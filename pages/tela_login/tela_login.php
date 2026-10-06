<?php

require '../../assets/php/login.php';

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

                <img src="../../assets/img/logo_sem_fundo_branco.png" alt="Logo">

            </div>
        </nav>
    </header>

    <main class="centralizar">

        <div class="estilo_primario bloco_formulario">

            <form method="POST">

                <input class="input_padrao estilo_secundario" type="text" name="email_usuario" placeholder="Email">

                <input class="input_padrao estilo_secundario" type="password" name="senha_usuario" placeholder="Senha">

                <div class="outras_opcoes">

                    <a href="#">
                        Esqueci minha senha
                    </a>

                    <a href="../tela_cadastro/tela_cadastro.php">
                        Cadastrar-se
                    </a>

                </div>

                <?php if(!empty($erro)): ?>

                    <P class="erro">
                        <?= htmlspecialchars($erro)?>
                    </P>

                <?php endif; ?>

                <input class="botao" type="submit" value="Entrar">

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