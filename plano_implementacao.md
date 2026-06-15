<h1 align="center">Planejamento de implementação - S.A. Ferrorama</h1>

<br>

<h2>Seção 1 — Identificação e visão geral.</h2> 

**Integrantes:** Tiago Neumann, Murilo Valduga, Lucas Sombrio e Guilherme Manske.

<h3 align="center"><strong>Resumo:</strong></h3>

<p style="text-align: justify">&emsp;&emsp;O sistema desenvolvido integra-se à empresa Track Flow e tem como principal objetivo realizar o monitoramento inteligente da frota ferroviária em tempo real. A plataforma permite acompanhar o status dos trens, sensores e ocorrências operacionais, auxiliando clientes, operadores e gestores na tomada de decisões rápidas e eficientes.</p>

<h3 align="center"><strong>Desisão Técnica:</strong></h3>

- **HTML**
    - O básico para a estruturação do site e para o implementação de elementos.
- **CSS puro**
    - O básico para a estilização do site;
    - Decidimos não usar Bootstrap para não ficar preso a elementos já moldados, tendo mais versatilidade, a custo de mais trabalho.
- **JavaScript puro**
    - O básico para manipular elementos e dados;
    - Decidimos não usar frameworks por não ter um conhecimento prévio do assunto.

**[Link do Mockup](https://www.figma.com/design/V6d076ac7UK5gpbaPYOrfq/Mock-Up-da-SA?node-id=0-1&m=dev&t=qxttX945e6QCSv85-1)**

<h2>Seção 2 — Arquitetura de arquivos e pastas</h2> 

```
projeto_ferrorama_sa/
├── assets/
|   ├── css/
|   |   └── global.css
|   ├── js/
|   |    ├── global.js
|   |    └── dados.js
|   ├── models/
|   |    └── modelos de estruturas
|   └── img/
|        └── imagens
├── pages/
|   ├── tela_inicial/
|   |   ├── index.html
|   |   ├── style.css
|   |   └── main.js
|   ├── tela_cadastro/
|   |   ├── index.html
|   |   ├── style.css
|   |   └──main.js
|   ├── tela_login/
|   |   ├── index.html
|   |   ├── style.css
|   |   └── main.js
|   ├── tela_dashboard/
|   |   ├── index.html
|   |   ├── style.css
|   |   └── main.js
|   ├── tela_relatorios/
|   |   ├── index.html
|   |   ├── style.css
|   |   └── main.js
|   ├── tela_sensores/
|   |   ├── index.html
|   |   ├── style.css
|   |   └── main.js
|   ├── tela_trens/
|   |   ├── index.html
|   |   ├── style.css
|   |   └── main.js
|   └── tela_usuario/
|       ├── index.html
|       ├── style.css
|       └── main.js
└── plano_implementacao.md

```


<h2>Seção 3 — Componentes reutilizáveis identificados</h2> 

<h2>Seção 4 — Ordem de implementação</h2> 

<h2>Seção 5 — Fluxos de navegação do usuário</h2> 

<h2>Seção 6 — Critérios de "pronto"</h2> 