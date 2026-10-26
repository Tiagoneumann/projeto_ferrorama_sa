
<?php

session_start();

require 'conexao.php';

// Aceita somente requisições enviadas pelo formulário
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../pages/tela_usuarios/tela_usuarios.php');
    exit;
}

// Verifica se existe um usuário logado
if (empty($_SESSION['email_usuario'])) {
    http_response_code(403);
    exit('Você precisa estar logado para realizar esta ação.');
}

// Verifica se o usuário logado é administrador
$sql = "SELECT tipo_usuario
        FROM usuario
        WHERE email_usuario = ?
        LIMIT 1";

$stmt = $conexao->prepare($sql);
$stmt->bind_param("s", $_SESSION['email_usuario']);
$stmt->execute();

$resultado = $stmt->get_result();
$usuario_logado = $resultado->fetch_assoc();

$stmt->close();

if (!$usuario_logado || $usuario_logado['tipo_usuario'] !== 'admin') {
    http_response_code(403);
    exit('Apenas administradores podem cadastrar usuários.');
}

// Recebe os dados do formulário
$nome_usuario = trim($_POST['nome_usuario'] ?? '');
$email_usuario = trim($_POST['email_usuario'] ?? '');
$senha_usuario = $_POST['senha_usuario'] ?? '';
$tipo_usuario = $_POST['tipo_usuario'] ?? 'usuario';

// Valida os campos
if (
    strlen($nome_usuario) < 2 ||
    strlen($nome_usuario) > 100 ||
    $email_usuario === '' ||
    strlen($email_usuario) > 150 ||
    !filter_var($email_usuario, FILTER_VALIDATE_EMAIL) ||
    $senha_usuario === '' ||
    !in_array($tipo_usuario, ['usuario', 'admin'], true)
) {
    http_response_code(400);
    exit('Preencha os campos corretamente.');
}

// Criptografa a senha antes de salvar no banco
$senha_criptografada = password_hash(
    $senha_usuario,
    PASSWORD_DEFAULT
);

// Prepara o cadastro
$sql = "INSERT INTO usuario
        (nome_usuario, email_usuario, senha_usuario, tipo_usuario)
        VALUES (?, ?, ?, ?)";

$stmt = $conexao->prepare($sql);

$stmt->bind_param(
    "ssss",
    $nome_usuario,
    $email_usuario,
    $senha_criptografada,
    $tipo_usuario
);

// Executa o cadastro
if ($stmt->execute()) {

    $stmt->close();

    header('Location: ../../pages/tela_usuarios/tela_usuarios.php?cadastro=sucesso');
    exit;

} else {

    $codigo_erro = $stmt->errno;

    $stmt->close();

    if ($codigo_erro === 1062) {
        http_response_code(409);
        exit('Este e-mail já está cadastrado.');
    }

    http_response_code(500);
    exit('Não foi possível cadastrar o usuário.');
}
