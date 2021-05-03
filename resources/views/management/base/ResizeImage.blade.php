@extends('management.layouts.app')

@section('content')

    <div class="text-center">
        <h1>画像ファイルをリサイズ</h1>
    </div>
    
    <div class="row">
        <div class="col-12">
            
            {!! Form::open(['route'=>'management.base.ExecuteResizeImage', 'enctype'=>'multipart/form-data']) !!}
                <div class="row">
                    <div class="col-12 mb-4 p-1 border">
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
                                <div class='col-form-label col-5 text-left'>（0を指定すると縦と比率を合わせてリサイズする）</div>
                        </div>
                        <div class='form-group row'>
                                {!! Form::label('resize_image_height', '縦', ['class'=>'col-form-label col-1 text-right']) !!}
                                {!! Form::number('resize_image_height', old('resize_image_height', 0), ['class'=>'form-control col-4 col-md-2', 'min' => 0, 'max' => 2000]) !!}
                                <div class='col-form-label col-1 text-left'>px</div>
                                <div class='col-form-label col-5 text-left'>（0を指定すると横と比率を合わせてリサイズする）</div>
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

        <div class="col-12 mt-5 mb-4 border-bottom">
            {{-- 空白行を作りたかったので追加したdiv --}}
        </div>

        <div class="col-12">
            <div class="text-center">
                {!! link_to_route('management.base.ClearTmpResizeImage', 'サーバーに残っている不要なファイルを削除する', null, ['class' => 'btn btn-warning']) !!}
            </div>
        </div>
    </div>
    
@endsection