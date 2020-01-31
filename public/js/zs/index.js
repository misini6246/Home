$(function(){
	var index;
	$('.menu_list li').hover(function(){
		index = $(this).index()
		$(this).addClass('active');
		$(this).prev().find('.text').css('border-bottom','none')
	},function(){
		console.log(index)
		$(this).removeClass('active');
		$(this).prev().find('.text').css('border-bottom','1px dashed #b2d1c1')
	})
})