<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DictionaryWord extends Model
{
    use HasFactory;

    protected $fillable = [
        'word',
        'phonetics',
        'meanings',
        'license',
        'source_urls',
    ];

    protected $casts = [
        'phonetics' => 'array',
        'meanings' => 'array',
        'license' => 'array',
        'source_urls' => 'array',
    ];
    //protected $table = 'dictionary_words';
    protected $table = 'words';
    public function histories()
    {
        return $this->hasMany(History::class);
    }
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
}
