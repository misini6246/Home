<style>
    #shuang11-daohang {position:fixed;_position:absolute;_top:expression(eval(document.documentElement.scrollTop+document.documentElement.clientHeight)-20+"px");bottom:20px;right:2px;width:210px;zoom:1;height: 440px; background:url('{{get_img_path('images/zhhcdh.png')}}') no-repeat;z-index: 100000;}
    #shuang11-daohang2 {position:fixed;_position:absolute;_top:expression(eval(document.documentElement.scrollTop+document.documentElement.clientHeight)-20+"px");bottom:20px;right:2px;width:210px;zoom:1;height: 440px; background:url('{{get_img_path('images/zhhcdh2.png')}}') no-repeat;z-index: 100000;}

    #shuang11-daohang a,#shuang11-daohang2 a{ display:block; width:140px; height:45px; margin-bottom:5px; overflow:hidden;}

    #shuang11-daohang a#totop,#shuang11-daohang2 a#totop{background-position:0 -166px;position:absolute;bottom:0px;cursor:pointer;}

</style>
<div @if($fd_type==1)id="shuang11-daohang"@else id="shuang11-daohang2" @endif>
    <div class="lianjie" style="width:140px;height:200px;margin:194px 0 0 32px">
        <a href="/bm"></a>
        <a href="/jfdh"></a>
        <a href="/cj"></a>
        <a @if($fd_type==1)href="#top"@else href="/shuang11" @endif></a>
        <a href="{{route('index')}}"></a>
    </div>
</div>