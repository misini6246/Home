<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/19
 * Time: 11:49
 */

namespace App\Http\Controllers\Superman;


class Surperman {
//    protected $power;
//
//    public function __construct(array $modules)
//    {
//        // 初始化工厂
//        $factory = new SuperModuleFactory;
//
//        // 通过工厂提供的方法制造需要的模块
//        foreach ($modules as $moduleName => $moduleOptions) {
//            $this->power[] = $factory->makeModule($moduleName, $moduleOptions);
//        }
//    }
    protected $module;

    public function __construct(SuperModuleInterface $module,$goods,$order)
    {
        $this->module = $module;
    }

    public function index(){
        return $this->module;
    }
}