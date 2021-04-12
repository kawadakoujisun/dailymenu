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
                    <div>
                        {!! link_to_route('management.dates.CreateSameDish', '日付を指定して投稿', ['dish_id' => $dish->id], ['class' => 'btn btn-light']) !!}
                        {!! link_to_route('management.dishes.edit', '編集', ['id' => $dish->id], ['class' => 'btn btn-light']) !!}
                        
                        {!! Form::open(['route' => ['management.dishes.destroy', $dish->id], 'method' => 'delete']) !!}
                            {!! Form::submit('この料理を削除', ['class' => 'btn btn-danger']) !!}
                        {!! Form::close() !!}
                    </div>
                </li>
            @endforeach
        </ul>
    @endif

    {!! link_to_route('management.base.index', '食堂の日替わりメニュー　管理者ページ') !!}
    <a href="/">公開ページ</a>
    
@endsection