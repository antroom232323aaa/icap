@extends('layouts.app')

@section('title', '首頁 | AI Travel Guide')

@section('content')

    {{-- Hero Section --}}
    <section class="site-hero">

        {{-- Banner 圖片 --}}
        <img src="{{ asset('images/home-banner.png') }}" class="site-hero-image" alt="台灣農村旅遊"
            style="height: 500px; object-fit: cover;">


        {{-- Banner 文字內容 --}}
        <div class="site-hero-overlay">

            <div class="container">

                <div class="col-lg-8">

                    <h1 class="site-hero-title">
                        台灣農村旅遊
                    </h1>

                    <p class="site-hero-text">
                        使用 AI Travel Guide，
                        探索台灣各地特色農村美食與住宿景點。
                    </p>

                    <div class="site-hero-actions">

                        <a href="{{ url('/attractions') }}" class="btn btn-success btn-lg me-2">
                            探索景點
                        </a>

                        <a href="{{ url('/statistics') }}" class="btn btn-outline-light btn-lg">
                            景點統計
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </section>


    {{-- 精選景點 Carousel --}}
    <section class="site-featured-section">

        <div class="container">

            <div class="row align-items-center">

                <div class="col-lg-6">
                    <div id="featuredAttractionsCarousel" class="carousel slide site-carousel" data-bs-ride="carousel"
                        data-bs-interval="4000">

                        {{-- 景點內容 --}}
                        <div class="carousel-inner" id="featuredAttractions">

                            {{-- jQuery 動態產生 --}}

                        </div>

                        {{-- 上一張 --}}
                        <button class="carousel-control-prev" type="button" data-bs-target="#featuredAttractionsCarousel"
                            data-bs-slide="prev">

                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>

                            <span class="visually-hidden">
                                上一張
                            </span>

                        </button>


                        {{-- 下一張 --}}
                        <button class="carousel-control-next" type="button" data-bs-target="#featuredAttractionsCarousel"
                            data-bs-slide="next">

                            <span class="carousel-control-next-icon" aria-hidden="true"></span>

                            <span class="visually-hidden">
                                下一張
                            </span>

                        </button>

                    </div>

                    {{-- 指示點 --}}
                    <div class="site-carousel-indicators" id="featuredAttractionsIndicators">

                        {{-- jQuery 動態產生 --}}

                    </div>
                </div>

                <div class="col-lg-6 p-5">

                    <p class="mb-4">
                        台灣農村旅遊不只是走訪景點，更是一場貼近土地與生活的旅行。從在地美食、農村住宿到自然風景，每個地方都有自己的特色與故事。放慢腳步，探索台灣各地的農村風情。
                    </p>

                    <p class="mb-4">
                        透過 AI Travel Guide，發現適合自己的農村旅程，品嚐在地滋味、探索特色景點，享受遠離城市喧囂的慢遊時光。
                    </p>

                </div>

            </div>
        </div>

    </section>



    {{-- Introduction --}}
    <section class="site-category-section">

        <div class="container">

            {{-- 農村美食 --}}
            <div class="row align-items-center g-4 site-category-row">

                {{-- AI 文字 --}}
                <div class="col-md-6 order-2 order-md-1">

                    <div class="site-category-content">

                        <h3 class="mb-3">
                            農村美食
                        </h3>

                        <p class="mb-4">
                            想深入認識一個地方，不妨從餐桌開始。
                        </p>

                        <p class="mb-4">
                            沿著在地食材探索農村料理，適合安排一趟以美食為主題的半日小旅行，邊吃邊認識土地與地方故事。
                        </p>

                        <a href="{{ url('/attractions?category_id=1') }}" class="btn btn-success">

                            查看農村美食

                        </a>

                    </div>

                </div>

                {{-- 圖片 --}}
                <div class="col-md-6 order-1 order-md-2">

                    <img src="{{ asset('images/rural-food.png') }}" class="site-category-image" alt="農村美食">

                </div>

            </div>


            {{-- 農村住宿 --}}
            <div class="row align-items-center g-4 site-category-row">

                {{-- 圖片 --}}
                <div class="col-md-6">

                    <img src="{{ asset('images/rural-stay.png') }}" class="site-category-image" alt="農村住宿">

                </div>

                {{-- AI 文字 --}}
                <div class="col-md-6">

                    <div class="site-category-content">

                        <h3 class="mb-3">
                            農村住宿
                        </h3>

                        <p class="mb-4">
                            想讓旅程慢下來，可以選擇住進農村。
                        </p>

                        <p class="mb-4">
                            白天探索周邊景點，傍晚回到住宿地點放鬆，適合安排週末小旅行，享受更悠閒的旅遊節奏。
                        </p>

                        <a href="{{ url('/attractions?category_id=2') }}" class="btn btn-success">

                            查看農村住宿

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </section>

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            loadFeaturedAttractions();

        });

        $('#featuredAttractionsCarousel').on('slid.bs.carousel', function(event) {

            const currentIndex = event.to;

            $('#featuredAttractionsIndicators .carousel-indicator-dot')
                .removeClass('active');

            $('#featuredAttractionsIndicators .carousel-indicator-dot')
                .eq(currentIndex)
                .addClass('active');

        });


        function loadFeaturedAttractions() {

            $.ajax({

                url: '/api/attractions',

                type: 'GET',

                data: {

                    random: true

                },

                success: function(response) {

                    renderFeaturedAttractions(response);

                },

                error: function() {

                    $('#featuredAttractions').html(`
                <div class="carousel-item active">

                    <div class="alert alert-secondary text-center">
                        暫時無法載入精選景點。
                    </div>

                </div>
            `);

                }

            });

        }


        function renderFeaturedAttractions(response) {

            let attractions = response.data;

            let html = '';
            let indicatorsHtml = '';


            if (!attractions || attractions.length === 0) {

                $('#featuredAttractions').html(`
            <div class="carousel-item active">

                <div class="alert alert-secondary text-center">
                    目前沒有可推薦的景點。
                </div>

            </div>
        `);

                $('#featuredAttractionsIndicators').html('');

                return;

            }


            $.each(attractions, function(index, attraction) {

                // Carousel 圖片
                html += `

            <div class="carousel-item ${index === 0 ? 'active' : ''}">

                <div class="row justify-content-center">

                    <div class="col-12">

                        <a href="/attractions/${attraction.id}"
                            class="text-decoration-none">

                            <div class="card shadow-sm overflow-hidden">

                                <img src="${attraction.image}"
                                    class="carousel-image"
                                    alt="${attraction.name}">

                                <div class="card-body text-center">

                                    <h4 class="card-title mb-0">
                                        ${attraction.name}
                                    </h4>

                                </div>

                            </div>

                        </a>

                    </div>

                </div>

            </div>

        `;


                // Carousel 指示點
                indicatorsHtml += `

            <span
        class="carousel-indicator-dot ${index === 0 ? 'active' : ''}"
        aria-hidden="true">
    </span>

        `;

            });


            // 顯示 Carousel
            $('#featuredAttractions').html(html);


            // 顯示指示點
            $('#featuredAttractionsIndicators').html(indicatorsHtml);

        }
    </script>
@endpush
