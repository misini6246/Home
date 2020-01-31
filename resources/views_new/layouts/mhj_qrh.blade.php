<style>
    #qrtz {
        position: fixed;
        top: 10%;
        text-align: center;
        width: 100%;
        z-index: 1002;
    }

    .qrtz_box {
        display: inline-block;
        *display: inline;
        *zoom: 1;
        width: 800px;
        border: 20px solid #8d8dff;
        box-sizing: border-box;
        background-color: #fff;
    }

    .qrtz_content {
        border: 5px solid #c9abff;
        padding: 15px;
        box-sizing: border-box;
    }

    .qrtz_title {
        height: 30px;
        line-height: 30px;
        font-size: 16px;
        padding: 0 10px;
        text-align: left;
    }

    .qrtz_title_ct {
        font-size: 16px;
        text-indent: 30px;
        text-align: left;
        padding: 0 10px;
        line-height: 24px;
    }

    .qrtz_table {
        background: #6363ff;
        margin-top: 15px;
        padding: 10px;
    }

    .qrtz_table_th {
        height: 30px;
        line-height: 30px;
        border-bottom: 1px solid #88b8ee;
    }

    .qrtz_table_th div, .qrtz_table_td div {
        float: left;
        color: #fff;
        text-align: left;
        text-indent: 10px;
    }

    .qrtz_table_th div {
        font-size: 14px;
        font-weight: bold;
    }

    #qrtz table td {
        text-align: left;
        height: 24px;
        line-height: 24px;
    }

    .qrtz_spmc, .qrtz_gg {
        width: 200px;
    }

    .qrtz_cj {
        width: 210px;
    }

    .qrtz_zje {
        width: 90px;
    }

    .qrtz_table_td {
        height: 24px;
    }

    .qrtz_table_td div {
        font-family: "宋体";
        height: 24px;
        line-height: 24px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .close_btn input {
        width: 100px;
        height: 42px;
        line-height: 42px;
        background: #39b617;
        color: #fff;
        font-size: 16px;
        margin: 10px 0;
        cursor: pointer;
    }

    .qrtz_phone {
        font-size: 16px;
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
<div id="qrtz">
    <div class="qrtz_box">
        <div class="qrtz_content">
            <p class="qrtz_title">
                尊敬的会员：
            </p>
            <p class="qrtz_title_ct">
                您好，为更好的规范含麻品种的购买，按GSP规定您已提供含麻委托书，含麻品种收货回执，{{config('services.web.name')}}严格按照规定，并提出更高要求，还需在网上对每笔订单做收货和付款确认。为保障您的权益，请仔细确认，以下是2018年截止到5月9日贵单位在药易购购买的含麻商品的明细，请核对以上货物全部收到，并确认这些商品的款项是贵单位购买并付款的。谢谢！
            </p>
            <div class="qrtz_table">
                <div class="qrtz_table_th">
                    <div class="qrtz_spmc">列表</div>
                    <div class="qrtz_cj">厂家</div>
                    <div class="qrtz_gg">规格</div>
                    <div class="qrtz_zje">总金额</div>
                </div>
                @foreach($mhj_qrh as $v)
                    <div class="qrtz_table_td">
                        <div class="qrtz_spmc">{{$v->goods_name}}</div>
                        <div class="qrtz_cj">{{$v->sccj}}</div>
                        <div class="qrtz_gg">{{$v->ypgg}}</div>
                        <div class="qrtz_zje">{{formated_price($v->goods_amount)}}</div>
                    </div>
                @endforeach
            </div>
            <div class="close_btn">
                <input type="button" value="确定" onclick="dfqr(1)"/>
            </div>
            <p class="qrtz_phone">咨询电话:15680806016</p>
        </div>
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
                $('#qrtz').hide();
                $('.zhezhao').hide();
                layer.msg(data.msg, {icon: data.error + 1})
            }
        })
    }
</script>