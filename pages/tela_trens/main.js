const criar = document.getElementById('criar_trem');
const trem = document.getElementById('trem');

criar.addEventListener('click', () => {

    fetch("../../assets/html/criar_trem.php")
        .then(resposta => resposta.text())
        .then(html => {

            trem.innerHTML = html;

            const btn_fechar = document.getElementById('fechar_conta');

            btn_fechar.addEventListener('click', () => {
                trem.innerHTML = '';
            });
        });
})

document.querySelectorAll('#editar_trem').forEach(botao => {

    botao.addEventListener('click', () => {

        const id_trem = botao.dataset.id;

        fetch(`../../assets/html/manipular_trem.php?id_trem=${id_trem}`)
            .then(resposta => resposta.text())
            .then(html => {

                trem.innerHTML = html;

                const btn_fechar = document.getElementById('fechar_conta');

                btn_fechar.addEventListener('click', () => {
                    trem.innerHTML = '';
                });
            });
    });
});