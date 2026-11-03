<?php

session_start();

require 'conexao.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $id_sensor = filter_input(INPUT_POST, 'id_sensor', FILTER_VALIDATE_INT);

    $sql = "DELETE FROM sensor WHERE id_sensor = ?";

    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $id_sensor);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        header('Location: ../../pages/tela_sensores/tela_sensores.php?sucesso=excluido');
    } else {
        header('Location: ../../pages/tela_sensores/tela_sensores.php?erro=nao_encontrado');
    }

    $stmt->close();
    $conexao->close();
    exit;

}

?>