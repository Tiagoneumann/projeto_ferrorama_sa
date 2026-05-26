const btn_menu = document.getElementById('btn_menu');

const menu_navbar = document.querySelector('.menu_navbar');

btn_menu.addEventListener('click', () => {
    menu_navbar.classList.toggle('ativo');
})

