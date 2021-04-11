@extends('layouts.app')

@section('content')

{{ public_path() }}

<img src="/home/ubuntu/environment/dailymenu/public/images/banner01.jpg" width="200px" height="200px">
<img src="images/banner01.jpg" width="200px" height="200px">

{!! Form::open(['route'=>'sample_objects.store','enctype'=>'multipart/form-data']) !!}
<div class='form-group'>
    {!! Form::label('selected_image_file', '画像ファイル') !!}
    {!! Form::file('selected_image_file') !!}
</div>
{!! Form::submit('登録する',['class'=>'btn btn-info']) !!}
{!! Form::close() !!}

@if(!is_null($selected_image_file_path))
    <p>{{ $selected_image_file_path }}</p>
    <img src="{{ $selected_image_file_path }}">
@endif

@endsection
