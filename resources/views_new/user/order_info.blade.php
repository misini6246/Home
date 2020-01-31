@extends('layouts.app')

@section('title')
    <title>我的订单-订单详情</title>
    @endsection
    @section('links')
        <link rel="stylesheet" type="text/css" href="/index/common/css/com-css.css" />
        <link rel="stylesheet" type="text/css" href="/user/huiyuancommon.css" />
        <link rel="stylesheet" type="text/css" href="/user/huiyuanzhongxin.css" />
        <link rel="stylesheet" type="text/css" href="/user/dingdanxiangqing.css"/>
        <!--layer-->
        <link rel="stylesheet" type="text/css" href="/layer/layer.css" />

        <script src="/index/common/js/jQuery-1.8.3.min.js" type="text/javascript" charset="utf-8"></script>
        <script src="/index/common/js/com-js.js" type="text/javascript" charset="utf-8"></script>
        <script src="/user/common_hyzx.js" type="text/javascript" charset="utf-8"></script>
        <script src="/user/huiyuancommon.js" type="text/javascript" charset="utf-8"></script>
        <script src="/user/placeholderfriend.js" type="text/javascript" charset="utf-8"></script>
        <!--layer-->
        <script src="/layer/layer.js" type="text/javascript" charset="utf-8"></script>
        <script src="/layer/lazyload.js" type="text/javascript" charset="utf-8"></script>
        <style type="text/css">
            table tr th {
                text-align: center;
            }
        </style>
        @endsection

@section('content')
    <div class="big-container">
        <!--头部-->
       @include('layouts.header')
        <!--/头部-->

        <!--搜索导航-->
       @include('layouts.search')
        <!--/搜索导航-->

        <!--导航-->
        @include('layouts.nav')
        <!--/导航-->

        <!--主体内容开始-->
        <div class="container" id="user_center">
            <div class="container_box">
                <div class="breadcrumb">
                    <span><img style="margin-top: -2px;" src="img/详情页_01.png"/>&nbsp;当前位置：</span>
                    <ul>
                        <li>
                            <a href="#">首页</a>
                        </li>
                        <li class="breadcrumb-divider">&gt;</li>
                        <li>
                            <a href="#">会员中心</a>
                        </li>
                        <li class="breadcrumb-divider">&gt;</li>
                        <li>
                            <a href="#">我的订单</a>
                        </li>
                        <li class="breadcrumb-divider">&gt;</li>
                        <li class="breadcrumb-cur">订单详情</li>
                    </ul>
                </div>
                <div class="left">
                    <a href="#">
                        <div class="myyyg">
                            <span>会员中心</span>
                        </div>
                    </a>
                    <ul class="f_ul">
                        <p class="biaoti">
                            <img src="img/交易管理图标.png" />
                            <span>交易管理</span>
                        </p>
                        <li class="cur">
                            <a href="http://www.mingheyaoye.com/user/orderList">
                                <img src="img/right_03.png" />
                                <span>我的订单</span>
                            </a>
                        </li>
                        <li>
                            <a href="http://www.mingheyaoye.com/user/orderList">
                                <img src="img/right_03.png" />
                                <span>充值记录</span>
                            </a>
                        </li>
                        <li>
                            <a href="http://www.mingheyaoye.com/user/orderList">
                                <img src="img/right_03.png" />
                                <span>积分订单</span>
                            </a>
                        </li>
                    </ul>
                    <ul class="f_ul">
                        <p class="biaoti">
                            <img src="img/资产管理图标.png" />
                            <span>资产管理</span>
                        </p>
                        <li>
                            <a href="http://www.mingheyaoye.com/user/accountInfo">
                                <img src="img/right_03.png" />
                                <span>余额管理</span>
                            </a>
                        </li>
                        <li>
                            <a href="http://www.mingheyaoye.com/user/youhuiq">
                                <img src="img/right_03.png" />
                                <span>优惠劵管理</span>
                            </a>
                        </li>
                        <li>
                            <a href="http://www.mingheyaoye.com/user/youhuiq">
                                <img src="img/right_03.png" />
                                <span>积分管理</span>
                            </a>
                        </li>
                    </ul>
                    <ul class="f_ul last_ul">
                        <p class="biaoti">
                            <img src="img/个人中心图标.png" />
                            <span>个人中心</span>
                        </p>
                        <li>
                            <a href="http://www.mingheyaoye.com/user/profile">
                                <img src="img/right_03.png" />
                                <span>基本信息</span>
                            </a>
                        </li>
                        <li>
                            <a href="http://www.mingheyaoye.com/user/collectList">
                                <img src="img/right_03.png" />
                                <span>我的收藏</span>
                            </a>
                        </li>
                        <li>
                            <a href="http://www.mingheyaoye.com/user/mobile_login">
                                <img src="img/right_03.png" />
                                <span>多会员管理</span>
                            </a>
                        </li>
                        <li>
                            <a href="http://www.mingheyaoye.com/user/znx_list">
                                <img src="img/right_03.png" />
                                <span>我的消息</span>
                                <span class="num">9</span>
                            </a>
                        </li>
                        <li>
                            <a href="http://www.mingheyaoye.com/user/addressList">
                                <img src="img/right_03.png" />
                                <span>我的求购</span>
                            </a>
                        </li>
                        <li>
                            <a href="http://www.mingheyaoye.com/user/addressList">
                                <img src="img/right_03.png" />
                                <span>收货地址</span>
                            </a>
                        </li>
                        <li>
                            <a href="http://www.mingheyaoye.com/user/addressList">
                                <img src="img/right_03.png" />
                                <span>配送物流</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="right" style="min-height: 607px;">
                    <div class="right_title">
                        <img src="img/椭圆.png">
                        <span>订单详情</span>
                    </div>
                    <div class="right_content">
                        <div class="zt_1">
                            <div class="f">
                                <span>订单编号：</span>
                                <span class="span_right">180531134744718809</span>
                            </div>
                            <div class="f">
                                <span>下单时间：</span>
                                <span class="span_right">2018-05-31 13:47:44</span>
                            </div>
                            <div class="f">
                                <span>订单状态：</span>
                                <span class="span_right zt">
                                                                    已取消
                                                            </span>
                            </div>
                            <div class="f">
                                <span>订单跟踪：</span>
                                <span class="span_right">2018-06-01 17:50:32
                                &nbsp;&nbsp;&nbsp;您的订单已取消。</span>
                                <span class="zhuizong">
									查看全部跟踪
                                <div class="genzong">
    <img src="http://47.106.142.169:8103/images/user/sanjiao.png?110112" class="sanjiao">
    <div class="wuliu">
                    <div class="end">
                                    <img src="img/wl_qx.png" class="icon">
                                <div class="xx">
                    <div class="time">2018-06-01 17:50:32</div>
                    <div class="xiangqing">
                        <div class="zhuangtai">【已取消
                            】
                        </div>
                        您的订单已取消。
                    </div>
                </div>
            </div>
                                    <div class="start">
                <img src="img/zhuizong_2.png" class="icon">
                <div class="xx">
                    <div class="time">2018-05-31 13:47:44</div>
                    <div class="xiangqing">
                        <div class="zhuangtai">【已提交
                            】
                        </div>
                        您的订单已提交，请尽快完成付款。
                    </div>
                </div>
            </div>
            </div>
</div>								</span>
                            </div>
                        </div>
                        <div class="zt_2">
                            <div class="zt_2_top">
                                <div class="zt_2_top_left">
                                    <div class="zt_2_title">
                                        费用总计
                                    </div>
                                    <ul>
                                        <li>
                                            <span>商品金额：</span>
                                            <span>￥1276.1</span>
                                        </li>
                                        <li>
                                            <span>+ 运费：</span>
                                            <span>￥0</span>
                                        </li>
                                        <li>
                                            <span>- 优惠券：</span>
                                            <span>￥0</span>
                                        </li>
                                        <li>
                                            <span>- 使用余额：</span>
                                            <span>￥0</span>
                                            <span style="color: #111111;margin-left: 20px;">追加使用：</span>
                                            <span style="width: 70px;*width: 68px;height: 24px;*height: 22px;box-sizing: border-box;border: 1px solid #E5E5E5;"><input type="text" name="zjsy" id="zjsy" value="0" style="padding-left: 10px;font-size: 14px;color: #FC3D39;display: inline-block;width: 100%;height: 100%;"></span>
                                            <span style="width: 44px;height: 24px;background-color: #FF2A3E;color: #FFFFFF;border-radius: 2px;text-align: center;line-height: 24px;">确定</span>
                                            <span style="margin-left: 5px;">可用余额：￥200000.00</span>
                                        </li>
                                        <li>
                                            <span style="color: #111111">应付款金额：</span>
                                            <span style="color: #950028">￥0</span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="zt_2_right">
                                    <div class="zt_2_title" style="height: 150px;">
                                        支付方式

                                        <li>
                                            <input class="J_payonline zkzfb" style="left: 400px;" value="支付宝支付" type="button">
                                            <input class="J_payonline zkwx" style="left: 400px;" value="微信支付" type="button">
                                            <input class="J_payonline yhzz" style="left: 400px;" value="银行转账" type="button">
                                        </li>
                                    </div>
                                    <div style="clear: both"></div>
                                    <!--<p class="shuoming" style="float: right;margin: 0 25px 0 0;">
                                        <a target="_blank" href="http://www.mingheyaoye.com/articleInfo?id=91">在线支付说明</a>
                                    </p>-->

                                </div>
                                <div style="clear: both;"></div>
                            </div>
                            <div class="zt_2_bottom">
                                <div class="zt_2_top_left">
                                    <div class="zt_2_title">
                                        收货信息
                                    </div>
                                    <ul>
                                        <li>
                                            <span>收货人：</span>
                                            <span>test （13800138000）</span>
                                        </li>
                                        <li>
                                            <span>收货地址：</span>
                                            <span>广西-南宁-青秀区 test</span>
                                        </li>
                                        <li>
                                            <span>配送方式：</span>
                                            <span>明合直配</span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="zt_2_right">
                                    <div class="zt_2_title">
                                        发票信息
                                    </div>
                                    <ul>
                                        <li>
                                            <span>发票类型：</span>
                                            <span>电子发票</span>
                                        </li>
                                        <li>
                                            <span>发票类别：</span>
                                            <span>增值税税控普通发票</span>
                                        </li>
                                        <li>
                                            <span>开票状态：</span>
                                            <span>已开票<a href="#">点击去查看</a></span>
                                        </li>
                                    </ul>
                                </div>
                                <div style="clear: both;"></div>
                            </div>
                        </div>
                        <div class="spxx">
                            <div class="spxx_title">
                                <span>商品信息</span>
                                <span><a style="color: #00a1e9" href="http://www.mingheyaoye.com/user/orderBuy?id=194">全部加入购物车</a></span>
                            </div>
                            <table>
                                <style type="text/css">
                                    .right table .cz {
                                        width: 85px;
                                    }
                                </style>
                                <tbody><tr>
                                    <th class="spbs">商品标识</th>
                                    <th class="spmc" style="color: #666666;">商品名称</th>
                                    <th class="sccj">生产厂家</th>
                                    <th class="gg">规格</th>
                                    <th class="xq">效期</th>
                                    <th class="spdj">商品单价</th>
                                    <th class="sl">数量</th>
                                    <th class="xj">小计</th>
                                    <th class="cz">操作</th>
                                </tr>
                                <tr>
                                    <td>
                                    </td>
                                    <td>
                                        <!--[if IE 11]>
                                        <style type="text/css">
                                            div.spmc {
                                                margin-top:"-25px"
                                            }


                                        </style>
                                        <![endif]-->
                                        <a target="_blank" href="http://www.mingheyaoye.com/goods?id=12855">
                                            <div class="spmc">阿奇霉素干混悬剂</div>
                                        </a>
                                    </td>
                                    <td>
                                        <div class="sccj">湖南迪诺制药有限公司</div>
                                    </td>
                                    <td>
                                        <div class="gg">0.1g*6袋</div>
                                    </td>
                                    <td>
                                        <div class="xq">2019-03-31</div>
                                    </td>
                                    <td>
                                        <div class="spdj">￥0.01</div>
                                    </td>
                                    <td>
                                        <div class="sl">10</div>
                                    </td>
                                    <td>
                                        <div class="xj">￥0.1</div>
                                    </td>
                                    <td>
                                        <img style="display:none;" src="http://47.106.142.169:8103/image/goods/thumb_img/615c442e639e29abc1e13e85969e03cc.jpg?110112" class="fly_img12855">
                                        <div class="cz fly_to_cart12855" onclick="tocart(12855)"><img src="img/加入购物车.png"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                    </td>
                                    <td>
                                        <a target="_blank" href="http://www.mingheyaoye.com/goods?id=4806">
                                            <div class="spmc">小柴胡颗粒(10袋)</div>
                                        </a>
                                    </td>
                                    <td>
                                        <div class="sccj">广州白云山光华制药股份有限公司</div>
                                    </td>
                                    <td>
                                        <div class="gg">10g*10袋</div>
                                    </td>
                                    <td>
                                        <div class="xq">2019-12-31</div>
                                    </td>
                                    <td>
                                        <div class="spdj">￥12.76</div>
                                    </td>
                                    <td>
                                        <div class="sl">100</div>
                                    </td>
                                    <td>
                                        <div class="xj">￥1276</div>
                                    </td>
                                    <td>
                                        <img style="display:none;" src="http://47.106.142.169:8103/image/goods/thumb_img/6914d4611d29f730efc0864e3699b359.jpg?110112" class="fly_img4806">
                                        <div class="cz fly_to_cart4806" onclick="tocart(4806)"><img src="img/加入购物车.png"></div>
                                    </td>
                                </tr>
                                <tr><td colspan="9">展开余下<span style="color: #FC3D39;">100</span>个商品 <img src="img/icon_42.jpg"/></td></tr>
                                </tbody></table>
                            <div class="heji">
                                商品合计：<span>￥1276.1</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="clear: both"></div>
            </div>

        </div>

        <!--主体内容结束-->

        <!--footer-->
       @include('layouts.new_footer')
        <!--/footer-->
        <script type="text/javascript">
            /**
             * searchEvent 初始化搜索功能
             * 参数1 获取数据方法
             * 参数2 回调方法
             * 参数3 按钮元素(执行搜索)(可选)
             * 参数4 搜索结果列表显示或隐藏的回调  返回true/false(可选)
             */
            $('.search').searchEvent(
                function(_target, _val) { //获取数据方法 val:搜索框内输入的值
                    var data = [
                    ]
                    /**
                     * searchDataShow 将数据渲染至页面
                     * 参数1:数据数组
                     * 参数2:数据数组内下标名
                     */
                    _target.searchDataShow(data, 'value')
                },
                function(val) { //回调方法 val:返回选中的值
                    alert('搜索关键词"' + val + '"...');
                },
                $('.search-btn')
            );
        </script>
    </div>

    @endsection


