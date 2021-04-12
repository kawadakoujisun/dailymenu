@extends('management.layouts.app')

@section('content')

    {!! Form::open(['route' => ['management.dishes.update', $dish->id], 'enctype'=>'multipart/form-data', 'method' => 'put']) !!}
        <div class='form-group'>
            {!! Form::label('name', '料理名') !!}
            {!! Form::text('name', old('name', $dish->name), ['class'=>'form-control']) !!}
        </div>
        <div>
            <img src="{{ $dish->image_url }}">
        </div>
        <div class='form-group'>
            {!! Form::label('selected_image_file', '写真') !!}
            {!! Form::file('selected_image_file') !!}
        </div>
        <div class='form-group'>
            {!! Form::label('description', '説明') !!}
            {!! Form::textarea('description', old('description', $dish->description), ['class'=>'form-control', 'rows' => '3']) !!}
        </div>
        {!! Form::submit('更新', ['class'=>'btn btn-info']) !!}
    {!! Form::close() !!}

    {!! link_to_route('management.base.index', '食堂の日替わりメニュー　管理者ページ') !!}
    <a href="/">公開ページ</a>
    
@endsection