<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\SubCategoryRequest;
use App\Models\SubCategory;
use App\Services\SubCategoryService;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{

    private $subCategoryService;

    public function __construct(SubCategoryService $subCategoryService)
    {
        $this->subCategoryService = $subCategoryService;
    }
    public function index()
    {
        $result = $this->subCategoryService->index();
        return ResponseHelper::success($result, null, 'subcategory returned successfully', 200);
    }

    public function store(SubCategoryRequest $request)

    {
        $result = $this->subCategoryService->store($request);
        return ResponseHelper::success($result, null, 'subcategory created successfully', 200);
    }


    public function destroy($subCategory)
    {
        $result = $this->subCategoryService->destroy($subCategory);
        return ResponseHelper::success($result, null, 'subcategory deleted successfully', 200);
    }
}
