<?php

session_start();

?>

<div class="conta">
    <div class="bloco_conta estilo_primario">
        <div class="ajuste_conta">
            <h1>Novo usuário</h1>
            <button class="btn_fechar" id="fechar_conta"><i class="fa-solid fa-x"></i></button>
        </div>
                
        <div class="bloco_conta estilo_secundario">
            <form action="../../assets/php/criar_usuario.php" method='POST'>
                <div class="separacao">
                    <input class="input_padrao" type="text" name="nome_usuario" placeholder="Nome">

                    <input class="input_padrao" type="email" name="email_usuario" placeholder="Email">

                    <input class="input_padrao" type="passwoard" name="senha_usuario" placeholder="Senha">

                    <div class="opcoes_usuario">
                        <label>
                            <input type="radio" name="tipo_usuario" value="usuario">
                            Usuário
                        </label>
                        <label>
                            <input type="radio" name="tipo_usuario" value="admin">
                            Admin
                        </label>
                    </div>
                </div>

                    <button class="botao extensao_botao">Criar conta</button>
            </form>             
        </div>
    </div>     
</div>