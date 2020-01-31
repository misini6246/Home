@extends('layouts.body')
@section('links')
    <link rel="stylesheet" type="text/css" href="{{path('css/index/new_common.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{path('css/new/help_common.css')}}"/>
    <style type="text/css">
        #content p {
            font-size: 16px;
            line-height: 30px;
            margin-top: 5px;
        }

        .content_title {
            font-weight: bold;
            margin-top: 20px!important;
        }

        .content_step {
            margin-top: 35px;
        }
    </style>
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
            <div class="help_title">退换货流程</div>
            <p>
                如客户需要进行退换货时，需按照以下流程进行办理：
            </p>
            <p>（1）客户需要退换货时请电话联系客服，并告知客服人员需退换的产品名称、退换数量、退换原因等详细情况。</p>
            <p>（2）客服人员将客户要求上报主管经理审批。</p>
            <p>（3）主管经理批准后由客服人员联系客户，请顾客将相关产品寄回。</p>
            <p>（4）仓库部门收到寄回产品后，检验是否符合退换货条件，</p>
            <p>（5）对于符合条件的退换货，由客服处理退款和换货；不符合条件的，药品直接原路返回，并由客服告知理由。</p>
            <p class="content_title">
                退换货注意事项
            </p>
            <p>1，请妥善保存商品外包装、配件以及相关赠品的完整性，退回完整商品，需注意商品未拆封未使用不影响二次销售退回；</p>
            <p>2，请在退回包裹内放入销售清单或者退货信息清单，其中注明订单号，姓名，联系方式和退货原因；</p>
            <p>3，电子发票在退货完成时将冲红。</p>
            <p>4，换货时如遇所换产品总价大于顾客剩余款项时按规定需补缴相应费用。如遇所换产品总价小于顾客剩余款项时按退款流程办理退款。</p>
        </div>
    </div>
    @include('article.footer')
@endsection
