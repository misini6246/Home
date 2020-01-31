@if(isset($page)&&$page==1)
    <div style="width: 170px;height: 500px;position: fixed;top: 20%;left: 0;z-index: 99999999;">
        <img src="http://www.hezongyy.com/images/close.png?20171106061054" style="float: right;cursor: pointer;"
             onclick="$(this).parent().remove()"/>
        <a target="_blank"
           href="http://www.hezongyy.com/category?keywords=%E6%B1%9F%E8%8B%8F%E8%BF%AA%E8%B5%9B%E8%AF%BA%E5%88%B6%E8%8D%AF%E6%9C%89%E9%99%90%E5%85%AC%E5%8F%B8&showi=0&step=disainuo">
            <img src="{{get_img_path('images/miaosha/disainuo.jpg')}}"/>
        </a>
        <a target="_blank"
           href="http://www.hezongyy.com/category?keywords=%E6%B9%96%E5%8C%97%E6%BD%9C%E6%B1%9F%E5%88%B6%E8%8D%AF%E8%82%A1%E4%BB%BD%E6%9C%89%E9%99%90%E5%85%AC%E5%8F%B8&showi=0&step=qianjiang">
            <img src="{{get_img_path('images/miaosha/qianjiang.jpg')}}"/>
        </a>
    </div>
@endif
