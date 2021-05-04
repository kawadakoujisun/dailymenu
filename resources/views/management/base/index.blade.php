@extends('management.layouts.app')

@section('content')

    <div class="text-center">
        <h1 class="font_size_page_title"><span class="word_lump">食堂の日替わりメニュー</span><span class="word_lump"></span>　<span class="word_lump">管理者ページ</span></h1>
    </div>
    
    <div class="row mt-3 mb-5">
        <div class="col-12 text-center">
            <ul class="list-unstyled">
                <li>{!! link_to_route('management.dates.CreateNewDish', '新しい料理を投稿') !!}</li>
                <li>{!! link_to_route('management.dishes.index', '作ったことのある料理を投稿、編集') !!}</li>
                <li>{!! link_to_route('management.dates.index', '日替わりメニューを削除') !!}</li>
                <li>{!! link_to_route('management.base.ResizeImage', '画像ファイルをリサイズ') !!}</li>
            </ul>
        </div>
    </div>

@endsection
