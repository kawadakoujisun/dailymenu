@extends('management.layouts.app')

@section('content')

    {!! Form::open(['route' => ['management.dates.StoreSameDish', $dish->id], 'enctype'=>'multipart/form-data']) !!}
        <div class='form-group'>
            {!! Form::label('date', '日にち') !!}
            {!! Form::date('date', old('date')) !!}  {{-- 年-月-日(例2021-04-12)だけで時:分:秒はナシ --}}
        </div>
        <div>
            {{ $dish->name }}
        </div>
        <div>
            <img src="{{ $dish->image_url }}">
        </div>
        <div>
            {!! nl2br(e($dish->description)) !!}
        </div>
        {!! Form::submit('投稿', ['class'=>'btn btn-info']) !!}
    {!! Form::close() !!}

    {!! link_to_route('management.base.index', '食堂の日替わりメニュー　管理者ページ') !!}
    <a href="/">公開ページ</a>
    
@endsection