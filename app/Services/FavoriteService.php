<?php

namespace App\Services;

use App\Helpers\ResponseHelper;
use App\Models\Author;
use App\Models\Favorite;
use App\Models\Source;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    protected function getFavoriteableType($type)
    {
        switch ($type) {
            case 'source':
                return Source::class;
            case 'author':
                return Author::class;
            case 'sub_category':
                return SubCategory::class;
            default:
                throw new \InvalidArgumentException('Invalid type: ' . $type);
        }
    }


    protected function getUserFavorites($type)
    {
        $user = User::query();

        switch ($type) {
            case 'source':
                $user->with('sourceFavorites.favoriteable');
                break;
            case 'author':
                $user->with('authorFavorites.favoriteable');
                break;
            case 'sub_category':
                $user->with('subCategoryFavorites.favoriteable');
                break;
            default:
                $user->with('favorites.favoriteable');
                break;
        }

        return $user;
    }





    public function store(Request $request)
    {
        $type = $request->type;
        $favoriteable_type = $this->getFavoriteableType($type);

        if (!$request->has('favoriteable_id')) {
            return response()->json(['error' => 'favoriteable_id is required'], 400);
        }

        $favorite = Favorite::create([
            'user_id' => Auth::id(),
            'favoriteable_type' => $favoriteable_type,
            'favoriteable_id' => $request->favoriteable_id
        ]);

        return $favorite;
    }

    public function index(Request $request)
    {
        $type = $request->type;
        $user = $this->getUserFavorites($type)->get()->toArray();
        return $user;
    }


    public function delete($fav)
    {
        $fav =Favorite::findOrFail($fav)->delete();
        return $fav;
    }


}
