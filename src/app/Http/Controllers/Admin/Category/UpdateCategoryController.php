<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Responses\ApiResponse;
use App\Models\Category;
use Illuminate\Http\Request;

class UpdateCategoryController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(UpdateCategoryRequest $request, Category $category)
    {
        $data = $request->validated();
       
        $category = Category::findOrFail($category->id);

        $category->update($data);

        return ApiResponse::created(['category' => new CategoryResource($category)]);
    }
}
