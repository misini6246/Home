@extends('layouts.app')
@section('title')
<title>111扫货主场</title>
@endsection
@section('links')
<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="ie=edge" />
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<script src="/isIE/isIE.js"></script>
    <style>
        .list{
            background-image: url("/huodong/zhuchang/beijing.jpg");
            height:4695px;
            width: 100%;
        }
        .li-list{
            width: 100%;
            height: 923px;
        }
        .list ul li{
            width: 800px;
            height: 750px;
         margin: 0 auto;

        }

        .lianjie{
            height: 100px;
            display: block;
        }
    </style>
<style>
    body{
        background-color:#ffffff !important;
    }
    .load {
        margin:300px auto;

        width: 150px;

        text-align: center;
    }
    .load div{
        width: 30px;

        height: 30px;

        background-color:rgb(118,224,250);

        border-radius: 100%;

        display: inline-block;

        -webkit-animation: load 1.4s infinite ease-in-out;

        -webkit-animation-fill-mode: both;
    }

    .load .circle1 {
        -webkit-animation-delay: -0.32s;
    }
    .load .circle2 {
        -webkit-animation-delay: -0.16s;
    }
    @-webkit-keyframes load {

        0%, 80%, 100% { -webkit-transform: scale(0.0) }

        40% { -webkit-transform: scale(1.0) }

    }
    .big-container{
        background: #fff;
        display: none;
    }
</style>
@endsection
<div class="load">
    <div class="circle1"></div>
    <div class="circle2"></div>
    <div class="circle3"></div>
</div>
@section('content')

<div class="container">
        <div class="list">
            <div class="li-list"></div>
            <ul>

             <li>
                 <a href="http://www.jyeyw.com/11.1/miaosha" target="_blank">
                    <img style="width: 100%;margin: 132px auto 60px;" src="/huodong/zhuchang/zhuti1.jpg" alt="">
                </a>
                 <a class="lianjie" href="http://www.jyeyw.com/11.1/miaosha" target="_blank"></a>
             </li>

                <li>
                 <a href="http://www.jyeyw.com/yfhg" target="_blank"> <img style="width: 100% ;margin: 132px auto 60px;" src="/huodong/zhuchang/zhuti2.jpg" alt=""></a>
                    <a class="lianjie" href="http://www.jyeyw.com/yfhg" target="_blank"></a>
                </li>

               <li>
                   <a href="http://www.jyeyw.com/yhq" target="_blank">  <img style="width: 100%;margin: 132px auto 60px;" src="/huodong/zhuchang/zhuti3.jpg" alt=""></a>
                   <a class="lianjie" href="http://www.jyeyw.com/yhq" target="_blank"></a>
                    </li>
               <li>
                   <a href="http://www.jyeyw.com/11.1/tejia" target="_blank">  <img style="width: 100%;margin: 132px auto 60px;" src="/huodong/zhuchang/zhuti4.jpg" alt=""></a>
                   <a class="lianjie" href="http://www.jyeyw.com/11.1/tejia" target="_blank"></a>
                    </li>
                <li>
                    <a href="http://www.jyeyw.com/11.1/choujiang" target="_blank"> <img style="width: 100%;margin: 132px auto 60px;" src="/huodong/zhuchang/zhuti5.jpg" alt=""></a>
                    <a class="lianjie" href="http://www.jyeyw.com/11.1/choujiang" target="_blank"></a>

                    </li>
            </ul>
        </div>

</div>
{{--@include('layouts.new_footer')--}}
<script type="text/javascript">


    $(document).ready(function(){
        setTimeout(function () {
            $('.load').hide();
            $('.big-container').show();
        },1000)

        // $('.load').hide();
    });

    //返回顶部
        $('.btn-top').click(function(){
            $('html,body').animate({
                'scrollTop':0
            })
        });
        /**
         * searchEvent 初始化搜索功能
         * 参数1 获取数据方法
         * 参数2 回调方法
         * 参数3 按钮元素(执行搜索)(可选)
         * 参数4 搜索结果列表显示或隐藏的回调  返回true/false(可选)
         */
        $('.search').searchEvent(
            function(_target, _val) { //获取数据方法 val:搜索框内输入的值
                $.get('/ajax/cart/searchKey',{keyword:_val},function(data){
                    _target.searchDataShow(data, 'value')
                },'json');
                /**
                 * searchDataShow 将数据渲染至页面
                 * 参数1:数据数组
                 * 参数2:数据数组内下标名
                 */
            },
            function(val) { //回调方法 val:返回选中的值
                window.location.href = "http://www.jyeyw.com/category?keywords="+val+"&showi=0";
            },
            $('.search-btn')
        );
</script>

@endsection