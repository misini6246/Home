<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Region;
use App\User;
use Illuminate\Support\Facades\Cache;

class RegController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

    /*
 * 注册验证
 * @select_area 查询省市
 * @is_name 查询用户名是否存在
 * @is_msn 查询企业名称是否存在
 * @is_qq 查询qq是否存在
 */
    public function reg_check(Request $request)
    {
        $id = $request->input('id');
        $act = $request->input('act');
        if ($act == 'select_area') {
            //$address = Region::where('parent_id', $id)->get();
            $address = Cache::tags(['shop', 'region'])->remember($id, 8 * 60, function () use ($id) {
                return Region::where('parent_id', $id)->orderBy('agency_id', 'desc')->get();
            });
            $regionshtml = "";
            foreach ($address as $v) {
                $regionshtml .= "<li data-id={$v->region_id}>{$v->region_name}</li>";
            }
            return $regionshtml;
        }
        if ($act == 'is_name') {
            $user_id = User::where('user_name', $id)->pluck('user_id');
            $type = 0;
            if (empty($user_id)) {
                $type = 1;
            }
            return $type;
        }
        if ($act == 'is_msn') {
            $user_id = User::where('msn', $id)->pluck('user_id');
            $type = 0;
            if (empty($user_id)) {
                $type = 1;
            }
            return $type;
        }
        if ($act == 'is_qq') {
            return 1;
            $user_id = User::where('qq', $id)->pluck('user_id');
            $type = 0;
            if (empty($user_id)) {
                $type = 1;
            }
            return $type;
        }
        if ($act == 'is_email') {
            return 1;
            $user_id = User::where('email', $id)->pluck('user_id');
            $type = 0;
            if (empty($user_id)) {
                $type = 1;
            }
            return $type;
        }
        if ($act == 'is_tel') {
            return 1;
            $user_id = User::where('mobile_phone', $id)->orwhere('home_phone', $id)->pluck('user_id');
            $type = 0;
            if (empty($user_id)) {
                $type = 1;
            }
            return $type;
        }
        if ($act == 'is_email') {
            $user_id = User::where('email', $id)->pluck('user_id');
            $type = 0;
            if (empty($user_id)) {
                $type = 1;
            }
            return $type;
        }
    }
}
