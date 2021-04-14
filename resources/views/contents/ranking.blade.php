@extends('layouts.app')

@section('content')

    <?php
    $orderArray = [
        0 => 'リクエスト数ランキング',
        1 => '登場回数ランキング',
        2 => '最近登場した順',
    ];
    ?>
    
    {!! Form::open(['route'=>'contents.PostRanking', 'enctype'=>'multipart/form-data']) !!}
        <div class='form-group'>
            {!! Form::label('order', 'ランキング') !!}
            {!! Form::select('order', $orderArray, old('order', $order_key), ['class'=>'form-control']) !!}
        </div>
        {!! Form::submit('更新', ['class'=>'btn btn-info']) !!}
    {!! Form::close() !!}
    
    @if(count($dishes) > 0)
        <ul class="list-unstyled">
            <?php $no = 0; ?>
            @foreach($dishes as $dish)
                <?php ++$no; ?>
                <li>
                    <div>
                        {{ $no }}
                    </div>
                    <div>
                        {{ $dish->name }}
                    </div>
                    <div>
                        <img src="{{ $dish->image_url }}">
                    </div>
                    <div>
                        {!! link_to_route('contents.RequestDish', 'リクエスト', ['dish_id' => $dish->id], ['class' => 'btn btn-light']) !!}
                        {{ $dish->requestCount->request_count }}
                    </div>
                    <div>
                        {!! nl2br(e($dish->description)) !!}
                    </div>
                </li>
            @endforeach
        </ul>
    @endif
    
    {{-- ページネーションのリンク --}}
    {{ $dishes->links() }}       
    
    {!! link_to_route('contents.GetRanking', 'ランキング') !!}
    <a href="/">食堂の日替わりメニュー</a>
    
@endsection