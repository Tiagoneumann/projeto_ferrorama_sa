<?php

session_start();

require 'conexao.php';

$id_trem = filter_input(INPUT_POST, 'id_trem', FILTER_VALIDATE_INT);

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

$sql = "DELETE FROM trem WHERE id_trem = ?";

$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_trem);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    if (!empty($trem['imagem_trem'])) {

        $caminho_imagem = __DIR__ . '/../../assets/img/trens/' .
            basename($trem['imagem_trem']);

        if (is_file($caminho_imagem)) {
            unlink($caminho_imagem);
        }
    }

    header('Location: ../../pages/tela_trens/tela_trens.php?sucesso=excluido');
} else {
    header('Location: ../../pages/tela_trens/tela_trens.php?erro=nao_encontrado');
}

$stmt->close();
$conexao->close();
exit;

?>