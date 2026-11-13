
<?php

require_once 'conexao.php';

try {

    // Busca as leituras, sensores e trens
    $sql = "
        SELECT
            l.id_sensor,
            l.valor_sensor,
            s.codigo_sensor,
            s.tipo_sensor,
            s.unidade_sensor,
            s.maximo_sensor,
            t.prefixo_trem,
            t.modelo_trem
        FROM leitura l
        INNER JOIN sensor s ON l.id_sensor = s.id_sensor
        INNER JOIN trem t ON s.id_trem = t.id_trem
    ";

    $resultado = $conexao->query($sql);

    if (!$resultado) {
        throw new Exception($conexao->error);
    }

    // Percorre todas as leituras
    while ($leitura = $resultado->fetch_assoc()) {

        $idSensor = $leitura['id_sensor'];
        $valor = (float) $leitura['valor_sensor'];
        $maximo = (float) $leitura['maximo_sensor'];

        if ($maximo <= 0) {
            continue;
        }

        // Calcula a porcentagem do limite
        $porcentagem = ($valor / $maximo) * 100;

        // Define a gravidade do alerta
        if ($porcentagem >= 80 && $porcentagem < 95) {
            $tipoAlerta = 'informativo';

        } elseif ($porcentagem >= 95 && $porcentagem <= 110) {
            $tipoAlerta = 'aviso';

        } elseif ($porcentagem > 110) {
            $tipoAlerta = 'critico';

        } else {
            $tipoAlerta = null;
        }

        // Se estiver normal, remove o alerta existente
        if ($tipoAlerta === null) {

            $sqlDelete = "
                DELETE FROM alerta
                WHERE id_sensor = ?
            ";

            $stmtDelete = $conexao->prepare($sqlDelete);
            $stmtDelete->bind_param("i", $idSensor);
            $stmtDelete->execute();
            $stmtDelete->close();

            continue;
        }

        // Informações do sensor e trem
        $codigoSensor = $leitura['codigo_sensor'];
        $tipoSensor = $leitura['tipo_sensor'];
        $prefixo = $leitura['prefixo_trem'];
        $modelo = $leitura['modelo_trem'];
        $unidade = $leitura['unidade_sensor'];

        // Monta o título e a descrição
        $titulo = $prefixo . " " . $tipoSensor;

        $descricao = "O sensor \"{$codigoSensor}\" de tipo {$tipoSensor} "
                   . "vinculado ao trem \"{$prefixo} / {$modelo}\" "
                   . "registrou um valor de {$valor}{$unidade}.";

        // Cria ou atualiza o alerta
        $sqlAlerta = "
            INSERT INTO alerta (
                titulo_alerta,
                descricao_alerta,
                tipo_alerta,
                data_alerta,
                id_sensor
            ) VALUES (?, ?, ?, NOW(), ?)

            ON DUPLICATE KEY UPDATE
                titulo_alerta = VALUES(titulo_alerta),
                descricao_alerta = VALUES(descricao_alerta),
                tipo_alerta = VALUES(tipo_alerta),
                data_alerta = NOW()
        ";

        $stmtAlerta = $conexao->prepare($sqlAlerta);

        $stmtAlerta->bind_param(
            "sssi",
            $titulo,
            $descricao,
            $tipoAlerta,
            $idSensor
        );

        $stmtAlerta->execute();
        $stmtAlerta->close();
    }

} catch (Exception $e) {

    echo "Erro ao gerar alertas: " . $e->getMessage();

}

?>
