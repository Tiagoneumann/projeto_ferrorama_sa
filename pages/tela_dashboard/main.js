const range = document.querySelector('input[type="range"]');

function setProgress(value) {
  range.value = value;
  range.style.setProperty('--progress', `${value}%`);
  range.nextElementSibling.textContent = `${value}%`;
}

// campo pesquisa dos trens

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

// campo de pesquisa das leituras

const campoPesquisaLeituras = document.getElementById('pesquisa_leituras');

const leituras = document.querySelectorAll('.leitura_item');

campoPesquisaLeituras.addEventListener('input', function () {

    const pesquisa = campoPesquisaLeituras.value.toLowerCase().trim();

    leituras.forEach(leitura => {

        const dadosLeituras = leitura.textContent.toLowerCase();

        if (dadosLeituras.includes(pesquisa)) {
            leitura.style.display = '';
        } else {
            leitura.style.display = 'none';
        }

    });

});