<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    // List authenticated user's articles
    public function mine()
    {
        $user = Auth::user();
        return response()->json(Article::where('user_id', $user->id)->get());
    }

    // Create a new article
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'status' => 'required|in:draft,published',
            'category_id' => 'required|exists:categories,id',
        ]);
        $article = Article::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'body' => $request->body,
            'status' => $request->status,
            'category_id' => $request->category_id,
            'user_id' => Auth::id(),
        ]);
        return response()->json($article, 201);
    }

    // View specific article (if owner)
    public function show($id)
    {
        $article = Article::findOrFail($id);
        if ($article->user_id !== Auth::id()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }
        return response()->json($article);
    }

    // Update article (if owner)
    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        if ($article->user_id !== Auth::id()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'status' => 'required|in:draft,published',
            'category_id' => 'required|exists:categories,id',
        ]);
        $article->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'body' => $request->body,
            'status' => $request->status,
            'category_id' => $request->category_id,
        ]);
        return response()->json($article);
    }

    // Soft delete article (if owner)
    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        if ($article->user_id !== Auth::id()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }
        $article->delete();
        return response()->json(['message' => 'Article deleted']);
    }

    // List all published articles (with filtering)
    public function publicIndex(Request $request)
    {
        $query = Article::with(['category', 'user'])->where('status', 'published');

        
        if ($request->filled('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('name', $request->category);
            });
        }

        
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $articles = $query->get()->map(function($article) {
            return [
                'id' => $article->id,
                'title' => $article->title,
                'slug' => $article->slug,
                'body' => $article->body,
                'status' => $article->status,
                'category_id' => $article->category_id,
                'category_name' => $article->category ? $article->category->name : 'Unknown',
                'user_id' => $article->user_id,
                'user_name' => $article->user ? $article->user->name : 'Unknown',
            ];
        });

        return response()->json($articles);
    }

    // View a single published article
    public function publicShow($id)
    {
        $article = Article::with(['category', 'user'])
            ->where('id', $id)
            ->where('status', 'published')
            ->firstOrFail();

        return response()->json([
            'id' => $article->id,
            'title' => $article->title,
            'slug' => $article->slug,
            'body' => $article->body,
            'status' => $article->status,
            'category_id' => $article->category_id,
            'category_name' => $article->category ? $article->category->name : 'Unknown',
            'user_id' => $article->user_id,
            'user_name' => $article->user ? $article->user->name : 'Unknown',
        ]);
    }
} 