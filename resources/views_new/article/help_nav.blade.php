<div id="nav" class="container">
    <div class="container_box">
        <div class="logo">
            <a href="{{route('index')}}"><img src="{{get_img_path('images/new/help_logo.jpg')}}"/></a>
        </div>
        <ul class="nav_list">
            @foreach($category as $k=>$v)
                <li @if($k==$cat_id)class="active"@endif>
                    <a href="{{route('xin.help',['cat_id'=>$k])}}">{{$v}}</a>
                </li>
            @endforeach
        </ul>
    </div>
</div>