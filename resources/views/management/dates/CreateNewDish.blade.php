@extends('management.layouts.app')

@section('content')

    <div class="text-center">
        <h1>新しい料理を投稿</h1>
    </div>
    
    <div class="row">
        <div class="col-12">
            
            {!! Form::open(['route'=>'management.dates.StoreNewDish', 'enctype'=>'multipart/form-data']) !!}
                <div class="col-12 mb-4 p-1 border">
                    
                    <div class='form-group'>
                        {!! Form::label('date', '日にち　') !!}
                        {!! Form::date('date', old('date')) !!}  {{-- 年-月-日(例2021-04-12)だけで時:分:秒はナシ --}}
                    </div>
                    <div class='form-group'>
                        {!! Form::label('name', '料理名　') !!}
                        {!! Form::text('name', old('name'), ['class'=>'form-control']) !!}
                    </div>
                    <div class='form-group'>
                        {!! Form::label('selected_image_file', '写真　') !!}
                        {!! Form::file('selected_image_file') !!}
                    </div>
                    <div class='form-group'>
                        {!! Form::label('description', '説明　') !!}
                        {!! Form::textarea('description', old('description'), ['class'=>'form-control', 'rows' => '3']) !!}
                    </div>
                
                </div>
                    
                <div class="text-center">
                    {!! Form::submit('投稿', ['class'=>'btn btn-primary']) !!}
                </div>
            {!! Form::close() !!}
    
        </div>
    </div>
    
@endsection