<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="Keywords" content=""/>
    <meta name="Description" content=""/>
    @include('layout.token')
    <title>合纵医药电子商务采购平台-药易购</title>

    <script type="text/javascript" src="{{path('js/jquery.min.js')}}"></script>
    @include('common.tanchu_attr')
    <style type="">
        .left0 {
            left: 160px;
        }

        .left1 {
            left: 560px;
        }

        .left2 {
            left: 75px;
        }

        .left3 {
            left: 480px;
        }

        #wxts {
            position: fixed;
            top: 50%;
            left: 50%;
            margin: -75px 0 0 -210px;
            background: url("{{get_img_path('images/tip_kuang.png')}}") no-repeat;
            width: 400px;
            height: 120px;
            z-index: 9999;
            padding: 10px;
            display: none;
        }

        .wxts {
            color: #ff5d5b;
            /* position: absolute; */
            left: 14px;
            top: 57px;
            width: 350px;
            overflow: hidden;
            line-height: 21px;
            font-size: 14px;
        }
    </style>

</head>
<body id="body" style="padding: 0;margin: 0;padding-bottom:0px;">
<div style='background: url("{{get_img_path('images/baotuan01.jpg')}}") no-repeat scroll center top;height: 400px;min-width: 1200px;overflow: hidden;width: 100%;'>
</div>

<div style='background: url("{{get_img_path('images/baotuan02.jpg')}}") no-repeat scroll center top;height: 290px;min-width: 1200px;overflow: hidden;width: 100%;'>
</div>
<div style='background: url("{{get_img_path('images/baotuan03.jpg')}}") no-repeat scroll center top;min-width: 1200px;overflow: hidden;width: 100%;'>
    <div class="main-box"
         style="width:990px;margin:30px auto 0 auto;background-color:#fbe0e7;padding:10px 0 60px 0;opacity:0.8;">

        <div class="title-box" style="width:560px;height:100px;margin:0px auto 60px auto;"><img
                    src="{{get_img_path('images/baotuan04.png')}}" alt=""/></div>
        @foreach($groups as $k=>$group)
            @if($is_bt==0)
                <div id="group_{{$group->gid}}" class="loft0{{$k+1}} groups"
                     style="width:770px;height:302px;margin:0px auto 60px auto;position:relative;">
                    <img src="{{$group->img}}" alt=""/>
                    <p class="{{$group->class}}" style="font-size:16px;color:#333333;position:absolute;top:63px;"><span
                                style="font-size:30px;color:#f51510;">{{(intval($group->total))}}</span>元</p>
                    <p class="{{$group->class}}"
                       style="font-size:16px;color:#333333;position:absolute;top:108px;"><span class="count"
                                                                                               style="font-size:30px;color:#f51510;">{{$group->count}}</span>人
                    </p>
                    <p class="{{$group->class}}"
                       style="font-size:16px;color:#333333;position:absolute;top:153px;"><span class="amount"
                                                                                               style="font-size:30px;color:#f51510;">{{($group->je)}}</span>元
                    </p>
                    <a class="{{$group->class1}} wbt" href="javascript:;" onclick="show_wxts($(this))"
                       gid="{{$group->gid}}"
                       count="{{$group->count}}" total="{{$group->total}}" consume="{{$group->consume}}"
                       style="width:200px;height:40px;border-radius:30px;line-height:40px;text-align:center;font-size:16px;color:#f2ffc1;position:absolute;top:215px;background-color:#f03659;text-decoration:none;">报名参加该团</a>
                    <a class="{{$group->class1}} ybt" href="javascript:;"
                       style="width:200px;height:40px;border-radius:30px;line-height:40px;text-align:center;font-size:16px;color:#f2ffc1;position:absolute;top:215px;background-color:#ae0d2b;text-decoration:none;display: none;">已报名参加该团</a>

                </div>
            @elseif($is_bt==$group->gid)
                <div class="loft0{{$k+1}}"
                     style="width:770px;height:302px;margin:0px auto 60px auto;position:relative;">
                    <img src="{{$group->img}}" alt=""/>
                    <p class="{{$group->class}}" style="font-size:16px;color:#333333;position:absolute;top:63px;"><span
                                style="font-size:30px;color:#f51510;">{{intval($group->total)}}</span>元</p>
                    <p class="{{$group->class}}" style="font-size:16px;color:#333333;position:absolute;top:108px;"><span
                                style="font-size:30px;color:#f51510;">{{$group->count}}</span>人</p>
                    <p class="{{$group->class}}" style="font-size:16px;color:#333333;position:absolute;top:153px;"><span
                                style="font-size:30px;color:#f51510;">{{($group->je)}}</span>元</p>
                    <a class="{{$group->class1}}" href="javascript:;"
                       style="width:200px;height:40px;border-radius:30px;line-height:40px;text-align:center;font-size:16px;color:#f2ffc1;position:absolute;top:215px;background-color:#ae0d2b;text-decoration:none;">已报名参加该团</a>
                </div>
            @endif
        @endforeach
    </div>
</div>


<div id="wxts" id="shopping_box">
    <div class="content_buy"><a href="javascript:;"></a>
        <h4 class="tip_text" style="padding-top: 0;height: 24px;">温馨提示</h4>
        <div class="wxts" alt="" title="" style="">
            1、每位会员只能参与一个团；参团后不可进行修改；
        </div>
        <div class="wxts" alt="" title="">
            2、该团于2.14-2.15特价活动消费满<span id="wxts_je">2000</span>元才可获得瓜分资格；
        </div>

        <p class="login_p tab_p4">
            <a id="sure" href="{{$show1_url3 or 'javascript:;'}}" class="login_a confirm again">确定参加</a>
        </p>
        <span class="close2"></span>
    </div>
</div>
<script>
    $(function () {
        $('.close2').click(function () {
            $('.tanchuc').hide();
        });
    });

</script>


</body>
<script type="text/javascript">
    $(function () {
        $('.close2').click(function () {
            $('#wxts').hide();
        });
    });
    function show_wxts(obj) {
        var consume = parseInt(obj.attr('consume'));
        $('#wxts_je').text(consume);
        $('#sure').off('click');
        $('#sure').on('click', function () {
            $('#wxts').hide();
            bt(obj);
        });
        $('#wxts').show();
    }
    function bt(obj) {
        var gid = obj.attr('gid');
        $.ajax({
            headers: {

                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')

            },
            url: '/bt/bt',
            type: 'post',
            async: false,
            data: {gid: gid},
            //dataType: 'json',
            success: function (result) {
                if (result.error == 1) {
                    add_tanchuc(result.msg);
                } else {
                    add_tanchuc(result.msg);
                    var count = parseInt(obj.attr('count'));
                    var total = parseInt(obj.attr('total'));
                    count++;
                    var amount = parseFloat(total / count).toFixed(2);
                    console.log(count, total, amount);
                    $('#group_' + gid + ' .amount').html(amount);
                    $('#group_' + gid + ' .count').html(count);
                    $('.groups').hide();
                    $('.wbt').hide();
                    $('.ybt').show();
                    $('#group_' + gid).show();
                }
            }
        });
    }
</script>
</html>
