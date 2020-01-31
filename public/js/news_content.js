/**
 * Created by wang on 14-9-10.
 */
$(function(){
    $(".user_left_wt_title").click(function(event){
        $(this).find(".user_left_open").toggleClass("change_bg");
        $(this).parent().next(".user_left_wt_conDiv").slideToggle(200);
		event.stopPropagation() ;
    });
});
