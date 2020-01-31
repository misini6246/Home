<ul class="nav_title">
    @if($middle_nav)
    @foreach($middle_nav as $k=>$v)
        <li><a @if($v->is_checked==1)class="checked"@endif href="{{$v->url}}" @if($v->opennew==1)target="_blank" @endif >{{$v->name}}</a>@if($k<count($middle_nav) - 1)<span class="separate"></span>@endif @if($v->is_hot==1)<span class="hot"></span>@endif</li>
    @endforeach
    @endif
</ul>
<div class="shopping_ico">
    <a href="{{route('cart.index')}}"><img src="{{get_img_path('images/index_25.png')}}"/></a>
</div>