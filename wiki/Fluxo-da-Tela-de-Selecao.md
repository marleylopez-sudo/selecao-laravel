# Fluxo da Tela de Selecao

## Entrada do usuario

A rota `/` retorna a view `selection`, que exibe uma tela inicial com o titulo **Multiverso Battle**.

Depois do clique em **Click to start**, a aplicacao entra na area de selecao.

## Como a selecao funciona

- O jogador navega pelos personagens em uma grade central.
- O hover mostra pre-visualizacao e toca efeito sonoro, quando disponivel.
- O clique confirma o personagem do jogador atual.
- A interface alterna entre P1 e P2 ate fechar os dois escolhidos.
- Em seguida, a tela VS mostra os dois lados e libera a passagem para a batalha.

## Tela de batalha

A tela final exibe:

- barra de vida de P1 e P2
- cronometro central
- arena de luta em canvas
- comandos do teclado para cada jogador

## Controles

- P1: `A/D` mover, `W` pular, `F` soco, `G` chute
- P2: setas mover/pular, `L` soco, `K` chute
