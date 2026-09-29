<?php

// Inicia a sessão, permitindo armazenar dados que permanecerão disponíveis
// enquanto o usuário navega pelo site.
session_start();

//Linka com arquivo de conexao 
require '../../assets/php/conexao.php';

//Se a página receber uma requisição usando o método POST, significa que o formulário foi enviado via POST, então execute o código abaixo.
if($_SERVER['REQUEST_METHOD'] === 'POST'){

    //Variável usada para informar erros
    $erro = "";

    //Variáveis para pegar os dados inseridos pelo usuário
    $email = trim($_POST['email_usuario']);
    $senha = $_POST['senha_usuario'];

    //Verifica se há algum campo vazio
    if(empty($email) || empty($senha)){

        //Informa o erro
        $erro = "Preencha todos os campos!";

    } else{

        //Cria uma variável que contém o comando de busca do sql
        $sql = "SELECT * FROM usuario WHERE email_usuario = ? LIMIT 1";

        //Prepara a instrução sql para ser executado quando chamada
        $stmt = $conexao->prepare($sql);

        //Informa a variável (?) do comando de busca do sql com base nas infromações de email inseridas pelo usuário
        $stmt->bind_param("s", $email);

        //Executa a busca
        $stmt->execute();

        //Pega o resultado da busca
        $resultado = $stmt->get_result();

        //Transforma eles em uma array (linha onde tem vários dados diferentes) usuário
        $usuario = $resultado->fetch_assoc();

        //Se o não existir (!) usuário, ele exibi uma mensagem de erro
        if(!$usuario) {

            $erro = "Usuário ou senha incorretos!";

        } else {

            //Se a senha for a mesma do banco de dados ele executa o comando
            if (password_verify($senha, $usuario['senha_usuario'])){

                //Pega os dados disponibilizados e deixa eles armazenados no session_start(), podendo usar eles depois em outras páginas
                $_SESSION['id_usuario'] = $usuario['id_usuario'];
                $_SESSION['email_usuario'] = $usuario['email_usuario'];
                $_SESSION['nome_usuario'] = $usuario['nome_usuario'];
                $_SESSION['tipo_usuario'] = $usuario['tipo_usuario'];

                //Manda pra página de dashboard
                header("Location: ../tela_dashboard/index.php");
                exit;
                
            } else {

                $erro = "Usuário ou senha incorretos!";

            }
        }

        //Corta a instrução
        $stmt->close();
    }
}


?>