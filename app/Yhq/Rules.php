<?php
/**
 * Created by PhpStorm.
 * User: chunyang
 * Date: 2017-09-27
 * Time: 17:07
 */

namespace App\Yhq;


abstract class Rules implements YhqInterface
{

    use YhqTrait;

    protected $order;

    protected $yhq_amount;

    public function __construct($order)
    {
        $this->order = $order;
    }

}