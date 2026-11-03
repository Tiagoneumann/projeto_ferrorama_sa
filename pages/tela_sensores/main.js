const sensor = document.getElementById('sensor');

document.querySelectorAll('#criar').forEach(criar => {
    criar.addEventListener('click', () => {

    fetch("../../assets/html/criar_sensor.php")
        .then(resposta => resposta.text())
        .then(html => {

            sensor.innerHTML = html;

            const btn_fechar = document.getElementById('fechar_conta');

            btn_fechar.addEventListener('click', () => {
                sensor.innerHTML = '';
            });
        });
    })
})

document.querySelectorAll('#editar').forEach(editar => {
    editar.addEventListener('click', () => {

        const id_sensor = editar.dataset.id;

        fetch(`../../assets/html/manipular_sensor.php?id_sensor=${id_sensor}`)
            .then(resposta => resposta.text())
            .then(html => {

                sensor.innerHTML = html;

                const btn_fechar = document.getElementById('fechar_conta');

                btn_fechar.addEventListener('click', () => {
                    sensor.innerHTML = '';
                });
            });
    });
})