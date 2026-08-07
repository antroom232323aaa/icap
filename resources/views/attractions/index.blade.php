@extends('layouts.app')

@section('title', '景點列表 | AI Travel Guide')

@section('content')

    <div class="container py-5 attraction-page">

        {{-- 頁面標題 --}}
        <div class="attraction-page-header">

            <h1>
                景點列表
            </h1>

        </div>

        {{-- 搜尋與篩選 --}}
        <div class="attraction-filter-panel">

            <div class="row g-3">

                {{-- 關鍵字 --}}
                <div class="col-10">
                    <label for="keyword" class="form-label">
                        關鍵字搜尋
                    </label>

                    <input type="text" id="keyword" class="form-control" placeholder="搜尋名稱、地址、介紹或特色">
                </div>

                {{-- 按鈕 --}}
                <div class="col-md-2 d-flex align-items-end">

                    <button type="button" class="btn btn-primary w-100" id="searchBtn">
                        搜尋
                    </button>

                </div>

                {{-- 城市 --}}
                <div class="col-md-5">
                    <label for="city" class="form-label">
                        城市／地區
                    </label>

                    <select id="city" class="form-select">
                        <option value="">全部城市</option>

                        @foreach ($cities as $city)
                            <option value="{{ $city }}">
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

                    <select id="category_id" class="form-select">
                        <option value="">全部分類</option>

                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">
                                {{ $category->name }}
                            </option>
                        @endforeach

                    </select>
                </div>

                {{-- 排序欄位 --}}
                <div class="col-md-5 mb-3">
                    <label for="sort" class="form-label">
                        排序方式
                    </label>

                    <select id="sort" class="form-select">
                        <option value="created_at" selected>
                            建立時間
                        </option>

                        <option value="name">
                            景點名稱
                        </option>

                        <option value="city">
                            城市
                        </option>

                        <option value="category">
                            分類
                        </option>
                    </select>
                </div>

                {{-- 排序方向 --}}
                <div class="col-md-5 mb-3">
                    <label for="direction" class="form-label">
                        排序方向
                    </label>

                    <select id="direction" class="form-select">
                        <option value="asc">
                            正序
                        </option>

                        <option value="desc" selected>
                            倒序
                        </option>
                    </select>
                </div>

                {{-- 每頁顯示 --}}
                <div class="col-md-4">
                    <label for="per_page" class="form-label">
                        每頁顯示
                    </label>

                    <select id="per_page" class="form-select">
                        <option value="6" selected>
                            6 筆
                        </option>

                        <option value="9">
                            9 筆
                        </option>

                        <option value="12">
                            12 筆
                        </option>

                        <option value="18">
                            18 筆
                        </option>
                    </select>
                </div>

            </div>

        </div>


        {{-- 景點列表 --}}
        <div id="attractionsList" class="row g-4 attraction-list">

            <div class="col-12 text-center">
                <p>景點資料載入中...</p>
            </div>

        </div>

        <div class="attraction-pagination" id="pagination">
            <p>頁面載入中...</p>
        </div>

    </div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            const urlParams = new URLSearchParams(window.location.search);

            const categoryId = urlParams.get('category_id');

            if (categoryId) {

                $('#category_id').val(categoryId);

            }

            loadAttractions(1);

        });

        $('#searchBtn').on('click', function() {

            loadAttractions(1);

        });

        $('#city').on('change', function() {

            loadAttractions(1);

        });

        $('#category_id').on('change', function() {

            loadAttractions(1);

        });

        $('#sort').on('change', function() {

            loadAttractions(1);

        });

        $('#direction').on('change', function() {

            loadAttractions(1);

        });

        $('#per_page').on('change', function() {

            loadAttractions(1);

        });

        $(document).on('click', '.pagination-link', function(e) {

            e.preventDefault();

            const page = $(this).data('page');

            loadAttractions(page);

        });

        function loadAttractions(page = 1) {

            const params = {
                keyword: $('#keyword').val(),
                city: $('#city').val(),
                category_id: $('#category_id').val(),
                sort: $('#sort').val(),
                direction: $('#direction').val(),
                per_page: $('#per_page').val(),
                page: page
            };

            axios.get('/api/attractions', {
                    params: params
                })
                .then(function(response) {

                    const result = response.data.data;
                    const attractions = result.data;

                    let html = '';

                    if (attractions.length === 0) {

                        html = `
                            <div class="col-12">

                                <div class="alert alert-warning">
                                    目前沒有景點資料。
                                </div>

                            </div>
                        `;

                    } else {

                        $.each(attractions, function(index, attraction) {

                            let description = attraction.description ?? '未提供介紹';

                            // 簡介最多顯示約 60 字
                            if (description.length > 60) {
                                description = description.substring(0, 60) + '...';
                            }


                            html += `
        <div class="col-md-6 col-lg-4">

            <div class="attraction-card">

                ${
                    attraction.image
                    ? `
                                                    <img
                                                        src="${attraction.image}"
                                                        class="attraction-card-image"
                                                        alt="${attraction.name}">
                                                `
                    : `
                                                    <div class="attraction-card-no-image">
                                                        <span>
                                                            暫無圖片
                                                        </span>
                                                    </div>
                                                `
                }


                <div class="attraction-card-body">

                    <h5 class="attraction-card-title">
                        ${attraction.name}
                    </h5>


                    <p class="attraction-card-location">

                        ${attraction.city ?? ''}

                        ${attraction.town
                            ? `${attraction.town}`
                            : ''
                        }

                    </p>


                    ${
                        attraction.category
                        ? `
                                                        <span class="attraction-card-category">
                                                            ${attraction.category.name}
                                                        </span>
                                                    `
                        : ''
                    }


                    <p class="attraction-card-description">
                        ${description}
                    </p>


                    <div class="mt-auto">

                        <a
                            href="/attractions/${attraction.id}"
                            class="btn btn-success attraction-card-button">

                            查看詳細資訊

                        </a>

                    </div>

                </div>

            </div>

        </div>
    `;

                        });

                    }

                    $('#attractionsList').html(html);

                    renderPagination(result);

                })
                .catch(function(error) {

                    console.error(error);

                    $('#attractionsList').html(
                        `<div class="col-12">
                            <div class="alert alert-danger">
                                景點資料載入失敗
                            </div>
                        </div>`
                    );

                });

        }

        function renderPagination(result) {

            let html = '';

            if (result.last_page <= 1) {
                $('#pagination').html('');
                return;
            }


            // 上一頁
            if (result.current_page > 1) {

                html += `
            <li class="page-item">
                <a class="page-link pagination-link"
                   href="#"
                   data-page="${result.current_page - 1}">
                    上一頁
                </a>
            </li>
        `;

            }


            // 第一頁
            html += `
        <li class="page-item ${result.current_page === 1 ? 'active' : ''}">
            <a class="page-link pagination-link"
               href="#"
               data-page="1">
                1
            </a>
        </li>
    `;


            // 決定顯示範圍
            let pageRange = 1;

            if (window.innerWidth >= 1200) {

                pageRange = 3;

            } else if (window.innerWidth >= 768) {

                pageRange = 2;

            } else {

                pageRange = 1;

            }


            let startPage = Math.max(2, result.current_page - pageRange);

            let endPage = Math.min(
                result.last_page - 1,
                result.current_page + pageRange
            );

            // 第一頁與中間頁碼之間
            if (startPage > 2) {

                html += `
            <li class="page-item disabled">
                <span class="page-link">
                    ...
                </span>
            </li>
        `;

            }


            // 中間頁碼
            for (let page = startPage; page <= endPage; page++) {

                html += `
            <li class="page-item ${page === result.current_page ? 'active' : ''}">
                <a class="page-link pagination-link"
                   href="#"
                   data-page="${page}">
                    ${page}
                </a>
            </li>
        `;

            }


            // 中間頁碼與最後一頁之間
            if (endPage < result.last_page - 1) {

                html += `
            <li class="page-item disabled">
                <span class="page-link">
                    ...
                </span>
            </li>
        `;

            }


            // 最後一頁
            if (result.last_page > 1) {

                html += `
            <li class="page-item ${result.current_page === result.last_page ? 'active' : ''}">
                <a class="page-link pagination-link"
                   href="#"
                   data-page="${result.last_page}">
                    ${result.last_page}
                </a>
            </li>
        `;

            }


            // 下一頁
            if (result.current_page < result.last_page) {

                html += `
            <li class="page-item">
                <a class="page-link pagination-link"
                   href="#"
                   data-page="${result.current_page + 1}">
                    下一頁
                </a>
            </li>
        `;

            }


            $('#pagination').html(`
        <nav aria-label="景點分頁">
            <ul class="pagination justify-content-center flex-wrap">
                ${html}
            </ul>
        </nav>
    `);

        }
    </script>
@endpush
