<?php

require_once '../../assets/php/autorizacao.php';

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

    <title>Track Flow || Sensores</title>
</head>

<body>
    <header>

        <div id="usuario"></div>

        <nav class="navbar">
            <div class="navbar_bloco">
                <button class="btn_navbar_menu" id="btn_menu"><i class="fa-solid fa-bars"></i></button>

                <div class="logo">
                    <img src="../../assets/img/logo_sem_fundo_branco.png" alt="logo">
                    <h6>Trens</h6>
                </div>

                <button class="perfil" id="perfil"><img src="https://i.pinimg.com/736x/23/40/8e/23408e565fc3f43454636fec27572d1f.jpg" alt="perfil"></button>
            </div>

            <div class="menu_navbar">
                <ul>
                    <li><a href="../tela_dashboard/tela_dashboard.php">Dashboard</a></li>
                    <li><a href="../tela_relatorios/tela_relatorios.php">Relatórios</a></li>
                    <li><a href="../tela_sensores/tela_sensores.php">Sensores</a></li>
                    <li><a href="../tela_trens/tela_trens.php">Trens</a></li>
                    <li><a href="../tela_usuarios/tela_usuarios.php">Usuários</a></li>
                </ul>
            </div>
        </nav>

    </header>
    <main>

        <div class="container">
            
            <button class="botao">Adicionar Trem</button>

            
            <div class="card">
                <img src="https://mobilidade.estadao.com.br/wp-content/uploads/2024/03/Trem.jpeg" alt="trem">

                <div class="dados">
                    <ul>
                        <li>ID: <span></span></li>
                        <li>Horário: <span></span></li>
                        <li>Modelo: <span></span></li>
                    </ul>
                    <ul>
                        <li>Linha: <span></span></li>
                        <li>Capacidade: <span></span></li>
                        <li>Operador: <span></span></li>
                    </ul>
                </div>
            </div>

    </main>
    <footer>
        <div class="marca_dagua">
            <small>Track Flow© 2026</small>
        </div>
    </footer>
</body>

</html>