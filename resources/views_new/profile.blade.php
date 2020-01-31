@extends('layout.body')
@section('links')
    <link href="{{path('new/css/base.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('/css/member2.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('/css/user_message2.css')}}" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="{{path('/js/common.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/member.js')}}"></script>
@endsection
@section('content')
    @include('common.header')
    @include('common.nav')
    <div class="main fn_clear">
        <div class="top"><span class="title">我的太星医药网</span> <a>>　<span>我的账户</span> </a> <a
                    href="{{route('user.profile')}}" class="end">>　<span> 用户信息</span></a></div>
        @include('layout.user_menu')
        <div class="main_right1">
            <div class="top_title">
                <h3>用户信息</h3>
                <span class="ico"></span>
            </div>
            <div class="content_box">
                <h4>用户信息</h4>
                <div class="content">
                    <form name="formEdit" action="{{route('user.infoUpdate')}}" method="post"
                          enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        <table>
                            <tr>
                                <td class="title">出生日期：</td>
                                <td>
                                    <select name="year">
                                        {!! $year !!}
                                    </select>&nbsp;
                                    <select name="month">
                                        {!! $month !!}
                                    </select>&nbsp;
                                    <select name="day">
                                        {!! $day !!}
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="title">性别：</td>
                                <td>
                                    <input type="radio" name="sex" value="0"
                                           @if($user->sex==0)checked="checked"@endif />保密
                                    <input type="radio" name="sex" value="1"
                                           @if($user->sex==1)checked="checked"@endif />男
                                    <input type="radio" name="sex" value="2"
                                           @if($user->sex==2)checked="checked"@endif />女
                                </td>

                            </tr>

                            <tr>
                                <td class="title">电子邮件地址：</td>
                                <td><input name="email" type="text" value="{{$user->email}}" size="25"
                                           class="com email"/> <span class="xinghao">*</span></td>
                            </tr>
                            <tr>
                                <td class="title">上传头像：</td>
                                <td style="line-height: initial;"><p><input type="file" name="ls_file"/><input
                                                type="hidden" name="ls_file1"
                                                value="{{$user->ls_file}}"/></p> <span
                                            class="file_ico"><img
                                                src="@if($user->ls_file) {{path('images/yes.gif')}} @else {{path('images/no.gif')}} @endif"/></span>
                                </td>
                            </tr>

                            {{--{foreach from=$extend_info_list item=field}--}}
                            {{--<!-- {if $field.id eq 6} -->--}}
                            {{--<tr>--}}
                            {{--<td class="title">{$lang.passwd_question}：</td>--}}
                            {{--<td >--}}
                            {{--<select name='sel_question'>--}}
                            {{--<option value='0'>{$lang.sel_question}</option>--}}
                            {{--{html_options options=$passwd_questions selected=$profile.passwd_question}--}}
                            {{--</select>--}}
                            {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                            {{--<td class="title">{$lang.passwd_answer}：</td>--}}
                            {{--<td ><input name="passwd_answer" type="text" class="com" maxlengt='20' value="{$profile.passwd_answer}"/><!-- {if $field.is_need} --><span class="tip_ico2">*</span><!-- {/if} --></td>--}}
                            {{--</tr>--}}
                            {{--<!-- {else} -->--}}
                            {{--{if $field.id eq 1}--}}
                            <tr>
                                <td class="title">企业名称：</td>
                                <td><input name="msn" type="text" class="com" readonly value="{{$user->msn}}"/><span
                                            class="txt">如需更改请联系客服人员！</span></td>
                            </tr>
                            <tr>
                                <td class="title">QQ：</td>
                                <td><input name="qq" type="text" class="com" value="{{$user->qq}}"/></td>
                            </tr>
                            <tr>
                                <td class="title">联系电话：</td>
                                <td><input name="mobile_phone" type="text" class="com" value="{{$user->mobile_phone}}"/>
                                </td>
                            </tr>
                            {{--{else}--}}
                            {{--<tr>--}}
                            {{--<td class="title">{$field.reg_field_name}：</td>--}}
                            {{--<td ><input name="extend_field{$field.id}" type="text" class="com" value="{$field.content}"/> <!-- {if $field.is_need} --><span class="tip_ico2">*</span><!-- {/if} --></td>--}}
                            {{--</tr>--}}
                            {{--{/if}--}}
                            {{--<!-- {/if} -->--}}
                            {{--{/foreach}--}}
                            <tr>
                                <td colspan="2" class="btn1">
                                    <input name="submit" type="submit" value="确认修改" class="revise"/>
                                    <input name="act" type="hidden" value="act_edit_profile"/>
                                </td>
                            </tr>
                        </table>
                    </form>
                    <form name="formPassword" action="{{route('user.setPwd')}}" method="post">
                        {!! csrf_field() !!}
                        <table class="table2">
                            <tr>
                                <td class="title">原密码：</td>
                                <td><input name="old_password" type="password"
                                           class="com ypsw"/>&nbsp;{!! $errors->first('old_password','<span style="color: red">:message</span>') !!}
                                </td>
                            </tr>
                            <tr>
                                <td class="title">新密码：</td>
                                <td><input name="password" type="password"
                                           class="com npsw"/>&nbsp;{!! $errors->first('password','<span style="color: red">:message</span>') !!}
                                </td>
                            </tr>

                            <tr>
                                <td class="title">确认密码：</td>
                                <td><input name="password_confirmation" type="password" class="com cpsw"/></td>
                            </tr>
                            <tr>
                                <td colspan="2" class="btn1 btn2">
                                    <input name="submit" type="submit" class="revise revise2" value="确认修改"/>
                                    <input name="act" type="hidden" value="act_edit_password"/>
                                </td>
                            </tr>
                        </table>

                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('common.footer')
@endsection
