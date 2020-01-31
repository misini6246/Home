$(function () {
    imgscrool('#ban2', 10000);
    imgscrool('#ban3', 6000);
    imgscrool('#ban4', 6000);
    imgscrool('#ban5', 6000);
})
function imgscrool(obj, time) {
    var len = $(obj + " .banner .img li").clone().length;
    var moving = false;
    var width = $(obj + " .banner .img li").width();
    var i = 0;
    var clone = $(obj + " .banner .img li").first().clone();
    $(obj + " .banner .img").append(clone);
    var size = $(obj + " .banner .img li").size();
    for (var j = 0; j < size - 1; j++) {
        $(obj + "" + obj + " .num").append("<li></li>");
    }
    $("" + obj + " .num li").first().addClass("on");

    if ($(obj + "" + obj + " .num li")) {

        $(obj + "" + obj + " .num li").hover(function () {
            var index = $(this).index();
            i = index;
            $(obj + " .banner .img").stop().animate({
                left: -index * width
            }, 1000)
            $(this).addClass("on").siblings().removeClass("on")
        })
    }
    ;
    var t = setInterval(function () {
        i++;
        move();
    }, time)

    $(obj + " .banner").hover(function () {
        clearInterval(t);
    }, function () {
        t = setInterval(function () {
            i++;
            move();
        }, time)
    })
    $(obj + " .num").hover(function () {
        clearInterval(t);
    }, function () {
        t = setInterval(function () {
            i++;
            move();
        }, time)
    })

    if ($(obj + " .banner .btn_l")) {

        $(obj + " .banner .btn_l").stop(true).click(function () {
            if (moving) {
                return;
            }
            ;
            moving = true;
            i--
            move();
        })

        $(obj + " .banner .btn_r").stop(true).click(function () {
            if (moving) {
                return;
            }
            moving = true;
            i++
            move()
        })

    }
    ;

    function move() {

        if (i == size) {
            $(obj + " .banner  .img").css({
                left: 0
            })
            i = 1;
        }

        if (i == -1) {
            $(obj + " .banner .img").css({
                left: -(size - 1) * width
            })
            i = size - 2;
        }
        $(obj + "" + obj + " .img").stop(true).delay(200).animate({
            left: -i * width
        }, 1000, function () {
            moving = false;
        })

        if (i == size - 1) {
            $(obj + "" + obj + " .num li").eq(0).addClass("on").siblings().removeClass("on")
        } else {
            $(obj + "" + obj + " .num li").eq(i).addClass("on").siblings().removeClass("on")
        }
    }

    if (len == 1) {
        $(obj).find('.num').hide();
        clearInterval(t);
        $(obj + " .banner").hover(function () {
            clearInterval(t);
        }, function () {
            clearInterval(t);
        })
    }

}