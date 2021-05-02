{{-- $pageNoは1始まり --}}
{{-- $calendarYearMonthは2021-04 --}}
{{-- $existDayArrayは要素数31+1の配列。日をそのまま配列のインデックスとして使える。 --}}

<?php

    $weekNumMax = 1 + 6;  // 曜日を表示する行の分を足しておく
    $dayOfTheWeekNameArray = [ '日', '月', '火', '水', '木', '金', '土' ];

    $calendarYearMonthArray = explode("-", $calendarYearMonth);  // 年と月に分ける

    $year  = $calendarYearMonthArray[0];
    $month = abs($calendarYearMonthArray[1]);  // 先頭の0を取り除く
    $startDay = 1;  // = date("d", strtotime('first day of ' . $calendarYearMonth));
    $endDay   = date("d", strtotime('last day of ' . $calendarYearMonth));
    
    $startDayInWeek = date("w", strtotime($calendarYearMonth . '-01'));
    
    $prevCalendarYearMonth = null;
    if($month <= 1){
        $prevYear = $year - 1;
        if($prevYear < 0) $prevYear = 0;
        $prevCalendarYearMonth = sprintf('%04d-%02d', $prevYear, 12);
    } else {
        $prevCalendarYearMonth = sprintf('%04d-%02d', $year, $month-1);
    }
    
    $nextCalendarYearMonth = null;
    if($month >= 12) {
        $nextYear = $year + 1;
        if($nextYear > 9999) $nextYear = 9999;
        $nextCalendarYearMonth = sprintf('%04d-%02d', $nextYear, 1);
    } else {
        $nextCalendarYearMonth = sprintf('%04d-%02d', $year, $month+1);
    }
    
    // 定休日
    $closeDayArray = array_fill(0, 31 + 1, false);  // 日をそのまま配列のインデックスにするために32個用意する
    $dayInWeek = $startDayInWeek;
    for($currDay=$startDay; $currDay<=$endDay; ++$currDay) {
        if($dayInWeek == 2){  // 火曜日を定休日とする
            $closeDayArray[$currDay] = true;
        }
        $dayInWeek = ($dayInWeek + 1) % 7;
    }
    
    // 日付を表示するのに使う変数
    $currDay = 0;
    
?>

<div class="calendar_frame">
    <div class="d-flex flex-row justify-content-between calendar_row">
        <div class="calendar_cell calendar_click_cell_arrow">
            <a href="{{ route('contents.ChangeCalendar', ['page_no' => $pageNo, 'calendar_value' => $prevCalendarYearMonth]) }}">
                <div class="calendar_text calendar_text_color_weekday">{{ '<' }}</div>
            </a>
        </div>
        <div class="calendar_cell_month">
            <div class="calendar_text calendar_text_color_weekday">{{ $year . '年' . $month . '月' }}</div>
        </div>
        <div class="calendar_cell calendar_click_cell_arrow">
            <a href="{{ route('contents.ChangeCalendar', ['page_no' => $pageNo, 'calendar_value' => $nextCalendarYearMonth]) }}">
                <div class="calendar_text calendar_text_color_weekday">{{ '>' }}</div>
            </a>
        </div>
    </div>
    
    @for($weekIndex=0; $weekIndex<$weekNumMax; ++$weekIndex)
        <div class="d-flex flex-row justify-content-between calendar_row">
            @for($dayInWeek=0; $dayInWeek<7; ++$dayInWeek)
                <?php
                    $calendarTextColorClass = "calendar_text_color_weekday";
                    if($dayInWeek == 0) {
                        $calendarTextColorClass = "calendar_text_color_holiday";
                    } else if($dayInWeek == 6) {
                        $calendarTextColorClass = "calendar_text_color_saturday";
                    }
                    // currDayが1以上なら日付が入っているので、日曜日以外の休日を調べるのに使える。
                ?>
                @if($weekIndex == 0)
                    <div class="calendar_cell">
                        {!! '<div class="calendar_text ' . $calendarTextColorClass . '">' !!} {{ $dayOfTheWeekNameArray[$dayInWeek] }} {!! '</div>' !!}
                    </div>
                @else
                    @if($currDay == 0)
                        @if($dayInWeek == $startDayInWeek)
                            <?php ++$currDay; ?>
                        @endif
                    @endif
                    
                    @if($startDay <= $currDay && $currDay <= $endDay)
                        @if($existDayArray[$currDay])
                            <div class="calendar_cell calendar_click_cell">
                                <?php $currDateValue = sprintf('%s-%02d', $calendarYearMonth, $currDay);  // 2021-04-30 ?>
                                <a href="{{ route('contents.SelectDate', ['date_value' => $currDateValue, 'calendar_value' => $calendarYearMonth]) }}">
                                    {!! '<div class="calendar_text ' . $calendarTextColorClass . '">' !!} {{ $currDay }} {!! '</div>' !!}
                                </a>
                            </div>
                        @elseif($closeDayArray[$currDay])
                            <div class="calendar_cell calendar_close_cell">
                                {!! '<div class="calendar_text ' . $calendarTextColorClass . '">' !!} {{ $currDay }} {!! '</div>' !!}
                            </div>
                        @else
                            <div class="calendar_cell">
                                {!! '<div class="calendar_text ' . $calendarTextColorClass . '">' !!} {{ $currDay }} {!! '</div>' !!}
                            </div>
                        @endif
                        <?php ++$currDay; ?>
                    @else
                        <div class="calendar_cell"></div>
                    @endif
                @endif
            @endfor
        </div>
    @endfor
</div>