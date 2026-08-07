<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attraction;
use App\Models\Category;
use Illuminate\Http\Request;

class AdminAttractionController extends Controller
{
    /**
     * 顯示景點管理列表
     */
    public function index()
    {
        // 取得所有城市
        $cities = Attraction::select('city')
            ->whereNotNull('city')
            ->where('city', '!=', '')
            ->distinct()
            ->orderBy('city')
            ->pluck('city');

        // 取得所有分類
        $categories = Category::orderBy('name')->get();

        return view('admin.attractions.index', [
            'cities' => $cities,
            'categories' => $categories,
        ]);
    }

    /**
     * 顯示新增景點表單
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.attractions.create', [
            'categories' => $categories,
        ]);
    }


    /**
     * 顯示編輯景點表單
     */
    public function edit(Request $request)
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.attractions.edit', [
            'id' => $request->id,
            'categories' => $categories,
        ]);
    }
}
