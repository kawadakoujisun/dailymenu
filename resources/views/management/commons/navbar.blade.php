<header class="mb-4">
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
        {{-- トップページへのリンク --}}
        <a class="navbar-brand" href="/management/base">DailyMenu　管理者ページ</a>

        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#nav-bar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="nav-bar">
            <ul class="navbar-nav mr-auto"></ul>
            <ul class="navbar-nav">
                @if (Auth::check())
                    {{-- 管理者としてログインしているとき --}}
                    {{-- 公開ページへのリンク --}}
                    <li class="nav-item"><a href="/" class="nav-link">公開ページ</a></li>
                    {{-- 管理者向け --}}
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">管理者専用</a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            {{-- ログアウトへのリンク --}}
                            <li class="dropdown-item">{!! link_to_route('logout.get', 'Logout') !!}</li>
                        </ul>                        
                    </li>
                @else
                    {{-- 管理者としてログインする前 --}}
                    {{-- 公開ページへのリンク --}}
                    <li class="nav-item"><a href="/" class="nav-link">公開ページ</a></li>
                @endif
            </ul>
        </div>
    </nav>
</header>