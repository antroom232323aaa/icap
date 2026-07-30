@extends('layouts.app')

@section('title', '景點列表 | AI Travel Guide')

@section('content')

    <div class="container py-5">

        {{-- 頁面標題 --}}
        <div class="mb-5">

            <h1>
                景點列表
            </h1>

            <p class="text-muted">
                探索台灣各地農村美食與住宿景點。
            </p>

        </div>

        {{-- 搜尋與篩選 --}}
        <form method="GET" action="{{ url('/attractions') }}" class="mb-4">

            <div class="row g-3">

                {{-- 關鍵字 --}}
                <div class="col-10">
                    <label for="keyword" class="form-label">
                        關鍵字搜尋
                    </label>

                    <input type="text" id="keyword" name="keyword" class="form-control" placeholder="搜尋名稱、地址、介紹或特色"
                        value="{{ request('keyword') }}">
                </div>

                {{-- 按鈕 --}}
                <div class="col-md-2 d-flex align-items-end">

                    <button type="submit" class="btn btn-primary w-100">
                        搜尋
                    </button>

                </div>

                {{-- 城市 --}}
                <div class="col-md-5">
                    <label for="city" class="form-label">
                        城市／地區
                    </label>

                    <select id="city" name="city" class="form-select" onchange="this.form.submit()">
                        <option value="">全部城市</option>

                        @foreach ($cities as $city)
                            <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>
                                {{ $city }}
                            </option>
                        @endforeach

                    </select>
                </div>


                {{-- 分類 --}}
                <div class="col-md-5">
                    <label for="category_id" class="form-label">
                        景點分類
                    </label>

                    <select id="category_id" name="category_id" class="form-select" onchange="this.form.submit()">
                        <option value="">全部分類</option>

                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach

                    </select>
                </div>

                {{-- 排序欄位 --}}
                <div class="col-md-5 mb-3">
                    <label for="sort" class="form-label">
                        排序欄位
                    </label>

                    <select id="sort" name="sort" class="form-select" onchange="this.form.submit()">
                        <option value="created_at" {{ request('sort', 'created_at') == 'created_at' ? 'selected' : '' }}>
                            建立時間
                        </option>

                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>
                            景點名稱
                        </option>

                        <option value="city" {{ request('sort') == 'city' ? 'selected' : '' }}>
                            城市
                        </option>

                        <option value="category" {{ request('sort') == 'category' ? 'selected' : '' }}>
                            分類
                        </option>
                    </select>
                </div>

                {{-- 排序方向 --}}
                <div class="col-md-5 mb-3">
                    <label for="direction" class="form-label">
                        排序方向
                    </label>

                    <select id="direction" name="direction" class="form-select" onchange="this.form.submit()">
                        <option value="desc" {{ request('direction', 'desc') == 'desc' ? 'selected' : '' }}>
                            降冪
                        </option>

                        <option value="asc" {{ request('direction') == 'asc' ? 'selected' : '' }}>
                            升冪
                        </option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="per_page" class="form-label">
                        每頁顯示
                    </label>

                    <select id="per_page" name="per_page" class="form-select" onchange="this.form.submit()">
                        <option value="12" {{ request('per_page', 12) == 12 ? 'selected' : '' }}>
                            12 筆
                        </option>

                        <option value="24" {{ request('per_page') == 24 ? 'selected' : '' }}>
                            24 筆
                        </option>

                        <option value="36" {{ request('per_page') == 36 ? 'selected' : '' }}>
                            36 筆
                        </option>

                        <option value="48" {{ request('per_page') == 48 ? 'selected' : '' }}>
                            48 筆
                        </option>
                    </select>
                </div>

            </div>

        </form>

        {{-- 景點列表 --}}
        <div class="row g-4">

            @forelse ($attractions as $attraction)
                <div class="col-md-6 col-lg-4">

                    <div class="card h-100 shadow-sm">

                        {{-- 景點圖片 --}}
                        @if ($attraction->image)
                            <img src="{{ $attraction->image }}" class="card-img-top" alt="{{ $attraction->name }}"
                                style="height: 220px; object-fit: cover;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center" style="height: 220px;">
                                <span class="text-muted">
                                    暫無圖片
                                </span>
                            </div>
                        @endif


                        <div class="card-body d-flex flex-column">

                            {{-- 景點名稱 --}}
                            <h5 class="card-title">
                                {{ $attraction->name }}
                            </h5>


                            {{-- 城市與鄉鎮 --}}
                            <p class="text-muted mb-2">

                                {{ $attraction->city }}

                                @if ($attraction->town)
                                    {{ $attraction->town }}
                                @endif

                            </p>


                            {{-- 分類 --}}
                            @if ($attraction->category)
                                <div class="mb-3">

                                    <span class="badge bg-success">
                                        {{ $attraction->category->name }}
                                    </span>

                                </div>
                            @endif


                            {{-- 景點介紹 --}}
                            <p class="card-text">

                                {{ Str::limit($attraction->description ?? '未提供介紹', 100) }}

                            </p>


                            {{-- 詳細資訊按鈕 --}}
                            <div class="mt-auto">

                                <a href="{{ url('/attractions/' . $attraction->id) }}" class="btn btn-success">
                                    查看詳細資訊
                                </a>

                            </div>

                        </div>

                    </div>

                </div>

            @empty

                {{-- 沒有資料 --}}
                <div class="col-12">

                    <div class="alert alert-warning">
                        目前沒有景點資料。
                    </div>

                </div>
            @endforelse

            {{-- 分頁 --}}
            @if ($attractions->hasPages())
                <div class="mt-4 d-flex justify-content-center">
                    {{ $attractions->links() }}
                </div>
            @endif

        </div>

    </div>

@endsection
