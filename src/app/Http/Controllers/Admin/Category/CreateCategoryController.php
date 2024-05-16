<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\CreateCategoryRequest;
use App\Http\Responses\ApiResponse;
use App\Models\Category;
use Illuminate\Http\Request;

class CreateCategoryController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(CreateCategoryRequest $request)
    {
        $data = $request->validated();
        Category::create($data);

        return ApiResponse::created(['message' => 'Category created successfully']);
    }
}
