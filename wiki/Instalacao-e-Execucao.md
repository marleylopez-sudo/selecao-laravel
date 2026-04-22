# Instalacao e Execucao

## Requisitos

- PHP 8.2 ou superior
- Composer
- Node.js e npm
- Banco de dados configurado no `.env`, se voce for usar migracoes

## Instalacao

1. Instale as dependencias do PHP.

```bash
composer install
```

2. Crie o arquivo de ambiente e a chave da aplicacao.

```bash
copy .env.example .env
php artisan key:generate
```

3. Instale as dependencias front-end.

```bash
npm install
```

4. Execute as migracoes, se necessario.

```bash
php artisan migrate
```

## Execucao local

Em um terminal:

```bash
php artisan serve
```

Em outro terminal, caso queira recompilar os assets em modo dev:

```bash
npm run dev
```

## Script rapido do projeto

O `package.json` inclui um script `dev` que sobe o servidor Laravel e o Vite em paralelo.

```bash
npm run dev
```

## Acesso

Depois de iniciado, abra o endereco informado pelo Laravel, normalmente:

- `http://127.0.0.1:8000`
