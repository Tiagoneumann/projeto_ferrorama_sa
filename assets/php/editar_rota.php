
<?php

session_start();

require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../pages/tela_rotas/tela_rotas.php');
    exit;
}

$id_rota = filter_input(INPUT_POST, 'id_rota', FILTER_VALIDATE_INT);

$origem = trim($_POST['origem_rota'] ?? '');
$destino = trim($_POST['destino_rota'] ?? '');
$data = $_POST['data_rota'] ?? '';
$partida = $_POST['horario_partida'] ?? '';
$chegada = $_POST['horario_chegada'] ?? '';
$status = trim($_POST['status_rota'] ?? '');

$id_trem = filter_input(INPUT_POST, 'trem_rota', FILTER_VALIDATE_INT);
$id_linha = filter_input(INPUT_POST, 'linha_rota', FILTER_VALIDATE_INT);

// Status permitidos
$status_opcoes = [
    'programada',
    'em andamento',
    'concluida',
    'cancelada'
];

// Valida os dados recebidos
if (
    !$id_rota || $id_rota <= 0 ||
    $origem === '' ||
    $destino === '' ||
    $origem === $destino ||
    $data === '' ||
    $partida === '' ||
    $chegada === '' ||
    !$id_trem || $id_trem <= 0 ||
    !$id_linha || $id_linha <= 0 ||
    !in_array($status, $status_opcoes, true)
) {
    header('Location: ../../pages/tela_rotas/tela_rotas.php?erro=dados_invalidos');
    exit;
}

// Verifica se a rota existe
$sql = "SELECT id_rota FROM rota WHERE id_rota = ?";

$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_rota);
$stmt->execute();

$existe = $stmt->get_result()->num_rows > 0;

$stmt->close();

if (!$existe) {
    header('Location: ../../pages/tela_rotas/tela_rotas.php?erro=nao_encontrado');
    exit;
}

// Verifica se o trem existe
$sql = "SELECT id_trem FROM trem WHERE id_trem = ?";

$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_trem);
$stmt->execute();

$trem_existe = $stmt->get_result()->num_rows > 0;

$stmt->close();

if (!$trem_existe) {
    header('Location: ../../pages/tela_rotas/tela_rotas.php?erro=trem_nao_encontrado');
    exit;
}

// Verifica se a linha existe
$sql = "SELECT id_linha FROM linha WHERE id_linha = ?";

$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_linha);
$stmt->execute();

$linha_existe = $stmt->get_result()->num_rows > 0;

$stmt->close();

if (!$linha_existe) {
    header('Location: ../../pages/tela_rotas/tela_rotas.php?erro=linha_nao_encontrada');
    exit;
}

// Atualiza os dados da rota
$sql = "UPDATE rota
        SET origem_rota = ?,
            destino_rota = ?,
            data_rota = ?,
            horario_partida = ?,
            horario_chegada = ?,
            status_rota = ?,
            id_trem = ?,
            id_linha = ?
        WHERE id_rota = ?";

$stmt = $conexao->prepare($sql);

$stmt->bind_param(
    "ssssssiii",
    $origem,
    $destino,
    $data,
    $partida,
    $chegada,
    $status,
    $id_trem,
    $id_linha,
    $id_rota
);

if ($stmt->execute()) {

    header('Location: ../../pages/tela_rotas/tela_rotas.php?sucesso=editado');

} else {

    error_log('Erro ao atualizar rota: ' . $stmt->error);

    header('Location: ../../pages/tela_rotas/tela_rotas.php?erro=atualizacao');

}

$stmt->close();
$conexao->close();

exit;

?>
