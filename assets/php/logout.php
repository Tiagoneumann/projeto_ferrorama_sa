<?php

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    session_start();

    session_unset();

    session_destroy();

    header('Location: ../../pages/tela_inicial/tela_inicial.php');
    exit;

}

?>