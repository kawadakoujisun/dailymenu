{{-- Dishの値、RequestCountの値、リクエストカウントリセットボタンを表示 --}}
<div>
    {{-- beforeとafterはhtmlタグであるし、ユーザが入力するものでもないので、!!で括る。 --}}
    {!! $before_dish_name !!} {!! nl2br(e($dish->name)) !!} {!! $after_dish_name !!}
</div>
<div class="m-3">
    <img src="{{ $dish->image_url }}" style="max-width: 100%; height: auto; width: auto;">
</div>
<div>
    {!! link_to_route('management.dishes.ResetRequestCount', 'リクエストカウントをリセット', ['id' => $dish->id], ['class' => 'btn btn-warning']) !!}
    <span class="badge badge-secondary" style="font-size:100%;">{{ $dish->requestCount->request_count }}</span>
</div>                    
<div class="m-2 mx-auto" style="max-width: 600px;">
    <p class="text-left">{!! nl2br(e($dish->description)) !!}</p>
</div>