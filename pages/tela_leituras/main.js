async function atualizarLeituras() {

    try {

        const resposta = await fetch('../../assets/php/buscar_leituras.php');

        if (!resposta.ok) {
            throw new Error('Erro ao buscar leituras.');
        }

        const leituras = await resposta.json();

        const lista = document.getElementById('lista_leituras');

        lista.innerHTML = '';

        if (leituras.length > 0) {

            leituras.forEach(leitura => {

                const linha = document.createElement('tr');

                linha.classList.add('leitura_item');

                const data = new Date(
                    leitura.registro_sensor.replace(' ', 'T')
                );

                const dataFormatada = data.toLocaleString('pt-BR');

                const valores = [
                    leitura.prefixo_trem,
                    leitura.codigo_sensor,
                    `${leitura.valor_sensor} ${leitura.unidade_sensor}`,
                    dataFormatada
                ];

                valores.forEach(valor => {

                    const coluna = document.createElement('td');

                    coluna.textContent = valor;

                    linha.appendChild(coluna);

                });

                lista.appendChild(linha);

            });

        } else {

            lista.innerHTML = `
                <tr>
                    <td class="mensagem" colspan="4"><small>Nenhuma leitura encontrada!</small></td>
                </tr>
            `;

        }

    } catch (erro) {

        console.error('Erro ao atualizar leituras:', erro);

    }

}

async function carregarLeituras() {
    try {
        await fetch('../../assets/php/simular_leituras.php');

        atualizarLeituras();

    } catch (erro) {
        console.error('Erro ao atualizar leituras:', erro);
    }
}

setInterval(carregarLeituras, 3000);
carregarLeituras();

//Campo de pesquisa

const campoPesquisa = document.getElementById('pesquisa_leitura');

const leituras = document.querySelectorAll('.leitura_item');

campoPesquisa.addEventListener('input', function () {

    const pesquisa = campoPesquisa.value.toLowerCase().trim();

    leituras.forEach(leituras => {

        const dadosLeituras = leituras.textContent.toLowerCase();

        if (dadosLeituras.includes(pesquisa)) {
            leituras.style.display = '';
        } else {
            leituras.style.display = 'none';
        }

    });

});