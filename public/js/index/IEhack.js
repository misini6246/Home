$(function(){
	$('.site_content i.myicon').each(function(){
		var parent_height = $(this).parent().height();
		var _height = $(this).height();
		$(this).css({
			'top':(parent_height-_height)/2
		})
	})
})