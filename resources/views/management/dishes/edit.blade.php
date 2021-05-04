@extends('management.layouts.app')

@section('content')

    <div class="text-center">
        <h1 class="font_size_page_title">作ったことのある料理を編集</h1>
    </div>

    <div class="row mt-3 mb-5">
        <div class="col-12">
            
        {!! Form::open(['route' => ['management.dishes.update', $dish->id], 'enctype'=>'multipart/form-data', 'method' => 'put']) !!}
            <div class="row">
                <div class="col-12 mb-4 p-3 border">
                    
                    <div class='form-group'>
                        {!! Form::label('name', '料理名　') !!}
                        {!! Form::textarea('name', old('name', $dish->name), ['class'=>'form-control', 'rows' => '2']) !!}
                    </div>
                    <div class="m-3 text-center">
                        <img src="{{ $dish->image_url }}" style="max-width: 100%; height: auto; width: auto;">
                    </div>
                    <div class='form-group'>
                        {!! Form::label('selected_image_file', '写真　') !!}
                        {!! Form::file('selected_image_file') !!}
                    </div>
                    <div class='form-group'>
                        {!! Form::label('description', '説明　') !!}
                        {!! Form::textarea('description', old('description', $dish->description), ['class'=>'form-control', 'rows' => '3']) !!}
                    </div>
                
                </div>
            </div>
            
            <div class="text-center">
                {!! Form::submit('更新', ['class'=>'btn btn-primary']) !!}
            </div>
        {!! Form::close() !!}

        </div>
    </div>
    
@endsection