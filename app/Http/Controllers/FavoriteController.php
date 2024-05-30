<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Article;
use App\Models\Author;
use App\Models\Favorite;
use App\Models\Source;
use App\Models\SubCategory;
use App\Services\FavoriteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{


    protected $favoriteService;

    public function __construct(FavoriteService $favoriteService)
    {
        $this->favoriteService = $favoriteService;

    }
    public function store(Request $request)
    {
        $result = $this->favoriteService->store($request);
        return ResponseHelper::success($result,null,'added to favorite',200);
    }
    public function index(Request $request)
    {
        $result = $this->favoriteService->index($request);
        return ResponseHelper::success($result,null,'favorite returned successfully',200);
    }
    public function delete($fav)
    {
        $result = $this->favoriteService->delete($fav);
        return ResponseHelper::success($result,null,'favorite deleted successfully',200);
    }

    }

