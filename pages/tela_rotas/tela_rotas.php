<?php

session_start();

require '../../assets/php/conexao.php';

$sql = 'SELECT r.id_rota, r.origem_rota, r.destino_rota,
r.data_rota, r.horario_partida, r.horario_chegada,
r.status_rota, t.prefixo_trem, t.modelo_trem, l.nome_linha
FROM rota r
INNER JOIN trem t ON r.id_trem = t.id_trem
INNER JOIN linha l ON r.id_linha = l.id_linha';

$resultado = $conexao->query($sql);

$sql_linhas = 'SELECT id_linha, nome_linha FROM linha';

$resultado_linhas = $conexao->query($sql_linhas);

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

    <title>Track Flow || Rotas</title>
</head>

<body>

    <header>

        <div id="usuario"></div>
        <div id="linha"></div>

        <nav class="navbar">
            <div class="navbar_bloco">
                <button class="btn_navbar_menu" id="btn_menu"><i class="fa-solid fa-bars"></i></button>

                <div class="logo">
                    <img src="../../assets/img/logo_sem_fundo_branco.png" alt="logo">
                    <h6>Rotas</h6>
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
            <div class="linhas estilo_primario">
                <button id="criar_linha" class="botao"><i class="fa-solid fa-plus"></i> Adicionar linha</button>

                <div class="tabela_linhas estilo_secundario">
                    <table>
                        <tr>
                            <th>Linhas</th> 
                        </tr>

                        <?php if($resultado_linhas->num_rows > 0): ?>

                        <?php while($linhas = $resultado_linhas->fetch_assoc()): ?>
                            <tr>
                                <td>
                                    <?= htmlspecialchars($linhas['nome_linha']) ?>

                                    <form action="../../assets/php/excluir_linha.php" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir essa linha?');">
                                        <input type="hidden" name="id_linha" value="<?= $linhas['id_linha'] ?>">
                                        <button type="submit" class="btn_excluir_linha"><i class="fa-solid fa-x"></i></button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>

                        <?php else: ?>
                            
                            <tr>
                                <td class="mensagem" colspan="4"><small>Nenhuma linha encontrada!</small></td>
                            </tr>

                        <?php endif; ?>

                    </table>
                </div>
            </div>

            <div class="rotas estilo_primario">
                <div class="topo_rotas">
                    <div class="pesquisa_rota">
                        <label for="pesquisa_rota"><i class="fa-solid fa-magnifying-glass"></i></label>
                        <input class="input_padrao estilo_secundario" type="text" name="pesquisa_rota" id="pesquisa_rota" placeholder="Pesquise um rota">
                    </div>

                    <button id="criar_rota" class="botao"><i class="fa-solid fa-plus"></i> Adicionar rota</button>
                </div>

                <div class="tabela_rotas estilo_secundario">
                    <table>
                        <tr>
                            <th>Data</th>
                            <th>Origem / Destino</th>
                            <th>Partida / Chegada</th>
                            <th>Status</th>
                            <th>Trem</th>
                            <th>Linha</th>
                        </tr>

                        <?php if($resultado->num_rows > 0): ?>

                        <?php while($rotas = $resultado->fetch_assoc()): ?>
                            <tr class="rota_item">
                                <td>
                                    <button id="editar_rota" class="btn_editar" data-id="<?= $rotas['id_rota'] ?>"><i class="fa-solid fa-pen-to-square"></i></button>
                                    <?= htmlspecialchars($rotas['data_rota']) ?>
                                </td>
                                <td><?= htmlspecialchars($rotas['origem_rota']) ?> / <?= htmlspecialchars($rotas['destino_rota']) ?> </td>
                                <td><?= htmlspecialchars($rotas['horario_partida']) ?> / <?= htmlspecialchars($rotas['horario_chegada']) ?></td>
                                <td><?= htmlspecialchars($rotas['status_rota']) ?></td>
                                <td><?= htmlspecialchars($rotas['prefixo_trem']) ?> / <?= htmlspecialchars($rotas['modelo_trem']) ?></td>
                                <td>
                                    <?= htmlspecialchars($rotas['nome_linha']) ?>

                                    <form action="../../assets/php/excluir_rota.php" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir essa rota?');">
                                        <input type="hidden" name="id_rota" value="<?= $rotas['id_rota'] ?>">
                                        <button type="submit" class="btn_excluir_rota"><i class="fa-solid fa-x"></i></button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>

                        <?php else: ?>
                            
                            <tr>
                                <td class="mensagem" colspan="6"><small>Nenhuma rota encontrada!</small></td>
                            </tr>

                        <?php endif; ?>
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