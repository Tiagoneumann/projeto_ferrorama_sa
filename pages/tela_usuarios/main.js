const conta = document.getElementById('conta');

document.querySelectorAll('#criar').forEach(criar => {
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
})


document.querySelectorAll('#editar').forEach(editar => {
    editar.addEventListener('click', () => {

        const id_usuario = editar.dataset.id;

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