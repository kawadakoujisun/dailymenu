{{-- 年月日（曜日）表示 --}}
<?php
    $dateDst = ' - ' . '年' . ' - ' . '月' . ' - ' . '日' . '（' . ' - ' . '曜日）';
    if ($dateSrc != null)
    {
        $dateTimestamp = strtotime($dateSrc);
        $dayOfTheWeekNameArray = [ '日', '月', '火', '水', '木', '金', '土' ];
        $dateDst = date('Y', $dateTimestamp) . '年' . date('n', $dateTimestamp) . '月' . date('j', $dateTimestamp) . '日' . '（' . $dayOfTheWeekNameArray[date('w', $dateTimestamp)] . '曜日）';
    }
    // print $beforeDate . $dateDst . $afterDate;  // htmlタグあり改行なしなのでnl2br(htmlspecialchars())では括らない。ユーザが文字列を入力するわけではないし。
    // でも{!! !!}と{{ }}で表示することにしたのでコメントアウト。表示方法を変えるに至った理由は特にないけど。
?>

{!! $beforeDate !!} {{ $dateDst }} {!! $afterDate !!}
