<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'ad';
    protected $primaryKey = 'ad_id';
    /**
     * 表明模型是否应该被打上时间戳
     *
     * @var bool
     */
    public $timestamps = false;

    //获取广告及广告位置
    public function AdPosition()
    {

        return $this->belongsTo('App\AdPosition', 'position_id');

    }

    /**
     * @param $pid
     * @param bool $type
     * @return mixed
     */
    public static function get_ads($pid, $type = false)
    {

        $query = self::where('start_time', '<', time())->where('end_time', '>', time())->where('position_id', $pid)
            ->where('enabled', 1)
            ->orderBy('sort_order', 'desc')->orderBy('ad_id', 'desc');
        if ($type) {
            $ads = $query->first();
        } else {
            $ads = $query->get();
        }

        return $ads;
    }

    /**
     * @return array
     */
    public static function check_ids()
    {
        $nowtime = time();
        $ad_arr = self::where(function ($query) {
            $query->where('position_id', 174)->orwhere('position_id', 175);
        })->where('start_time', '<=', $nowtime)->where('end_time', '>=', $nowtime)
            ->select('ad_bgc')
            ->take(12)->get();
        //dd($ad_arr);
        $check_ids = [];
        foreach ($ad_arr as $v) {
            $check_ids[] = trim($v['ad_bgc']);
        }
        return $check_ids;
    }


}
