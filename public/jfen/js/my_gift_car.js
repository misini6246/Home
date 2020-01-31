/**
 * Created by wang on 14-9-19.
 */
$(function(){
    var pay_btn=$(".pay_btn");
    var add1=$(".add1");
    var del1=$(".del1");
    add1.hover(function(){//鼠标放到商品加1按钮上
        if(parseInt($(this).prev().find("input").val())<9999/*最大数量*/){
            $(this).css({border: "1px solid #f95706"});
            $(this).prev().find("input").css({borderRight: "0"});
        }
    },function(){
        $(this).css({border: "1px solid #eaeaea",borderLeft: "0"});
        $(this).prev().find("input").css({borderRight: "1px solid #999"});
    });
    del1.hover(function(){//鼠标放到商品减1按钮上
        if(parseInt($(this).next().find("input").val())>1){
            $(this).css({border: "1px solid #f95706"});
            $(this).next().find("input").css({borderLeft: "0"});
        }
    },function(){
        $(this).css({border: "1px solid #eaeaea",borderRight: "0"});
        $(this).next().find("input").css({border: "1px solid #999"});
    });

    add1.click(function(){//商品数量加1
        var val=parseInt($(this).prev().find("input").val());//商品数量
        var choose_record=$(".choose_record");
        var tr=$(this).parent().parent().parent();// 表格行
        var point=tr.find(".need_point p");
        var one=tr.attr('data-jf');//商品单价
        var t=$(this);
        var po= parseInt(point.text());
        var id=parseInt(tr.attr("data-id"));//商品id
        var url = '/jf/checkNum';
        var step = 'add_num_cart' ;
        var count =val+1;//商品数量
        $.ajax({
            headers: {

                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')

            },
            type: "post",
             url: url,
            data: {
                id: id,
                num: val,
                step: step
            },
            dataType: 'JSON',
            success: function(msg){
                if(!msg.flag){//如果不是最大数量
                    t.prev().find("input").val(val+1);//商品数量加1
                    point.text(one*parseInt(t.prev().find("input").val()));//总积分
                    if(tr.find(":checked").length){//如果商品被选中
                        var rec=0;
                        var choose_num=$(".choose_num");
                        var old=parseInt(choose_record.eq(0).text());
                        var ne=parseInt(point.text());
                        rec= old-po+ne;//新的所需积分
                        choose_record.text(rec);
                        choose_num.text(parseInt(choose_num.text())+1);//总数量加1
                    }
                }else{
                    showDialog("商品库存不足！", false);
					t.prev().find("input").val(msg.stock);
                }
            }
        });
    });
    del1.click(function(){//商品数量减1
        var val=parseInt($(this).next().find("input").val());
		var tr=$(this).parent().parent().parent();
        var one=tr.attr('data-jf');//商品单价
        var choose_record=$(".choose_record");
        var point=tr.find(".need_point p");
        var rec=0;
        if(val>1){
            var choose_num=$(".choose_num");
            var po= parseInt(point.text());
            $(this).next().find("input").val(val-1);
            point.text(one*parseInt($(this).next().find("input").val()));
            if(tr.find(".check_goods input:checked").length>0){
                choose_num.text(parseInt(choose_num.text())-1);
                var old=parseInt(choose_record.eq(0).text());
                var ne=parseInt(point.text());
                rec= old-po+ne;
                choose_record.text(rec);
            }
        }
    });
    $(".choose_every_label input").focusout(function(){//检查数量是否数字
		var max=parseInt($(this).parents("tr").find(".remain").text());
		var tr=$(this).parent().parent().parent().parent() ;
        if(!(/(^[0-9]+$)/.test($(this).val()))||/^[0]$/.test($(this).val())){
            $(this).val(1);
        }else{
            if(parseInt($(this).val())>max/*最大数量*/){
                $(this).val(max/*最大数量*/);
            }
        }
        if(parseInt($(this).val())>0&&parseInt($(this).val())<=9999/*最大数量*/){//改变所需积分
            var one=tr.attr('data-jf');//商品单价
            $(this).parent().parent().parent().parent().find(".need_point p").text(one*$(this).val());
			//10-24
            if(tr.find(":checked").length>0){
                var choose_record=$(".choose_record");
                var old= 0,no= 0;
                $(".list_in_car table tbody").find(":checked").each(function(n,e){
                    old+=parseInt($(e).parent().parent().parent().find(".need_point p").text());
                    no+=parseInt($(e).parent().parent().parent().find(".choose_every_num").val());
                });
                choose_record.text(old);
                $(".choose_num").text(no);
            }
			//end

        }
    });
    $(".remove_goods").click(function(){//删除单个
        var th=$(this);
        var choose_num=$(".choose_num");
        var tr=th.parent().parent().parent("tr");
        var choose_record=$(".choose_record");
        var point=$(this).parent().parent().parent().find(".need_point p");
        var e = $(this).attr('data-id') ;
        showDialog("确定要删除该商品？",true,function(){
            location.href='/jf/deleteCart?id='+e;
//            $.ajax({
//				type: "POST" ,
//				url: "flow.php",
//				dataType: 'JSON',
//				data: {
//					step: 'del_to_cart' ,
//					id: e
//				},
//				success: function(msg){
////                do sth
//                if(msg.flag){
//                    if(tr.find(":checked").length>0){
//                        choose_num.text(parseInt(choose_num.text())-parseInt(tr.find(".choose_every_num").val()));
//                        choose_record.text(parseInt(choose_record.eq(0).text())-parseInt(point.text()));
//                    }
//                    tr.remove();
//					var checked1=$(".list_in_car table tbody").find(":checked");
//					if(checked1.length<=0){
//						pay_btn.css("cursor","auto");
//						pay_btn.css({backgroundColor: "#f8f8f8",color: "#aaa"});
//					}
//					var check=$(".list_in_car table tbody").find(":checkbox");
//                    $(".cart a span i").text(check.length);
//                    $(".cnd_goodsCar a span span").text(check.length);
//				}
//            }});
        });
    });
    $(".delete_goods").click(function(){//删除选中
        var th=$(this);
        var checked=$(".list_in_car table tbody").find(":checked");
        if(checked.length>0){
            showDialog("确定要删除该商品？",true,function(){
                $.ajax({type: "get",url: "",data: "",success: function(msg){

                    //do sth
                    if(1/*删除条件*/){
                        var choose_num=$(".choose_num");
                        $(".choose_record").text("0");
                        var all=0;
                        checked.parent().parent().parent("tr").remove();//删除选中
                        checked.each(function(n,e){//计算删除个数
                            var num=parseInt($(this).parent().parent().parent().find(".choose_every_num").val());
                            all=all+num;
                        });
                        choose_num.text(parseInt(choose_num.text())-all);//更新个数

						var checked1=$(".list_in_car table tbody").find(":checked");
                        if(checked1.length<=0){
                            pay_btn.css("cursor","auto");
                            pay_btn.css({backgroundColor: "#f8f8f8",color: "#aaa"});
                        }
						var check=$(".list_in_car table tbody").find(":checkbox");
						$(".cart a span i").text(check.length);
						$(".cnd_goodsCar a span span").text(check.length);
                    }
                }});
            });
        }else{
            showDialog("你没有选中任何商品！",false);
        }
    });

    $(".move_to").click(function(){//单个移入收藏夹
        showDialog("确定移入收藏夹？",true,function(){
            $.ajax({type: "get",url: "",data: "",success: function(msg){

                //do sth
                if(msg/*移入收藏夹成功条件*/){

                }else{
                    showDialog("该商品已在收藏夹中！",false);
                }
            }});
        });
    });

    $(".move_to_collect").click(function(){//选中移入收藏夹
        var th=$(this);
        var checked=$(".list_in_car table tbody").find(":checked");
        if(checked.length>0){
            showDialog("确定移入收藏夹？",true,function(){
                $.ajax({type: "get",url: "",data: "",success: function(msg){

                    //do sth
                    if(msg/*移入收藏夹成功条件*/){

                    }
                }});
            });
        }else{
            showDialog("你没有选中任何商品！",false);
        }
    });

    $(".all_select").bind("click",function(){//全选
        var choose_record=$(".choose_record");
        var choose_num=$(".choose_num");
        var check=$(".list_in_car table tbody");
        var checkbox= check.find(":checkbox");
        var checked=check.find(":checkbox:not(:checked)");
        var total=0;
        var no=0;
        if(!$(this).find("input:checked").length){
            $(".all_select input").removeAttr("checked");
            checkbox.removeAttr("checked");
            choose_record.text(0);
            choose_num.text(0);
            pay_btn.css("cursor","auto");
            pay_btn.css({backgroundColor: "#f8f8f8",color: "#aaa"});
        }else{
            $(".all_select input").attr("checked","checked");
            checkbox.attr("checked","checked");
            checkbox.each(function(n,e){
                var point=$(this).parent().parent().parent().find(".need_point p");
                var num=parseInt($(this).parent().parent().parent().find(".choose_every_num").val());
                var price=parseInt($(this).parent().parent().parent().attr("data-jf"));
                point.text(num*price);
				total=total+parseInt(point.text());
                no=no+num;
            });
            choose_record.text(total);
            choose_num.text(no);
            pay_btn.css("cursor","pointer");
            pay_btn.css({backgroundColor: "#f95706",color: "#fff"});
        }
    });

    $(".check_goods input").click(function(){//勾选商品改变价格
        var choose_record=$(".choose_record");
        var choose_num=$(".choose_num");
        var checkbox=$(".list_in_car table tbody");
        var total=0;
        var tr=$(this).parent().parent().parent();
        var num=parseInt(tr.find(".choose_every_num").val());
        var point=tr.find(".need_point");
        total=parseInt(point.text());
        if($(this).filter(":checked").length>0){
            choose_num.text(parseInt(choose_num.text())+parseInt(tr.find(".choose_every_num").val()));
            choose_record.text(parseInt(choose_record.eq(0).text())+total);
        }else{
            choose_num.text(parseInt(choose_num.text())-parseInt(tr.find(".choose_every_num").val()));
            choose_record.text(parseInt(choose_record.eq(0).text())-total);
        }
        if(checkbox.find(":checked").length==checkbox.find(":checkbox").length){//如果全部选中，把全选勾上
            $(".all_select input").attr("checked","checked");
        }else{
            $(".all_select input").removeAttr("checked");
        }
        change_cursor(checkbox.find(":checked"));
    });

    $(".cld_topNav button:not(.pay_btn)").click(function(){//表格上面的切换
        $(this).siblings().css({"border-bottom":"0",color: "#4a4a4a"});
        $(this).css({"border-bottom":"2px solid #f95706",color: "#f95706"});
    });
    $(".list_in_car tr td:first-child").css({paddingLeft: "30px",textAlign: "left"});



    var checked=$(".list_in_car table tbody").find(":checked");
    change_cursor(checked);
    function change_cursor(e){//没有选中商品时改变结算按钮状态
        if(e.length<=0){
            pay_btn.css({"cursor":"auto"});
            pay_btn.css({backgroundColor: "#f8f8f8",color: "#aaa"});
        }else if(e.length>0){
            pay_btn.css("cursor","pointer");
            pay_btn.css({backgroundColor: "#f95706",color: "#fff"});
        }
    }
    pay_btn.on("click",function(){//支付
        var checked=$(".list_in_car table tbody").find(":checked");
        if(checked.length<=0){
            $(".show_sth").fadeIn(300);
        }else if(checked.length>0){//如果有选中的商品
			//do sth
            //wait_alert($("body"));
			orderstr = '' ;
            checked.each(function(n,e){
				var id = parseInt($(e).attr("data-id")) ;
				var num = parseInt($(e).parents('tr').find(".choose_every_num").val()) ;
				var os = id + '_' + num ;
				orderstr += os+'-' ;
            });
            $.ajax({
                headers: {

                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')

                },
				type: "POST" ,
				dataType: 'JSON' ,
				url: "/jf/check" ,
				data: {
					step: 'check' ,
					orderstr: orderstr
				} ,
				success: function(msg){
					if(msg.flag){
					    //do sth
						//remove_wait("支付成功！",false);
						window.location.href="/jf/make" ;//跳转页面
						return;
					}

					showDialog(msg.content, false) ;
				}
            })
        }else{
            alert("error");
        }
    });
    pay_btn.mouseout(function(){//移出结算按钮
        $(".show_sth").fadeOut(300);
    });

    select($(this),1);//默认全部商品
    $(".all_list").click(function(){select($(this),1)});//全部商品
    $(".lack").click(function(){select($(this),2)});//库存紧张
//    e:操作元素，id:操作id;tips:全部商品还是库存紧张
    function select(e,id){
        var th=e;
        $.ajax({type: "get",url: "",data: {id: id},success: function(msg){
            if(msg.status/*注意*/){
                var html="";
                for(var i=0;i<msg.length;i++){
                    html+="<tr>"+
                        "<td class=\"check_goods\"><label><input type=\"checkbox\"/><img src=\"images/yuzuo.jpg\" alt=''/></label></td>"+
                        "<td class=\"goods_msg\"><p>"+msg[i].name+"</p></td>"+
                        "<td class=\"only_price\"><p>"+msg[i].price+"</p></td>"+
                        "<td><p>" +
                            "<button class=\"reset_btn del1\">－</button>" +
                            "<label class=\"choose_every_label\">" +
                            "<input type=\"text\" value=\"1\" class=\"choose_every_num\"/>" +
                            "</label>" +
                            "<button class=\"reset_btn add1\">＋</button>" +
                        "</p></td>"+
                        "<td class=\"need_point\"><p>"+msg[i].score+"</p></td>"+
                        "<td class=\"operate\"><div>"+
                            "<a class=\"reset_btn move_to\" href=\"javascript:;\">移入收藏夹</a>"+
                            "<button class=\"reset_btn remove_goods\">删除</button>"+
                            "</div>" +
                        "</td></tr>";
                }
                th.find("span").text(msg.lackNo);//库存紧张或全部商品数量
                $(".list_in_car table tbody").html(html);
            }
        }});
    }
});
