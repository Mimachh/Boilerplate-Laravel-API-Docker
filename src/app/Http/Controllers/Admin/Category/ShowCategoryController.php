<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Models\Category;
use Illuminate\Http\Request;

class ShowCategoryController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Category $category)
    {
        if(auth()->user()->cannot('view', $category)){
            return ApiResponse::forbidden();
            // abort(403);
        }
        return ApiResponse::ok(['category' => $category]);
    }
}
