<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class RemoveBgService
{
    protected $apiKey;
    protected $apiUrl = 'https://api.remove.bg/v1.0/removebg';

    public function __construct()
    {
        $this->apiKey = config('services.removebg.key');
    }

    /**
     * Processa uma imagem e remove o fundo usando API remove.bg
     *
     * @param string $inputPath Caminho da imagem de entrada (relativo ao public ou absoluto)
     * @param string $outputPath Caminho de saída (relativo ao public)
     * @return bool|string Retorna o caminho da imagem processada ou false
     */
    public function processImage($inputPath, $outputPath)
    {
        try {
            // Se for um caminho relativo, resolve no public
            if (!str_starts_with($inputPath, '/')) {
                $inputPath = public_path($inputPath);
            }

            if (!file_exists($inputPath)) {
                \Log::error("RemoveBg: Arquivo não encontrado: {$inputPath}");
                return false;
            }

            // Cria diretório de saída se não existir
            $outputFullPath = public_path($outputPath);
            $outputDir = dirname($outputFullPath);
            if (!is_dir($outputDir)) {
                mkdir($outputDir, 0755, true);
            }

            // Lê a imagem como binary
            $imageData = file_get_contents($inputPath);

            // Chama a API remove.bg
            $response = Http::withHeaders([
                'X-API-Key' => $this->apiKey,
            ])
            ->attach('image_file', $imageData, basename($inputPath))
            ->post($this->apiUrl);

            if (!$response->successful()) {
                \Log::error("RemoveBg API Error: " . $response->body());
                return false;
            }

            // Salva a imagem processada
            file_put_contents($outputFullPath, $response->body());

            \Log::info("RemoveBg: Sucesso processando {$inputPath} -> {$outputPath}");

            return $outputPath;
        } catch (\Exception $e) {
            \Log::error("RemoveBg Exception: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Processa todas as imagens de uma pasta
     *
     * @param string $sourceDir Pasta de origem (relativa ao public)
     * @param string $outputDir Pasta de saída (relativa ao public)
     * @return array Array com imagens processadas
     */
    public function processBatch($sourceDir, $outputDir = 'processed')
    {
        $sourcePath = public_path($sourceDir);
        $results = [];

        if (!is_dir($sourcePath)) {
            \Log::error("RemoveBg: Diretório não encontrado: {$sourcePath}");
            return $results;
        }

        $files = glob("{$sourcePath}/*/*.{jpg,jpeg,png,gif}", GLOB_BRACE);

        foreach ($files as $file) {
            $relative = str_replace(public_path() . '/', '', $file);
            $outputPath = $outputDir . '/' . basename($file);

            $processed = $this->processImage($relative, $outputPath);

            if ($processed) {
                $results[] = [
                    'input' => $relative,
                    'output' => $processed,
                    'status' => 'success',
                ];
            } else {
                $results[] = [
                    'input' => $relative,
                    'status' => 'failed',
                ];
            }
        }

        return $results;
    }
}
