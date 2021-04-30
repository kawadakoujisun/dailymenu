<?php

    $weekNumMax = 1 + 6;  // 曜日を表示する行の分を足しておく
    $dayOfTheWeekNameArray = [ '日', '月', '火', '水', '木', '金', '土' ];

    $year  = 2021;
    $month = 12;
    $startDay = 1;
    $endDay   = 31;
    
    $startDayInWeek = 6;
    
    // 日付を表示するのに使う変数
    $currDay = 0;
?>

<div class="calendar_frame">
    <div class="d-flex flex-row justify-content-between calendar_row">
        <div class="border calendar_cell"><div class="calendar_text">{{ '<' }}</div></div>
        <div><div class="calendar_text">{{ $year . '年' . $month . '月' }}</div></div>
        <div class="border calendar_cell"><div class="calendar_text">{{ '>' }}</div></div>
    </div>
    
    @for($weekIndex=0; $weekIndex<$weekNumMax; ++$weekIndex)
        <div class="d-flex flex-row justify-content-between calendar_row">
            @for($dayInWeek=0; $dayInWeek<7; ++$dayInWeek)
                @if($weekIndex == 0)
                    <div class="border calendar_cell"><div class="calendar_text">{{ $dayOfTheWeekNameArray[$dayInWeek] }}</div></div>
                @else
                    @if($currDay == 0)
                        @if($dayInWeek == $startDayInWeek)
                            <?php ++$currDay; ?>
                        @endif
                    @endif
                    
                    @if($startDay <= $currDay && $currDay <= $endDay)
                        <div class="border calendar_cell"><div class="calendar_text">{{ $currDay }}</div></div>
                        <?php ++$currDay; ?>
                    @else
                        <div class="border calendar_cell"></div>
                    @endif
                @endif
            @endfor
        </div>
    @endfor
</div>