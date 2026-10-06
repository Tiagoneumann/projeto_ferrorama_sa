<?php

session_start();

require 'conexao.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $sql = "DELETE FROM usuario WHERE email_usuario = ?";

    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $_SESSION['email_usuario']);
    $stmt->execute();
    $stmt->close();

    header('Location: ../../pages/tela_inicio/tela_inicio.php');
    exit();

}

?>