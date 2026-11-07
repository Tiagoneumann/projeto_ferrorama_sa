
<?php

session_start();

require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $erro = '';

    $origem = trim($_POST['origem_rota']);
    $destino = trim($_POST['destino_rota']);
    $data = $_POST['data_rota'];
    $partida = $_POST['horario_partida'];
    $chegada = $_POST['horario_chegada'];
    $trem = $_POST['trem_rota'];
    $linha = $_POST['linha_rota'];
    $status = $_POST['status_rota'] ?? '';

    if (
        $origem === '' ||
        $destino === '' ||
        $data === '' ||
        $partida === '' ||
        $chegada === '' ||
        $trem === '' ||
        $linha === '' ||
        $status === ''
    ) {

        $erro = "Preencha todos os campos!";

    } elseif ($origem === $destino) {

        $erro = "A origem e o destino não podem ser iguais!";

    } elseif (!in_array($status, ['programada', 'em andamento', 'concluida', 'cancelada'], true)) {

        $erro = "Status da rota inválido!";

    } else {

        $sql = "INSERT INTO rota (
                    origem_rota,
                    destino_rota,
                    data_rota,
                    horario_partida,
                    horario_chegada,
                    status_rota,
                    id_trem,
                    id_linha
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conexao->prepare($sql);

        $stmt->bind_param(
            'ssssssii',
            $origem,
            $destino,
            $data,
            $partida,
            $chegada,
            $status,
            $trem,
            $linha
        );

        if ($stmt->execute()) {

            header('Location: ../../pages/tela_rotas/tela_rotas.php?cadastro_rota=sucesso');
            exit;

        } else {

            $erro = "Erro ao realizar a criação da rota!";

        }

        $stmt->close();
    }

    if ($erro !== '') {

        $_SESSION['erro_rota'] = $erro;

        header('Location: ../../pages/tela_rotas/tela_rotas.php?cadastro_rota=erro');
        exit;

    }
}

?>
