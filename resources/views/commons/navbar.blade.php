<header class="sticky-top">
    <div class="restaurant_logo_outer">
        <div class="restaurant_logo_inner"><a href="/"><img class="image_in_div" src="/images/restaurant_logo.png" alt="食堂"></a></div>
    </div>
</header>

<div class="mb-3 navbar_outer">
    <nav class="navbar navbar-expand-sm navbar-light bg-light">
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#nav-bar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="nav-bar">
            <ul class="navbar-nav">
                @if (Auth::check())
                    {{-- 管理者としてログインしているとき --}}
                    {{-- ダミー --}}
                    {{-- <li class="nav-item"><span class='nav-link' style="text-decoration: line-through;">ホーム</span></li> --}}
                    {{-- トップページへのリンク --}}
                    <li class="nav-item">{!! link_to_route('contents.index', '日替わりメニュー', [], ['class' => 'nav-link']) !!}</li>
                    {{-- ランキングページへのリンク --}}
                    <li class="nav-item">{!! link_to_route('contents.GetRankingOfRequestCount', 'ランキング', [], ['class' => 'nav-link']) !!}</li>
                    {{-- ダミー --}}
                    {{-- <li class="nav-item"><span class='nav-link' style="text-decoration: line-through;">アクセス</span></li> --}}
                    {{-- 管理者向け --}}
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">管理者専用</a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            {{-- 管理者ページへのリンク --}}
                            <li class="dropdown-item">{!! link_to_route('management.base.index', '管理者ページ') !!}</li>
                            <li class="dropdown-divider"></li>
                            {{-- ログアウトへのリンク --}}
                            <li class="dropdown-item">{!! link_to_route('logout.get', 'Logout') !!}</li>
                        </ul>                        
                    </li>
                @else
                    {{-- 一般ユーザ向け --}}
                    {{-- ダミー --}}
                    {{-- <li class="nav-item"><span class='nav-link' style="text-decoration: line-through;">ホーム</span></li> --}}
                    {{-- トップページへのリンク --}}
                    <li class="nav-item">{!! link_to_route('contents.index', '日替わりメニュー', [], ['class' => 'nav-link']) !!}</li>
                    {{-- ランキングページへのリンク --}}
                    <li class="nav-item">{!! link_to_route('contents.GetRankingOfRequestCount', 'ランキング', [], ['class' => 'nav-link']) !!}</li>
                    {{-- ダミー --}}
                    {{-- <li class="nav-item"><span class='nav-link' style="text-decoration: line-through;">アクセス</span></li> --}}
                @endif
            </ul>
        </div>
    </nav>
</div>