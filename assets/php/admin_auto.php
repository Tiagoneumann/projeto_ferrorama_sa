<?php

if($_SESSION['tipo_usuario'] !== 'admin'){
    http_response_code(403);
    echo 'Acesso negado.';
    exit;
}

?>