# Wiki do Projeto

Bem-vindo a wiki do projeto **Multiverso Battle**.

Este projeto e uma tela de selecao de personagens em estilo de jogo de luta, feita com **Laravel**, **Blade**, **CSS** e **JavaScript**. A interface principal fica em [resources/views/selection.blade.php](../resources/views/selection.blade.php), com a rota inicial definida em [routes/web.php](../routes/web.php).

## Paginas

- [Instalacao e Execucao](Instalacao-e-Execucao.md)
- [Estrutura do Projeto](Estrutura-do-Projeto.md)
- [Fluxo da Tela de Selecao](Fluxo-da-Tela-de-Selecao.md)
- [Assets e Mapeamentos](Assets-e-Mapeamentos.md)
- [API de Processamento de Imagens](API-de-Processamento-de-Imagens.md)

## Resumo rapido

- A pagina inicial abre a tela de selecao de personagens.
- Os personagens sao montados dinamicamente a partir de imagens em `public/`.
- A experiencia inclui hover, selecao, tela VS e batalha.
- Ha uma API auxiliar para processar imagens com remove.bg.
