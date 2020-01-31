<div class="side-nav">
    <ul>
        <li>
            <a href="/yhq" target="_blank">
                <img src="http://www.jyeyw.com/111/nav/yhq.png" alt="">
            </a>
        </li>
        <li>
            <a href="/11.1/miaosha" target="_blank">
                <img src="http://www.jyeyw.com/111/nav/ms.png" alt="">
            </a>
        </li>
        <li>
            <a href="/yfhg" target="_blank">
                <img src="http://www.jyeyw.com/111/nav/hg.png" alt="">
            </a>
        </li>
        <li>
            <a href="/11.1/tejia" target="_blank">
                <img src="http://www.jyeyw.com/111/nav/tj.png" alt="">
            </a>
        </li>
        <li>
            <a href="/cxhd/jpmz" target="_blank">
                <img src="http://www.jyeyw.com/111/nav/mz.png" alt="">
            </a>
        </li>
        <li>
            <a href="/11.1/choujiang" target="_blank">
                <img src="http://www.jyeyw.com/111/nav/cj.png" alt="">
            </a>
        </li>
    </ul>
    <div class="go-top">
        <img src="http://www.jyeyw.com/111/nav/go-top.png">
    </div>
</div>
<script>
    $('.go-top img').click(function(){
        $("body,html").animate({
            "scrollTop":0
        },300)
    })
</script>
<style>
    .side-nav {
        /* display: none; */
        width: 190px;
        position: fixed;
        right: 40px;
        top: 50px;
        z-index: 10;
        padding: 180px 0 80px 0;
        background: url('http://www.jyeyw.com/111/nav/bg.png');
        background-size: 100%;
        background-repeat: no-repeat;
    }

    .side-nav ul {
        padding: 0 10px;
    }

    .side-nav ul>li {
        width: 100%;
        margin-top: 10px;
    }

    .side-nav ul>li img {
        width: 100%;
    }

    .side-nav .go-top {
        width: 100%;
    }

    .side-nav .go-top img {
        width: 100%;
        cursor: pointer;
    }
</style>