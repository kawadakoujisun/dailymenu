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
        <div class="row" style="max-width: 800px; margin: auto;">
            @foreach($dates as $date)
                <?php $dish = $date->dish; ?>
                <div class="col-12 mb-4 p-1 border text-center">
                    <div>
                        {{-- 年月日（曜日）表示 --}}
                        <?php $beforeDate = '<h2>'; $dateSrc = $date->date; $afterDate = '</h2>' ?>
                        @include('commons.DateDisplay')
                    </div>
                    {{-- Dishの値、RequestCountの値、リクエストボタンを表示 --}}
                    <?php $dish_id = $dish->id; $dish_name = $dish->name; $dish_description = $dish->description; $dish_image_url = $dish->image_url; ?>
                    <?php $requestCount_request_count = $dish->requestCount->request_count; ?>
                    @include('commons.ContentsDisplay')
                </div>
            @endforeach
        </div>
    @endif
    
    <div class="d-flex justify-content-center">
        {{-- ページネーションのリンク --}}
        {{ $dates->links() }}
    </div>
    
@endsection