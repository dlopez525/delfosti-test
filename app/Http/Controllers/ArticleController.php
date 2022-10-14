<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArticleCollection;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function getArticles(Request $request)
    {
        $request->only(['search', 'page', 'per_page']);

        $perPage = $request->has('per_page') ? $request->per_page : 12;
        $page = $request->has('page') ? $request->page : 1;
        $offset = ($page - 1) * $perPage;


        $articlesQuery = Article::query()->with('categories')
                                        ->when($request->search, function ($query) use ($request) {
                                            return $query->where('name', 'like', "%{$request->search}%");
                                        });

        $countItems = $articlesQuery->count();

        $articles = $articlesQuery->skip($offset)
                                    ->take($perPage)
                                    ->get(['id', 'name', 'description', 'status']);

        $endCount = $offset + $perPage;
        $morePages = $countItems > $endCount;

        $results = array(
            "data" => new ArticleCollection($articles),
            "count" => $countItems,
            "pagination_more" => $morePages,
            "per_page" => $perPage,
            "total_pages" => ceil((int) $countItems / (int) $perPage) == 0 ? 1 : ceil((int) $countItems / (int) $perPage),
        );

        return response()->json($results);
    }

    public function getArticle($id)
    {
        $article = Article::query()
                            ->with('categories')
                            ->select('id', 'name', 'description', 'status')
                            ->find($id);
        if ($article != null) {
            return response()->json(new ArticleResource($article));
        }

        return  response()->json(null ,404);
    }
}
