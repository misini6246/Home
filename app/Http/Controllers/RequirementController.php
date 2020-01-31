<?php

namespace App\Http\Controllers;

use App\Buy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class RequirementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['only' => 'store']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //Cache::tags(['shop','ad'])->flush();
        $user     = Auth::user();
        $imgList  = ads(20);
        $imgOne   = ads(21, true);
        $imgTwo   = ads(22, true);
        $imgThree = ads(23, true);
        $buyList  = Cache::tags(['shop', 'buyList'])->remember($request->input('page', 1), 60, function () {
            return Buy::where('buy_through', 1)->orderBy('buy_addtime', 'desc')->Paginate(10);
        });
        $assign   = [
            'page_title' => '求购专区-',
            'user'       => $user,
            'imgList'    => $imgList,
            'imgOne'     => $imgOne,
            'imgTwo'     => $imgTwo,
            'imgThree'   => $imgThree,
            'pages'      => $buyList,
            'params'     => [
                'url' => 'requirement.index',
            ],
            'middle_nav' => nav_list('middle'),
        ];
        return view('requirement')->with($assign);
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
        $rules = [
            'required'    => '不能为空',
            'digits'      => '无效的号码',
            'integer'     => '数量为整数',
            'date_format' => '2014.01.01格式',
            'numeric'     => '无效的价格',
        ];
        $check = Validator::make($request->all(), [
            'buy_name'     => 'required',
            'buy_tel'      => 'required|digits:11',
            'buy_goods'    => 'required',
            'product_name' => 'required',
            'buy_spec'     => 'required',
            'buy_number'   => 'required|integer',
            'buy_price'    => 'required|numeric',
            'buy_time'     => 'required|date_format:Y.m.d',
        ], $rules);
        if ($check->fails()) {//返回验证错误信息
            return redirect('requirement#contactForm')
                ->withErrors($check)
                ->withInput();
        } else {
            $user              = Auth::user();
            $buy               = new Buy();
            $buy->buy_username = $user->user_name;
            $buy->user_id      = $user->user_id;
            $buy->buy_name     = $request->input('buy_name');
            $buy->buy_tel      = $request->input('buy_tel');
            $buy->buy_goods    = $request->input('buy_goods');
            $buy->product_name = $request->input('product_name');
            $buy->buy_spec     = $request->input('buy_spec');
            $buy->buy_number   = $request->input('buy_number');
            $buy->buy_price    = $request->input('buy_price');
            $buy->buy_time     = $request->input('buy_time');
            $buy->message      = $request->input('message');
            $buy->buy_addtime  = time();
            if ($buy->save()) {
                tips0('求购信息提交成功！', ['返回求购专区' => route('requirement.index')]);
            }
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
