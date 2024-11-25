<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\DictionaryWord;

class ImportDictionaryWords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dictionary:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importa palavras do Dictionary API a partir de um arquivo JSON fixo';

    /**
     * Caminho fixo para o arquivo JSON.
     *
     * @var string
     */
    private $filePath = 'words_dictionary.json';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->importFromFile($this->filePath);
    }

    private function importFromFile(string $filePath): void
    {
        if (!file_exists($filePath)) {
            $this->error("Arquivo '$filePath' não encontrado no diretório raiz.");
            return;
        }

        // Carregar o conteúdo do arquivo JSON
        $jsonContent = file_get_contents($filePath);
        $words = json_decode($jsonContent, true); // Decodifica o JSON em um array associativo

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->error("Erro ao ler o arquivo JSON: " . json_last_error_msg());
            return;
        }

        // Iterar pelas palavras e importá-las
        foreach ($words as $word => $value) {
            $this->importWord(trim($word));
        }
    }

    private function importWord(string $word, int $attempt = 1): void
    {
        if (DictionaryWord::where('word', $word)->exists()) {
            $this->info("Palavra '$word' já está no banco de dados. Pulando...");
            return;
        }

        if (strpos($word, ' ') !== false) {
            $this->info("Ignorando a expressão '$word' porque contém espaços.");
            return;
        }

        $response = Http::withOptions([
            'verify' => false, // Desabilita a verificação SSL
        ])->get("https://api.dictionaryapi.dev/api/v2/entries/en/$word");


       // $maxAttempts = 5;
        if ($response->failed()) {
            $this->error("Erro ao buscar a palavra '$word'."); //(tentativa $attempt de $maxAttempts)
            $this->importWordFromFile($word);
//            if ($attempt < $maxAttempts) {
//                sleep(0.5);
//                $this->importWord($word, $attempt + 1);
//            } else {
//                $this->error("Limite de tentativas alcançado para a palavra '$word'.");
//
//            }

            return;
        }
        if ($response->json('title') === 'No Definitions Found') {
            $this->error("A palavra '$word' não foi encontrada na API.");
            $this->importWordFromFile($word);
            return;
        }

        $data = $response->json();

        foreach ($data as $entry) {
            DictionaryWord::updateOrCreate(
                ['word' => $entry['word']],
                [
                    'phonetics' => json_encode($entry['phonetics'] ?? []),
                    'meanings' => json_encode($entry['meanings'] ?? []),
                    'license' => json_encode($entry['license'] ?? null),
                    'source_urls' => json_encode($entry['sourceUrls'] ?? [])
                ]
            );
        }

        $this->info("Palavra '$word' importada com sucesso!");
    }
    private function importWordFromFile(string $word): void
    {
        // Carregar o conteúdo do arquivo JSON
        $jsonContent = file_get_contents($this->filePath);
        $words = json_decode($jsonContent, true); // Decodifica o JSON em um array associativo

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->error("Erro ao ler o arquivo JSON: " . json_last_error_msg());
            return;
        }

        // Verificar se a palavra está no arquivo JSON
        if (isset($words[$word])) {
            $this->info("Importando a palavra '$word' do arquivo JSON.");

            // Inserir a palavra diretamente do arquivo JSON
            DictionaryWord::updateOrCreate(
                ['word' => $word],
                [
                    'phonetics' => json_encode($words[$word]['phonetics'] ?? []),
                    'meanings' => json_encode($words[$word]['meanings'] ?? []),
                    'license' => json_encode($words[$word]['license'] ?? null),
                    'source_urls' => json_encode($words[$word]['sourceUrls'] ?? [])
                ]
            );

            $this->info("Palavra '$word' importada com sucesso do arquivo JSON!");
        } else {
            $this->error("A palavra '$word' não foi encontrada no arquivo JSON.");
        }
    }
}
