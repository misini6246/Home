<div class="header">
    <div class="top_box">
        <div class="top">
            <div class="top_left">
                {!! member_info() !!}
            </div>
            <div class="top_right"><a href="#" id="addCollect">加入收藏</a>|<a href="{{route('index')}}">返回页面</a></div>
        </div>
    </div>
    <div class="banner_box">
        <div class="banner">
            <a href="{{route('article.index')}}"><img src="{{path('images/login_03.png')}}" alt=""/></a>
            <h1>{{$title}}</h1>
            <span class="tel"><img src="{{path('images/login00.png')}}" alt=""/></span>
        </div>
    </div>
</div>