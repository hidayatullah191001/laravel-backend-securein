<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function fetch()
    {
        $categories = Category::all();

        return ResponseFormatter::success($categories, 'Date retrieved successfully');
    }
}
