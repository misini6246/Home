<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class IndexNewController extends Controller
{
    private $nav_list;

    private $arr;

    private $user;

    private $show_area;

    private $is_new_user;

    public function __construct(Request $request){
        $this->nav_list = nav_list('middle',-1);
        $this->user = auth()->user();
        if($this->user){
            $this->user = $this->user->is_new_user();
            $this->is_new_user = $this->user->is_new_user;
            $this->show_area = auth()->user()->province;
        }else{
            $this->show_area = intval($request->input('show_area',26));
        }
        $this->arr = [
            'page_title'=>'',
            'middle_nav'=>$this->nav_list,
            'nav_shijian'=>0,
        ];
        //dd($this->nav_list);
    }
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
