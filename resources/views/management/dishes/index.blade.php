@extends('management.layouts.app')

@section('content')

    <div class="text-center">
        <h1>作ったことのある料理を投稿、編集</h1>
    </div>

    <div class="d-flex justify-content-center">
        {{-- ページネーションのリンク --}}
        {{ $dishes->links() }}
    </div>
    
    @if(count($dishes) > 0)
        <div class="row">
            @foreach($dishes as $dish)
                <div class="col-12 mb-4 p-1 border text-center">
                    <div>
                        <h2>{{ $dish->name }}</h2>
                    </div>
                    <div class="m-3">
                        <img src="{{ $dish->image_url }}">
                    </div>
                    <div>
                        {!! link_to_route('management.dishes.ResetRequestCount', 'リクエストカウントをリセット', ['id' => $dish->id], ['class' => 'btn btn-warning']) !!}
                        <span class="badge badge-secondary" style="font-size:100%;">{{ $dish->requestCount->request_count }}</span>
                    </div>                       
                    <div class="m-2">
                        <p>{!! nl2br(e($dish->description)) !!}</p>
                    </div>
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