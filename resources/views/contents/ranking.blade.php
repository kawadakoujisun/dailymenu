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
    
    @if(count($joinedDishes) > 0)
        <ul class="list-unstyled">
            <?php $no = 0; ?>
            @foreach($joinedDishes as $joinedDish)
                <?php ++$no; ?>
                <li>
                    <div>
                        {{ '第' . $no . '位' }}
                    </div>
                    <div>
                        {{ $joinedDish->name }}
                    </div>
                    <div>
                        <img src="{{ $joinedDish->image_url }}">
                    </div>
                    <div>
                        {!! link_to_route('contents.RequestDish', 'リクエスト', ['dish_id' => $joinedDish->id], ['class' => 'btn btn-light']) !!}
                        {{ $joinedDish->request_counts_request_count }}
                    </div>
                    <div>
                        {!! nl2br(e($joinedDish->description)) !!}
                    </div>
                    <div>
                        {{ 'ここ1年の登場回数' }}
                        {{ $joinedDish->appearance_count }}
                    </div>
                    <div>
                        {{ '最近登場した日' }}
                        @if($joinedDish->dates_date != null)
                            <?php $dateTimestamp = strtotime($joinedDish->dates_date); ?>
                            <?php $dayOfTheWeekNameArray = [ '日', '月', '火', '水', '木', '金', '土' ]; ?>
                            {{ date('Y', $dateTimestamp) . '年' . date('n', $dateTimestamp) . '月' . date('j', $dateTimestamp) . '日' . $dayOfTheWeekNameArray[date('w', $dateTimestamp)] . '曜日' }}
                        @else
                            {{ '-' . '年' . '-' . '月' . '-' . '日' . '-' . '曜日' }}
                        @endif
                    </div>
                    <div>
                        <br>
                        <br>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif
    
    {{-- ページネーションのリンク --}}
    {{ $joinedDishes->links() }}       
    
    {!! link_to_route('contents.GetRankingOfRequestCount', 'ランキング') !!}
    <a href="/">食堂の日替わりメニュー</a>
    
@endsection