@extends('layout.body')
@section('links')
    <link href="{{path('/css/base.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('/css/member2.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('/css/my_msg2.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('css/index2.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('css/new-common.css')}}" rel="stylesheet" type="text/css" />

    <script type="text/javascript" src="{{path('/js/common.js')}}"></script>

    <script type="text/javascript" src="{{path('/js/member.js')}}"></script>

@endsection
@section('content')
    @include('layout.page_header')
    @include('layout.nav')
    <div class="main fn_clear">

        <div class="top"><span class="title">我的太星医药网</span> <a>>　<span>我的账户</span> </a> <a href="{{route('user.messageList')}}" class="end">>　<span>我的留言</span></a> </div>

        @include('layout.user_menu')

        <div class="main_right1">
            <div class="top_title">
                <h3>用户信息</h3>
                <span class="ico"></span>
            </div>
            <!-- *我的留言板 start-->
            @if(count($pages)>0)
            <div class="content_box fn_clear">
                <div class="content_box" style="margin-top: 0px;border: none;">
                    <div class="message-box">
                        <h4>我的留言板</h4>
                        @foreach($pages as $v)
                            <dl class="msg-dl">
                                <dt>{{date('Y-m-d H:i:s',$v->msg_time)}}</dt>
                                <dd>
                                    <p class="del"><a href="{{route('user.msgDelete',['id'=>$v->msg_id])}}" title="删除" onclick="if (!confirm('你确实要彻底删除这条留言吗?')) return false;">删除</a></p>
                                    <p class="msg-txt"> <span class="title">{{$msg_type[$v->msg_type]}}:</span>
                                        @if(!empty($v->msg_content))
                                            {{$v->msg_content}}
                                        @endif
                                    </p>
                                    {{--@if(!empty($v->message_img))--}}
                                        {{--<p class="check"> <a href="{{path('uploads/feedback')}}/{{$v->message_img}}">查看上传的文件</a></p>--}}
                                    {{--@endif--}}
                                </dd>

                            </dl>
                        @endforeach
                    <div class="page">
                        @if($pages->lastPage()>0)
                            {!! pagesView($pages->currentPage(),$pages->lastPage(),3,3,['url'=>'user.messageList']) !!}
                        @endif
                    </div>
                    </div>
                </div>
            </div>

                @endif
                <!--#我的留言板 end-->
            <form action="{{route('user.msgCreate')}}" enctype="multipart/form-data" name="formMsg" class="content_box" method="post" >
                {!! csrf_field() !!}
                <h4>我的留言</h4>
                <div class="content">
                    <table>
                        <tr>
                            <td class="title"><span >留言类型：</span></td>
                            <td>
                                <label><input name="msg_type" type="radio" value="0"  checked="checked" /> {{$msg_type[0]}} </label>
                                <label><input name="msg_type" type="radio" value="1" /> {{$msg_type[1]}} </label>
                                <label><input name="msg_type" type="radio" value="2" /> {{$msg_type[2]}} </label>
                                <label><input name="msg_type" type="radio" value="3" /> {{$msg_type[3]}} </label>
                                <label><input name="msg_type" type="radio" value="4" /> {{$msg_type[4]}} </label>
                            </td>
                        </tr>
                        <tr>
                            <td  class="title"><span>主题：</span></td>
                            <td><input name="msg_title" type="text" class="text" id="text"/></td>
                        </tr>
                        <tr>
                            <td class="title"><span class="msg_title">留言内容：</span></td>
                            <td><textarea name="msg_content" id="msg" ></textarea></td>
                        </tr>
                        {{--<tr>--}}

                            {{--<td  class="title"><span>上传文件：</span></td>--}}
                            {{--<td><p class="file_box"><input name="message_img" type="file" class="file"/></p></td>--}}
                        {{--</tr>--}}
                        <tr>
                            <td colspan="2"><input type="submit" value="提　交" class="submit"/></td>
                            <input type="hidden" name="act" value="act_add_message" />
                            <input type="hidden" id="errors_alert" value="msg_type&msg_title&msg_content"/>
                        </tr>
                        {{--<tr>--}}
                            {{--<td colspan="2" class="tip_box">--}}
                                {{--<p><font style="color: #FF6102">小提示：</font></p>--}}
                                {{--<p>您可以上传以下格式的文件：<br>gif、jpg、png、word、excel、txt、zip、ppt、pdf</p>--}}
                            {{--</td>--}}
                        {{--</tr>--}}
                    </table>
                </div>
            </form>
        </div>
    </div>
    <script type="text/javascript">
        $(function(){
            {{--var msg = '';--}}
            {{--var tags = $('#errors_alert').val();--}}
            {{--tags = tags.split('&');--}}
            {{--for(var i=0;i<tags.length;i++){--}}
                {{--var value = '{{$errors->first('"+msg+"')}}';--}}
                {{--alert(value)--}}
            {{--}--}}
            var msg = '';
            var msg_title = '{{$errors->first('msg_title')}}';
            var msg_type = '{{$errors->first('msg_type')}}';
            var msg_content = '{{$errors->first('msg_content')}}';
            if(msg_type!=''){
                msg += '留言类型'+msg_type+'\n';
            }
            if(msg_title!=''){
                msg += '主题'+msg_title+'\n';
            }
            if(msg_content!=''){
                msg += '留言内容'+msg_content+'\n';
            }
            if(msg!='') {
                alert(msg);
            }
        })
    </script>
    @include('layout.page_footer')
@endsection
