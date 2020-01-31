<?php

namespace App\Http\Controllers\zyzq;

use App\Category;
use App\Http\Controllers\Controller as BaseController;

class Controller extends BaseController
{

    public function __construct()
    {
        $this->user = auth()->user();
        if ($this->user) {
            $this->user->is_new_user();
        }
        $category = Category::with([
            'cate' => function ($query) {
                $query->with('cate');
            }
        ])->where('parent_id', 445)->take(5)->get();
        $this->setAssign('middle_nav', nav_list('middle'));
        $this->setAssign('category', $category);
        $this->setAssign('page_title', '中药专区-');
        $this->setAssign('user', $this->user);
    }

    /**
     * @return array
     */
    public function getAssign($key)
    {
        return $this->assign[$key];
    }

    /**
     * @param $key
     * @param $value
     */
    public function setAssign($key, $value)
    {
        $this->assign[$key] = $value;
    }
}
