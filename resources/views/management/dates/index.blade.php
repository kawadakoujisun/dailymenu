@extends('management.layouts.app')

@section('content')

    <div class="text-center">
        <h1 class="font_size_page_title">日替わりメニューを削除</h1>
    </div>

    <div class="d-flex justify-content-center">
        {{-- ページネーションのリンク --}}
        {{ $dates->links() }}
    </div>
    
    @if(count($dates) > 0)
        <div class="row" style="max-width: 800px; margin: auto;">
            @foreach($dates as $date)
                <?php $dish = $date->dish; ?>
                <div class="col-12 mb-4 p-1 border text-center">
                    <div>
                        {{-- 年月日（曜日）表示 --}}
                        <?php $beforeDate = '<h2 class="font_size_item_title">'; $dateSrc = $date->date; $afterDate = '</h2>' ?>
                        @include('commons.DateDisplay')
                    </div>
                    {{-- Dishの値、RequestCountの値、リクエストカウントリセットボタンを表示 --}}
                    <?php $before_dish_name = '<p class="font_size_dish_name">'; $after_dish_name = '</p>'; ?>
                    @include('management.commons.ContentsDisplay')
                    <div>
                        {!! Form::open(['route' => ['management.dates.destroy', $date->id], 'method' => 'delete']) !!}
                            {!! Form::submit('この日付を削除（料理は削除しない）', ['class' => 'btn btn-danger']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            @endforeach
        </div>
    @endif
    
    <div class="d-flex justify-content-center">
        {{-- ページネーションのリンク --}}
        {{ $dates->links() }}
    </div>
    
@endsection