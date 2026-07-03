<?php
// ====================================================================
// CAMADA DE APLICAÇÃO (TCP/IP) - PROTOCOLO HTTP & ESTRUTURAÇÃO DE DADOS
// ====================================================================

// 1. Avisamos ao navegador (cliente) que o servidor não está enviando um HTML,
// mas sim um arquivo de dados puro estruturado em formato UNIVERSAL JSON.
header('Content-Type: application/json');

// 2. Função lógica para gerar números decimais aleatórios.
// Ela simula a oscilação física e material que um sensor real sofreria na parede da câmara.
function gerarTemperatura($min, $max) {
    return round($min + mt_rand() / mt_getrandmax() * ($max - $min), 1);
}

// 3. PROCESSAMENTO INTERNO DE DADOS (O Back-end trabalhando na CPU do Servidor)
// Geramos variações térmicas que, de vez em quando, vão quebrar o limite ideal.
// Isso é vital para testarmos se o nosso painel visual vai saber disparar os alertas.
$tempUva   = gerarTemperatura(0.5, 3.5);  // Ideal da Uva: até 2.5ºC. Passou disso, estraga.
$tempManga = gerarTemperatura(9.0, 13.5); // Ideal da Manga: até 12.5ºC. Passou disso, amadurece antes da hora.
$tempGeral = gerarTemperatura(3.0, 7.0);  // Ideal das Docas de Triagem: até 6.0ºC.

// 4. MONTAGEM DO PAYLOAD (A carga de dados que vai viajar pela rede)
// Organizamos tudo em uma estrutura de array associativo (chave e valor).
$dadosCamaras = [
    "cidade" => "Petrolina - PE",
    "polo_economico" => "Vale do São Francisco",
    "status_sistema" => "Monitoramento Ativo",
    "camaras" => [
        [
            "id" => "CAM-01",
            "produto" => "Uva de Exportação 🍇",
            "temperatura" => $tempUva,
            "umidade" => rand(85, 92), // Umidade relativa do ar em %
            "limite_max" => 2.5,
            "alerta" => ($tempUva > 2.5) ? true : false // O PHP toma a decisão lógica aqui
        ],
        [
            "id" => "CAM-02",
            "produto" => "Manga Tommy 🥭",
            "temperatura" => $tempManga,
            "umidade" => rand(85, 90),
            "limite_max" => 12.5,
            "alerta" => ($tempManga > 12.5) ? true : false
        ],
        [
            "id" => "CAM-03",
            "produto" => "Pátio de Triagem & Docas 🚛",
            "temperatura" => $tempGeral,
            "umidade" => rand(70, 80),
            "limite_max" => 6.0,
            "alerta" => ($tempGeral > 6.0) ? true : false
        ]
    ]
];

// 5. TRANSMISSÃO DE SAÍDA (O ato final do cozinheiro)
// O PHP pega a estrutura da memória, transforma no texto purificado JSON e dá o "echo".
// Esse texto é o que o servidor Web (Apache) vai envelopar e despachar pelos cabos da rede.
echo json_encode($dadosCamaras, JSON_UNESCAPED_UNICODE);