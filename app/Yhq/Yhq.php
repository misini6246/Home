<?php
/**
 * Created by PhpStorm.
 * User: chunyang
 * Date: 2017-09-27
 * Time: 16:52
 */

namespace App\Yhq;


class Yhq
{

    protected $yhq;

    public function __construct(YhqInterface $yhq)
    {
        $this->yhq = $yhq;
    }

    public function chooseYhq()
    {
        return $this->yhq->chooseYhq();
    }

    public function useYhq()
    {
        return $this->yhq->useYhq();
    }

}