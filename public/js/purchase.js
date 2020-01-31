$(function () {


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
    $("#submit").click(function(){

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


    var initPagination = function() {
        var num_entries = $("#hiddenresult div.result").length;
        // 创建分页
        $("#Pagination").pagination(num_entries, {
            num_edge_entries: 1, //边缘页数
            num_display_entries: 4, //主体页数
            callback: pageselectCallback,
            items_per_page: 1, //每页显示1项
            prev_text: "前一页",
            next_text: "后一页"
        });
    };

    function pageselectCallback(page_index, jq){
        var new_content = $("#hiddenresult div.result:eq("+page_index+")").clone();
        $("#Searchresult").empty().append(new_content); //装载对应分页的内容
        return false;
    }
    //ajax加载
    //$("#hiddenresult").load("load.html", null, initPagination);







});