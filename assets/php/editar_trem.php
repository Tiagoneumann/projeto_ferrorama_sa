<?php

require 'autorizacao.php';
require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../pages/tela_trens/tela_trens.php');
    exit;
}

$id = filter_input(INPUT_POST, 'id_trem', FILTER_VALIDATE_INT);

$prefixo = trim($_POST['prefixo_trem'] ?? '');
$modelo = trim($_POST['modelo_trem'] ?? '');
$ano = filter_input(INPUT_POST, 'ano_trem', FILTER_VALIDATE_INT);
$status = $_POST['status_trem'] ?? '';
$linha = $_POST['linhas'] ?? '';

if (
    !$id ||
    $prefixo === '' ||
    $modelo === '' ||
    !$ano ||
    $ano < 1800 ||
    $ano > 2100 ||
    !in_array($status, ['ativo', 'manutencao', 'parado'], true)
) {
    header('Location: ../../pages/tela_trens/tela_trens.php?erro=dados_invalidos');
    exit;
}

if ($linha === '') {
    $linha = null;
} else {
    $linha = filter_var($linha, FILTER_VALIDATE_INT);

    if (!$linha || $linha < 1) {
        header('Location: ../../pages/tela_trens/tela_trens.php?erro=linha_invalida');
        exit;
    }

    $sql = "SELECT id_linha FROM linha WHERE id_linha = ?";

    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $linha);
    $stmt->execute();

    $existe_linha = $stmt->get_result()->num_rows > 0;

    $stmt->close();

    if (!$existe_linha) {
        header('Location: ../../pages/tela_trens/tela_trens.php?erro=linha_invalida');
        exit;
    }
}

$sql = "SELECT imagem_trem FROM trem WHERE id_trem = ?";

$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$trem = $stmt->get_result()->fetch_assoc();

$stmt->close();

if (!$trem) {
    header('Location: ../../pages/tela_trens/tela_trens.php?erro=nao_encontrado');
    exit;
}

$imagem = $trem['imagem_trem'];

if (
    isset($_FILES['imagem_trem']) &&
    $_FILES['imagem_trem']['error'] !== UPLOAD_ERR_NO_FILE
) {
    $arquivo = $_FILES['imagem_trem'];

    if ($arquivo['error'] !== UPLOAD_ERR_OK || $arquivo['size'] > 5 * 1024 * 1024) {
        header('Location: ../../pages/tela_trens/tela_trens.php?erro=imagem_invalida');
        exit;
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $tipo_imagem = $finfo->file($arquivo['tmp_name']);

    $extensoes = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp'
    ];

    if (!isset($extensoes[$tipo_imagem])) {
        header('Location: ../../pages/tela_trens/tela_trens.php?erro=formato_imagem');
        exit;
    }

    $diretorio = __DIR__ . '/../img/trens/';

    if (!is_dir($diretorio)) {
        mkdir($diretorio, 0755, true);
    }

    $nome_imagem = bin2hex(random_bytes(16)) . '.' . $extensoes[$tipo_imagem];
    $destino = $diretorio . $nome_imagem;

    if (!move_uploaded_file($arquivo['tmp_name'], $destino)) {
        header('Location: ../../pages/tela_trens/tela_trens.php?erro=upload');
        exit;
    }

    $imagem = '../../assets/img/trens/' . $nome_imagem;
}

$sql = "UPDATE trem
        SET prefixo_trem = ?,
            modelo_trem = ?,
            ano_trem = ?,
            status_trem = ?,
            imagem_trem = ?,
            id_linha = ?
        WHERE id_trem = ?";

$stmt = $conexao->prepare($sql);

$stmt->bind_param(
    "ssissii",
    $prefixo,
    $modelo,
    $ano,
    $status,
    $imagem,
    $linha,
    $id
);

if ($stmt->execute()) {

    if (
        isset($destino) &&
        !empty($trem['imagem_trem']) &&
        strpos($trem['imagem_trem'], '../../assets/img/trens/') === 0
    ) {
        $imagem_antiga = __DIR__ . '/../img/trens/' . basename($trem['imagem_trem']);

        if (is_file($imagem_antiga)) {
            unlink($imagem_antiga);
        }
    }

    header('Location: ../../pages/tela_trens/tela_trens.php?sucesso=editado');

} else {

    error_log('Erro ao atualizar trem: ' . $stmt->error);

    if (isset($destino) && is_file($destino)) {
        unlink($destino);
    }

    header('Location: ../../pages/tela_trens/tela_trens.php?erro=atualizacao');
}

$stmt->close();
$conexao->close();

exit;
