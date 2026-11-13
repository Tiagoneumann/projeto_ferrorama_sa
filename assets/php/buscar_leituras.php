<?php

require '../../assets/php/conexao.php';

header('Content-Type: application/json; charset=utf-8');

$sql = "
    SELECT
        leitura.id_leitura,
        leitura.valor_sensor,
        leitura.registro_sensor,
        sensor.codigo_sensor,
        sensor.unidade_sensor,
        trem.prefixo_trem
    FROM leitura
    INNER JOIN sensor
        ON leitura.id_sensor = sensor.id_sensor
    INNER JOIN trem
        ON sensor.id_trem = trem.id_trem
    ORDER BY leitura.registro_sensor DESC
";

$resultado = $conexao->query($sql);

$leituras = [];

if ($resultado) {
    while ($linha = $resultado->fetch_assoc()) {
        $leituras[] = $linha;
    }
}

echo json_encode($leituras);

?>
