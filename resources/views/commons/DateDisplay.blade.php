{{-- 年月日（曜日）表示 --}}
<?php
    $dateDst = '<span class="word_lump">' . ' - ' . '年' . ' - ' . '月' . ' - ' . '日' . '</span><span class="word_lump">' . '（' . ' - ' . '曜日）' . '</span>';  // word_lumpを付与したspanで改行位置を制御する
    if ($dateSrc != null)
    {
        $dateTimestamp = strtotime($dateSrc);
        $dayOfTheWeekNameArray = [ '日', '月', '火', '水', '木', '金', '土' ];
        $dateDst = '<span class="word_lump">' . date('Y', $dateTimestamp) . '年' . date('n', $dateTimestamp) . '月' . date('j', $dateTimestamp) . '日' . '</span><span class="word_lump">' . '（' . $dayOfTheWeekNameArray[date('w', $dateTimestamp)] . '曜日）' . '</span>';
    }
    // print $beforeDate . $dateDst . $afterDate;  // htmlタグあり改行なしなのでnl2br(htmlspecialchars())では括らない。ユーザが文字列を入力するわけではないし。
    // でも{!! !!}と{{ }}で表示することにしたのでコメントアウト。表示方法を変えるに至った理由は特にないけど。
?>

{!! $beforeDate !!} {!! $dateDst !!} {!! $afterDate !!}
