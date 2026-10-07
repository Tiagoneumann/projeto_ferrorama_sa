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

    <title>Track Flow || Dashboard</title>
</head>

<body>

    <header>

        <div id="usuario"></div>

        <nav class="navbar">
            <div class="navbar_bloco">
                <button class="btn_navbar_menu" id="btn_menu"><i class="fa-solid fa-bars"></i></button>

                <div class="logo">
                    <img src="../../assets/img/logo_sem_fundo_branco.png" alt="logo">
                    <h6>Dashboard</h6>
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

            <div class="card" style="margin-bottom: 15px;">
                <div class="legend">
                    <span><span class="box" style="background:#E5533D;"></span>Parado</span>
                    <span><span class="box" style="background:#E8B931;"></span>Manutenção</span>
                    <span><span class="box" style="background:#3DB7E4;"></span>Ativos</span>
                </div>

                <div class="chart-wrapper">
                    <canvas id="statusChart" role="img"
                        aria-label="Gráfico de barras horizontal: Parado, Manutenção, Ativos"></canvas>
                </div>

                <div class="refresh-info" id="refreshInfo">Última atualização: --</div>
            </div>

            <div class="bloco bloco_alertas">
                <div class="card_sec alertas">
                    <h5>⚠️ Alertas ⚠️</h5>
                    <div class="informacoes">
                        <ul>
                            <li>Teste</li>
                            <li>Teste</li>
                            <li>Teste</li>
                        </ul>
                    </div>
                    <button class="btn_mais" id="btn_ver_alertas">Ver mais</button>
                </div>
                <div class="card_sec ocorrencias">
                    <h5>Últimas Ocorrências</h5>
                    <div class="informacoes">
                        <ul>
                            <li>Teste</li>
                            <li>Teste</li>
                            <li>Teste</li>
                        </ul>
                    </div>
                    <button class="btn_mais" id="btn_ver_ocorrencias">Ver mais</button>
                </div>
            </div>

            <div class="bloco bloco_lista">
                <div class="card_sec lista_trens">
                    <h5>Lista rápida de trens</h5>
                    <div class="informacoes">
                        <ul>
                            <li>TR-102 80km/h ✅</li>
                            <li>TR-221 0km/h ❌</li>
                            <li>TR-095 45km/h ⚠️</li>
                            <li>TR-089 85km/h ✅</li>
                        </ul>
                    </div>
                    <button class="btn_mais">Ver mais</button>
                </div>
            </div>
        </div>

    </main>
    <footer>
        <small class="marca_dagua">Track Flow© 2026</small>
    </footer>
</body>

</html>