<div id="znq-daohang" style="z-index: 10000">
    <div class="lianjie" style="width:124px;height:330px;margin:68px 0 0 30px">
        <a href="/jfdh"></a>
        <a href="/cz"></a>
        @if(time()<strtotime('2017-03-30')&&time()>=strtotime('2017-03-29'))
            @if(time()>=strtotime('2017-03-29'))
                <a target="_blank" href="{{route('category.index',['step'=>'promotion'])}}"></a>
            @else
                <a target="_blank" href="{{route('category.index',['step'=>'nextpro'])}}"></a>
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