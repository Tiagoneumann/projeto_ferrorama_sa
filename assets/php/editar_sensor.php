
<?php

session_start();

require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../pages/tela_sensores/tela_sensores.php');
    exit;
}

$id_sensor = filter_input(INPUT_POST, 'id_sensor', FILTER_VALIDATE_INT);

$codigo = trim($_POST['codigo_sensor']);
$tipo = trim($_POST['tipo_sensor']);
$unidade = trim($_POST['unidade_sensor']);
$maximo = $_POST['maximo_sensor'];
$id_trem = filter_input(INPUT_POST, 'trem_sensor', FILTER_VALIDATE_INT);

// Valida os dados recebidos
if (
    !$id_sensor || $id_sensor <= 0 ||
    $codigo === '' ||
    $tipo === '' ||
    $unidade === '' ||
    $maximo === '' ||
    !$id_trem || $id_trem <= 0
) {
    header('Location: ../../pages/tela_sensores/tela_sensores.php?erro=dados_invalidos');
    exit;
}

$sql = "SELECT id_sensor FROM sensor WHERE id_sensor = ?";

$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_sensor);
$stmt->execute();

$existe = $stmt->get_result()->num_rows > 0;

$stmt->close();

if (!$existe) {
    header('Location: ../../pages/tela_sensores/tela_sensores.php?erro=nao_encontrado');
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
    header('Location: ../../pages/tela_sensores/tela_sensores.php?erro=trem_nao_encontrado');
    exit;
}

$sql = "UPDATE sensor
        SET codigo_sensor = ?,
            tipo_sensor = ?,
            unidade_sensor = ?,
            maximo_sensor = ?,
            id_trem = ?
        WHERE id_sensor = ?";

$stmt = $conexao->prepare($sql);

$stmt->bind_param(
    "sssdii",
    $codigo,
    $tipo,
    $unidade,
    $maximo,
    $id_trem,
    $id_sensor
);

if ($stmt->execute()) {

    header('Location: ../../pages/tela_sensores/tela_sensores.php?sucesso=editado');

} else {

    // Erro caso o código do sensor já esteja cadastrado
    if ($stmt->errno == 1062) {

        header('Location: ../../pages/tela_sensores/tela_sensores.php?erro=codigo_existente');

    } else {

        error_log('Erro ao atualizar sensor: ' . $stmt->error);

        header('Location: ../../pages/tela_sensores/tela_sensores.php?erro=atualizacao');

    }

}

$stmt->close();
$conexao->close();

exit;

