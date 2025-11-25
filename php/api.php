<?php
class email{
    public function verificar_email($email) {
              $ch = curl_init();
              curl_setopt($ch, CURLOPT_URL, 'https://emailreputation.abstractapi.com/v1/?api_key=b71db26d57fe49709fe9c06c9318dc60&email=' . urlencode($email));
              curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
              curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
              $data = curl_exec($ch);
              curl_close($ch);
              $dados = json_decode($data, true);
              if (isset($dados["email_deliverability"]["status_detail"]) && $dados["email_deliverability"]["status_detail"] === "valid_email") {
                  return true; 
              } else {
                  return false;
              }   
    }
}
?>