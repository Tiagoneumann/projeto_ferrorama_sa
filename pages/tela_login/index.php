<?php

session_start();

require '../../assets/php/conexao.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $erro = "";

    $email = trim($_POST['email_usuario']);
    $senha = $_POST['senha_usuario'];

    if(empty($email) || empty($senha)){

        $erro = "Preencha todos os campos!";

    } else{

        $sql = "SELECT * FROM usuario WHERE email_usuario = ? LIMIT 1";

        $stmt = $conexao->prepare($sql);

        $stmt->bind_param("s", $email);
        $stmt->execute();

        //Transforma a linha do banco onde contem as informações em uma array
        $resultado = $stmt->get_result();
        $usuario = $resultado->fetch_assoc();

        if(!$usuario) {

            $erro = "Usuário ou senha incorretos!";

        } else {

            if (password_verify($senha, $usuario['senha_usuario'])){

                $_SESSION['id_usuario'] = $usuario['id'];
                $_SESSION['email_usuario'] = $usuario['email_usuario'];
                $_SESSION['nome_usuario'] = $usuario['nome_usuario'];

                header("Location: ../tela_dashboard/index.php");
                exit;
                
            } else {

                $erro = "Usuário ou senha incorretos!";

            }
        }
        $stmt->close();
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

    <title>Track Flow || Login</title>
</head>

<body>

    <header>
        <nav class="navbar">

            <div class="navbar_bloco">

                <button style="display:none;" id="btn_menu">
                    <i class="fa-solid fa-bars"></i>
                </button>

                <div class="vazio"></div>

                <h3>Login</h3>

                <img src="../../assets/img/logo_sem_fundo.png" alt="Logo">

            </div>
        </nav>
    </header>

    <main>

        <div class="bloco_login">

            <form method="POST">

                <input type="text" name="email_usuario" placeholder="Email">

                <input type="password" name="senha_usuario" placeholder="Senha">

                <div class="outras_opcoes">

                    <a href="#">
                        Esqueci minha senha
                    </a>

                    <a href="../tela_cadastro/index.php">
                        Cadastrar-se
                    </a>

                </div>

                <?php if(!empty($erro)): ?>

                    <P class="erro">
                        <?= htmlspecialchars($erro)?>
                    </P>

                <?php endif; ?>

                <input type="submit" value="Entrar">

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