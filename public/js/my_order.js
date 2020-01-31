$(function () {
    $("#search_box input[type=text]").focus(function () {
             $(this).val("");

    });

	$('.stat').hover(function () {
		var _id = $(this).parent().siblings(".nub").attr("data-id");

		//$(this).parent().append("<div class='wamp'></div>");

		$(this).append("<div class='wamp fn_clear'> <div class='ddgz-alert' style='position:absolute;width:400px;position:relative;min-height:80px;;margin-left:-150px;'> <div class='top_ico'></div> <p> <span>处理时间</span> <span>订单追踪信息</span> </p> </div></div>");

		$.ajax({
			url:$('#ddgz').attr('dd-url'),
			type:'get',
            async:false,
			data:{
				act:'ajax_order_status',
				order_ids:_id
			},
			//dataType:'json',
			success: function (result) {
				$('.wamp').append(result);
			}
		})
	}, function () {
		$('.wamp').remove();
	})
    $('.wamp').bind("hover",function(){

        $(this).show();
    });


});
