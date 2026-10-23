
<?php

require 'conexao.php';

header('Content-Type: application/json; charset=utf-8');

function responder($sucesso, $mensagem, $codigo = 200)
{
    http_response_code($codigo);

    echo json_encode([
        'sucesso' => $sucesso,
        'mensagem' => $mensagem
    ], JSON_UNESCAPED_UNICODE);

    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = filter_input(INPUT_POST, 'id_trem', FILTER_VALIDATE_INT);

    if (!$id || $id < 1) {
        responder(false, 'ID do trem inválido.', 422);
    }

    try {
        $stmt = $conexao->prepare('SELECT imagem_trem FROM trem WHERE id_trem = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $trem = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if (!$trem) {
            responder(false, 'Trem não encontrado.', 404);
        }

        $stmt = $conexao->prepare('DELETE FROM trem WHERE id_trem = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();

        $imagem = $trem['imagem_trem'] ?? '';
        $prefixo_upload = '../../assets/img/trens/';

        if (strpos($imagem, $prefixo_upload) === 0) {
            $diretorio = '../../assets/img/trens/';
            $caminho = $diretorio . basename($imagem);

            if (is_file($caminho)) {
                unlink($caminho);
            }
        }

        responder(true, 'Trem excluído com sucesso.');
    } catch (Throwable $e) {
        error_log($e->getMessage());
        responder(false, 'Não foi possível excluir o trem.', 500);
    }
}
