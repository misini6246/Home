@extends('layout.body')
@section('links')
    <link href="{{path('/css/base.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('/css/member2.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('/css/my_buy2.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('css/index2.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('css/new-common.css')}}" rel="stylesheet" type="text/css" />

    <script type="text/javascript" src="{{path('/js/common.js')}}"></script>

    <script type="text/javascript" src="{{path('/js/member.js')}}"></script>

    <script type="text/javascript" src="{{path('/js/my_buy.js')}}"></script>

@endsection
@section('content')
    @include('layout.page_header')
    @include('layout.nav')
    <div class="main fn_clear">
        <div class="top"><span class="title">我的药易购</span> <a>>　<span>我的账户</span> </a> <a href="{{route('user.buyList')}}" class="end">>　<span>我的求购</span></a> </div>
        @include('layout.user_menu')
        <div class="main_right1">
            <div class="top_title">
                <h3>{{$submitText}}</h3>
                <span class="ico"></span>
                <p class="right_box"><a href="{{route('user.buyList')}}" style="color: #39a817">查看求购</a></p>
            </div>

            <div class="content_box">
                <form method="post" action="{{route('user.buyCreate')}}" name="formbuy">
                    {!! csrf_field() !!}
                    <table>
                        <tr>
                            <td class="title">会员账号：</td>
                            <td>{{$user->user_name}}<input type="hidden" value="{{$user->user_name}}" name="buy_username"></td>
                        </tr>
                        <tr>
                            <td class="title">联系人：</td>
                            <td><input type="text" value="{{$buy->buy_name or old('buy_name')}}" name="buy_name" id="buy_name"> <span class="ico">*{{$errors->first('buy_name')}}</span> </td>
                        </tr>
                        <tr>
                            <td class="title">联系电话：</td>
                            <td><input type="text" value="{{$buy->buy_tel or old('buy_tel')}}" name="buy_tel" id="buy_tel"> <span class="ico">*{{$errors->first('buy_tel')}}</span> </td>
                        </tr>
                        <tr>
                            <td class="title">求购药品：</td>
                            <td><input type="text" value="{{$buy->buy_goods or old('buy_goods')}}" name="buy_goods" id="buy_goods"> <span class="ico">*{{$errors->first('buy_goods')}}</span> </td>
                        </tr>
                        <tr>
                            <td class="title">生产厂家：</td>
                            <td><input type="text" value="{{$buy->product_name or old('product_name')}}" id="product_name" name="product_name"> <span class="ico">*{{$errors->first('product_name')}}</span> </td>
                        </tr>
                        <tr>
                            <td class="title">药品规格：</td>
                            <td><input type="text" value="{{$buy->buy_spec or old('buy_spec')}}" name="buy_spec" id="buy_spec"> <span class="ico">*{{$errors->first('buy_spec')}}</span> </td>
                        </tr>
                        <tr>
                            <td class="title">求购数量：</td>
                            <td><input type="text" value="{{$buy->buy_number or old('buy_number')}}" name="buy_number" id="buy_number"> <span class="ico">*{{$errors->first('buy_number')}}</span> </td>
                        </tr>
                        <tr>
                            <td class="title">求购价格：</td>
                            <td><input type="text" value="{{$buy->buy_price or old('buy_price')}}" name="buy_price" id="buy_price"> <span class="ico">*{{$errors->first('buy_price')}}</span> </td>
                        </tr>
                        <tr>
                            <td class="title">求购有效期：</td>
                            <td><input type="text" value="{{$buy->buy_time or old('buy_time')}}" name="buy_time" id="buy_time"> <span class="ico">*  注：</span>填写格式为 2014.01.14</td>
                        </tr>
                        {!! $errors->first('buy_time','<tr><td></td><td style="color: red">*:message</td></tr>') !!}
                        <tr>
                            <td class="title"> <span class="msg">留言：</span></td>
                            <td><textarea id="message" name="message" cols="30" rows="10">{{$buy->message or ''}}</textarea></td>
                        </tr>
                        <tr>
                            <td colspan="2"  class="submit">
                                <input type="hidden" value="{{$buy->buy_id or 0}}" name="buy_id">
                                <input type="hidden" value="act_edit_buy" name="act">
                                <input type="submit" value="{{$submitText}}" class="btn"/>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
    @include('layout.page_footer')
@endsection
