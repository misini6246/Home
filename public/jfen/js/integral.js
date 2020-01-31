/**
 * Created by wang on 14-9-25.
 */
$(function(){
    $(".etc_class_list_msg a").click(function(){//加入礼品车
        var id=$(this).attr("data-id");//商品id
		var url = '/jf/addCart' ;
		var count = 1 ;
		var step = 'add_to_cart' ;
        $.ajax({
            headers: {

                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')

            },
			type: "post", 
			url: url,
			dataType: 'JSON' ,
			data: {
				id: id ,
				num : count ,
				step: step 
			},
			success: function(msg){
            if(msg.flag){
                show_addCart("商品已成功加入礼品车！",true, true, "去结算&nbsp;&gt;", function(){
                    window.location.href="/jf/cart";//点击结算跳转网址
                }, "继续购物",function(){
                    window.location.href="";//点击继续跳转网址
                });
            }else{
                show_addCart(msg.content,true, false);
            }
        }});
    });
});