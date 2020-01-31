/**
 * Created by wang on 14-9-21.
 */
$(function(){
    var give_us_msg_input=$(".give_us_msg input");
    give_us_msg_input.focusin(function(){
       $(this).next().fadeOut();
    });
    give_us_msg_input.focusout(function(){
        if($(this).val()=="") $(this).next().fadeIn();
    });

    $(".sub_order").click(function(){//点击提交订单
        showDialog("确认提交订单？",true,function(){
            wait_alert($("body"));
            //var id= new Array();
            //var number= new Array();//数量
            //var method= new Array();//运送方式
			var addid = $(".send_detail .to_where").attr('data-id') ;
            var message=$(".give_us_msg input").val();//留言
            //$(".list_in_car table tbody tr").each(function(n,e){
             //   id[n]=parseInt($(e).attr("data-id"));
             //   number[n]=parseInt($(e).find(".number p").text());
             //   method[n]=$(e).find(".select_choose span").attr("value");
            //});
            $('#message').val(message);
            $('#addressId').val(addid);
            $('#orderForm').submit();
//            $.ajax({
//                headers: {
//
//                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
//
//                },
//				type: "post",
//				url: "/jf/done",
//				dataType: 'JSON',
//				data: {
//					addid: addid,
//					//number: number,
//					step: 'addorder' ,
//					message: message
//				},
//					success: function(msg){
//                if(msg){
////                    do sth
//                    if(msg['flag']==false){
//                        location.href='/auth/login'
//                        return false;
//                    }
//                    window.location.href="flow.php?step=eorder";
//                    remove_wait("提交成功！",false);
//                }
//            }})
        })
    });

    $(".sure_order_real_d li:first").find(".to_where").css("padding-left","5px");
//  10-16
    $(".send_to_radio").live("mouseup",function(){//切换地址
        if($(this).filter(":checked").length==0){
            var code=$(this).parent().parent().html();
            var li=$(this).parent().parent().parent();
            $(".sure_order_real_d li").each(function(n,e){
                $(e).html("<div class='to_where' data-id="+$(e).find(".to_where").attr("data-id")+">"+$(e).find(".to_where").html()+"</div>");
                $(e).find(".address_icon").remove();
                $(e).find(".send_to_tips").remove();
                $(e).find("input").removeAttr("checked");
            });
            var html=""
                +"<div class='send_to clear_float'>"
                +"<div class='send_bg'></div>"
                +"<div class='send_detail'>"
                //+"<div class='change_this_address'><a href='javascript:;'>修改本地址</a><a href='javascript:;'>设为默认地址</a></div>"
                +"<div class='to_where' data-id='"+$(this).parent().parent().attr("data-id")+"'>"
                +"<img class='address_icon' src='/jfen/images/address_icon.png' alt=''/>"
                +"<span class='send_to_tips'>寄送至 </span>"+code
                +"</div></div></div>";

            li.html(html);
            li.find(".to_where").css("padding-left","10px");
            li.find(".send_to_radio").attr("checked","checked");
            $(".send_msg_to .address").text(  $(".send_to .address").text());
            $(".send_msg_to .user_name").text($(".send_to .user_name").text());
            $(".send_msg_to .phone_num").text($(".send_to .phone_num").text());
        }
    });

//    10-29
    $(".use_new_address").toggle(function(){
        $(".fill_msg").slideDown(200,function(){
            $(".select").css({marginLeft: "0"});
        });
    },function(){
        $(".fill_msg").slideUp(200,function(){
            $(".select").css({marginLeft: "auto"});
        });
    });
//    end

});
