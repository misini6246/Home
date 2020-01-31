<div id="append_parent"></div>
@if(Auth::check())
<p>&nbsp;&nbsp;<font style="color:#F95706;">{{Auth::user()->user_name}}</font>，欢迎来您到合纵医药网积分商城！<a href="/auth/logout">[退出]</a></p>
<div class="page_nav">
    <ul class="clear_float">
        <li><a href="{{route('jf.member')}}"><img src="{{path('jfen/images/select_record.png')}}" alt=""/><span>我的积分</span></a></li>
        <!--<li><a href="javascript:;"><img src="images/user_center.png" alt=""/><span>会员中心</span></a></li>-->
        <li class="padding0">|</li>

@else
    <p>&nbsp;&nbsp;合纵医药网积分商城欢迎您！</p>
    <div class="page_nav">
        <ul class="clear_float">
            <li><a href="/auth/login"><img src="{{path('jfen/images/login.png')}}" alt="登录"/><span>请登录</span></a></li>
            <li class="padding0">|</li>
            <li><a href="{{route('jf.member')}}"><img src="{{path('jfen/images/select_record.png')}}" alt=""/><span>我的积分</span></a></li>
            <!--<li><a href="javascript:;"><img src="images/user_center.png" alt=""/><span>会员中心</span></a></li>-->
            <li class="padding0">|</li>

@endif