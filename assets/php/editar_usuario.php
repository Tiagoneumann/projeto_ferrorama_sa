<?php

session_start();

require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../pages/tela_usuarios/tela_usuarios.php');
    exit;
}

$id_usuario = filter_input(INPUT_POST, 'id_usuario', FILTER_VALIDATE_INT);

$nome = trim($_POST['nome_usuario'] ?? '');
$email = trim($_POST['email_usuario'] ?? '');
$senha = $_POST['senha_usuario'] ?? '';
$tipo = $_POST['tipo_usuario'] ?? '';

if (!$id_usuario || $id_usuario <= 0 || $nome === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || !in_array($tipo, ['usuario', 'admin'], true)) {
    header('Location: ../../pages/tela_usuarios/tela_usuarios.php?erro=dados_invalidos');
    exit;
}

$sql = "SELECT id_usuario FROM usuario WHERE id_usuario = ?";

$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();

$existe = $stmt->get_result()->num_rows > 0;
$stmt->close();

if (!$existe) {
    header('Location: ../../pages/tela_usuarios/tela_usuarios.php?erro=nao_encontrado');
    exit;
}

if ($senha !== '') {

    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    $sql = "UPDATE usuario SET nome_usuario = ?, email_usuario = ?, senha_usuario = ?, tipo_usuario = ? WHERE id_usuario = ?";

    $stmt = $conexao->prepare($sql);

    $stmt->bind_param("ssssi", $nome, $email, $senha_hash, $tipo, $id_usuario);

} else {

    $sql = "UPDATE usuario SET nome_usuario = ?, email_usuario = ?, tipo_usuario = ? WHERE id_usuario = ?";

    $stmt = $conexao->prepare($sql);

    $stmt->bind_param("sssi", $nome, $email, $tipo, $id_usuario);
}

if ($stmt->execute()) {

    header('Location: ../../pages/tela_usuarios/tela_usuarios.php?sucesso=editado');

} else {

    error_log('Erro ao atualizar usuário: ' . $stmt->error);

    header('Location: ../../pages/tela_usuarios/tela_usuarios.php?erro=atualizacao');

}

$stmt->close();
$conexao->close();

exit;
