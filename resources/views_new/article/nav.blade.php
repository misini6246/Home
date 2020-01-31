<div id="nav" class="container">
    <div class="container_box">
        <div class="logo">
            <a href="{{route('index')}}"><img src="/index/img/logo.jpg"/></a>
        </div>
        <div class="option">
            @foreach($help_nav as $n)
                <div @if($n->name == '公司动态')class="option-item cur" @else class="option-item" @endif><a href="{{ $n->url }}">{{ $n->name }}</a></div>
            @endforeach
        </div>
        <div class="fr">
            <img src="{{get_img_path('images/new/news_phone_num.jpg')}}"/>
        </div>
    </div>
</div>