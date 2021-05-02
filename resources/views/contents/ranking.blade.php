@extends('layouts.app')

@section('content')

    <div class="page_frame">

        <div class="mb-4">
            <div class="page_title">
                <h1 class="font_size_page_title">ランキング</h1>
            </div>
        </div>
        
        <div class="row" style="max-width: 984px; margin: auto;">
            <div class="col-12">
                {!! Form::open(['route'=>'contents.PostRanking', 'enctype'=>'multipart/form-data']) !!}
                    <div class='form-group d-flex flex-row'>
                        {!! Form::select('order', Config::get('contents.ContentsDef.rankingOrderArray'), old('order', $order_key), ['class'=>'form-control']) !!}
                        {!! Form::submit('更新', ['class'=>'btn btn-primary']) !!}
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
        
        <div class="row" style="max-width: 984px; margin: auto;">

            <div class="col-12">
                <div class="d-flex justify-content-center">
                    {{-- ページネーションのリンク --}}
                    {{ $joinedDishes->links() }}
                </div>    
                
                @if(count($joinedDishes) > 0)
                    <div class="row" style="max-width: 984px; margin: auto;">
                        <?php $no = ($joinedDishes->currentPage() - 1) * \Config::get('contents.ContentsDef.ITEM_NUM_IN_PAGE'); ?>
                        @foreach($joinedDishes as $joinedDish)
                            <?php ++$no; ?>
                            <?php $jumpId = 'index'.$no; ?>
                            <div class="col-12 mb-4 text-center item_frame">
                                @include('commons.SpaceBeforeItemTitle')
                                <div class="item_title">
                                    <div>
                                        {!! '<h2 class="font_size_item_title">' !!}{{ '第' . $no . '位' }}{!! '</h2>' !!}
                                    </div>
                                </div>
                                {{-- Dishの値、RequestCountの値、リクエストボタンを表示 --}}
                                <?php $dish_id = $joinedDish->id; $dish_name = $joinedDish->name; $dish_description = $joinedDish->description; $dish_image_url = $joinedDish->image_url; ?>
                                <?php $requestCount_request_count = $joinedDish->request_counts_request_count; ?>
                                @include('commons.ContentsDisplay', ['sharpJumpId' => '#'.$jumpId ])
                                <div class="dish_info">
                                    <div class="row">
                                        <div class="col-lg-3"></div>
                                        <div class="col-lg-6">
                                            <table class="table table-bordered dish_info_table">
                                                <tr>
                                                    <td class="align-middle">ここ1年の<br>登場回数</td>
                                                    <td class="align-middle">{{ $joinedDish->appearance_count }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="align-middle">最近登場した日</td>
                                                    <td class="align-middle">
                                                        {{-- 年月日（曜日）表示 --}}
                                                        <?php $beforeDate = ''; $dateSrc = $joinedDish->dates_date; $afterDate = '' ?>
                                                        @include('commons.DateDisplay')
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-lg-3"></div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
                
                <div class="d-flex justify-content-center">
                    {{-- ページネーションのリンク --}}
                    {{ $joinedDishes->links() }}
                </div>
            </div>
            
        </div>
    
    </div>
    
@endsection