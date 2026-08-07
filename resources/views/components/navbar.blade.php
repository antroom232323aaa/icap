<nav class="navbar navbar-expand-lg site-navbar">
    <div class="container">

        {{-- Logo --}}
        <a class="navbar-brand fw-bold site-navbar-brand" href="{{ url('/') }}">
            AI Travel Guide
        </a>

        {{-- Mobile Menu Button --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar"
            aria-controls="mainNavbar" aria-expanded="false" aria-label="切換導覽列">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Navigation --}}
        <div class="collapse navbar-collapse" id="mainNavbar">

            <ul class="navbar-nav ms-auto">

                {{-- 首頁 --}}
                <li class="nav-item">
                    <a class="nav-link site-nav-link" href="{{ url('/') }}">
                        首頁
                    </a>
                </li>

                {{-- 景點列表 --}}
                <li class="nav-item">
                    <a class="nav-link site-nav-link" href="{{ url('/attractions') }}">
                        景點列表
                    </a>
                </li>

                {{-- 景點統計 --}}
                <li class="nav-item">
                    <a class="nav-link site-nav-link" href="{{ url('/statistics') }}">
                        景點統計
                    </a>
                </li>

                {{-- 管理 --}}
                <li class="nav-item">
                    <a class="nav-link site-nav-link" href="{{ url('/admin/attractions') }}">
                        景點管理
                    </a>
                </li>

            </ul>

        </div>

    </div>
</nav>
