/* nav.js zhaokun 20150709 主要应用于首页右侧导航栏 */
$(document).ready(function(){
	$('.tbar-cart-item').hover(function (){ $(this).find('.p-del').show(); },function(){ $(this).find('.p-del').hide(); });
	$('.jth-item').hover(function (){ $(this).find('.add-cart-button').show(); },function(){ $(this).find('.add-cart-button').hide(); });
	$('.toolbar-tab').hover(function (){ $(this).find('.tab-text').addClass("tbar-tab-hover"); $(this).find('.footer-tab-text').addClass("tbar-tab-footer-hover"); $(this).addClass("tbar-tab-selected");},function(){ $(this).find('.tab-text').removeClass("tbar-tab-hover"); $(this).find('.footer-tab-text').removeClass("tbar-tab-footer-hover"); $(this).removeClass("tbar-tab-selected"); });

/*$('.toolbar-wrap').addClass('toolbar-open');*/


	$('#shopCart').click(function(){

		$('.toolbar-wrap').addClass('toolbar-open');

	})




	
});