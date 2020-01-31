function preview(img){
    $("#preview .jqzoom img").attr("src",$(img).attr("src"));
    $("#preview .jqzoom img").attr("jqimg",$(img).attr("bimg"));
}

$(function(){

	//百度分享
   with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];


     //放大镜
    $(".jqzoom").jqueryzoom({xzoom:380,yzoom:360});

    //tab切换
    $(".li_1").click(function () {

        $(this).addClass("on").siblings().removeClass("on");
        $(".ul_1").show().siblings("ul").hide();

    });
    $(".li_2").click(function () {
        $(this).addClass("on").siblings().removeClass("on");
        $(".ul_2").show().siblings("ul").hide();

    });
    $(".li_3").click(function () {
        $(this).addClass("on").siblings().removeClass("on");
        $(".content_7").css({
            'opacity':'1',
            'filter':'Alpha(Opacity:100)'
        });
        $(".content_7").show().siblings("ul").hide();

    });

});

//图片预览小图移动效果,页面加载时触发
$(function(){
    var tempLength = 0; //临时变量,当前移动的长度
    var viewNum = 4; //设置每次显示图片的个数量
    var moveNum = 2; //每次移动的数量
    var moveTime = 300; //移动速度,毫秒
    var scrollDiv = $(".spec-scroll .items ul"); //进行移动动画的容器
    var scrollItems = $(".spec-scroll .items ul li"); //移动容器里的集合
    var moveLength = scrollItems.eq(0).width() * moveNum; //计算每次移动的长度
    var countLength = (scrollItems.length - viewNum) * scrollItems.eq(0).width(); //计算总长度,总个数*单个长度

    //下一张
    $(".spec-scroll .next").bind("click",function(){
        if(tempLength < countLength){
            if((countLength - tempLength) > moveLength){
                scrollDiv.animate({left:"-=" + moveLength + "px"}, moveTime);
                tempLength += moveLength;
            }else{
                scrollDiv.animate({left:"-=" + (countLength - tempLength) + "px"}, moveTime);
                tempLength += (countLength - tempLength);
            }
        }
    });
    //上一张
    $(".spec-scroll .prev").bind("click",function(){
        if(tempLength > 0){
            if(tempLength > moveLength){
                scrollDiv.animate({left: "+=" + moveLength + "px"}, moveTime);
                tempLength -= moveLength;
            }else{
                scrollDiv.animate({left: "+=" + tempLength + "px"}, moveTime);
                tempLength = 0;
            }
        }
    });
});
















