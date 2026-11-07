<?php

session_start();

require 'conexao.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $id_linha = filter_input(INPUT_POST, 'id_linha', FILTER_VALIDATE_INT);

    $sql = "DELETE FROM linha WHERE id_linha = ?";

    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $id_linha);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        header('Location: ../../pages/tela_rotas/tela_rotas.php?sucesso=excluido');
    } else {
        header('Location: ../../pages/tela_rotas/tela_rotas.php?erro=nao_encontrado');
    }

    $stmt->close();
    $conexao->close();
    exit;

}

?>