<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class ResourceController extends Controller
{
    /**
     * Display the resource page for user — shows published articles.
     */
    public function index(Request $request)
    {
        $query = Article::where('status', 'published')
            ->with('author')
            ->latest('published_at');

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%")
                  ->orWhere('excerpt', 'like', "%{$request->search}%");
            });
        }

        $articles = $query->paginate(9)->withQueryString();
        $categories = Article::where('status', 'published')->distinct()->pluck('category');

        return view('user.resource', compact('articles', 'categories'));
    }
}
