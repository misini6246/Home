<?php namespace App\Repositories\Criteria;

use Bosnadev\Repositories\Criteria\Criteria;
use Bosnadev\Repositories\Contracts\RepositoryInterface as Repository;

/**
 * Class IndexBuyTake
 *
 * @package App\Repositories\Criteria
 */
class IndexBuyTake extends Criteria {

    /**
     * @param            $model
     * @param Repository $repository
     *
     * @return mixed
     */
    public function apply($model, Repository $repository)
    {
        return $model->take(20);
    }
}