<?php

session_start();

require '../../assets/php/conexao.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $nome = $_POST['nome_usuario'];
    $email = $_POST['email_usuario'];
    $senha = $_POST['senha_usuario'];
    $confirmar_senha = $_POST['confirmar_senha'];

    if ($senha !== $confirmar_senha){
        echo "As senhas não são iguais.";
        exit;
    }

    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuario 
    (nome_usuario, email_usuario, senha_usuario) 
    VALUES (?, ?, ?)";

    $stmt = $conexao->prepare($sql);

    $stmt->bind_param("sss", $nome, $email, $senha_hash);

    if ($stmt->execute()) {

        header('Location: ../tela_login/index.php');
        exit;

    } else {
        echo "Erro ao realizar o cadastro.";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link rel="stylesheet" href="../../assets/css/global.css">
    <link rel="stylesheet" href="style.css">

    <script src="main.js" defer></script>
    <script src="../../assets/js/global.js" defer></script>

    <title>Track Flow | Cadastro</title>
</head>
<body>

    <header>
        <nav class="navbar">
            <div class="navbar_bloco">

                <button style="display:none;" id="btn_menu">
                    <i class="fa-solid fa-bars"></i>
                </button>

                <div class="vazio"></div>

                <h3>Cadastro</h3>

                <img src="../../assets/img/logo_sem_fundo.png" alt="Logo">

            </div>
        </nav>
    </header>

    <main>

        <div class="bloco_cadastro">
            <form method="POST">

                <input type="text" name="nome_usuario" placeholder="Nome">

                <input type="email" name="email_usuario" placeholder="Email">

                <input type="password" name="senha_usuario" placeholder="Senha">

                <input type="password" name="confirmar_senha" placeholder="Confirmar senha">

                <div class="outras_opcoes">
                    <a href="../tela_login/index.php">
                        Já tem uma conta?
                    </a>
                </div>

                <input type="submit" value="Cadastre-se">

            </form>
        </div>

    </main>

    <footer>
        <div class="marca_dagua">
            <small>Track Flow © 2026</small>
        </div>
    </footer>

</body>
</html>