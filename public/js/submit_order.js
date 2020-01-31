var int;
$(function () {
    //弹出广告效果
    $('.close').click(function(){
        $('.alert_mark').hide(0);
        $('.content_mark_div').hide(0);
        clearInterval(int);
    });
}) ;

function toSearch(_obj){
    $('.alert_mark').show(0);
    $('.content_mark_div').show(0).css("filter","alpha(opacity=60)");
    var searchUrl = _obj.attr('searchUrl');
    int = setInterval("search_zf('"+searchUrl+"')", 8000)

}

function search_zf(searchUrl){
    $.ajax({
        url:searchUrl,
        type:'get',
        dataType:'json',
        success:function($result){
            //alert($result);
            if($result.error==0){
                window.location.reload();
            }
        }
    });
}

