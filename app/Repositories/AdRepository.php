<?php namespace App\Repositories;

use Bosnadev\Repositories\Contracts\RepositoryInterface;
use Bosnadev\Repositories\Eloquent\Repository;

/**
 * Class AdRepository
 * @package App\Repositories
 */
class AdRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return 'App\Ad';
    }
}