const linha = document.getElementById('linha')

document.querySelectorAll('#criar_linha').forEach(criar_linha => {
    criar_linha.addEventListener('click', () => {

        fetch("../../assets/html/criar_linha.php")
            .then(resposta => resposta.text())
            .then(html => {

                linha.innerHTML = html;

                const btn_fechar = document.getElementById('fechar_conta')

                btn_fechar.addEventListener('click', () => {
                linha.innerHTML = '';
            });
        })
    })
})

document.querySelectorAll('#criar_rota').forEach(criar_rota => {
    criar_rota.addEventListener('click', () => {

        fetch("../../assets/html/criar_rota.php")
            .then(resposta => resposta.text())
            .then(html => {

                linha.innerHTML = html;

                const btn_fechar = document.getElementById('fechar_conta')

                btn_fechar.addEventListener('click', () => {
                linha.innerHTML = '';
            });
        })
    })
})

document.querySelectorAll('#editar_rota').forEach(editar_rota => {
    editar_rota.addEventListener('click', () => {

        const id_rota = editar_rota.dataset.id;

        fetch(`../../assets/html/manipular_rota.php?id_rota=${id_rota}`)
            .then(resposta => resposta.text())
            .then(html => {

                linha.innerHTML = html;

                const btn_fechar = document.getElementById('fechar_conta')

                btn_fechar.addEventListener('click', () => {
                linha.innerHTML = '';
            });
        })
    })
})

//campo de pesquisa das rotas

const campoPesquisa = document.getElementById('pesquisa_rota');

const rotas = document.querySelectorAll('.rota_item');

campoPesquisa.addEventListener('input', function () {

    const pesquisa = campoPesquisa.value.toLowerCase().trim();

    rotas.forEach(rota => {

        const dadosRotas = rota.textContent.toLowerCase();

        if (dadosRotas.includes(pesquisa)) {
            rota.style.display = '';
        } else {
            rota.style.display = 'none';
        }

    });

});