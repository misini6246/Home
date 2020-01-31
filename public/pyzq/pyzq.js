$(function() {
	var isHas = false; //只看有货开关状态
	var total_page = $('.puyao_title_right .nu .total_page').html(); //总页数
	var cur_page = $('.puyao_title_right .nu .red').html(); //当前页数

	//layer
	$('.cpmc').hover(function() {
		$(this).find('.lazy_show').attr('src', $(this).find('.lazy_show').data('original'))
	});
	$("img.lazy").lazyload({
		effect: "fadeIn",
		threshold: 300,
		placeholder: "/pyzq/img/small.gif"
	});
	$('.layer_tips').hover(function() {
		var msg = $(this).data('msg');
		var id = $(this).attr('id');
		layer.tips(msg, '#' + id, {
			tips: [3, '#fff'],
			time: 0,
			id: 'layer_tips'
		});
	}, function() {
		layer.closeAll();
	});

	//点击更多
	$('.zhankai .more').click(function() {
		var li1height = $(this).parent().height();
		var ulheight = $(this).next().next().height();
		$(this).parent().css({
			'height': ulheight,
			'transition': 'all 0.2s linear'
		})
		$(this).hide();
		$(this).next().show()
	})
	$('.zhankai .more-1').click(function() {
		var li1height = $(this).parent().height();
		var ulheight = $(this).next().height();
		$(this).parent().css({
			'height': '45px',
			'transition': 'all 0.2s linear'
		})
		$(this).hide();
		$(this).siblings().show();
	})

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
            'color': '#0090D2',
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


    //排序
	$('.puyao_title_list li').click(function() {
		if($(this).index() != $('.puyao_title_list li').length - 1) {
			$(this).addClass("active").siblings().removeClass('active')
		}
		if($(this).index() == 1) { //人气
			if($(this).find('.z-a').css("display") == "none") {
				$(this).find('.z-a').css("display", "inline-block")
				$(this).find('.a-z').css("display", "none")
			} else {
				$(this).find('.a-z').css("display", "inline-block")
				$(this).find('.z-a').css("display", "none")
			}
		}

		if($(this).index() == 2) { //销量
			if($(this).find('.z-a').css("display") == "none") {
				$(this).find('.z-a').css("display", "inline-block")
				$(this).find('.a-z').css("display", "none")
			} else {
				$(this).find('.a-z').css("display", "inline-block")
				$(this).find('.z-a').css("display", "none")
			}
		}

		if($(this).index() == 3) { //价格
			if($(this).find('.z-a').css("display") == "none") {
				$(this).find('.z-a').css("display", "inline-block")
				$(this).find('.a-z').css("display", "none")
			} else {
				$(this).find('.a-z').css("display", "inline-block")
				$(this).find('.z-a').css("display", "none")
			}
		}
	})

	//只看有货
	$('.puyao_title_list img').click(function() {
		if(!isHas) {
			$(this).attr('src', "img/liebiao_title_btn.jpg")
		} else {
			$(this).attr('src', "img/liebiao_title_btn_1.jpg")
		}
		isHas = !isHas;
	})

	//翻页
	if(cur_page == 1) {
		$('.prev').attr('src', "/pyzq/img/puyao_left.jpg")
	} else {
		$('.prev').attr('src', "/pyzq/img/puyao_left_1.jpg")
	}
	if(cur_page == total_page) {
		$('.next').attr('src', "/pyzq/img/puyao_right_1.jpg")
	} else {
		$('.next').attr('src', "/pyzq/img/puyao_right.jpg")
	}

	//添加购物车
	function tocart() {
		alert("点击了添加购物车按钮")
	}
	//添加收藏
	function tocollect() {
		alert("点击了添加收藏按钮")
	}

})