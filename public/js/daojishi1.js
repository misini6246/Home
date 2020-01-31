$(function () {
    var sjs = 0;
    var url = './kc.xml?'+Math.random();
    var url = '/get_kc?'+Math.random();
    var now = 0;
    var end = 1478880000 + sjs;
    var time1 = 1478793600 + sjs;
    var time2 = 1478818800 + sjs;
    var time3 = 1478826000 + sjs;
    var time4 = 1478840400 + sjs;
    var time5 = 1478862000 + sjs;
    var now_check = 0;
    var now_check1 = 0;
    var team1 = 0;
    var team2 = 0;
    var team3 = 0;
    var team4 = 0;
    var team5 = 0;
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
            }
        },
        complete:function(x){
            now = parseInt(Date.parse(x.getResponseHeader("Date"))/1000);
            //now = parseInt(Date.parse(new Date())/1000);
            //now = now + 3600*8;
            if(now>time5)//七点以后固定显示最后一个
            {
                now_check = 5;
                team1 = team2 = team3 = team4 = team5 = end - now;
            }
            else if(now>time4)//
            {
                now_check = 4;
                team1 = team2 = team3 = team4 = end - now;
                team5 = time5 - now;
            }
            else if(now>time3)//
            {
                now_check = 3;
                team1 = team2 = team3 = end - now;
                team4 = time4 - now;
                team5 = time5 - now;
            }
            else if(now>time2)//
            {
                now_check = 2;
                team1 = team2 = end - now;
                team3 = time3 - now;
                team4 = time4 - now;
                team5 = time5 - now;
            }
            else
            {
                now_check = 1;
                team1 = end - now;
                team2 = time2 - now;
                team3 = time3 - now;
                team4 = time4 - now;
                team5 = time5 - now;
            }

            if(now>end)//活动结束
            {
                now_check1 = 2;
            }else if(now<time1)//活动未开始
            {
                now_check1 = 1;
                team1 = time1 - now;
            }else{
                now_check1 = 0;
            }

            $("#end_time").attr('now_check',now_check);
            $("#end_time").attr('now_check1',now_check1);
            $("#end_time").val(end-now);

            timer(team1,1);
            timer(team2,2);
            timer(team3,3);
            timer(team4,4);
            timer(team5,5);
            go_end(end-now);
            dingwei(now_check);
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
function timer(intDiff,team){

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


            $('#hour_show' + team).html('<s id="h"></s>' + hour);

            $('#minute_show' + team).html('<s></s>' + minute);

            $('#second_show' + team).html('<s></s>' + second);

            if(intDiff==0){//倒计时结束
                for(var i=1;i<=team;i++) {
                    clearInterval(daojs);
                    change_btn(i, true);
                }
            }

        }, 1000);

}


function go_end(intDiff){

    window.setInterval(function(){
        intDiff--;
        $("#end_time").val(intDiff)
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

function change_btn(team,flag){
    team = parseInt(team);
    var end_time = parseInt($("#end_time").val());
    var now_check = parseInt($("#end_time").attr('now_check'));
    var now_check1 = parseInt($("#end_time").attr('now_check1'));
    if(parseInt(now_check1)==1){//活动未开始
        now_check1 = 0;
        $("#end_time").attr('now_check1',now_check1);
        $("#team"+team).addClass('jinxing');
        $(".btn_wks"+team).hide();
        $(".btn_yks"+team).show();
        $(".text_wks"+team).hide();
        $(".text_yks"+team).show();
    }else if(parseInt(now_check1)==0){//活动已开始
        now_check = team;
        var old_check = team - 1;
        $("#end_time").attr('now_check',now_check);
        $("#team"+old_check).removeClass('jinxing').addClass('jinxing1');
        $("#team"+now_check).addClass('jinxing');
        $(".btn_wks"+now_check).hide();
        $(".btn_yks"+now_check).show();
        $(".text_wks"+now_check).hide();
        $(".text_yks"+now_check).show();

    }
    if(flag==true) {
        timer(end_time, team);
    }

}

function dingwei(team){
    team = parseInt(team);
    var now_check = parseInt($("#end_time").attr('now_check'));
    var now_check1 = parseInt($("#end_time").attr('now_check1'));
    if(parseInt(now_check1)==0){//活动已开始
        now_check = team;
        $("#team"+now_check).addClass('jinxing');
        $(".btn_wks"+now_check).hide();
        $(".btn_yks"+now_check).show();
        $(".text_wks"+now_check).hide();
        $(".text_yks"+now_check).show();
        if(now_check!=1) {
            $(".list-01").hide();
            $("#time-item1").hide();
            $(".list-0" + now_check).show();
            $("#time-item" + now_check).show();
        }
        for(var i=1;i<now_check;i++){
            $("#team"+i).removeClass('jinxing').addClass('jinxing1');
            $(".btn_wks"+i).hide();
            $(".btn_yks"+i).show();
            $(".text_wks"+i).hide();
            $(".text_yks"+i).show();
        }
    }
}