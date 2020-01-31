$(function () {


    //倒计时

	var times1 = $("#time-item1").attr("data-id");
	var times2 = $("#time-item2").attr("data-id");
	var times3 = $("#time-item3").attr("data-id");
	var times4 = $("#time-item4").attr("data-id");
	var times5 = $("#time-item5").attr("data-id");
    var end_time = parseInt($("#end_time").val());

	var intDiff1 = parseInt(times1); //倒计时总毫秒数量

    timer(intDiff1,1);

    var intDiff2 = parseInt(times2); //倒计时总毫秒数量
    timer(intDiff2,2);

    var intDiff3 = parseInt(times3); //倒计时总毫秒数量
    timer(intDiff3,3);

    var intDiff4 = parseInt(times4); //倒计时总毫秒数量
    timer(intDiff4,4);

    var intDiff5 = parseInt(times5); //倒计时总毫秒数量
    timer(intDiff5,5);

    go_end(end_time);




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
                clearInterval(daojs);
                change_btn(team);
            }

        }, 1000);

}


function go_end(intDiff){

    window.setInterval(function(){
        intDiff--;
        $("#end_time").val(intDiff)
    }, 1000);

}

function change_btn(team){
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
    timer(end_time,team);

}