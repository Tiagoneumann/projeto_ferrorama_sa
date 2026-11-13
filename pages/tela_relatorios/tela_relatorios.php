<?php

require '../../assets/php/conexao.php';
require_once '../../assets/php/autorizacao.php';

$sql = 'SELECT  relatorio.*, usuario.nome_usuario FROM relatorio INNER JOIN usuario ON relatorio.id_usuario = usuario.id_usuario ORDER BY relatorio.id_relatorio DESC';
$resultado = $conexao->query($sql);

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

        <div id="usuario"></div>
        <div id="relatorio"></div>

        <nav class="navbar">
            <div class="navbar_bloco">
                <button class="btn_navbar_menu" id="btn_menu"><i class="fa-solid fa-bars"></i></button>

                <div class="logo">
                    <img src="../../assets/img/logo_sem_fundo_branco.png" alt="logo">
                    <h6>Relatórios</h6>
                </div>

                <button class="perfil" id="perfil"><img src="https://i.pinimg.com/736x/23/40/8e/23408e565fc3f43454636fec27572d1f.jpg" alt="perfil"></button>
            </div>

            <div class="menu_navbar">
                <ul>
                    <li><a href="../tela_dashboard/tela_dashboard.php">Dashboard</a></li>
                    <li><a href="../tela_relatorios/tela_relatorios.php">Relatórios</a></li>
                    <li><a href="../tela_sensores/tela_sensores.php">Sensores</a></li>
                    <li><a href="../tela_leituras/tela_leituras.php">Leituras</a></li>
                    <li><a href="../tela_rotas/tela_rotas.php">Rotas</a></li>
                    <li><a href="../tela_trens/tela_trens.php">Trens</a></li>
                    <li><a href="../tela_usuarios/tela_usuarios.php">Usuários</a></li>
                </ul>
            </div>
        </nav>
    </header>
    <main>
        
        <div class="container">
            <div class="topo_relatorio">
                <form action="../../assets/php/gerar_relatorio.php" method="POST">
                    <button type="submit" id="gerar_relatorio" class="botao"><i class="fa-solid fa-plus"></i> Gerar relatório</button>
                </form>
            </div>

            <div class="relatorios">

            <?php if($resultado->num_rows > 0): ?>

            <?php while($relatorios = $resultado->fetch_assoc()): ?>

                <div class="item_relatorio estilo_primario">
                    <div class="informacoes_relatorio">
                        <p><strong><?= htmlspecialchars($relatorios['titulo_relatorio']) ?></strong></p>

                        <div class="dados_relatorio">
                            <small>Por: <?= htmlspecialchars($relatorios['nome_usuario']) ?></small>
                            <small>Data: <?= htmlspecialchars($relatorios['data_geracao']) ?></small>
                        </div>
                    </div>

                    <button id="visualizar_relatorio" class="btn_visualizar" data-id="<?= $relatorios['id_relatorio'] ?>"><i class="fa-regular fa-eye"></i></button>
                </div>

            <?php endwhile; ?>

            <?php else: ?>

                <div class="mensagem">
                    <small>Nenhum relatório encontrado!</small>
                </div>

            <?php endif;?>

            </div>
        </div>

    </main>
    <footer>
        <small class="marca_dagua">Track Flow© 2026</small>
    </footer>

</body>
</html>