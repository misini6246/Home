<style type="text/css">
    #shuang11-daohang {position:fixed;_position:absolute;_top:expression(eval(document.documentElement.scrollTop+document.documentElement.clientHeight)-20+"px");bottom:10px;right:2px;width:79px;zoom:1;height: 200px; background:url('{{get_img_path('images/hd_daohang.png')}}') no-repeat;z-index: 100000;}

    #shuang11-daohang a{ display:block; width:150px; height:24px; margin-bottom:5px; overflow:hidden;}

    #shuang11-daohang a#totop{position:absolute;bottom:0px;cursor:pointer;}

</style>


<div id="shuang11-daohang">
    <div class="lianjie" style="width:79px;height:250px;margin-top:55px;">
        <a target="_blank" href="/miaosha.html"></a>
        <a target="_blank" href="@if(strtotime('2016-12-12 00:00:00')<time()) {{route('category.index',['step'=>'promotion'])}} @else {{route('category.index',['step'=>'nextpro'])}} @endif"></a>
        <a target="_blank" href="/hd/shuang12"></a>

        <a href="{{route('index')}}"></a>
    </div>
</div>
