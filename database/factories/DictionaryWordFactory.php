<?php
namespace Database\Factories;

use App\Models\DictionaryWord;
use Illuminate\Database\Eloquent\Factories\Factory;

class DictionaryWordFactory extends Factory
{
    protected $model = DictionaryWord::class;

    public function definition()
    {
        return [
            'word' => $this->faker->word,
        ];
    }
}
