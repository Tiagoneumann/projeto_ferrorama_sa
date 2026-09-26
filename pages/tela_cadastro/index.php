<?php

session_start();

//Puxa a conexao feita com o banco de dados na pasta php
require '../../assets/php/conexao.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $erro = "";

    //Pega os daods digitados nos campos e transforma eles em variáveis
    $nome = trim($_POST['nome_usuario']);
    $email = trim($_POST['email_usuario']);
    $senha = $_POST['senha_usuario'];
    $confirmar_senha = $_POST['confirmar_senha'];

    //Verifica se todos os campos foram preenchidos
    if (empty($nome) || empty($email) || empty($senha) || empty($confirmar_senha)){

        $erro = "Preencha todos os campos!";

    //Verifica se a senha foi digitada certa
    } elseif ($senha !== $confirmar_senha){

        $erro = "As senhas não são iguais.";

    } else {

        //Verifica se o email não esta repetido
        $sql_verifica = "SELECT id_usuario FROM usuario WHERE email_usuario = ?";
        $stmt_verifica = $conexao->prepare($sql_verifica);

        $stmt_verifica->bind_param("s", $email);
        $stmt_verifica->execute();

        $resultado = $stmt_verifica->get_result();

        if($resultado->num_rows > 0) {

            $erro = "Este e-mail já existe.";

        } else {
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

                if($stmt->errno === 1062){

                $erro = "Este e-mail já esta cadastrado";

                } else {

                $erro = "Erro ao realizar o cadastro.";

                }
            }
        }
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
                
                <?php if (!empty($erro)): ?>
                    <p class="erro">
                        <?= htmlspecialchars($erro) ?>
                    </p>
                <?php endif; ?>

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