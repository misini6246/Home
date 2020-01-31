<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Region;
use App\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserAddressController extends Controller
{
    use UserTrait;

    public function __construct()
    {
        $this->action = 'address';
        $this->user = auth()->user()->is_zhongduan();
        $this->now = time();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $info = UserAddress::where('user_id', $this->user->user_id)->where('address_id', $this->user->address_id)->first();
        if ($info) {
            $info->region_name = get_region_name([$info->province, $info->city, $info->district], ' ');
        }
        $province = Region::with('child')->where('parent_id', 1)
            ->where('region_type', 1)->orderBy('agency_id', 'desc')->get();
        $this->set_assign('province', $province);

        $this->set_assign('info', $info);
        $this->common_value();
        return view($this->view . 'user.address', $this->assign);
    }

    public function get_region(Request $request)
    {
        $id = intval($request->input('id'));
        $region = Region::where('parent_id', $id)->select('region_id', 'region_name')->get();
        $collect = collect();
        foreach ($region as $v) {
            $collect->push(['id' => $v->region_id, 'name' => $v->region_name]);
        }
        return response()->json($collect)->getContent();
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
        $user_address = UserAddress::where('user_id', $this->user->user_id)->where('address_id', $this->user->address_id)->first();
        if ($user_address) {
            tips1('改变收货地址请联系客服人员');
        }
        $rules = [
            'required' => '不能为空',
        ];
        $validator = Validator::make($request->all(), [
            'consignee' => 'required',
            'province' => 'required',
            'city' => 'required',
            'district' => 'required',
//            'address' => 'required',
            'tel' => 'required',
        ], $rules);
        if ($validator->fails()) {
            return redirect('member/address')
                ->withErrors($validator)
                ->withInput();
        } else {
            $address = new UserAddress();
            $address->consignee = trim($request->input('consignee', ''));
            $address->user_id = $this->user->user_id;
            $address->country = 1;
            $address->province = intval($request->input('province'));
            $address->city = intval($request->input('city'));
            $address->district = intval($request->input('district'));
            $address->address = '';
            $address->tel = trim($request->input('tel', ''));
            $address->mobile = trim($request->input('mobile', ''));
            $address->sign_building = '';
            $address->best_time = '';
            $address->zipcode = trim($request->input('zipcode', ''));
            $act = $request->input('act', 'user');
            $flag = DB::transaction(function () use ($address, $act) {
                $address->save();
                if ($address->address_id == 0) {
                    return 1;
                }
                $this->user->address_id = $address->address_id;
                $this->user->save();
                if ($act != 'user') {
                    return redirect()->route('cart.jiesuan');
                }
            });
            if (!is_null($flag)) {
                return redirect('member/address')
                    ->withErrors($validator)
                    ->withInput();
            }
            tips0('您的收货地址信息添加成功', ['返回查看收货地址' => route('member.address.index')]);
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
    public function destroy($id)
    {
        //
    }
}
