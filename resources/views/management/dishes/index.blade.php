@extends('management.layouts.app')

@section('content')

    @if(count($dishes) > 0)
        <ul class="list-unstyled">
            @foreach($dishes as $dish)
                <li>
                    <div>
                        {{ $dish->name }}
                    </div>
                    <div>
                        <img src="{{ $dish->image_url }}">
                    </div>
                    <div>
                        {!! nl2br(e($dish->description)) !!}
                    </div>
                </li>
            @endforeach
        </ul>
    @endif

    {!! link_to_route('management.base.index', '食堂の日替わりメニュー　管理者ページ') !!}
    <a href="/">公開ページ</a>
    
@endsection