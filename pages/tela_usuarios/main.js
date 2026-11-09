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

//Código de pesquisa

const campoPesquisa = document.getElementById('pesquisa_usuarios');

const usuarios = document.querySelectorAll('.usuario_item');

campoPesquisa.addEventListener('input', function () {

    const pesquisa = campoPesquisa.value.toLowerCase().trim();

    usuarios.forEach(usuario => {

        const dadosUsuario = usuario.textContent.toLowerCase();

        if (dadosUsuario.includes(pesquisa)) {
            usuario.style.display = '';
        } else {
            usuario.style.display = 'none';
        }

    });

});