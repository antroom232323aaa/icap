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
        $attractions = Attraction::with('category')
            ->latest()
            ->get();

        return view('admin.attractions.index', [
            'attractions' => $attractions,
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
     * 儲存新景點
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
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

        $attraction->category_id = $validated['category_id'];
        $attraction->name = $validated['name'];
        $attraction->city = $validated['city'];
        $attraction->town = $validated['town'];
        $attraction->address = $validated['address'];
        $attraction->image = $validated['image'];
        $attraction->description = $validated['description'];
        $attraction->feature = $validated['feature'] ?? null;
        $attraction->website = $validated['website'] ?? null;

        $attraction->save();

        return redirect('/admin/attractions')
            ->with('success', '景點新增成功');
    }

    /**
     * 顯示編輯景點表單
     */
    public function edit(Request $request)
    {
        $attraction = Attraction::findOrFail($request->id);

        $categories = Category::orderBy('name')->get();

        return view('admin.attractions.edit', [
            'attraction' => $attraction,
            'categories' => $categories,
        ]);
    }

    /**
     * 更新景點
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'town' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'image' => 'required|url|max:255',
            'description' => 'required|string',
            'feature' => 'nullable|string',
            'website' => 'nullable|url|max:255',
        ]);

        $attraction = Attraction::findOrFail($request->id);

        $attraction->category_id = $validated['category_id'];
        $attraction->name = $validated['name'];
        $attraction->city = $validated['city'];
        $attraction->town = $validated['town'];
        $attraction->address = $validated['address'];
        $attraction->image = $validated['image'];
        $attraction->description = $validated['description'];
        $attraction->feature = $validated['feature'] ?? null;
        $attraction->website = $validated['website'] ?? null;

        $attraction->save();

        return redirect('/admin/attractions')
            ->with('success', '景點修改成功');
    }

    /**
     * 刪除景點
     */
    public function destroy(Request $request)
    {
        $attraction = Attraction::findOrFail($request->id);

        $attraction->delete();

        return redirect('/admin/attractions')
            ->with('success', '景點刪除成功');
    }
}
