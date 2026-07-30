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
    public function index(Request $request)
    {
        $query = Attraction::with('category');

        // 關鍵字搜尋
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;

            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                    ->orWhere('city', 'like', "%{$keyword}%")
                    ->orWhere('town', 'like', "%{$keyword}%")
                    ->orWhere('address', 'like', "%{$keyword}%")
                    ->orWhere('description', 'like', "%{$keyword}%")
                    ->orWhere('feature', 'like', "%{$keyword}%");
            });
        }

        // 城市篩選
        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        // 分類篩選
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // 排序欄位白名單
        $sortOptions = [
            'name' => 'name',
            'city' => 'city',
            'category' => 'category_id',
            'created_at' => 'created_at',
        ];

        // 排序欄位
        $sort = $request->get('sort', 'created_at');

        // 排序方向
        $direction = $request->get('direction', 'desc');

        // 確認排序欄位是否允許
        if (!array_key_exists($sort, $sortOptions)) {
            $sort = 'created_at';
        }

        // 確認排序方向是否允許
        if (!in_array($direction, ['asc', 'desc'])) {
            $direction = 'desc';
        }

        // 分頁設定
        $perPageOptions = [12, 24, 36, 48];
        $perPage = (int) $request->get('per_page', 12);

        // 確認分頁是否允許
        if (!in_array($perPage, $perPageOptions)) {
            $perPage = 12;
        }

        $attractions = $query
            ->orderBy($sortOptions[$sort], $direction)
            ->paginate($perPage)
            ->withQueryString();

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
            'attractions' => $attractions,
            'cities' => $cities,
            'categories' => $categories,
        ]);
    }

    /**
     * 顯示單一景點詳細資料
     */
    public function show(Request $request)
    {
        $attraction = Attraction::with('category')
            ->findOrFail($request->id);

        return view('attractions.show', [
            'attraction' => $attraction,
        ]);
    }
}
