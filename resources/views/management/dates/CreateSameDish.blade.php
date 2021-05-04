@extends('management.layouts.app')

@section('content')

    <div class="text-center">
        <h1 class="font_size_page_title"><span class="word_lump">作ったことのある料理を</span><span class="word_lump">日付を指定して投稿</span></h1>
    </div>

    <div class="row mt-3 mb-5">
        <div class="col-12">

            {!! Form::open(['route' => ['management.dates.StoreSameDish', $dish->id], 'enctype'=>'multipart/form-data']) !!}
                <div class="row">
                    <div class="col-12 mb-4 p-3 border text-center">
                        
                        <div class='form-group'>
                            {!! Form::label('date', '日にち　') !!}
                            {!! Form::date('date', old('date')) !!}  {{-- 年-月-日(例2021-04-12)だけで時:分:秒はナシ --}}
                        </div>
                        <div>
                            <p class="font_size_dish_name">{!! nl2br(e($dish->name)) !!}</p>
                        </div>
                        <div class="m-3">
                            <img src="{{ $dish->image_url }}" style="max-width: 100%; height: auto; width: auto;">
                        </div>
                        <div class="m-2 mx-auto" style="max-width: 600px;">
                            <p class="text-left">{!! nl2br(e($dish->description)) !!}</p>
                        </div>
                        
                    </div>
                </div>
                    
                <div class="text-center">
                    {!! Form::submit('投稿', ['class'=>'btn btn-primary']) !!}
                </div>
            {!! Form::close() !!}

        </div>
    </div>
    
@endsection