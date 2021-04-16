@extends('layouts.app')

@section('content')

    <div class="text-center">
        <h1>食堂の日替わりメニュー</h1>
    </div>

    <div class="d-flex justify-content-center">
        {{-- ページネーションのリンク --}}
        {{ $dates->links() }}
    </div>

    @if(count($dates) > 0)
        <div class="row">
            @foreach($dates as $date)
                <?php $dish = $date->dish; ?>
                <div class="col-12 mb-4 p-1 border text-center">
                    <div>
                        <?php $dateTimestamp = strtotime($date->date); ?>
                        <?php $dayOfTheWeekNameArray = [ '日', '月', '火', '水', '木', '金', '土' ]; ?>
                        <h2>{{ date('Y', $dateTimestamp) . '年' . date('n', $dateTimestamp) . '月' . date('j', $dateTimestamp) . '日' . '（' . $dayOfTheWeekNameArray[date('w', $dateTimestamp)] . '曜日）' }}</h2>
                    </div>
                    <div>
                        <p style="font-size:200%;">{{ $dish->name }}</p>
                    </div>
                    <div class="m-3">
                        <img src="{{ $dish->image_url }}">
                    </div>
                    <div>
                        {!! link_to_route('contents.RequestDish', 'リクエスト', ['dish_id' => $dish->id], ['class' => 'btn btn-success']) !!}
                        <span class="badge badge-secondary" style="font-size:100%;">{{ $dish->requestCount->request_count }}</span>
                    </div>
                    <div class="m-2">
                        <p>{!! nl2br(e($dish->description)) !!}</p>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
    
    <div class="d-flex justify-content-center">
        {{-- ページネーションのリンク --}}
        {{ $dates->links() }}
    </div>
    
@endsection