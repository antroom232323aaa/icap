@extends('layouts.admin')


@section('title', '景點管理')


@section('content')

    <div class="container py-5">

        {{-- 頁面標題 --}}
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h1 class="mb-2">
                    景點管理
                </h1>

            </div>


            <div>

                <a href="/admin/attractions/create" class="btn btn-primary">
                    新增景點
                </a>

            </div>

        </div>

        {{-- 搜尋與篩選 --}}
        <div class="mb-4">

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
                        排序欄位
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
        <div class="row" id="adminAttractionsList">

            <div class="text-center py-4">
                <p>景點資料載入中...</p>
            </div>

        </div>

        {{-- 分頁 --}}
        <div id="adminPagination" class="mt-4"></div>

    </div>

    </div>

@endsection

@push('scripts')

    <script>
        $(document).ready(function() {

            loadAdminAttractions(1);

        });

        $('#searchBtn').on('click', function() {

            loadAdminAttractions(1);

        });

        $('#city').on('change', function() {

            loadAdminAttractions(1);

        });

        $('#category_id').on('change', function() {

            loadAdminAttractions(1);

        });

        $('#sort').on('change', function() {

            loadAdminAttractions(1);

        });

        $('#direction').on('change', function() {

            loadAdminAttractions(1);

        });

        $('#per_page').on('change', function() {

            loadAdminAttractions(1);

        });

        $(document).on('click', '.pagination-link', function(e) {

            e.preventDefault();

            const page = $(this).data('page');

            loadAdminAttractions(page);

        });


        function loadAdminAttractions(page) {

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


                    // 沒有資料
                    if (!attractions || attractions.length === 0) {

                        html = `
                    <div class="col-12">

                        <div class="alert alert-secondary">

                            <p class="mb-3">
                                目前沒有景點資料。
                            </p>

                            <a href="/admin/attractions/create" class="btn btn-primary">
                                新增第一筆景點
                            </a>

                        </div>

                    </div>
                `;

                        $('#adminAttractionsList').html(html);

                        $('#adminPagination').html('');

                        return;
                    }


                    // 景點資料
                    $.each(attractions, function(index, attraction) {

                        let imageHtml = '';

                        if (attraction.image) {

                            imageHtml = `
                        <img src="${escapeHtml(attraction.image)}"
                            alt="${escapeHtml(attraction.name)}"
                            class="card-img-top"
                 style="height: 220px; object-fit: cover;">
                    `;

                        } else {

                            imageHtml = `
                        <div class="p-4 text-center">
                            無圖片
                        </div>
                    `;

                        }


                        const categoryName = attraction.category ?
                            attraction.category.name :
                            '未分類';


                        html += `

                    <div class="col-md-6 col-lg-4 mb-3">

                        <div class="card h-100 shadow-sm">

                            

                                {{-- 圖片 --}}
                                
                                    ${imageHtml}

                                


                                {{-- 景點資料 --}}
                                

                                    <div class="card-body">

                                        <h5 class="card-title">
                                            ${escapeHtml(attraction.name)}
                                        </h5>


                                        <p class="card-text">

                                            <strong>
                                                ID：
                                            </strong>

                                            ${attraction.id}

                                        </p>


                                        <p class="card-text">

                                            <strong>
                                                分類：
                                            </strong>

                                            ${escapeHtml(categoryName)}

                                        </p>


                                        <p class="card-text">

                                            <strong>
                                                地區：
                                            </strong>

                                            ${escapeHtml(attraction.city ?? '')}
                                            ${escapeHtml(attraction.town ?? '')}

                                        </p>


                                        <p class="card-text">

                                            <strong>
                                                地址：
                                            </strong>

                                            ${escapeHtml(attraction.address ?? '')}

                                        </p>

                                    </div>

                                


                                {{-- 操作 --}}

                                    <div class="card-footer">

                                        <div class="d-grid gap-2 d-md-flex">

                                            <a href="/admin/attractions/edit/${attraction.id}"
                                                class="btn btn-secondary flex-fill">
                                                編輯
                                            </a>


                                            <button type="button"
                                                class="btn btn-danger flex-fill deleteAttraction"
                                                data-id="${attraction.id}">
                                                刪除
                                            </button>

                                        </div>

                                    </div>

                            

                        </div>

                    </div>

                `;

                    });


                    $('#adminAttractionsList').html(html);


                    // 建立分頁
                    renderAdminPagination(result);

                })
                .catch(function(error) {

                    console.error(error);

                    $('#adminAttractionsList').html(`
                <div class="col-12">

                    <div class="alert alert-danger">
                        景點資料載入失敗，請稍後再試。
                    </div>

                </div>
            `);

                    $('#adminPagination').html('');

                });

        }


        // 分頁
        function renderAdminPagination(result) {

            let paginationHtml = '';

            const currentPage = result.current_page;
            const lastPage = result.last_page;


            if (lastPage <= 1) {

                $('#adminPagination').html('');

                return;

            }


            // 根據螢幕寬度決定顯示頁碼數量
            let pageRange = 1;

            if (window.innerWidth >= 1200) {

                pageRange = 3;

            } else if (window.innerWidth >= 768) {

                pageRange = 2;

            } else {

                pageRange = 1;

            }


            let startPage = Math.max(
                2,
                currentPage - pageRange
            );

            let endPage = Math.min(
                lastPage - 1,
                currentPage + pageRange
            );


            paginationHtml += `
        <nav aria-label="景點分頁">

            <ul class="pagination justify-content-center flex-wrap">
    `;


            // 上一頁
            if (currentPage > 1) {

                paginationHtml += `
            <li class="page-item">

                <a href="#"
                   class="page-link adminPage"
                   data-page="${currentPage - 1}">

                    上一頁

                </a>

            </li>
        `;

            }


            // 第一頁
            paginationHtml += `
        <li class="page-item ${currentPage === 1 ? 'active' : ''}">

            <a href="#"
               class="page-link adminPage"
               data-page="1">

                1

            </a>

        </li>
    `;


            // 第一頁與中間頁碼之間
            if (startPage > 2) {

                paginationHtml += `
            <li class="page-item disabled">

                <span class="page-link">
                    ...
                </span>

            </li>
        `;

            }


            // 中間頁碼
            for (let page = startPage; page <= endPage; page++) {

                paginationHtml += `
            <li class="page-item ${page === currentPage ? 'active' : ''}">

                <a href="#"
                   class="page-link adminPage"
                   data-page="${page}">

                    ${page}

                </a>

            </li>
        `;

            }


            // 中間頁碼與最後一頁之間
            if (endPage < lastPage - 1) {

                paginationHtml += `
            <li class="page-item disabled">

                <span class="page-link">
                    ...
                </span>

            </li>
        `;

            }


            // 最後一頁
            if (lastPage > 1) {

                paginationHtml += `
            <li class="page-item ${currentPage === lastPage ? 'active' : ''}">

                <a href="#"
                   class="page-link adminPage"
                   data-page="${lastPage}">

                    ${lastPage}

                </a>

            </li>
        `;

            }


            // 下一頁
            if (currentPage < lastPage) {

                paginationHtml += `
            <li class="page-item">

                <a href="#"
                   class="page-link adminPage"
                   data-page="${currentPage + 1}">

                    下一頁

                </a>

            </li>
        `;

            }


            paginationHtml += `
            </ul>

        </nav>
    `;


            $('#adminPagination').html(paginationHtml);

        }


        // 點擊分頁
        $(document).on('click', '.adminPage', function(event) {

            event.preventDefault();

            const page = $(this).data('page');

            loadAdminAttractions(page);

        });


        // HTML 安全處理
        function escapeHtml(text) {

            return $('<div>')
                .text(text)
                .html();

        }

        $(document).on('click', '.deleteAttraction', function() {

            const id = $(this).data('id');

            Swal.fire({
                icon: 'warning',
                title: '確定要刪除嗎？',
                text: '刪除後將無法復原。',
                showCancelButton: true,
                confirmButtonText: '確定刪除',
                cancelButtonText: '取消',
                allowOutsideClick: false
            }).then(function(result) {

                if (!result.isConfirmed) {
                    return;
                }

                deleteAttraction(id);

            });

        });

        function deleteAttraction(id) {

            axios.delete('/api/attractions/' + id)

                .then(function(response) {

                    console.log(response.data);

                    Swal.fire({
                            icon: 'success',
                            title: '刪除成功',
                            text: '景點資料已刪除。',
                            confirmButtonText: '確定',
                            allowOutsideClick: false
                        })
                        .then(function() {

                            loadAdminAttractions(1);

                        });

                })

                .catch(function(error) {

                    console.error(error);

                    if (error.response && error.response.status === 404) {

                        Swal.fire({
                            icon: 'warning',
                            title: '刪除失敗',
                            text: '找不到指定的景點資料。',
                            allowOutsideClick: false
                        });

                        return;
                    }


                    Swal.fire({
                        icon: 'error',
                        title: '刪除失敗',
                        text: '景點刪除失敗，請稍後再試。',
                        allowOutsideClick: false
                    });

                });

        }
    </script>

    {{-- 成功訊息 --}}
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: '操作成功',
                text: '{{ session('success') }}',
                confirmButtonText: '確定'
            });
        </script>
    @endif

@endpush
