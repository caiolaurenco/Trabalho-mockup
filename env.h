// env.h - Configurações para os 3 Arduinos

// ===== CONFIGURAÇÕES WIFI =====
#define WIFI_SSID "SEU_WIFI_AQUI"
#define WIFI_PASS "SUA_SENHA_AQUI"

// ===== CONFIGURAÇÕES MQTT (HiveMQ) =====
#define BROKER_URL "broker.hivemq.com"
#define BROKER_PORT 8883
#define BROKER_USER ""  // HiveMQ público não precisa de usuário
#define BROKER_PASS ""  // HiveMQ público não precisa de senha

// ===== TÓPICOS SENSOR 1 (S1) =====
#define TOPIC_ILUM "s1/iluminacao"
// Tópicos adicionais já definidos no código principal:
// s1/temperatura
// s1/distancia
// s1/umidade

// ===== TÓPICOS SENSOR 2 (S2) =====
// s2/sensor1
// s2/sensor2
// s2/status

// ===== TÓPICOS SENSOR 3 (S3) =====
#define TOPIC_DISTANCIA "s3/distancia"
#define TOPIC_PRESENCA1 "s3/presenca1"
#define TOPIC_PRESENCA2 "s3/presenca2"
#define TOPIC_PRESENCA3 "s3/presenca3"
// Tópicos adicionais:
// s3/servo1
// s3/servo2
// s3/status