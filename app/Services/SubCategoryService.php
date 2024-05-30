<?php

namespace App\Services;

use App\Models\SubCategory;

class SubCategoryService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {

    }


        public function store($request)
        {
            $result = SubCategory::query()->create([
                'name' => $request->name,
                'category_id' => $request->category_id
            ]);
            return $result;
        }

        public function index()
        {
            $category_id = request()->input('category_id');
            $result = SubCategory::query()->where('category_id', $category_id)
                ->get()->toArray();
            return $result;

        }



        public function destroy($category)
        {
            $result = SubCategory::findOrFail($category)->delete();
            return $result;
        }

}
