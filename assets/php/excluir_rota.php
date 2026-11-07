
<?php

session_start();

require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id_rota = filter_input(INPUT_POST, 'id_rota', FILTER_VALIDATE_INT);

    if (!$id_rota) {
        header('Location: ../../pages/tela_rotas/tela_rotas.php?erro=id_invalido');
        exit;
    }

    $sql = "DELETE FROM rota WHERE id_rota = ?";

    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $id_rota);
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
