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

                <p class="text-muted mb-0">
                    管理網站中的旅遊景點資料。
                </p>

            </div>


            <div>

                <a href="/admin/attractions/create" class="btn btn-primary">
                    新增景點
                </a>

            </div>

        </div>

        {{-- 景點統計 --}}
        <div class="card mb-4">

            <div class="card-body">

                <h5 class="card-title">
                    景點資料
                </h5>

                <p class="card-text mb-0">

                    目前共有

                    <strong>
                        {{ $attractions->count() }}
                    </strong>

                    筆景點資料。

                </p>

            </div>

        </div>


        {{-- 景點列表 --}}
        <div class="row g-4">

            @if ($attractions->isEmpty())

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
            @else
                @foreach ($attractions as $attraction)
                    <div class="col-12">

                        <div class="card">

                            <div class="row g-0">

                                {{-- 圖片 --}}
                                <div class="col-md-3">

                                    @if ($attraction->image)
                                        <img src="{{ $attraction->image }}" alt="{{ $attraction->name }}"
                                            class="img-fluid rounded-start h-100">
                                    @else
                                        <div class="p-4 text-center">
                                            無圖片
                                        </div>
                                    @endif

                                </div>


                                {{-- 景點資料 --}}
                                <div class="col-md-7">

                                    <div class="card-body">

                                        <h5 class="card-title">
                                            {{ $attraction->name }}
                                        </h5>


                                        <p class="card-text">

                                            <strong>
                                                ID：
                                            </strong>

                                            {{ $attraction->id }}

                                        </p>


                                        <p class="card-text">

                                            <strong>
                                                分類：
                                            </strong>

                                            {{ $attraction->category->name ?? '未分類' }}

                                        </p>


                                        <p class="card-text">

                                            <strong>
                                                地區：
                                            </strong>

                                            {{ $attraction->city }}
                                            {{ $attraction->town }}

                                        </p>


                                        <p class="card-text">

                                            <strong>
                                                地址：
                                            </strong>

                                            {{ $attraction->address }}

                                        </p>


                                        <p class="card-text text-muted">

                                            {{ $attraction->description }}

                                        </p>

                                    </div>

                                </div>


                                {{-- 操作 --}}
                                <div class="col-md-2">

                                    <div class="card-body">

                                        <div class="d-grid gap-2">

                                            <a href="/admin/attractions/edit/{{ $attraction->id }}"
                                                class="btn btn-secondary">
                                                編輯
                                            </a>


                                            <form action="/admin/attractions/{{ $attraction->id }}" method="POST">

                                                @csrf

                                                @method('DELETE')

                                                <button type="submit" class="btn btn-danger w-100">
                                                    刪除
                                                </button>

                                            </form>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>
                @endforeach

            @endif

        </div>

    </div>

@endsection

@push('scripts')

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
