<?php

session_start();

require "../../assets/php/conexao.php";

$id_rota = filter_input(INPUT_GET, 'id_rota', FILTER_VALIDATE_INT);

$stmt = $conexao->prepare('SELECT * FROM rota WHERE id_rota = ?');
$stmt->bind_param('i', $id_rota);
$stmt->execute();

$rota = $stmt->get_result()->fetch_assoc();
$stmt->close();

$resultado_trens = $conexao->query(
    'SELECT id_trem, prefixo_trem, modelo_trem FROM trem ORDER BY prefixo_trem'
);

$resultado_linhas = $conexao->query(
    'SELECT id_linha, nome_linha FROM linha ORDER BY nome_linha'
);

?>

<div class="conta">
    <div class="bloco_conta estilo_primario">
        <div class="ajuste_conta">
            <h1>Editar rota</h1>
            <button class="btn_fechar" id="fechar_conta"><i class="fa-solid fa-x"></i></button>
        </div>

        <div class="bloco_conta estilo_secundario">

            <form action="../../assets/php/editar_rota.php" method="POST">
                <div class="separacao">

                    <input type="hidden" name="id_rota" value="<?= htmlspecialchars($rota['id_rota']) ?>">

                    <input class="input_padrao estilo_secundario" type="date" name="data_rota" value="<?= htmlspecialchars($rota['data_rota']) ?>" required>

                <div class="viagem">
                    <input class="input_padrao estilo_secundario" type="text" name="origem_rota" placeholder="Origem" value="<?= htmlspecialchars($rota['origem_rota']) ?>" required>

                    <input class="input_padrao estilo_secundario" type="text" name="destino_rota" placeholder="Destino" value="<?= htmlspecialchars($rota['destino_rota']) ?>" required>
                </div>

                <div class="horario">
                    <input class="input_padrao estilo_secundario" type="text" name="horario_partida" placeholder="Partida" value="<?= htmlspecialchars($rota['horario_partida']) ?>" required>

                    <input class="input_padrao estilo_secundario" type="text" name="horario_chegada" placeholder="Chegada" value="<?= htmlspecialchars($rota['horario_chegada']) ?>" required>
                </div>

                    <select class="input_padrao estilo_secundario" name="trem_rota" id="trens">
                        
                        <option value="">Selecione um trem</option>

                        <?php while ($trem = $resultado_trens->fetch_assoc()):?>

                            <option value="<?= $trem['id_trem']?>"  <?= (int)$rota['id_trem'] === (int)$trem['id_trem'] ? 'selected' : '' ?>> <?= htmlspecialchars($trem['prefixo_trem']), " / ", htmlspecialchars($trem['modelo_trem']) ?></option>

                        <?php endwhile;?>
                    </select>

                    <select class="input_padrao estilo_secundario" name="linha_rota" id="linhas">
                        
                        <option value="">Selecione uma linha</option>

                        <?php while ($linha = $resultado_linhas->fetch_assoc()):?>

                            <option value="<?= $linha['id_linha']?>" <?= (int)$rota['id_linha'] === (int)$linha['id_linha'] ? 'selected' : '' ?>> <?= htmlspecialchars($linha['nome_linha'])?></option>

                        <?php endwhile;?>
                    </select>

                    <div class="opcoes_usuario">
                        <?php $status_opcoes = ['programada' => 'Programada', 'em andamento' => 'Em andamento', 'concluida' => 'Concluída', 'cancelada' => 'Cancelada']; ?>

                        <?php foreach ($status_opcoes as $valor => $rotulo): ?>
                            <label class="opcao_usuario estilo_secundario">
                                <input type="radio" name="status_rota" value="<?= $valor ?>" <?= $rota['status_rota'] === $valor ? 'checked' : '' ?> required>
                                <span><?= $rotulo ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>

                </div>

                <button type="submit" class="botao extensao_botao"><i class="fa-solid fa-plus"></i> Salvar Alterações</button>
            </form>
        </div>
    </div>
</div>