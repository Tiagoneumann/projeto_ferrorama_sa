const criar = document.getElementById("criar_trem");
const painelTrem = document.getElementById("trem");

criar.addEventListener("click", async () => {
    try {
        const resposta = await fetch("../../assets/html/criar_trem.php");

        if (!resposta.ok) {
            throw new Error("Não foi possível carregar o formulário.");
        }

        painelTrem.innerHTML = await resposta.text();
    } catch (erro) {
        alert(erro.message);
    }
});

document.addEventListener("click", async (evento) => {
    if (evento.target.closest("#fechar_conta")) {
        painelTrem.innerHTML = "";
        return;
    }

    const botao = evento.target.closest("[data-acao-trem]");

    if (!botao) return;

    const id = botao.dataset.idTrem;
    const acao = botao.dataset.acaoTrem;

    if (!id) {
        alert("Não foi possível identificar o trem selecionado.");
        return;
    }

    if (acao === "editar") {
        try {
            const resposta = await fetch(
                `../../assets/html/manipular_trem.php?id_trem=${encodeURIComponent(id)}`
            );

            const html = await resposta.text();

            if (!resposta.ok) {
                throw new Error(html || "Não foi possível encontrar o trem.");
            }

            painelTrem.innerHTML = html;
        } catch (erro) {
            alert(erro.message);
        }

        return;
    }

    if (acao === "excluir") {
        const confirmar = window.confirm(
            "Tem certeza de que deseja excluir este trem?"
        );

        if (!confirmar) return;

        try {
            const dados = new FormData();
            dados.append("id_trem", id);

            const resposta = await fetch("../../assets/php/excluir_trem.php", {
                method: "POST",
                body: dados
            });

            const resultado = await resposta.json();

            if (!resposta.ok || !resultado.sucesso) {
                throw new Error(
                    resultado.mensagem || "Não foi possível excluir o trem."
                );
            }

            // Retira o card da tela sem recarregar a página.
            botao.closest(".card")?.remove();
            painelTrem.innerHTML = "";

            alert(resultado.mensagem);

        } catch (erro) {
            alert(erro.message || "Erro ao comunicar com o servidor.");
        }
    }
});

// Envia o formulário de edição sem navegar para outra página.
document.addEventListener("submit", async (evento) => {
    const formulario = evento.target.closest(".form_trem");

    if (!formulario) return;

    evento.preventDefault();

    const botaoEnviar = formulario.querySelector(
        'button[type="submit"]'
    );

    if (botaoEnviar) botaoEnviar.disabled = true;

    try {
        const resposta = await fetch(formulario.action, {
            method: "POST",
            body: new FormData(formulario)
        });

        const resultado = await resposta.json();

        if (!resposta.ok || !resultado.sucesso) {
            throw new Error(
                resultado.mensagem || "Não foi possível atualizar o trem."
            );
        }

        alert(resultado.mensagem);

        // Atualiza os cards mantendo o usuário na mesma página.
        window.location.reload();

    } catch (erro) {
        alert(erro.message || "Erro ao salvar as alterações.");

        if (botaoEnviar) botaoEnviar.disabled = false;
    }
});