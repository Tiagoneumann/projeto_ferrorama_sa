<?php

require_once '../../assets/php/autorizacao.php';
require_once '../../assets/php/gerar_alertas.php';

$sql = "SELECT trem.*, linha.nome_linha
        FROM trem
        LEFT JOIN linha 
        ON trem.id_linha = linha.id_linha";

$resultado = $conexao->query($sql);

$trens = [];
$totalAtivos = 0;
$totalManutencao = 0;
$totalParados = 0;

while ($trem = $resultado->fetch_assoc()) {
    $trens[] = $trem;

    switch ($trem['status_trem']) {
        case 'ativo':
            $totalAtivos++;
            break;

        case 'manutencao':
            $totalManutencao++;
            break;

        case 'parado':
            $totalParados++;
            break;
    }
}

$totalTrens = count($trens);

$porcentagemAtivos = $totalTrens > 0
    ? round(($totalAtivos * 100) / $totalTrens)
    : 0;

$porcentagemManutencao = $totalTrens > 0
    ? round(($totalManutencao * 100) / $totalTrens)
    : 0;

$porcentagemParados = $totalTrens > 0
    ? round(($totalParados * 100) / $totalTrens)
    : 0;

$limiteParados = $porcentagemParados;
$limiteManutencao = $limiteParados + $porcentagemManutencao;
$limiteAtivos = 100;

$sqlLeituras = "SELECT
                    leitura.id_leitura,
                    leitura.valor_sensor,
                    leitura.registro_sensor,
                    sensor.tipo_sensor,
                    sensor.unidade_sensor,
                    sensor.codigo_sensor,
                    trem.prefixo_trem
                FROM leitura
                INNER JOIN sensor
                    ON leitura.id_sensor = sensor.id_sensor
                INNER JOIN trem
                    ON sensor.id_trem = trem.id_trem
                ORDER BY leitura.registro_sensor DESC";

$resultadoLeituras = $conexao->query($sqlLeituras);

$leituras = [];

if ($resultadoLeituras) {
    while ($leitura = $resultadoLeituras->fetch_assoc()) {
        $leituras[] = $leitura;
    }
}

$sqlAlertas = "
    SELECT
        titulo_alerta,
        descricao_alerta,
        tipo_alerta,
        data_alerta
    FROM alerta
    ORDER BY
        FIELD(tipo_alerta, 'critico', 'aviso', 'informativo'),
        data_alerta DESC
";

$resultadoAlertas = $conexao->query($sqlAlertas);

$alertas = [];

if ($resultadoAlertas) {
    while ($alerta = $resultadoAlertas->fetch_assoc()) {
        $alertas[] = $alerta;
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

            <div class="status_trens estilo_primario">
                <div class="status estilo_secundario">
                    <i class="status_verde fa-solid fa-check"></i>

                    <div>
                        <p><strong>Trens ativos</strong></p>
                        <small class="quantidade_status"><span><?= htmlspecialchars($totalAtivos) ?></span> de <?= htmlspecialchars($totalTrens) ?></small>
                        <input class="barra_verde" type="range" style="--progresso-verde: <?= $porcentagemAtivos ?>%;" disabled>
                    </div>
                </div>

                <div class="status estilo_secundario">
                    <i class="status_amarelo fa-solid fa-gear"></i>

                    <div>
                        <p><strong>Trens em manutenção</strong></p>
                        <small class="quantidade_status"><span><?= htmlspecialchars($totalManutencao) ?></span> de <?= htmlspecialchars($totalTrens) ?></small>
                        <input class="barra_amarela" type="range" style="--progresso-amarelo: <?= $porcentagemManutencao ?>%;" disabled>
                    </div>
                </div>

                <div class="status estilo_secundario">
                    <i class="status_vermelho fa-solid fa-stop"></i>

                    <div>
                        <p><strong>Trens parados</strong></p>
                        <small class="quantidade_status"><span><?= htmlspecialchars($totalParados) ?></span> de <?= htmlspecialchars($totalTrens) ?></small>
                        <input class="barra_vermelha" type="range" style="--progresso-vermelho: <?= $porcentagemParados ?>%;" disabled>
                    </div>
                </div>
            </div>

            <div class="grafico_trens estilo_primario">
                <div class="bloco_grafico">
                    <p><strong>Estado dos Trens</strong></p>
                    <small>Distribuição da frota por status</small>

                    <div class="grafico" style="--limite-parados: <?= $limiteParados ?>%; --limite-manutencao: <?= $limiteManutencao ?>%; --limite-ativos: <?= $limiteAtivos ?>%;"></div>
                </div>

                <div class="dados_grafico estilo_secundario">
                    <table>
                        <tr>
                            <th>Status</th>
                            <th>Quantidade</th>
                            <th>Porcentagem</th>
                        </tr>

                        <tr>
                            <td><i class="bola_verde fa-solid fa-circle"></i> Ativo</td>
                            <td><?= htmlspecialchars($totalAtivos) ?></td>
                            <td><?= $porcentagemAtivos ?>%</td>
                        </tr>

                        <tr>
                            <td><i class="bola_amarela fa-solid fa-circle"></i> Manutenção</td>
                            <td><?= htmlspecialchars($totalManutencao) ?></td>
                            <td><?= $porcentagemManutencao ?>%</td>
                        </tr>

                        <tr>
                            <td><i class="bola_vermelha fa-solid fa-circle"></i> Parado</td>
                            <td><?= htmlspecialchars($totalParados) ?></td>
                            <td><?= $porcentagemParados ?>%</td>
                        </tr>

                    </table>
                </div>
            </div>

            <div class="lista_trens estilo_primario">
                <div class="topo_lista_trens">
                    <div class="lista_trens_info">
                        <p><strong><i class="fa-solid fa-train"></i> Catálogo de Trens</strong></p>
                        <small>Todos os trens cadastrados no sistema</small>
                    </div>

                    <div class="pesquisa">
                        <label for="pesquisa_trens"><i class="fa-solid fa-magnifying-glass"></i></label>
                        <input class="input_padrao estilo_secundario" type="text" name="pesquisa_trens" id="pesquisa_trens" placeholder="Pesquise um trem">
                    </div>
                </div>

                <div class="catalogo estilo_secundario">
                    <table>
                        <tr>
                            <th>Prefixo</th>
                            <th>Modelo</th>
                            <th>Status</th>
                            <th>Linha</th>
                            <th>Ano</th>
                        </tr>

                        <?php if (count($trens) > 0): ?>
                            <?php foreach ($trens as $trem): ?>

                                <tr class="trem_item">
                                    <td><?= htmlspecialchars($trem['prefixo_trem']) ?? "--" ?></td>
                                    <td><?= htmlspecialchars($trem['modelo_trem']) ?? "--" ?></td>
                                    <td class="status_<?= match ($trem['status_trem']) {
                                                            'ativo' => 'ativo',
                                                            'manutencao' => 'manutencao',
                                                            'parado' => 'parado'
                                                        } ?>"><?= match ($trem['status_trem']) {
                                                                    'ativo' => htmlspecialchars("Ativo"),
                                                                    'manutencao' => htmlspecialchars("Manutenção"),
                                                                    'parado' => htmlspecialchars("Parado")
                                                                } ?? "--" ?></td>
                                    <td><?= htmlspecialchars($trem['nome_linha'] ?? "--") ?></td>
                                    <td><?= htmlspecialchars($trem['ano_trem']) ?? "--" ?></td>
                                </tr>

                            <?php endforeach; ?>
                        <?php else: ?>

                            <tr>
                                <td class="mensagem" colspan="5"><small>Nenhum trem encontrado!</small></td>
                            </tr>

                        <?php endif; ?>

                    </table>
                </div>
            </div>

            <div class="leitura estilo_primario">
                <div class="topo_lista_leituras">
                    <div class="lista_leituras_info">
                        <p><strong><i class="fa-solid fa-clock"></i> Leituras</strong></p>
                        <small>Todos as leituras do sistema</small>
                    </div>

                    <div class="pesquisa">
                        <label for="pesquisa_leituras"><i class="fa-solid fa-magnifying-glass"></i></label>
                        <input class="input_padrao estilo_secundario" type="text" name="pesquisa_leituras" id="pesquisa_leituras" placeholder="Pesquise por uma leitura">
                    </div>
                </div>


                <div class="catalogo estilo_secundario">
                    <table>
                        <tr>
                            <th>Trem</th>
                            <th>Tipo</th>
                            <th>Valor</th>
                        </tr>

                        <?php if (count($leituras) > 0): ?>
                            <?php foreach ($leituras as $leitura): ?>

                                <tr class="leitura_item">
                                    <td><?= htmlspecialchars($leitura['prefixo_trem']) ?></td>
                                    <td><?= htmlspecialchars($leitura['tipo_sensor']) ?></td>
                                    <td><?= htmlspecialchars(number_format((float)$leitura['valor_sensor'], 2, ',', '.') . ' ' . $leitura['unidade_sensor']) ?></td>
                                </tr>

                            <?php endforeach; ?>
                        <?php else: ?>

                            <tr>
                                <td class="mensagem" colspan="3"><small>Nenhuma leitura encontrada!</small></td>
                            </tr>

                        <?php endif; ?>
                    </table>
                </div>
            </div>

            <div class="aviso estilo_primario">

                <p><strong><i class="fa-solid fa-bell"></i> Avisos</strong></p>

                <div class="lista_avisos estilo_secundario">

                    <?php if (empty($alertas)): ?>

                        <div class="sem_avisos">
                            <i class="fa-solid fa-circle-check"></i>
                            <p>Nenhum alerta no momento!</p>
                            <small>Todos os sensores estão dentro dos limites.</small>
                        </div>

                    <?php else: ?>

                        <?php foreach ($alertas as $alerta): ?>

                            <div class="item_aviso aviso_<?= htmlspecialchars($alerta['tipo_alerta']) ?>">

                                <div class="aviso_icone">

                                    <?php if ($alerta['tipo_alerta'] === 'critico'): ?>

                                        <i class="fa-solid fa-circle-exclamation"></i>

                                    <?php elseif ($alerta['tipo_alerta'] === 'aviso'): ?>

                                        <i class="fa-solid fa-triangle-exclamation"></i>

                                    <?php else: ?>

                                        <i class="fa-solid fa-circle-info"></i>

                                    <?php endif; ?>

                                </div>

                                <div class="aviso_conteudo">

                                    <div class="aviso_cabecalho">

                                        <strong><?= htmlspecialchars($alerta['titulo_alerta']) ?></strong>
                                        <span class="aviso_tipo"><?= ucfirst(htmlspecialchars($alerta['tipo_alerta'])) ?></span>

                                    </div>

                                    <p><?= htmlspecialchars($alerta['descricao_alerta']) ?></p>
                                    <small><i class="fa-regular fa-clock"></i><?= date('d/m/Y H:i', strtotime($alerta['data_alerta'])) ?></small>

                                </div>

                            </div>

                        <?php endforeach; ?>

                    <?php endif; ?>

                </div>

            </div>

        </div>

    </main>
    <footer>
        <small class="marca_dagua">Track Flow© 2026</small>
    </footer>
</body>

</html>