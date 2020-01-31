@extends('layouts.app')
@section('links')
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>求购专区</title>
    <link rel="stylesheet" type="text/css" href="/index/common/css/com-css.css" />
    <link rel="stylesheet" type="text/css" href="/qgzq/buy.css"/>

    <script src="/index/common/js/jQuery-1.8.3.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/index/common/js/com-js.js" type="text/javascript" charset="utf-8"></script>
@endsection
@section('content')
@include('layouts.header')
@include('layouts.search')
@include('layouts.nav')

<div class="main fn_clear">
    <div class="banner">
        @foreach($imgList as $k=>$v)
        @if($k==0)
        <a href="{{$v->ad_link}}" target="_blank"><img src="{{$v->ad_code}}" alt="{{$v->ad_name}}"/></a>
        @endif
        @endforeach
    </div>
    <div class="main_left">
        <ul class="nav_list">
            <li class="on"><a href="requirement.php" >求购专区</a></li>
        </ul>
        <form id="contactForm"  enctype="multipart/form-data" method="post" action="{{route('requirement.store')}}">
            {!! csrf_field() !!}
            <table>
                <tr>
                    <th colspan="4">发布求购信息 <span class="txt">(会员登录后才能发布)</span></th>
                </tr>
                <tr>
                    <td>
                        <p>联系人： {!! $errors->first('buy_name',"<span class='ico'>:message</span>") !!}</p>
                        <input type="text" name="buy_name" value="{{old('buy_name')}}" class="text contact" /> <span class="ico">*</span>
                    </td>
                    <td>
                        <p>联系电话： {!! $errors->first('buy_tel',"<span class='ico'>:message</span>") !!}</p>
                        <input type="text" class="text phone" name="buy_tel" value="{{old('buy_tel')}}" /> <span class="ico">*</span>
                    </td>
                    <td>
                        <p>求购药品：    {!! $errors->first('buy_goods',"<span class='ico'>:message</span>") !!}</p>
                        <input type="text" class="text drug" name="buy_goods" value="{{old('buy_goods')}}" /> <span class="ico">*</span>
                    </td>
                    <td>
                        <p>生产厂家：{!! $errors->first('product_name',"<span class='ico'>:message</span>") !!}</p>
                        <input type="text" class="text factory" name="product_name" value="{{old('product_name')}}" /> <span class="ico">*</span>
                    </td>

                </tr>
                <tr>
                    <td>
                        <p>药品规格：   {!! $errors->first('buy_spec',"<span class='ico'>:message</span>") !!}</p>
                        <input type="text" class="text norms" name="buy_spec" value="{{old('buy_spec')}}" /> <span class="ico">*</span>
                    </td>
                    <td>
                        <p>求购数量： {!! $errors->first('buy_number',"<span class='ico'>:message</span>") !!}</p>
                        <input type="text" class="text number" name="buy_number" value="{{old('buy_number')}}" /> <span class="ico">*</span>
                    </td>
                    <td>
                        <p>求购价格：    {!! $errors->first('buy_price',"<span class='ico'>:message</span>") !!}</p>
                        <input type="text" class="text price" name="buy_price" value="{{old('buy_price')}}" /> <span class="ico">*</span>
                    </td>
                    <td>
                        <p>求购有效期：{!! $errors->first('buy_time',"<span class='ico'>:message</span>") !!}</p>
                        <input type="text" class="text time" name="buy_time" value="{{old('buy_time')}}" /> <span class="ico">*</span>
                    </td>

                </tr>
                <tr>
                    <td colspan="4">
                        <p>留言：</p>
                        <textarea name="message" id="message" class="message">{{old('message')}}</textarea> <span class="ico">*</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" class="end">
                        <input type="submit" id="J_submit" value="提   交" class="submit"/>
                        <input type="hidden" name="act" value="add_requirement" />
                    </td>
                </tr>

            </table>

        </form>

        <ul class="msg_content">
            @foreach($pages as $v)
            <li>
                <p class="title">
                    <span class="title">会员：</span>
                    <span class="name">{{$v->buy_username}}</span>
                    <span class="date">{{date('Y-m-d H:i:s',$v->buy_addtime)}}</span>
                </p>
                <p class="msg">[求购药品信息]</p>
                <div class="list">
                    <span class="msg_title">药品名称：</span><span class="msg_text">{{$v->buy_goods}}</span>
                    <span class="msg_title">生产厂家：</span><span class="msg_text">{{$v->product_name}}</span>
                    <span class="msg_title">规格：</span><span class="msg_text">{{$v->buy_spec}}</span>
                    <span class="msg_title">有效期：</span><span class="msg_text">{{$v->buy_time}}</span>
                    <span class="msg_title">数量：</span><span class="msg_text">{{$v->buy_number}}</span>
                    <span class="msg_title">价格：</span><span class="msg_text">{{formated_price($v->buy_price)}}</span>
                </div>
                <p>
                    <span class="msg_title">求购留言：</span><span class="msg_text">{{$v->message}}</span>

                </p>
                @if($v->replay!='')
                <p class="reply"> <span class="msg_name">今瑜e药网回复：</span>{{$v->replay}}</p>
                @endif
            </li>
            @endforeach
            <div style="float: right">
            @include('layout.pagesUser')
            </div>
        </ul>


    </div>
    {{--<div class="main_right">--}}
        {{--<ul>--}}
            {{--@if($imgOne)--}}
            {{--<li>--}}
                {{--<a href="{{$imgOne->ad_linke or ''}}">--}}
                    {{--<img src="{{$imgOne->ad_code or ''}}"/>--}}
                {{--</a>--}}
            {{--</li>--}}
            {{--@endif--}}
            {{--@if($imgTwo)--}}
            {{--<li>--}}
                {{--<a href="{{$imgTwo->ad_linke or ''}}">--}}
                    {{--<img src="{{$imgTwo->ad_code or ''}}"/>--}}
                {{--</a>--}}
            {{--</li>--}}
            {{--@endif--}}
            {{--@if($imgThree)--}}
            {{--<li>--}}
                {{--<a href="{{$imgThree->ad_linke or ''}}">--}}
                    {{--<img src="{{$imgThree->ad_code or ''}}"/>--}}
                {{--</a>--}}
            {{--</li>--}}
            {{--@endif--}}
        {{--</ul>--}}
    {{--</div>--}}

</div>


@include('layouts.new_footer')
@endsection
