@extends('management.layouts.app')

@section('content')

    <div class="text-center">
        <h1 class="font_size_page_title">画像ファイルをリサイズ</h1>
    </div>
    
    <div class="row mt-3 mb-5">
        <div class="col-12">
            
            {!! Form::open(['route'=>'management.base.ExecuteResizeImage', 'enctype'=>'multipart/form-data']) !!}
                <div class="row">
                    <div class="col-12 mb-4 p-3 border">
                        <div class='text-left'>
                            <ul>
                                <li>{{ '写真ファイルをサーバーでリサイズするので、アップロードしてダウンロードします。' }}</li>
                                <li>{{ 'もともとの写真ファイルのベース名の末尾に "_resized" を付けた名前でダウンロードしてきます。' }}</li>
                            </ul>
                        </div>
                        
                        <div class='form-group'>
                            {!! Form::label('selected_image_file', '写真　') !!}
                            {!! Form::file('selected_image_file') !!}
                        </div>

                        <div class='form-group row'>
                                {!! Form::label('resize_image_width', '横', ['class'=>'col-form-label col-1 text-right']) !!}
                                {!! Form::number('resize_image_width', old('resize_image_width', 0), ['class'=>'form-control col-4 col-md-2', 'min' => 0, 'max' => 2000]) !!}
                                <div class='col-form-label col-1 text-left'>px</div>
                                <div class='col-form-label col-6 col-md-8 text-left'>（0を指定すると縦と比率を合わせてリサイズする）</div>
                        </div>
                        <div class='form-group row'>
                                {!! Form::label('resize_image_height', '縦', ['class'=>'col-form-label col-1 text-right']) !!}
                                {!! Form::number('resize_image_height', old('resize_image_height', 0), ['class'=>'form-control col-4 col-md-2', 'min' => 0, 'max' => 2000]) !!}
                                <div class='col-form-label col-1 text-left'>px</div>
                                <div class='col-form-label col-6 col-md-8 text-left'>（0を指定すると横と比率を合わせてリサイズする）</div>
                        </div>
                        <div class='text-left'>
                            {{ '縦横どちらも0のときはサイズを変更せずjpgファイルに変換します。' }}
                        </div>
                    </div>
                </div>
                    
                <div class="text-center">
                    {!! Form::submit('リサイズ', ['class'=>'btn btn-primary']) !!}
                </div>
            {!! Form::close() !!}
    
        </div>
    </div>

    <div class="mb-5 border-bottom">
        {{-- 線を引くために追加したdiv --}}
    </div>
    
    <div class="text-center mb-5">
        <a href="{{ route('management.base.ClearTmpResizeImage') }}" class="btn btn-warning">
            <span class="word_lump">サーバーに残っている</span><span class="word_lump">不要なファイルを削除する</span>
        </a>
    </div>

@endsection