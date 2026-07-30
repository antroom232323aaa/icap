@extends('layouts.admin')


@section('title', '新增景點')


@section('content')

    <div class="container py-5">

        {{-- 頁面標題 --}}
        <div class="mb-4">

            <h1>
                新增景點
            </h1>

            <p class="text-muted">
                建立新的旅遊景點資料。
            </p>

        </div>

        {{-- 新增表單 --}}
        <div class="card">

            <div class="card-body">

                <form action="/admin/attractions" method="POST" id="attractionForm">

                    @csrf


                    {{-- 景點名稱 --}}
                    <div class="mb-3">

                        <label for="name" class="form-label">
                            景點名稱
                        </label>

                        <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}"
                            placeholder="請輸入景點名稱">

                        <div id="nameError" class="text-danger mt-1"></div>

                    </div>


                    {{-- 分類 --}}
                    <div class="mb-3">

                        <label for="category_id" class="form-label">
                            景點分類
                        </label>

                        <select id="category_id" name="category_id" class="form-select">

                            <option value="">
                                請選擇分類
                            </option>

                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                                    {{ $category->name }}
                                </option>
                            @endforeach

                        </select>

                        <div id="categoryIdError" class="text-danger mt-1"></div>

                    </div>


                    {{-- 城市 --}}
                    <div class="mb-3">

                        <label for="city" class="form-label">
                            城市／縣市
                        </label>

                        <input type="text" id="city" name="city" class="form-control" value="{{ old('city') }}"
                            placeholder="例如：宜蘭縣">

                        <div id="cityError" class="text-danger mt-1"></div>

                    </div>


                    {{-- 鄉鎮 --}}
                    <div class="mb-3">

                        <label for="town" class="form-label">
                            鄉鎮／地區
                        </label>

                        <input type="text" id="town" name="town" class="form-control" value="{{ old('town') }}"
                            placeholder="例如：大同鄉">

                        <div id="townError" class="text-danger mt-1"></div>

                    </div>


                    {{-- 地址 --}}
                    <div class="mb-3">

                        <label for="address" class="form-label">
                            地址
                        </label>

                        <input type="text" id="address" name="address" class="form-control"
                            value="{{ old('address') }}" placeholder="請輸入景點地址">

                        <div id="addressError" class="text-danger mt-1"></div>

                    </div>


                    {{-- 圖片網址 --}}
                    <div class="mb-3">

                        <label for="image" class="form-label">
                            圖片網址
                        </label>

                        <input type="url" id="image" name="image" class="form-control" value="{{ old('image') }}"
                            placeholder="https://example.com/image.jpg">

                        <div id="imageError" class="text-danger mt-1"></div>

                    </div>


                    {{-- 景點介紹 --}}
                    <div class="mb-3">

                        <label for="description" class="form-label">
                            景點介紹
                        </label>

                        <textarea id="description" name="description" class="form-control" rows="5" placeholder="請輸入景點介紹">{{ old('description') }}</textarea>

                        <div id="descriptionError" class="text-danger mt-1"></div>

                    </div>


                    {{-- 特色 --}}
                    <div class="mb-3">

                        <label for="feature" class="form-label">
                            景點特色
                        </label>

                        <textarea id="feature" name="feature" class="form-control" rows="4" placeholder="請輸入景點特色">{{ old('feature') }}</textarea>

                    </div>


                    {{-- 官方網站 --}}
                    <div class="mb-4">

                        <label for="website" class="form-label">
                            官方網站
                        </label>

                        <input type="url" id="website" name="website" class="form-control"
                            value="{{ old('website') }}" placeholder="https://example.com">

                    </div>


                    {{-- 操作按鈕 --}}
                    <div class="d-flex gap-2">

                        <button type="submit" class="btn btn-primary">
                            新增景點
                        </button>


                        <a href="/admin/attractions" class="btn btn-secondary">
                            取消
                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            // ==============================
            // 欄位驗證函式
            // ==============================

            function validateName() {

                if ($('#name').val().trim() === '') {

                    $('#nameError').text('請輸入景點名稱。');

                    return false;

                }

                $('#nameError').text('');

                return true;

            }


            function validateCategory() {

                if ($('#category_id').val() === '') {

                    $('#categoryIdError').text('請選擇景點分類。');

                    return false;

                }

                $('#categoryIdError').text('');

                return true;

            }


            function validateCity() {

                if ($('#city').val().trim() === '') {

                    $('#cityError').text('請輸入城市或地區。');

                    return false;

                }

                $('#cityError').text('');

                return true;

            }


            function validateTown() {

                if ($('#town').val().trim() === '') {

                    $('#townError').text('請輸入鄉鎮或地區。');

                    return false;

                }

                $('#townError').text('');

                return true;

            }


            function validateAddress() {

                if ($('#address').val().trim() === '') {

                    $('#addressError').text('請輸入景點地址。');

                    return false;

                }

                $('#addressError').text('');

                return true;

            }


            function validateImage() {

                if ($('#image').val().trim() === '') {

                    $('#imageError').text('請輸入圖片網址。');

                    return false;

                }

                if (!$('#image')[0].checkValidity()) {

                    $('#imageError').text('請輸入有效的圖片網址。');

                    return false;

                }

                $('#imageError').text('');

                return true;

            }


            function validateDescription() {

                if ($('#description').val().trim() === '') {

                    $('#descriptionError').text('請輸入景點介紹。');

                    return false;

                }

                $('#descriptionError').text('');

                return true;

            }


            // ==============================
            // 即時監聽
            // ==============================

            $('#name').on('input', function() {

                validateName();

            });


            $('#category_id').on('change', function() {

                validateCategory();

            });


            $('#city').on('input', function() {

                validateCity();

            });


            $('#town').on('input', function() {

                validateTown();

            });


            $('#address').on('input', function() {

                validateAddress();

            });


            $('#image').on('input', function() {

                validateImage();

            });


            $('#description').on('input', function() {

                validateDescription();

            });


            // ==============================
            // 表單送出前再次驗證
            // ==============================

            $('#attractionForm').on('submit', function(event) {

                const isNameValid = validateName();

                const isCategoryValid = validateCategory();

                const isCityValid = validateCity();

                const isTownValid = validateTown();

                const isAddressValid = validateAddress();

                const isImageValid = validateImage();

                const isDescriptionValid = validateDescription();


                if (
                    !isNameValid ||
                    !isCategoryValid ||
                    !isCityValid ||
                    !isTownValid ||
                    !isAddressValid ||
                    !isImageValid ||
                    !isDescriptionValid
                ) {

                    event.preventDefault();

                    Swal.fire({
                        icon: 'warning',
                        title: '資料輸入有誤',
                        text: '請確認所有必填欄位與資料格式。',
                        confirmButtonText: '確定'
                    });

                }

            });

        });
    </script>

    {{-- Laravel Validation 錯誤 --}}
    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: '資料輸入有誤',
                text: '請確認表單欄位是否正確填寫。',
                confirmButtonText: '確定'
            });
        </script>
    @endif
@endpush
