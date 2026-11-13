
<?php

require_once 'conexao.php';

// Gera valores de acordo com o tipo de sensor
function gerarValor($tipo) {

    $tipo = strtolower($tipo);

    switch ($tipo) {

        case 'temperatura':
            return rand(200, 900) / 10;

        case 'umidade':
            return rand(300, 900) / 10;

        case 'vibração':
        case 'vibracao':
            return rand(0, 150) / 10;

        case 'velocidade':
            return rand(0, 120);

        case 'pressão':
        case 'pressao':
            return rand(10, 100) / 10;

        default:
            return rand(100, 2000) / 10;
    }
}

// Busca todos os sensores cadastrados
$sql = "SELECT id_sensor, tipo_sensor FROM sensor";

$resultado = $conexao->query($sql);

if (!$resultado) {
    http_response_code(500);
    exit("Erro ao buscar sensores.");
}

// Prepara os comandos SQL
$verificar = $conexao->prepare(
    "SELECT id_leitura FROM leitura WHERE id_sensor = ? LIMIT 1"
);

$atualizar = $conexao->prepare(
    "UPDATE leitura
     SET valor_sensor = ?, registro_sensor = NOW()
     WHERE id_sensor = ?"
);

$inserir = $conexao->prepare(
    "INSERT INTO leitura (id_sensor, valor_sensor, registro_sensor)
     VALUES (?, ?, NOW())"
);

while ($sensor = $resultado->fetch_assoc()) {

    $idSensor = $sensor['id_sensor'];
    $tipo = $sensor['tipo_sensor'];

    $valor = gerarValor($tipo);

    // Verifica se já existe uma leitura
    $verificar->bind_param("i", $idSensor);
    $verificar->execute();

    $leitura = $verificar->get_result()->fetch_assoc();

    if ($leitura) {

        // Atualiza o registro existente
        $atualizar->bind_param("di", $valor, $idSensor);
        $atualizar->execute();

    } else {

        // Cria a primeira leitura
        $inserir->bind_param("id", $idSensor, $valor);
        $inserir->execute();

    }
}

$verificar->close();
$atualizar->close();
$inserir->close();

?>
