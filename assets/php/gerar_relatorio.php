<?php

session_start();

require 'conexao.php';

try {

    $trens = $conexao->query("
        SELECT t.id_trem, 
        t.prefixo_trem, 
        t.modelo_trem, 
        t.ano_trem, 
        t.status_trem,
        l.nome_linha
        FROM trem t
        LEFT JOIN linha l ON t.id_linha = l.id_linha
    ")->fetch_all(MYSQLI_ASSOC);

    $linhas = $conexao->query("
        SELECT * FROM linha
    ")->fetch_all(MYSQLI_ASSOC);

    $rotas = $conexao->query("
        SELECT r.*, t.prefixo_trem, l.nome_linha
        FROM rota r
        INNER JOIN trem t ON r.id_trem = t.id_trem
        INNER JOIN linha l ON r.id_linha = l.id_linha
    ")->fetch_all(MYSQLI_ASSOC);

    $sensores = $conexao->query("
        SELECT s.*, t.prefixo_trem
        FROM sensor s
        INNER JOIN trem t ON s.id_trem = t.id_trem
    ")->fetch_all(MYSQLI_ASSOC);

    $leituras = $conexao->query("
        SELECT le.*, s.codigo_sensor, s.tipo_sensor,
               s.unidade_sensor
        FROM leitura le
        INNER JOIN sensor s ON le.id_sensor = s.id_sensor
    ")->fetch_all(MYSQLI_ASSOC);

    $dados = [
        'trens' => $trens,
        'linhas' => $linhas,
        'rotas' => $rotas,
        'sensores' => $sensores,
        'leituras' => $leituras
    ];

    $conteudo = json_encode(
        $dados,
        JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
    );

    if ($conteudo === false) {
        throw new Exception("Erro ao converter os dados do relatório.");
    }

    $titulo = "Relatório geral do sistema";

    $sql = "INSERT INTO relatorio
            (titulo_relatorio, conteudo_relatorio, id_usuario)
            VALUES (?, ?, ?)";

    $stmt = $conexao->prepare($sql);

    $idUsuario = $_SESSION['id_usuario'];

    $stmt->bind_param("ssi", $titulo, $conteudo, $idUsuario);

    $stmt->execute();

    $idRelatorio = $conexao->insert_id;

    $stmt->close();

    header("Location: ../../pages/tela_relatorios/tela_relatorios.php");
    exit;

} catch (Exception $e) {

    die("Erro ao gerar relatório: " . $e->getMessage());

}
?>
