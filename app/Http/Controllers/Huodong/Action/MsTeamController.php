<?php

namespace App\Http\Controllers\Huodong\Action;

use App\Http\Controllers\Huodong\MsGoods;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MsTeamController extends Controller
{
    protected $msGoods;

    public function __construct(MsGoods $msGoods){
        $this->msGoods = $msGoods;
    }

    public function ms_goods(){
        return $this->msGoods;
    }
}
