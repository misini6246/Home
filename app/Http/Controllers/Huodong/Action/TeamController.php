<?php

namespace App\Http\Controllers\Huodong\Action;

use App\Http\Controllers\Huodong\MsTeam;
use Illuminate\Http\Request;

use App\Http\Requests;

class TeamController implements MsTeam
{
    public $start;

    public $end;

    public $team;

    public function team(array $team){
        $this->start = $team['0'];
        $this->end = $team['1'];
        $this->team = $team['2'];
        return $this;
    }
}
