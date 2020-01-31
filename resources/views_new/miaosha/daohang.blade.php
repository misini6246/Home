<style type="text/css">
    #znq-daohang {
        display: none;
        position: fixed;
        top: 50%;
        right: 0;
        width: 157px;
        zoom: 1;
        height: 353px;
        {{--background: url('{{get_img_path('adimages1/201809/daohang1.png')}}1') no-repeat;--}}
        background: url('http://images.hezongyy.com/adimages1/201910/daohang.png?4') no-repeat;
        z-index: 10;
    }

    #znq-daohang a {
        display: block;
        width: 94px;
        height: 42px;
        /*margin-bottom: 1px;*/
        overflow: hidden;
        margin-top: 0px;
        margin-left: 5px;
        /*border: 1px solid red;*/
        box-sizing: border-box;
    }

    #znq-daohang a #totop {
        position: absolute;
        bottom: 0px;
        cursor: pointer;
    }
</style>

<div id="znq-daohang">
    <div class="lianjie" style="height:208px;margin: 66px 0 0 9px;">
        <a href="{{route('category.index',['step'=>'nextpro'])}}"></a>
        <a href="/ms/"></a>
        <a href="/cxhd/jpmz"></a>
        <a href="/cxhd/czhg"></a>
        <a style="height: 55px;" href="{{route('index')}}"></a>

    </div>
</div>
<script type="text/javascript">
    $('.shouqi').click(function () {
        $('#znq-daohang').hide();
        $('#znq-daohang_1').show();
    })
    $('.zhankai').click(function () {
        $('#znq-daohang').show();
        $('#znq-daohang_1').hide();
    })
</script>
