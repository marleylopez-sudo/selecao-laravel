<?php

namespace App\Http\Controllers;

use App\Services\RemoveBgService;
use Illuminate\Http\Request;

class ImageProcessingController extends Controller
{
    protected $removeBg;

    public function __construct(RemoveBgService $removeBg)
    {
        $this->removeBg = $removeBg;
    }

    /**
     * Processa um único arquivo de imagem
     * POST /api/process-image
     * Body: { "input": "caminho/da/imagem.jpg", "output": "processado/imagem.png" }
     */
    public function processImage(Request $request)
    {
        $request->validate([
            'input' => 'required|string',
            'output' => 'required|string',
        ]);

        $result = $this->removeBg->processImage(
            $request->input('input'),
            $request->input('output')
        );

        if ($result) {
            return response()->json([
                'success' => true,
                'message' => 'Imagem processada com sucesso',
                'output' => $result,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Erro ao processar imagem',
        ], 400);
    }

    /**
     * Processa um lote de imagens de uma pasta
     * POST /api/process-batch
     * Body: { "source": "gifs-raw", "output": "gifs-processed" }
     */
    public function processBatch(Request $request)
    {
        $request->validate([
            'source' => 'required|string',
            'output' => 'required|string',
        ]);

        $results = $this->removeBg->processBatch(
            $request->input('source'),
            $request->input('output')
        );

        if (empty($results)) {
            return response()->json([
                'success' => false,
                'message' => 'Nenhuma imagem encontrada ou pasta não existe',
            ], 404);
        }

        $successCount = collect($results)->where('status', 'success')->count();

        return response()->json([
            'success' => true,
            'total' => count($results),
            'success_count' => $successCount,
            'failed_count' => count($results) - $successCount,
            'results' => $results,
        ]);
    }
}
