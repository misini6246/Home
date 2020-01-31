$(function () {
    $('.zhankai .more').click(function () {
        var li1height = $(this).parent().height();
        var ulheight = $(this).next().next().height();
        $(this).parent().css({
            'height': ulheight,
            'transition': 'all 0.2s linear'
        })
        $(this).hide();
        $(this).next().show()
    })
    $('.zhankai .more-1').click(function () {
        var li1height = $(this).parent().height();
        var ulheight = $(this).next().height();
        $(this).parent().css({
            'height': '45px',
            'transition': 'all 0.2s linear'
        })
        $(this).hide();
        $(this).siblings().show();
    })


//  console.log($('.shaixuan-yongtu').css())
    //点击获取筛选


    //医药公司名字点击筛选
    $('.sx-li3 .zimu li .shaixuan-company-box p').click(function () {
        var gongsi = $(this).html()
        $('.company-name').html(gongsi);
        $('.sx-li3').hide();
        $('.company-name-box').css('display', 'inline-block');
    })

    //筛选以后的再次点击选择

    //重置筛选
    $('.container-topimg').click(function () {
        $('.sx-li1').show();
        $('.sx-li2').show();
        $('.sx-li3').show();
        $('.shaixuan-jixing').css('display', 'none');
        $('.shaixuan-yongtu').css('display', 'none')
        $('.shaixuan-qingchu').css('display', 'none');
        $('.company-name-box').css('display', 'none');
    })
    $('.shaixuan-qingchu').click(function () {
        $('.sx-li1').show();
        $('.sx-li2').show();
        $('.sx-li3').show();
        $('.shaixuan-jixing').css('display', 'none');
        $('.shaixuan-yongtu').css('display', 'none');
        $('.shaixuan-qingchu').css('display', 'none');
        $('.company-name-box').css('display', 'none');
    })

    //字母筛选医药公司的宽度获取


    //字母点击获取生产厂家
    $('.xuanzhe').click(function () {
        $('.shaixuan-company-box').hide();
        $('.zimu li').css({
            'color': '#333333',
            'font-weight': '100',
            'border': '1px solid transparent'
        });
        var zm = $(this).attr('id');
        $('#zm' + zm).show();
        $(this).css({
            'color': '#3cbc2b',
            'font-weight': 'bold',
            'border': '1px solid #e5e5e5',
            'border-bottom': '1px solid white'
        })
    })
    $('.company-del').click(function () {
        $('.sx-li3').show();
        $('.company-name-box').hide();
        $('.shaixuan-company-box').hide();
        $('.zimu li').css({
            'color': '#333333',
            'font-weight': '100',
            'border': '1px solid transparent'
        })
    })


//	排序点击样式改变
// 	$('.content-chanpin-title ul li').click(function(){
// 		$('.content-chanpin-title ul li').removeClass('on');
// 		$('.content-chanpin-title ul li i:first-child+i').hide();
// 		$('.content-chanpin-title ul li i:first-child').show();
// 		$(this).addClass('on');
// 		$(this).children('i:first-child').hide();
// 		$(this).children('i:first-child+i').show();
// 	})

//	大图与列表之间的切换
// 	$('.fonts-datu').parent().click(function(){
// 		$('.fonts-datu').show();
// 		$('.fonts-datu-hui').hide();
// 		$('.fonts-liebiao').hide();
// 		$('.fonts-liebiao-hui').show();
// 		$('.datu').show();
// 		$('.liebiao').hide();
// 	})
// 	$('.fonts-liebiao').parent().click(function(){
// 		$('.fonts-datu').hide();
// 		$('.fonts-datu-hui').show();
// 		$('.fonts-liebiao').show();
// 		$('.fonts-liebiao-hui').hide();
// 		$('.datu').hide();
// 		$('.liebiao').show();
// 	})

//	左侧排名鼠标悬停显示图片
    $('.paihang-bottom ul li').hover(function () {
        $('.paihang-bottom ul li').css('height', '32px');
        $('.paihang-bottom ul li span:first-child').css({
            'border': '1px solid #bbb',
            'color': '#666666'
        });
        $('.paihang-bottom ul li').children('.hover-before').show();
        $('.paihang-bottom ul li').children('.hover-after').hide();
        $(this).css('height', '68px');
        $(this).children('.hover-before').hide();
        $(this).children('.hover-after').show();
        $(this).children('span:first-child').css({
            'border': '1px solid #e70000',
            'color': '#e70000'
        })
    })
    $('.datu-chanpin .manjian').hover(function () {
        $(this).parents('.datu-chanpin').find('.datu-tcc').show();
    }, function () {
        $(this).parents('.datu-chanpin').find('.datu-tcc').hide();
    });
//	搜索纠正
    $('.jiuzheng-del').click(function () {
        $('.jiuzheng').hide()
    })

    //	hover设置宽度
    $('.cxbs span').hover(function () {
        var len = $(this).children('.bs_tishi').text().length;
        var wid = len * 12;
        $(this).children('.bs_tishi').width(wid);
    })
})

function imgscrool(obj) {
    var moving = false;
    var width = $(obj + " .banner .img li").width();
    var i = 0;
    var clone = $(obj + " .banner .img li").first().clone();
    $(obj + " .banner .img").append(clone);
    var size = $(obj + " .banner .img li").size();
    for (var j = 0; j < size - 1; j++) {
        $(obj + "#ban2 .num").append("<li></li>");
    }
    $("#ban2 .num li").first().addClass("on");

    if ($(obj + "#ban2 .num li")) {

        $(obj + "#ban2 .num li").hover(function () {
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
    }, 5000)

    $(obj + " .banner").hover(function () {
        clearInterval(t);
    }, function () {
        t = setInterval(function () {
            i++;
            move();
        }, 5000)
    })
    $(obj + " .num").hover(function () {
        clearInterval(t);
    }, function () {
        t = setInterval(function () {
            i++;
            move();
        }, 5000)
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
        $(obj + "#ban2 .img").stop(true).delay(200).animate({
            left: -i * width
        }, 1000, function () {
            moving = false;
        })

        if (i == size - 1) {
            $(obj + "#ban2 .num li").eq(0).addClass("on").siblings().removeClass("on")
        } else {
            $(obj + "#ban2 .num li").eq(i).addClass("on").siblings().removeClass("on")
        }
    }
}