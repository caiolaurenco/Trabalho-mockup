<?php
header('Content-Type: application/json; charset=utf-8');

include __DIR__ . '/mqtt_helper.php';

$raw = file_get_contents('php://input');
$input = json_decode($raw, true);
$params = $_REQUEST;
if ($input && is_array($input)) $params = array_merge($params, $input);

$topic = isset($params['topic']) ? trim($params['topic']) : '';
$host = isset($params['host']) && strlen(trim($params['host'])) ? trim($params['host']) : 'test.mosquitto.org';
$port = isset($params['port']) ? (int)$params['port'] : 1883;
$timeout = isset($params['timeout']) ? (int)$params['timeout'] : 5;

if ($topic === '') {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Parâmetro "topic" é obrigatório.']);
    exit;
}

if ($timeout < 1) $timeout = 1;
if ($timeout > 30) $timeout = 30;

$res = mqtt_subscribe($host, $port, $topic, null, $timeout);

if (!is_array($res) || !isset($res['success']) || $res['success'] !== true) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Erro ao assinar o tópico.', 'detail' => $res]);
    exit;
}

$messages = [];
foreach ($res['messages'] as $m) {
    $messages[] = [
        'topic' => $m['topic'],
        'payload' => $m['payload']
    ];
}

echo json_encode(['success' => true, 'messages' => $messages]);
exit;

?>