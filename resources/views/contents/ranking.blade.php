@extends('layouts.app')

@section('content')

    <?php
    $orderArray = [
        0 => 'リクエスト数ランキング',
        1 => '登場回数ランキング',
        2 => '最近登場した順',
    ];
    ?>
    
    <div class="text-center">
        <h1>ランキング</h1>
    </div>
    
    <div class="row">
        <div class="col-12">
            {!! Form::open(['route'=>'contents.PostRanking', 'enctype'=>'multipart/form-data']) !!}
                <div class='form-group d-flex flex-row'>
                    {!! Form::select('order', $orderArray, old('order', $order_key), ['class'=>'form-control']) !!}
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
        <div class="row">
            <?php $no = 0; ?>
            @foreach($joinedDishes as $joinedDish)
                <?php ++$no; ?>
                <div class="col-12 mb-4 p-1 border text-center">
                    <div>
                        <h2>{{ '第' . $no . '位' }}</h2>
                    </div>
                    <div>
                        <p style="font-size:200%;">{{ $joinedDish->name }}</p>
                    </div>
                    <div class="m-3">
                        <img src="{{ $joinedDish->image_url }}">
                    </div>
                    <div>
                        {!! link_to_route('contents.RequestDish', 'リクエスト', ['dish_id' => $joinedDish->id], ['class' => 'btn btn-success']) !!}
                        <span class="badge badge-secondary" style="font-size:100%;">{{ $joinedDish->request_counts_request_count }}</span> 
                    </div>
                    <div class="m-2">
                        <p>{!! nl2br(e($joinedDish->description)) !!}</p>
                    </div>
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
                                        @if($joinedDish->dates_date != null)
                                            <?php $dateTimestamp = strtotime($joinedDish->dates_date); ?>
                                            <?php $dayOfTheWeekNameArray = [ '日', '月', '火', '水', '木', '金', '土' ]; ?>
                                            {{ date('Y', $dateTimestamp) . '年' . date('n', $dateTimestamp) . '月' . date('j', $dateTimestamp) . '日' . '（' . $dayOfTheWeekNameArray[date('w', $dateTimestamp)] . '曜日）' }}
                                        @else
                                            {{ ' - ' . '年' . ' - ' . '月' . ' - ' . '日' . '（' . ' - ' . '曜日）' }}
                                        @endif                                    
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