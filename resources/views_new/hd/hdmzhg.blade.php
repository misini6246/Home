<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>119换购专区-{{config('services.web.title')}}</title>
</head>
<style>
    * {
        padding: 0;
        margin: 0;
        font-size: 12px;
        font-family: "微软雅黑";
        list-style: none;
        outline: none;
        box-sizing: border-box;
    }

    body {
        min-width: 1200px;
        background: #fba80e;
    }

    img {
        border: none;
    }

    #top {
        width: 100%;
        height: 420px;
        min-width: 1200px;
        background: url('{{get_img_path('images/hd/1109/hdmzhgtop_bg.jpg')}}') no-repeat scroll top center;
    }

    #container {
        width: 1200px;
        margin: 0 auto;
        padding-bottom: 140px;
    }

    #container ul {
        overflow: hidden;
        margin-left: -10px;
    }

    #container ul li {
        width: 292px;
        height: 502px;
        float: left;
        background: #fff;
        position: relative;
        margin: 20px 0 0 10px;
    }

    #container ul li .mz {
        position: absolute;
        top: -6px;
        left: 7px;
    }

    #container ul li .img_box {
        width: 292px;
        height: 292px;
        line-height: 292px;
        text-align: center;
        background: #fff;
    }

    #container ul li .img_box img {
        width: 100%;
    }

    #container ul li .text {
        background: #f0f0f0;
        height: 195px;
        width: 100%;
    }

    #container ul li .text p {
        padding: 0 8px;
    }

    #container ul li .text p.name {
        height: 38px;
        line-height: 38px;
        font-size: 16px;
        color: #c30a38;
        border-bottom: 1px solid #b9b9b9;
    }

    #container ul li .text p.company, #container ul li .text p.guige {
        color: #000;
        margin-top: 6px;
        vertical-align: middle;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    #container ul li .text p.zhu {
        font-size: 14px;
        color: #999999;
        margin-top: 9px;
        line-height: 23px;
    }

    #container ul li .text p.zhu span {
        font-size: 18px;
        color: #e00000;
    }

    #container ul li .text .btn {
        width: 276px;
        height: 34px;
        display: inline-block;
        background: url('{{get_img_path('images/hd/btn.png')}}') no-repeat;
        position: absolute;
        bottom: 10px;
        left: 8px;
    }

</style>
<body>
<div id="top"></div>
<div id="container">
    <ul>
        @foreach($result as $v)
            <li>
                <div class="img_box">
                    <a href="#"><img src="{{$v->goods_thumb}}"/></a>
                </div>
                <div class="text">
                    <p class="name">{{$v->goods->goods_name}}</p>
                    <p class="guige">{{$v->goods->ypgg or '暂无'}}</p>
                    <p class="company">厂家：{{$v->goods->product_name}}</p>
                    <p class="zhu">注：{{$v->message}}</p>
                    <a target="_blank" href="{{route('goods.index',['id'=>$v->goods_id])}}" class="btn"></a>
                </div>
            </li>
        @endforeach
        @include('miaosha.daohang')
    </ul>
</div>
</body>
</html>

