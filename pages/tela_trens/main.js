const criar = document.getElementById('criar_trem');
const trem = document.getElementById('trem');

document.querySelectorAll('#criar').forEach(criar => {
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
})

document.querySelectorAll('#editar').forEach(editar => {

    editar.addEventListener('click', () => {

        const id_trem = editar.dataset.id;

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

//campo de pesquisa

const campoPesquisa = document.getElementById('pesquisa_trens');

const trens = document.querySelectorAll('.trem_item');

campoPesquisa.addEventListener('input', function () {

    const pesquisa = campoPesquisa.value.toLowerCase().trim();

    trens.forEach(trem => {

        const dadosTrens = trem.textContent.toLowerCase();

        if (dadosTrens.includes(pesquisa)) {
            trem.style.display = '';
        } else {
            trem.style.display = 'none';
        }

    });

});