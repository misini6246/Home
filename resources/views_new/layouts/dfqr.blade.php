<style>
    * {
        padding: 0;
        margin: 0;
    }

    ul, li, ol {
        list-style: none;
    }

    body {
        height: 5000px;
    }

    .invitation_box {
        width: 600px;
        position: fixed;
        top: 50%;
        left: 50%;
        margin: -205px 0 0 -300px;
        z-index: 1002;
    }

    .invitation {
        width: 600px;
        height: 410px;
        /*background: url(http://images.hezongyy.com/images/index/querenhan_bg.jpg) no-repeat;*/
        position: relative;
        /*background-size: 100%;*/
    }

    .invitation .money_list {
        overflow: hidden;
        text-align: center;
        position: absolute;
        top: 241px;
        left: 215px;
    }

    .invitation .money_list li {
        width: 113px;
        float: left;
        height: 32px;
        line-height: 32px;
        color: #ff1919;
        font-size: 14px;
    }

    .invitation .company, .invitation .data {
        position: absolute;
        height: 16px;
        line-height: 16px;
        color: #ff1919;
        font-size: 12px;
    }

    .invitation .company {
        top: 350px;
        left: 100px;
    }

    .invitation .data {
        top: 367px;
        right: 48px;
    }

    .invitation .data span {
        display: inline-block;
        width: 35px;
        text-align: center;
    }

    .invitation .data span.years {
        margin-right: 10px;
    }

    .btn {
        text-align: center;
        width: 100%;
    }

    .btn input {
        height: 50px;
        line-height: 50px;
        border: none;
        cursor: pointer;
        border-radius: 30px;
        color: #fff;
        font-size: 32px;
        background: #3dbb2b;
        padding: 0 30px;
        outline: none;
        margin-top: 20px;
    }

    .btn input:first-child + input {
        margin-left: 50px;
        border: 1px solid #ccc;
        background: #fff;
        color: #666;
    }

    .invitation .close {
        width: 19px;
        height: 19px;
        position: absolute;
        right: 0px;
        top: 0;
        z-index: 2;
        cursor: pointer;
    }

    .zhezhao {
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        z-index: 1001;
        background: #000;
        opacity: 0.4;
        filter: alpha(opacity=40);
        display: block;
        position: fixed;
    }
</style>
<div class="invitation_box">
    <div class="invitation">
        {{--<span class="close"><img src="http://www.hezongyy.com/images/close.png?20180129225830" alt=""></span>--}}
        <img style="width: 100%;vertical-align: top;" src="{{get_img_path('images/index/querenhan_bg.jpg')}}">
        <ul class="money_list">
            <li>{{$user_dfqr->amount2017 or 0}}</li>
            <li>{{$user_dfqr->amount2016 or 0}}</li>
            <li>{{$user_dfqr->amount2015 or 0}}</li>
        </ul>
        <div class="company">{{$user->msn}}</div>
        <div class="data">
            <span class="years">{{date('Y')}}</span><span class="month">{{date('m')}}</span><span
                    class="day">{{date('d')}}</span>
        </div>
    </div>
    <div class="btn">
        <input onclick="dfqr(1)" type="button" value="确认并领取50元感恩劵"/>
        {{--<input onclick="dfqr(2)" type="button" value="确认授权但不愿接受电话回访"/>--}}
    </div>
</div>
<div class="zhezhao"></div>
<script>
//    $('.invitation .close').click(function () {
//        $('.invitation_box').hide();
//        $('.zhezhao').hide();
//    });
    function dfqr(type) {
        $.ajax({
            url: '{{route('yhq.dfqr')}}',
            type: 'post',
            data: {type: type},
            dataType: 'json',
            success: function (data) {
                $('.invitation_box').hide();
                $('.zhezhao').hide();
                layer.msg(data.msg, {icon: data.error + 1})
            }
        })
    }
</script>