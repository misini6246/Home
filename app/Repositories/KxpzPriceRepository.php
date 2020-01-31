<?php
/**
 * Created by PhpStorm.
 * User: lilong
 * Date: 2018/6/27
 * Time: 16:31
 */

namespace App\Repositories;


use App\Yyg\KxpzPrice;

class KxpzPriceRepository
{
    protected $kxpzPrice;

    protected $user;

    public function __construct(KxpzPrice $kxpzPrice)
    {
        $this->kxpzPrice = $kxpzPrice;
        $this->user = auth()->user();
    }

    public function getAuthUser()
    {
        $query = $this->kxpzPrice->where(function ($query) {
            $query->where('ls_regions', 'like', '%.' . $this->user->country . '.%')//区域限制
            ->orwhere('ls_regions', 'like', '%.' . $this->user->province . '.%')
                ->orwhere('ls_regions', 'like', '%.' . $this->user->city . '.%')
                ->orwhere('ls_regions', 'like', '%.' . $this->user->district . '.%')
                ->orwhere('user_id', $this->user->user_id);//会员限制
        });
        if (in_array($this->user->user_rank, [2, 5])) {
            $query = $query->where('area_price', '>', 0);
        } else {
            $query = $query->where('company_price', '>', 0);
        }
        return $query->lists('goods_id');
    }
}