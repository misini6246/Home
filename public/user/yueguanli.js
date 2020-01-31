$(function() {
	$('.yue li').click(function() {
		var tar = $(this).index();
		$(this).addClass('active').siblings('li').removeClass('active');
		var colors = $(this).css('background-color');
		$('.choose li:eq(' + tar + ')').addClass('active').siblings('li').removeClass('active')
		$('.choose li:eq(' + tar + ')').children('span').css('border-bottom','18px solid ' + colors + '');
		$('.choose').css('border-bottom', '2px solid ' + colors + '')
	})
	$('.right_title ul li').click(function(){
		$(this).addClass('active').siblings('li').removeClass('active');
		if($(this).index()==0){
			$('.wodeyue').show();
			$('.tixian').hide();
		}else{
			$('.wodeyue').hide();
			$('.tixian').show();
		}
	})
	
	
	
	$('.tixian input[type=text]').focus(function() {
		$(this).css({
			'boder': '1px solid #3ebb2b',
			'box-shadow': '0 0 4px rgba(62,187,43,0.6)'
		})
	})
	$('.tixian input[type=text]').blur(function() {
		$(this).css({
			'boder': '1px solid #ccc',
			'box-shadow': 'none'
		})
	})
})