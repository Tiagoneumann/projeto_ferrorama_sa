const criar = document.getElementById("criar_trem");
const trem = document.getElementById("trem");

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