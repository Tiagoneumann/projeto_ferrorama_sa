
<?php

session_start();

require '../../assets/php/conexao.php';

// Verifica o ID recebido
if (!isset($_GET['id_relatorio']) || !is_numeric($_GET['id_relatorio'])) {
    http_response_code(400);
    exit("Relatório inválido.");
}

$id_relatorio = (int) $_GET['id_relatorio'];

// Busca o relatório
$sql = "SELECT r.*, u.nome_usuario
        FROM relatorio r
        INNER JOIN usuario u ON r.id_usuario = u.id_usuario
        WHERE r.id_relatorio = ?";

$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_relatorio);
$stmt->execute();

$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    http_response_code(404);
    exit("Relatório não encontrado.");
}

$relatorio = $resultado->fetch_assoc();

// Decodifica o JSON
$dados = json_decode($relatorio['conteudo_relatorio'], true);

if (!is_array($dados)) {
    http_response_code(500);
    exit("Erro ao carregar os dados do relatório.");
}

// Protege os dados exibidos no HTML
function escapar($valor) {
    return htmlspecialchars((string)($valor ?? ''), ENT_QUOTES, 'UTF-8');
}

// Define as seções
$secoes = [
    'trens' => 'Trens cadastrados',
    'linhas' => 'Linhas cadastradas',
    'rotas' => 'Rotas cadastradas',
    'sensores' => 'Sensores cadastrados',
    'leituras' => 'Leituras dos sensores'
];

?>

<div class="relatorio">
    <div class="bloco_relatorio estilo_primario">
        <div class="ajuste_conta">
            <h1>Relatório</h1>
            <button class="btn_fechar" id="fechar_conta"><i class="fa-solid fa-x"></i></button>
        </div>

        <div class="folha_relatorio">
            <div class="folha">

            <div class="cabecalho_relatorio">

                <h2><?= escapar($relatorio['titulo_relatorio']) ?></h2>

                <p>Gerado por: <?= escapar($relatorio['nome_usuario']) ?></p>

                <p>Data: <?= escapar($relatorio['data_geracao']) ?></p>

            </div>

            <?php foreach ($secoes as $chave => $titulo): ?>

                <?php $registros = $dados[$chave] ?? []; ?>

                <section class="secao_relatorio">

                    <h3><?= escapar($titulo) ?></h3>

                    <?php if (!empty($registros)): ?>

                        <div class="tabela_relatorio">

                            <table>

                                <thead>
                                    <tr>

                                        <?php foreach (array_keys($registros[0]) as $coluna): ?>

                                            <th><?= escapar($coluna) ?></th>

                                        <?php endforeach; ?>

                                    </tr>
                                </thead>

                                <tbody>

                                    <?php foreach ($registros as $registro): ?>

                                        <tr>

                                            <?php foreach ($registro as $valor): ?>

                                                <td><?= escapar($valor) ?></td>

                                            <?php endforeach; ?>

                                        </tr>

                                    <?php endforeach; ?>

                                </tbody>

                            </table>

                        </div>

                    <?php else: ?>

                        <p>Nenhum registro encontrado.</p>

                    <?php endif; ?>

                </section>

            <?php endforeach; ?>

            </div>
        </div>
    
        <button class="botao" type="button" onclick="window.print()">Baixar / Imprimir PDF</button>
    </div>
</div>
