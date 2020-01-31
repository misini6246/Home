<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="baidu-site-verification" content="qUlVl7Atu0" />
    <meta name="Keywords" content="药品价格,药品销售,采购药品,药品查询,网上药品批发,四川药品批发，药物目录,OTC,医药公司,医院,药店,药品说明书,适应症，药厂，制药" />
    <meta name="Description" content="【合纵医药网&mdash;药易购】是四川合纵医药有限责任公司旗下国家药监局批准的正规药品采购、批发、销售网上药品交易电子商务平台（药易购），主要经营普药、OTC高毛利、医疗器械、中药饮片；300人的团队为您的采购和销售，保驾护航，为您提供最有价值的医药服务；平台保证您的货款安全和药品质量，服务热线：400-6028-262,网址：www.hezongyy.com" />
    @include('layout.token')
    <title>【合纵医药网&mdash;药易购】幸运抽奖</title>


    <link href="{{path('css/base.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('css/choujiang.css')}}" rel="stylesheet" type="text/css" />

    <script type="text/javascript" src="{{path('js/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{path('js/awardRotate.js')}}"></script>
    <script type="text/javascript">
        $(function (){

            var rotateTimeOut = function (){
                $('#rotate').rotate({
                    angle:0,
                    animateTo:2160,
                    duration:8000,
                    callback:function (){
                        alert('网络超时，请检查您的网络设置！');
                    }
                });
            };
            var bRotate = false;

            var rotateFn = function (awards, angles, txt){
                bRotate = !bRotate;
                $('#rotate').stopRotate();
                $('#rotate').rotate({
                    angle:0,
                    animateTo:angles+1800,
                    duration:8000,
                    callback:function (){
                        showMask();
                        if(txt!='谢谢参与') {
                            showMsg(txt,'再抽一次');
                        }else{
                            showMsg('很遗憾,未抽中','再抽一次');
                        }

                        bRotate = !bRotate;
                        $('#status').val(1);
                        var cj_points = parseInt($("#cj_points").html());
                        var cj_count = parseInt($("#cj_count").html());
                        $("#cj_points").html(cj_points-5000);
                        $("#cj_count").html(cj_count-1);
                    }
                })
            };

            $('.pointer').click(function ab(){
                var status = parseInt($('#status').val());
                if(status==1) {
                    $('#status').val(2);
                    $('.zailai').bind('click',function tip() {
                        $.ajax({
                            headers: {

                                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')

                            },
                            url: '/get_cj',
                            type: 'post',
                            data:{id:1},
                            dataType: 'json',
                            success: function (result) {
                                $('.zailai').unbind('click');
                                var btn1 = '确定';
                                if (result.id == -1) {
                                    showMsg(result.msg,btn1);
                                    $('#status').val(-1);
                                    return false;
                                }else if(result.id == -2){
                                    showMsg(result.msg,btn1);
                                    $('#status').val(-2);
                                    return false;
                                }else if(result.id == -3){
                                    showMsg(result.msg,btn1);
                                    $('#status').val(-3);
                                    return false;
                                }else if(result.id == -4){
                                    showMsg(result.msg,btn1);
                                    $('#status').val(-4);
                                    return false;
                                }else if(result.id == -5){
                                    showMsg(result.msg,btn1);
                                    $('#status').val(-5);
                                    return false;
                                }else{
                                    btn1 = '再抽一次';
                                }
                                //if(bRotate)return;
                                //var item = rnd(1,7);
                                rotateFn(result.id, result.jiaodu, result.msg);
                                //console.log(result);
                            }
                        });
                    });
                    showMsg('消耗5000积分抽一次','确定');
                    return false;

                }else if(status==-1){
                    showMsg('活动已结束','确定');
                }else if(status==-2){
                    showMsg('活动未开始','确定');
                }else if(status==-3){
                    showMsg('积分不足','确定');
                }else if(status==-4){
                    showMsg('只限终端参与','确定');
                }else if(status==-5){
                    showMsg('抽奖次数已用完','确定');
                }
            });

            setInterval('autoScroll(".maquee")',3000);

            $(".close").click(function(){

                $(this).parent().parent().hide();
                hideMask();

            })
            $(".zailai").click(function(){

                $(this).parent().parent().hide();
                hideMask();

            })


        });
        function rnd(n, m){
            return Math.floor(Math.random()*(m-n+1)+n)
        }

        function autoScroll(obj){
            $(obj).find("ul").animate({
                marginTop : "-39px"
            },500,function(){
                $(this).css({marginTop : "0px"}).find("li:first").appendTo(this);
            })
        }

        function showMsg(msg,btn1){
            $(".jp").html(msg);
            $(".zailai").html(btn1);
            $(".zhongle").show();
            $('.zailai').bind('click',function () {
                $(this).parent().parent().hide();
                hideMask();
            })
        }


        function showZj(txt){
            $(".jp").html(txt);
            $(".zhongle").show();
        }

        function showMz(){

            $(".meizhong").show();
        }

        function showJf(){

            $(".jfbg").show();
        }

        function showWks(){

            $(".weiks").show();
        }

        function showYjs(){

            $("#cj_ks").hide();
            $("#cj_js").show();
            $(".yjs").show();
        }

        //兼容火狐、IE8
        //显示遮罩层
        function showMask(){
            $("#mask").css("height",$(document).height());
            $("#mask").css("width",$(document).width());
            $("#mask").show();
        }
        //隐藏遮罩层
        function hideMask(){

            $("#mask").hide();
        }



    </script>





</head>
<body style="background-color:#fff9ef;position:relative;">
<input type="hidden" id="status" value="1"/>
<div id="mask" class="mask"></div>
<div class="zhongle" >
    <div class="zhongjiang">
        <img src="{{get_img_path('images/tanchuang01.png')}}" alt="" />
        <span class="close"><img src="{{get_img_path('images/choujiang-close.png')}}" alt="" /></span>
        <a href="javascript:;" class="zailai">再抽一次</a>
        <a target="_blank" href="{{route('user.youhuiq')}}" class="check">查看中奖纪录</a>
        <span class="jp">抽中就的角度讲奖品</span>

    </div>
</div>






<div class="top" style="background: url('{{get_img_path('images/choujiang_01.jpg')}}') no-repeat scroll center top;height: 530px;min-width: 1200px;overflow: hidden;width: 100%;"></div>

<div class="main-wrap">
    <div class="main-box">
        <div class="user-msg">
            <span style="font-size:18px;color:#333333;"> 亲爱的：</span><span style="font-size:18px;color:#d80541;font-weight:bolder;padding-right:50px;">{{$user->user_name}}</span>
            <span style="font-size:18px;color:#333333;"> 您目前积分为：</span><span style="font-size:18px;color:#d80541;font-weight:bolder;padding-right:50px;" id="cj_points">{{$user->pay_points}}</span><span style="font-size:18px;color:#333333;"> 您还有 <span style="font-size:18px;color:#d80541;font-weight:bolder;" id="cj_count">{{$count or 0}}</span> 次抽奖机会</span> <span style="font-size:14px;color:#d80541;">(每次抽奖将消耗5000积分)</span>


        </div>
        <div class="zhuanpan fn_clear" >
            <div class="turntable-bg">

                <div class="pointer"><img src="{{get_img_path('images/pointer.png')}}" alt="pointer"/></div>
                <div class="rotate" ><img id="rotate" src="{{get_img_path('images/turntable.png')}}" alt="turntable"/></div>
            </div>
            <div class="mingdan">


                <img src="{{get_img_path('images/tz.jpg')}}" alt="" />






            </div>



        </div>




    </div>




</div>







</body>
