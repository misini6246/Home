<?php
/**
 * Created by PhpStorm.
 * User: chunyang
 * Date: 2018-01-12
 * Time: 10:40
 */

namespace App\Http\Controllers\Hdzx;


use App\JpLog;
use Illuminate\Support\Facades\DB;

trait HdzxTrait
{

    protected $user;

    protected $now;

    protected $assign;

    protected $action;

    protected function set_assign($key, $value)
    {
        $this->assign[$key] = $value;
    }

    protected function common_value()
    {
        $this->set_assign('user', $this->user);
        $this->set_assign('now', $this->now);
        $this->set_assign('page_title', '活动中心-');
        $this->set_assign('action', $this->action);
    }

    protected function cj_rules($jp_goods)
    {
        $jishu = 0;
        $res   = -1;
        if (count($jp_goods) > 0) {
            foreach ($jp_goods as $v) {
                if (($v->number - $v->ls_num) > 0) {//还有剩余数量
                    $jishu += $v->zjgl;
                }
            }
            foreach ($jp_goods as $k => $v) {
                if (($v->number - $v->ls_num) > 0) {
                    $rand = mt_rand(1, $jishu);
                    if ($rand <= $v->zjgl) {
                        $res      = $k;
                        $this->jp = $v;
                        $status   = $this->log_jp_goods();
                        if ($status == 1) {
                            $this->jp = $jp_goods->whereLoose('jp_id', $this->default)->first();
                            $this->log_jp_goods();
                        }
                        break;
                    } else {
                        $jishu -= $v->zjgl;
                    }
                }
            }
        }
        return $res;
    }

    protected function log_jp_goods()
    {
        $flag = DB::transaction(function () {
            $status = 0;
            if ($this->jp->cat_id > 0) {
                $status = $this->create_yhq_cj();
                if ($status == 1) {
                    return 1;
                }
            }
            if ($status == 0 || $this->jp->cat_id == 0) {
                $jp_log           = new JpLog();
                $jp_log->user_id  = $this->user->user_id;
                $jp_log->add_time = time();
                $jp_log->log      = $this->jp->jp_name;
                $jp_log->jp_id    = $this->jp->jp_id;
                $jp_log->bm       = $this->bm;
                if (strpos($this->jp->jp_name, '未中奖') !== false) {
                    $jp_log->is_zj = 1;
                } else {
                    $jp_log->is_zj = 0;
                }
                $jp_log->save();
                $this->jp->ls_num = $this->jp->ls_num + 1;
                $this->jp->save();
                $this->jp->setRelation('jp_log_id', $jp_log->log_id);
            }
        });
        return $flag;
    }
}