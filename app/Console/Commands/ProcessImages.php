<?php

namespace App\Console\Commands;

use App\Services\RemoveBgService;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

class ProcessImages extends Command
{
    protected $signature = 'images:process {source=gifs-raw : Pasta de origem das imagens} {output=gifs-processed : Pasta de destino}';
    protected $description = 'Processa imagens removendo o fundo usando API remove.bg';

    protected $removeBg;

    public function __construct(RemoveBgService $removeBg)
    {
        parent::__construct();
        $this->removeBg = $removeBg;
    }

    public function handle()
    {
        $source = $this->argument('source');
        $output = $this->argument('output');

        $this->info("Processando imagens de: {$source}");
        $this->info("Salvando em: {$output}");

        $results = $this->removeBg->processBatch($source, $output);

        if (empty($results)) {
            $this->error('Nenhuma imagem encontrada ou pasta não existe.');
            return 1;
        }

        $successCount = collect($results)->where('status', 'success')->count();
        $failCount = collect($results)->where('status', 'failed')->count();

        foreach ($results as $result) {
            if ($result['status'] === 'success') {
                $this->line("<info>✓</info> {$result['input']} → {$result['output']}");
            } else {
                $this->line("<error>✗</error> {$result['input']} (Falhou)");
            }
        }

        $this->newLine();
        $this->info("Total: {$successCount} sucesso, {$failCount} falha");

        return $successCount > 0 ? 0 : 1;
    }
}
