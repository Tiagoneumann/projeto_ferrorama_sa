<?php

require '../../assets/php/conexao.php';

$id_trem = filter_input(INPUT_GET, 'id_trem', FILTER_VALIDATE_INT);

if (!$id_trem || $id_trem < 1) {
    http_response_code(400);
    exit('ID do trem inválido.');
}

$stmt = $conexao->prepare('SELECT * FROM trem WHERE id_trem = ?');
$stmt->bind_param('i', $id_trem);
$stmt->execute();

$trem = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$trem) {
    http_response_code(404);
    exit('Trem não encontrado.');
}

$resultado_linhas = $conexao->query(
    'SELECT id_linha, nome_linha FROM linha ORDER BY nome_linha'
);

function escaparTrem($valor) {
    return htmlspecialchars((string) $valor);
}
?>

<div class="conta">
    <div class="bloco_conta estilo_primario">

        <div class="ajuste_conta">
            <h1>Editar Trem</h1>

            <button type="button" class="btn_fechar" id="fechar_conta">
                <i class="fa-solid fa-x"></i>
            </button>
        </div>

        <div class="bloco_conta estilo_secundario">
            <form action="../../assets/php/editar_trem.php" method="POST" enctype="multipart/form-data" class="form_trem">
                <input type="hidden" name="id_trem" value="<?= (int) $trem['id_trem'] ?>">

                <?php if (!empty($trem['imagem_trem'])): ?>
                    <img src="<?= escaparTrem($trem['imagem_trem']) ?>" alt="Imagem atual do trem" style="max-width: 200px; max-height: 120px;">
                <?php endif; ?>

                <div class="separacao">

                    <input class="input_padrao estilo_secundario" type="file" name="imagem_trem" accept="image/jpeg, image/png, image/webp">

                    <input class="input_padrao estilo_secundario" type="text" name="prefixo_trem" placeholder="Prefixo | ex: BR 403" value="<?= escaparTrem($trem['prefixo_trem']) ?>" maxlength="100" required>

                    <input class="input_padrao estilo_secundario" type="text" name="modelo_trem" placeholder="Modelo | ex: Siemens Velaro" value="<?= escaparTrem($trem['modelo_trem']) ?>" maxlength="100" required>

                    <input class="input_padrao estilo_secundario" type="number" name="ano_trem" placeholder="Ano de criação" value="<?= (int) $trem['ano_trem'] ?>" min="1800" max="2100" required>

                    <select class="input_padrao estilo_secundario" name="linhas">
                        <option value="">Sem linha</option>

                        <?php while ($linha = $resultado_linhas->fetch_assoc()): ?>
                            <option value="<?= (int) $linha['id_linha'] ?>" <?= (int) ($trem['id_linha'] ?? 0) === (int) $linha['id_linha'] ? 'selected' : '' ?>>
                                <?= escaparTrem($linha['nome_linha']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>

                    <div class="opcoes_usuario">

                        <?php
                        $status_opcoes = [
                            'ativo' => 'Ativo',
                            'manutencao' => 'Manutenção',
                            'parado' => 'Parado'
                        ];
                        ?>

                        <?php foreach ($status_opcoes as $valor => $rotulo): ?>
                            <label class="opcao_usuario estilo_secundario">
                                <input type="radio" name="status_trem" value="<?= $valor ?>" <?= $trem['status_trem'] === $valor ? 'checked' : '' ?> required>
                                <span><?= $rotulo ?></span>
                            </label>
                        <?php endforeach; ?>

                    </div>
                </div>

                <button type="submit" class="botao extensao_botao">Salvar Alterações</button>
            </form>
        </div>
    </div>
</div>