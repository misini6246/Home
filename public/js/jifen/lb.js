$(function(){
	imgscrool('#ban2');
})
function imgscrool(obj) {
	var moving = false;
	var width = $(obj + " .banner .img li").width();
	var i = 0;
	var clone = $(obj + " .banner .img li").first().clone();
	$(obj + " .banner .img").append(clone);
	var size = $(obj + " .banner .img li").size();
	for(var j = 0; j < size - 1; j++) {
		$(obj + "#ban2 .num").append("<li>"+parseInt(j+1)+"</li>");
		
	}
	$("#ban2 .num li").first().addClass("on");

	if($(obj + "#ban2 .num li")) {
		$(obj + "#ban2 .num li").hover(function() {
			var index = $(this).index();
			i = index;
			$(obj + " .banner .img").stop().animate({
				left: -index * width
			}, 1000)
			$(this).addClass("on").siblings().removeClass("on")
		})
	};
	var t = setInterval(function() {
		i++;
		move();
	}, 6000)

	$(obj + " .banner").hover(function() {
		clearInterval(t);
	}, function() {
		t = setInterval(function() {
			i++;
			move();
		}, 6000)
	})
	$(obj + " .num").hover(function() {
		clearInterval(t);
	}, function() {
		t = setInterval(function() {
			i++;
			move();
		}, 6000)
	})

	if($(obj + " .banner .btn_l")) {

		$(obj + " .banner .btn_l").stop(true).click(function() {
			if(moving) {
				return;
			};
			moving = true;
			i--
			move();
		})

		$(obj + " .banner .btn_r").stop(true).click(function() {
			if(moving) {
				return;
			}
			moving = true;
			i++
			move()
		})

	};

	function move() {

		if(i == size) {
			$(obj + " .banner  .img").css({
				left: 0
			})
			i = 1;
		}

		if(i == -1) {
			$(obj + " .banner .img").css({
				left: -(size - 1) * width
			})
			i = size - 2;
		}
		$(obj + "#ban2 .img").stop(true).delay(200).animate({
			left: -i * width
		}, 1000, function() {
			moving = false;
		})

		if(i == size - 1) {
			$(obj + "#ban2 .num li").eq(0).addClass("on").siblings().removeClass("on")
		} else {
			$(obj + "#ban2 .num li").eq(i).addClass("on").siblings().removeClass("on")
		}
	}
}