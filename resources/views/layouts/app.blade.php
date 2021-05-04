<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>DailyMenu</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=RocknRoll+One&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Kosugi+Maru&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="/css/main.css">
    </head>

    <body>
        {{-- ナビゲーションバー --}}
        @include('commons.navbar')

        <div class="container-fluid p-0">
            {{-- エラーメッセージ --}}
            @include('commons.error_messages')

            @yield('content')
        </div>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.7.2/js/all.js"></script>
    </body>
</html>
