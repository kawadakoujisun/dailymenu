@extends('management.layouts.app')

@section('content')

    {!! link_to_route('management.dates.CreateNewDish', '新しい料理を投稿') !!}
    {!! link_to_route('management.dishes.index', '作ったことのある料理を投稿、編集') !!}
    {!! link_to_route('management.dates.index', '日替わりメニューを削除') !!}
    <a href="/">公開ページ</a>

    @if (Auth::check())
        <br>
        {{-- ログアウトへのリンク --}}
        {!! link_to_route('logout.get', 'Logout') !!}
    @endif

@endsection
