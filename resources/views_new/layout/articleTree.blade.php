{{--<div class="subNavBox">--}}
    {{--@foreach($artCat as $v)--}}
        {{--<div class="subNav @if(isset($article)&&$article->articleCat->cat_id==$v->cat_id) currentDd currentDt @endif">{{$v->cat_name}} </div>--}}
        {{--<ul @if(isset($article)&&$article->articleCat->cat_id==$v->cat_id) style="display: block" @else style="display: none;"  @endif class="navContent">--}}
            {{--@foreach($v->article as $val)--}}
            {{--<li><a target="_blank" href="{{route('articleInfo',['id'=>$val->article_id])}}" title="免费注册">{{$val->title}}</a></li>--}}
            {{--@endforeach--}}
        {{--</ul>--}}
    {{--@endforeach--}}
        {{--<div class="subNav"><a class="subNav_a" href="{{route('article.index',['id'=>4])}}" title="公司动态">公司动态</a></div>--}}
        {{--<div class="subNav"><a class="subNav_a" href="{{route('article.index',['id'=>12])}}" title="公司动态">医药信息</a></div>--}}
{{--</div>--}}
<div class="title"><img src="{{path('images/help1.png')}}"></div>
<div class="subNavBox">
    @foreach($artCat as $v)
        <div class="subNav @if(isset($cat_id)&&$cat_id==$v->cat_id) currentDd currentDt @endif">{{$v->cat_name}} </div>
        <ul style="display: block" class="navContent">
            @foreach($v->article as $val)
                <li><a @if(isset($id)&&$id==$val->article_id) class="a_checked" @endif href="{{route('articleInfo',['id'=>$val->article_id])}}" title="{{$val->title}}">{{$val->title}}</a></li>
            @endforeach
        </ul>
    @endforeach
    {{--<a href="{{route('article.index',['id'=>4])}}" title="公司动态"><div class="subNav">公司动态</div></a>--}}
    {{--<a href="{{route('article.index',['id'=>12])}}" title="医药信息"><div class="subNav">医药信息</div></a>--}}
</div>