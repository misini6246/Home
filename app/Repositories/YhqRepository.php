<?php
/**
 * Created by PhpStorm.
 * User: lilong
 * Date: 2018/9/11
 * Time: 14:24
 */

namespace App\Repositories;


use App\Models\Yhq;
use App\Models\YhqCategory;

class YhqRepository
{
    protected $yhq;

    protected $yhqCategory;

    public function __construct(Yhq $yhq, YhqCategory $yhqCategory)
    {
        $this->yhq = $yhq;
        $this->yhqCategory = $yhqCategory;
    }

    /**
     * @return mixed
     * 获取会员有效优惠券
     */
    public function getUserYhq()
    {
        return $this->yhq->with([
            'category' => function ($query) {
                $query->select('cat_id', 'title');
            }
        ])->userVisible()->get();
    }
}