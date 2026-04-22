# Assets e Mapeamentos

## Fontes de personagens

A lista de personagens e criada a partir da combinacao de duas fontes:

- imagens base em `public/` para os icones
- GIFs em `public/Gifs Personagens/` para os retratos maiores

## Mapeamento de nomes

Os nomes dos arquivos passam por normalizacao para reduzir problemas com acentos, espacos e simbolos. Quando o nome do GIF nao bate exatamente com o nome do icone, o projeto usa mapas manuais para resolver casos especiais.

Exemplos de mapeamento:

- `homemaranha` -> `spiderman`
- `tungtungtungtungsahur` -> `tungtungsarur`
- `sakuracardicaptor` -> `sakuracardcaptor`

## Audio

Os sons ficam em `public/sons/` e sao separados por uso:

- trilha principal
- som de hover
- falas por personagem

Quando houver correspondencia de nome, a fala de um personagem e associada automaticamente ao seu card. O projeto nao usa voz sintetizada por padrao; os arquivos precisam existir na pasta de audio.

## Configuracoes salvas no navegador

A tela possui controles de volume, brilho e tema. Essas preferencias ficam salvas no navegador do usuario via `localStorage`.
