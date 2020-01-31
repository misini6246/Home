<script type="text/javascript" src="{{path('/js/transport_jquery.js')}}"></script>
<script type="text/javascript" src="{{path('/js/utils.js')}}"></script>
<div id="ECS_ORDERTOTAL">
    <table class="table8" align="center" border="0" cellpadding="0">
        <tr>
            <th>费用总计</th>
        </tr>
        <tr class="tb6_td1">
            <td>
                商品总计: <span class="price">{{formated_price($total)}}</span>
                @if($discount)
                    - 折扣: <span class="price">{{formated_price($discount)}}</span>
                @endif
                @if($zyzk)
                    - 优惠金额: <span class="price">{{formated_price($zyzk)}}</span>
                @endif
                {{--<!-- {if $total.discount gt 0} 折扣 -->--}}
                {{--- {$lang.discount}: <span class="price">{$total.discount_formated}</span>--}}
                {{--<!-- {/if} -->--}}
                {{--<!-- {if $total.tax gt 0} 税 -->--}}
                {{--+ {$lang.tax}: <span class="price">{$total.tax_formated}</span>--}}
                {{--<!-- {/if} -->--}}
                {{--<!-- {if $total.shipping_fee > 0} 配送费用 -->--}}
                {{--+ {$lang.shipping_fee}: <span class="price">{$total.shipping_fee_formated}</span><span>(商品总金额未满800元,需支付{$total.shipping_fee}元运费)</span> <!-- 2015-4-7 -->--}}
                {{--<!-- {/if} -->--}}
                {{--<!-- {if $total.shipping_insure > 0} 保价费用 -->--}}
                {{--+ {$lang.insure_fee}: <span class="price">{$total.shipping_insure_formated}</span>--}}
                {{--<!-- {/if} -->--}}
                {{--<!-- {if $total.pay_fee > 0} 支付费用 -->--}}
                {{--+ {$lang.pay_fee}: <span class="price">{$total.pay_fee_formated}</span>--}}
                {{--<!-- {/if} -->--}}
                {{--<!-- {if $total.pack_fee > 0} 包装费用-->--}}
                {{--+ {$lang.pack_fee}: <span class="price">{$total.pack_fee_formated}</span>--}}
                {{--<!-- {/if} -->--}}
                {{--<!-- {if $total.card_fee > 0} 贺卡费用-->--}}
                {{--+ {$lang.card_fee}: <span class="price">{$total.card_fee_formated}</span>--}}
                {{--<!-- {/if} -->    </td>--}}
            </td>
        </tr>
        {{--<!-- {if $total.surplus > 0 or $total.integral > 0 or $total.bonus > 0} 使用余额或积分或红包 -->--}}
        {{--<tr class="tb6_td1">--}}
            {{--<td>--}}
                {{--<!-- {if $total.surplus > 0} 使用余额 -->--}}
                {{--- {$lang.use_surplus}: <span class="price">{$total.surplus_formated}</span>--}}
                {{--<!-- {/if} -->--}}
                {{--<!-- {if $total.integral > 0} 使用积分 -->--}}
                {{--- {$lang.use_integral}: <span class="price">{$total.integral_formated}</span>--}}
                {{--<!-- {/if} -->--}}
                {{--<!-- {if $total.bonus > 0} 使用红包 -->--}}
                {{--- {$lang.use_bonus}: <span class="price">{$total.bonus_formated}</span>--}}
                {{--<!-- {/if} -->    </td>--}}
        {{--</tr>--}}
        {{--<!-- {/if} 使用余额或积分或红包 -->--}}
        <tr class="tb6_td1">
            <td> 应付款金额: <span class="price">{{formated_price($order_amount)}}</span>
                {{--{if $is_group_buy}<br />--}}
                {{--{$lang.notice_gb_order_amount}{/if}--}}
                {{--<!--{if $total.exchange_integral }消耗积分--><br />--}}
                {{--{$lang.notice_eg_integral}<span class="price">{$total.exchange_integral}</span>--}}
                {{--<!--{/if}-->--}}
            </td>
        </tr>
    </table>
</div>