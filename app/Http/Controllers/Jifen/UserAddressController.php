<?php

namespace App\Http\Controllers\Jifen;

use App\Http\Controllers\Controller;
use App\Region;
use App\UserAddress;
use Illuminate\Http\Request;

class UserAddressController extends Controller
{
    use JfTrait;

    public function __construct()
    {
        $this->user = auth()->user();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->action = 'user';
        $result       = UserAddress::where('user_id', $this->user->user_id)->where('address_id', $this->user->address_id)->get();
        $this->set_assign('result', $result);
        $this->set_assign('user_menu', 'address');
        $this->set_assign('wntj', $this->getTj8());
        $this->common_value();
        return view('jifen.address.index', $this->assign);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return;
        $province = Region::where('parent_id', 1)->orderBy('agency_id', 'desc')->get();
        $this->set_assign('province', $province);
        return view('jifen.address.create', $this->assign);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return;
        $user_address       = UserAddress::where('user_id', $this->user->user_id)->orderBy('is_default', 'desc')->get();
        $address            = new UserAddress();
        $address->true_name = trim($request->input('consignee'));
        $address->user_id   = $this->user->user_id;
        if (count($user_address) == 0) {
            $address->is_default = 1;
        }
        if (count($user_address) >= 5) {
            return $this->content('最多只能保存5个收货地址', 2);
            $content  = response()->view('jifen.layouts.address', ['address' => $user_address])->getContent();
            $qian     = array("\t", "\n", "\r");
            $content  = str_replace($qian, '', $content);
            $default  = $user_address->whereLoose('is_default', 1)->first();
            $province = Region::where('parent_id', 1)->orderBy('agency_id', 'desc')->get();
            $this->set_assign('province', $province);
            $this->set_assign('success', 1);
            $this->set_assign('default_address', '<img src="' . get_img_path('images/jf/add_icon.png') . '"/><span>' . $default->location . $default->address . '</span>');
            $this->set_assign('content', $content);
            return view('jifen.address.create', $this->assign);
        }
        $address->province  = intval($request->input('province'));
        $address->city      = intval($request->input('city'));
        $address->area      = intval($request->input('district'));
        $address->address   = trim($request->input('address'));
        $address->mob_phone = $request->input('tel');
        $address->zip_code  = $request->input('zipcode');
        $address->location  = get_region_name([$address->province, $address->city, $address->area], ' ');
        if ($address->save()) {
            $content = '<script>var p = parent;p.layer.closeAll();p.location.reload();</script>';
            return $content;
            $user_address->push($address);
            $content  = response()->view('jifen.layouts.address', ['address' => $user_address])->getContent();
            $qian     = array("\t", "\n", "\r");
            $content  = str_replace($qian, '', $content);
            $default  = $user_address->whereLoose('is_default', 1)->first();
            $province = Region::where('parent_id', 1)->orderBy('agency_id', 'desc')->get();
            $this->set_assign('province', $province);
            $this->set_assign('success', 1);
            $this->set_assign('default_address', '<img src="' . get_img_path('images/jf/add_icon.png') . '"/><span>' . $default->location . $default->address . '</span>');
            $this->set_assign('content', $content);
            return view('jifen.address.create', $this->assign);
        }
        return redirect()->back();
    }

    public function set_default(Request $request)
    {
        return;
        $id   = intval($request->input('id'));
        $info = UserAddress::where('user_id', $this->user->user_id)->find($id);
        if (!$info) {
            return [
                'error' => 1,
                'msg'   => '地址不存在',
            ];
        }
        $info->is_default = 1;
        if ($info->save()) {
            UserAddress::where('user_id', $this->user->user_id)->where('id', '!=', $id)->update([
                'is_default' => 0
            ]);
            return [
                'error'           => 0,
                'id'              => $id,
                'default_address' => '<img src="' . get_img_path('images/jf/add_icon.png') . '"/><span>' . $info->location . $info->address . '</span>'
            ];
        }
        return [
            'error' => 1,
            'msg'   => '操作失败'
        ];
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
        return;
        $province = Region::where('parent_id', 1)->orderBy('agency_id', 'desc')->get();
        $info     = UserAddress::where('user_id', $this->user->user_id)->find($id);
        if (!$info) {
            return $this->content('收货地址不存在', 2);
        }
        $city = Region::where('parent_id', $info->province)->get();
        $area = Region::where('parent_id', $info->city)->get();
        $this->set_assign('info', $info);
        $this->set_assign('province', $province);
        $this->set_assign('city', $city);
        $this->set_assign('area', $area);
        return view('jifen.address.edit', $this->assign);
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
        return;
        $info = UserAddress::where('user_id', $this->user->user_id)->find($id);
        if (!$info) {
            return $this->content('收货地址不存在', 2);
        }
        $info->province  = intval($request->input('province'));
        $info->city      = intval($request->input('city'));
        $info->area      = intval($request->input('district'));
        $info->address   = trim($request->input('address'));
        $info->mob_phone = $request->input('tel');
        $info->zip_code  = $request->input('zipcode');
        $info->location  = get_region_name([$info->province, $info->city, $info->area], ' ');
        if ($info->save()) {
            return $this->content('修改成功');
        }
        return $this->content('修改失败', 2);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return;
        $id = intval($id);
        if (UserAddress::where('id', $id)->where('user_id', $this->user->user_id)->delete()) {
            return [
                'error' => 0,
                'msg'   => '删除成功'
            ];
        }
        return [
            'error' => 1,
            'msg'   => '删除失败'
        ];
    }

    protected function content($msg, $error = 1)
    {
        $content = '<script>var p = parent;p.layer.closeAll();p.layer.msg(\'' . $msg . '\',{icon:' . $error . '}, function(){p.location.reload()});</script>';
        return $content;
    }
}
