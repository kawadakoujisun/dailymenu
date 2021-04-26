{{-- Dishの値、RequestCountの値、リクエストボタンを表示 --}}
<div>
    <p style="font-size:200%;">{!! nl2br(e($dish_name)) !!}</p>
</div>
<div class="m-3">
    <img src="{{ $dish_image_url }}" style="max-width: 100%; height: auto; width: auto;">
</div>
<div>
    <?php $dish = \App\Dish::findOrFail($dish_id); ?>
    <?php $requestCount = $dish->requestCount; ?>
    @if($requestCount->isRequested())
        <span>リクエスト</span>
    @else
        {!! link_to_route('contents.RequestDish', 'リクエスト', ['dish_id' => $dish_id], ['class' => 'btn btn-success']) !!}
    @endif
    <span class="badge badge-secondary" style="font-size:100%;">{{ $requestCount_request_count }}</span>
</div>
<div class="m-2 mx-auto" style="max-width: 600px;">
    <p class="text-left">{!! nl2br(e($dish_description)) !!}</p>
</div>