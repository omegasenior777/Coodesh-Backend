<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class DictionaryWordsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = 'words_dictionary.json';

        if (!File::exists($filePath)) {
            $this->command->error("Arquivo words_dictionary.json não encontrado.");
            return;
        }

        $data = json_decode(File::get($filePath), true);

        if (!$data) {
            $this->command->error("Erro ao decodificar o arquivo JSON.");
            return;
        }

        foreach ($data as $word => $value) {
            DB::table('dictionary_words')->insert([
                'word' => $word,
                'phonetics' => null,
                'meanings' => null,
                'license' => null,
                'source_urls' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info("Dicionário populado com sucesso!");
    }
}
