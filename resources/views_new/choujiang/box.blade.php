<style>
    .choujiang {
        width: 990px;
        height: 360px;
        background: url('{{get_img_path('images/hd/choujiang_bg_0307.jpg')}}') no-repeat;
        margin: 0 0 20px 160px;
        position: relative;
        display: none;
    }

    .choujiang_btn {
        display: inline-block;
        width: 240px;
        height: 70px;
        position: absolute;
        top: 268px;
        left: 375px;
        cursor: pointer;
    }

    .choujiang_result_box {
        text-align: center;
        height: 360px;
        width: 100%;
        background: rgba(0, 0, 0, .5);
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#7f000000, endColorstr=#7f000000);
        position: relative;
        z-index: 2;
    }

    .choujiang_result {
        display: inline-block;
        width: 389px;
        height: 305px;
        background: url('{{get_img_path('images/hd/choujiang_result.png')}}') no-repeat;
        margin-top: 30px;
    }

    .choujiang_result .lx {
        margin-top: 187px;
    }

    .choujiang_result .lx, .choujiang_result .lx span {
        font-size: 30px;
    }

    .choujiang_result .lx span {
        color: #ff4b5c;
    }

    .choujiang_result .txt {
        font-size: 18px;
        margin-top: 5px;
    }

    .choujiang_result .number {
        color: #666;
        font-size: 14px;
        margin-top: 20px;
    }

</style>
<div class="choujiang">

</div>
<script>
    $(function () {
        $.ajax({
            url: '/jp/check_log_count',
            data: {id: 1},
            dataType: 'json',
            success: function (data) {
                if (data.error == 0) {
                    $('.choujiang').html(data.msg);
                    $('.choujiang').show();
                }
            }
        })
    });
    function cj() {
        $.ajax({
            url: '/jp',
            data: {order_id: '{{$order['order_id']}}'},
            dataType: 'json',
            success: function (data) {
                if (data.error == 0) {
                    $('.choujiang').html(data.msg);
                } else {
                    layer.msg(data.msg, {icon: data.error + 1})
                }
            }
        })
    }
</script>