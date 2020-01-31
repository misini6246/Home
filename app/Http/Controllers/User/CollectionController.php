<?php

namespace App\Http\Controllers\User;

use App\CollectGoods;
use App\Http\Controllers\Controller;
use App\Models\Goods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CollectionController extends Controller
{
    use UserTrait;

    public function __construct()
    {
        $this->action = 'collection';
        $this->user   = auth()->user()->is_zhongduan();
        $this->now    = time();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $show_area = trim($request->input('show_area'));
        $query     = DB::table('collect_goods as c')->leftJoin('goods as g', 'c.goods_id', '=', 'g.goods_id')
            ->whereNotNull('g.goods_id')->where('user_id', $this->user->user_id);
        if (!empty($show_area)) {
            if ($show_area == 11) {
                $query->where('g.show_area', 'not like', '%4%');
            } else {
                $query->where('g.show_area', 'like', '%' . $show_area . '%');
            }
        }
        $query->select('g.goods_name', 'g.goods_id', 'c.rec_id');
        $result     = $query->orderBy('rec_id', 'desc')->Paginate(20);
        $ids        = $result->lists('goods_id')->toArray();
        $gmcs       = $this->gmcs($ids);
        $real_price = $this->real_price($ids);
        foreach ($result as $k => $v) {
            $v->num = isset($gmcs[$v->goods_id]) ? $gmcs[$v->goods_id] : 0;
            $jh     = new Goods();
            $arr    = isset($real_price[$v->goods_id]) ? $real_price[$v->goods_id] : [];
            foreach ($arr as $key => $val) {
                $v->$key = $val;
            }
            $jh->forceFill(collect($v)->toArray());
            $result[$k] = $jh;
        }
        $result->addQuery('show_area', $show_area);
        $this->set_assign('result', $result);
        $this->set_assign('show_area', $show_area);
        $this->common_value();
        $box = trim($request->input('box'));
        if ($box == 'sc1') {
            return response()->view('user.' . $box, $this->assign)->getContent();
        }
        return view($this->view . 'user.collection', $this->assign);
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
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $id = trim($id, ',');
        $id = explode(',', $id);
        CollectGoods::where('user_id', $this->user->user_id)->whereIn('goods_id', $id)->delete();
        $box = trim($request->input('box'));
        if ($box == 'sc1') {
            $html = $this->index($request);
        } else {
            $result = $this->near_collection();
            $html   = response()->view('user.' . $box, ['result' => $result])->getContent();
        }
        ajax_return('删除成功', 0, ['html' => $html]);
    }

    protected function gmcs($ids)
    {
        $select = ['og.goods_id', DB::raw('count(ecs_og.goods_id) as num')];
        $query  = DB::table('order_goods as og')->leftJoin('order_info as oi', 'og.order_id', '=', 'oi.order_id')
            ->where('oi.order_status', 1)->where('oi.user_id', $this->user->user_id)->whereIn('goods_id', $ids)
            ->select($select)->groupBy('goods_id');
        $query1 = DB::table('old_order_goods as og')->leftJoin('old_order_info as oi', 'og.order_id', '=', 'oi.order_id')
            ->where('oi.order_status', 1)->where('oi.user_id', $this->user->user_id)->whereIn('goods_id', $ids)
            ->select($select)->groupBy('goods_id');
        $union  = $query->unionAll($query1);
        $sql    = DB::table(DB::raw("({$union->toSql()}) as ecs_g"))
            ->mergeBindings($union);
        $result = $sql->whereNotNull('goods_id')->groupBy('goods_id')->get();
        $arr    = [];
        foreach ($result as $v) {
            $arr[$v->goods_id] = $v->num;
        }
        return $arr;
    }

    public function near_collection($num = 4)
    {
        $query = DB::table('collect_goods as c')->leftJoin('goods as g', 'c.goods_id', '=', 'g.goods_id')
            ->whereNotNull('g.goods_id')->where('user_id', $this->user->user_id);
        $query->select('g.goods_name', 'g.goods_id', 'g.goods_number', 'c.rec_id');
        $result     = $query->orderBy('rec_id', 'desc')->take($num)->get();
        $result     = collect($result);
        $ids        = $result->lists('goods_id')->toArray();
        $real_price = $this->real_price($ids);
        $collect    = collect();
        foreach ($result as $v) {
            $jh  = new Goods();
            $arr = isset($real_price[$v->goods_id]) ? $real_price[$v->goods_id] : [];
            foreach ($arr as $key => $val) {
                $v->$key = $val;
            }
            $jh->forceFill(collect($v)->toArray());
            $collect->push($jh);
        }
        return $collect;
    }
}
