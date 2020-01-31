$(function(){
    $(".subNav").click(function(){
        $(this).toggleClass("currentDd").siblings(".subNav").removeClass("currentDd");
        $(this).toggleClass("currentDt").siblings(".subNav").removeClass("currentDt");

        $(this).next(".navContent").slideToggle(500).siblings(".navContent").slideUp(500);
    });


    //百度分享
    with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];




})