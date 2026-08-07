<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attraction;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ApiStatisticsController extends Controller
{
    public function index()
    {
        // 農村美食
        $food = Attraction::where('category_id', 1)
            ->whereNotNull('city')
            ->selectRaw('city, COUNT(*) as total')
            ->groupBy('city')
            ->orderBy('city')
            ->get();

        // 農村住宿
        $stay = Attraction::where('category_id', 2)
            ->whereNotNull('city')
            ->selectRaw('city, COUNT(*) as total')
            ->groupBy('city')
            ->orderBy('city')
            ->get();

        return response()->json([
            'status' => 'success',
            'message' => '統計資料取得成功',
            'data' => [
                'food' => $food,
                'stay' => $stay,
            ],
            'code' => Response::HTTP_OK,
        ], Response::HTTP_OK);
    }
}
