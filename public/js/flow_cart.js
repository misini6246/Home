$(function () {

    // 购物车

    //默认全选

    var checkAllIuputs=$("input[type=checkbox]");

    checkAllIuputs.each(function () {
        var is_checked = parseInt($(this).attr('is_checked'));
        if(is_checked==0) {
            $(this).attr("checked", false);
        }else{
            $(this).attr("checked", true);
        }
	});

    // if($(".allselect").attr("checked")){
    //     GetCount();
    // }

    $("#Checkbox1").click(function () {
        $("input[type=checkbox]").each(function () {
            if ($("#Checkbox1").attr("checked")) {
                var is_checked = parseInt($(this).attr('is_checked'));
                if(is_checked==0) {
                    $(this).attr("checked", false);
                }else{
                    $(this).attr("checked", true);
                }
            } else {
                $(this).attr("checked", false);
            }
        });
        GetCount();
    });

	$("#Checkbox2").click(function () {
        $("input[type=checkbox]").each(function () {
            if ($("#Checkbox2").attr("checked")) {
                var is_checked = parseInt($(this).attr('is_checked'));
                if(is_checked==0) {
                    $(this).attr("checked", false);
                }else{
                    $(this).attr("checked", true);
                }
            } else {
                $(this).attr("checked", false);
            }
        });
        GetCount();
    });

    $("input[name=newslist]").click(function () {
         if(!$(this).checked){
              $(".allselect").attr("checked",false);
         }
         if($("input[name=newslist]:checked").length==$(".gwc_tb2 .xuanzhongzt").length){
              $(".allselect").attr("checked",true);
         }
         GetCount();
	});

    function GetCount() {
        var aa = 0;
        var bb=0;
		var orderstr="";
        var finestr="";
        $(".gwc_tb2 input[name=newslist]").each(function () {
            if ($(this).attr("checked")) {
				var recid= $(this).parents("tr").attr("data-id");
                var fine= $(this).parents("tr").find(".tb2_td2");
			    orderstr += recid+"_";
                aa += 1;
                if(fine.text()=="精"){
                    finestr+= recid+"_";
                    bb++;
                }
            }
        });
		$.ajax({
            url: '/ajax/cart/goodsChoose?'+Math.random(),
            type: 'get',
		    dataType: 'json',
			data:{orderstr:orderstr},
            success: function (msg) {
				$('#zong1').html(msg.total);
				$('#zong2').html(msg.jp_total_amount);
            }
        });

        $("#shuliang").text(aa);
        //$("#zong1").html((conts).toFixed(2));

        if(aa==0){
            $("#jz2").css("display", "none");
            $("#jz1").css("display", "block");

            $('#jiesuan').html("<span id='jz1'>结算</span>")
        } else{
            $('#jiesuan').html("<a href='/cart/jiesuan' class='jz2' id='jz2'>结算</a>")
        }
    }

	$(".jz2").click(function () {
        alert('请仔细核对商品数量及商品有效期,药品非质量问题概不退换！')
        //alert('       告广大药易购客户，因公司电商平台系统升级，为了给\n客户更好的下单和收货体验，经公司慎重研究决定，原定于4\n月26日的特价活动延期至5月4日举行，我们由衷的为此次升\n级给您带来的不便表示歉意，5月4日我们将以更大的活动力\n度来回馈大家的支持和理解！');
         $(".submit_txt").show();
        $(this).parent().remove();
    });

    // 参加的优惠信息
    $(".sale_list").hover(function () {
             $(".list").show();
    }, function () {
             $(".list").hide();
    });



    //清空购物车
    $("#clear_all").click(function(){
        if( check("您确定要清除吗？")){
			$.ajax({
                url: 'flow.php',
                type: 'post',
				dataType: 'json',
				data: {
					step: 'clear'
				},
                success: function (msg) {
                    if(msg.error){
						alert(msg.message);
					}
                }
            });
			$(".gwc").hide();
			$(".no_shopping").show();
        }
    });

	//点击删除与收藏
	 $(".del").click(function () {
        var _id = $(this).parents("tr").attr("data-id");
        $("#shopping_box4").show();
        $(".del2").click(function () {
			$(".del2").attr('href' ,'/cart/dropCart?id='+_id);
        });
        $(".remove_col").click(function () {
			$(".remove_col").attr('href' ,'/cart/dropToCollect?id='+_id);
        });

    });
	$(".collect").click(function () {
        var _id = $(this).parents("tr").attr("data-id");
        $("#shopping_box5").show();
        $(".confirm_cc").click(function () {
			$(".confirm_cc").attr('href' ,'/cart/dropToCollect?id='+_id);
        });

        $(".cancel").click(function () {
            $("#shopping_box5").hide();
        });


    });
	//end


    //删除选中的商品
    $("#del_checked").click(function(){
        var flag=$("#shuliang").text();
        var orderstr="";
		var _this=$(".gwc_tb2 input[name=newslist]:checked") ;
		_this.each(function () {
			var recid= $(this).parents("tr").attr("data-id");
			orderstr += recid+"_";
		});
        if(flag==0){
            check("请选择要删除的商品！");
        } else {
            if(check("您确定要删除吗？")){
                $(".gwc_tb2 input[type=checkbox]:checked ").parents("tr").remove();
                $(".allselect").attr("checked",false);
                location.href='/cart/dropCartMany?id='+orderstr
             }
         }
    });

    // 确认框
    function check($text) {

        if (confirm($text)) {
            return true;
        }
        else {
            return false;
        }
    }


    //滚动播放

    $('#slides').slides({
        container: 'slides_container',
        preload: true,
        play: 3000,
        pause: 1500,
        hoverPause: true,
        effect: 'slide',
        slideSpeed: 850
    });

});


function add_num(rec_id){
    var _this=$(".gwc_tb2 input[name=newslist]:checked") ;
	var _th=$(".gwc_tb2 input[name=newslist]") ;
    var num = parseInt(_th.parents("tr").find('#goods_num_show_'+rec_id).val()) ;
    var dzd = parseInt(_th.parents("tr").find('#goods_num_show1_'+rec_id).val());
    var goods_id = parseInt(_th.parents("tr").find('#goods_num_show_'+rec_id).attr('data-g')) ;
    var lsgg = parseInt(_th.parents("tr").find('#goods_num_show_'+rec_id).attr('data-lsgg')) ;
    var orderstr="";
    _this.each(function () {
        var recid= $(this).parents("tr").attr("data-id");
        orderstr += recid +"_";
    });
    $.post('/ajax/cart/addNum',{
        rec_id:rec_id,
        num:num,
        dzd:dzd,
        goods_id:goods_id,
        lsgg:lsgg,
        orderstr:orderstr,
        _token:$('meta[name="_token"]').attr('content')
        },
        updateCartResponse,'json');
}

function reduce_num(rec_id){
    var _this=$(".gwc_tb2 input[name=newslist]:checked") ;
    var _th=$(".gwc_tb2 input[name=newslist]") ;
    var num = parseInt(_th.parents("tr").find('#goods_num_show_'+rec_id).val()) ;
    var dzd = parseInt(_th.parents("tr").find('#goods_num_show1_'+rec_id).val());
    var goods_id = parseInt(_th.parents("tr").find('#goods_num_show_'+rec_id).attr('data-g')) ;
    var lsgg = parseInt(_th.parents("tr").find('#goods_num_show_'+rec_id).attr('data-lsgg')) ;
    var orderstr="";
    _this.each(function () {
        var recid= $(this).parents("tr").attr("data-id");
        orderstr += recid+"_";
    });
    $.post('/ajax/cart/addNum',{
            rec_id:rec_id,
            num:num,
            change_num:-1,
            dzd:dzd,
            goods_id:goods_id,
            lsgg:lsgg,
            orderstr:orderstr,
            _token:$('meta[name="_token"]').attr('content')
        },
        updateCartResponse,'json');
}


function changePrice_ls(rec_id){
    var _this=$(".gwc_tb2 input[name=newslist]:checked") ;
	var _th=$(".gwc_tb2 input[name=newslist]") ;
    var num = parseInt(_th.parents("tr").find('#goods_num_show_'+rec_id).val()) ;
    var dzd = parseInt(_th.parents("tr").find('#goods_num_show1_'+rec_id).val());
	var oldnum = parseInt(_th.parents("tr").find('#goods_num_show_'+rec_id).attr('data-value')) ;
    var goods_id = parseInt(_th.parents("tr").find('#goods_num_show_'+rec_id).attr('data-g')) ;
    var lsgg = parseInt(_th.parents("tr").find('#goods_num_show_'+rec_id).attr('data-lsgg')) ;
    var orderstr="";
    _this.each(function () {
        var recid= $(this).parents("tr").attr("data-id");
        orderstr += recid+"_";
    });
    $.post('/ajax/cart/addNum',{
            rec_id:rec_id,
            num:0,
            change_num:num,
            dzd:dzd,
            goods_id:goods_id,
            lsgg:lsgg,
            orderstr:orderstr,
            _token:$('meta[name="_token"]').attr('content')
        },
        updateCartResponse,'json');
}

function updateCartResponse(result){
    if (result.error == 0){
        var isChecked = $('.gwc_tb2 input[name=newslist]').is(":checked");
        if(isChecked){
            $('#zong1').html(result.total);
			$('#zong2').html(result.jp_total_amount);
        }
        $('#goods_num_show_'+result.rec_id).val(result.num);
		$('#subtotal_'+result.rec_id).html(result.subtotal);
		$('#zp_goods'+result.rec_id).replaceWith(result.child);
		// 2015-7-9 换购
		$('#tr_'+result.rec_id).before(result.c_str);
		if(result.c_rec_id > 0){
			$('#tr_'+result.rec_id).attr("data-id",result.rec_id+"_"+result.c_rec_id);
			var orderstr = $("#jz2").attr('href');
			var str = result.c_rec_id+"_";
			$("#jz2").attr('href',orderstr+str);
		}
		 
		if(result.change_do == 0){
			$('#tr_'+result.change_id).remove();
			$('#tr_'+result.change_id).attr("data-id","");
			$('#tr_'+result.rec_id).attr("data-id",result.rec_id);
			var orderstr = $("#jz2").attr('href');
			var str = result.change_id+"_";
			$("#jz2").attr('href',orderstr.replace(str,''));
		}
		if(result.change_do == 1){
			$('#tr_'+result.change_id).find(".tb2_td7").text(result.change_num);
			$('#subtotal_'+result.change_id).html(result.c_subtotal);
		}

        if(result.message){
            alert(result.message);
        }
		//end
    }
    else if (result.error == 1) {
        add_tanchuc(result.msg);
        return false;
    }
    else{
        //alert(result.message);
        $('#goods_num_show_'+result.rec_id).val(result.num);
    }
}

