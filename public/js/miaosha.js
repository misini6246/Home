/**
 * Created by Administrator on 2016/12/7.
 */
(function($){
    var methods = {
        dingwei:function(team){
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
        },
        change_btn:function(team,flag){
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

        },
        tbkc:function(){

            var kc = window.setInterval(function () {
                var url = './kc.xml';
                $.ajax({
                    url: url,
                    type: 'get',
                    success: function (msg) {
                        $(msg).find("xiangqing").each(function (i) {
                            var kc = parseInt($(this).attr("kc"));
                            var id = parseInt($(this).attr("id"));
                            $('#kc' + id).html('库存：' + kc);
                        });
                    }
                });
            },10000);

        }
    };
    $.fn.miaosha = function(method){
        var defaults = {

        }
    };
    var options = $.extend(defaults,options);
    this.each(function(){

    });
})(jQuery);