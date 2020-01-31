@extends('layout.body')
@section('links')
    <link href="{{path('/css/base.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('/css/buy.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('css/index2.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('css/new-common.css')}}" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{{path('/js/goods_list.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/common.js')}}"></script>
@endsection
@section('content')
@include('layout.page_header')
@include('layout.nav')
<div class="main fn_clear">
    <p class="banner">
        @foreach($imgList as $k=>$v)
        @if($k==0)
        <a href="{{$v->ad_link}}" target="_blank"><img src="{{$v->ad_code}}" alt="{{$v->ad_name}}"/></a>
        @endif
        @endforeach
    </p>
    <div class="main_left">
        <ul class="nav_list">
            <li><a href="javascript:;">投票专区</a></li>
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
                <p class="reply"> <span class="msg_name">药易购回复：</span>{{$v->replay}}</p>
                @endif
            </li>
            @endforeach
            <div style="float: right">
            @include('layout.pagesUser')
            </div>
        </ul>


    </div>
    <div class="main_right">
        <ul>
            @if($imgOne)
            <li>
                <a href="{{$imgOne->ad_linke or ''}}">
                    <img src="{{$imgOne->ad_code or ''}}"/>
                </a>
            </li>
            @endif
            @if($imgTwo)
            <li>
                <a href="{{$imgTwo->ad_linke or ''}}">
                    <img src="{{$imgTwo->ad_code or ''}}"/>
                </a>
            </li>
            @endif
            @if($imgThree)
            <li>
                <a href="{{$imgThree->ad_linke or ''}}">
                    <img src="{{$imgThree->ad_code or ''}}"/>
                </a>
            </li>
            @endif
        </ul>
    </div>

</div>

<script type="text/javascript">
//    $(function() {
//        $('#J_submit').click(function(event) {
//            event.preventDefault() ;
//            var submiturl = "requirement.php" ;
//            var formdata = $(this).parents('form').serialize() ;
//            $.ajax({
//                type: "POST" ,
//                dataType: 'json' ,
//                url: submiturl ,
//                data: formdata ,
//                success: function(data) {
//                    if(data.error != undefined) {
//                        ui.box.error(data.error, 2000) ;
//                        return ;
//                    }
//                    ui.box.success(data.msg, 2000) ;
//                    $('#contactForm input[type=text]').val('') ;
//                    $('#message').val('') ;
//                    return ;
//                }
//            }) ;
//        }) ;
//    }) ;
</script>

@include('layout.page_footer')
@endsection
