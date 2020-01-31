<?php namespace App\Repositories\Criteria;

use Bosnadev\Repositories\Criteria\Criteria;
use Bosnadev\Repositories\Contracts\RepositoryInterface as Repository;

/**
 * Class IndexAd
 *
 * @package App\Repositories\Criteria
 */
class IndexAd extends Criteria {

    /**
     * @param            $model
     * @param Repository $repository
     *
     * @return mixed
     */
    public function apply($model, Repository $repository)
    {
        return $model->where('start_time','<',time())->where('end_time','>',time())
            ->select('position_id','ad_id','ad_name','ad_code','start_time','ad_link','end_time','ad_bgc')
            ->orderBy('sort_order','desc')->orderBy('ad_id','desc');
    }
}