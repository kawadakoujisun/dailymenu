@extends('layouts.app')

@section('content')

    <div class="text-center">
        <h1 class="disp_page_title">ランキング</h1>
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
                <div class="col-12 mb-4 p-1 border text-center">
                    <div>
                        {!! '<h2 class="disp_item_title" id=' . $jumpId . '>' !!}{{ '第' . $no . '位' }}{!! '</h2>' !!}
                    </div>
                    {{-- Dishの値、RequestCountの値、リクエストボタンを表示 --}}
                    <?php $dish_id = $joinedDish->id; $dish_name = $joinedDish->name; $dish_description = $joinedDish->description; $dish_image_url = $joinedDish->image_url; ?>
                    <?php $requestCount_request_count = $joinedDish->request_counts_request_count; ?>
                    @include('commons.ContentsDisplay', ['sharpJumpId' => '#'.$jumpId ])
                    <div class="row">
                        <div class="col-lg-3"></div>
                        <div class="col-lg-6">
                            <table class="table table-bordered">
                                <tr>
                                    <td>ここ1年の登場回数</td>
                                    <td>{{ $joinedDish->appearance_count }}</td>
                                </tr>
                                <tr>
                                    <td>最近登場した日</td>
                                    <td>
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
            @endforeach
        </div>
    @endif
    
    <div class="d-flex justify-content-center">
        {{-- ページネーションのリンク --}}
        {{ $joinedDishes->links() }}
    </div>   
    
@endsection