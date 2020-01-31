$(function () {

    //    导航栏鼠标经过
    $('ul.nav_title li.li_list_r a').click(function(){
        $('ul.nav_title  li:first-child a').removeClass("checked_on");
        $(this).stop().addClass("checked_on").parents("li").siblings().find("a").removeClass("checked_on");
    });


    //默认全选

    var checkAllIuputs=$("input[type=checkbox]");

    checkAllIuputs.each(function () {

        $("input[type=checkbox]").attr("checked",true);

    }) ;

    $("#Checkbox1").click(function () {
        $("input[type=checkbox]").each(function () {


            if ($("#Checkbox1").attr("checked")) {
                $(this).attr("checked", true);


            } else {
                $(this).attr("checked", false);


            }
        });

    });


    $("#Checkbox2").click(function () {
        $("input[type=checkbox]").each(function () {


            if ($("#Checkbox2").attr("checked")) {
                $(this).attr("checked", true);


            } else {
                $(this).attr("checked", false);


            }
        });

    });

    $("input[dd-id=newslist]").click(function () {

        if(!$(this).checked){

            $(".allselect").attr("checked",false);

        }

        if($("input[dd-id=newslist]:checked").length==$(".gwc_tb2 tr").length-1){
            $(".allselect").attr("checked",true);

        }


    });


    //表格鼠标经过效果
    $("table tr td").hover(function () {
       $(this).parent().addClass("hover").siblings().removeClass("hover");
    }, function () {
        $(this).parent().removeClass("hover")
    });


	//批量加入购物车
    $("#submit_0").click(function(){

        var _this=$(".gwc_tb2 input[dd-id=newslist]:checked");
        var _len=_this.length;
        var _id="";
        _this.each(function () {
            var  goods_id=$(this).parents("tr").attr("data-id");
            _id+= goods_id+"_";
        });
        if(_len==0){
            alert("请选择商品！");
            return false;
        }
    });

	//批量加入购物车
    $("#submit1").click(function(){
		alert('你的权限不够，请查看是否登录或者未提交资质，如提交请与客服联系');
	});

    //批量取消收藏
	
   $("#cancel1").click(function(){
        var _this=$(".gwc_tb2 input[dd-id=newslist]:checked");
        var _len=_this.length;
        var _id="";
        _this.each(function () {
            var  rec_id=$(this).parents("tr").attr("id");
            _id+= rec_id+"_";

        }) ;
        if(_len==0){
            alert("请选择商品！");
            return false;
        }else {
            if( check("您确定要删除吗？")){
                var url = $('#action').val();
                $('#form').attr('action',url);
                $('#form').submit();
                return true;
            }
        }

    });
    

	//function callback(msg){
		//alert('11');
		//alert(msg.success);
	//}
	

	// 确认框
    function check($text) {

        if (confirm($text)) {
            return true;
        }
        else {
            return false;
        }
    }


});
