@extends('management.layouts.app')

@section('content')

    <div class="text-center">
        <h1 class="font_size_page_title"><span class="word_lump">作ったことのある料理を</span><span class="word_lump">投稿、編集</span></h1>
    </div>

    <div class="d-flex justify-content-center">
        {{-- ページネーションのリンク --}}
        {{ $dishes->links() }}
    </div>
    
    @if(count($dishes) > 0)
        <div class="row" style="max-width: 800px; margin: auto;">
            @foreach($dishes as $dish)
                <div class="col-12 mb-4 p-1 border text-center">
                    {{-- Dishの値、RequestCountの値、リクエストカウントリセットボタンを表示 --}}
                    <?php $before_dish_name = '<h2 class="font_size_item_title">'; $after_dish_name = '</h2>'; ?>
                    @include('management.commons.ContentsDisplay')
                    <div>
                        {!! link_to_route('management.dates.CreateSameDish', '日付を指定して投稿', ['dish_id' => $dish->id], ['class' => 'btn btn-primary']) !!}
                        {!! link_to_route('management.dishes.edit', '編集', ['id' => $dish->id], ['class' => 'btn btn-primary']) !!}
                    </div>
                    <div class="m-1">
                        {!! Form::open(['route' => ['management.dishes.destroy', $dish->id], 'method' => 'delete']) !!}
                            {!! Form::submit('この料理を削除', ['class' => 'btn btn-danger']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <div class="d-flex justify-content-center">
        {{-- ページネーションのリンク --}}
        {{ $dishes->links() }}
    </div>
    
@endsection