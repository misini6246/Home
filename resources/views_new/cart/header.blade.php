<style>
    .top_box {
        background-color: #f1f1f1;
        height: 38px;
        border-bottom: 1px solid #e5e5e5;
        border-top: 1px solid #e5e5e5;
        color: #6c6c6c;
        line-height: 38px;
        position: relative;
        z-index: 997;
    }

    .top_box a {
        color: #6c6c6c;
        padding: 0 10px;
    }

    .top_box a.login {
        padding: 4px 10px;
        color: #fff;
        text-align: center;
        background-color: #3ebb2b;
        border-radius: 5px;
    }

    .top_box a.login:hover {
        background-color: #46d23c
    }

    .top_box a.reg {
        padding: 4px 5px;
        color: #6d6f6d;
        text-align: center;
    }

    .top_box a.reg:hover {
        color: #e70000
    }

    .top_box .separate {
        padding: 0 10px;
    }

    .top_box .separate2 {
        padding: 0 5px;
    }

    .top_box .username {
        color: #f08300;
        padding-right: 0;
    }

    .top_box .out {
        color: #717170;
        padding: 0 1px 0 3px;
    }

    .top_left .my_name {
        padding: 4px 10px;
        color: #fff;
        text-align: center;
        background-color: #3ebb2b;
        border-radius: 5px;
    }

    .top_box a.my_name:hover {
        background-color: #46d23c
    }

    .top {
        width: 1200px;
        margin: 0 auto;
    }

    .top_left {
        float: left;
        color: #aeaeae;
    }

    .top_left span {
        color: #4c4b4b;
    }

    .top_left a {
        color: #e70000;
        padding: 0 10px;
    }

    .top_right {
        float: right;
        color: #aeaeae;
        position: relative;
        z-index: 9999;
    }

    .top_right a {
        padding: 0 10px;
        position: relative;
    }

    .top_right a:hover {
        color: #e70000;
    }

    .top_right .pic img {
        width: 113px;
        height: 121px;
    }

</style>
<div id="header" class="header">
    <div class="top_box">
        <div class="top">
            <div class="top_left">{!! member_info() !!}</div>
            <div class="top_right">
                <a target="_blank" href="{{route('user.collectList')}}">我的收藏</a>|<a href="{{route('index')}}">返回首页</a>
            </div>

        </div>
    </div>
</div>