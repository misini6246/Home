<?php

namespace App\Http\Controllers\Jifen;

use App\Http\Controllers\Controller;
use App\jf\QianDao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QianDaoController extends Controller
{
    use JfTrait;

    protected $year;

    protected $month;

    protected $day;

    protected $days;

    protected $start;

    protected $model;

    /**
     * @return mixed
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param mixed $year
     */
    public function setYear($year)
    {
        $this->year = $year;
    }

    /**
     * @return mixed
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * @param mixed $month
     */
    public function setMonth($month)
    {
        $this->month = $month;
    }

    /**
     * @return mixed
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * @param mixed $day
     */
    public function setDay($day)
    {
        $this->day = $day;
    }

    /**
     * @return mixed
     */
    public function getDays()
    {
        return $this->days;
    }

    /**
     * @param mixed $days
     */
    public function setDays($days)
    {
        $this->days = range(1, $days);
    }

    public function __construct(QianDao $qianDao)
    {
        $this->middleware('auth');
        $this->user = auth()->user();
        $this->now = time();
        $this->start = '2018-06';
        $this->model = $qianDao;
        $this->action='qiandao';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $date = $this->setDate($this->now);
        $days = $this->model->user($this->user->user_id)->where('year', $this->getYear())
            ->where('month', $this->getMonth())->whereIn('day', $date['days'])
            ->orderBy('add_time', 'desc')->lists('day')->toArray();
        $yesterday = $this->model->user($this->user->user_id)->where('year', $this->getYear())
            ->where('month', $this->getMonth())
            ->where('day', $this->getDay() - 1)->first();
        $today = $this->model->user($this->user->user_id)->where('year', $this->getYear())
            ->where('month', $this->getMonth())
            ->where('day', $this->getDay())->first();
        $jf_rules = $this->model->jf_rules();
        $tmp_index=1;
        if(isset($yesterday->days)){
            $tmp_index=$yesterday->days;
        }
        if(isset($jf_rules[$tmp_index]))
            $jf=$jf_rules[$tmp_index];
        else
            $jf=$jf_rules[1];
        // $jf = $jf_rules[$yesterday->days ?? 1] ?? $jf_rules[1];
        $this->set_assign('days', $days);
        $this->set_assign('jf', $jf);
        $this->set_assign('date', $date);
        $this->set_assign('yesterday', $yesterday);
        $this->set_assign('today', $today);
        $this->set_assign('prev', $this->getYear() . '-' . $this->getMonth() > $this->start);
        $this->set_assign('next', false);
        $this->common_value();
        // dd($this->assign);
        if(request()->route()->getName()=='qiandao111'){
            // dd($this->assign);
            return view('hd.111.qiandao', $this->assign);
        }
        return view('jifen.qiandao', $this->assign);
    }

    public function store(Request $request)
    {
        $this->setDate($this->now);
        $info = $this->model->user($this->user->user_id)->where('year', $this->getYear())
            ->where('month', $this->getMonth())->where('day', $this->getDay())->first();
        if ($info) {
            $this->set_assign('info', $info);
            ajax_return('您今天已经签到过了', 1, $this->assign);
        } else {
            $yesterday = $this->model->user($this->user->user_id)->where('year', $this->getYear())
                ->where('month', $this->getMonth())
                ->where('day', $this->getDay() - 1)->first();
            $info = new QianDao();
            $info->user_id = $this->user->user_id;
            $info->add_time = $this->now;
            $info->days = $yesterday ? $yesterday->days + 1 : 1;
            $info->year = $this->getYear();
            $info->month = $this->getMonth();
            $info->day = $this->getDay();
            $flag = DB::transaction(function () use ($info) {
                $info->setRelation('user', $this->user);
                $info->save();
                if ($info->id == 0) {
                    return 1;
                }
            });
            if (!is_null($flag)) {
                ajax_return('签到失败', 1);
            }
            $this->set_assign('info', $info);
            $jf_rules = $info->jf_rules();
            $jf = $jf_rules[$info->days];
            ajax_return('签到成功,，获得积分<span style="color: red;font-size: 14px;">+' . $jf . '</span>', 0, $this->assign);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function changeDate(Request $request)
    {
        $date = $request->input('date', date('Y-m'));
        $next = intval($request->input('next'));
        if ($date <= $this->start && $next == -1) {
            $this->set_assign('error', 1);
            $this->set_assign('msg', '当前月份已是签到时间起点');
            return $this->assign;
        }
        if (strtotime($date) > $this->now && $next == 1) {
            $this->set_assign('error', 1);
            $this->set_assign('msg', '当前月份已是签到时间起点');
            return $this->assign;
        }
        $date = $this->setDate(strtotime($date), $next);
        $days = $this->model->user($this->user->user_id)->where('year', $this->getYear())
            ->where('month', $this->getMonth())->whereIn('day', $date['days'])
            ->orderBy('add_time', 'desc')->lists('day')->toArray();
        $jf_rules = $this->model->jf_rules();
        $tmp_index=1;
        if(isset($yesterday->days)){
            $tmp_index=$yesterday->days;
        }
        if(isset($jf_rules[$tmp_index]))
            $jf=$jf_rules[$tmp_index];
        else
            $jf=$jf_rules[1];
        // $jf = $jf_rules[$yesterday->days ?? 1] ?? $jf_rules[1];
        $this->set_assign('days', $days);
        $this->set_assign('jf', $jf);
        $this->set_assign('error', 0);
        $this->set_assign('date', $date);
        $this->set_assign('prev', $this->getYear() . '-' . $this->getMonth() > $this->start);
        $this->set_assign('next', $this->getYear() . $this->getMonth() < date('Ym', $this->now));
        return $this->assign;
    }

    /**
     * @param $now
     * @param int $next
     * @return array
     */
    protected function setDate($now, $next = 0)
    {
        if ($next != 0) {
            $current = strtotime($next . ' month', $now);
        } else {
            $current = $now;
        }
        $this->setYear(date('Y', $current));
        $this->setMonth(date('m', $current));
        $this->setDay(date('d', $current));
        $this->setDays(date("t", strtotime($this->getYear() . '-' . $this->getMonth())));
        return [
            'year' => $this->getYear(),
            'month' => $this->getMonth(),
            'day' => $this->getDay(),
            'days' => $this->getDays(),
        ];
    }

    protected function getDate($format, $timestamp)
    {
        return intval(date($format, $timestamp));
    }
}
