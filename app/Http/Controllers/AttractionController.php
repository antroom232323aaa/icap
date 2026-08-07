<?php

namespace App\Http\Controllers;

use App\Models\Attraction;
use App\Models\Category;
use Illuminate\Http\Request;

class AttractionController extends Controller
{
    /**
     * 顯示所有景點
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

        return view('attractions.index', [
            'cities' => $cities,
            'categories' => $categories,
        ]);
    }

    /**
     * 顯示單一景點詳細資料
     */
    public function show(Request $request)
    {
        return view('attractions.show', [
            'id' => $request->id,
        ]);
    }
}
