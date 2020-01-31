@extends('common.index')
@section('links')
    <link href="{{path('new/css/base.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('/css/member2.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('css/new/xiaoxi.css')}}" rel="stylesheet" type="text/css"/>

    <script type="text/javascript" src="{{path('/js/common.js')}}"></script>

    <script type="text/javascript" src="{{path('/js/member.js')}}"></script>
    <style type="text/css">
        .listPageDiv {
            height: 50px;
            line-height: 50px;
            text-align: right;
            margin-top: 10px;
            float: right;
            width: 82%;
            color: #333333;
            font-family: "Microsoft YaHei"
        }

        .pageList {
            width: 600px;
            float: left;
        }

        .listPageDiv .p1 {
            border: 1px #CCC solid;
            padding: 4px 9px;
            margin: 3px;
            background-color: #efefef;
        }

        .listPageDiv .p_ok {
            color: #39a817;
            border: 0;
            background-color: #fff;
        }

        .listPageDiv a {
            color: #666;
        }

        .listPageDiv a:hover {
            text-decoration: underline;
            color: #39a817;
        }

        .listPageDiv .no {
            background-color: #fff;
        }

        .listPageDiv .no a {
            color: #cccccc;
        }

        .listPageDiv .page_inout {
            width: 24px;
            height: 24px;
            border: 1px solid #ccc;
            margin: 0 5px;
            line-height: 24px;
            text-align: center;
        }

        .listPageDiv .submit {
            cursor: pointer;
            width: 45px;
            height: 24px;
            line-height: 20px;
            background-color: #efefef;
            border: 1px solid #ccc;
            margin-right: 10px;
        }

        .listPageDiv .submit_input {
            padding-left: 10px;
            width: 180px;
            float: right;
            _margin-top: 10px;
        }
    </style>
@endsection
@section('content')
    @include('common.header')
    @include('common.nav')
    <div class="main fn_clear">

        <div class="top"><span class="title">我的药易购</span> <a>>　<span>消息中心</span> </a> <a
                    href="{{route('user.znx_list')}}" class="end">>　<span>我的消息</span></a></div>

        @include('layout.user_menu')
        <div class="main_right1">
            @if(count($pages)>0)
                <div class="main_box">
                    <div class="top_title">
                        <h3>我的消息</h3>
                        <span class="ico"></span>
                    </div>
                    <div class="title">
                        <div class="left">
                            <label>
                                <input style="margin-top: -3px;" type="checkbox" class="xwd check_all" name="item"
                                       onclick="check_all($(this))"> 全选
                            </label>
                        </div>
                        <div class="right delete" onclick="shanchu_msg()">
                            删除
                        </div>
                    </div>
                    @foreach($pages as $k=>$v)
                        <div id="msg{{$v->msg_id}}" class="ct @if($k==0) first_ct @endif">
                            <div class="biaoti">
                                <div class="left">
                                    <input type="checkbox" name="item" class="znx_id id_check"
                                           onclick="is_check('id_check','check_all')"
                                           znx_id="{{$v->msg_id}}"/>
                                    @if($v->status==0)
                                        <span class="weidu" id="weidu{{$v->msg_id}}">未读</span>
                                        <span class="yidu" id="yidu{{$v->msg_id}}" style="display: none;">已读</span>
                                        <span id="bt_wd{{$v->msg_id}}"
                                              class="biaoti_yidu">{{$v->message->title or ''}}</span>
                                        <span id="bt_yd{{$v->msg_id}}"
                                              style="display: none;">{{$v->message->title or ''}}</span>
                                    @else
                                        <span class="yidu">已读</span>
                                        <span>{{$v->message->title or ''}}</span>
                                    @endif
                                </div>
                                <span class="right">
            					{{$v->add_time->format('Y-m-d H:i')}}
            				</span>
                            </div>
                            <div class="text">
                                @if($v->status==0)
                                    <div id="read{{$v->msg_id}}" class="read" onclick="read_znx('{{$v->msg_id}}')">
                                        点击查看内容
                                    </div>
                                    <div id="hidden{{$v->msg_id}}" class="hidden">
                                        {!! $v->message->text !!}
                                    </div>
                                @else
                                    {!! $v->message->text !!}
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="bot" style="display: inline-block;">
                    <div class="left">
                        <label>
                            <input style="margin-top: -3px;" type="checkbox" class="xwd check_all" name="item"
                                   onclick="check_all($(this))"> 全选
                        </label>
                        <span class="delete" onclick="shanchu_msg()">删除</span>
                    </div>
                </div>
                @if($pages->lastPage()>0)
                    {!! pagesView($pages->currentPage(),$pages->lastPage(),3,3,[
                    'url'=>'user.znx_list',
                    'status'=>$status,
                    ]) !!}
                @endif
            @else
            <!--为空显示-->
                <div class="weikong">
                    <img src="{{get_img_path('images/kong.png')}}"/>
                </div>
            @endif
        </div>
    </div>
    <script type="text/javascript">
        var sjf = '{{$sjf or 0}}';
        if (sjf == 1) {
            layer.alert('成功获得500积分', {
                btn: ['查看积分管理', '确定'], //按钮
                icon: 1
            }, function (index) {
                location.href = '/jf/member';
            })
        }
        function read_znx(id) {
            $.ajax({
                url: '/user/yd_znx',
                data: {str: id},
                type: 'get',
                async: false,
                dataType: 'json',
                success: function (data) {
                    if (data.error == 0) {
                        $('#weidu' + id).hide();
                        $('#read' + id).hide();
                        $('#bt_wd' + id).hide();
                        $('#yidu' + id).show();
                        $('#hidden' + id).show();
                        $('#bt_yd' + id).show();
                        $('.msg_count').html(data.msg_count);
                        if (data.msg_count == 0) {
                            $('#msg_count_tishi').remove();
                        }
                    }
                }
            })
        }
        function check_all(obj) {
            $('.id_check').prop("checked", obj.prop('checked'));
            $('.check_all').prop("checked", obj.prop('checked'));
        }
        function is_check(obj, id) {
            var subBox = $("." + obj);
            $("." + id).prop("checked", subBox.length == $("." + obj + ":checked").length ? true : false);
        }
        function wd_znx(_obj) {
            var type = _obj.attr('checked');
            var url = "/user/znx_list";
            var status = 0;
            if (type == 'checked') {
                status = 1;
            }
            $.ajax({
                url: url,
                data: {status: status, full_page: 0},
                type: 'get',
                async: false,
                dataType: 'html',
                success: function (data) {
                    if (data) {
                        $('.zhanneixx-box').html(data);
                    }
                }
            })
        }
        function yd() {
            var str = '';
            $('.znx_id').each(function () {
                var type = $(this).prop('checked');
                if (type == true) {
                    var znx_id = parseInt($(this).attr('znx_id'));
                    str += znx_id + ',';
                }
            });
            if (str == '') {
                layer.alert('未选中任何信息', {icon: 2})
            } else {
                $.ajax({
                    url: '/user/yd_znx',
                    data: {str: str},
                    type: 'get',
                    async: false,
                    dataType: 'json',
                    success: function (data) {
                        if (data.error == 0) {
                            $('.znx_id').each(function () {
                                var type = $(this).prop('checked');
                                if (type == true) {
                                    var znx_id = parseInt($(this).attr('znx_id'));
                                    $('#status' + znx_id).prop('src', '{{get_img_path('images/msg-03.png')}}');
                                }
                            });
                        }
                        layer.msg(data.msg, {icon: data.error + 1});
                    }
                })
            }
        }
        function shanchu_msg() {
            var str = '';
            $('.znx_id').each(function () {
                var type = $(this).prop('checked');
                if (type == true) {
                    var znx_id = parseInt($(this).attr('znx_id'));
                    str += znx_id + ',';
                }
            });
            if (str == '') {
                layer.alert('未选中任何信息', {icon: 2})
            } else {
                layer.confirm('确定删除选中信息', function () {
                    $.ajax({
                        url: '/user/shanchu_znx',
                        data: {str: str},
                        type: 'get',
                        async: false,
                        dataType: 'json',
                        success: function (data) {
                            if (data.error == 0) {
                                $('.znx_id').each(function () {
                                    var type = $(this).prop('checked');
                                    if (type == true) {
                                        var znx_id = parseInt($(this).attr('znx_id'));
                                        $('#msg' + znx_id).remove();
                                    }
                                });
                            }
                            layer.msg(data.msg, {icon: data.error + 1});
                        }
                    })
                });
            }
        }
    </script>
    @include('common.footer')
@endsection
