<div class="nav-right">
    <div class="nav-right">
        <div class="luo-bo-mid">

            <div class="new_banner">
                <ul class="rslides f426x240">
                    @foreach($ad100 as $ad)
                        <li><a href="{{$ad->ad_link}}" target="_blank">
                                <img src="{{get_img_path('data/afficheimg/'.$ad->ad_code)}}" width="770" height="480" alt="" /></a></li>
                    @endforeach
                </ul>
            </div>

        </div>
        <ul class="banner-ad-list">
            @if($ad101)
                @foreach($ad101 as $k=>$v)
                    @if($k<2)
                        <li class="overimg">
                            <a href="{{$v->ad_link}}" target="_blank"><img src="{{$v->ad_code}}" alt="" /></a>
                            <i class="light"></i>
                        </li>
                    @endif
                @endforeach
            @endif

        </ul>
        <!-- 导航条右侧结束 -->
    </div>

    <!-- 导航条右侧结束 -->
</div>