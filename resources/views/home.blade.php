@extends('layouts.app')

@section('title', '首頁 | AI Travel Guide')

@section('content')

    {{-- Hero Section --}}
    <section class="bg-light py-5">
        <div class="container py-5">

            <div class="row align-items-center">

                <div class="col-lg-8">

                    <h1 class="display-4 fw-bold">
                        探索台灣農村旅遊
                    </h1>

                    <p class="lead mt-3">
                        使用 AI Travel Guide，
                        探索台灣各地特色農村美食與住宿景點。
                    </p>

                    <div class="mt-4">

                        <a href="{{ url('/attractions') }}" class="btn btn-success btn-lg me-2">
                            探索景點
                        </a>

                        <a href="{{ url('/admin/attractions') }}" class="btn btn-outline-success btn-lg">
                            景點管理
                        </a>

                    </div>

                </div>

            </div>

        </div>
    </section>


    {{-- Introduction --}}
    <section class="py-5">

        <div class="container">

            <div class="text-center mb-5">

                <h2>
                    AI Travel Guide
                </h2>

                <p class="text-muted">
                    發現台灣農村旅遊的特色景點
                </p>

            </div>


            <div class="row g-4">

                {{-- 農村美食 --}}
                <div class="col-md-6">

                    <div class="card h-100 shadow-sm">

                        <div class="card-body">

                            <h3 class="card-title">
                                農村美食
                            </h3>

                            <p class="card-text">
                                探索台灣各地農村特色料理、
                                在地食材與特色餐飲。
                            </p>

                            <a href="{{ url('/attractions') }}" class="btn btn-success">
                                查看景點
                            </a>

                        </div>

                    </div>

                </div>


                {{-- 農村住宿 --}}
                <div class="col-md-6">

                    <div class="card h-100 shadow-sm">

                        <div class="card-body">

                            <h3 class="card-title">
                                農村住宿
                            </h3>

                            <p class="card-text">
                                探索各地特色農村住宿，
                                體驗不同的農村生活。
                            </p>

                            <a href="{{ url('/attractions') }}" class="btn btn-success">
                                查看景點
                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

@endsection
