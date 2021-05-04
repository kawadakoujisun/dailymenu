{{-- Dishの値、RequestCountの値、リクエストボタンを表示 --}}
<div class="dish_name">
    <p class="font_size_dish_name">{!! nl2br(e($dish_name)) !!}</p>
</div>
<div class="dish_image">
    <img src="{{ $dish_image_url }}" style="max-width: 100%; height: auto; width: auto;">
</div>
<div>
    <?php $dish = \App\Dish::findOrFail($dish_id); ?>
    <?php $requestCount = $dish->requestCount; ?>
    @if($requestCount->isRequested())
        <span>リクエスト</span>
    @else
        {{-- {{ $sharpJumpId }} --}}  {{-- 試しに@includeで引数を渡してみた --}}
        {{-- 「'id' => 'request_button_'.$jumpId」はJavaScriptのテストのために追加したものなので、JavaScriptのテストをしないなら不要。  --}}
        {!! link_to_route('contents.RequestDish', 'リクエスト', ['dish_id' => $dish_id, 'jump_id' => $jumpId], ['class' => 'btn btn-success', 'id' => 'request_button_'.$jumpId]) !!}
        
        {{-- JavaScriptでローカルストレージを使うテスト --}}
        {{--
        <script>
            {
                const requestButtonId = 'request_button_' + @json($jumpId);
 
                const requestButton = document.getElementById(requestButtonId);
                requestButton.addEventListener('click', (e) => {
                
                    // スリープ
                    const sleepTime = 2000;  // mili seconds
                    {
                        const d1 = new Date();
                        while (true) {
                            const d2 = new Date();
                            if (d2 - d1 > sleepTime) {
                                break;
                            }
                        }
                    }
                
                    // hrefのリンク先に飛ばないようにする
                    e.preventDefault();
        
                    console.log('イベントの種類：', e.type);
                    alert('ボタンクリック：' + requestButtonId);
                    
                    // ローカルストレージを使ってみる
                    const itemVal = localStorage.getItem("dailymenu_item");
                    if (itemVal) {
                        console.log('localStorage itemVal：' + itemVal);
                        
                        localStorage.removeItem("appName");
                        localStorage.removeItem("dailymenu_item");
                    } else {
                        localStorage.appName = "dailymenu";
                        localStorage.setItem("dailymenu_item", "2021/04/27");
                    }
                });
            }
        </script>        
        --}}
        
    @endif
    <span class="badge badge-secondary" style="font-size:100%;">{{ $requestCount_request_count }}</span>
</div>
<div class="dish_description_outer">
    <div class="dish_description mx-auto">
        <p class="text-left mb-0">{!! nl2br(e($dish_description)) !!}</p>
    </div>
</div>