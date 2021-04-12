@extends('management.layouts.app')

@section('content')

    {!! Form::open(['route'=>'management.dates.StoreNewDish','enctype'=>'multipart/form-data']) !!}
        <div class='form-group'>
            {!! Form::label('date', '日にち') !!}
            {!! Form::date('date', old('date')) !!}  {{-- 年-月-日(例2021-04-12)だけで時:分:秒はナシ --}}
        </div>
        <div class='form-group'>
            {!! Form::label('name', '料理名') !!}
            {!! Form::text('name', old('name'), ['class'=>'form-control']) !!}
        </div>
        <div class='form-group'>
            {!! Form::label('selected_image_file', '写真') !!}
            {!! Form::file('selected_image_file') !!}
        </div>
        <div class='form-group'>
            {!! Form::label('description', '説明') !!}
            {!! Form::textarea('description', old('description'), ['class'=>'form-control', 'rows' => '3']) !!}
        </div>
        {!! Form::submit('投稿',['class'=>'btn btn-info']) !!}
    {!! Form::close() !!}

    {!! link_to_route('management.base.index', '食堂の日替わりメニュー　管理者ページ') !!}
    <a href="/">公開ページ</a>
    
@endsection