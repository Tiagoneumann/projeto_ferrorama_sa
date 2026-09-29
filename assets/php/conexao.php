<?php

//Cria variáveis com as informações necessárias para a conexão com o banco de dados
$servidor = 'localhost';
$usuario = 'root';
$senha = '';
$banco = 'trackflow_sa';

//Cria uma variável que se conecta com o banco de dados usando aquelas variáveis
$conexao = new mysqli($servidor, $usuario, $senha, $banco);

//Se a conexão com der errado ele vai exibir uma mensagem de erro, informando qual é o erro
if($conexao->connect_error){
    die("Falha na conexão: ". $conexao->connect_error);
}

//Permite a utilização de outros caracteres
$conexao->set_charset('utf8mb4');
?>