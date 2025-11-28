<?php

function mqtt_connect_socket($host, $port = 1883, $timeout = 5) {
    $errNo = 0;
    $errStr = '';
    $socket = @fsockopen($host, $port, $errNo, $errStr, $timeout);
    if (!$socket) {
        return false;
    }
    stream_set_timeout($socket, $timeout);
    return $socket;
}

function mqtt_encode_length($len) {
    $enc = '';
    do {
        $digit = $len % 128;
        $len = (int)($len / 128);
        if ($len > 0) {
            $digit = $digit | 0x80;
        }
        $enc .= chr($digit);
    } while ($len > 0);
    return $enc;
}

function mqtt_write_packet($socket, $packet) {
    $written = fwrite($socket, $packet);
    fflush($socket);
    return ($written === strlen($packet));
}

function mqtt_build_connect_packet($clientId, $keepalive = 60, $username = null, $password = null, $clean = true) {
    $protocolName = "MQTT"; 
    $protocolLevel = chr(4);

    $flags = 0;
    if ($clean) $flags |= 0x02;
    $payload = '';

    $payload .= chr(strlen($clientId) >> 8) . chr(strlen($clientId) & 0xFF) . $clientId;

    if (!is_null($username)) $flags |= 0x80; 
    if (!is_null($password)) $flags |= 0x40;
    $variable = '';
    $variable .= chr(strlen($protocolName) >> 8) . chr(strlen($protocolName) & 0xFF) . $protocolName;
    $variable .= $protocolLevel;
    $variable .= chr($flags);
    $variable .= chr($keepalive >> 8) . chr($keepalive & 0xFF);

    if (!is_null($username)) {
        $variable .= chr(strlen($username) >> 8) . chr(strlen($username) & 0xFF) . $username;
    }
    if (!is_null($password)) {
        $variable .= chr(strlen($password) >> 8) . chr(strlen($password) & 0xFF) . $password;
    }

    $remaining = $variable . $payload;
    $fixedHeader = chr(0x10) . mqtt_encode_length(strlen($remaining));
    return $fixedHeader . $remaining;
}

function mqtt_publish($host, $port, $topic, $message, $clientId = null, $qos = 0, $retain = 0, $username = null, $password = null) {
    if (is_null($clientId)) $clientId = 'php_' . rand(1000, 9999);
    $sock = mqtt_connect_socket($host, $port);
    if (!$sock) return ['success' => false, 'message' => 'Unable to connect to broker'];

    $connect = mqtt_build_connect_packet($clientId, 60, $username, $password, true);
    if (!mqtt_write_packet($sock, $connect)) {
        fclose($sock);
        return ['success' => false, 'message' => 'Failed to send CONNECT'];
    }

    $connack = fread($sock, 4);
    if (!$connack || strlen($connack) < 4 || ord($connack[0]) >> 4 !== 2) {
        fclose($sock);
        return ['success' => false, 'message' => 'No CONNACK from broker'];
    }

    $fixed = 0x30; 
    if ($qos === 1) $fixed = 0x32;
    if ($qos === 2) $fixed = 0x34;

    $topicEnc = chr(strlen($topic) >> 8) . chr(strlen($topic) & 0xFF) . $topic;
    $payload = $message;
    $remaining = $topicEnc;
    if ($qos > 0) {
        $remaining .= chr(0) . chr(1);
    }
    $remaining .= $payload;

    $packet = chr($fixed) . mqtt_encode_length(strlen($remaining)) . $remaining;

    $ok = mqtt_write_packet($sock, $packet);

    fwrite($sock, chr(0xE0) . "\x00");
    fclose($sock);

    return ['success' => (bool)$ok];
}

function mqtt_subscribe($host, $port, $topic, $clientId = null, $timeout = 5, $username = null, $password = null) {
    if (is_null($clientId)) $clientId = 'php_sub_' . rand(1000, 9999);
    $sock = mqtt_connect_socket($host, $port, $timeout);
    if (!$sock) return ['success' => false, 'message' => 'Unable to connect to broker'];

    $connect = mqtt_build_connect_packet($clientId, 60, $username, $password, true);
    if (!mqtt_write_packet($sock, $connect)) {
        fclose($sock);
        return ['success' => false, 'message' => 'Failed to send CONNECT'];
    }

    $connack = fread($sock, 4);
    if (!$connack || strlen($connack) < 4 || ord($connack[0]) >> 4 !== 2) {
        fclose($sock);
        return ['success' => false, 'message' => 'No CONNACK from broker'];
    }

    
    $packetId = chr(0) . chr(1);
    $topicEnc = chr(strlen($topic) >> 8) . chr(strlen($topic) & 0xFF) . $topic . chr(0); 
    $remaining = $packetId . $topicEnc;
    $fixed = chr(0x82) . mqtt_encode_length(strlen($remaining));
    $packet = $fixed . $remaining;
    mqtt_write_packet($sock, $packet);

    $suback = fread($sock, 5);

    $end = time() + $timeout;
    $messages = [];
    stream_set_blocking($sock, false);
    while (time() < $end) {
        $data = '';
        $chunk = fread($sock, 4096);
        if ($chunk === false || $chunk === '') {
            usleep(100000);
            continue;
        }
        $data .= $chunk;
        while (strlen($data) > 2) {
            $byte1 = ord($data[0]);
            $msgType = $byte1 >> 4;
            if ($msgType !== 3) {
                $data = '';
                break;
            }
          
            $remLen = ord($data[1]);
            if (strlen($data) < 2 + $remLen) break;
            $tlen = (ord($data[2]) << 8) + ord($data[3]);
            $topicName = substr($data, 4, $tlen);
            $payload = substr($data, 4 + $tlen, $remLen - 2 - $tlen);
            $messages[] = ['topic' => $topicName, 'payload' => $payload];
            $data = substr($data, 2 + $remLen);
        }
    }

    fwrite($sock, chr(0xE0) . "\x00");
    fclose($sock);

    return ['success' => true, 'messages' => $messages];
}

?>