<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\History;
use App\Models\Favorite;
use App\Models\DictionaryWord;

class UserController extends Controller
{
    public function __construct()
    {
        // Autentica um usuário fixo para testes (caso não esteja logado)
        if (app()->environment('local') && !Auth::check()) {
            $testUser = \App\Models\User::firstOrCreate(
                ['email' => 'cesar2@gmail.com'],
                ['name' => 'Cesar', 'password' => bcrypt('12345678')]
            );
            Auth::login($testUser);
        }
    }
    public function profile()
    {
        $user = Auth::user();

        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }
    public function history(Request $request)
    {
        $user = Auth::user();
        $history = History::with('word')
            ->where('user_id', $user->id)
            ->orderBy('viewed_at', 'desc')
            ->paginate(10);

        $results = $history->map(function ($item) {
            // Verifica se 'viewed_at' é um objeto Carbon, se não, converte para um
            $viewedAt = $item->viewed_at instanceof \Carbon\Carbon ? $item->viewed_at : \Carbon\Carbon::parse($item->viewed_at);

            return [
                'word' => $item->word->word,
                'added' => $viewedAt->toIso8601String(),
            ];
        });

        return response()->json([
            'results' => $results,
            'totalDocs' => $history->total(),
            'page' => $history->currentPage(),
            'totalPages' => $history->lastPage(),
            'hasNext' => $history->hasMorePages(),
            'hasPrev' => $history->currentPage() > 1,
        ]);
    }
    public function favorites(Request $request)
    {
        $user = Auth::user();

        $favorites = Favorite::with('word')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $results = $favorites->map(function ($item) {
            return [
                'word' => $item->word->word,
                'added' => $item->created_at->toIso8601String(),
            ];
        });

        return response()->json([
            'results' => $results,
            'totalDocs' => $favorites->total(),
            'page' => $favorites->currentPage(),
            'totalPages' => $favorites->lastPage(),
            'hasNext' => $favorites->hasMorePages(),
            'hasPrev' => $favorites->currentPage() > 1,
        ]);
    }
}
