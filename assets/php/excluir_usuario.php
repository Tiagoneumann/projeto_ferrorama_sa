<?php

session_start();

require 'conexao.php';

$id_usuario = filter_input(INPUT_POST, 'id_usuario', FILTER_VALIDATE_INT);

$sql = "DELETE FROM usuario WHERE id_usuario = ?";

$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    header('Location: ../../pages/tela_usuarios/tela_usuarios.php?sucesso=excluido');
} else {
    header('Location: ../../pages/tela_usuarios/tela_usuarios.php?erro=nao_encontrado');
}

$stmt->close();
$conexao->close();
exit;

?>