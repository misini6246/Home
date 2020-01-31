/**
 * Created by wang on 14-8-29.
 */
$(function(){

    $(".exchange_num input").focusout(function(){
        if(!(/^[0-9]+$/.test($(this).val())||/^[0]$/.test($(this).val()))){
            $(this).val(1);
        }
    });
    $(".exchange_num .add1").click(function(){//点击数量加1
        var val=parseInt($(this).prev("input").val());
        $(this).prev("input").val(val+1);
    });
    $(".exchange_num .del1").click(function(){//点击数量减1
        var val=parseInt($(this).next("input").val());
        if(val>1){
            $(this).next("input").val(val-1);
        }
    });

    $(".page_nav").hover(function(){$(".page_nav_detail").fadeIn(300);},function(){$(".page_nav_detail").fadeOut(300);});
    $(".egd_nav ul:not(.pagination ul)").find("li").click(function(){
        var egd_msg_diff=$(".egd_msg_diff");
        var index=$(this).index();
        $(".nav_white_strip").css({left: 121*(index)+"px"});
        $(".nav_strip").css({left: 121*(index)-1+"px"});
        $(this).siblings().find("p").css({borderRight: "1px solid #707070"});
        $(this).siblings().css({borderRight: "0",width: "121px"});
        $(this).parent().children().eq(2).find("p").css({borderRight: "0"});
        if($(this).prev()){
            $(this).prev().find("p").css({borderRight: "0"});
            $(this).prev().css({borderRight: "1px solid #e8e8e8",width: "120px"});
        }
        $(this).find("p").css({borderRight: "0"});
        $(this).css({borderRight: "1px solid #e8e8e8",width: "120px"});
        $(this).siblings().removeClass("bg_c");
        $(this).addClass("bg_c");
        if(index==2){
            $(this).css({borderRight: "1px solid #f4f4f4"});
        }
        egd_msg_diff.children("div").fadeOut(0);
        egd_msg_diff.children("div").eq(index).fadeIn(300);
        return false;
    });
    $(".etc_class_list_img a img").hover(function(){
        $(this).animate({marginTop: "-5px"},100);
    },function(){
        $(this).animate({marginTop: "0"},100);
    });

    $(".add_to_cart").click(function(){//加入礼品车
        var id = $(this).attr("data-id");//商品id
        var count = parseInt($(".exchange_num").eq(0).find("input").val());//商品数量
		var url = '/jf/addCart' ;
		var step = 'add_to_cart' ;
        $.ajax({
            headers: {

                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')

            },
			type: "POST" , 
			url: url ,
			dataType: 'JSON' ,
			data: {
				id : id ,
				num : count ,
				step : step 
			} ,
			success: function(msg){
				if(msg.flag){
					show_addCart("商品已成功加入礼品车！",true, true, "去结算&nbsp;&gt;", function(){
						window.location.href="/jf/cart";//点击结算跳转网址
					}, "继续购物",function(){
						window.location.href="";//点击继续跳转网址
					});
				}else{
					show_addCart(msg.content, true, false);
				}
			}
        });
    });
    $(".direct_pay").click(function(){//加入礼品车
        var id=$(this).attr("data-id");//商品id
        $.ajax({type: "get", url: "", data: "id="+id,success: function(msg){
            if(msg){
                show_addCart("商品已成功加入收藏夹！",true, true, "继续购物", function(){
                    window.location.href="";//点击结算跳转网址
                }, "查看收藏夹", function(){
                    window.location.href="";//点击继续跳转网址
                });
            }else{
                show_addCart("商品加入收藏夹失败！",true, false);
            }
        }});
    });

    $(".pagination .pagination_toLeft").live("mouseup",function(){
        var current_page=0;//当前页码
        wait($(".exchange_record"));
        $(".pagination .page_num").each(function(n,e){
            if($(e).hasClass("clicked")){
                current_page=$(e).find("a").text()-1
            }
        });
        $.ajax({type: "get",url: "",data: "current_page="+current_page+"number=10"/*每页显示条数*/,success: function(msg){
            var html="";
//            数据名称需要自己写
            for(var i=0;i<msg.length/*注意msg格式*/;i++){
                html+="<tr>"+
                    "<td>"+msg[i].name+"</td>"+
                    "<td class='color_f9'>"+msg[i].score+"</td>"+
                    "<td>"+msg[i].num+"</td>"+
                    "<td>"+msg[i].time+"</td>"+
                    "<td>"+msg[i].status+"</td>"+
                    "</tr>";
            }
            $(".exchange_record_table tbody").html(html);
            remove_wait();
        }})
    });
    $(".pagination .pagination_toRight").live("mouseup",function(n,e){
        var current_page=0;//当前页码
        wait($(".exchange_record"));
        $(".pagination .page_num").each(function(n,e){
            if($(e).hasClass("clicked")){
                current_page=$(e).find("a").text()+1
            }
        });

        $.ajax({type: "get",url: "",data: "current_page="+current_page+"number=10"/*每页显示条数*/,success: function(msg){
            var html="";
//            数据名称需要自己写
            for(var i=0;i<msg.length/*注意msg格式*/;i++){
                html+="<tr>"+
                    "<td>"+msg[i].name+"</td>"+
                    "<td class='color_f9'>"+msg[i].score+"</td>"+
                    "<td>"+msg[i].num+"</td>"+
                    "<td>"+msg[i].time+"</td>"+
                    "<td>"+msg[i].status+"</td>"+
                    "</tr>";
            }
            $(".exchange_record_table tbody").html(html);
            remove_wait();
        }})
    });
    $(".pagination .page_num").live("mouseup",function(){
        wait($(".exchange_record"));
        var current_page=parseInt($(this).find("a").text());//当前页码
        $.ajax({type: "get",url: "",data: "current_page="+current_page+"number=10"/*每页显示条数*/,success: function(msg){
           var html="";
//            数据名称需要自己写
            for(var i=0;i<msg.length/*注意msg格式*/;i++){
                html+="<tr>"+
                    "<td>"+msg[i].name+"</td>"+
                    "<td class='color_f9'>"+msg[i].score+"</td>"+
                    "<td>"+msg[i].num+"</td>"+
                    "<td>"+msg[i].time+"</td>"+
                    "<td>"+msg[i].status+"</td>"+
                    "</tr>";
            }
            $(".exchange_record_table tbody").html(html);
            remove_wait();
        }})
    });
});