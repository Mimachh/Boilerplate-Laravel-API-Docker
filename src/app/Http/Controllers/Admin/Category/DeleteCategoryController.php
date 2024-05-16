<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\DeleteCategoryRequest;
use App\Http\Responses\ApiResponse;
use App\Models\Category;
use Illuminate\Http\Request;

class DeleteCategoryController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(DeleteCategoryRequest $request)
    {
        $idsToDelete = $request->input('ids', []);
        foreach($idsToDelete as $id) {
            $category = Category::where('id', $id)->first();
            if (!$category) {
                return ApiResponse::notFound('Category not found');
            }
            
            if(auth()->user()->cannot('forceDelete', $category)) {
                return ApiResponse::forbidden('You are not allowed to delete this category');
            }
            $category->forceDelete();
        }
        return ApiResponse::ok(['message' => 'Categories deleted successfully']);  
    }
}
