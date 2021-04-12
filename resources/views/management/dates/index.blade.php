@extends('management.layouts.app')

@section('content')

    @if(count($dates) > 0)
        <ul class="list-unstyled">
            @foreach($dates as $date)
                <?php $dish = $date->dish; ?>
                <li>
                    <div>
                        <?php $dateTimestamp = strtotime($date->date); ?>
                        <?php $dayOfTheWeekNameArray = [ '日', '月', '火', '水', '木', '金', '土' ]; ?>
                        {{ date('Y', $dateTimestamp) . '年' . date('n', $dateTimestamp) . '月' . date('j', $dateTimestamp) . '日' . $dayOfTheWeekNameArray[date('w', $dateTimestamp)] . '曜日' }}
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
                    <div>
                        {!! Form::open(['route' => ['management.dates.destroy', $date->id], 'method' => 'delete']) !!}
                            {!! Form::submit('この日付を削除（料理は削除しない）', ['class' => 'btn btn-danger']) !!}
                        {!! Form::close() !!}
                    </div>
                </li>
            @endforeach
        </ul>
    @endif
    
    {!! link_to_route('management.base.index', '食堂の日替わりメニュー　管理者ページ') !!}
    <a href="/">公開ページ</a>
    
@endsection