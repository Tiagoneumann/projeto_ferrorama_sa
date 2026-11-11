const relatorio = document.getElementById('relatorio');

document.querySelectorAll('#visualizar_relatorio').forEach(visualizar_relatorio => {
    visualizar_relatorio.addEventListener('click', () => {

        const id_relatorio = visualizar_relatorio.dataset.id;

        fetch(`../../assets/html/visualizar_relatorio.php?id_relatorio=${id_relatorio}`)
            .then(resposta => resposta.text())
            .then(html => {

                relatorio.innerHTML = html;

                const btn_fechar = document.getElementById('fechar_conta')

                btn_fechar.addEventListener('click', () => {
                relatorio.innerHTML = '';
            });
        })
    })
})

function imprimirRelatorio() {
    const relatorio = document.querySelector('.relatorio');
    const original = relatorio.parentNode;
    const proximo = relatorio.nextSibling;

    document.body.appendChild(relatorio);

    window.print();

    original.insertBefore(relatorio, proximo);
}