<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="Keywords" content="" />
    <meta name="Description" content="" />
    @include('layout.token')
    <title>合纵医药电子商务采购平台-药易购</title>
    <link href="{{path('css/base.css')}}" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{{path('js/jquery.min.js')}}"></script>

    <style type="text/css">
        .zhongle{ width:250px; height:136px;position: fixed;left: 50%;top: 50%;margin-left: -125px;margin-top: -70px;z-index: 1003;display: none;text-align: center;}
        .zhongle11{ width:250px; height:136px;position: fixed;left: 50%;top: 50%;margin-left: -125px;margin-top: -70px;z-index: 1003;display: none;text-align: center;}
        .zhongjiang{position: relative; width:250px; height:136px;}
        .zhongjiang11{position: relative; width:250px; height:136px;}
        .close{width: 20px;height: 20px;position: absolute;right: 4px;top:4px;cursor: pointer;background-color: #f00;opacity: 0;filter:alpha(opacity=0);}
        .queding{width: 70px;height: 30px;position: absolute;left: 54px;top:78px;background-color: #f00;opacity: 0;filter:alpha(opacity=0);}
        .check{width: 70px;height: 30px;position: absolute;left: 125px;top:78px;background-color: #f00;opacity: 0;filter:alpha(opacity=0);}
        .text{font-size: 24px;color: #fff;position: absolute;left: 50px;height: 32px;line-height: 32px;font-weight: bold;top:30px;}
        .yhq0 {width:240px;height:130px;position:absolute;left:104px;top:15px;}
        .yhq1 {width:240px;height:130px;position:absolute;left:354px;top:15px;}
        .yhq2 {width:240px;height:130px;position:absolute;left:601px;top:15px;}
        .yhq3 {width:240px;height:130px;position:absolute;left:849px;top:15px;}
    </style>
</head>
<body style="padding: 0;margin: 0;background-color:#ab024b;position:relative;">

<div class="zhongle" >
    <div class="zhongjiang">
        <img src="{{get_img_path('images/shuang11-lq05.png')}}" alt="" />

        <span class="text" id="success">恭喜您兑换成功</span>
        <span class="text"  style="display:none;">你的积分不足</span>

        <span class="close" ></span>
        <a href="javascript:;" class="queding"></a>
        <a target="_blank" href="http://www.hezongyy.com/user/youhuiq" class="check"></a>


    </div>
</div>


<div class="zhongle11" >
    <div class="zhongjiang11">
        <img src="{{get_img_path('images/shuang11-lq05.png')}}" alt="" />

        <span class="text" id="success11">恭喜您兑换成功</span>
        <span class="text"  style="display:none;">你的积分不足</span>

        <span class="close" ></span>
        <a href="javascript:;" class="queding" cat_id="0"  onclick="cs($(this))" id="queding11"></a>
        <a target="_blank" href="http://www.hezongyy.com/user/youhuiq" class="check"></a>


    </div>
</div>

<div id="top" style='background: url("{{get_img_path('images/jfdh01.jpg')}}") no-repeat scroll center top;height: 300px;min-width: 1200px;overflow: hidden;width: 100%;'>
</div>
<div style='background: url("{{get_img_path('images/jfdh02.jpg')}}") no-repeat scroll center top;height: 252px;min-width: 1200px;overflow: hidden;width: 100%;'>

</div>
<div style='background: url("{{get_img_path('images/jfdh03.jpg')}}") no-repeat scroll center top;height: 188px;min-width: 1200px;overflow: hidden;width: 100%;'>
    <div class="guize-box" style="width:1200px;height:188px;margin:0 auto;position:relative;">
        <p style="width:250px;height:30px;line-height:30px;color:#f2e519;position:absolute;left:355px;top:112px;font-size:36px;overflow:hidden">{{$user->pay_points}}</p>


    </div>

</div>
<div  style='background: url("{{get_img_path('images/jfdh04.jpg')}}") no-repeat scroll center top;height: 451px;min-width: 1200px;overflow: hidden;width: 100%;'>
    <div class="lq-box" style="width:1200px;height:300px;margin:0 auto;position:relative;" >
        @foreach($cat_ids as $k=>$v)
            <a href="javascript:;"  class="yhq{{$k}}" @if($v->is_ks==0) cat_id="{{$v->cat_id}}" @else cat_id="{{$v->is_ks}}" @endif  onclick="ts($(this))" ></a>
        @endforeach

    </div>
</div>
@include('shuang11.daohang')
</body>
</html>
<script type="text/javascript">
    $(function(){


        $(".close").click(function(){
            $(this).parent().parent().hide();

        })

        $(".queding").click(function(){
            $(this).parent().parent().hide();

        })

        $(".check").click(function(){
            $(this).parent().parent().hide();

        })



    });
    function ts(obj){
        $('#success11').html('确认兑换吗?');
        $(".zhongle11").show();
        var cat_id = obj.attr('cat_id');
        $("#queding11").attr('cat_id',cat_id)
    }
    function cs(obj){
        var cat_id = obj.attr('cat_id');
        if(cat_id>0) {
            obj.attr('cat_id',0);
            $.ajax({
                headers: {

                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')

                },
                url: '/get_jf',
                type: 'post',
                data: {cat_id: cat_id},
                dataType: 'json',
                success: function (result) {
                    //if(result.id==1){
                    $('#success').html(result.msg);
                    $(".zhongle").show();
                    if(result.id==1){
                        obj.attr('cat_id',cat_id);
                    }
                }
            });
        }
        else if(cat_id==-1){
            $('#success').html('活动未开始!');
            $(".zhongle").show();
        }
        else if(cat_id==-2){
            $('#success').html('活动已结束!');
            $(".zhongle").show();
        }
        else{
            $('#success').html('积分不足!');
            $(".zhongle").show();
        }
    }
</script>