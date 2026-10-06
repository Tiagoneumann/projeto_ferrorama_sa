const criar = document.getElementById('criar_usuario');
const conta = document.getElementById('conta');

criar.addEventListener('click', () => {

    fetch("../../assets/html/criar_usuario.php")
        .then(resposta => resposta.text())
        .then(html => {

            conta.innerHTML = html;

            const btn_fechar = document.getElementById('fechar_conta');

            btn_fechar.addEventListener('click', () => {
                conta.innerHTML = '';
            });

        });

})