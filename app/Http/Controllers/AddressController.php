<?php

namespace App\Http\Controllers;

use App\Region;
use App\UserAddress;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $orderstr = $request->input('orderstr');
        $user = Auth::user();
        $address = UserAddress::where('user_id', $user->user_id)->get();
        $arr = array();
        $province = Region::where('parent_id', 1)->where('region_type', 1)->select('region_id', 'region_name')->get();
        $arr['page_title'] = trans('address.shdzgl');
        $arr['province'] = $province;
        $arr['orderstr'] = $orderstr;
        $arr['nextUrl'] = route('address.store');
        //print_r($province);
        return view('address')->with($arr);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        $user_address = UserAddress::where('user_id', $user->user_id)->where('address_id', $user->address_id)->first();
        if ($user_address) {
            tips1('改变收货地址请联系客服人员');
        }
        $arr = $request->all();
        $arr['user_id'] = Auth::user()->user_id;
        $nextUrl = $request->input('nextUrl');
        //print_r($nextUrl);die;
        if (UserAddress::create($arr)) {
            return redirect($nextUrl);
        }
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
     * 地址修改
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $user = Auth::user();
        $addressList = UserAddress::where('user_id', $user->user_id)->get();
        $province = Cache::tags(['shop', 'region'])->remember(1, 8 * 60, function () {
            return Region::where('parent_id', 1)->get();
        });
        foreach ($addressList as $v) {
            $v->cityList = Cache::tags(['shop', 'region'])->remember($v->province, 8 * 60, function () use ($v) {
                return Region::where('parent_id', $v->province)->get();
            });
            $v->districtList = Cache::tags(['shop', 'region'])->remember($v->city, 8 * 60, function () use ($v) {
                return Region::where('parent_id', $v->city)->get();
            });
            //print_r($v->cityList->toArray());
        }
        //print_r($addressList->toArray());
        $assign = [
            'page_title' => trans('common.userCenter'),
            'user' => $user,
            'action' => 'addressList',
            'addressList' => $addressList,
            'province' => $province,
        ];
        return view('address')->with($assign);
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
    public function destroy($id)
    {
        //
    }

    /*
     * 地址级联查询
     */
    public function region(Request $request)
    {
        $parent_id = $request->input('parent');
        $type = $request->input('type');
        $target = $request->input('target');
        if ($parent_id == 0) {
            $result = array();
            $result['regions'] = [];
            $result['target'] = $target;
            $result['type'] = $type;
            return $result;
        }
        //$region = Region::where('parent_id',$parent_id)->where('region_type',$type)->select('region_id','region_name')->get();
        $region = Cache::tags(['shop', 'region'])->remember($parent_id, 8 * 60, function () use ($parent_id) {
            return Region::where('parent_id', $parent_id)->get();
        });
        $result = array();
        $result['regions'] = $region;
        $result['target'] = $target;
        $result['type'] = $type;
        return $result;
    }
}
