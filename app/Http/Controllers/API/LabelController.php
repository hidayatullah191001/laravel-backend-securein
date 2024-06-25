<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Label;
use Illuminate\Http\Request;

class LabelController extends Controller
{
    public function fetch($id_category)
    {
        $labels = Label::where('category_id', $id_category)->get();
        return ResponseFormatter::success($labels, 'Data retrieved successfully');
    }
}
