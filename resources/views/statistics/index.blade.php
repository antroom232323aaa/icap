@extends('layouts.app')

@section('title', '景點詳細資訊 | AI Travel Guide')

@section('content')

    <div class="container py-5 statistics-page">

        {{-- 頁面標題 --}}
        <div class="statistics-page-header">

            <h1>
                景點統計
            </h1>

        </div>


        {{-- 農村美食 --}}
        <section class="statistics-card">

            <div class="statistics-card-header">

                <h2>
                    農村美食｜各縣市景點數量
                </h2>

            </div>

            <div class="statistics-chart">
                <canvas id="foodChart"></canvas>
            </div>

        </section>


        {{-- 農村住宿 --}}
        <section class="statistics-card">

            <div class="statistics-card-header">

                <h2>
                    農村住宿｜各縣市景點數量
                </h2>

            </div>

            <div class="statistics-chart">
                <canvas id="stayChart"></canvas>
            </div>

        </section>

    </div>

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

    <script>
        let foodChart = null;
        let stayChart = null;

        window.addEventListener('resize', function() {

            const xAxisSettings = getXAxisSettings();

            foodChart.options.scales.x.ticks.font.size =
                xAxisSettings.fontSize;

            foodChart.options.scales.x.ticks.maxRotation =
                xAxisSettings.rotation;

            foodChart.options.scales.x.ticks.minRotation =
                xAxisSettings.rotation;

            stayChart.options.scales.x.ticks.font.size =
                xAxisSettings.fontSize;

            stayChart.options.scales.x.ticks.maxRotation =
                xAxisSettings.rotation;

            stayChart.options.scales.x.ticks.minRotation =
                xAxisSettings.rotation;


            foodChart.update('none');

            stayChart.update('none');

        });

        $.ajax({
            url: '/api/statistics',
            method: 'GET',

            success: function(result) {

                if (result.status !== 'success') {
                    return;
                }

                const foodData = result.data.food.map(item => item.total);
                const stayData = result.data.stay.map(item => item.total);

                const maxValue = Math.max(
                    ...foodData,
                    ...stayData
                );

                const chartMax = Math.ceil(maxValue * 1.05 / 5) * 5;

                const xAxisSettings = getXAxisSettings();

                // =========================
                // 農村美食
                // =========================

                const foodLabels = result.data.food.map(item => item.city);

                const foodCtx = document
                    .getElementById('foodChart')
                    .getContext('2d');


                foodChart = new Chart(foodCtx, {

                    type: 'bar',

                    data: {

                        labels: foodLabels,

                        datasets: [{
                            label: '景點數量',
                            data: foodData,

                            backgroundColor: '#8FAF7A',
                            borderColor: '#6F8F5F',
                            borderWidth: 1
                        }]

                    },

                    plugins: [ChartDataLabels],

                    options: {

                        responsive: true,

                        maintainAspectRatio: false,

                        plugins: {

                            legend: {
                                display: false
                            },

                            datalabels: {
                                anchor: 'end',
                                align: 'top',
                                formatter: function(value) {
                                    return value;
                                }
                            }

                        },

                        scales: {

                            x: {

                                ticks: {

                                    autoSkip: false,

                                    maxRotation: xAxisSettings.rotation,

                                    minRotation: xAxisSettings.rotation,

                                    font: {
                                        size: xAxisSettings.fontSize
                                    }

                                }

                            },

                            y: {

                                beginAtZero: true,

                                max: chartMax,

                                ticks: {
                                    precision: 0
                                }

                            }

                        }

                    }

                });


                // =========================
                // 農村住宿
                // =========================

                const stayLabels = result.data.stay.map(item => item.city);

                const stayCtx = document
                    .getElementById('stayChart')
                    .getContext('2d');


                stayChart = new Chart(stayCtx, {

                    type: 'bar',

                    data: {

                        labels: stayLabels,

                        datasets: [{
                            label: '景點數量',
                            data: stayData,

                            backgroundColor: '#5F8063',
                            borderColor: '#456348',
                            borderWidth: 1
                        }]

                    },

                    plugins: [ChartDataLabels],

                    options: {

                        responsive: true,

                        maintainAspectRatio: false,

                        plugins: {

                            legend: {
                                display: false
                            },

                            datalabels: {
                                anchor: 'end',
                                align: 'top',
                                formatter: function(value) {
                                    return value;
                                }
                            }

                        },

                        scales: {

                            x: {

                                ticks: {

                                    autoSkip: false,

                                    maxRotation: xAxisSettings.rotation,

                                    minRotation: xAxisSettings.rotation,

                                    font: {
                                        size: xAxisSettings.fontSize
                                    }

                                }

                            },

                            y: {

                                beginAtZero: true,

                                max: chartMax,

                                ticks: {
                                    precision: 0
                                }

                            }

                        }

                    }

                });

            },

            error: function() {

                alert('統計資料取得失敗');

            }

        });

        function getXAxisSettings() {

            let fontSize = 12;
            let rotation = 0;

            if (window.innerWidth < 992) {

                fontSize = 12;
                rotation = 45;

            }

            if (window.innerWidth < 576) {

                fontSize = 10;
                rotation = 90;

            }

            return {
                fontSize: fontSize,
                rotation: rotation
            };

        }
    </script>
@endpush
