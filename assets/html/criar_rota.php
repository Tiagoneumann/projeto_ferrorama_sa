<?php

session_start();

require "../../assets/php/conexao.php";

$sql_trem = "SELECT id_trem, prefixo_trem, modelo_trem FROM trem";
$resultado_trem = $conexao->query($sql_trem);

$sql_linha = "SELECT id_linha, nome_linha FROM linha";
$resultado_linha = $conexao->query($sql_linha);

?>

<div class="conta">
    <div class="bloco_conta estilo_primario">
        <div class="ajuste_conta">
            <h1>Criar rota</h1>
            <button class="btn_fechar" id="fechar_conta"><i class="fa-solid fa-x"></i></button>
        </div>

        <div class="bloco_conta estilo_secundario">

            <form action="../../assets/php/criar_rota.php" method="POST">
                <div class="separacao">

                    <input class="input_padrao estilo_secundario" type="date" name="data_rota" required>

                <div class="viagem">
                    <input class="input_padrao estilo_secundario" type="text" name="origem_rota" placeholder="Origem" required>

                    <input class="input_padrao estilo_secundario" type="text" name="destino_rota" placeholder="Destino" required>
                </div>

                <div class="horario">
                    <input class="input_padrao estilo_secundario" type="text" name="horario_partida" placeholder="Partida" required>

                    <input class="input_padrao estilo_secundario" type="text" name="horario_chegada" placeholder="Chegada" required>
                </div>

                    <select class="input_padrao estilo_secundario" name="trem_rota" id="trens">
                        
                        <option value="">Selecione um trem</option>

                        <?php while ($trem = $resultado_trem->fetch_assoc()):?>

                            <option value="<?= $trem['id_trem']?>"> <?= htmlspecialchars($trem['prefixo_trem']), " / ", htmlspecialchars($trem['modelo_trem']) ?></option>

                        <?php endwhile;?>
                    </select>

                    <select class="input_padrao estilo_secundario" name="linha_rota" id="linhas">
                        
                        <option value="">Selecione uma linha</option>

                        <?php while ($linha = $resultado_linha->fetch_assoc()):?>

                            <option value="<?= $linha['id_linha']?>"> <?= htmlspecialchars($linha['nome_linha'])?></option>

                        <?php endwhile;?>
                    </select>

                    <div class="opcoes_usuario">
                        <label class="opcao_usuario estilo_secundario">
                            <input type="radio" name="status_rota" value="programada">
                            <span>Programada</span>
                        </label>
                        <label class="opcao_usuario estilo_secundario">
                            <input type="radio" name="status_rota" value="em andamento">
                            <span>Em andamento</span>
                        </label>
                        <label class="opcao_usuario estilo_secundario">
                            <input type="radio" name="status_rota" value="concluida">
                            <span>Concluida</span>
                        </label>
                         <label class="opcao_usuario estilo_secundario">
                            <input type="radio" name="status_rota" value="cancelada">
                            <span>Cancelada</span>
                        </label>
                    </div>

                </div>

                <button type="submit" class="botao extensao_botao"><i class="fa-solid fa-plus"></i> Criar rota</button>
            </form>
        </div>
    </div>
</div>