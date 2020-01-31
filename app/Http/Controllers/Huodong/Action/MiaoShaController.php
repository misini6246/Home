<?php

namespace App\Http\Controllers\Huodong\Action;

use App\Http\Controllers\Huodong\MsGoods;
use App\Http\Controllers\Huodong\MsTeam;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MiaoShaController extends Controller
{

    protected $msTeam;

    public function __construct(MsTeam $msTeam){
        $this->msTeam = $msTeam;
    }

    public function ms_team(){
        return $this->msTeam;
    }
}
