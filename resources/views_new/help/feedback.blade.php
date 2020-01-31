@extends('layouts.app')
@section('links')
    @include('layout.token')
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>帮助中心-联系我们-意见反馈</title>
    <link rel="stylesheet" type="text/css" href="/index/common/css/com-css.css" />
    <link rel="stylesheet" type="text/css" href="/help/bzzx.css"/>
    <link rel="stylesheet" type="text/css" href="/help/yhfk.css"/>
    @include('common.ajax_set')

@endsection
@section('content')
    <div class="big-container">
        <!--头部-->
        @include('layouts.header')
        <!--/头部-->

        <!--顶部-->
        <div class="top-box">
            <div class="box-container">
                <div class="left">
                    <a href="/"><img src="/index/img/logo.jpg"></a>
                    <div class="line"></div>
                    帮助中心
                </div>
                <div class="option">
                    @foreach($help_nav as $n)
                        <div class="option-item"><a href="http://47.107.103.86/article?id={{ $n->cat_id }}">{{ $n->cat_name }}</a></div>
                    @endforeach
                        <div class="option-item cur"><a href="/feedback">用户反馈</a></div>
                </div>
            </div>
        </div>
        <!--/顶部-->

        <!--主体内容-->
        <div class="main-box">
            <div class="box-container">
                <ul class="nav">
                    <li class="nav-item cur">{{ $title }}</li>
                </ul>
                <div class="main_right">
                    <div class="feed">
                        <h3 style="font-size: 20px;">您对重庆今瑜e药网有任何意见和建议，或在使用过程中遇到问题，请在本页面反馈。我们会每天关注您的反馈，不断优化产品，为您提供更好的服务！</h3>
                        <div class="form-box">
                            <form action="http://47.107.103.86/user/feedback" method="post">
                                <input type="hidden" name="_token" value="vATzGx33lpqN7AMOdZ50F5lkSNqJ3iAM31YcBoAk">
                                <div class="feed-cs" id="radio">
                                    您反馈类型：
                                    <label><input value="1" name="type" checked="checked" type="radio"><span>药品咨询</span></label>
                                    <label><input value="2" name="type" type="radio"><span>首页意见建议</span></label>
                                    <label><input value="3" name="type" type="radio"><span>服务投诉</span></label>
                                    <label><input value="4" name="type" type="radio"><span>服务表扬</span></label>
                                    <label><input value="5" name="type" type="radio"><span>问题报告</span></label>
                                </div>
                                <div class="feed-email"><label>手机/邮箱：</label><input id="celORmail" name="connect_info" value="" type="text">
                                    <p class="err">电话/邮箱至少填写一项</p>
                                </div>
                                <div class="feed-text">
                                    <span>内容：</span>
                                    <textarea maxlength="1000" class="fetext" id="content" style="color: rgb(195, 195, 195);">请尽量填写10-1000字，以便我们及时给您回复</textarea>
                                    <div class="sub-box">
                                        <p class="err">请至少填写10字以上</p>
                                        <input value="提交" class="sub" onclick="AddAdvice();" type="button">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/主体内容-->

        <!--footer-->
    @include('layouts.new_footer')
        <script type="text/javascript">
            $(document).ready(function() {
                $('.feed-email input').blur(function() {
                    var reg = /^0?1[3|4|5|8][0-9]\d{8}$/;
                    var emg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/;
                    if(reg.test($(this).val()) || emg.test($(this).val())) {} else {
                        $('.feed-email .err').css('visibility', 'visible');
                    }
                    $('.sub-box .err').css('visibility', 'hidden');
                });
                $('.feed-email input').focus(function() {
                    $('.feed-email .err').css('visibility', 'hidden');
                    $('.sub-box .err').css('visibility', 'hidden');
                });
                $('.fetext').blur(function() {
                    if($(this).val().length < 10) {
                        $('.sub-box .err').css('visibility', 'visible');
                    }
                    var rule = /^\s*$/;
                    if(rule.test($(this).val())) {
                        $(this).val('请尽量填写10-1000字，以便我们及时给您回复');
                        $(this).css('color', '#c3c3c3');
                    } else {
                        $(this).css('color', '#333');
                    }
                });
                $('.fetext').focus(function() {
                    $('.sub-box .err').css('visibility', 'hidden');
                    if($(this).val() == '请尽量填写10-1000字，以便我们及时给您回复') {
                        $(this).val('');
                        $(this).css('color', '#333');
                    } else {
                        $(this).css('color', '#333');
                    }
                });
            });

            function AddAdvice() {
                if($(".form-box").html().indexOf("visible") < 0 && $("#celORmail").val() != "" && $("#content").val().indexOf("请尽量填写10-1000字") < 0) {
                    var celORmail = $("#celORmail").val();
                    $.ajax({
                        url: '/user/feedback',
                        data: {
                            type: $("#radio input:checked").val(),
                            connect_info: celORmail,
                            msg_content: $("#content").val()
                        },
                        dataType: 'json',
                        success: function(data) {
                            if(data.error == 0) {
                                $("#content").val('请尽量填写10-1000字，以便我们及时给您回复');
                                $("#content").css('color', '#c3c3c3');
                            }
                            add_tanchuc(data.msg)
                        }
                    });
                }
            }
        </script>
@endsection
