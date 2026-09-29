const btn_menu = document.getElementById('btn_menu');
const menu_navbar = document.querySelector('.menu_navbar');

const conta = document.getElementById('perfil');

btn_menu.addEventListener('click', () => {
    menu_navbar.classList.toggle('ativo');
});

