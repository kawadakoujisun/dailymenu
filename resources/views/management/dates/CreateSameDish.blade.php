@extends('management.layouts.app')

@section('content')

    <div class="text-center">
        <h1>作ったことのある料理を日付を指定して投稿</h1>
    </div>

    <div class="row">
        <div class="col-12">

            {!! Form::open(['route' => ['management.dates.StoreSameDish', $dish->id], 'enctype'=>'multipart/form-data']) !!}
                <div class="row">
                    <div class="col-12 mb-4 p-1 border text-center">
                        
                        <div class='form-group'>
                            {!! Form::label('date', '日にち　') !!}
                            {!! Form::date('date', old('date')) !!}  {{-- 年-月-日(例2021-04-12)だけで時:分:秒はナシ --}}
                        </div>
                        <div>
                            <p style="font-size:200%;">{{ $dish->name }}</p>
                        </div>
                        <div class="m-3">
                            <img src="{{ $dish->image_url }}">
                        </div>
                        <div class="m-2">
                            <p>{!! nl2br(e($dish->description)) !!}</p>
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