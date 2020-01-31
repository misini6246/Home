@if(isset($page)&&$page==1)
    <div style="width: 180px;height: 500px;position: fixed;top: 20%;left: 0;z-index: 99999999;">
        <img src="http://www.hezongyy.com/images/close.png?20171106061054" style="float: right;cursor: pointer;"
             onclick="$(this).parent().remove()"/>
        <a target="_blank"
           href="/yhq">
            <img src="{{get_img_path('images/hd/lqyhq.jpg')}}"/>
        </a>
    </div>
@endif
