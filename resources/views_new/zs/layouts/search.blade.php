<style>
    .search_box div input {
        width: 421px;
        height: 40px;
        border: 1px solid #3dbb2b;
        line-height: 40px;
        padding-left: 10px;
        color: #777777;
        display: inline;
        margin-top: -87px;
        float: left;
        margin-left: 330px;
    }

    .search_show {
        display: none;
        width: 410px;
        padding: 2px 3px;
        border: 1px solid #3DAC14;
        position: absolute;
        z-index: 65;
        background: #FFF;
    }

    .search_list {
        font-size: 14px;
        border-top: 1px solid #F3F3F3;
    }

    .search-hot a {
        color: #5E5E5E;
        padding-right: 12px;
    }

    .search-hot a:hover {
        color: #e70000;
    }

    .search_list li {
        color: #333;
        height: 30px;
        line-height: 30px;
        border-bottom: 1px solid #F3F3F3;
        padding: 0 5px 0 5px;
    }

    .search_list li.active {
        background: #C4FFAA;
    }

    .search_list li a {
        float: left;
        color: #8F8F8F;
        text-decoration: none;
        width: 100%;
    }

    .search_list li span {
        float: right;
        font-size: 12px;
        color: #8F8F8F;
    }

</style>
<div id="search" class="container">
    <div class="container_box">
        <div class="search_top">
            <div class="img_box">
                <a href="{{route('index')}}"><img src="http://www.hezongyy.com/new/images/logo.png"/></a>
            </div>
            <div class="input_box">
                <input id="suggest" name="userSearch" type="text"
                       value="@if(!isset($keywords)||empty($keywords))药品名称(拼音缩写)或厂家名称@else{{$keywords}}@endif"
                       class="search_input suggest"/><input type="image" id="search_btn"
                                                            src="{{get_img_path('images/zs/search_btn.png')}}"/>
                <div id="suggestions_wrap" class="search_show list_box suggestions_wrap"
                     style="margin-left: 145px;left:auto;top: auto;border-top: 0;">

                    <ul class="search_list suggestions" id="suggestions">
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
                <div class="hot">
                    @foreach($ad159 as $v)
                        <a target="_blank" href="{{$v->ad_link}}">{{$v->ad_name}}</a>
                    @endforeach
                </div>
            </div>
            <div class="gwc_box fr">
                <div class="dd fl">
                    <a href="{{route('member.order.index')}}">
                        <img src="{{path('new/images/xiangqing.png')}}"/>
                        <span>订单查询</span>
                    </a>
                </div>
                <div class="gwc fl">
                    <a href="{{route('cart.index')}}">
                        <img src="{{path('new/images/gouwuche.png')}}"/>
                        <span>购物车</span><span class="sl">(<span>{{cart_info()}}</span>)</span>
                    </a>
                </div>
                <p>
                    <a target="_blank" href="/images/zgz1.jpg">药品交易服务资格证书</a>
                </p>
            </div>
        </div>
    </div>
</div>