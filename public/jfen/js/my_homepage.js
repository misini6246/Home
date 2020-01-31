/**
 * Created by wang on 14-9-23.
 */
$(function(){
   $(".operate .change").click(function(e){//点击修改
       e.stopPropagation();
       //do sth

   });
    $(".operate .del").click(function(e){//点击删除
        stopPropagation(e);
        var th=$(this);
        showDialog("确定要删除该地址？",true,function(){
			wait_alert($(".all_address"));
            //do sth
            var id=parseInt(th.parent().parent().attr("data-id"));
            location.href='/user/addressDelete?id='+id+"&act=jf"
        })
    });
    $(".operate .cancel").click(function(e){//点击取消
        stopPropagation(e);
        //do sth

    });


    $(".save").click(function(e){//点击保存
		var edit = $(this).attr('data-edit') ;
		var aid = $(this).attr('data-aid') ;
        var isTrue=true;
		var returnurl = $(this).attr('data-url') ;
        var people=$(".people");
        var detail_address=$(".detail_address");
        var postcode=$(".postcode");
        var cellphone_num=$(".cellphone_num");
        isTrue=test_null(people,"收货人姓名")&&isTrue;//验证收货人姓名
        isTrue=test_null(detail_address,"街道地址")&&isTrue;//验证街道地址
        isTrue=test_postcode(postcode,"邮政编码",6)&&isTrue;//验证邮政编码
        isTrue=test_postcode(cellphone_num,"手机号码",11)&&isTrue;//验证手机号码
        isTrue = test_address()&&isTrue;//表单是否填写完整 
        var is_default=$(".to_default:checked").length;//是否默认：1是，0否
		var act = 'add_addr' ;
		if(edit == 1) {
			act = 'edit_addr' ;
		} 

        if(isTrue){

            //do sth
            var span=$(".choose_address .select_choose span");
            $('#province').val(parseInt(span.eq(0).attr("data-id")));
            $('#city').val(parseInt(span.eq(1).attr("data-id")));
            $('#district').val(parseInt(span.eq(2).attr("data-id")));
            $('#form').submit();
            //var name=people.val();
            //var address= detail_address.val();
            //var post= postcode.val();
            //var cellphone= cellphone_num.val();
            //var select1=parseInt(span.eq(0).attr("data-id"));
            //var select2=parseInt(span.eq(1).attr("data-id"));
            //var select3=parseInt(span.eq(2).attr("data-id"));
            //$.ajax({
			//	type: "POST" ,
			//	url: "member.php" ,
			//	dataType: "JSON" ,
			//	data: {
			//		act: act ,
			//		aid: aid ,
			//		name: name ,
			//		address: address ,
			//		post: post ,
			//		cellphone: cellphone ,
			//		select1: select1 ,
			//		select2: select2 ,
			//		select3: select3
			//	} ,
			//	success: function(data){
			//		if(data.error !== undefined){
			//			wait_alert($(".all_address"));
			//			remove_wait("<img src='/jfen/images/dialog_success.png' width='16' height='16' alt=''/><span>"+data.error+"</span>",true);
			//			return ;
			//		}
			//
			//		wait_alert($(".all_address"));
             //       remove_wait("<img src='/jfen/images/dialog_success.png' width='16' height='16' alt=''/><span>"+data.msg+"</span>",true);
			//		location.href = returnurl ;
			//	}
			//});
        }
        return false;
    });

    $(".reset").click(function(e){//点击取消
        e.stopPropagation();
        var span=$(".choose_address .select_choose span");
        var input=$(".fill_msg input");
        input.val("");
        $(".alert").text("*");
        span.text("请选择...");
//        10-13
        span.attr("data-id",0);
//        end
		$(".choose_address .select_options:not(:first)").html($(".choose_address .select_options:first-child").html());
        return false;
    });

    $(".people").focusout(function(){//验证收货人姓名
        //do sth
        test_null($(this),"收货人姓名");
        return true;
    });
    $(".detail_address").focusout(function(){//验证街道地址
        //do sth
        test_null($(this),"街道地址");
    });
    $(".postcode").focusout(function(){//验证邮政编码
        //do sth
        test_postcode($(this),"邮政编码",6);
    });
    $(".cellphone_num").focusout(function(){//验证手机号码
        //do sth
        test_postcode($(this),"手机号码",11);
    });
    function test_postcode(e,al,n){
        var re = new RegExp("^[0-9]{"+n+"}$");
        if(e.val()==""){
            e.next("span").text(al+"不能为空！");
            return false;
        }else if(!re.test(e.val())){
            e.next("span").text(al+"只能是"+n+"位数字！");
            return false;
        }else{
            e.next("span").text("*");
            return true;
        }
    }

    function test_null(e,al){//验证空
        //do sth
        if(e.val()==""){
            e.next("span").text(al+"不能为空！");
            return false;
        }else{
            e.next("span").text("*");
            return true;
        }
    }

    function test_address(){
        var span=$(".choose_address .select_choose span");
//        验证所在地区下拉框
        var select1=parseInt(span.eq(0).attr("data-id"))!=0;
        var select2=parseInt(span.eq(1).attr("data-id"))!=0;
        var select3=parseInt(span.eq(2).attr("data-id"))!=0;
//        end
        if(select1&&select2&&select3){
            $(".choose_address .alert").text("*");
            return true
        }else{
            $(".choose_address .alert").text("请完整选择所在地区！");
            return false;
        }
    }
//    10-14
//    地址在这里第一个参数改
    $(".province .select_options li").live("mouseup",function(){select_area("/address/region",$(this),".city",2);return false});
    $(".city .select_options li").live("mouseup",function(){select_area("/address/region",$(this),".district",3);return false});
    /**
     *
     * @param url   请求地址
     * @param e     当前操作的节点
     * @param where 结果添加的地方（父元素），格式：jquery选择器
     */
    function select_area(url,e,where,type){
        var id=parseInt(e.attr("data-id"));
        if(id){
            $.ajax({
                type:"get",
                url:url,
                data:{type:type,parent:id},
                dateType:'json',
                success:function(msg){
                var html="<li data-id='0' style='border: 0'>请选择...</li>";
                for(var i=0;i<msg['regions'].length;i++){
                    html += "<li data-id='"+msg['regions'][i].region_id+"'>"+msg['regions'][i].region_name+"</li>"
                }
				//html += msg ;
                $(where+" .select_options").html(html);
            }})
        } else {
			if(where == '.city') {
				$('.city .select_choose', '.distrct .select_choose').html("<li data-id='0'>请选择...</li>") ;
				$('.city .select_choose', '.distrct .select_choose').html("<li data-id='0' style='border: 0'>请选择...</li>") ;
			} else if(where == '.district') {
				$('.distrct .select_choose').html("<li data-id='0'>请选择...</li>") ;
				$('.distrct .select_choose').html("<li data-id='0' style='border: 0'>请选择...</li>") ;
			}
		}
    }
//end
});