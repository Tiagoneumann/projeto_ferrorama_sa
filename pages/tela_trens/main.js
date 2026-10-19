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

const imagem_trem = document.getElementById('imagem_trem');
const area_colar_imagem = document.getElementById('area_colar_imagem');
const previa_imagem = document.getElementById('previa_imagem');

function mostrar_previa(arquivo) {
    if (!arquivo || !arquivo.type.startsWith('image/')) {
        alert('Selecione ou cole um arquivo de imagem.');
        return;
    }

    const tipos_permitidos = [
        'image/jpeg',
        'image/png',
        'image/webp'
    ];

    if (!tipos_permitidos.includes(arquivo.type)) {
        alert('Use uma imagem JPG, PNG ou WEBP.');
        return;
    }

    if (arquivo.size > 5 * 1024 * 1024) {
        alert('A imagem deve ter no máximo 5 MB.');
        return;
    }

    const transferencia = new DataTransfer();
    transferencia.items.add(arquivo);
    imagem_trem.files = transferencia.files;

    previa_imagem.src = URL.createObjectURL(arquivo);
    previa_imagem.hidden = false;
}

imagem_trem.addEventListener('change', () => {
    mostrar_previa(imagem_trem.files[0]);
});

area_colar_imagem.addEventListener('paste', (evento) => {
    const itens = evento.clipboardData.items;

    for (const item of itens) {
        if (item.type.startsWith('image/')) {
            const arquivo = item.getAsFile();

            if (arquivo) {
                mostrar_previa(arquivo);
                evento.preventDefault();
                return;
            }
        }
    }

    alert('Não foi encontrada uma imagem na área de transferência.');
});

area_colar_imagem.addEventListener('click', () => {
    area_colar_imagem.focus();
});
