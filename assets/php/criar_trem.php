```php
<?php

session_start();

require_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../pages/tela_trens/tela_trens.php');
    exit;
}

$prefixo_trem = trim($_POST['prefixo_trem'] ?? '');
$modelo_trem = trim($_POST['modelo_trem'] ?? '');
$ano_trem = $_POST['ano_trem'] ?? '';
$id_linha = $_POST['linhas'] ?? '';
$status_trem = $_POST['status_trem'] ?? 'ativo';

if (
    $prefixo_trem === '' ||
    $modelo_trem === '' ||
    $ano_trem === ''
) {
    $_SESSION['erro_trem'] = 'Preencha todos os campos obrigatórios!';
    header('Location: ../../pages/tela_trens/tela_trens.php');
    exit;
}

if (
    filter_var($ano_trem, FILTER_VALIDATE_INT) === false ||
    (int) $ano_trem < 1800 ||
    (int) $ano_trem > 2100
) {
    $_SESSION['erro_trem'] = 'Informe um ano entre 1800 e 2100!';
    header('Location: ../../pages/tela_trens/tela_trens.php');
    exit;
}

$status_permitidos = ['ativo', 'manutencao', 'parado'];

if (!in_array($status_trem, $status_permitidos, true)) {
    $_SESSION['erro_trem'] = 'Status inválido!';
    header('Location: ../../pages/tela_trens/tela_trens.php');
    exit;
}

if (
    filter_var($id_linha, FILTER_VALIDATE_INT) === false ||
    (int) $id_linha <= 0
) {
    $_SESSION['erro_trem'] = 'Selecione uma linha válida!';
    header('Location: ../../pages/tela_trens/tela_trens.php');
    exit;
}

$id_linha = (int) $id_linha;

$sql_linha = "SELECT id_linha FROM linha WHERE id_linha = ?";
$stmt_linha = $conexao->prepare($sql_linha);

if (!$stmt_linha) {
    $_SESSION['erro_trem'] = 'Erro ao verificar a linha.';
    header('Location: ../../pages/tela_trens/tela_trens.php');
    exit;
}

$stmt_linha->bind_param('i', $id_linha);
$stmt_linha->execute();

$resultado_linha = $stmt_linha->get_result();
$linha_existe = $resultado_linha->num_rows > 0;

$stmt_linha->close();

if (!$linha_existe) {
    $_SESSION['erro_trem'] = 'A linha selecionada não existe!';
    header('Location: ../../pages/tela_trens/tela_trens.php');
    exit;
}

$caminho_imagem = null;

if (
    isset($_FILES['imagem_trem']) &&
    $_FILES['imagem_trem']['error'] !== UPLOAD_ERR_NO_FILE
) {
    $imagem = $_FILES['imagem_trem'];

    if ($imagem['error'] !== UPLOAD_ERR_OK) {
        $_SESSION['erro_trem'] = 'Erro ao enviar a imagem.';
        header('Location: ../../pages/tela_trens/tela_trens.php');
        exit;
    }

    if ($imagem['size'] > 5 * 1024 * 1024) {
        $_SESSION['erro_trem'] = 'A imagem deve ter no máximo 5 MB!';
        header('Location: ../../pages/tela_trens/tela_trens.php');
        exit;
    }

    $arquivo_temporario = $imagem['tmp_name'];

    $tipo_imagem = (new finfo(FILEINFO_MIME_TYPE))
        ->file($arquivo_temporario);

    $tipos_permitidos = ['image/jpeg' => 'jpg', 'image/png'  => 'png', 'image/webp' => 'webp'];

    if (!isset($tipos_permitidos[$tipo_imagem])) {
        $_SESSION['erro_trem'] = 'Envie uma imagem JPG, PNG ou WEBP!';
        header('Location: ../../pages/tela_trens/tela_trens.php');
        exit;
    }

    $pasta_imagens = '../../assets/img/trens/';

    if (
        !is_dir($pasta_imagens) &&
        !mkdir($pasta_imagens, 0755, true)
    ) {
        $_SESSION['erro_trem'] = 'Não foi possível criar a pasta de imagens.';
        header('Location: ../../pages/tela_trens/tela_trens.php');
        exit;
    }

    $nome_imagem = bin2hex(random_bytes(16))
        . '.' . $tipos_permitidos[$tipo_imagem];

    $destino = $pasta_imagens . $nome_imagem;

    if (!move_uploaded_file($arquivo_temporario, $destino)) {
        $_SESSION['erro_trem'] = 'Não foi possível salvar a imagem.';
        header('Location: ../../pages/tela_trens/tela_trens.php');
        exit;
    }

    $caminho_imagem = 'assets/img/trens/' . $nome_imagem;
}

$sql = "INSERT INTO trem (prefixo_trem, modelo_trem, ano_trem, status_trem, id_linha, imagem_trem) VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $conexao->prepare($sql);

if (!$stmt) {

    if ($caminho_imagem !== null) {
        @unlink($destino);
    }

    $_SESSION['erro_trem'] = 'Erro ao preparar o cadastro do trem.';
    header('Location: ../../pages/tela_trens/tela_trens.php');
    exit;
}

$ano_trem = (int) $ano_trem;

$stmt->bind_param('ssis is', $prefixo_trem, $modelo_trem, $ano_trem, $status_trem, $id_linha, $caminho_imagem);

if ($stmt->execute()) {

    $_SESSION['sucesso_trem'] = 'Trem cadastrado com sucesso!';

} else {

    if ($caminho_imagem !== null) {
        @unlink($destino);
    }

    $_SESSION['erro_trem'] = 'Não foi possível cadastrar o trem.';
}

$stmt->close();

header('Location: ../../pages/tela_trens/tela_trens.php');
exit;

?>
```