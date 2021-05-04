@extends('layouts.app')

@section('content')
    <?php
        require_once(dirname(__FILE__)."/../../../app/contents/DisplayNumberUtil.php");  // 追加
    ?>

    <div class="page_frame page_frame_padding">

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

            <div class="col-12 p-0">
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
                                        <?php
                                            $displayNo = App\Contents\DisplayNumberUtil::getDisplayNumberString($no);
                                        ?>
                                        {!! '<h2 class="font_size_item_title">' !!}{{ '第' . $displayNo . '位' }}{!! '</h2>' !!}
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
                                                    <td class="align-middle"><span class="word_lump">ここ1年の</span><span class="word_lump">登場回数</span></td>
                                                    <td class="align-middle">{{ $joinedDish->appearance_count }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="align-middle"><span class="word_lump">最近</span><span class="word_lump">登場した日</span></td>
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