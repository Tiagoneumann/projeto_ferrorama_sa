
<?php

require_once __DIR__ . '/autorizacao.php';
require_once __DIR__ . '/conexao.php';

header('Content-Type: application/json; charset=utf-8');

function responder($sucesso, $mensagem, $codigo = 200) {
    http_response_code($codigo);
    echo json_encode([
        'sucesso' => $sucesso,
        'mensagem' => $mensagem
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    responder(false, 'Método não permitido.', 405);
}

$id = filter_input(INPUT_POST, 'id_trem', FILTER_VALIDATE_INT);
$prefixo = trim($_POST['prefixo_trem'] ?? '');
$modelo = trim($_POST['modelo_trem'] ?? '');
$ano = filter_input(INPUT_POST, 'ano_trem', FILTER_VALIDATE_INT);
$status = $_POST['status_trem'] ?? '';
$linha = $_POST['linhas'] ?? '';

if (
    !$id || $prefixo === '' || $modelo === '' ||
    !$ano || $ano < 1800 || $ano > 2100 ||
    mb_strlen($prefixo) > 100 || mb_strlen($modelo) > 100 ||
    !in_array($status, ['ativo', 'manutencao', 'parado'], true)
) {
    responder(false, 'Verifique os dados informados.', 422);
}

if ($linha === '') {
    $linha = null;
} else {
    $linha = filter_var($linha, FILTER_VALIDATE_INT);

    if (!$linha || $linha < 1) {
        responder(false, 'Linha inválida.', 422);
    }

    $stmt = $conexao->prepare(
        'SELECT id_linha FROM linha WHERE id_linha = ?'
    );
    $stmt->bind_param('i', $linha);
    $stmt->execute();
    $existe = $stmt->get_result()->num_rows > 0;
    $stmt->close();

    if (!$existe) {
        responder(false, 'A linha selecionada não existe.', 422);
    }
}

$stmt = $conexao->prepare(
    'SELECT imagem_trem FROM trem WHERE id_trem = ?'
);
$stmt->bind_param('i', $id);
$stmt->execute();
$atual = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$atual) {
    responder(false, 'Trem não encontrado.', 404);
}

$imagem = $atual['imagem_trem'];
$nova_imagem = null;
$destino = null;
$diretorio = dirname(__DIR__) . '/img/trens/';

if (
    isset($_FILES['imagem_trem']) &&
    $_FILES['imagem_trem']['error'] !== UPLOAD_ERR_NO_FILE
) {
    $arquivo = $_FILES['imagem_trem'];

    if ($arquivo['error'] !== UPLOAD_ERR_OK) {
        responder(false, 'Erro no envio da imagem.', 422);
    }

    if ($arquivo['size'] > 5 * 1024 * 1024) {
        responder(false, 'A imagem deve ter no máximo 5 MB.', 422);
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($arquivo['tmp_name']);

    $extensoes = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp'
    ];

    if (!isset($extensoes[$mime])) {
        responder(false, 'Use uma imagem JPG, PNG ou WEBP.', 422);
    }

    if (!is_dir($diretorio) &&
        !mkdir($diretorio, 0755, true) &&
        !is_dir($diretorio)) {
        responder(false, 'Não foi possível criar a pasta de imagens.', 500);
    }

    $nome = bin2hex(random_bytes(16)) . '.' . $extensoes[$mime];
    $destino = $diretorio . $nome;

    if (!move_uploaded_file($arquivo['tmp_name'], $destino)) {
        responder(false, 'Não foi possível salvar a imagem.', 500);
    }

    $nova_imagem = '../../assets/img/trens/' . $nome;
    $imagem = $nova_imagem;
}

try {
    $stmt = $conexao->prepare(
        'UPDATE trem
         SET prefixo_trem = ?,
             modelo_trem = ?,
             ano_trem = ?,
             status_trem = ?,
             imagem_trem = ?,
             id_linha = ?
         WHERE id_trem = ?'
    );

    $stmt->bind_param(
        'ssissii',
        $prefixo,
        $modelo,
        $ano,
        $status,
        $imagem,
        $linha,
        $id
    );

    $stmt->execute();
    $stmt->close();

    if ($nova_imagem !== null && !empty($atual['imagem_trem'])) {
        $prefixo_upload = '../../assets/img/trens/';

        if (strpos($atual['imagem_trem'], $prefixo_upload) === 0) {
            $antiga = $diretorio . basename($atual['imagem_trem']);

            if (is_file($antiga)) {
                unlink($antiga);
            }
        }
    }

    responder(true, 'Trem atualizado com sucesso.');

} catch (Throwable $e) {
    if ($destino !== null && is_file($destino)) {
        unlink($destino);
    }

    error_log($e->getMessage());
    responder(false, 'Não foi possível atualizar o trem.', 500);
}
