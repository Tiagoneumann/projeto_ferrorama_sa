<?php

session_start();

require 'conexao.php';

$id_usuario = filter_input(INPUT_GET, 'id_usuario', FILTER_VALIDATE_INT);

$sql = "SELECT id_usuario, nome_usuario, email_usuario, tipo_usuario FROM usuario WHERE id_usuario = ?";

$stmt = $conexao->prepare($sql);
$stmt->bind_param("s", $id_usuario);
$stmt->execute();

$resultado = $stmt->get_result();
$usuario = $resultado->fetch_assoc();

?>