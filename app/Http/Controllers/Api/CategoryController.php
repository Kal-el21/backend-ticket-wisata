<?php

namespace App\Http\Controllers\Api;


use App\Helpers\ResponseHelpers;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        return ResponseHelpers::jsonResponse('success',  message: 'haii', data: Category::all());            //yang keluar akan status dengan data dan masih harus
    }
}
