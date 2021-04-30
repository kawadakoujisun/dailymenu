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
    
    // 日付を表示するのに使う変数
    $currDay = 0;
    
?>

<div class="calendar_frame">
    <div class="d-flex flex-row justify-content-between calendar_row">
        <div class="border calendar_cell calendar_click_cell">
            <a href="{{ route('contents.ChangeCalendar', ['page_no' => $pageNo, 'calendar_value' => $prevCalendarYearMonth]) }}">
                <div class="calendar_text">{{ '<' }}</div>
            </a>
        </div>
        <div><div class="calendar_text">{{ $year . '年' . $month . '月' }}</div></div>
        <div class="border calendar_cell calendar_click_cell">
            <a href="{{ route('contents.ChangeCalendar', ['page_no' => $pageNo, 'calendar_value' => $nextCalendarYearMonth]) }}">
                <div class="calendar_text">{{ '>' }}</div>
            </a>
        </div>
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
                        @if($existDayArray[$currDay])
                            <div class="border calendar_cell calendar_click_cell">
                                <?php $currDateValue = sprintf('%s-%02d', $calendarYearMonth, $currDay);  // 2021-04-30 ?>
                                <a href="{{ route('contents.SelectDate', ['date_value' => $currDateValue, 'calendar_value' => $calendarYearMonth]) }}">
                                    <div class="calendar_text">{{ $currDay }}</div>
                                </a>
                            </div>
                        @else
                            <div class="border calendar_cell">
                                <div class="calendar_text">{{ $currDay }}</div>
                            </div>
                        @endif
                        <?php ++$currDay; ?>
                    @else
                        <div class="border calendar_cell"></div>
                    @endif
                @endif
            @endfor
        </div>
    @endfor
</div>