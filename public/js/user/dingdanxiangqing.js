$(function() {
	$('.true').children().bind('click', function() {
			change('.zhankai')
	})

	function change(obj) {
		if($(obj).hasClass('true')) {
			$.ajax({
				type: "get",
				url: "",
				async: true,
				success: function() {
					alert(1)
				}
			});
			$(obj).addClass('false');
			$(obj).removeClass('true');	
			$('.false').children('span').html("收起商品信息");
			$('.false').children('img').attr('src', 'img/shouqi.png');
		} else if($(obj).hasClass('false')){
			$.ajax({
				type: "get",
				url: "",
				async: true,
				success: function() {
					alert(2)
				}
			});
			$(obj).addClass('true');
			$(obj).removeClass('false');
			$('.true').children('span').html("展开余下<span>100</span>个商品");
			$('.true').children('img').attr('src', 'img/zhankai.png');
		}
	}
})