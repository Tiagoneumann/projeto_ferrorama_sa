<?php

require_once '../../assets/php/autorizacao.php'

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

    <title>Track Flow || Relatórios</title>
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="navbar_bloco">
                <button class="btn_navbar_menu" id="btn_menu"><i class="fa-solid fa-bars"></i></button>

                <div class="logo">
                    <img src="../../assets/img/logo_sem_fundo_branco.png" alt="logo">
                    <h6>Relatórios</h6>
                </div>

                <a href="../tela_usuarios/index.php" class="perfil"><img
                        src="https://i.pinimg.com/736x/23/40/8e/23408e565fc3f43454636fec27572d1f.jpg" alt=""></a>
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
            <h6 class="titulo">Relatório</h6>

            <div class="bloco">
                <label> 
                    Período:
                    <input type="text">
                </label>
            </div>

            <div class="bloco">
                <label> 
                    Tipo de relatório:
                    <input type="text">
                </label>
            </div>

            <div class="bloco">
                <label> 
                    Trem (opcional):
                    <input type="text">
                </label>
            </div>

            <div class="bloco">
                <label> 
                    Sensor (opcional):
                    <input type="text">
                </label>
            </div>

            <div class="bloco">
                <label> 
                    Status atual:
                    <input type="text">
                </label>
            </div>

            <div class="bloco">
                <label> 
                    Velocidade média:
                    <input type="text">
                </label>
            </div>

            <div class="bloco">
                <label> 
                    Ocorrências/descrição:
                    <input type="text">
                </label>
            </div>

            <button class="btn_relatorio">Enviar Relatório</button>
        </div>
    </main>
    <footer>
        <div class="marca_dagua">
            <small>Track Flow© 2026</small>
        </div>
    </footer>

</body>
</html>