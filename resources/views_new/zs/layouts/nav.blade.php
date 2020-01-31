<div id="nav" class="container">
    <div class="container_box">
        <div class="fenlei">
            <img src="{{path('new/images/fenlei.jpg')}}"/>
            <span>诊所用药分类</span>
        </div>
        <ul class="nav_list">
            @foreach($middle_nav as $k=>$v)
                <li>
                    <a @if($v->name=='诊所专区') style="color: #3ebb2b;font-weight: bold;" @endif href="{{$v->url}}"
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
                    @if($k<5)
                        <li>
                            <div class="text">
                                <p class="text_top">
                                    <img src="{{get_img_path('images/zs/menu_right.png')}}" class="fr"/>
                                    <img src="{{get_img_path('images/zs/menu_right_hove.png')}}" class="fr"/>
                                    {{$v->cat_name}}
                                </p>
                                <p class="text_bottom">
                                    @foreach($v->cate as $key=>$val)
                                        @if($key<3)
                                            <span>{{$val->cat_name}}</span>
                                        @endif
                                    @endforeach
                                </p>
                            </div>
                            <ul class="child">
                                @foreach($v->cate as $val)
                                    @if(count($val->cate)>0)
                                        <li style="height: auto;">
                                            <p class="title">{{$val->cat_name}}</p>
                                            <ul>
                                                @foreach($val->cate as $value)
                                                    <li class="cat_name"><a
                                                                href="{{route('category.index',['ylfl'=>'n','ylfl1'=>$v->cat_id,'ylfl2'=>$value->cat_id])}}">{{$value->cat_name}}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</div>