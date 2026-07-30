@extends('layouts.app')

@section('title', $attraction->name . ' | AI Travel Guide')

@section('content')

    <div class="container py-5">

        {{-- 返回列表 --}}
        <div class="mb-4">

            <a href="{{ url('/attractions') }}" class="btn btn-outline-secondary">
                ← 返回景點列表
            </a>

        </div>


        {{-- 景點詳細資料 --}}
        <div class="card shadow-sm overflow-hidden">

            {{-- 景點圖片 --}}
            @if ($attraction->image)
                <img src="{{ $attraction->image }}" class="card-img-top" alt="{{ $attraction->name }}"
                    style="max-height: 500px; object-fit: cover;">
            @endif


            <div class="card-body p-4">

                {{-- 景點名稱 --}}
                <h1 class="card-title">
                    {{ $attraction->name }}
                </h1>


                {{-- 分類 --}}
                @if ($attraction->category)
                    <span class="badge bg-success mb-3">
                        {{ $attraction->category->name }}
                    </span>
                @endif


                {{-- 地區 --}}
                <p class="text-muted">

                    {{ $attraction->city }}

                    @if ($attraction->town)
                        {{ $attraction->town }}
                    @endif

                </p>


                <hr>


                {{-- 地址 --}}
                <h3 class="mt-4">
                    地址
                </h3>

                <p>
                    {{ $attraction->address ?? '未提供地址' }}
                </p>


                {{-- 景點介紹 --}}
                <h3 class="mt-4">
                    景點介紹
                </h3>

                <p>
                    {!! nl2br(e($attraction->description ?? '未提供介紹')) !!}
                </p>


                {{-- 特色 --}}
                <h3 class="mt-4">
                    特色
                </h3>

                <p>
                    {!! nl2br(e($attraction->feature ?? '未提供特色資訊')) !!}
                </p>


                {{-- 官方網站 --}}
                @if ($attraction->website)
                    <div class="mt-4">

                        <a href="{{ $attraction->website }}" target="_blank" rel="noopener noreferrer"
                            class="btn btn-success">
                            前往官方網站
                        </a>

                    </div>
                @endif

            </div>

        </div>

    </div>

@endsection
