<?php

namespace App\Jobs;

use App\OrderInfo;
use App\Region;
use App\User;
use App\UserJnmj;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use SoapClient;

class ToWebservice extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $order;

    protected $user;

    public function __construct(OrderInfo $orderInfo, User $user)
    {
        $this->order = $orderInfo;
        $this->user  = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info('进入任务中');
        $xf_ids = [];//使用现付的会员
        if (($this->order->province == 26 && $this->order['goods_amount'] >= 800) || in_array($this->order->user_id, $xf_ids)) {
            $fkfs = '现付';
        } else {
            $fkfs = '提付';
        }
        if (strpos($this->order->shipping_name, '申通') !== false) {
            $this->order->shipping_name = '成都申通快递实业有限公司郫县营业部';
        } elseif (strpos($this->order->shipping_name, '腾林物流') !== false) {
            $this->order->shipping_name = '四川腾林物流有限公司';
        } elseif (strpos($this->order->shipping_name, '余氏东风') !== false) {
            $this->order->shipping_name = '四川佳迅物流有限公司（余氏东风）';
        } elseif (strpos($this->order->shipping_name, '三江物流') !== false) {
            $this->order->shipping_name = '成都市三江运发货运有限公司';
        } elseif (strpos($this->order->shipping_name, '国通物流(送货上门)') !== false) {
            $this->order->shipping_name = '成都嘉宣物流有限公司（四川国通（增益）物流）';
        } elseif (strpos($this->order->shipping_name, '增益速递') !== false) {
            $this->order->shipping_name = '成都嘉宣物流有限公司（四川国通（增益）物流）';
        } elseif (strpos($this->order->shipping_name, '飞马货运') !== false) {
            $this->order->shipping_name = '飞马快运';
        } elseif (strpos($this->order->shipping_name, '东臣物流') !== false) {
            $this->order->shipping_name = '四川东臣物流有限公司';
        } elseif (strpos($this->order->shipping_name, '成昌信物流') !== false) {
            $this->order->shipping_name = '成都成昌信物流有限公司';
        } elseif (strpos($this->order->shipping_name, '光华托运部') !== false) {
            $this->order->shipping_name = '成都市光华托运部';
        } elseif (strpos($this->order->shipping_name, '鑫海洋') !== false) {
            $this->order->shipping_name = '四川鑫海洋货运代理有限公司';
        } elseif (strpos($this->order->shipping_name, '筋斗云') !== false) {
            $this->order->shipping_name = '新疆筋斗云物流有限责任公司成都分公司';
        } elseif (strpos($this->order->shipping_name, '力展') !== false) {
            $this->order->shipping_name = '四川力展物流有限责任公司';
        } elseif (strpos($this->order->shipping_name, '宇鑫物流') !== false) {
            $this->order->shipping_name = '成都宇鑫物流有限公司';
        } elseif (strpos($this->order->shipping_name, '宅急送') !== false) {
            $this->order->shipping_name = '成都宅急送快运有限公司';
        }

        //收货地址
        $province = Cache::tags(['shop', 'region'])->rememberForever(1, function () {
            return Region::where('parent_id', 1)->get();
        })->find($this->order->province);
        $city     = Cache::tags(['shop', 'region'])->rememberForever($this->order->province, function () {
            return Region::where('parent_id', $this->order->province)->get();
        })->find($this->order->city);
        $district = Cache::tags(['shop', 'region'])->rememberForever($this->order->city, function () {
            return Region::where('parent_id', $this->order->city)->get();
        })->find($this->order->district);
        if (empty($district)) {
            $district = Region::find($this->order->district);
        }

        $add_dz                = $province->region_name . $city->region_name . $district->region_name . $this->order->address;
        $this->order->order_sn = trim($this->order->order_sn);

        $fpfs_type = array('增值税普通发票', '纸制发票', '增值税专用发票');
        $fpfs      = $fpfs_type[$this->user->dzfp];

        if ($this->order->is_zq > 0) {//账期会员的账期订单
            $fukfs = '月结';
        } else {
            $fukfs = '预付';
        }

        if (!empty($this->order->inv_payee)) {
            $ywy = $this->order->inv_payee;
        } else {
            $ywy = '药易购';
        }

        $zk         = 0;
        $goods_list = $this->order->order_goods;
        $zkljs      = 0;
        if ($this->order['pack_fee'] > 0 && ($this->order['goods_amount'] - $this->order['zyzk'] - $this->order['pack_fee']) > 0) {
            $zkljs = $this->order['pack_fee'] / ($this->order['goods_amount'] - $this->order['zyzk'] - $this->order['pack_fee']);
        } elseif ($this->order['jnmj'] > 0) {
            $user_jnmj = UserJnmj::where('user_id', $this->user->user_id)->first();
            $zkljs     = $user_jnmj->jnmj_zk / 1000;
        }
        if ($this->order['zj_type'] > 0) {
            $zkljs = 0;
        }
        $in_order = array(
            'order_id'      => $this->order->order_sn,
            'order_num'     => count($goods_list),
            'khinf_id'      => $this->user->wldwid,
            'khinf_id1'     => $this->user->wldwid1,
            'khinf_dh'      => empty($this->order->tel) ? $this->order->mobile : $this->order->tel,
            'lgistics_name' => $this->order->shipping_name,
            'lgistics_dh'   => $this->order->wl_dh,
            'address'       => $add_dz,
            'shr'           => $this->order->consignee,
            'fkfs'          => $fkfs,
            'beizhu'        => $this->order->consignee . ' ' . $this->order->sign_building,
            'zp-zb'         => 1,
            'fpfs'          => $fpfs,
            'fukfs'         => $fukfs,
            'ywy'           => $ywy,
            'zk'            => $zk,
            'zkljs'         => $zkljs,
            'bmid'          => 'BMZ00000002',
            'bmname'        => '电子商务组',
            'zhiyid'        => '',
            'UserName'      => '药易购',
            'is_jybg'       => '否',
        );
        $in_goods = [];
        $goods_list->load([
            'goods' => function ($query) {
                $query->select('goods_id', 'ERPID');
            }
        ]);
        foreach ($goods_list as $k => $v) {
            if (strpos(strtolower($v->tsbz), 'z') !== false) {
                $zp = 0;
            } else {
                $zp = 1;
            }

            //2016-03-14
            if ($v->zyzk > 0) {
                $v->goods_price = $v->goods_price - $v->zyzk;
            }


            $val          = array(
                'order_sn'  => $k + 1,
                'sponfo_id' => $v->goods->ERPID,
                'ckinf_id'  => $v->ckid,
                'order_sl'  => $v->goods_number,
                'oreder_jg' => $v->goods_price,
                'uug_spbh'  => $v->rec_id,
                'zp_dp'     => $zp,
            );
            $in_goods[$k] = $val;
        }

        if ($in_order['order_num'] > 0) {
            $flag = $this->to_webservice($in_order, $in_goods);
            if (!$flag) {
                $this->release(10);
            }
            Log::info('执行状态:'.$flag.',执行时间:'.date('Y-m-d H:i:s'));
        }
    }

    private function to_webservice($order, $goods)
    {
        $val = "<DATA><HZ>
<ORDER_ID>" . $order['order_id'] . "</ORDER_ID>
<ORDER_NUM>" . $order['order_num'] . "</ORDER_NUM>
<KHINFO_ID>" . $order['khinf_id'] . "</KHINFO_ID>
<KHINFO_ID1>" . $order['khinf_id1'] . "</KHINFO_ID1>
<KHINFO_DH>" . $order['khinf_dh'] . "</KHINFO_DH>
<LGISTICS_NAME>" . $order['lgistics_name'] . "</LGISTICS_NAME>
<LGISTICCS_DH>" . $order['lgistics_dh'] . "</LGISTICCS_DH>
<ADDRESS>" . $order['address'] . "</ADDRESS>
<SHR>" . $order['shr'] . "</SHR>
<FKFS>" . $order['fkfs'] . "</FKFS>
<BeiZhu>" . $order['beizhu'] . "</BeiZhu>
<ZP_ZB>" . $order['zp-zb'] . "</ZP_ZB>
<FPFS>" . $order['fpfs'] . "</FPFS>
<FUKFS>" . $order['fukfs'] . "</FUKFS>
<YWY>" . $order['ywy'] . "</YWY>
<ZKID>" . $order['zk'] . "</ZKID>
<ZKLJS>" . $order['zkljs'] . "</ZKLJS>
<BMID>" . $order['bmid'] . "</BMID>
<BMNAME>" . $order['bmname'] . "</BMNAME>
<zhiyid>" . $order['zhiyid'] . "</zhiyid>
<UserName>" . $order['UserName'] . "</UserName>
<is_jybg>" . $order['is_jybg'] . "</is_jybg>
</HZ>
<LIST>";
        $str = '';
        foreach ($goods as $v) {
            $str .= "<MX>
<ORDER_SN>" . $v['order_sn'] . "</ORDER_SN>
<SPINFO_ID>" . $v['sponfo_id'] . "</SPINFO_ID>
<CKINFO_ID>" . $v['ckinf_id'] . "</CKINFO_ID>
<ORDER_SL>" . $v['order_sl'] . "</ORDER_SL>
<ORDER_JG>" . $v['oreder_jg'] . "</ORDER_JG>
<YYG_SPBH>" . $v['uug_spbh'] . "</YYG_SPBH>
<ZP_DP>" . $v['zp_dp'] . "</ZP_DP>
</MX>";
        }

        $str    = $val . $str . '</LIST></DATA>';
        $client = new SoapClient('http://171.221.207.113:3395/cszjc/webservice/cxfService?wsdl');
        return $client->setOrder(array('param' => $str));
    }
}
