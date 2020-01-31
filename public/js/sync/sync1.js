/**
 * Created by Administrator on 2017-09-18.
 */
$(function () {
    sync('sync/topleft', $('.top_left'), 1);
    sync('sync/fixright', $('#fixright'));
    sync('sync/tancc', $('#body'), 2);
    //	定时器
    var now;
    var start = $('#start').val();
    var end = $('#end').val();
    var time;
    var djs;

    function sync(url, obj, type) {
        $.ajax({
            url: url
            , type: 'get'
            , data: {id: 1}
            , dataType: 'json'
            , success: function (data) {
                if (type == 2) {
                    $(obj).append(data.view);
                } else {
                    $(obj).html(data.view);
                }
                $('.cart_number').text(data.cart_number);
                if (type == 1) {
                    now = data.now;
                    if (now < start) {
                        time = start - now;
                    }
                    else if (now >= start && now < end) {
                        time = end - now;
                        $('.dingshiqi .txt').text('距闭幕剩');
                    }
                    remaintime();
                    djs = window.setInterval(remaintime, 1000);
                }
            }
        });
    }

    function remaintime() {
        time--;
        now++;
        if (time <= -1) {
            time = 0;
            if (now >= start && now < end) {
                time = end - now;
                $('.dingshiqi .txt').text('距闭幕剩');
            } else if (now >= end) {
                clearInterval(djs);
            }
        }
        var second = Math.floor(time % 60); // 计算秒
        var minute = Math.floor((time / 60) % 60); //计算分
        var hourse = Math.floor(time / 3600); //计算小时
        $('.remaintime .hourse').html(hourse);
        $('.remaintime .minute').html(minute);
        $('.remaintime .second').html(second);
    }
});