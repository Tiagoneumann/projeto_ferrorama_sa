<h1 align="center">Planejamento de implementação - S.A. Ferrorama</h1>

<br>

<h2>Seção 1 — Identificação e visão geral.</h2> 

**Integrantes:** Tiago Neumann, Murilo Valduga, Lucas Sombrio e Guilherme Manske.

<h3 align="center"><strong>Resumo:</strong></h3>
O sistema desenvolvido integra-se à empresa Track Flow e tem como principal objetivo realizar o monitoramento inteligente da frota ferroviária em tempo real. A plataforma permite acompanhar o status dos trens, sensores e ocorrências operacionais, auxiliando clientes, operadores e gestores na tomada de decisões rápidas e eficientes.

<p>&emsp;&emsp;</p>

<h3 align="center"><strong>Desisão Técnica:</strong></h3>

**HTML**
    - O básico para a estruturação do site e para o implementação de elementos.
**CSS puro**
    - O básico para a estilização do site;
    - Decidimos não usar Bootstrap para não ficar preso a elementos já moldados, tendo mais versatilidade, a custo de mais trabalho.
**JavaScript puro**
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

1. Header de navegação -
Telas em que aparece: Todas as telas internas.
Variações observadas: Diferentes títulos de página, mantendo logo, menu lateral e perfil do usuário.

2. Campos de formulário -
Telas em que aparece: Login, Cadastro, Relatório.
Variações observadas: Campos de texto, e-mail, senha e descrição.

3. Card de informação -
Telas em que aparece: Dashboard, Sensores, Linha dos Trens.
Variações observadas: Com imagem, sem imagem e com informações resumidas.

4. Card de linha de trem -
Telas em que aparece: Linha dos Trens.
Variações observadas: Visualização resumida e detalhada.

5. Botão primário -
Telas em que aparece: Login, Cadastro, Relatório, Linha dos Trens.
Variações observadas: Textos diferentes, como Entrar, Cadastrar, Enviar Relatório e Ver Histórico.

6. Card de sensor -
Telas em que aparece: Sensores.
Variações observadas: Status OK, Atenção e Crítico.

7. Sidebar/Menu lateral -
Telas em que aparece: Todas as telas internas.
Variações observadas: Menu aberto e menu recolhido.

8. Tabela/Listagem - 
Telas em que aparece: Lista de Usuários e históricos.
Variações observadas: Diferentes quantidades de registros e paginação.

9. Indicadores de status -
Telas em que aparece: Dashboard, Sensores, Linha dos Trens.
Variações observadas: Status OK, Atenção e Crítico.

10. Logo institucional -
Telas em que aparece: Todas as telas.
Variações observadas: Aplicação na tela inicial e no cabeçalho das páginas internas.

<h2>Seção 4 — Ordem de implementação</h2> 
Tela de Boas-vindas <br>
É a porta de entrada do sistema e possui poucas dependências, utilizando apenas componentes básicos de layout e botões. <br>

<br>
Tela de Login <br>
Necessária para autenticar o usuário antes de acessar as funcionalidades internas do sistema.

Dependências:
- Botões
- Campos de formulário

<br>
Tela de Cadastro

Permite o registro de novos usuários e utiliza os mesmos componentes desenvolvidos para o login. <br>
Dependências:
- Botões
- Campos de formulário

<br>
Estrutura Principal de Navegação

Após a autenticação, é necessário implementar a estrutura que será compartilhada pelas telas internas.
Dependências:
- Header
- Sidebar/Menu lateral

<br>
Tela Linha dos Trens

Apresenta as linhas monitoradas pelo sistema e serve como base para a consulta das informações operacionais dos trens. <br>
Dependências:
- Header;
- Sidebar/Menu lateral;
- Cards de informação;
- Botões.

<br>
Tela de Sensores

Permite o monitoramento dos sensores instalados nos trens e utiliza indicadores visuais para demonstrar o estado de funcionamento.
<br>
Dependências:
- Header;
- Sidebar/Menu lateral;
- Card de sensor;
- Indicadores de status.

<br>
Dashboard

Centraliza as principais informações do sistema em uma única tela, reunindo dados das linhas de trem e dos sensores.
<br>
Dependências:
- Linha dos Trens;
- Sensores;
- Cards de informação;
- Indicadores de status;
- Gráficos.

<br>
Tela de Relatórios

Permite gerar relatórios operacionais utilizando as informações coletadas pelo sistema.<br>
Dependências:
- Campos de formulário;
- Botões;
- Dados de trens e sensores.

<br>
Lista de Usuários

Possibilita a visualização e o gerenciamento dos usuários cadastrados no sistema.<br>
Dependências:
- Cadastro de usuários;
- Tabela/Listagem.

<h2>Seção 5 — Fluxos de navegação do usuário</h2> 


**Fluxo 1: Cadastrar-se e acessar o sistema pela primeira vez**

Perfil: Novo usuário

Tela de Login, clica em "Criar conta"

Tela de Cadastro, preenche nome, e-mail, usuário e senha - clica em "Cadastrar"

Sistema exibe mensagem de sucesso

Tela de Login, informa usuário e senha - clica em "Entrar"

Dashboard, visualiza a visão geral do sistema


<br>

**Fluxo 2: Operador identifica um sensor crítico**

Perfil: Operador

Tela de Login, realiza autenticação

Dashboard, identifica alerta de sensor crítico

Tela de Sensores, seleciona o sensor em estado crítico

Sistema exibe detalhes da leitura e do status do sensor

Tela Linha dos Trens, visualiza informações do trem associado ao sensor

Operador analisa a situação e toma as medidas necessárias


<br>

**Fluxo 3: Administrador cadastra um novo usuário**

Perfil: Administrador

Tela de Login, realiza autenticação

Menu lateral, acessa "Lista de Usuários"

Lista de Usuários, clica em "Adicionar Usuário"

Tela de Cadastro, preenche os dados do novo usuário

Sistema valida as informações

Usuário é cadastrado com sucesso e passa a aparecer na lista de usuários


<br>

**Fluxo 4: Técnico gera um relatório de falhas**

Perfil: Técnico

Tela de Login, realiza autenticação

Menu lateral, acessa "Relatório"

Tela de Relatório, preenche as informações solicitadas e seleciona o período desejado

Clica em "Enviar Relatório"

Sistema processa os dados e gera o relatório

Técnico visualiza as informações para análise e registro


<br>

**Fluxo 5: Operador consulta informações de uma linha de trem**

Perfil: Operador

Tela de Login, realiza autenticação

Menu lateral, acessa "Linha dos Trens"

Lista de Linhas, seleciona uma linha específica

Tela de Detalhes da Linha, visualiza horário de saída, horário de chegada e quantidade de passageiros

Operador acompanha o status operacional da linha selecionada


<br>

**Fluxo 6: Usuário encerra a sessão**

Perfil: Administrador, Operador ou Técnico

Qualquer tela interna, clica no ícone de perfil

Seleciona a opção "Sair"

Sistema encerra a sessão do usuário

Tela de Login é exibida novamente

<h2>Seção 6 — Critérios de "pronto"</h2>

Antes de uma tela ser considerada pronta, ela deve atender aos seguintes critérios de qualidade:

- [ ] HTML semântico (uso correto de header, main, section, nav e footer quando necessário).
- [ ] CSS organizado e sem utilização de estilos inline.
- [ ] Layout responsivo para dispositivos móveis (largura de 390px).
- [ ] Layout responsivo para desktop (largura de 1440px).
- [ ] Nenhum erro ou aviso crítico no console do navegador.
- [ ] Todos os links e botões direcionam para a tela correta.
- [ ] Componentes reutilizáveis seguem o padrão definido pelo projeto.
- [ ] Cores, tipografia e espaçamentos consistentes com o mockup.
- [ ] Formulários possuem validação básica dos campos obrigatórios.
- [ ] Imagens, ícones e logotipos carregam corretamente.
- [ ] Menu lateral e navegação funcionam corretamente em todas as telas.
- [ ] Código organizado de forma legível.
- [ ] Commit realizado com mensagem clara e descritiva.
- [ ] Tela aprovada pelo grupo após comparação com o mockup original.