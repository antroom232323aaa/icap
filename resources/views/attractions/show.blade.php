@extends('layouts.app')

@section('title', '景點詳細資訊 | AI Travel Guide')

@section('content')

    <div class="container py-5 attraction-detail-page">

        {{-- 返回列表 --}}
        <div class="attraction-detail-back">

            <a href="{{ url('/attractions') }}" class="btn btn-outline-secondary attraction-back-button">

                ← 返回景點列表

            </a>

        </div>


        {{-- 景點詳細內容 --}}
        <div id="attractionDetail">

            <div class="text-center py-5">

                <p class="text-muted mb-0">
                    景點資料載入中...
                </p>

            </div>

        </div>

    </div>

@endsection


@push('scripts')
    <script>
        const attractionId = @json($id);


        // 避免 API 回傳的文字直接插入 HTML
        function escapeHtml(text) {

            return $('<div>')
                .text(text)
                .html();

        }


        axios.get(`/api/attractions/${attractionId}`)

            .then(function(response) {

                const attraction = response.data.data;


                $('title').text(
                    `${attraction.name} | AI Travel Guide`
                );


                // =========================
                // 景點圖片
                // =========================

                let imageHtml = '';

                if (attraction.image) {

                    imageHtml = `
                        <div class="attraction-detail-image-wrapper">

                            <img
                                src="${escapeHtml(attraction.image)}"
                                class="attraction-detail-image"
                                alt="${escapeHtml(attraction.name)}">

                        </div>
                    `;

                }


                // =========================
                // 分類
                // =========================

                let categoryHtml = '';

                if (attraction.category) {

                    categoryHtml = `
                        <span class="attraction-detail-category">

                            ${escapeHtml(attraction.category.name)}

                        </span>
                    `;

                }


                // =========================
                // 地區
                // =========================

                let townHtml = '';

                if (attraction.town) {

                    townHtml = `
                        ${escapeHtml(attraction.town)}
                    `;

                }


                // =========================
                // 地址
                // =========================

                const address = attraction.address ?
                    escapeHtml(attraction.address) :
                    '未提供地址';


                // =========================
                // 景點特色
                // =========================

                const feature = attraction.feature ?
                    escapeHtml(attraction.feature).replace(/\n/g, '<br>') :
                    '未提供特色資訊';


                // =========================
                // 官方網站
                // =========================

                let websiteHtml = '';

                if (attraction.website != "未提供網站") {

                    websiteHtml = `
                        <div class="attraction-detail-website">

                            <a
                                href="${escapeHtml(attraction.website)}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="btn btn-success attraction-website-button">

                                前往官方網站

                            </a>

                        </div>
                    `;

                } else {
                    websiteHtml = `
                        <div class="attraction-detail-website">

                            <a
                                target="_blank"
                                rel="noopener noreferrer"
                                class="btn btn-success attraction-website-button" >

                                未提供網站連結

                            </a>

                        </div>
                    `;
                }


                // =========================
                // 景點內容
                // =========================

                const html = `

                    <article class="attraction-detail-card">


                        {{-- 景點圖片 --}}
                        ${imageHtml}


                        {{-- 景點標題 --}}
                        <div class="attraction-detail-header">

                            ${categoryHtml}


                            <h1 class="attraction-detail-title">

                                ${escapeHtml(attraction.name)}

                            </h1>


                            <p class="attraction-detail-location">

                                ${escapeHtml(attraction.city ?? '')}

                                ${townHtml}

                            </p>

                        </div>


                        {{-- 景點資訊 --}}
                        <div class="attraction-detail-content">


                            {{-- 地址 --}}
                            <section class="attraction-detail-section">

                                <h2 class="attraction-detail-section-title">

                                    地址

                                </h2>

                                <p class="attraction-detail-address">

                                    ${address}

                                </p>

                            </section>


                            {{-- 景點特色 --}}
                            <section class="attraction-detail-section">

                                <h2 class="attraction-detail-section-title">

                                    景點特色

                                </h2>

                                <p class="attraction-detail-feature">

                                    ${feature}

                                </p>

                            </section>


                            {{-- 官方網站 --}}
                            ${websiteHtml}


                        </div>

                    </article>

                `;


                $('#attractionDetail').html(html);

            })


            .catch(function(error) {

                console.error(error);


                if (error.response && error.response.status === 404) {

                    $('#attractionDetail').html(`

                        <div class="alert alert-warning attraction-detail-alert">

                            找不到指定的景點資料。

                        </div>

                    `);

                } else {

                    $('#attractionDetail').html(`

                        <div class="alert alert-danger attraction-detail-alert">

                            景點資料載入失敗。

                        </div>

                    `);

                }

            });
    </script>
@endpush
