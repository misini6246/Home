<?php

namespace App\Providers;

use App\Goods;
use App\jf\QianDao;
use App\Observers\Jifen\QianDaoObserver;
use App\Observers\OrderInfoObserver;
use App\OrderInfo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $arr = [];
        $arr['ad26'] = ads(152, true);
        $arr['ad152'] = ads(152, true);
        $arr['rand_num'] = time();
        view()->share($arr);
        view()->composer(['layout.member_info', 'layout.user_menu'], function ($view) {
            $view->with('user', auth()->user());
        });
        view()->composer(['layout.page_header', 'common.header', 'index', 'layout.nav', 'huodong.qixi'], function ($view) {
            $search_keywords = explode(',', shopConfig('search_keywords'));
            $view->with('user', auth()->user());
            $view->with('cart_num', cart_info());
            $view->with('search_keywords', $search_keywords);
            $view->with('ad159', ads(159));
            $now = time();
            $start = strtotime('20160809');
            $end = strtotime('20160810');
            if ($now >= $start && $now <= $end) {
                $qixi = route('category.index', ['step' => 'promotion']);
            } elseif ($now <= $start) {
                $qixi = route('category.index', ['step' => 'nextpro']);
            } else {
                $qixi = '#';
            }
            $view->with('qixi_url', $qixi);
        });
        view()->composer('category', function ($view) {
            $view->with('ad34', ads(34));
        });
        view()->composer('auth.login', function ($view) {
            $view->with('ad157', ads(157, true));
        });
        view()->composer('topad', function ($view) {
            $view->with('ad26', ads(26));
        });
        view()->composer(['layout.nav', 'common.nav'], function ($view) {
            $view->with('middle_nav', nav_list('middle'));
        });
        view()->composer('layout.cate_tree', function ($view) {
            $cate_tree = [
                'py' => '中西成药',
                'tj' => '进口.合资',
                'xty' => '国/川.基药',
                'ylqx' => '器械.计生',
                'bjp' => '保健食品',
                'zyyp' => '中药饮片'
            ];
            $view->with('cate_tree', $cate_tree);
        });
        view()->composer(['zy_goods', 'zy', 'zy_category'], function ($view) {
            /**
             * 重点推荐品
             */
            $user = auth()->user();
            if (auth()->check()) {
                $user = $user->is_new_user();
            }
            $zdtj = Goods::rqdp('is_wntj', 4, 4);
            $view->with('zdtj', $zdtj);

        });

        view()->composer(['layout.nav', 'common.nav'], function ($view) {
            $view->with('cate_tree', cate_tree_new());
        });
        view()->composer('layout.page_footer', function ($view) {
            $view->with('friend_link', friend_link('img'));
        });
        //新首页
        view()->composer(['layouts.nav'], function ($view) {
            $cate_tree = cate_tree_new();
            $ids = [490, 496, 531, 548, 575, 620, 536, 584, 619, 767, 788, 796, 778,
                801, 655, 665, 674, 682, 445, 683, 12, 732, 739, 751, 899, 922];
            foreach ($cate_tree as $v) {
                if (in_array($v->cat_id, $ids)) {
                    $blm = 'cate' . $v->cat_id;
                    $$blm = $v;
                }
            }
            foreach ($ids as $v) {
                $blm = 'cate' . $v;
                $cate_tree->$blm = $$blm;
            }
            $view->with('cate_tree', $cate_tree);
        });
        view()->composer(['layouts.search'], function ($view) {
            $view->with('ad159', ads(159));
        });
        view()->composer(['layouts.header'], function ($view) {
            $view->with('user', auth()->user());
        });
        view()->composer(['layout.nav', 'common.nav', 'layouts.nav'], function ($view) {
            $view->with('middle_nav', nav_list('middle'));
        });
        OrderInfo::observe(OrderInfoObserver::class);
        QianDao::observe(QianDaoObserver::class);

//        DB::listen(function ($sql, $bindings, $time) {
//            Log::info('db listen', [
//                'sql' => $sql,
//                'bindings' => $bindings,
//                'time' => $time
//            ]);
//        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
