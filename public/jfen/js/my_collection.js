$(function(){
    $(".remove_goods").click(function(){//删除单个
        var th=$(this);
        var choose_num=$(".choose_num");
        var tr=th.parent().parent().parent("tr");
        var choose_record=$(".choose_record");
        var point=$(this).parent().parent().parent().find(".need_point p");
        var e=1;
        showDialog("确定要删除该商品？",true,function(){
            $.ajax({type: "get",url: "",data: "id="+e,success: function(msg){
//                do sth
                if(msg/*删除条件*/){
                    if(tr.find(":checked").length>0){
                        choose_num.text(parseInt(choose_num.text())-parseInt(tr.find(".choose_every_num").val()));
                        choose_record.text(parseInt(choose_record.eq(0).text())-parseInt(point.text()));
                    }
                    tr.remove();
                    wait_alert($(".list_in_car"));
                    remove_wait("<img src='images/dialog_success.png' width='16' height='16' alt=''/><span>删除成功！</span>",true);
                }else{
                    wait_alert($(".list_in_car"));
                    remove_wait("<img src='images/dialog_fail.png' width='26' height='16' alt=''/><span>删除失败！</span>",true);
                }
            }});
        });
    });
});