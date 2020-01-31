<style type="text/css">
    .fixsearch {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 60px;
        z-index: 999;
        background: #fefefe;
        display: none;
        box-shadow: 0 5px 8px rgba(0, 0, 0, 0.15);
        -webkit-box-shadow: 0 5px 8px rgba(0, 0, 0, 0.15);
    }

    .fixsearch-box {
        width: 1200px;
        height: 60px;
        margin: 0 auto;
        /*border: 1px solid red;*/
        line-height: 60px;
        display: flex;
        align-items: center;
        position: relative;
    }

    .fixedsearch_box {
        display: inline-block;
        margin-left: 100px;
        position: relative;
        /*border: 1px solid red;*/
    }

    #fixed-suggest {
        width: 431px;
        height: 38px;
        border: 1px solid #3dbb2b;
        color: #777777;
        line-height: 38px;
    }

    .fixed-search_btn {
        width: 71px;
        height: 40px;
        line-height: 40px;
        background: #3ebb2b;
        color: #fff;
        font-size: 14px;
        text-align: center;
        font-weight: bold;
        margin-left: -5px;
        cursor: pointer;
    }

    .fixsearch .fixsearch-box .fixedsearch_box .search_show {
        width: 434px;
        *width: 431px;
        left: 0;
        *left: 100px;
        top: 50px;
        *top: 49px;
        border-top: none;
        display: none;
    }

    .fixed-gouwuche, .fixed-dingdan {
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

    .fixed-gouwuche img, .fixed-dingdan img {
        vertical-align: middle;
        margin-top: -6px;
        *margin-top: -5px;
    }

    .fixed-gouwuche {
        width: 138px;
    }

    .fixed-dingdan {
        width: 112px;
        margin-left: 103px;
    }
</style>
<div id="fixed_search" class="container">
    <div class="container_box">
        <div class="logo_box">
            <a href="{{route('index')}}"><img style="height: 50px;margin-top: 5px;" src="{{asset('images/logo-new.png')}}"/></a>
        </div>
        <div class="fixed_input_box">
            <input id="fixed-suggest" name="userSearch" type="text" value="药品名称(拼音缩写)或厂家名称"
                   class="search_input1 suggest1"/><input type="button" id="search_btn" value="搜 索" class="search_btn"/>
            <div id="fixed-suggestions_wrap" class="search_show list_box suggestions_wrap"
                 style="margin-top: -1px;border-top: 0;">

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
        </div>
        <div class="gwc_box fr">
            <div class="dd fl">
                <a href="{{route('member.order.index')}}">
                    <img src="{{get_img_path('images/index/xiangqing.png')}}" style="top: 3px"/>
                    <span>订单查询</span>
                </a>
            </div>
            <div class="gwc fl">
                <a href="{{route('cart.index')}}">
                    <img src="{{get_img_path('images/index/gouwuche.png')}}" style="top: 3px"/>
                    <span>购物车</span><span class="sl"><span class="cart_number">{{cart_info(1,1)}}</span></span>
                </a>
            </div>
        </div>
    </div>
</div>