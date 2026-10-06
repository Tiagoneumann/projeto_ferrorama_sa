const btn_menu = document.getElementById('btn_menu');
const menu_navbar = document.querySelector('.menu_navbar');

const perfil = document.getElementById('perfil');
const usuario = document.getElementById('usuario');

btn_menu.addEventListener('click', () => {
    menu_navbar.classList.toggle('ativo');
});

perfil.addEventListener('click', () => {

    fetch("../../assets/html/usuario.php")
        .then(resposta => resposta.text())
        .then(html => {

            usuario.innerHTML = html;

            const btn_fechar = document.getElementById('fechar_conta');

            btn_fechar.addEventListener('click', () => {
                usuario.innerHTML = '';
            });

        });

});

