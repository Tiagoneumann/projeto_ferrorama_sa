<?php

session_start();

require 'conexao.php';

if(!isset($_SESSION['id_usuario'])){

    header('Location: ../../pages/tela_inicial/index.php');
    exit;

}

$id_usuario = $_SESSION['id_usuario'];

$sql = 'SELECT id_usuario FROM usuario WHERE id_usuario = ? LIMIT 1';

$stmt = $conexao->prepare($sql);
$stmt->bind_param('s', $id_usuario);
$stmt->execute();

$resultado = $stmt->get_result();

if($resultado->num_rows === 0){

    session_unset();
    session_destroy();

    header("Location: ../../pages/tela_inicial/index.php");
    exit;

}

$stmt->close();

?>