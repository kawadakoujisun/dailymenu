@extends('layouts.app')

@section('content')

    <div class="mb-4 text-center restaurant_main_visual_outer">
        <img class="image_in_div" src="/images/restaurant_main_visual.jpg" alt="食堂">
    </div>

    <div class="page_frame page_frame_padding">
        
        <div class="mb-4">
            <div class="page_title">
                <h1 class="font_size_page_title">日替わりメニュー</h1>
            </div>
        </div>
    
        <div class="row" style="max-width: 984px; margin: auto;">
    
            {{-- サイドバー --}}
            <div class="col-md-4 order-md-2 mb-4 p-0">
                <div class="sidebar">
                    <div style="position: relative; max-width: 360px; height: auto; margin: 0 auto 0;">
                        <div style="padding-top: 100%"></div>
                        <div style="position: absolute; top: 0; left 0; width: 100%; height: 100%;">
                            <div class="sidebar_box" style="width: 87.5%; height: 100%; margin: 0 auto 0;">
                                @include('commons.CalendarDisplay', ['pageNo' => $dates->currentPage(), 'calendarYearMonth' => $calendarYearMonth, 'existDayArray' => $existDayArray])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    
            {{-- メインコンテンツ --}}
            <div class="col-md-8 order-md-1 p-0">
                <div class="d-flex justify-content-center">
                    {{-- ページネーションのリンク --}}
                    {{ $dates->appends(['calendar' => $calendarYearMonth])->links() }}
                </div>
            
                @if(count($dates) > 0)
                    <div class="row" style="max-width: 984px; margin: auto;">
                        <?php $no = ($dates->currentPage() - 1) * \Config::get('contents.ContentsDef.ITEM_NUM_IN_PAGE'); ?>
                        @foreach($dates as $date)
                            <?php ++$no; ?>
                            <?php $jumpId = 'index'.$no; ?>
                            <?php $dish = $date->dish; ?>
                            <div class="col-12 mb-4 text-center item_frame">
                                @include('commons.SpaceBeforeItemTitle')
                                <div class="item_title">
                                    {{-- 年月日（曜日）表示 --}}
                                    <?php $beforeDate = '<h2 class="font_size_item_title">'; $dateSrc = $date->date; $afterDate = '</h2>' ?>
                                    @include('commons.DateDisplay')
                                </div>
                                {{-- Dishの値、RequestCountの値、リクエストボタンを表示 --}}
                                <?php $dish_id = $dish->id; $dish_name = $dish->name; $dish_description = $dish->description; $dish_image_url = $dish->image_url; ?>
                                <?php $requestCount_request_count = $dish->requestCount->request_count; ?>
                                @include('commons.ContentsDisplay', ['sharpJumpId' => '#'.$jumpId ])
                            </div>
                        @endforeach
                    </div>
                @endif
                
                <div class="d-flex justify-content-center">
                    {{-- ページネーションのリンク --}}
                    {{ $dates->appends(['calendar' => $calendarYearMonth])->links() }}
                </div>
            </div>
    
        </div>
    
    </div>
    
@endsection