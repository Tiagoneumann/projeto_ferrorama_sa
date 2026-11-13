<?php

session_start();

require '../../assets/php/conexao.php';

$sql_sensores = "SELECT COUNT(*) AS total_sensores FROM sensor";
$resultado_sensores = $conexao->query($sql_sensores);

$sql_leituras = "SELECT COUNT(*) AS total_leituras FROM leitura";
$resultado_leituras = $conexao->query($sql_leituras);

$dados_leituras = $resultado_leituras->fetch_assoc();
$dados_sensores = $resultado_sensores->fetch_assoc();

$totalLeituras = $dados_leituras['total_leituras'];
$totalSensores = $dados_sensores['total_sensores'];

$sql_dados = "
    SELECT
        leitura.id_leitura,
        leitura.valor_sensor,
        leitura.registro_sensor,
        sensor.codigo_sensor,
        sensor.tipo_sensor,
        sensor.unidade_sensor,
        trem.prefixo_trem
    FROM leitura
    INNER JOIN sensor
        ON leitura.id_sensor = sensor.id_sensor
    INNER JOIN trem
        ON sensor.id_trem = trem.id_trem
    ORDER BY leitura.registro_sensor DESC
";

$resultado_dados = $conexao->query($sql_dados);

$leituras = [];

if ($resultado_dados) {
    while ($linha = $resultado_dados->fetch_assoc()) {
        $leituras[] = $linha;
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

    <title>Track Flow || Leituras</title>
</head>

<body>

    <header>

        <div id="usuario"></div>

        <nav class="navbar">
            <div class="navbar_bloco">
                <button class="btn_navbar_menu" id="btn_menu"><i class="fa-solid fa-bars"></i></button>

                <div class="logo">
                    <img src="../../assets/img/logo_sem_fundo_branco.png" alt="logo">
                    <h6>Leituras</h6>
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
            <div class="dados_leituras estilo_primario">
                <div class="total_leituras estilo_secundario">
                    <p><strong>Total de leituras</strong></p>
                    <small>Leituras cadastradas no sistema</small>

                    <h1><?= htmlspecialchars($totalLeituras) ?></h1>
                </div>

                <div class="total_sensores estilo_secundario">
                    <p><strong>Total de sensores</strong></p>
                    <small>Sensores cadastros no sistema</small>

                    <h1><?= htmlspecialchars($totalSensores) ?></h1>
                </div>
            </div>

            <div class="leituras estilo_primario">
                <div class="topo_leituras">
                    <div class="pesquisa_leitura">
                        <label for="pesquisa_leitura"><i class="fa-solid fa-magnifying-glass"></i></label>
                        <input class="input_padrao estilo_secundario" type="text" name="pesquisa_leitura" id="pesquisa_leitura" placeholder="Pesquise uma leitura">
                    </div>
                </div>

                <div class="tabela_leituras estilo_secundario">
                    <table>
                        <thead>
                            <tr>
                                <th>Trem</th>
                                <th>Sensor</th>
                                <th>Valor</th>
                                <th>Registro</th>
                            </tr>
                        </thead>

                        <tbody id="lista_leituras">
                            <?php if (count($leituras) > 0): ?>
                                <?php foreach ($leituras as $leitura): ?>

                                    <tr class="leitura_item">
                                        <td><?= htmlspecialchars($leitura['prefixo_trem']) ?></td>
                                        <td><?= htmlspecialchars($leitura['codigo_sensor']) ?></td>
                                        <td><?= htmlspecialchars($leitura['valor_sensor']) ?> <?= htmlspecialchars($leitura['unidade_sensor']) ?></td>
                                        <td><?= date('d/m/Y H:i:s', strtotime($leitura['registro_sensor'])) ?></td>
                                    </tr>

                                <?php endforeach; ?>

                            <?php else: ?>

                                <tr>
                                    <td class="mensagem" colspan="4"><small>Nenhuma leitura encontrada!</small></td>
                                </tr>

                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <small class="marca_dagua">Track Flow© 2026</small>
    </footer>
</body>

</html>