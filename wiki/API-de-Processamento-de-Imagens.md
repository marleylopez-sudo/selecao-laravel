# API de Processamento de Imagens

## Objetivo

A API serve para processar imagens com a integracao da remove.bg.

## Endpoint

### `POST /api/image/process`

Processa uma imagem unica.

Corpo esperado:

```json
{
  "input": "caminho/da/imagem.jpg",
  "output": "processado/imagem.png"
}
```

Resposta de sucesso:

```json
{
  "success": true,
  "message": "Imagem processada com sucesso",
  "output": "processado/imagem.png"
}
```

### `POST /api/image/process-batch`

Processa um lote de imagens de uma pasta.

Corpo esperado:

```json
{
  "source": "gifs-raw",
  "output": "gifs-processed"
}
```

## Fluxo interno

- O controller valida a entrada.
- O servico resolve caminhos relativos dentro de `public/`.
- A imagem e enviada para a API remove.bg.
- Se houver sucesso, o arquivo processado e salvo no caminho de saida.

## Arquivos relacionados

- [app/Http/Controllers/ImageProcessingController.php](../app/Http/Controllers/ImageProcessingController.php)
- [app/Services/RemoveBgService.php](../app/Services/RemoveBgService.php)
- [routes/api.php](../routes/api.php)
