s<?php

session_start();

require 'conexao.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $erro = '';

    $nome = $_POST['nome_linha'];

    if($nome === ''){

        $erro = "Preencha todos os campos!";

    } else {

        $sql = 'INSERT INTO linha (nome_linha) VALUES (?)';

        $stmt = $conexao->prepare($sql);
        $stmt->bind_param('s', $nome);

        if($stmt->execute()){

                header('Location: ../../pages/tela_rotas/tela_rotas.php?cadastro_linha=sucesso');
                exit;

            } else {

                $stmt->close();

                if($stmt->errno === 1062){

                    $erro = "Este linha já foi cadastrada!";

                } else {

                    $erro = "Erro ao realizar a criação do linha!";

                }
            }
    }
}

?>