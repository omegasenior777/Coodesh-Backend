<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DictionaryWord;
use App\Models\History;
use App\Models\Favorite;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;

class DictionaryController extends Controller
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
    public function index(Request $request)
    {
        $search = $request->query('search');
        $limit = $request->query('limit', 10);

        $query = DictionaryWord::query();
        if ($search) {
            $query->where('word', 'like', "%$search%");
        }

        $words = $query->paginate($limit);

        $wordList = $words->pluck('word')->toArray();

        return response()->json([
            'results' => $wordList,
            'totalDocs' => $words->total(),
            'page' => $words->currentPage(),
            'totalPages' => $words->lastPage(),
            'hasNext' => $words->hasMorePages(),
            'hasPrev' => $words->onFirstPage() ? false : true,
        ]);
    }

    public function show($word)
    {
        $wordEntry = DictionaryWord::where('word', '=',$word)->first();

        if (!$wordEntry) {
            return response()->json([],204);
        }
        $user = Auth::user();
        if ($user) {
            History::create([
                'user_id' => $user->id,
                'word_id' => $wordEntry->id,
                'viewed_at' => now(),
            ]);
        }

        return response()->json([
            'results' => [
                'word' => $wordEntry->word,
            ],
            'totalDocs' => 1,
            'page' => 1,
            'totalPages' => 1,
            'hasNext' => false,
            'hasPrev' => false,
        ]);
    }
    public function favorite(Request $request)
    {
        $request->validate([
            'word' => 'required|string|max:255',
        ]);

        $word = Word::where('word', $request->input('word'))->first();

        if (!$word) {
            return response()->json(['message' => 'Word not found'], 404);
        }

        $existingFavorite = Favorite::where('user_id', auth()->id())
            ->where('word_id', $word->id)
            ->first();

        if ($existingFavorite) {
            return response()->json(['message' => 'Word is already favorited'], 400);
        }

        Favorite::create([
            'user_id' => auth()->id(),
            'word_id' => $word->id,
        ]);

        return response()->json(['message' => 'Word added to favorites'], 200);
    }

    public function unfavorite(Request $request)
    {
        $request->validate([
            'word' => 'required|string|max:255',
        ]);

        $word = Word::where('word', $request->input('word'))->first();

        if (!$word) {
            return response()->json(['message' => 'Word not found'], 404);
        }

        $favorite = Favorite::where('user_id', auth()->id())
            ->where('word_id', $word->id)
            ->first();

        if (!$favorite) {
            return response()->json(['message' => 'Word is not in favorites'], 400);
        }

        $favorite->delete();

        return response()->json(['message' => 'Word removed from favorites'], 200);
    }
}
