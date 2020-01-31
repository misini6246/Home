
<!-- 顶部banner图 start -->
@if(ads(26))

    <div style="background: url('{{path('images/fapiao.jpg')}}') no-repeat scroll center top;height: 100px;min-width: 1200px;overflow: hidden;width: 100%;" class="top_wrap">
        <div style="height:100px;position: relative;width: 1200px;margin: 0 auto;"><a href="" style="display:block;width:100%;height:100%" target="_blank"></a><span class="close_btns"></span></div>
    </div>

    @endif
            <!-- end -->

    <div class="header">
        <div class="top_box">
            <div class="top">
                <div class="top_left">
                    {!! member_info() !!}
                </div>
                <div class="top_right">
                    <a target="_blank" href="{{route('article.index',['id'=>4])}}"><span style="font-weight:bold;color:#329900;">合纵资讯</span></a>|<a target="_blank" href="http://171.221.207.113:88/index.php/Index/index">质检报告查询</a>|<a target="_blank" href="{{route('requirement.index')}}">求购专区</a>|<a href="{{route('cart.index')}}" class="cart_a"><span class="cart_ico"></span> 购物车(<span class="num">{{cart_info()}}</span>)</a>|<a target="_blank" href="{{route('user.collectList')}}" class="common collect_a" ><span class="collect_ico"></span> 我的收藏 </a>
                    <a href="javascript:;" class="attention">关注<span class="pic"><img src="{{path('images/code_pic.png')}}" alt=""/></span><span class="ico"></span></a>
                    <a target="_blank" href="{{route('article.index',['id'=>3])}}">帮助中心 </a>
                </div>
            </div>
        </div>
        <div class="mid">
            <div class="logo"><a href="{{route('index')}}" name="top"><img src="{{path('images/index_logo.png')}}" alt="logo"/></a></div>
            <div class="search">
                <div class="search_box fn_clear">
                    <input name="userSearch" id="suggest" type="text" value="@if(!isset($keywords)||$keywords=='')药品名称(拼音缩写)@else{{$keywords}}@endif"  class="search_input"/>
                    <a href="javascript:void(0)" class="btn search_btn" id="search_btn">搜 索</a>

                    <div id="suggestions_wrap" class="search_show list_box" style="display: none;">
                        <ul id="suggestions" class="search_list">

                        </ul>
                    </div>

                </div>

                <div class="search_title">
                    <span>热门搜索：</span>
                    @foreach(session('searchKeywords') as $k=>$val)
                        @if($k<7)
                            <a href="{{route('category.index',['keywords'=>$val,'showi'=>0])}}">{{$val}}</a>
                        @endif
                    @endforeach
                </div>

            </div>
            <div class="tel">
                <img src="{{path('images/tel_pic.jpg')}}" alt="联系电话"/>
                <p><a href="{{path('images/zgz1.png')}}" target="_blank" class="text">互联网药品交易服务资格证</a></p>
                <p><a href="{{path('images/zgz2.png')}}" target="_blank" class="text">互联网药品信息服务资格证</a></p>
            </div>
        </div>
        <div class="nav">
            <div class="nav_box fn_clear">
                <div class="title_nav">
                    全部商品分类 <span class="title_ico"></span>
                    <div class="left_nav fn_clear">
                        <ul class="nav_list" >
                            @foreach(taxonomic_tree() as $v)
                                <li class="child_li @if($v=='中西成药'||$v=='国/川.基药') jiyao @endif">
                                    <p>
                    <span class="menu_ico @if($v=='进口.合资') recommend @endif
                    @if($v=='国/川.基药') new @endif
                    @if($v=='中药饮片') medical @endif
                    @if($v=='保健食品') health @endif
                    @if($v=='器械.计生') pieces @endif"></span>
                                        <a href="@if($v=='中西成药') category?dis=1 @endif
                                        @if($v=='进口.合资') category?dis=9 @endif
                                        @if($v=='国/川.基药') category?dis=8 @endif
                                        @if($v=='中药饮片') category?dis=4 @endif
                                        @if($v=='保健食品') category?dis=5 @endif
                                        @if($v=='器械.计生') category?dis=6 @endif">
                                            <span class="title_text">{{$v}}</span></a> <span class="right_ico"></span></p></li>
                            @endforeach
                        </ul>
                        <ul class="box big_box fn_clear">
                            <li style="display: none;" class="jiyao fn_clear"><!-- 中西成药 -->
                                <h3>西药</h3>
                                <div class="fn_clear">
                                    @foreach(cate_tree(22) as $v)
                                        <a href="{{route('category.index',['dis'=>1,'phaid'=>$v->cat_id])}}" title="{{$v->cat_name}}">{{$v->cat_name}}</a>
                                    @endforeach
                                </div>
                                <h3 class="h_t">中成药</h3>
                                <div>
                                    @foreach(cate_tree(188) as $v)
                                        <a href="{{route('category.index',['dis'=>1,'phaid'=>$v->cat_id])}}" title="{{$v->cat_name}}">{{$v->cat_name}}</a>
                                    @endforeach
                                </div>


                            </li>
                            <li class="fn_clear"><!-- 进口.合资 -->
                                <h3>进口.合资</h3>
                                <div class="fn_clear">
                                    @foreach(cate_tree(399) as $v)
                                        <a href="{{route('category.index',['dis'=>9,'phaid'=>$v->cat_id])}}" title="{{$v->cat_name}}">{{$v->cat_name}}</a>
                                    @endforeach
                                </div>
                            </li>
                            <li class="jiyao fn_clear"><!-- 基药 -->
                                <h3>西药</h3>
                                <div class="fn_clear">
                                    @foreach(cate_tree(22) as $v)
                                        <a href="{{route('category.index',['dis'=>8,'phaid'=>$v->cat_id])}}" title="{{$v->cat_name}}">{{$v->cat_name}}</a>
                                    @endforeach
                                </div>
                                <h3 class="h_t">中成药</h3>
                                <div>
                                    @foreach(cate_tree(188) as $v)
                                        <a href="{{route('category.index',['dis'=>8,'phaid'=>$v->cat_id])}}" title="{{$v->cat_name}}">{{$v->cat_name}}</a>
                                    @endforeach
                                </div>
                            </li>
                            <li class="fn_clear"><!-- 器械.计生 -->
                                <h3>器械.计生</h3>
                                <div class="fn_clear">
                                    @foreach(cate_tree(1) as $v)
                                        <a href="{{route('category.index',['dis'=>6,'phaid'=>$v->cat_id])}}" title="{{$v->cat_name}}">{{$v->cat_name}}</a>
                                    @endforeach
                                </div>
                            </li>
                            <li class="fn_clear"><!-- 保健食品 -->
                                <h3>保健食品</h3>
                                <div class="fn_clear">
                                    @foreach(cate_tree(12) as $v)
                                        <a href="{{route('category.index',['dis'=>5,'phaid'=>$v->cat_id])}}" title="{{$v->cat_name}}">{{$v->cat_name}}</a>
                                    @endforeach
                                </div>
                            </li>
                            <li class="fn_clear"><!-- 中药饮片 -->
                                <h3>中药饮片</h3>
                                <div class="fn_clear">
                                    @foreach(cate_tree(6) as $v)
                                        <a href="{{route('category.index',['dis'=>4,'phaid'=>$v->cat_id])}}" title="{{$v->cat_name}}">{{$v->cat_name}}</a>
                                    @endforeach
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <ul class="nav_title">
                    @foreach(nav_list('middle') as $k=>$v)
                        <li><a @if(navChecked(isset($dis)?$dis:0,isset($py)?$py:0)==$v->name)class="checked"@endif href="{{$v->url}}" @if($v->opennew==1)target="_blank" @endif >{{$v->name}}</a>@if($k<6)<span class="separate"></span>@endif @if($k==3)<span class="hot"></span>@endif</li>
                    @endforeach
                </ul>
                <div class="shopping_ico">
                    <a href="{{route('cart.index')}}"><img src="{{path('images/index_25.png')}}" alt=""/></a>
                </div>
            </div>


        </div>
    </div>
