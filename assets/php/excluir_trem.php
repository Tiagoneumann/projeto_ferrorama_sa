
<?php

session_start();

require 'conexao.php';

$id_trem = filter_input(INPUT_POST, 'id_trem', FILTER_VALIDATE_INT);

if (!$id_trem) {
    header('Location: ../../pages/tela_trens/tela_trens.php?erro=nao_encontrado');
    exit;
}

$sql = "SELECT imagem_trem FROM trem WHERE id_trem = ?";

$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_trem);
$stmt->execute();

$resultado = $stmt->get_result();
$trem = $resultado->fetch_assoc();

$stmt->close();

if (!$trem) {
    header('Location: ../../pages/tela_trens/tela_trens.php?erro=nao_encontrado');
    exit;
}

try {

    $conexao->begin_transaction();

    $sql = "DELETE FROM rota WHERE id_trem = ?";

    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $id_trem);
    $stmt->execute();
    $stmt->close();

    $sql = "DELETE FROM trem WHERE id_trem = ?";

    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $id_trem);
    $stmt->execute();

    $stmt->close();

    $conexao->commit();

    if (!empty($trem['imagem_trem'])) {

        $caminho_imagem = __DIR__ . '/../../assets/img/trens/' .
            basename($trem['imagem_trem']);

        if (is_file($caminho_imagem)) {
            unlink($caminho_imagem);
        }
    }

    header('Location: ../../pages/tela_trens/tela_trens.php?sucesso=excluido');

} catch (mysqli_sql_exception $erro) {

    $conexao->rollback();

    header('Location: ../../pages/tela_trens/tela_trens.php?erro=exclusao');
}

$conexao->close();
exit;

?>
