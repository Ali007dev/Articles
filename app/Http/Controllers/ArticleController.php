<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Article;
use App\Models\Category;
use App\Models\SubCategory;
use App\Services\ArticleService;
use App\Services\FilterService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ArticleController extends Controller
{

    protected $articleService;
    protected $filterService;

    public function __construct(ArticleService $articleService, FilterService $filterService)
    {
        $this->articleService = $articleService;
        $this->filterService = $filterService;

    }
    // public function guardian()
    // {
    //     return $this->articleService->storeArticle('https://content.guardianapis.com/search','test',$result['webPublicationDate'],$result['webTitle'],$result['id'],$result['webUrl']);
    // }

    public function index(Request $request)
    {

        $articles= $this->articleService->index($request);
        $result = $this->filterService->filterDate($articles,$request->date,'date');
        $result = $articles->paginate(10);
        return ResponseHelper::success($result,null,'Articles',200);
    }

public function show($id)
    {
        $result= $this->articleService->show($id);
        return ResponseHelper::success($result,null,'Articles',200);
    }

    public function search(Request $request)
    {
        $result= $this->articleService->search($request);
        return ResponseHelper::success($result,null,'Articles',200);
    }

    public function favoriteResults(Request $request)
    {
        $articles= $this->articleService->favoriteResults($request);
        $result = $articles->paginate(10);
        return ResponseHelper::success($result,null,'Articles',200);
    }

}
