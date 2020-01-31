<div id="header" class="container">
    <div class="container_box">
        @if(!$user)
            <div class="login_before">
                <a href="/auth/login" class="login">登录</a>
                <a href="/auth/register" class="reg">注册</a>
                <span class="Province">
						<img src="{{get_img_path('images/zs/header_add.png')}}" class="header_add"/>
                    @if($show_area==26)四川@else新疆@endif
                    <span class="icon">
                        <img src="{{get_img_path('images/zs/header_add_s.png')}}"/>
                        <img src="{{get_img_path('images/zs/header_add_x.png')}}"/>
                    </span>
                    <span class="add_choose">
                        @if($show_area==29)
                            <a href="/zs/?show_area=26">四川</a>
                        @else
                            <a href="/zs/?show_area=29">新疆</a>
                        @endif
                    </span>
                </span>
            </div>
        @else
            <div class="login_after">
					<span class="userid">
						{{$user->msn}}
                        <div class="user_box">
							<div class="user_top">
								<div class="img_box" style="border: 0">
                                     <img src="{{path('new/images/gerentouxiang.png')}}"/>
                                </div>
								<div class="text">
									<p class="p1">{{$user->msn}}</p>
									<p class="p2">{{$user_province or ''}}-{{$user_rank_name or ''}}</p>
								</div>
							</div>
							<ul>
								<li>
									<a href="{{route('member.order.index')}}">我的订单</a>
								</li>
								<li>
									<a href="/jf/member">我的积分</a>
								</li>
								<li>
									<a href="{{route('member.zncg')}}">智能采购</a>
								</li>
							</ul>
						</div>
					</span>
                <a href="/auth/logout" class="out">[退出]</a>
                <a href="{{route('member.index')}}" class="myyyg">我的药易购</a>
            </div>
        @endif

        <ul class="right_list">
            <li><a target="_blank" href="/dzfp">电子发票查询</a></li>
            <li><a target="_blank" href="/zhijian">质检报告查询</a></li>
            <li><a target="_blank" href="/requirement">求购专区</a></li>
            <li class="hover app_yyg">
                <img src="{{path('new/images/bgerweima_05.png')}}" class="header_erweima"/>
                手机药易购
                <span class="icon">
							<img src="{{get_img_path('images/zs/header_add_s.png')}}"/>
							<img src="{{get_img_path('images/zs/header_add_x.png')}}"/>
						</span>
                <div class="hover_box">
                    <img src="{{path('new/images//yaoyigou.png')}}"/>
                </div>
            </li>
            <li><a target="_blank" href="/article?id=3">帮助中心</a></li>
            <li class="hover tel">
                投诉
                <span class="icon">
							<img src="{{get_img_path('images/zs/header_add_s.png')}}"/>
							<img src="{{get_img_path('images/zs/header_add_x.png')}}"/>
						</span>
                <div class="hover_box">
                    15208485597
                </div>
            </li>
        </ul>

    </div>
</div>