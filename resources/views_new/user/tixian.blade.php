<div class="tixian_jilu_title">
    提现记录
</div>
<ul class="tixian_jilu_zt">
    <li class="active">全部</li>
    <li>正在进行</li>
    <li>已完成</li>
    {{--<li>已取消</li>--}}
</ul>
<div class="all_tixian tixian_log">
    @if(count($result)>0)
        <table>
            <tr>
                <th class="sqsj">申请时间</th>
                <th class="je">金额</th>
                <th class="yhxx">银行信息</th>
                <th class="zt">状态</th>
                <th class="cz">操作</th>
            </tr>
            @foreach($result as $v)
                @if($v->sq_type==0&&$v->sh_type!=4&&$v->sh_type!=5)
                    <tr>
                        <td class="sqsj">{{$v->create_time->format('Y-m-d H:i:s')}}</td>
                        <td class="je">{{number_format($v->money,2,'.','')}}</td>
                        <td class="yhxx">
										<span>
											<span class="chakan">查看</span>
											<div class="xxck-xiangqing">
												<img src="/new_gwc/jiesuan_img/sanjiao.png"
                                                     class="chakan_img"/>
												<div class="khh">
													<span class="khh-title">
														<img src="/new_gwc/jiesuan_img/椭圆.png"/>
														开户行：
													</span>
													<div class="khh-bank">
														{{$v->bank}}
													</div>
												</div>
												<div class="khh">
													<span class="khh-title">
														<img src="/new_gwc/jiesuan_img/椭圆.png"/>
														卡号：
													</span>
													<div class="khh-bank kahao">
														{{str_replace(' ','',$v->bank_sn)}}
													</div>
												</div>
												<div class="khh">
													<span class="khh-title">
														<img src="/new_gwc/jiesuan_img/椭圆.png"/>
														户名：
													</span>
													<div class="khh-bank">
														 {{$v->bank_user}}
													</div>
												</div>
											</div>
										</span>
                        </td>
                        <td class="zt">
                            {{$v->sh_type_text}}
                            {{--<div class="tx-zhuangtai">--}}
                            {{--<img src="{{get_img_path('images/user/sanjiao.png')}}" class="chakan_img"/>--}}
                            {{--<ul>--}}
                            {{--<li>处理时间</li>--}}
                            {{--<li>订单追踪信息</li>--}}
                            {{--</ul>--}}
                            {{--<div class="tx-zhuangtai-xinxi">--}}
                            {{--<span class="zhuangtai-shijian">--}}
                            {{--<img src="{{get_img_path('images/user/dian.jpg')}}"/>--}}
                            {{--2017-05-15 09:01:49--}}
                            {{--</span>--}}
                            {{--<span class="dingdan-xiangqing">--}}
                            {{--您的订单已经取消您的订单已经取消您的订单已经取消您的订单已经取消您的订单已经取消您的订单已经取消您的订单已经取消您的订单已经取消--}}
                            {{--</span>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                        </td>
                        @if($v->sq_type==0&&($v->sh_type==5||$v->sh_type==0))
                            <td class="cz">取消
                                <form action="{{route('user.tixian.update',['id'=>$v->tx_id])}}" method="POST">
                                    <input name="_method" value="PUT" type="hidden">
                                    {!! csrf_field() !!}
                                    <div class="tx-queding tx-tcc" style="line-height: 12px;">
                                        <div>您确定要取消此次金额为<span>{{$v->money}}元</span>提现申请吗？</div>
                                        <button type="submit" class="tx-quxiao-queding">
                                            确定
                                        </button>
                                        <div class="tx-quxiao-quxiao" style="top: 12px;">
                                            取消操作
                                        </div>
                                    </div>
                                </form>
                            </td>
                        @endif
                    </tr>
                @endif
            @endforeach
        </table>
    @else
        @include('user.empty',['type'=>4,'emsg'=>'没有申请过提现'])
    @endif
</div>
<div class="jinxing_tixian tixian_log" style="display: none;">
    @if(count($result->jinxing)>0)
        <table>
            <tr>
                <th class="sqsj">申请时间</th>
                <th class="je">金额</th>
                <th class="yhxx">银行信息</th>
                <th class="zt">状态</th>
                <th class="cz">操作</th>
            </tr>
            @foreach($result->jinxing as $v)
                @if($v->sq_type==0&&$v->sh_type!=4&&$v->sh_type!=5)
                    <tr>
                        <td class="sqsj">{{$v->create_time->format('Y-m-d H:i:s')}}</td>
                        <td class="je">{{number_format($v->money,2,'.','')}}</td>
                        <td class="yhxx">
										<span>
											<span class="chakan">查看</span>
											<div class="xxck-xiangqing">
												<img src="/new_gwc/jiesuan_img/sanjiao.png"
                                                     class="chakan_img"/>
												<div class="khh">
													<span class="khh-title">
														<img src="/new_gwc/jiesuan_img/椭圆.png"/>
														开户行：
													</span>
													<div class="khh-bank">
														{{$v->bank}}
													</div>
												</div>
												<div class="khh">
													<span class="khh-title">
														<img src="/new_gwc/jiesuan_img/椭圆.png"/>
														卡号：
													</span>
													<div class="khh-bank kahao">
														{{str_replace(' ','',$v->bank_sn)}}
													</div>
												</div>
												<div class="khh">
													<span class="khh-title">
														<img src="/new_gwc/jiesuan_img/椭圆.png"/>
														户名：
													</span>
													<div class="khh-bank">
														 {{$v->bank_user}}
													</div>
												</div>
											</div>
										</span>
                        </td>
                        <td class="zt">
                            {{$v->sh_type_text}}
                            {{--<div class="tx-zhuangtai">--}}
                            {{--<img src="{{get_img_path('images/user/sanjiao.png')}}" class="chakan_img"/>--}}
                            {{--<ul>--}}
                            {{--<li>处理时间</li>--}}
                            {{--<li>订单追踪信息</li>--}}
                            {{--</ul>--}}
                            {{--<div class="tx-zhuangtai-xinxi">--}}
                            {{--<span class="zhuangtai-shijian">--}}
                            {{--<img src="{{get_img_path('images/user/dian.jpg')}}"/>--}}
                            {{--2017-05-15 09:01:49--}}
                            {{--</span>--}}
                            {{--<span class="dingdan-xiangqing">--}}
                            {{--您的订单已经取消您的订单已经取消您的订单已经取消您的订单已经取消您的订单已经取消您的订单已经取消您的订单已经取消您的订单已经取消--}}
                            {{--</span>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                        </td>
                        @if($v->sq_type==0&&($v->sh_type==5||$v->sh_type==0))
                            <td class="cz">取消
                                <form action="{{route('user.tixian.update',['id'=>$v->tx_id])}}" method="POST">
                                    <input name="_method" value="PUT" type="hidden">
                                    {!! csrf_field() !!}
                                    <div class="tx-queding tx-tcc" style="line-height: 12px;">
                                        <div>您确定要取消此次金额为<span>{{$v->money}}元</span>提现申请吗？</div>
                                        <button type="submit" class="tx-quxiao-queding">
                                            确定
                                        </button>
                                        <div class="tx-quxiao-quxiao" style="top: 12px;">
                                            取消操作
                                        </div>
                                    </div>
                                </form>
                            </td>
                        @endif
                    </tr>
                @endif
            @endforeach
        </table>
    @else
        @include('user.empty',['type'=>4,'emsg'=>'没有正在进行的提现申请'])
    @endif
</div>
<div class="wancheng_tixian tixian_log" style="display: none;">
    @if(count($result->wancheng)>0)
        <table>
            <tr>
                <th class="sqsj">申请时间</th>
                <th class="je">金额</th>
                <th class="yhxx">银行信息</th>
                <th class="zt">状态</th>
                <th class="cz">操作</th>
            </tr>
            @foreach($result->wancheng as $v)
                @if($v->sq_type==0&&$v->sh_type!=4&&$v->sh_type!=5)
                    <tr>
                        <td class="sqsj">{{$v->create_time->format('Y-m-d H:i:s')}}</td>
                        <td class="je">{{number_format($v->money,2,'.','')}}</td>
                        <td class="yhxx">
										<span>
											<span class="chakan">查看</span>
											<div class="xxck-xiangqing">
												<img src="/new_gwc/jiesuan_img/sanjiao.png"
                                                     class="chakan_img"/>
												<div class="khh">
													<span class="khh-title">
														<img src="/new_gwc/jiesuan_img/椭圆.png"/>
														开户行：
													</span>
													<div class="khh-bank">
														{{$v->bank}}
													</div>
												</div>
												<div class="khh">
													<span class="khh-title">
														<img src="/new_gwc/jiesuan_img/椭圆.png"/>
														卡号：
													</span>
													<div class="khh-bank kahao">
														{{str_replace(' ','',$v->bank_sn)}}
													</div>
												</div>
												<div class="khh">
													<span class="khh-title">
														<img src="/new_gwc/jiesuan_img/椭圆.png"/>
														户名：
													</span>
													<div class="khh-bank">
														 {{$v->bank_user}}
													</div>
												</div>
											</div>
										</span>
                        </td>
                        <td class="zt">
                            {{$v->sh_type_text}}
                            {{--<div class="tx-zhuangtai">--}}
                            {{--<img src="{{get_img_path('images/user/sanjiao.png')}}" class="chakan_img"/>--}}
                            {{--<ul>--}}
                            {{--<li>处理时间</li>--}}
                            {{--<li>订单追踪信息</li>--}}
                            {{--</ul>--}}
                            {{--<div class="tx-zhuangtai-xinxi">--}}
                            {{--<span class="zhuangtai-shijian">--}}
                            {{--<img src="{{get_img_path('images/user/dian.jpg')}}"/>--}}
                            {{--2017-05-15 09:01:49--}}
                            {{--</span>--}}
                            {{--<span class="dingdan-xiangqing">--}}
                            {{--您的订单已经取消您的订单已经取消您的订单已经取消您的订单已经取消您的订单已经取消您的订单已经取消您的订单已经取消您的订单已经取消--}}
                            {{--</span>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                        </td>
                        @if($v->sq_type==0&&($v->sh_type==5||$v->sh_type==0))
                            <td class="cz">取消
                                <form action="{{route('user.tixian.update',['id'=>$v->tx_id])}}" method="POST">
                                    <input name="_method" value="PUT" type="hidden">
                                    {!! csrf_field() !!}
                                    <div class="tx-queding tx-tcc" style="line-height: 12px;">
                                        <div>您确定要取消此次金额为<span>{{$v->money}}元</span>提现申请吗？</div>
                                        <button type="submit" class="tx-quxiao-queding">
                                            确定
                                        </button>
                                        <div class="tx-quxiao-quxiao" style="top: 12px;">
                                            取消操作
                                        </div>
                                    </div>
                                </form>
                            </td>
                        @endif
                    </tr>
                @endif
            @endforeach
        </table>
    @else
        @include('user.empty',['type'=>4,'emsg'=>'没有已完成的提现申请'])
    @endif
</div>
<script>
    $('.tixian_jilu_zt li').click(function () {
        $(this).addClass('active').siblings().removeClass('active');
        var index = $(this).index();
        $('.tixian_log').hide();
        if (index == 0) {
            $('.all_tixian').show();
        } else if (index == 1) {
            $('.jinxing_tixian').show();
        } else if (index == 2) {
            $('.wancheng_tixian').show();
        }
    })
</script>