# Estrutura do Projeto

## Visao geral

O projeto segue uma estrutura padrao de Laravel, com foco na tela principal de selecao e em um pequeno servico de processamento de imagens.

## Arquivos principais

- [routes/web.php](../routes/web.php) define a rota da tela principal.
- [resources/views/selection.blade.php](../resources/views/selection.blade.php) contem a interface, os estilos e o script da experiencia.
- [routes/api.php](../routes/api.php) expõe as rotas da API de processamento.
- [app/Http/Controllers/ImageProcessingController.php](../app/Http/Controllers/ImageProcessingController.php) recebe as requisicoes da API.
- [app/Services/RemoveBgService.php](../app/Services/RemoveBgService.php) integra com a API remove.bg.

## Pastas de assets

- `public/Gifs Personagens/` armazena os GIFs usados como retrato/preview dos personagens.
- `public/` tambem guarda as imagens de icones/capas no nivel raiz.
- `public/sons/` contem trilha, efeitos e falas dos personagens.

## Observacao de arquitetura

A tela de selecao nao depende de controller dedicado. O Blade monta a lista de personagens lendo arquivos diretamente do `public/`, o que simplifica a manutencao dos assets para o contexto deste projeto educacional.
