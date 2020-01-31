<?php namespace App\Repositories;

use Bosnadev\Repositories\Contracts\RepositoryInterface;
use Bosnadev\Repositories\Eloquent\Repository;

/**
 * Class BuyRepository
 * @package App\Repositories
 */
class BuyRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return 'App\Buy';
    }
}