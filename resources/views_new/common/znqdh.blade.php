<style type="text/css">
    #znq-daohang {
        position: fixed;
        _position: absolute;
        _top: expression(eval(document.documentElement.scrollTop+document.documentElement.clientHeight)-20+"px");
        top: 40%;
        right: 10px;
        width: 124px;
        zoom: 1;
        height: 330px;
        background: url('{{get_img_path('images/znq-jfdh04.png')}}') no-repeat;
        z-index: 100000;
    }

    #znq-daohang a {
        display: block;
        width: 90px;
        height: 35px;
        margin-bottom: 1px;
        overflow: hidden;
    }

    #znq-daohang a#totop {
        position: absolute;
        bottom: 0px;
        cursor: pointer;
    }

</style>
<div id="znq-daohang" style="z-index: 10000">
    <div class="lianjie" style="width:124px;height:330px;margin:68px 0 0 30px">
        <a href="/jfdh"></a>
        <a href="/cz"></a>
        @if(time()<strtotime('2017-03-30')&&time()>=strtotime('2017-03-27'))
            @if(time()>=strtotime('2017-03-29'))
                <a href="{{route('category.index',['step'=>'promotion'])}}"></a>
            @else
                <a href="{{route('category.index',['step'=>'nextpro'])}}"></a>
            @endif

        @else
            <a onclick="znq_ts('{{path('huodong/images/3.29_03.png')}}')" href="javascript:;"></a>
        @endif
        <a href="http://www.hezongyy.com/"></a>

    </div>
</div>
<script>

    function znq_ts(img) {
        $('.Bombbox').css('background','url('+img+')');
        $('#chakan').hide();
        $('.err').hide();
        $('.Bombbox').css('display', 'block')
    }
</script>