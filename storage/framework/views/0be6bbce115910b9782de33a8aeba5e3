<div class="side-nav">
    <div class="title">
        <img src="" alt="">
    </div>
    <ul>
        <li class="hd">
            <a href="/">爆款特惠></a>
        </li>
        <li>
            <a href="/yhq">优惠券></a>
        </li>
        <li>
            <a href="/cxzq">每周精选></a>
        </li>
        <li>
            <a href="/cxhd/tejia">特价专区></a>
        </li>
        <li>
            <a href="/cxhd/youhui">满减专区></a>
        </li>
        <li>
            <a href="/cxhd/jpmz"> 买赠专区></a>
        </li>
        <li>
            <a href="/category?dis=2">高毛精品></a>
        </li>
        <li>
            <a href="/zy">中药专区></a>
        </li>
        <li>
            <a href="/articleInfo?id=48">
                返利规则>
            </a>
        </li>
    </ul>
</div>
<script>
    // 控制当前是国庆还是秋分并添加active样式
    var url=window.location.pathname;
    if(url=="/qiufen"){
        $('.side-nav ul .hd').addClass('active');
    }else if(url=="/guoqing"){
        $('.side-nav ul .hd').addClass('active');
    }
    // 根据时间控制第一个是链接国庆还是秋分
    var now=Date.parse(new Date());
    if(now>=Date.parse('2019-09-24')){
        $('.side-nav .title img').attr('src','/huodong/guoqing/nav.png');
        $('.side-nav ul .hd a').attr('href','/guoqing');
    }else{
        $('.side-nav ul .hd a').attr('href','/qiufen');
        $('.side-nav .title img').attr('src','/huodong/qiufen/nav.png');
    }
    // 控制导航隐藏与显示
    // $(document).scroll(function(){
    //     if($(document).scrollTop()>=1000){
    //         $('.side-nav').show(300);
    //     }else{
    //         $('.side-nav').hide(300);
    //     }
    // })
</script>
<style>
    .side-nav {
        /* display: none; */
        background: #facd89;
        position: fixed;
        right: 40px;
        top: 26%;
        z-index: 10;
        border-radius: 100px;
        padding: 0 0 80px 0;
    }

    .side-nav .title img {
        width: 100%;
    }

    .side-nav ul {
        padding: 0 10px;
    }

    .side-nav ul>li {
        margin-top: 10px;
        padding: 10px 26px;
        border-radius: 40px;
        background: #fee5c0;
        text-align: center;
        text-align-last: justify;
        font-size: 14px;
    }

    .side-nav ul>li.active {
        background: #fff;
    }
</style>