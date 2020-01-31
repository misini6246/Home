<div id="nav" class="container">
    <div class="container_box">
        <div class="fenlei">
            <img src="{{path('new/images/fenlei.jpg')}}"/>
            <span>中药专区分类</span>
        </div>
        <ul class="nav_list">
            @foreach($middle_nav as $k=>$v)
                <li>
                    <a @if($v->name=='中药专区') style="color: #3ebb2b;font-weight: bold;" @endif href="{{$v->url}}"
                       @if($v->opennew==1)target="_blank" @endif >{{$v->name}}</a>
                </li>
            @endforeach
        </ul>
        <div class="gif_phone">
            <img src="{{path('new/images/dianhua.gif')}}"/>
        </div>
        <div class="site_content">
            <ul class="menu_list">
                @foreach($category as $k=>$v)
                    @if($k<4)
                        <li>
                            <a target="_blank" href="{{route('zyzq.category',['pid'=>$v->cat_id])}}">
                                <div class="text">
                                    <p class="text_top">
                                        <img src="{{get_img_path('images/zs/menu_right.png')}}" class="fr"/>
                                        <img src="{{get_img_path('images/zs/menu_right_hove.png')}}" class="fr"/>
                                        {{$v->cat_name}}
                                    </p>
                                </div>
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</div>
<script>
    $('.fenlei,.site_content').hover(function () {
        $('.site_content').show();
    }, function () {
        $('.site_content').hide();
    });
    var index;
    $('.menu_list li').hover(function () {
        index = $(this).index();
        $(this).addClass('active');
        $(this).prev().find('.text').css('border-bottom', 'none')
    }, function () {
        $(this).removeClass('active');
        $(this).prev().find('.text').css('border-bottom', '1px dashed #b2d1c1')
    })
</script>