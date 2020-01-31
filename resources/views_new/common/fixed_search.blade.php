<style type="text/css">
    /*固定搜搜索栏*/
    .fixsearch{
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 60px;
        z-index: 999;
        background: #fefefe;
        display: none;
        box-shadow: 0 5px 8px rgba(0,0,0,0.15);
        -webkit-box-shadow:0 5px 8px rgba(0,0,0,0.15);
    }
    .fixsearch-box{
        width: 1200px;
        height: 60px;
        margin: 0 auto;
        /*border: 1px solid red;*/
        line-height: 60px;
        display:flex;
        align-items:center;
        position: relative;
    }
    .fixedsearch_box{
        display: inline-block;
        margin-left: 100px;
        position: relative;
        /*border: 1px solid red;*/
    }
    #fixed-suggest{
        width: 431px;
        height: 38px;
        border: 1px solid #3dbb2b;
        color: #777777;
        line-height: 38px;
    }
    .fixed-search_btn{
        width:71px;
        height: 40px;
        line-height:40px;
        background: #3ebb2b;
        color: #fff;
        font-size: 14px;
        text-align: center;
        font-weight: bold;
        margin-left: -5px;
        cursor: pointer;
    }
    .fixsearch .fixsearch-box .fixedsearch_box .search_show{
        width: 434px;
        *width: 431px;
        left: 0;
        *left:100px;
        top:50px;
        *top:49px;
        border-top: none;
        display:none;
    }
    .fixed-gouwuche,.fixed-dingdan{
        border: 1px solid #cecece;
        color: #777;
        height: 40px;
        line-height: 40px;
        margin-top: 10px;
        margin-left: 13px;
        float: right;
        text-align: center;
        *margin-top: -50px;
    }
    .fixed-gouwuche img,.fixed-dingdan img{
        vertical-align: middle;
        margin-top: -6px;
        *margin-top: -5px;
    }
    .fixed-gouwuche{
        width: 138px;
    }
    .fixed-dingdan{
        width: 112px;
        margin-left:103px;
    }

</style>
<div class="fixsearch">
    <div class="fixsearch-box">
        <img src="{{get_img_path('images/fixed-nav.jpg')}}" style="float: left;"/>
        <div class="fixedsearch_box fn_clear">
            <input style="padding-left: 10px;" id="fixed-suggest" name="userSearch" type="text" value="药品名称(拼音缩写)或厂家名称" class="search_input1 suggest1"/>
            <button type="button" class="btn fixed-search_btn" id="" value="" >搜 索</button>
            <div id="fixed-suggestions_wrap" class="search_show list_box suggestions_wrap">

                <ul class="search_list suggestions" id="fixed-suggestions">
                    <li class="" style="cursor: pointer;">(简)复方氨基酸注射液(18AA-V)</li>
                    <li class="" style="cursor: pointer;">(精)复方氨基酸注射液(18AA-V)</li>
                    <li class="" style="cursor: pointer;">(精)盐酸氨溴索葡萄糖注射液</li>
                    <li class="" style="cursor: pointer;">(精)盐酸氨溴索葡萄糖注射液(给欣)</li>
                    <li class="active" style="cursor: pointer;">(高邦爱无忧延缓)天然胶乳橡胶避孕套</li>
                    <li>*复方福尔可定口服溶液(奥特斯)</li>
                    <li>*小儿伪麻美芬滴剂(艾畅)</li>
                    <li>*氨酚伪麻片(Ⅱ)</li>
                    <li>*氨酚伪麻美芬片Ⅱ/氨麻苯美片(白加黑)</li>
                    <li>*氨酚伪麻胶囊(II)</li>
                </ul>
            </div>
            <a href="{{route('cart.index')}}">
                <div class="fixed-gouwuche">
                    <img src="{{get_img_path('images/gouwuche.png')}}"/>
                    购物车
                    <span style="color: red;">({{cart_info()}})</span>
                </div>
            </a>

            <a href="{{route('user.orderList')}}">
                <div class="fixed-dingdan">
                    <img src="{{get_img_path('images/xiangqing.png')}}"/>
                    订单查询
                </div>
            </a>

        </div>

    </div>

</div>
<script type="text/javascript">
    window.onscroll = function () {
        var t = document.documentElement.scrollTop || document.body.scrollTop;//获取滚动距离
        if(t>=240){
            $('.fixsearch').fadeIn()
        }else{
            $('.fixsearch').fadeOut()

        }
    }

</script>