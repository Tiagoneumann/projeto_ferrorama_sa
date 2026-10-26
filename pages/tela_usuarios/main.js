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

document.querySelectorAll('.editar_usuario').forEach(botao => {

    botao.addEventListener('click', () => {

        const id_usuario = botao.dataset.id;

        fetch(`../../assets/html/manipular_usuario.php?id_usuario=${id_usuario}`)
            .then(resposta => resposta.text())
            .then(html => {

                conta.innerHTML = html;

                const btn_fechar = document.getElementById('fechar_conta');

                btn_fechar.addEventListener('click', () => {
                    conta.innerHTML = '';
                });
            });
    });
});