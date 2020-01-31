<?php

namespace App\Http\Controllers;

use App\Functions\Common\Hd;
use App\Functions\Common\Jpzq;
use App\Functions\Common\Order;
use App\Functions\Common\Trans;
use App\Models\CzMoney;
use App\Models\HongbaoMoney;
use App\Models\JfMoney;
use App\Models\OldOrderInfo;
use App\Models\OrderGoods;
use App\Models\OrderInfo;
use App\Models\UserAddress;
use App\Models\UserBumen;
use App\Models\Yhq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use SoapClient;

class OrderController extends Controller
{
    private $user;

    private $assign;

    private $order;

    private $order_user;

    private $old_order;

    private $zje = 0;

    private $zje1 = 0;

    private $zje2 = 0;

    private $zje3 = 0;

    private $zje4 = 0;

    private $zje5 = 0;

    private $table;

    private $now;

    use Jpzq, Hd;
    use Trans;
    use Order;

    public function __construct(OrderInfo $orderInfo, OldOrderInfo $oldOrderInfo)
    {
        $this->middleware(function ($request, $next) {
            $this->user = session_admin();
            return $next($request);
        });
        $this->now = time();
        $this->order = $orderInfo;
        $this->old_order = $oldOrderInfo;
        $this->assign = [];
        $this->assign['tip1'] = '订单管理';
        $this->assign['tip2'] = '订单列表';
        $this->assign['tip3'] = route('order.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $where = function ($where) {
            $where->whereNotIn('mobile_pay', [2, 6, 7, 8, 12, 13, 14, 17, 18, 20, 22, 24, 26, 28, 30, 32, 34, 36, 38, 42, 44, 46, 48])->orwhere(function ($where) {
                $where->where('mobile_pay', 2)->where(function ($where) {
                    $where->where('order_id', '<=', 367858)->orwhere('order_id', '>', 394321);
                })->whereNotIn('order_id', [367153, 367774, 367662, 367692, 367493, 367664, 367768, 366777, 367595, 367678, 367836, 367090]);;
            });
        };

        $result = $this->order_list_union($request, $where);

        Cache::tags(['houtai', 'order.index'])->put($this->user->user_id, $result->url($result->currentPage()), 60);
        if (has_role('财务')) {
            $this->assign['show_qid'] = 1;
        }
        if (has_role('营销策划部')) {
            $this->assign['chb'] = 1;
        }
        $this->assign['user'] = $this->user;
        $ub = new UserBumen();
        $this->assign['result'] = $result;
        $this->assign['bumen_arr'] = $ub->bumen();
        $this->assign['ddzt'] = $this->order_status();
        $this->assign['ddbz_arr'] = $this->ddbz_arr();
        $this->assign['zje'] = $this->zje();
        $this->assign['zje1'] = $this->zje1;
        $this->assign['zje2'] = $this->zje2;
        if (has_role('监管')) {
            return view('order.simple', $this->assign);
        }
        return view('order.index', $this->assign);
    }

    public function ywy(Request $request)
    {
        $admin = intval($request->input('admin'));
        if (has_role(['戴总后勤', '戴总队伍']) && $admin == 0) {
            $where = function ($where) {
                $where->where(function ($where) {
                    $where->where('mobile_pay', '>', 1);
                })->where('card_message', 'like', '%' . $this->user->name . '%');
            };
        } else {
            $where = function ($where) {
                $where->where('mobile_pay', '>', 1);
            };
        }
        $result = $this->order_list_union($request, $where);
        Cache::tags(['houtai', 'order.index'])->put($this->user->user_id, $result->url($result->currentPage()), 60);
        $this->assign['user'] = $this->user;
        $this->assign['result'] = $result;
        $this->assign['ddzt'] = $this->order_status();
        $this->assign['ddbz_arr'] = $this->ddbz_arr();
        $this->assign['zje1'] = $this->zje1;
        $this->assign['zje2'] = $this->zje2;
        $this->assign['tip3'] = route('order.ywy');
        return view('order.ywy_order', $this->assign);
    }

    public function my(Request $request)
    {
        $admin = intval($request->input('admin'));
        $ddbz = intval($request->input('ddbz'));
        if ($this->user->is_admin != 1 && $this->user->name != '李燕飞' && $admin == 0) {
            $where = function ($where) use ($ddbz) {
                $where->where(function ($where) {
                    $where->whereNotIn('mobile_pay', [2, 6, 7, 8, 12, 13, 14, 17, 18, 20, 22, 24, 26, 28, 30, 32, 34, 36, 38, 42, 44, 46, 48])->orwhere(function ($where) {
                        $where->where('mobile_pay', 2)->where(function ($where) {
                            $where->where('order_id', '<=', 367858)->orwhere('order_id', '>', 394321);
                        })->whereNotIn('order_id', [367153, 367774, 367662, 367692, 367493, 367664, 367768, 366777, 367595, 367678, 367836, 367090]);
                    });
                })->where(function ($where) {
                    if (has_role(['市场部后勤', '市场部管理', '市场一部', '市场二部'])) {
                        $where->where('inv_content', 'like', '%' . $this->user->name . '%');
                    } else {
                        $where->where('ls_zpgly', 'like', '%' . $this->user->name . '%')
                            ->orwhere('inv_content', 'like', '%' . $this->user->name . '%')
                            ->orwhere('card_message', 'like', '%' . $this->user->name . '%');
                    }
                });
            };
        } else {
            $where = function ($where) use ($ddbz) {
                if (has_role(['市场部后勤', '市场部管理', '市场一部', '市场二部'])) {
                    $where->where(function ($where) {
                        $where->whereNotIn('mobile_pay', [2, 6, 7, 8, 12, 13, 14, 17, 18, 20, 22, 24, 26, 28, 30, 32, 34, 36, 38, 42, 44, 46, 48])->orwhere(function ($where) {
                            $where->where('mobile_pay', 2)->where(function ($where) {
                                $where->where('order_id', '<=', 367858)->orwhere('order_id', '>', 394321);
                            })->whereNotIn('order_id', [367153, 367774, 367662, 367692, 367493, 367664, 367768, 366777, 367595, 367678, 367836, 367090]);
                        });
                    });
                } else {
                    $where->where(function ($where) {
                        $where->whereNotIn('mobile_pay', [2, 6, 7, 8, 12, 13, 14, 17, 18, 20, 22, 24, 26, 28, 30, 32, 34, 36, 38, 42, 44, 46, 48])->orwhere(function ($where) {
                            $where->where('mobile_pay', 2)->where(function ($where) {
                                $where->where('order_id', '<=', 367858)->orwhere('order_id', '>', 394321);
                            })->whereNotIn('order_id', [367153, 367774, 367662, 367692, 367493, 367664, 367768, 366777, 367595, 367678, 367836, 367090]);
                        });
                    });
                }
            };
        }
        $result = $this->order_list_union($request, $where);
        $this->assign['user'] = $this->user;
        $ub = new UserBumen();
        $this->assign['result'] = $result;
        $this->assign['bumen_arr'] = $ub->bumen();
        $this->assign['ddzt'] = $this->order_status();
        $this->assign['ddbz_arr'] = $this->ddbz_arr();
        $this->assign['zje1'] = $this->zje1;
        $this->assign['zje2'] = $this->zje2;
        $this->assign['zje3'] = $this->zje3;
        $this->assign['zje4'] = $this->zje4;
        $this->assign['zje5'] = $this->zje5;
        $this->assign['tip3'] = route('order.my');
        return view('order.index', $this->assign);
    }

    public function renhe(Request $request)
    {
        $where = function ($where) {
            $where->where('mobile_pay', 31)->where('order_type', 0);
        };
        $result = $this->order_list_union($request, $where);
        $this->assign['user'] = $this->user;
        $ub = new UserBumen();
        $this->assign['result'] = $result;
        $this->assign['bumen_arr'] = $ub->bumen();
        $this->assign['ddzt'] = $this->order_status();
        $this->assign['ddbz_arr'] = $this->ddbz_arr();
        $this->assign['zje1'] = $this->zje1;
        $this->assign['zje2'] = $this->zje2;
        $this->assign['zje3'] = $this->zje3;
        $this->assign['zje4'] = $this->zje4;
        $this->assign['zje5'] = $this->zje5;
        $this->assign['tip3'] = route('order.renhe');
        return view('order.index', $this->assign);
    }

    public function tianlong(Request $request)
    {
        $where = function ($where) {
            $where->where('mobile_pay', 27)->where('order_type', 0);
        };
        $result = $this->order_list_union($request, $where);
        $this->assign['user'] = $this->user;
        $ub = new UserBumen();
        $this->assign['result'] = $result;
        $this->assign['bumen_arr'] = $ub->bumen();
        $this->assign['ddzt'] = $this->order_status();
        $this->assign['ddbz_arr'] = $this->ddbz_arr();
        $this->assign['zje1'] = $this->zje1;
        $this->assign['zje2'] = $this->zje2;
        $this->assign['zje3'] = $this->zje3;
        $this->assign['zje4'] = $this->zje4;
        $this->assign['zje5'] = $this->zje5;
        $this->assign['tip3'] = route('order.tianlong');
        return view('order.index', $this->assign);
    }

    public function sy(Request $request)
    {
        $where = function ($where) {
            $where->where('is_mhj', 2);
        };
        $result = $this->order_list_union($request, $where);
        $this->assign['user'] = $this->user;
        $ub = new UserBumen();
        $this->assign['result'] = $result;
        $this->assign['bumen_arr'] = $ub->bumen();
        $this->assign['ddzt'] = $this->order_status();
        $this->assign['ddbz_arr'] = $this->ddbz_arr();
        $this->assign['zje1'] = $this->zje1;
        $this->assign['zje2'] = $this->zje2;
        $this->assign['tip3'] = route('order.sy');
        return view('order.index', $this->assign);
    }

    public function zq_order_all(Request $request)
    {
        $sort = qckg($request->input('sort', 'order_id'));
        $order = qckg($request->input('order', 'desc'));
        $page_num = intval($request->input('page_num', 15));
        $this->table = 'zq_order';
        $act = qckg($request->input('action', ''));
        $query = $this->query_make($request, 1, 'yyq');
        $this->table = 'zq_order_ywy';
        $query1 = $this->query_make($request, 2, 'yyq');
        $count = $query->count();
        $count += $query1->count();
        $this->zje1 = $query->sum(DB::raw('ecs_oi.goods_amount+ecs_oi.shipping_fee'));
        $this->zje1 += $query1->sum(DB::raw('ecs_oi.goods_amount+ecs_oi.shipping_fee'));
        $this->zje2 = $query->sum('oi.order_amount');
        $this->zje2 += $query1->sum('oi.order_amount');
        $result = $query->unionAll($query1)
            ->orderBy($sort, $order)
            ->orderBy('add_time', 'desc')
            ->union_paginate($page_num, $count);
        $user_rank = user_rank();
        foreach ($result as $v) {
            $v->handle = $this->handle($v->order_id);
            $v->user_rank = isset($v->user_rank) ? $user_rank[$v->user_rank] : '';
            if ($v->is_sync == 1) {
                $v->is_sync = sprintf("<span style='color: red;'>%s</span>", '已回读');//红色
            } else {
                $v->is_sync = '未回读';
            }
            if ($v->is_trans == 1) {
                $v->is_trans = sprintf("<span style='color: red;font-weight: bold'>%s</span>", '已传输');//红色
            } else {
                $v->is_trans = '未传输';
            }
        }
        $order_list = $this->add_params($result, array_merge($request->all(), ['sort' => $sort, 'order' => $order, 'page_num' => $page_num]));
        $sort_arr = [
            'add_time',
            'consignee',
            'goods_amount',
            'order_amount',
            'surplus',
        ];
        $order_list->sort = $this->sort_arr($sort, $order, $order_list->url($order_list->currentPage()), $sort_arr);
        $this->assign['result'] = $result;
        $this->assign['ddzt'] = $this->order_status();
        $this->assign['zq_type'] = 1;
        $this->assign['zje1'] = $this->zje1;
        $this->assign['zje2'] = $this->zje2;
        $this->assign['tip1'] = '账期订单管理';
        $this->assign['tip2'] = '所有账期逾期订单列表';
        $this->assign['tip3'] = route('order.zq_order_all');
        return view('order.zq_order', $this->assign);
    }

    public function zq_order(Request $request)
    {
        $this->table = 'zq_order';
        $act = qckg($request->input('action', ''));
        $result = $this->order_list($request, 1, $act);
        $this->assign['result'] = $result;
        $this->assign['ddzt'] = $this->order_status();
        $this->assign['zq_type'] = 1;
        $this->assign['zje1'] = $this->zje1;
        $this->assign['zje2'] = $this->zje2;
        $this->assign['tip1'] = '账期订单管理';
        $this->assign['tip2'] = '账期订单列表';
        $this->assign['tip3'] = route('order.zq_order', ['action' => $act]);
        return view('order.zq_order', $this->assign);
    }

    public function zq_order_my(Request $request)
    {
        $admin = intval($request->input('admin'));
        if ($admin == 0) {
            $where = function ($where) {
                $where->where($this->search_table . 'ls_zpgly', 'like', '%' . $this->user->name . '%')
                    ->orwhere($this->search_table . 'inv_content', 'like', '%' . $this->user->name . '%')
                    ->orwhere('u.question', 'like', '%' . $this->user->name . '%')
                    ->orwhere($this->search_table . 'card_message', 'like', '%' . $this->user->name . '%');
            };
        } else {
            $where = '';
        }
        $this->table = 'zq_order';
        $act = qckg($request->input('action', ''));
        $result = $this->order_list($request, 1, $act, $where);
        $this->assign['result'] = $result;
        $this->assign['ddzt'] = $this->order_status();
        $this->assign['zq_type'] = 1;
        $this->assign['zje1'] = $this->zje1;
        $this->assign['zje2'] = $this->zje2;
        $this->assign['tip1'] = '账期订单管理';
        $this->assign['tip2'] = '账期订单列表';
        $this->assign['tip3'] = route('order.zq_order_my', ['action' => $act]);
        return view('order.zq_order', $this->assign);
    }

    public function zq_order_ywy(Request $request)
    {
        $this->table = 'zq_order_ywy';
        $act = qckg($request->input('action', ''));
        $result = $this->order_list($request, 2, $act);
        $this->assign['result'] = $result;
        $this->assign['ddzt'] = $this->order_status();
        $this->assign['zq_type'] = 2;
        $this->assign['zje1'] = $this->zje1;
        $this->assign['zje2'] = $this->zje2;
        $this->assign['tip1'] = '业务员账期订单管理';
        $this->assign['tip2'] = '业务员账期订单列表';
        $this->assign['tip3'] = route('order.zq_order_ywy', ['action' => $act]);
        return view('order.zq_order', $this->assign);
    }

    public function zq_order_ywy_my(Request $request)
    {
        $admin = intval($request->input('admin'));
        if ($admin == 0) {
            $where = function ($where) {
                $where->where($this->search_table . 'ls_zpgly', 'like', '%' . $this->user->name . '%')
                    ->orwhere($this->search_table . 'inv_content', 'like', '%' . $this->user->name . '%')
                    ->orwhere('u1.question', 'like', '%' . $this->user->name . '%')
                    ->orwhere($this->search_table . 'card_message', 'like', '%' . $this->user->name . '%');
            };
        } else {
            $where = '';
        }
        $this->table = 'zq_order_ywy';
        $act = qckg($request->input('action', ''));
        $result = $this->order_list($request, 2, $act, $where);
        $this->assign['result'] = $result;
        $this->assign['ddzt'] = $this->order_status();
        $this->assign['zq_type'] = 2;
        $this->assign['zje1'] = $this->zje1;
        $this->assign['zje2'] = $this->zje2;
        $this->assign['tip1'] = '业务员账期订单管理';
        $this->assign['tip2'] = '业务员账期订单列表';
        $this->assign['tip3'] = route('order.zq_order_ywy_my', ['action' => $act]);
        return view('order.zq_order', $this->assign);
    }

    public function zq_order_sy(Request $request)
    {
        $this->table = 'zq_order_sy';
        $act = qckg($request->input('action', ''));
        $result = $this->order_list($request, 3, $act);
        $this->assign['result'] = $result;
        $this->assign['ddzt'] = $this->order_status();
        $this->assign['zq_type'] = 3;
        $this->assign['zje1'] = $this->zje1;
        $this->assign['zje2'] = $this->zje2;
        $this->assign['tip1'] = '尚医账期订单管理';
        $this->assign['tip2'] = '尚医账期订单列表';
        $this->assign['tip3'] = route('order.zq_order_sy', ['action' => $act]);
        return view('order.zq_order', $this->assign);
    }

    public function zq_order_sy_my(Request $request)
    {
        $admin = intval($request->input('admin'));
        if ($admin == 0) {
            $where = function ($where) {
                $where->where($this->search_table . 'ls_zpgly', 'like', '%' . $this->user->name . '%')
                    ->orwhere($this->search_table . 'inv_content', 'like', '%' . $this->user->name . '%')
                    ->orwhere('u1.question', 'like', '%' . $this->user->name . '%')
                    ->orwhere($this->search_table . 'card_message', 'like', '%' . $this->user->name . '%');
            };
        } else {
            $where = '';
        }
        $this->table = 'zq_order_sy';
        $act = qckg($request->input('action', ''));
        $result = $this->order_list($request, 3, $act, $where);
        $this->assign['result'] = $result;
        $this->assign['ddzt'] = $this->order_status();
        $this->assign['zq_type'] = 3;
        $this->assign['zje1'] = $this->zje1;
        $this->assign['zje2'] = $this->zje2;
        $this->assign['tip1'] = '尚医账期订单管理';
        $this->assign['tip2'] = '尚医账期订单列表';
        $this->assign['tip3'] = route('order.zq_order_sy_my', ['action' => $act]);
        return view('order.zq_order', $this->assign);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if ($this->user)
            $url = Cache::tags(['houtai', 'order.index'])->get($this->user->user_id);
        $info = $this->order->with([
            'user' => function ($query) {
                $query->select('user_id', 'msn', 'address_id', 'erp_address');
            },
            'order_action' => function ($query) {
                $query->orderBy('action_id', 'desc');
            },
            'order_goods' => function ($query) {
                $query->with([
                    'goods' => function ($query) {
                        $query->with(['goods_attr', 'goods_attribute', 'spkc_tj'])->select('goods_id', 'goods_number', 'cat_ids', 'jx', 'goods_sn', 'ERPID');
                    },
                    'zp_goods'
                ]);
            }
        ])->find($id);
        if (empty($info)) {
            $info = $this->old_order->with([
                'user' => function ($query) {
                    $query->select('user_id', 'msn', 'erp_address', 'address_id');
                },
                'order_action',
                'order_goods' => function ($query) {
                    $query->with([
                        'goods' => function ($query) {
                            $query->with(['goods_attr', 'goods_attribute'])->select('goods_id', 'goods_number', 'cat_ids', 'jx', 'goods_sn');
                        }
                    ]);
                }
            ])->find($id);
        }
        if (empty($info)) {
            error_msg('订单不存在');
        }
        if (has_role('仁和厂家') && !($info->mobile_pay == 31 && $info->order_type == 0)) {
            error_msg('没有权限访问');
        }
        $goods_lb = [
            '西药及其他药品' => [
                'list' => collect(),
                'amount' => 0,
            ],
            '麻黄碱' => [
                'list' => collect(),
                'amount' => 0,
            ],
            '赠品' => [
                'list' => collect(),
                'amount' => 0,
            ],
            'erp开赠品' => [
                'list' => collect(),
                'amount' => 0,
            ],
            '计生用品' => [
                'list' => collect(),
                'amount' => 0,
            ],
            '针剂' => [
                'list' => collect(),
                'amount' => 0,
            ],
            '中药饮片' => [
                'list' => collect(),
                'amount' => 0,
            ],
        ];
        if (count($info->order_goods) > 0) {
            foreach ($info->order_goods as $k => $v) {
				
                $v->goods = $v->goods->get_attr($v->goods);
                $v->subtotal = $v->goods_number * $v->goods_price;
                $v->paixu = $k + 1;
                $arr = [];
                $arr[] = $v;
                if (in_array(180, $v->goods->cat_ids)) {
                    $goods_lb['麻黄碱']['list'][] = $v;
                    $goods_lb['麻黄碱']['amount'] += $v->subtotal;
                } elseif ($v->parent_id > 0) {
                    $goods_lb['赠品']['list'][] = $v;
                    $goods_lb['赠品']['amount'] += $v->subtotal;
                } elseif (strpos($v->tsbz, 'z') !== false) {
                    $goods_lb['erp开赠品']['list'][] = $v;
                    $goods_lb['erp开赠品']['amount'] += $v->subtotal;
                } elseif (in_array(20, $v->goods->cat_ids)) {
                    $goods_lb['计生用品']['list'][] = $v;
                    $goods_lb['计生用品']['amount'] += $v->subtotal;
                } elseif ($v->goods->jx == '注射剂') {
                    $goods_lb['针剂']['list'][] = $v;
                    $goods_lb['针剂']['amount'] += $v->subtotal;
                } elseif ($v->is_zyyp == 1) {
                    $goods_lb['中药饮片']['list'][] = $v;
                    $goods_lb['中药饮片']['amount'] += $v->subtotal;
                } else {
                    $goods_lb['西药及其他药品']['list'][] = $v;
                    $goods_lb['西药及其他药品']['amount'] += $v->subtotal;
                }
                //dd($v->goods);
            }
        }
		

        $jp_points = $info->order_goods->sum(function ($item) {
            $total = 0;
            if ($item->is_jp == 1) {
                $total = $item->goods_price * $item->goods_number;
            }
            return intval($total);
        });
        $old_jp_points = $info->order_goods->sum(function ($item) {
            $total = 0;
            if ($item->is_jp == 1) {
                $total = $item->goods_price * $item->goods_number_f;
            }
            return intval($total);
        });

        $user_address = UserAddress::where('address_id', $info->user->address_id)->where('user_id', $info->user_id)->value('address');
        $status_btn = $this->status_btn($info);
        $links = '<a class="btn btn-success radius r" style="margin-top:3px;margin-right:5px;" onclick="shuaxin(\'' . $url . '\')">订单列表</a>';
        $this->assign['info'] = $info;
        $this->assign['user'] = get_user_info($info->user_id);
        $this->assign['links'] = $links;
        $this->assign['goods_lb'] = $goods_lb;
        $this->assign['jp_points'] = $jp_points;
        $this->assign['user_address'] = $user_address;
        $this->assign['status_btn'] = $status_btn;
        $this->assign['old_jp_points'] = $old_jp_points;
        $this->assign['tip2'] = '查看订单详情';
        $this->assign['tip3'] = route('order.show', ['id' => $info->order_id]);
        if (has_role('监管')) {
            return view('order.simple_show', $this->assign);
        }
        //dd($this->assign);
        return view('order.show', $this->assign);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }


    private function zje()
    {
        $where = function ($where) {
            $where->whereNotIn('mobile_pay', [2, 6, 7, 8, 12, 13, 14, 17, 18, 20, 22, 24, 26, 28, 30, 32, 34, 36, 38, 42, 44, 46, 48])->orwhere(function ($where) {
                $where->where('mobile_pay', 2)->where(function ($where) {
                    $where->where('order_id', '<=', 367858)->orwhere('order_id', '>', 394321);
                })->whereNotIn('order_id', [367153, 367774, 367662, 367692, 367493, 367664, 367768, 366777, 367595, 367678, 367836, 367090]);;
            });
        };
        $total = $this->order->where($where)->where('order_status', '!=', 2)->where('mobile_pay', '!=', -2)
            ->where('add_time', '>=', strtotime(20180101))->where('add_time', '<', strtotime(20190101))
            ->sum(DB::raw('goods_amount+shipping_fee'));
        return $total;
        return $total + 299096723.28;
    }

    public function merge_order(Request $request)
    {
        $ids = qckg($request->input('ids'), ',');
        $ids = explode(',', $ids);
        if (!isset($ids[0]) || !isset($ids[1]) || count($ids) > 2) {
            $this->merge_error('只能合并两个订单');
        }
        sort($ids);
        $from_order = get_order_info($ids[0]);
        $to_order = get_order_info($ids[1]);
        if ($from_order->o_paid > 0 || $to_order->o_paid > 0) {
            $this->merge_error('在线支付订单不能合并');
        }
        if ($from_order->mobile_pay >= 2 || $to_order->mobile_pay >= 2) {
            $this->merge_error('业务员订单不能合并');
        }
        if ($from_order->user_id != $to_order->user_id) {
            $this->merge_error('订单不属于同一个会员');
        }
        if ($from_order->order_status == 2 || $to_order->order_status == 2) {
            $this->merge_error('已取消订单不能合并');
        }
        if ($from_order->pay_status == 2 || $to_order->pay_status == 2) {
            $this->merge_error('已付款订单不能合并');
        }
        if ($from_order->is_trans == 1 || $to_order->is_trans == 1) {
            $this->merge_error('已传输订单不能合并');
        }
        if ($from_order->shipping_status > 0 || $to_order->shipping_status > 0) {
            $this->merge_error('已开票订单不能合并');
        }
        if ($from_order->is_zq > 0 || $to_order->is_zq > 0) {
            $this->merge_error('账期订单不能合并');
        }
        if (($from_order->mobile_pay == 2 && $to_order->mobile_pay != 2) || ($from_order->mobile_pay != 2 && $to_order->mobile_pay == 2)) {
            $this->merge_error('业务员订单不能和其他订单合并');
        }
        if (($from_order->mobile_pay == -1 && $to_order->mobile_pay != -1) || ($from_order->mobile_pay != -1 && $to_order->mobile_pay == -1)) {
            $this->merge_error('预售订单不能和其他订单合并');
        }
//        if ($from_order->is_zy == 3 || $to_order->is_zy == 3) {
//            $this->merge_error('换购商品不能合并');
//        }
        if ($from_order->is_mhj != $to_order->is_mhj) {
            $this->merge_error('不是同类型订单不能合并');
        }
        if ($from_order->extension_code != $to_order->extension_code) {
            $this->merge_error('不同折扣订单不能合并');
        }
//        if ($from_order->pack_fee > 0 || $to_order->pack_fee > 0) {
//            $this->merge_error('使用优惠券订单不能合并');
//        }
        if ($from_order->money_paid > 0 || $to_order->money_paid > 0) {
            $this->merge_error('使用已付款金额订单不能合并');
        }
//        if ($from_order->surplus > 0 || $to_order->surplus > 0) {
//            $this->merge_error('使用余额订单不能合并');
//        }
        if ($from_order->jnmj > 0 || $to_order->jnmj > 0) {
            $this->merge_error('使用充值余额订单不能合并');
        }
        $from_order->load('order_goods');
        $to_order->load('order_goods');
        $user = get_user_info($to_order->user_id);
        $user = $user->is_new_user();
        $bm_id = intval(UserBumen::where('user_id', $user->user_id)->value('bm_id'));
        $this->order_user = $user;
        $address = UserAddress::where('address_id', $user->address_id)->where('user_id', $user->user_id)->first();
        if (empty($address)) {
            error_msg('收货地址不存在');
        }
        $time = time();
        $this->order = new OrderInfo();
        $this->order->setRelation('user_info', $user);
        $this->order->order_sn = $this->get_order_sn($user->user_id);
        $this->order->user_id = $user->user_id;
        $this->order->bm_id = $bm_id;
        $this->order->msn = $user->msn;
        $this->order->ls_zpgly = $user->ls_zpgly;
        $this->order->consignee = $address->consignee;
        $this->order->country = $address->country;
        $this->order->province = $address->province;
        $this->order->city = $address->city;
        $this->order->district = $address->district;
        $this->order->address = $address->address;
        $this->order->zipcode = $address->zipcode;
        $this->order->tel = $address->tel;
        $this->order->mobile = $address->mobile;
        $this->order->email = $address->email;
        $this->order->best_time = $address->best_time;
        $this->order->sign_building = $address->sign_building;
        $this->order->postscript = $to_order->postscript;
        $this->order->shipping_id = $user->shipping_id;
        $this->order->shipping_name = $user->shipping_name;
        $this->order->wl_dh = $user->wl_dh;
        $this->order->pay_id = 2;
        $this->order->pay_name = '银行汇款/转帐';
        $this->order->referer = $to_order->referer;
        $this->order->add_time = $time;
        $this->order->confirm_time = $time;
        $this->order->mobile_pay = $to_order->mobile_pay;
        $this->order->is_xkh = 0;
        $this->order->how_oos = $to_order->how_oos;
        $this->order->goods_amount = 0;
        $this->order->shipping_fee = 0;
        $this->order->surplus = $from_order->surplus + $to_order->surplus;
        $this->order->order_amount = 0;
        $this->order->jp_points = 0;
        $this->order->zyzk = 0;
        $this->order->jnmj = 0;
        $this->order->pack_fee = $to_order->pack_fee + $from_order->pack_fee;
        $this->order->cz_money = $to_order->cz_money + $from_order->cz_money;
        $this->order->jf_money = $to_order->jf_money + $from_order->jf_money;
        $this->order->hongbao_money = $to_order->hongbao_money + $from_order->hongbao_money;
        $this->order->card_fee = 0;
        $this->order->pay_fee = 0;
        $this->order->dzfp = $user->dzfp;
        $this->order->is_mhj = $to_order->is_mhj;
        $this->order->discount = $to_order->discount;
        $this->order->is_zy = $to_order->is_zy;
        $this->order->change_status = 1;
        $this->order->inv_payee = '';
        if ($this->order->mobile_pay == 2) {
            $this->order->card_name = $user->answer;
            $this->order->card_message = $user->passwd_question;
        } else {
            $this->order->inv_content = is_null($user->question) ? '' : $user->question;
        }
        $this->order->pack_id = $user->sex;
        $this->order->is_gtkf = $user->is_gtkf;
        $this->order->agency_id = 0;
        $this->order->inv_type = 0;
        $this->order->tax = 0;
        $this->order->o_paid = 0;
        $this->order->order_status = 1;
        $this->order->pay_status = 0;
        $this->order->shipping_status = 0;
        $cf_ids = [];
        $gcp_num = 0;
        //dd($this->order);
        foreach ($to_order->order_goods as $order_goods) {
            if ($to_order->is_mhj == 1 && strpos($order_goods->goods_name, '甘草片') !== false) {
                $gcp_num += $order_goods->goods_number;
            }
            $goods = $from_order->order_goods->where('goods_id', $order_goods->goods_id)->first();
            if (!$goods) {
                $this->order->order_goods[] = $order_goods;
            } else {
                //$this->merge_error('存在相同商品');
                $this->check_diff($goods, $order_goods);
                $cf_ids[] = $order_goods->goods_id;
                $order_goods->goods_number = $order_goods->goods_number + $goods->goods_number;
                $order_goods->goods_number_f = $order_goods->goods_number;
                $this->order->order_goods[] = $order_goods;

            }
        }
        foreach ($from_order->order_goods as $k => $order_goods) {
            if (!in_array($order_goods->goods_id, $cf_ids)) {
                if ($from_order->is_mhj == 1 && strpos($order_goods->goods_name, '甘草片') !== false) {
                    $gcp_num += $order_goods->goods_number;
                }
                $goods = $to_order->order_goods->where('goods_id', $order_goods->goods_id)->first();
                if (!$goods) {
                    $this->order->order_goods[] = $order_goods;
                } else {
                    $this->check_diff($goods, $order_goods);
                }
            }
        }
        if ($gcp_num > 720 && $user->is_zhongduan == 1) {
            $this->merge_error('甘草片数量超过720不能合并');
        }
        $goods_amount = $this->order->order_goods->sum(function ($item) {
            return $item->goods_price * $item->goods_number;
        });
        $zyzk = $this->order->order_goods->sum(function ($item) {
            return $item->zyzk * $item->goods_number;
        });
        $jp_points = $this->order->order_goods->sum(function ($item) {
            $total = 0;
            if ($item->is_jp == 1) {
                $total = $item->goods_price * $item->goods_number;
            }
            return intval($total);
        });
        $card_fee = $this->order->order_goods->sum(function ($item) {
            $total = 0;
            if ($item->goods->hy_price > 0) {
                $total = $item->goods_price * $item->goods_number;
            }
            return $total;
        });
        $pay_fee = $this->order->order_goods->sum(function ($item) {
            $total = 0;
            if (strpos($item->tsbz, 'k') !== false) {
                $total = $item->goods_price * $item->goods_number;
            }
            return $total;
        });
        $shipping_fee = $this->order->shipping_fee;
        if ($this->user->shipping_name == '京东直达	' && $this->order['goods_amount'] < 1000 && $this->order['has_ys'] == 0) {
            if ($this->order['goods_amount']<=500){
                $this->order['shipping_fee'] = 12;
            }else{
                $this->order['shipping_fee'] = 24;
            }
        }
        $is_hd_order = is_hd_order($this->order->add_time);
        if ($is_hd_order == 1) {
            $shipping_fee = 0;
        }
        $is_hd_order1 = is_hd_order($from_order->add_time);
        $is_hd_order2 = is_hd_order($to_order->add_time);
        if ($is_hd_order1 != $is_hd_order2 && !has_role('administrator')) {
            $this->merge_error('活动订单不能和其他订单合并');
        }
        if ($is_hd_order1 >= 1) {
            $this->order->add_time = $from_order->add_time;
        } elseif ($is_hd_order2 >= 1) {
            $this->order->add_time = $to_order->add_time;
        } else {
            $this->order->add_time = time();
        }
        //$this->order->pack_fee = $this->manjian($this->order->pack_fee);
        $order_amount = order_amount($this->order,
            ['goods_amount' => $goods_amount, 'zyzk' => $zyzk, 'shipping_fee' => $shipping_fee]);
        $inputs = [
            'goods_amount' => $goods_amount,
            'order_amount' => $order_amount,
            'shipping_fee' => $shipping_fee,
            'zyzk' => $zyzk,
            'card_fee' => $card_fee,
            'pay_fee' => $pay_fee,
        ];
        /* 检查精品专区购买的金额是否满足活动要求，满足则查询相应的礼品信息 */
        $gift_list = $this->jpzq($jp_points);
        $inputs = $this->jpzq_attr($gift_list, $inputs, $jp_points);
        $change_desc = [];
        $change_count = 0;
        $result = union_log($inputs, $this->order, $change_desc, $change_count, 'order');
        $flag = DB::transaction(function () use ($result, $from_order, $to_order, $cf_ids) {
            $this->order = $result['info'];
            $change_count = $result['change_count'];
            if ($change_count > 0) {
                $this->order->order_sn = $this->get_order_sn($this->order->user_id);
                $change_desc = "合并订单:" . $from_order->order_sn . "(商品总金额:" . $from_order->goods_amount .
                    ",运费:" . $from_order->shipping_fee . ")与" . $to_order->order_sn . "(商品总金额:" . $to_order->goods_amount .
                    ",运费:" . $to_order->shipping_fee . ")到新订单:" . $this->order->order_sn . "(商品总金额:" . $this->order->goods_amount .
                    ",运费:" . $this->order->shipping_fee . ")";
                $this->order->save();
                if ($this->order->order_id == 0) {
                    return 2;
                }
                admin_log($change_desc);
                OrderGoods::where('order_id', $to_order->order_id)->update([
                    'order_id' => $this->order->order_id
                ]);
                OrderGoods::whereNotIn('goods_id', $cf_ids)->where('order_id', $from_order->order_id)->update([
                    'order_id' => $this->order->order_id
                ]);
                foreach ($from_order->order_goods as $order_goods) {
                    if (in_array($order_goods->goods_id, $cf_ids)) {
                        OrderGoods::where('order_id', $this->order->order_id)
                            ->where('goods_id', $order_goods->goods_id)->update([
                                'goods_number' => DB::raw("goods_number+" . $order_goods->goods_number),
                                'goods_number_f' => DB::raw("goods_number_f+" . $order_goods->goods_number_f),
                            ]);
                    }
                }
                Yhq::whereIn('order_id', [$to_order->order_id, $from_order->order_id])->update([
                    'order_id' => $this->order->order_id
                ]);
                OrderGoods::whereIn('goods_id', $cf_ids)->where('order_id', $from_order->order_id)->delete();
                order_action($this->order, $change_desc);
                $to_order->delete();
                $from_order->delete();
            }
        });
        if ($flag == 2) {
            error_msg('订单合并失败', [route('order.show', ['id' => $this->order->order_id]) => '查看订单信息'], 'msg_simple', route('order.show', ['id' => $this->order->order_id]));
        }
        $trans = env('TRANS', false);
        if ($trans == true) {
            $this->delOrder($from_order->order_sn, 1);
            $this->delOrder($to_order->order_sn, 1);
            $this->toErp();
        }
        DB::transaction(function () use ($from_order, $to_order) {
            DB::table('zfsb_order')->insert([
                'order_sn' => $from_order->order_sn,
                'type' => 0,
            ]);
            DB::table('zfsb_order')->insert([
                'order_sn' => $to_order->order_sn,
                'type' => 0,
            ]);
        });
        if (count($gift_list) > 0 && $this->has_gift == 0) {
            return redirect()->route('order_edit.index', ['id' => $this->order->order_id, 'action' => 'gift_goods']);
        }
        success_msg('订单合并成功', [route('order.show', ['id' => $this->order->order_id]) => '查看订单信息'], 'msg_simple', route('order.show', ['id' => $this->order->order_id]));
    }

    private function order_list_union($request, $where = [])
    {
        $this->search_table = '';
        $ks = $request->input('ks', '2018-03-01');//时间查询 开始
        $js = $request->input('js', date('Y-m-d', strtotime('+1 day')));//时间查询 结束
        $order_sn = qckg($request->input('order_sn', ''));
        $user_id = intval($request->input('user_id'));
        $consignee = qckg($request->input('consignee', ''));
        $order_status = qckg($request->input('order_status', ''));
        $msn = qckg($request->input('msn', ''));
        $gly = qckg($request->input('gly', ''));
        $jqcz = qckg($request->input('jqcz', ''));
        $is_trans = intval($request->input('is_trans'));
        $ddbz = intval($request->input('ddbz'));
        $province = intval($request->input('province'));
        $city = intval($request->input('city'));
        $district = intval($request->input('district'));
        $admin = intval($request->input('admin'));
        $bm_id = intval($request->input('bm_id'));
        $union = strtotime(union_tb());//查询时间小于这个 连表查询
        $sort = qckg($request->input('sort', 'add_time'));
        $order = qckg($request->input('order', 'desc'));
        $page_num = intval($request->input('page_num', 15));
        $group_ywy = intval($request->input('group_ywy'));

        $query = $this->order->with([
            'user' => function ($query) {
                $query->select('user_id', 'msn', 'user_name', 'user_rank');
            }
        ])->where(function ($where) use ($ddbz) {
            if ($ddbz == 22) {
                //dd(666);
                $where->where('add_time', '>=', strtotime(20180119));
            } else {
                //dd(555);
                $where->where('mobile_pay', '!=', -2);
            }
            //$where->where('mobile_pay', '!=', -2);
        });


        $query1 = $this->old_order->with([
            'user' => function ($query) {
                $query->select('user_id', 'msn', 'user_name', 'user_rank');
            }
        ]);
        if ($this->user->is_tx == 1) {
            $query->where('city', 330);
            $query1->where('city', 330);
        }
        if ($where instanceof \Closure) {
            $query->where($where);
            $query1->where($where);
        }
        if (has_role('监管')) {
            $query->where('is_mhj', 0);
            $query1->where('is_mhj', 0);
        }
        if ($bm_id > 0) {
            $query->where('bm_id', $bm_id - 1);
            $query1->where('bm_id', $bm_id - 1);
        }
        if ($group_ywy > 0) {
            $query->where('bonus_id', $group_ywy);
        } elseif ($group_ywy == -1) {
            $query->whereIn('mobile_pay', [2, 6]);
        }
        if (!empty($ks)) {
            $query->where('add_time', '>=', strtotime($ks));
            $query1->where('add_time', '>=', strtotime($ks));
        }
        if (!empty($js)) {
            $query->where('add_time', '<', strtotime($js));
            $query1->where('add_time', '<', strtotime($js));
        }
        if (!empty($order_sn)) {
            $query->where('order_sn', 'like', '%' . $order_sn . '%');
            $query1->where('order_sn', 'like', '%' . $order_sn . '%');
        }
        if (!empty($msn)) {
            $query->where('msn', 'like', '%' . $msn . '%');
            $query1->where('msn', 'like', '%' . $msn . '%');
        }
        if (!empty($gly)) {
            $query->where(function ($where) use ($gly) {
                $where->where('ls_zpgly', 'like', '%' . $gly . '%')
                    ->orwhere('inv_content', 'like', '%' . $gly . '%')
                    ->orwhere('card_message', 'like', '%' . $gly . '%');
            });
            $query1->where(function ($where) use ($gly) {
                $where->where('ls_zpgly', 'like', '%' . $gly . '%')
                    ->orwhere('inv_content', 'like', '%' . $gly . '%')
                    ->orwhere('card_message', 'like', '%' . $gly . '%');
            });
        }
        if ($is_trans > 0) {
            $query->where('is_trans', $is_trans - 1)->where('mobile_pay', '!=', -2);
            $query1->where('is_trans', $is_trans - 1)->where('mobile_pay', '!=', -2);
        }
        if (!empty($consignee)) {
            $query->where(function ($where) use ($consignee) {
                $where->where('consignee', 'like', '%' . $consignee . '%')
                    ->orwhere('tel', 'like', '%' . $consignee . '%')
                    ->orwhere('shipping_name', 'like', '%' . $consignee . '%');
            });
            $query1->where(function ($where) use ($consignee) {
                $where->where('consignee', 'like', '%' . $consignee . '%')
                    ->orwhere('tel', 'like', '%' . $consignee . '%')
                    ->orwhere('shipping_name', 'like', '%' . $consignee . '%');
            });
        }
        if ($order_status > 0) {
            switch ($order_status) {
                case 1:
                    $query->where('pay_status', '!=', 2);
                    $query1->where('pay_status', '!=', 2);
                    break;
                case 2:
                    $query->where('pay_status', 2);
                    $query1->where('pay_status', 2);
                    break;
                case 3:
                    $query->where('shipping_status', 0)->where('is_trans', 1);
                    $query1->where('shipping_status', 0)->where('is_trans', 1);
                    break;
                case 4:
                    $query->where('shipping_status', 1)->where('is_trans', 1);
                    $query1->where('shipping_status', 1)->where('is_trans', 1);
                    break;
                case 5:
                    $query->where('shipping_status', 2)->where('is_trans', 1);
                    $query1->where('shipping_status', 2)->where('is_trans', 1);
                    break;
                case 6:
                    $query->where('pay_status', 2)->where('shipping_status', 3)->where('is_trans', 1);
                    $query1->where('pay_status', 2)->where('shipping_status', 3)->where('is_trans', 1);
                    break;
                case 7:
                    $query->where('shipping_status', 4)->where('is_trans', 1);
                    $query1->where('shipping_status', 4)->where('is_trans', 1);
                    break;
                case 8:
                    $query->where('shipping_status', 5)->where('is_trans', 1);
                    $query1->where('shipping_status', 5)->where('is_trans', 1);
                    break;
                case 9:
                    $query->where('order_status', 2);
                    $query1->where('order_status', 2);
                    break;
            }
        }
        if ($order_status != 9) {
            $query->where('order_status', '!=', 2);
            $query1->where('order_status', '!=', 2);
        }
        if ($jqcz > 0) {
            switch ($jqcz) {
                case 1:
                    $query->where('ls_zpgly', '!=', '')
                        ->where('inv_content', '')->where('card_message', '')
                        ->where('inv_payee', '');
                    $query1->where('ls_zpgly', '!=', '')
                        ->where('inv_content', '')->where('card_message', '')
                        ->where('inv_payee', '');
                    break;
                case 3:
                    $query->where('inv_content', '');
                    $query1->where('inv_content', '');
                    break;
                case 2:
                    $query->where('card_message', '')->where('inv_content', '!=', '');
                    $query1->where('card_message', '')->where('inv_content', '!=', '');
                    break;
                case 4:
                    $query->where('card_message', '')->where('inv_content', '')->where('inv_payee', '!=', '');
                    $query1->where('card_message', '')->where('inv_content', '')->where('inv_payee', '!=', '');
                    break;
                case 5:
                    $query->where(function ($where) {
                        $where->where('card_message', '!=', '')
                            ->orwhere('inv_content', '!=', '')
                            ->orwhere('inv_payee', '');
                    });
                    $query1->where(function ($where) {
                        $where->where('card_message', '!=', '')
                            ->orwhere('inv_content', '!=', '')
                            ->orwhere('inv_payee', '');
                    });
                    break;

            }
        }
        if ($ddbz > 0) {
            switch ($ddbz) {
                case 1:
                    $query->where('is_xkh', 1);
                    $query1->where('is_xkh', 1);
                    break;
                case 2:
                    $query->where('is_separate', 1);
                    $query1->where('is_separate', 1);
                    break;
                case 3:
                    $query->where('jnmj', '>', 0);
                    $query1->where('jnmj', '>', 0);
                    break;
                case 4:
                    $query->where('is_zq', '>', 0);
                    $query1->where('is_zq', '>', 0);
                    break;
                case 5:
                    $query->where('dzfp', 2);
                    $query1->where('dzfp', 2);
                    break;
                case 6:
                    $query->where('pay_id', 6)->where('qid', '!=', '');
                    $query1->where('pay_id', 6)->where('qid', '!=', '');
                    break;
                case 7:
                    $query->where('pay_id', 4)->where('qid', '!=', '');
                    $query1->where('pay_id', 4)->where('qid', '!=', '');
                    break;
                case 10:
                    $query->where('pay_id', 7)->where('qid', '!=', '');
                    $query1->where('pay_id', 7)->where('qid', '!=', '');
                    break;
                case 8:
                    $query->whereIn('mobile_pay', [2, 3, 4, 5, 9, 10, 11, 15, 16, 19, 21, 23, 25, 27, 29, 31, 33, 35, 37, 41, 43, 45, 47]);
                    $query1->whereIn('mobile_pay', [2, 3, 4, 5, 9, 10, 11, 15, 16, 19, 21, 23, 25, 27, 29, 31, 33, 35, 37, 41, 43, 45, 47]);
                    break;
                case 9:
                    $query->where('mobile_pay', 1);
                    $query1->where('mobile_pay', 1);
                    break;
                case 11:
                    $query->where('is_zq', 2);
                    $query1->where('is_zq', 2);
                    break;
                case 12:
                    $query->where('pack_id', 3);
                    $query1->where('pack_id', 3);
                    break;
                case 13:
                    $query->where('is_separate', 1)->where('mobile_pay', 2);
                    $query1->where('is_separate', 1)->where('mobile_pay', 2);
                    break;
                case 14:
                    $query->where('pack_fee', '>', 0);
                    $query1->where('pack_fee', '>', 0);
                    break;
                case 15:
                    $query->where('is_mhj', 2);
                    $query1->where('is_mhj', 2);
                    break;
                case 16:
                    $query->where('is_gtkf', 1);
                    $query1->where('is_gtkf', 1);
                    break;
                case 17:
                    $query->where('mobile_pay', 3);
                    $query1->where('mobile_pay', 3);
                    break;
                case 18:
                    $query->where('is_mhj', 2)->where('order_id', '>', 380700);
                    $query1->where('is_mhj', 2)->where('order_id', '>', 380700);
                    break;
                case 19:
                    $query->where('pay_id', 12)->where('qid', '!=', '');
                    $query1->where('pay_id', 12)->where('qid', '!=', '');
                    break;
                case 20:
                    $query->where('is_mhj', 1);
                    $query1->where('is_mhj', 1);
                    break;
                case 21:
                    $query->where('is_admin', 1);
                    $query1->where('is_admin', 1);
                    break;
                case 22:
                    $query->where('mobile_pay', -2);
                    $query1->where('mobile_pay', -2);
                    break;
                case 23:
                    $query->where('mobile_pay', -1);
                    $query1->where('mobile_pay', -1);
                    break;
                case 24:
                    $query->where('is_mhj', 1)->where('is_mhj_tx', 1);
                    $query1->where('is_mhj', 1)->where('is_mhj_tx', 1);
                    break;
                case 25:
                    $query->where('is_mhj', 1)->where('is_mhj_tx', 0);
                    $query1->where('is_mhj', 1)->where('is_mhj_tx', 0);
                    break;
                case 26:
                    $query->where('mobile_pay', -3);
                    $query1->where('mobile_pay', -3);
                    break;
                case 27:
                    $query->where('pay_id', 11)->where('qid', '!=', '');
                    $query1->where('pay_id', 11)->where('qid', '!=', '');
                    break;
            }
        }
        if ($user_id > 0) {
            $query->where('user_id', $user_id);
            $query1->where('user_id', $user_id);
        }
        if ($province > 0) {
            $query->where('province', $province);
            $query1->where('province', $province);
        }
        if ($city > 0) {
            $query->where('city', $city);
            $query1->where('city', $city);
        }
        if ($district > 0) {
            $query->where('district', $district);
            $query1->where('district', $district);
        }
        switch ($admin) {
            case 1://下属管理员
                $this->user->load([
                    'child' => function ($child) {
                        $child->select('user_id', 'name', 'pid')->with([
                            'child' => function ($child) {
                                $child->select('user_id', 'name', 'pid')->with([
                                    'child' => function ($child) {
                                        $child->select('user_id', 'name', 'pid');
                                    }
                                ]);
                            }
                        ]);
                    }
                ]);
                if (count($this->user->child) > 0) {
                    $query->where(function ($where) {
                        foreach ($this->user->child as $child) {
                            $where->orwhere(function ($where) use ($child) {
                                $where->where('ls_zpgly', 'like', '%' . $child->name . '%')
                                    ->orwhere('inv_content', 'like', '%' . $child->name . '%')
                                    ->orwhere('card_message', 'like', '%' . $child->name . '%');
                                foreach ($child->child as $v) {
                                    $where->orwhere(function ($where) use ($v) {
                                        $where->where('ls_zpgly', 'like', '%' . $v->name . '%')
                                            ->orwhere('inv_content', 'like', '%' . $v->name . '%')
                                            ->orwhere('card_message', 'like', '%' . $v->name . '%');
                                        foreach ($v->child as $val) {
                                            $where->orwhere(function ($where) use ($val) {
                                                $where->where('ls_zpgly', 'like', '%' . $val->name . '%')
                                                    ->orwhere('inv_content', 'like', '%' . $val->name . '%')
                                                    ->orwhere('card_message', 'like', '%' . $val->name . '%');
                                            });
                                        }
                                    });
                                }
                            });
                        }
                    });
                    $query1->where(function ($where) {
                        foreach ($this->user->child as $child) {
                            $where->where(function ($where) use ($child) {
                                $where->where('ls_zpgly', 'like', '%' . $child->name . '%')
                                    ->orwhere('inv_content', 'like', '%' . $child->name . '%')
                                    ->orwhere('card_message', 'like', '%' . $child->name . '%');
                                foreach ($child->child as $v) {
                                    $where->orwhere(function ($where) use ($v) {
                                        $where->where('ls_zpgly', 'like', '%' . $v->name . '%')
                                            ->orwhere('inv_content', 'like', '%' . $v->name . '%')
                                            ->orwhere('card_message', 'like', '%' . $v->name . '%');
                                        foreach ($v->child as $val) {
                                            $where->orwhere(function ($where) use ($val) {
                                                $where->where('ls_zpgly', 'like', '%' . $val->name . '%')
                                                    ->orwhere('inv_content', 'like', '%' . $val->name . '%')
                                                    ->orwhere('card_message', 'like', '%' . $val->name . '%');
                                            });
                                        }
                                    });

                                }
                            });
                        }
                    });
                } else {
                    $query->whereRaw('1=0');
                    $query1->whereRaw('1=0');
                }
                break;
            case 2://只查admin
                $query->where(function ($where) {
                    $where->where('ls_zpgly', 'like', '%admin%')
                        ->orwhere('inv_content', 'like', '%admin%')
                        ->orwhere('card_message', 'like', '%admin%');
                });
                $query1->where(function ($where) {
                    $where->where('ls_zpgly', 'like', '%admin%')
                        ->orwhere('inv_content', 'like', '%admin%')
                        ->orwhere('card_message', 'like', '%admin%');
                });
                break;
            case 3://查询未分配管理员的
                $query->where(function ($where) {
                    $where->where('ls_zpgly', '')
                        ->orwhereNull('ls_zpgly');
                });
                $query1->where(function ($where) {
                    $where->where('ls_zpgly', '')
                        ->orwhereNull('ls_zpgly');
                });
                break;
        }
        if (strtotime($ks) < $union && strtotime($js) > $union) {//联表查询
            $qiuhe_query = clone $query;
            $qiuhe_query1 = clone $query1;
            $qiuhe = $qiuhe_query->selectRaw('count(*) as num,sum(goods_amount+shipping_fee) as zje1
            ,sum(order_amount) as zje2,sum(pay_fee) as zje3,sum(card_fee) as zje4,sum(goods_amount-zyzk-pay_fee-card_fee) as zje5')->first();
            $qiuhe1 = $qiuhe_query1->selectRaw('count(*) as  num,sum(goods_amount+shipping_fee) as zje1
            ,sum(order_amount) as zje2,sum(pay_fee) as zje3,sum(card_fee) as zje4,sum(goods_amount-zyzk-pay_fee-card_fee) as zje5')->first();
            $this->zje1 = $qiuhe->zje1 + $qiuhe1->zje1;
            $this->zje2 = $qiuhe->zje2 + $qiuhe1->zje2;
            $this->zje3 = $qiuhe->zje3 + $qiuhe1->zje3;
            $this->zje4 = $qiuhe->zje4 + $qiuhe1->zje4;
            $this->zje5 = $qiuhe->zje5 + $qiuhe1->zje5;
            $page = intval($request->input('page', 1));
            $query1 = $query1->select($this->select_str())->orderBy($sort, $order)->take($page_num * $page)
                ->orderBy('add_time', 'desc');
            $order_list = $query->orderBy($sort, $order)->take($page_num * $page)->unionAll($query1)
                ->select($this->select_str())
                ->orderBy($sort, $order)
                ->orderBy('order_id', 'desc')
                ->union_paginate($page_num, $qiuhe1->num + $qiuhe->num);
        } elseif (strtotime($js) <= $union) {//查询旧表
            $qiuhe_query = clone $query;
            $qiuhe_query1 = clone $query1;
            $qiuhe = $qiuhe_query->selectRaw('count(*) as num,sum(goods_amount+shipping_fee) as zje1
            ,sum(order_amount) as zje2,sum(pay_fee) as zje3,sum(card_fee) as zje4,sum(goods_amount-zyzk-pay_fee-card_fee) as zje5')->first();
            $qiuhe1 = $qiuhe_query1->selectRaw('count(*) as  num,sum(goods_amount+shipping_fee) as zje1
            ,sum(order_amount) as zje2,sum(pay_fee) as zje3,sum(card_fee) as zje4,sum(goods_amount-zyzk-pay_fee-card_fee) as zje5')->first();
            $this->zje1 = $qiuhe->zje1 + $qiuhe1->zje1;
            $this->zje2 = $qiuhe->zje2 + $qiuhe1->zje2;
            $this->zje3 = $qiuhe->zje3 + $qiuhe1->zje3;
            $this->zje4 = $qiuhe->zje4 + $qiuhe1->zje4;
            $this->zje5 = $qiuhe->zje5 + $qiuhe1->zje5;
            $page = intval($request->input('page', 1));
            $query1 = $query1->select($this->select_str())->orderBy($sort, $order)->take($page_num * $page)
                ->orderBy('add_time', 'desc');
            $order_list = $query->orderBy($sort, $order)->take($page_num * $page)->unionAll($query1)
                ->select($this->select_str())
                ->orderBy($sort, $order)
                ->orderBy('add_time', 'desc')
                ->union_paginate($page_num, $qiuhe1->num + $qiuhe->num);
        } else {
            $qiuhe_query = clone $query;
            $qiuhe = $qiuhe_query->selectRaw('count(*) as num,sum(goods_amount+shipping_fee) as zje1
            ,sum(order_amount) as zje2,sum(pay_fee) as zje3,sum(card_fee) as zje4,sum(goods_amount-zyzk-pay_fee-card_fee) as zje5')->first();
            $this->zje1 = $qiuhe->zje1;
            $this->zje2 = $qiuhe->zje2;
            $this->zje3 = $qiuhe->zje3;
            $this->zje4 = $qiuhe->zje4;
            $this->zje5 = $qiuhe->zje5;
            $order_list = $query->select($this->select_str())
                ->orderBy($sort, $order)
                ->orderBy('add_time', 'desc')
                ->union_paginate($page_num, $qiuhe->num);

        }
        $user_rank = user_rank();
        foreach ($order_list as $v) {
            $v->handle = $this->handle($v->order_id);
            $v->user_rank = isset($v->user) ? $user_rank[$v->user->user_rank] : '';
            if ($v->is_sync == 1) {
                $v->is_sync = sprintf("<span style='color: red;'>%s</span>", '已回读');//红色
            } else {
                $v->is_sync = '未回读';
            }
            if ($v->is_trans == 1) {
                $v->is_trans = sprintf("<span style='color: red;font-weight: bold'>%s</span>", '已传输');//红色
            } else {
                $v->is_trans = '未传输';
            }
        }
        $order_list = $this->add_params($order_list, [
            'ks' => $ks,
            'user_id' => $user_id,
            'group_ywy' => $group_ywy,
            'js' => $js,
            'order_sn' => $order_sn,
            'consignee' => $consignee,
            'order_status' => $order_status,
            'msn' => $msn,
            'gly' => $gly,
            'jqcz' => $jqcz,
            'is_trans' => $is_trans,
            'ddbz' => $ddbz,
            'province' => $province,
            'city' => $city,
            'district' => $district,
            'admin' => $admin,
            'sort' => $sort,
            'order' => $order,
            'page_num' => $page_num,
            'bm_id' => $bm_id,
        ]);
        $sort_arr = [
            'add_time',
            'consignee',
            'goods_amount',
            'order_amount',
            'surplus',
            'user_id',
        ];
        $order_list->sort = $this->sort_arr($sort, $order, $order_list->url($order_list->currentPage()), $sort_arr);
        return $order_list;
    }


    private function ywy_order_list($request, $where = [])
    {
        $this->search_table = '';
        $ks = $request->input('ks', '2017-10-01');//时间查询 开始
        $js = $request->input('js', date('Y-m-d', strtotime('+1 day')));//时间查询 结束
        $order_sn = qckg($request->input('order_sn', ''));
        $user_id = intval($request->input('user_id'));
        $consignee = qckg($request->input('consignee', ''));
        $order_status = qckg($request->input('order_status', ''));
        $msn = qckg($request->input('msn', ''));
        $gly = qckg($request->input('gly', ''));
        $card_name = qckg($request->input('card_name', ''));
        $jqcz = qckg($request->input('jqcz', ''));
        $is_trans = intval($request->input('is_trans'));
        $ddbz = intval($request->input('ddbz'));
        $province = intval($request->input('province'));
        $city = intval($request->input('city'));
        $district = intval($request->input('district'));
        $admin = intval($request->input('admin'));
        $group_ywy = intval($request->input('group_ywy'));
        $union = strtotime(union_tb());//查询时间小于这个 连表查询
        $sort = qckg($request->input('sort', 'add_time'));
        $order = qckg($request->input('order', 'desc'));
        $page_num = intval($request->input('page_num', 15));
        $query = $this->order->with([
            'user' => function ($query) {
                $query->select('user_id', 'msn', 'user_name', 'user_rank');
            }
        ]);
        if ($where instanceof \Closure) {
            $query->where($where);
        }
        if (!empty($ks)) {
            $query->where('add_time', '>=', strtotime($ks));
        }
        if (!empty($js)) {
            $query->where('add_time', '<', strtotime($js));
        }
        if (!empty($order_sn)) {
            $query->where('order_sn', 'like', '%' . $order_sn . '%');
        }
        if (!empty($msn)) {
            $query->where('msn', 'like', '%' . $msn . '%');
        }
        if (!empty($gly)) {
            $query->where(function ($where) use ($gly) {
                $where->where('ls_zpgly', 'like', '%' . $gly . '%')
                    ->orwhere('inv_content', 'like', '%' . $gly . '%')
                    ->orwhere('card_message', 'like', '%' . $gly . '%');
            });
        }
        if (!empty($card_name)) {
            $query->where('card_name', 'like', '%' . $card_name . '%');
        }
        if ($is_trans > 0) {
            $query->where('is_trans', $is_trans - 1);
        }
        if ($group_ywy > 0) {
            $query->where('bonus_id', $group_ywy);
        } elseif ($group_ywy == -1) {
            $query->whereIn('mobile_pay', [2, 6]);
        }
        if (!empty($consignee)) {
            $query->where(function ($where) use ($consignee) {
                $where->where('consignee', 'like', '%' . $consignee . '%')
                    ->orwhere('tel', 'like', '%' . $consignee . '%')
                    ->orwhere('shipping_name', 'like', '%' . $consignee . '%');
            });
        }
        if ($order_status > 0) {
            switch ($order_status) {
                case 1:
                    $query->where('pay_status', '!=', 2);
                    break;
                case 2:
                    $query->where('pay_status', 2);
                    break;
                case 3:
                    $query->where('shipping_status', 0);
                    break;
                case 4:
                    $query->where('shipping_status', 1);
                    break;
                case 5:
                    $query->where('shipping_status', 2);
                    break;
                case 6:
                    $query->where('shipping_status', 3);
                    break;
                case 7:
                    $query->where('shipping_status', 4);
                    break;
                case 8:
                    $query->where('shipping_status', 5);
                    break;
                case 9:
                    $query->where('order_status', 2);
                    break;
            }
        }
        if ($order_status != 9) {
            $query->where('order_status', '!=', 2);
        }
        if ($jqcz > 0) {
            switch ($jqcz) {
                case 1:
                    $query->where('ls_zpgly', '!=', '')
                        ->where('inv_content', '')->where('card_message', '')
                        ->where('inv_payee', '');
                    break;
                case 3:
                    $query->where('inv_content', '');
                    break;
                case 2:
                    $query->where('card_message', '')->where('inv_content', '!=', '');
                    break;
                case 4:
                    $query->where('card_message', '')->where('inv_content', '')->where('inv_payee', '!=', '');
                    break;
                case 5:
                    $query->where(function ($where) {
                        $where->where('card_message', '!=', '')
                            ->orwhere('inv_content', '!=', '')
                            ->orwhere('inv_payee', '');
                    });
                    break;

            }
        }
        if ($ddbz > 0) {
            switch ($ddbz) {
                case 1:
                    $query->where('is_xkh', 1);
                    break;
                case 2:
                    $query->where('is_separate', 1);
                    break;
                case 3:
                    $query->where('jnmj', '>', 0);
                    break;
                case 4:
                    $query->where('is_zq', '>', 0);
                    break;
                case 5:
                    $query->where('dzfp', 2);
                    break;
                case 6:
                    $query->where('pay_id', 6)->where('qid', '!=', '');
                    break;
                case 7:
                    $query->where('pay_id', 4)->where('qid', '!=', '');
                    break;
                case 10:
                    $query->where('pay_id', 7)->where('qid', '!=', '');
                    break;
                case 8:
                    $query->whereIn('mobile_pay', [2, 3, 4, 5, 9, 10, 11, 15, 16, 19, 21, 23, 25, 27, 29, 31, 33, 35, 37, 41, 43, 45, 47]);
                    break;
                case 9:
                    $query->where('mobile_pay', 1);
                    break;
                case 11:
                    $query->where('is_zq', 2);
                    break;
                case 12:
                    $query->where('pack_id', 3);
                    break;
                case 13:
                    $query->where('is_separate', 1)->where('mobile_pay', 2);
                    break;
                case 14:
                    $query->where('pack_fee', '>', 0);
                    break;
                case 15:
                    $query->where('is_mhj', 2);
                    break;
                case 16:
                    $query->where('is_gtkf', 1);
                    break;
                case 17:
                    $query->where('mobile_pay', 3);
                    break;

            }
        }
        if ($user_id > 0) {
            $query->where('user_id', $user_id);
        }
        if ($province > 0) {
            $query->where('province', $province);
        }
        if ($city > 0) {
            $query->where('city', $city);
        }
        if ($district > 0) {
            $query->where('district', $district);
        }
        switch ($admin) {
            case 1://下属管理员
                $this->user->load([
                    'child' => function ($child) {
                        $child->select('user_id', 'name', 'pid')->with([
                            'child' => function ($child) {
                                $child->select('user_id', 'name', 'pid')->with([
                                    'child' => function ($child) {
                                        $child->select('user_id', 'name', 'pid');
                                    }
                                ]);
                            }
                        ]);
                    }
                ]);
                if (count($this->user->child) > 0) {
                    $query->where(function ($where) {
                        foreach ($this->user->child as $child) {
                            $where->orwhere(function ($where) use ($child) {
                                $where->where('ls_zpgly', 'like', '%' . $child->name . '%')
                                    ->orwhere('inv_content', 'like', '%' . $child->name . '%')
                                    ->orwhere('card_message', 'like', '%' . $child->name . '%');
                                foreach ($child->child as $v) {
                                    $where->orwhere(function ($where) use ($v) {
                                        $where->where('ls_zpgly', 'like', '%' . $v->name . '%')
                                            ->orwhere('inv_content', 'like', '%' . $v->name . '%')
                                            ->orwhere('card_message', 'like', '%' . $v->name . '%');
                                        foreach ($v->child as $val) {
                                            $where->orwhere(function ($where) use ($val) {
                                                $where->where('ls_zpgly', 'like', '%' . $val->name . '%')
                                                    ->orwhere('inv_content', 'like', '%' . $val->name . '%')
                                                    ->orwhere('card_message', 'like', '%' . $val->name . '%');
                                            });
                                        }
                                    });
                                }
                            });
                        }
                    });
                } else {
                    $query->whereRaw('1=0');
                }
                break;
            case 2://只查admin
                $query->where(function ($where) {
                    $where->where('ls_zpgly', 'like', '%admin%')
                        ->orwhere('inv_content', 'like', '%admin%')
                        ->orwhere('card_message', 'like', '%admin%');
                });
                break;
            case 3:
                $query->where(function ($where) {
                    $where->where('ls_zpgly', '')
                        ->orwhereNull('ls_zpgly');
                });
                break;
        }
        $this->zje1 = $query->sum(DB::raw('goods_amount+shipping_fee'));
        $this->zje2 = $query->sum('order_amount');
        $order_list = $query->select($this->select_str())
            ->orderBy($sort, $order)
            ->orderBy('order_id', 'desc')
            ->Paginate($page_num);
        $user_rank = user_rank();
        foreach ($order_list as $v) {
            $v->handle = $this->handle($v->order_id);
            $v->user_rank = isset($v->user) ? $user_rank[$v->user->user_rank] : '';
            if ($v->is_sync == 1) {
                $v->is_sync = sprintf("<span style='color: red;'>%s</span>", '已回读');//红色
            } else {
                $v->is_sync = '未回读';
            }
            if ($v->is_trans == 1) {
                $v->is_trans = sprintf("<span style='color: red;font-weight: bold'>%s</span>", '已传输');//红色
            } else {
                $v->is_trans = '未传输';
            }
        }
        $order_list = $this->add_params($order_list, [
            'ks' => $ks,
            'group_ywy' => $group_ywy,
            'js' => $js,
            'order_sn' => $order_sn,
            'consignee' => $consignee,
            'order_status' => $order_status,
            'msn' => $msn,
            'gly' => $gly,
            'jqcz' => $jqcz,
            'is_trans' => $is_trans,
            'ddbz' => $ddbz,
            'province' => $province,
            'city' => $city,
            'district' => $district,
            'admin' => $admin,
            'sort' => $sort,
            'order' => $order,
            'page_num' => $page_num,
        ]);
        $sort_arr = [
            'add_time',
            'consignee',
            'goods_amount',
            'order_amount',
            'surplus',
            'user_id',
        ];
        $order_list->sort = $this->sort_arr($sort, $order, $order_list->url($order_list->currentPage()), $sort_arr);
        return $order_list;
    }

    public function daochu_hdfk()
    {
        $where = function ($where) {
            $where->where('mobile_pay', '!=', 2)->orwhere(function ($where) {
                $where->where('mobile_pay', 2)->where('order_id', '<=', 367858)
                    ->whereNotIn('order_id', [367153, 367774, 367662, 367692, 367493, 367664, 367768, 366777, 367595, 367678, 367836, 367090]);;
            });
        };
        $result = OrderInfo::where('is_separate', 1)->where('order_status', 1)->where('pay_status', 0)->where('order_type', 0)
            ->where($where)
            ->select('order_id', 'order_sn', 'msn', 'mobile_pay', 'goods_amount', 'order_amount',
                'money_paid', 'surplus', 'ls_zpgly', 'add_time')
            ->orderBy('add_time', 'desc')
            ->get();
        foreach ($result as $v) {
            if ($v->mobile_pay == 2) {
                $v->mobile_pay = '是';
            } else {
                $v->mobile_pay = '否';
            }
            $v->add_time = date('Y-m-d H:i:s', $v->add_time);
            $v->order_sn .= ' ';
        }
        $key_value = [
            'order_sn' => '订单编号',
            'msn' => '企业名称',
            'mobile_pay' => '是否业务员订单',
            'goods_amount' => '商品总金额',
            'order_amount' => '应付金额',
            'money_paid' => '付款金额',
            'surplus' => '使用余额',
            'ls_zpgly' => '管理员',
            'add_time' => '下单时间',
        ];
        $this->to_excel($key_value, $result, '未付款货到付款订单');
    }

    private function merge_error($msg)
    {
        error_msg($msg, [route('order.index') => '返回订单列表'], 'msg_simple');
    }

    private function check_diff($goods, $order_goods)
    {
        if ($goods->tsbz != $order_goods->tsbz) {
            $this->merge_error('商品(' . $goods->goods_name . ')特殊标识不一致');
        }
        if ($goods->goods_price != $order_goods->goods_price) {
            $this->merge_error('商品(' . $goods->goods_name . ')价格不一致');
        }
        if ($goods->is_cur_p != $order_goods->is_cur_p) {
            $this->merge_error('商品(' . $goods->goods_name . ')特价状态不一致');
        }
        if ($goods->zyzk != $order_goods->zyzk) {
            $this->merge_error('商品(' . $goods->goods_name . ')优惠金额不一致');
        }
        if ($goods->is_jp != $order_goods->is_jp) {
            $this->merge_error('商品(' . $goods->goods_name . ')精品状态不一致');
        }
        if ($goods->xq != $order_goods->xq) {
            $this->merge_error('商品(' . $goods->goods_name . ')效期不一致');
        }

    }

    private function ddbz_arr()
    {
        $arr = [
            1 => '新客户订单',
            20 => '查询麻黄碱订单',
        ];
        return $arr;
    }

    public function check_refund($id)
    {
        $info = $this->order->find($id);
        $can_refund = 0;
        if ($info->order_status == 1 && $info->order_amount < 0 && has_permission('order.edit.refund')) {
            if ($info->is_trans == 1) {
                if (has_permission('edit_ycs_order')) {
                    $can_refund = 1;
                }
            } else {
                $can_refund = 1;
            }
        }
        if ($can_refund == 1) {
            ajax_return(route('order_edit.index', ['id' => $info->order_id, 'action' => 'refund']));
        } else {
            ajax_return('', 1);
        }
    }

    public function yjtk()
    {
        check_permission('order.yjtk');
        $order_list = $this->order->where('order_amount', '<', 0)->where('pay_status', 2)->where('shipping_status', '>=', 3)
            ->select('order_id', 'order_sn', 'user_id', 'money_paid', 'goods_amount', 'order_status', 'pay_status', 'shipping_status',
                'is_trans', 'jnmj', 'surplus', 'order_amount', 'cz_money', 'jf_money', 'hongbao_money')
            ->take(30)->get();
        if (count($order_list) == 0) {
            ajax_return('暂时没有需要一键退款的订单！', 1);
        }
        DB::transaction(function () use ($order_list) {
            foreach ($order_list as $v) {
                $inputs = [];
                $note = "订单系统退款：" . $v->order_sn;
                $refund = abs($v->order_amount);
                $inputs['order_amount'] = 0;
                $user = get_user_info($v->user_id);
                $change_surplus = 0;
                $change_cz_money = 0;
                $change_money_paid = 0;
                $change_jf_money = 0;
                if ($v->jnmj > 0) {
                    $user->load('jnmj');
                    log_jnmj_change($user->jnmj, $refund, $note . $v->order_sn);
                    $inputs['jnmj'] = $v->jnmj - $refund;
                    $note .= "(退往充值余额)";
                } else {
                    if ($v->surplus > 0) {//订单有使用余额,优先退余额
                        if ($v->surplus >= $refund) {//使用的余额金额大于等于退款金额
                            $inputs['surplus'] = $v->surplus - $refund;
                            $change_surplus = $refund;
                            $refund = 0;
                        } else {
                            $inputs['surplus'] = 0;
                            $refund -= $v->surplus;
                            $change_surplus = $v->surplus;
                        }
                    }
                    if ($v->cz_money > 0) {//订单有使用余额,优先退余额
                        if ($v->cz_money >= $refund) {//使用的余额金额大于等于退款金额
                            $inputs['cz_money'] = $v->cz_money - $refund;
                            $change_cz_money = $refund;
                            $refund = 0;
                        } else {
                            $inputs['cz_money'] = 0;
                            $refund -= $v->cz_money;
                            $change_cz_money = $v->cz_money;
                        }
                    }
                    if ($v->money_paid > 0) {//订单有使用余额,优先退余额
                        if ($v->money_paid >= $refund) {//使用的余额金额大于等于退款金额
                            $inputs['money_paid'] = $v->money_paid - $refund;
                            $change_money_paid = $refund;
                            $refund = 0;
                        } else {
                            $inputs['money_paid'] = 0;
                            $refund -= $v->money_paid;
                            $change_money_paid = $v->money_paid;
                        }
                    }
                    if ($v->jf_money > 0) {//订单有积分金币,优先退积分金币
                        if ($v->jf_money >= $refund) {//使用的积分金币大于等于退款金额
                            $inputs['jf_money'] = $v->jf_money - $refund;
                            $change_jf_money = $refund;
                            $refund = 0;
                        } else {
                            $inputs['jf_money'] = 0;
                            $refund -= $v->jf_money;
                            $change_jf_money = $v->jf_money;
                        }
                    }
                    if ($refund > 0) {
                        $inputs['hongbao_money'] = $v->hongbao_money - $refund;
                    }
                }
                $change_desc = [];
                $change_count = 0;
                $result = union_log($inputs, $v, $change_desc, $change_count, 'order');
                DB::transaction(function () use ($result, $user, $refund, $note, $change_surplus, $change_cz_money, $change_money_paid, $change_jf_money, $v) {
                    $info = $result['info'];
                    $change_desc = $result['change_desc'];
                    $change_count = $result['change_count'];
                    if ($change_count > 0) {
                        if ($change_surplus + $change_money_paid > 0 && $info->jnmj == 0 && $v->jnmj == 0) {
                            $change_desc[] = '余额由<span style="color: red;">' . $user->user_money . '</span>变成<span style="color: red">' . ($user->user_money + $change_surplus + $change_money_paid) . '</span>';
                            log_account_change($user, $change_surplus + $change_money_paid, 0, 0, 0, $note, 0, 0, $info->order_id);
                        }
                        if ($change_cz_money > 0) {
                            $cz_money = CzMoney::where('user_id', $info->user_id)->first();
                            $change_desc[] = trans('common.cz_money') . '由<span style="color: red;">' . $cz_money->money . '</span>变成<span style="color: red">' . ($cz_money->money + $change_cz_money) . '</span>';
                        }
                        if ($change_jf_money > 0) {
                            $jf_money = JfMoney::where('user_id', $info->user_id)->first();
                            $change_desc[] = trans('models/jf_money.money.info') . '由<span style="color: red;">' . $jf_money->money . '</span>变成<span style="color: red">' . ($jf_money->money + $change_jf_money) . '</span>';
                        }
                        if ($refund > 0) {
                            $hongbao_money = HongbaoMoney::where('user_id', $info->user_id)->first();
                            $change_desc[] = trans('models/hongbao_money.money.info') . '由<span style="color: red;">' . $hongbao_money->money . '</span>变成<span style="color: red">' . ($hongbao_money->money + $refund) . '</span>';
                        }
                        if (count($change_desc) > 0) {
                            $change_desc = implode(';', $change_desc);
                            $change_desc = "订单一键退款:" . $info->order_sn . "(OrderId:" . $info->order_id . ") " . $change_desc;
                            admin_log($change_desc);
                        }
                        unset($info->pay_time);
                        $info->save();
                    }
                });
            }
        });
        ajax_return('一键退款成功');
    }

    public function ljjp()
    {
        $start = strtotime(20170701);
        $end = strtotime(20171001);
        $order_list = $this->order->with([
            'order_goods' => function ($query) {
                $query->where('is_jp', 1)->where('is_gsync', 1)
                    ->select('order_id', 'goods_price', 'goods_number', 'is_jp', 'is_gsync');
            }
        ])->where('is_sync', '>', 0)->where('is_jp_points', 0)
            ->where('add_time', '>=', $start)->where('add_time', '<', $end)
            ->where('sign_building', 'not like', '%获得礼品%')->where('jp_points', '>', 0)
            ->where('order_status', 1)->where('pay_status', 2)->where('mobile_pay', '<', 2)
            ->where('shipping_status', '>', 2)
            ->select('order_id', 'order_sn', 'user_id', 'jp_points', 'sign_building')
            ->take(1)->get();
        if (count($order_list) == 0) {
            ajax_return('暂时没有需要检索累计精品积分的订单！', 1);
        }
        DB::transaction(function () use ($order_list) {
            foreach ($order_list as $v) {
                $jp_points = $v->order_goods->sum(function ($item) {
                    $total = 0;
                    if ($item->is_jp == 1 && $item->is_gsync == 1) {
                        $total = $item->goods_price * $item->goods_number;
                    }
                    return intval($total);
                });
                $inputs = [
                    'is_jp_points' => 1,
                    'jp_points' => $jp_points,
                ];
                OrderInfo::where('order_id', $v->order_id)->update($inputs);
                $log_info = $v->order_sn . "累计精品积分<span style='color:red'>" . $jp_points . "</span>。";
                admin_log($log_info);
                DB::update('update ecs_users set jp_points=jp_points+' . $jp_points . ' where user_id = ?', [$v->user_id]);
            }
        });
        ajax_return('检索累计精品积分成功！');
    }

    public function set_admin(Request $request)
    {
        check_role('administrator');
        $id = intval($request->input('id'));
        OrderInfo::where('order_id', $id)->update([
            'is_admin' => 1
        ]);
    }

    public function sync_address(Request $request)
    {
        $info = OrderInfo::where('order_id', intval($request->input('order_id')))
            ->select('order_id', 'address', 'user_id', 'order_sn', 'change_status')->lockForUpdate()->first();
        $user = get_user_info($info->user_id);
        if (!$info) {
            ajax_return('订单不存在', 1);
        }
        try {
            $str = "<DATA><WLDWID>" . $user->wldwid1 . "</WLDWID></DATA>";
            $client = new SoapClient('http://171.221.207.113:3396/cszjc/webservice/cxfService?wsdl');
            $response = $client->getWldwAddress(array('param' => $str));
            $xml = simplexml_load_string($response->return);
            $erp_address = $xml->ADDRESS;
            if (empty($erp_address[0])) {
                ajax_return('erp地址为空', 1);
            }
            DB::transaction(function () use ($erp_address, $info) {
                admin_log('同步订单 ' . $info->order_sn . ' 收货地址(Id:' . $info->order_id . '):由 ' . $info->address . ' 改为 ' . $erp_address);
                $info->address = $erp_address;
                $info->change_status = 1;
                $info->save();
            });
            ajax_return('同步收货地址完成', 0, ['address' => $erp_address]);
        } catch (\Exception $e) {
            ajax_return('获取收货地址失败', 1);
        }
    }
}
