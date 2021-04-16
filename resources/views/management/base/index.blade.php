@extends('management.layouts.app')

@section('content')

    <div class="text-center">
        <h1>食堂の日替わりメニュー　管理者ページ</h1>
    </div>
    
    <div class="row">
        <div class="col-12 text-center">
            <ul class="list-unstyled">
                <li>{!! link_to_route('management.dates.CreateNewDish', '新しい料理を投稿') !!}</li>
                <li>{!! link_to_route('management.dishes.index', '作ったことのある料理を投稿、編集') !!}</li>
                <li>{!! link_to_route('management.dates.index', '日替わりメニューを削除') !!}</li>
            </ul>
        </div>
    </div>

@endsection
