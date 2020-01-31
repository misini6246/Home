<style type="text/css">
    #znq-daohang {
        position: fixed;
        _position: absolute;
        _top: expression(eval(document.documentElement.scrollTop+document.documentElement.clientHeight)-20+"px");
        top: 50%;
        right: 10px;
        width: 100px;
        zoom: 1;
        height: 285px;
        background: url('{{get_img_path('images/miaosha/6_03.png')}}') no-repeat;
        z-index: 100000;
    }

    #znq-daohang a {
        display: block;
        width: 90px;
        height: 32px;
        /*margin-bottom: 1px;*/
        overflow: hidden;
    }

    #znq-daohang a #totop {
        position: absolute;
        bottom: 0px;
        cursor: pointer;
    }
</style>
<div id="znq-daohang" style="z-index: 10000">
    <div class="lianjie" style="width:86px;height:208px;margin-top:100px">
        @if(time()>=strtotime(20170608))
            <a href="{{route('category.index',['step'=>'promotion'])}}"></a>
        @else
            <a href="{{route('category.index',['step'=>'nextpro'])}}"></a>
        @endif
        <a href="/miaosha"></a>
        <a href="/cxhd/jpmz"></a>
        <a href="/cxhd/czhg"></a>
        <a href="{{route('index')}}"></a>

    </div>
</div>