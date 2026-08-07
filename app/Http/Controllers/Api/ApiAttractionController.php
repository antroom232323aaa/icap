<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attraction;
use Illuminate\Http\Response;

class ApiAttractionController extends Controller
{
    public function index(Request $request)
    {
        $query = Attraction::with('category');

        // 關鍵字搜尋
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;

            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
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
            'created_at' => 'created_at',
            'category' => 'category_id',
        ];

        $sort = $request->get('sort', 'created_at');

        if (!array_key_exists($sort, $sortOptions)) {
            $sort = 'created_at';
        }

        // 排序方向
        $direction = $request->get('direction', 'desc');

        if (!in_array($direction, ['asc', 'desc'])) {
            $direction = 'desc';
        }

        // 首頁精選景點
        if ($request->boolean('random')) {

            $attractions = $query
                ->whereNotNull('image')
                ->where('image', '!=', '')
                ->where('image', '!=', 'https://ezgo.ardswc.gov.tw/_api/content/images/notfound/miss.jpg')
                ->inRandomOrder()
                ->limit(6)
                ->get();

            return response()->json([
                'status' => 'success',
                'message' => '精選景點取得成功',
                'data' => $attractions,
                'code' => Response::HTTP_OK,
            ], Response::HTTP_OK);
        }

        // 每頁筆數
        $perPageOptions = [6, 9, 12, 18];

        $perPage = (int) $request->get('per_page', 6);

        if (!in_array($perPage, $perPageOptions)) {
            $perPage = 6;
        }

        // 分頁
        $attractions = $query
            ->orderBy($sortOptions[$sort], $direction)
            ->orderBy('id', $direction)
            ->paginate($perPage)
            ->withQueryString();

        return response()->json([
            'status' => 'success',
            'message' => '景點取得成功',
            'data' => $attractions,
            'code' => Response::HTTP_OK,
        ], Response::HTTP_OK);
    }

    public function show(Request $request)
    {
        $attraction = Attraction::with('category')
            ->find($request->id);

        if (!$attraction) {
            return response()->json([
                'status' => 'error',
                'message' => '找不到指定的景點',
                'data' => null,
                'code' => Response::HTTP_NOT_FOUND,
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'status' => 'success',
            'message' => '景點取得成功',
            'data' => $attraction,
            'code' => Response::HTTP_OK,
        ], Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|integer|exists:categories,id',
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'town' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'image' => 'required|url|max:255',
            'description' => 'required|string',
            'feature' => 'nullable|string',
            'website' => 'nullable|url|max:255',
        ]);

        $attraction = new Attraction();

        $attraction->category_id = $request->category_id;
        $attraction->name = $request->name;
        $attraction->city = $request->city;
        $attraction->town = $request->town;
        $attraction->address = $request->address;
        $attraction->image = $request->image;
        $attraction->description = $request->description;
        $attraction->feature = $request->feature;
        $attraction->website = $request->website;

        $attraction->save();

        $attraction->load('category');

        return response()->json([
            'status' => 'success',
            'message' => '景點新增成功',
            'data' => $attraction,
            'code' => Response::HTTP_CREATED,
        ], Response::HTTP_CREATED);
    }

    public function update(Request $request)
    {
        $attraction = Attraction::find($request->id);

        if (!$attraction) {
            return response()->json([
                'status' => 'error',
                'message' => '找不到指定的景點',
                'data' => null,
                'code' => Response::HTTP_NOT_FOUND,
            ], Response::HTTP_NOT_FOUND);
        }

        $request->validate([
            'category_id' => 'required|integer|exists:categories,id',
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'town' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'image' => 'required|url|max:255',
            'description' => 'required|string',
            'feature' => 'nullable|string',
            'website' => 'nullable|url|max:255',
        ]);

        $attraction->category_id = $request->category_id;
        $attraction->name = $request->name;
        $attraction->city = $request->city;
        $attraction->town = $request->town;
        $attraction->address = $request->address;
        $attraction->image = $request->image;
        $attraction->description = $request->description;
        $attraction->feature = $request->feature;
        $attraction->website = $request->website;

        $attraction->save();

        $attraction->load('category');

        return response()->json([
            'status' => 'success',
            'message' => '景點修改成功',
            'data' => $attraction,
            'code' => Response::HTTP_OK,
        ], Response::HTTP_OK);
    }

    public function destroy(Request $request)
    {
        $attraction = Attraction::find($request->id);

        if (!$attraction) {
            return response()->json([
                'status' => 'error',
                'message' => '找不到指定的景點',
                'data' => null,
                'code' => Response::HTTP_NOT_FOUND,
            ], Response::HTTP_NOT_FOUND);
        }

        $attraction->delete();

        return response()->json([
            'status' => 'success',
            'message' => '景點刪除成功',
            'data' => null,
            'code' => Response::HTTP_OK,
        ], Response::HTTP_OK);
    }
}
