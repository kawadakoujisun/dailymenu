{{-- Dishの値、RequestCountの値、リクエストボタンを表示 --}}
<div>
    <p style="font-size:200%;">{{ $dish_name }}</p>
</div>
<div class="m-3">
    <img src="{{ $dish_image_url }}">
</div>
<div>
    {!! link_to_route('contents.RequestDish', 'リクエスト', ['dish_id' => $dish_id], ['class' => 'btn btn-success']) !!}
    <span class="badge badge-secondary" style="font-size:100%;">{{ $requestCount_request_count }}</span>
</div>
<div class="m-2">
    <p>{!! nl2br(e($dish_description)) !!}</p>
</div>