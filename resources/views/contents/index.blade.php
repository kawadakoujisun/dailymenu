@extends('layouts.app')

@section('content')

    @if(count($dates) > 0)
        <ul class="list-unstyled">
            @foreach($dates as $date)
                <?php $dish = $date->dish; ?>
                <li>
                    <div>
                        <?php $dateTimestamp = strtotime($date->date); ?>
                        <?php $dayOfTheWeekNameArray = [ '日', '月', '火', '水', '木', '金', '土' ]; ?>
                        {{ date('Y', $dateTimestamp) . '年' . date('n', $dateTimestamp) . '月' . date('j', $dateTimestamp) . '日' . $dayOfTheWeekNameArray[date('w', $dateTimestamp)] . '曜日' }}
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
    {{ $dates->links() }}    
    
    {!! link_to_route('contents.GetRanking', 'ランキング') !!}
    <a href="/">食堂の日替わりメニュー</a>
    
@endsection