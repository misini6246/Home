/**
 * Created by wang on 14-9-9.
 */
//分页
$(function(){
    var li=$(".pagination").find(".page_num");
    $(".page_num").click(function(){
        var pagination= $(".pagination");
        var pageNum=pagination.find(".page_num");
        var prevNum=$(this).prevAll(".page_num").length;
        pageNum.removeClass("clicked");
        var total_page=parseInt(pagination.attr("data-page"));
        if($(this).hasClass("page_num")){$(this).addClass("clicked")}
        if(parseInt($(this).text())<parseInt(total_page)){
            if(prevNum>parseInt(pageNum.length/2)){
                for(var i=0;i<prevNum-parseInt(pageNum.length/2);i++){
                    if(parseInt(pageNum.last().children("a").text())+i+1<=parseInt(total_page)){
                        pageNum.eq(i).children("a").text(parseInt(pageNum.last().children("a").text())+i+1);
                        pageNum.eq(i).insertAfter($(".page_num").last());
                    }
                }
            }
        }
        return false;
    });
    $(".pagination_toLeft").click(function(){
        li.each(function(a,e){
            if($(e).hasClass("clicked")){
                var page_num=$(".pagination").find(".page_num");
                if($(e).prev().hasClass("page_num")){
                    $(e).prev(".page_num").addClass("clicked");
                    $(e).removeClass("clicked");
                }
                if(parseInt(page_num.first().children().text())>1){
                    if($(e).index(".page_num")<=parseInt(page_num.length/2)){
                        page_num.last().children("a").text(parseInt(page_num.first().children("a").text())-1);
                        page_num.last().insertBefore(page_num.first());
                    }
                }
            }
        });
        return false;
    });
    $(".pagination_toRight").click(function(){
        var pagination= $(".pagination");
        var total_page=parseInt(pagination.attr("data-page"));
        pagination.find(".page_num").each(function(a,e){
            if($(e).hasClass("clicked")){
                var page_num=$(".pagination").find(".page_num");
                if($(e).next().hasClass("page_num")){
                    $(e).next(".page_num").addClass("clicked");
                    $(e).removeClass("clicked");
                }
                if(parseInt(li.last().text())<total_page){
                    if($(e).index(".page_num")>=parseInt(page_num.length/2)){
                        page_num.first().children("a").text(parseInt(page_num.last().children("a").text())+1);
                        page_num.first().insertAfter(page_num.last());
                    }
                }
                return false;
            }
        });
    });
});
//end