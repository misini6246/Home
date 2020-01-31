/**
 * Created by wang on 14-10-11.
 */
$(function(){
    $(".pagination .pagination_toLeft").live("mouseup",function(){
        var current_page=0;//当前页码
        wait($(".all_address"));
        $(".pagination .page_num").each(function(n,e){
            if($(e).hasClass("clicked")){
                current_page=$(e).find("a").text()-1
            }
        });
        $.ajax({
			type: "POST",
			dataType: 'JSON' ,
			url: "member.php",
			data: {
				act: 'ajax_get_order' ,
				current_page: current_page ,
				number: 5
			},
			success: function(msg){
			var content = msg.content ;
            var html = "";
            for(var i=0;i<content.length;i++){
				html+="<tr><td class='orderid'><a href='member.php?act=od&id="+content[i].id+"' target='_blank'>"+content[i].order_sn+"</a></td><td>"+content[i].add_time+"</td><td class='color_f9'>"+content[i].order_amount+"分</td><td class='status'>"+content[i].order_state+"</td></tr>" ;
            }
            $(".all_address tbody").html(html);
            remove_wait();
        }})
    });
    $(".pagination .pagination_toRight").live("mouseup",function(n,e){
        var current_page=0;//当前页码
        wait($(".all_address"));
        $(".pagination .page_num").each(function(n,e){
            if($(e).hasClass("clicked")){
                current_page=$(e).find("a").text()+1
            }
        });

        $.ajax({
			type: "POST",
			dataType: 'JSON' ,
			url: "member.php",
			data: {
				act: 'ajax_get_order' ,
				current_page: current_page ,
				number: 5
			},
			success: function(msg){
			var content = msg.content ;
            var html="";
			for(var i=0;i<content.length;i++){
				html+="<tr><td class='orderid'><a href='member.php?act=od&id="+content[i].id+"' target='_blank'>"+content[i].order_sn+"</a></td><td>"+content[i].add_time+"</td><td class='color_f9'>"+content[i].order_amount+"分</td><td class='status'>"+content[i].order_state+"</td></tr>" ;
            } 
            $(".all_address_table tbody").html(html);
            remove_wait();
        }})
    });
    $(".pagination .page_num").live("mouseup",function(){
        wait($(".all_address"));
        var current_page=parseInt($(this).find("a").text());//当前页码
        $.ajax({
			type: "POST",
			dataType: 'JSON' ,
			url: "member.php",
			data: {
				act: 'ajax_get_order' ,
				current_page: current_page ,
				number: 5
			},
			success: function(msg){
            var content = msg.content ;
            var html="";
            for(var i=0;i<content.length;i++){
				html+="<tr><td class='orderid'><a href='member.php?act=od&id="+content[i].id+"' target='_blank'>"+content[i].order_sn+"</a></td><td>"+content[i].add_time+"</td><td class='color_f9'>"+content[i].order_amount+"分</td><td class='status'>"+content[i].order_state+"</td></tr>" ;
            } 
            $(".all_address tbody").html(html);
            remove_wait();
        }})
    });
});