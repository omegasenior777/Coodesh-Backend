<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    protected $table = 'history';

    protected $fillable = [
        'user_id',
        'word_id',
        'viewed_at',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function word()
    {
        return $this->belongsTo(DictionaryWord::class, 'word_id');
    }
}
