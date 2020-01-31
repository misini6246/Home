<style type="text/css">
    #down_box {
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, .5);
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#7f000000, endColorstr=#7f000000);
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1000;
        text-align: center;
        min-width: 1200px;
        margin: 0 auto;
        /*display: none;*/
    }

    #down_box li {
        display: none;
        text-align: center;
        position: relative;
        width: 950px;
        margin: 0 auto;
    }

    #down_box li.active {
        display: block
    }

    #mn {
        position: absolute;
        width: 125px;
        height: 35px;
        line-height: 37px;
        background: white;
        top: 4px;
        left: 396px;
        text-align: center;
        border-radius: 10px;
    }

    #mn span {
        height: 24px;
        line-height: 24px;
        width: 92px;
        text-align: center;
        color: #bb8d2b;
        display: inline-block;
        border: 1px solid #bb8d2b;
    }

    .down_1 img {
        margin-left: -12%;
    }

    .body_down {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }

    #down_box li a {
        display: inline-block;
        width: 60px;
        height: 35px;
        position: absolute;
        background: url(about:blank);
    }

    #down_box li.down_1 a {
        right: 236px;
        bottom: 68px;
    }

    #down_box li.down_2,
    #down_box li.down_3,
    #down_box li.down_4 {
        margin-top: 100px;
    }

    #down_box li.down_2 a {
        right: 399px;
        bottom: 77px;
    }

    #down_box li.down_3 a {
        right: 402px;
        bottom: 67px;
    }

    #down_box li.down_4 a {
        right: 415px;
        bottom: 89px;
        width: 120px;
    }
</style>
<div id="down_box" class="container">
    <ul>
        <li class="down_1">
            <img src="{{get_img_path('adimages1/201806/down_1.png')}}"/>
            <div id="mn">
                <span>添加网站到桌面</span>
            </div>
            <a href="javascript:;"></a>
        </li>
        <li class="down_2">
            <img src="{{get_img_path('adimages1/201806/down_2.png')}}"/>
            <a href="javascript:;"></a>
        </li>
        <li class="down_3">
            <img src="{{get_img_path('adimages1/201806/down_3.png')}}">
            <a href="javascript:;"></a>
        </li>
        <li class="down_4">
            <img src="{{get_img_path('adimages1/201806/down_4.png')}}">
            <a href="javascript:;"></a>
        </li>
    </ul>
</div>

<script type="text/javascript">
    $(function () {
        $('#down_box .down_1').css('top', $('.top-wrap').css('height')).addClass('active');
        if ($('#down_box').css('display') == 'block') {
            $('body').addClass('body_down')
            $('#down_box ul li a').click(function () {
                $(this).parent().removeClass('active')
                $(this).parent().next().addClass('active')
                if ($(this).parent().hasClass('down_4')) {
                    $('.down_1').show()
                    $('#down_box').remove()
                    $('body').removeClass('body_down')
                }
            })
            $('#down')
        } else {
            $('body').removeClass('body_down')
        }
    })
</script>

