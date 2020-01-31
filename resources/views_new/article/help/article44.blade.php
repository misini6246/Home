@extends('layouts.body')
@section('links')
    <link rel="stylesheet" type="text/css" href="{{path('css/index/new_common.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{path('css/new/help_common.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{path('css/new/help_ts.css')}}"/>
@endsection
@section('content')
    @include('article.header')
    @include('article.help_nav')
    <div id="help_title" class="container">
        <div class="container_box">
            <ul class="help_title_list">
                @foreach($articles as $k=>$v)
                    <li @if($k==$article_id)class="active"@endif><a
                                href="{{route('xin.help',['cat_id'=>$cat_id,'article_id'=>$k])}}">{{$v}}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div id="content" class="container">
        <div class="container_box">
            <div class="help_title">投诉与建议</div>
            <p class="content_title">
                如果您在使用药易购网上商城的过程中出现问题，给您购物带来不便，或者您对我们的服务有更好的建议，请通过以下方式告诉我们。我们真诚地希望听到您的心声。全国客服热线：<span>400-602-8262</span>；投诉电话：<span>15208485597</span>。
            </p>
            <div class="fklx">
						<span class="fklx_title">
						<span>*</span>反馈类型：
						</span>
                <ul class="fklx_list">
                    <li class="active" data-type="1">
								<span class="choose_box">
								<span>√</span>
								</span>
                        药品咨询
                    </li>
                    <li data-type="6">
								<span class="choose_box">
								<span>√</span>
								</span>
                        功能界面
                    </li>
                    <li data-type="7">
								<span class="choose_box">
								<span>√</span>
								</span>
                        物流问题
                    </li>
                    <li data-type="3">
								<span class="choose_box">
								<span>√</span>
								</span>
                        服务投诉
                    </li>
                    <li data-type="8">
								<span class="choose_box">
								<span>√</span>
								</span>
                        其他问题
                    </li>
                </ul>
            </div>
            <div class="fknr">
						<span class="fklx_title">
						<span>*</span>反馈内容：
						</span>
                <textarea id="msg_content"
                          placeholder="您的意见对我们非常重要，我们会不断的优化和改善，努力为您带来更好的体验，如涉及具体页面请附上相关链接或在下方添加图片，谢谢！"></textarea>
            </div>
            {{--<div class="fklx">--}}
            {{--<span class="fklx_title">--}}
            {{--附件：--}}
            {{--</span>--}}
            {{--<input type="file" onchange="previewImage(this)" id="up_img"/><div id="preview"><img id="imghead"></div>--}}
            {{--</div>--}}
            <div class="fklx">
						<span class="fklx_title">
						<span>*</span>联系方式：
						</span>
                <input id="connect_info" name="connect_info" type="text" placeholder="输入您的手机号码或邮箱地址"/>
            </div>
            <div class="btn">
                <input type="button" value="点击提交" onclick="AddAdvice()"/>
            </div>

            <p class="tishi">
                温馨提示：如果您是在我们网站上没有找到您需要的药品，可以到“
                <a href="#">求购专区</a>”发布求购信息，我们也会第一时间给您反馈。
            </p>
        </div>
    </div>
    @include('article.footer')
    <script>
        $(function () {
            $('.fklx_list li').click(function () {
                $(this).addClass('active').siblings('li').removeClass('active');
            })
//            window.onload = function () {
//                new uploadPreview({
//                    UpBtn: "up_img",
//                    DivShow: "preview",
//                    ImgShow: "imghead"
//                });
//            }
        })
        function AddAdvice() {
            var content = $('#msg_content').val();
            var rule = /^\s*$/;
            if (content.length < 10 || rule.test(content)) {
                layer.msg('请尽量填写10-1000字，以便我们及时给您回复', {icon: 2});
                return false;
            }
            var connect_info = $('#connect_info').val();
            var reg = /^0?1[3|4|5|8][0-9]\d{8}$/;
            var emg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/;
            if (!reg.test(connect_info) && !emg.test(connect_info)) {
                layer.msg('电话/邮箱至少填写一项', {icon: 2});
                return false;
            }
            var type = $('.fklx_list .active').data('type');
            $.ajax({
                url: '/xin/fankui',
                data: {
                    type: type,
                    connect_info: connect_info,
                    msg_content: content
                },
                type: 'post',
                dataType: 'json',
                success: function (data) {
                    if (data.error == 0) {
                        $("#msg_content").val('');
                        $("#connect_info").val('');
                    }
                    layer.msg(data.msg, {icon: data.error + 1});
                }
            });
        }
    </script>
@endsection
