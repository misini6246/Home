$(function () {
    var url = '/get_kc?'+Math.random();
    $.ajax({
        url:url,
        type:'get',
        async:false,
        cache:false,
        success:function(msg){
            //$(msg).find("goods").each(function(i){
            //    var kc=parseInt($(this).attr("kc"));
            //    var id=parseInt($(this).attr("id"));
            //    $('#kc'+id).html('库存：'+kc);
            //});
            for(var i=0;i<msg.length;i++){
                $('#kc'+msg[i].id).html('库存：'+msg[i].kc);
                if(msg[i].kc==0){//库存为零
                    $('.yqg'+msg[i].id).show();
                    $(".pt_btn"+msg[i].id).hide();
                    $(".yqg_btn"+msg[i].id).show();
                }else{
                    $('.yqg'+msg[i].id).hide();
                    $(".pt_btn"+msg[i].id).show();
                    $(".yqg_btn"+msg[i].id).hide();
                }
            }
        },
        complete:function(x){
            var now = parseInt(Date.parse(x.getResponseHeader("Date"))/1000);
            //now = parseInt(Date.parse(new Date())/1000);
            //now = now + 3600*8;
            var now_check = 0;
            var count = 0;
            var end_type = 0;
            $('.nav ul li').each(function(){
                var start = parseInt($(this).attr('start'));
                var end = parseInt($(this).attr('end'));
                var index = parseInt($(this).index());
                index++;
                if(now>=start&&now<=end){//进行中
                    now_check = index
                }else if(now>end){//已结束
                    now_check = -1;
                    end_type = index;
                }else{
                    now_check = 0;
                }
                timer(start-now,index,0);
                timer(end-now,index,1);
                timer(0,index,2);
                count++;
            });
            if(now_check==-1){
                dingwei(count+1,count,end_type);
            }else {
                dingwei(now_check,count,end_type);
            }
            //tbkc();
        }
    });


    $(".right_ico").click(function(){


        var val= $(this).prev().attr("value");
        val= parseInt(val);
        val+=1;
        $(this).prev().attr("value",val);

       var kuncun=parseInt($(this).parents(".li-box").find(".kucun").html());

        if(val>kuncun){
            alert("111");
        }


    });


    $(".left_ico").click(function(){


        var val= $(this).next().attr("value");
        val= parseInt(val);
        val-=1;
        $(this).next().attr("value",val);

        var kuncun=parseInt($(this).parents(".li-box").find(".kucun").html());

        if(val>kuncun){
            alert("111");
        }if(val<=0){

            $(this).next().attr("value",1);
        }


    })





});

// 倒计时调用方法
function timer(intDiff,team,status){

        var daojs = window.setInterval(function () {

            var day = 0,

                hour = 0,

                minute = 0,

                second = 0;//时间默认值
            intDiff--;
            if (intDiff >= 0) {

                hour = Math.floor(intDiff / (60 * 60)) - (day * 24);

                minute = Math.floor(intDiff / 60) - (day * 24 * 60) - (hour * 60);

                second = Math.floor(intDiff) - (day * 24 * 60 * 60) - (hour * 60 * 60) - (minute * 60);

            }

            if (minute <= 9) minute = '0' + minute;

            if (second <= 9) second = '0' + second;


            $('#hour_show' + team+status).html('<s id="h"></s>' + hour);

            $('#minute_show' + team+status).html('<s></s>' + minute);

            $('#second_show' + team+status).html('<s></s>' + second);

            if(intDiff==0){//倒计时结束
                clearInterval(daojs);
                $("#time-item"+team+status).hide();
                $(".btn"+team+status).hide();
                if(status==0){
                    $("#time-item"+team+'1').show();
                    $(".btn"+team+'1').show();
                    $("#team"+team).removeClass('miaoshao-wks').removeClass('miaoshao-yjs').addClass('miaoshao-jx');
                }else if(status==1){
                    $("#time-item"+team+'2').show();
                    $(".btn"+team+'2').show();
                    $("#team"+team).removeClass('miaoshao-wks').removeClass('miaoshao-jx').addClass('miaoshao-yjs');
                }
            }

        }, 1000);

}



// 倒计时调用方法
function tbkc(){

    var kc = window.setInterval(function () {
        var url = './kc.xml';
        $.ajax({
            url: url,
            type: 'get',
            success: function (msg) {
                $(msg).find("goods").each(function (i) {
                    var kc = parseInt($(this).attr("kc"));
                    var id = parseInt($(this).attr("id"));
                    $('#kc' + id).html('库存：' + kc);
                });
            }
        });
    },10000);

}

function dingwei(team,count,end_type){
    team = parseInt(team);
    if(team>=1){//活动已开始
        $("#team"+team).removeClass('miaoshao-wks').removeClass('miaoshao-wxz').removeClass('miaoshao-yjs').addClass('miaoshao-jx').addClass('miaoshao-xz');
        $(".btn"+team+'0').hide();
        $(".btn"+team+'2').hide();
        $(".btn"+team+'1').show();
        $("#time-item"+team+'1').show();
        $("#time-item"+team+'2').hide();
        $("#time-item"+team+'0').hide();
        if(team!=1&&team==count) {
            $(".list-01").hide();
            $("#time-box1").hide();
            $(".list-0" + team).show();
            $("#time-box" + team).show();
        }
        for(var i=1;i<team;i++){
            $("#team"+i).removeClass('miaoshao-wks').removeClass('miaoshao-jx').removeClass('miaoshao-xz').addClass('miaoshao-yjs').addClass('miaoshao-wxz');
            $(".btn"+i+'0').hide();
            $(".btn"+i+'1').hide();
            $(".btn"+i+'2').show();
            $("#time-item"+i+'1').hide();
            $("#time-item"+i+'2').show();
            $("#time-item"+i+'0').hide();
        }
    }else if(end_type>0){
        end_type++;
        $("#team"+end_type).removeClass('miaoshao-yks').removeClass('miaoshao-yjs').removeClass('miaoshao-wxz').addClass('miaoshao-wks').addClass('miaoshao-xz');
        $(".btn"+end_type+'0').show();
        $(".btn"+end_type+'2').hide();
        $(".btn"+end_type+'1').hide();
        $("#time-item"+end_type+'1').hide();
        $("#time-item"+end_type+'2').hide();
        $("#time-item"+end_type+'0').show();
        $(".list-01").hide();
        $("#time-box1").hide();
        $(".list-0" + end_type).show();
        $("#time-box" + end_type).show();

        for(var i=1;i<end_type;i++){
            $("#team"+i).removeClass('miaoshao-wks').removeClass('miaoshao-jx').removeClass('miaoshao-xz').addClass('miaoshao-yjs').addClass('miaoshao-wxz');
            $(".btn"+i+'0').hide();
            $(".btn"+i+'1').hide();
            $(".btn"+i+'2').show();
            $("#time-item"+i+'1').hide();
            $("#time-item"+i+'2').show();
            $("#time-item"+i+'0').hide();
        }
    }
}