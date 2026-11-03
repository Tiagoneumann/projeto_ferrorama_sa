<?php

session_start();

require 'conexao.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $id_sensor = filter_input(INPUT_POST, 'id_sensor', FILTER_VALIDATE_INT);

    $codigo = $_POST['codigo_sensor'];
    $tipo = $_POST['tipo_sensor'];
    $unidade = $_POST['unidade_sensor'];
    $trem = $_POST['id_trem'];

}

?>