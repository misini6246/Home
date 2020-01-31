<?php
/**
 * Created by PhpStorm.
 * User: chunyang
 * Date: 2017-10-11
 * Time: 10:34
 */

namespace App\Observers\Jifen;

use App\jf\QianDao;

class QianDaoObserver
{
    public function creating(QianDao $qianDao)
    {
        $jf_rules = $qianDao->jf_rules();
        $jf = $jf_rules[$qianDao->days];
        $qianDao->desc = '签到送积分：' . $jf . '（连续签到' . $qianDao->days . '天，签到前积分：' . $qianDao->user->pay_points . '）';
    }

    public function created(QianDao $qianDao)
    {
        $jf_rules = $qianDao->jf_rules();
        $jf = $jf_rules[$qianDao->days];
        log_account_change($qianDao->user_id, 0, 0, 0, $jf, '签到送积分：' . $jf . '（连续签到' . $qianDao->days . '天，签到前积分：' . $qianDao->user->pay_points . '）');
    }
}