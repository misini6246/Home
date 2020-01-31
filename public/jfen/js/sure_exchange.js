$(function(){
    $(".sure_btn").click(function(){
        //$.ajax({type: "POST",url: "/jf/sure",data: "",success: function(msg){
        //    //if(msg){
			//	window.location.href="flow.php?step=suc";
        //        /*showDialog("兑换成功！",true,function(){
        //
        //        })*/
        //    //}
        //}})
        var id = $(this).attr('data-o');
        window.location.href="/jf/sure?id="+id;
    });
});