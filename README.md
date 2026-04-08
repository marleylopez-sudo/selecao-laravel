# Tela de Seleção Marvel (Character Select Screen)

Uma **tela de seleção de personagens estilo videogame** (como nos jogos de luta), onde o jogador escolhe o personagem **antes da partida iniciar** — com visual inspirado no universo Marvel.

Projeto **educacional (SENAI)**, com foco em prática de front-end e integração com back-end usando **Laravel**.

---

## Sobre o projeto

Este projeto recria a experiência clássica de “**Character Select Screen**” encontrada em games: uma interface onde você navega entre personagens, recebe feedback visual e confirma a escolha antes de iniciar a próxima etapa.

**Objetivos educacionais:**
- praticar estruturação de páginas e componentes visuais
- treinar CSS (layout, responsividade, efeitos)
- aplicar JavaScript para estados/interações (hover/seleção)
- organizar uma aplicação web com **Laravel (PHP)**

---

## Tecnologias (cards)

<div align="center">

<img alt="Laravel" src="https://img.shields.io/badge/Laravel-Framework-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" />
<img alt="PHP" src="https://img.shields.io/badge/PHP-Back--end-777BB4?style=for-the-badge&logo=php&logoColor=white" />
<img alt="HTML5" src="https://img.shields.io/badge/HTML5-Estrutura-E34F26?style=for-the-badge&logo=html5&logoColor=white" />
<img alt="CSS3" src="https://img.shields.io/badge/CSS3-Estilos-1572B6?style=for-the-badge&logo=css3&logoColor=white" />
<img alt="JavaScript" src="https://img.shields.io/badge/JavaScript-Intera%C3%A7%C3%B5es-F7DF1E?style=for-the-badge&logo=javascript&logoColor=000" />

</div>

---

## Funcionalidades

- Tela de seleção no estilo “games” (pré-partida)
- Destaque visual ao passar o mouse (hover)
- Estado visual de personagem selecionado
- Interface temática inspirada na Marvel
- Estrutura pronta para evoluir o fluxo via Laravel (rotas/views/controllers)

---

## Frames visuais (imagens no README)

> As imagens abaixo são **exemplos de caminhos**. Coloque seus prints dentro de `docs/` e mantenha os mesmos nomes para aparecerem automaticamente aqui.

### Preview (Hero)
<div align="center">
  <img src="docs/preview-hero.png" alt="Preview - Tela de Seleção Marvel" width="900" />
</div>

### Frames / Telas
<div align="center">
  <img src="docs/frame-01.png" alt="Frame 01" width="420" />
  <img src="docs/frame-02.png" alt="Frame 02" width="420" />
</div>

<div align="center">
  <img src="docs/frame-03.png" alt="Frame 03" width="420" />
  <img src="docs/frame-04.png" alt="Frame 04" width="420" />
</div>

---

## Requisitos

- **PHP** (compatível com a versão do Laravel do projeto)
- **Composer**
- **Node.js + NPM** (caso o projeto utilize Vite/Mix para assets)

---

## Como rodar o projeto (Laravel)

### 1) Clonar o repositório
```bash
git clone https://github.com/jhonatandev01/Tela-de-Selecao-Marvel.git
cd Tela-de-Selecao-Marvel
```

### 2) Instalar dependências do PHP
```bash
composer install
```

### 3) Configurar variáveis de ambiente
```bash
cp .env.example .env
php artisan key:generate
```

### 4) Instalar dependências do front-end (se aplicável)
```bash
npm install
npm run dev
```

> Para gerar build de produção (se aplicável):
```bash
npm run build
```

### 5) Rodar o servidor
```bash
php artisan serve
```

Acesse no navegador:
- `http://127.0.0.1:8000`

---

## Estrutura (referência)

> A organização pode variar, mas normalmente em Laravel você encontrará:

- `routes/web.php` — rotas web
- `resources/views/` — páginas Blade
- `resources/css/` — estilos
- `resources/js/` — scripts
- `public/` — arquivos públicos (imagens, ícones etc.)
- `app/Http/Controllers/` — controllers

---

## Observações (uso educacional)

Este repositório é um **projeto educacional do SENAI**, criado para fins de aprendizado e prática.  
Caso existam referências visuais/temáticas, elas são utilizadas **somente com finalidade didática**.

---

## Autor

**Jhonatan** — `@jhonatandev01`
