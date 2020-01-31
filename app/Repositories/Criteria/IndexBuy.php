<?php namespace App\Repositories\Criteria;

use Bosnadev\Repositories\Criteria\Criteria;
use Bosnadev\Repositories\Contracts\RepositoryInterface as Repository;

/**
 * Class IndexBuy
 *
 * @package App\Repositories\Criteria
 */
class IndexBuy extends Criteria {

    /**
     * @param            $model
     * @param Repository $repository
     *
     * @return mixed
     */
    public function apply($model, Repository $repository)
    {
        return $model->select('buy_goods','buy_number','buy_addtime')
            ->orderBy('buy_addtime','desc')
            ;
    }
}