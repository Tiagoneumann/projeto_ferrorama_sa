<?php

session_start();

require '../../assets/php/conexao.php';

$sql = "SELECT id_trem, prefixo_trem, modelo_trem FROM trem";
$resultado = $conexao->query($sql);

$id_sensor = filter_input(INPUT_GET, 'id_sensor', FILTER_VALIDATE_INT);

$stmt = $conexao->prepare('SELECT * FROM sensor WHERE id_sensor = ?');
$stmt->bind_param('i', $id_sensor);
$stmt->execute();

$sensor = $stmt->get_result()->fetch_assoc();
$stmt->close();

?>

<div class="conta">
    <div class="bloco_conta estilo_primario">
        <div class="ajuste_conta">
            <h1>Editar sensor</h1>
            <button class="btn_fechar" id="fechar_conta"><i class="fa-solid fa-x"></i></button>
        </div>

        <div class="bloco_conta estilo_secundario">

            <form action="../../assets/php/editar_sensor.php" method="POST">
                <div class="separacao">

                    <input type="hidden" name="id_sensor" value="<?= htmlspecialchars($sensor['id_sensor']) ?>">

                    <input class="input_padrao estilo_secundario" type="text" name="codigo_sensor" placeholder="Código do sensor" value="<?= htmlspecialchars($sensor['codigo_sensor']) ?>" required>

                    <input class="input_padrao estilo_secundario" type="text" name="tipo_sensor" placeholder="Tipo do sensor" value="<?= htmlspecialchars($sensor['tipo_sensor']) ?>" required>

                    <input class="input_padrao estilo_secundario" type="text" name="unidade_sensor" placeholder="Unidades do sensor" value="<?= htmlspecialchars($sensor['unidade_sensor']) ?>" required>

                    <select class="input_padrao estilo_secundario" name="trem_sensor" id="trens">
                        
                        <option value="">Selecione um trem</option>

                        <?php while ($trem = $resultado->fetch_assoc()):?>

                            <option value="<?= $trem['id_trem']?>" <?= ($trem['id_trem'] == $sensor['id_trem']) ? 'selected' : '' ?>> <?= htmlspecialchars($trem['prefixo_trem']), " / ", htmlspecialchars($trem['modelo_trem']) ?></option>

                        <?php endwhile;?>
                    </select>

                    <p id="erro_sensor"></p>

                </div>

                <button type="submit" class="botao extensao_botao"><i class="fa-solid fa-plus"></i> Realizar Alterações</button>
            </form>
        </div>
    </div>
</div>