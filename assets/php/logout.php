<?php

session_start();

session_unset();

session_destroy();

header('Location: ../../pages/tela_inicial/index.php');
exit;

?>