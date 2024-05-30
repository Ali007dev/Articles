<?php

namespace App\Services;

use App\Models\Article;
use App\Models\Author;
use App\Models\Category;
use App\Models\Favorite;
use App\Models\Source;
use App\Models\SubCategory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ArticleService
{
    /**
     * Create a new class instance.
     */
    protected $filterService;
    public function __construct(FilterService $filterService)
    {
        $this->filterService = $filterService;
    }



    public function index($request)
    {
        $query = Article::query();

        if ($request->has('sub_category_id')) {
            $query = $this->filterService->filterBySubCategory($query, $request->sub_category_id);
        }

        if ($request->has('source_id')) {
            $query = $this->filterService->filterBySource($query, $request->source_id);
        }

        if ($request->has('author_id')) {
            $query = $this->filterService->filterByAuthor($query, $request->author_id);
        }

        return $query;
    }



    public function show($article)
    {
        $result = Article::findOrFail($article);

        return $result;
    }



    public function search($request)
    {
        $search = $request->data;
        $taskResults = Article::whereAny(
            [
                'title',
                'content',
            ],
            'LIKE',
            "%$search%"
        )->paginate(10);

        return $taskResults;
    }

    public function fetchNewsArticles($url, string $query, string $date, string $apiKey, $tag)
    {
        return Http::withHeaders([
            'api-key' => $apiKey
        ])->get($url, [
            'q' => $query,
            'from' => $date,
            'apiKey' => $apiKey,
            'tag' => $tag,
            'from-date' => $date,
        ]);
    }


    public function favoriteResults($request)
    {
        $userAuthorIds = $this->getFavoriteIds(Favorite::USER_FAVORITEABLE_TYPE_AUTHOR);
        $userCategoryIds = $this->getFavoriteIds(Favorite::USER_FAVORITEABLE_TYPE_SUBCATEGORY);
        $userSourceIds = $this->getFavoriteIds(Favorite::USER_FAVORITEABLE_TYPE_SOURCE);

        $query = Article::query()
            ->whereIn('author_id', $userAuthorIds)
            ->orWhereIn('source_id', $userSourceIds)
            ->orWhereIn('sub_category_id', $userCategoryIds)
            ->orderByDesc('created_at');


        return $query;
    }

    protected function getFavoriteIds($favoriteableType)
    {
        return Favorite::where('user_id', Auth::user()->id)
            ->where('favoriteable_type', $favoriteableType)
            ->pluck('favoriteable_id');
    }
}
