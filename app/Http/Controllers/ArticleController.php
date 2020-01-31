<?php

namespace App\Http\Controllers;

use App\Article;
use App\ArticleCat;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $id   = $request->input('id', '');
        if (empty($id)) {
            return redirect('/');
        }

        $artCat  = Cache::tags('article')->rememberForever('artCat', function () {
            return ArticleCat::with([
                'article' => function ($query) {
                    $query->select('cat_id', 'article_id', 'title');
                }
            ])->where(function ($query) {
                $query->where('cat_id', '!=', 1)->where(function ($query) {
                    $query->where('cat_type', 5);
                });
            })->orderBy('parent_id', 'desc')->select('cat_id', 'cat_name')->get();
        });
        $ur_here = ArticleCat::where('cat_id', $id)->select('cat_id', 'cat_name')->firstOrfail();
        if (!$ur_here) {
            return redirect('/');
        }

        $articleList1 = Cache::tags('article')->remember('articleList' . $id . $request->input('page', 1), 60, function () use ($id, $ur_here) {
            return Article::where(function ($query) use ($id, $ur_here) {
                if ($id == 3) {
                    $query->whereIn('cat_id', [17,20]);
                } else {
                    $query->where('cat_id', $ur_here->cat_id);
                }
            })
                ->select('article_id', 'title', 'content')
                ->orderBy('add_time', 'desc')->Paginate(10);
        });
        $articleList=Article::where('cat_id',$id)->paginate(2);
        foreach ($articleList as $v) {
            $v->content = cutstr_html($v->content, 120);
        }
        if (in_array($id, [3, 5, 7, 8, 9])) {
            $view  = 'article';
            $title = '帮助中心';
        } else {
            $view  = 'info';
            $title = $ur_here->cat_name;
        }
        $page_title = $ur_here->cat_name;

        //llPrint($artCat,2);
        $assign = [
            'page_title' => $page_title,
            'ur_here'    => $ur_here,
            'user'       => $user,
            'artCat'     => $artCat,
            'id'         => $id,
            'pages'      => $articleList,
            'title'      => $title,
            'params'     => [
                'url' => 'article.index',
                'id'  => $id,
            ],
        ];
        //dd($assign);
        return view($view)->with($assign);
    }

    /*
     * 文章详情
     */
    public function articleInfo(Request $request)
    {
        $user=Auth::user();
        $id=$request->input('id');
        $article=Article::with(['articleCat'=>function($query){
            $query->select('cat_id','cat_name','parent_id');
        }])->where('article_id',$id)->select('cat_id','article_id','title','content','author','add_time')->firstOrfail();
        if ($article->article_id >= 348) {
            $article->content = str_replace('/ueditor/php/upload/image/', $this->get_img_path('/ueditor/php/upload/image/'), $article->content);
        } else {
            $article->content = str_replace('/ueditor/php/upload/image/', $this->get_img_path('/ueditor/php/upload/image/'), $article->content);
        }
        $page_title=$article->title.'-';
        $cat_id=$article->cat_id;
        $view='articleInfo';
        $top        = '
        <div class="top">
        <span class="title">' . trans('common.nowPosition') . ':</span>
        <a class="end"><span></span></a><a href="' . route('index') . '">首页</a>
        <code>&gt;</code> <a href="' . route('article.index', ['id' => $article->cat_id]) . '">' . $article->articleCat->cat_name . '</a>
        <code>&gt;</code> <a href="' . route('articleInfo', ['id' => $article->article_id]) . '">' . $article->title . '</a>
        </div>';

        if(!in_array($article->cat_id,[17,20])){//如果不为行业动态和资讯，就去
            $help=Article::where('cat_id',$article->cat_id)->get();
            $l=$article->cat_id;
            $article=$article->content;
            $view='helpInfo';
//            $title=trans('common.help');
        }else{
            $l=$article->cat_id;
            $title=$article->articleCat->cat_name;
        }


        $preArticle = Article::where('article_id','<',$id)->where(function($query){
            $query->where('cat_id',20)->orwhere('cat_id',17);
        })
            ->select('article_id','title')
            ->orderBy('article_id','desc')
            ->first();

//        //下一篇
        $nextArticle = Article::where('article_id','>',$id)->where(function ($query){
            $query->where('cat_id',20)->orwhere('cat_id',17);
        })
            ->select('article_id','title')
            ->orderBy('article_id')
            ->first();
        $artCat = Cache::tags('article')->rememberForever('artCat', function () {
            return ArticleCat::with([
                'article' => function ($query) {
                    $query->select('cat_id'
                        , 'article_id', 'title');
                }
            ])->where(function ($query) {
                $query->where('cat_id', '!=', 1)->where(function ($query) {
                    $query->where('cat_type', 5);
                });
            })->orderBy('parent_id', 'desc')->select('cat_id', 'cat_name')->get();
        });
        $assign=[
            'page_title'=>$page_title,
            'cat_id'=>$cat_id,
            'article'=>$article,
            'preArticle'=>$preArticle,
            'nextArticle'=>$nextArticle,
            'user'       => $user,
            'id'         => $id,
            'top'=>$top,
            'artCat'     => $artCat,
        ];

//dd($assign);
        if(!in_array($l, [17,20])){

            $assign['help']=$help;
            return view($view)->with($assign);
        }else{

            return view($view)->with($assign);
        }
    }

    /*
     * 模板
     */
    private function templates($id)
    {
        $templates = [];
        $templates[67] = <<<html
        <style type="text/css">
            .help_container{height: 8310px;}
            .help_container .main_left{height: 8310px;;}
        </style>
        <div class="main_right">
            <div><img src="http://images.hezongyy.com/images/help_anquan_04.jpg"></div>
            <div><img src="http://images.hezongyy.com/images/help_anquan_05.jpg"></div>
            <div><img src="http://images.hezongyy.com/images/help_anquan_06.jpg"></div>
            <div><img src="http://images.hezongyy.com/images/help_anquan_07.jpg"></div>
            <div><img src="http://images.hezongyy.com/images/help_anquan_08.jpg"></div>
            <div><img style="width: 1000px;" src="http://images.hezongyy.com/images/help_anquan_09.jpg?1"></div>
            <div><img src="http://images.hezongyy.com/images/help_anquan_10.jpg"></div>
            <div><img src="http://images.hezongyy.com/images/help_anquan_11.jpg"></div>
            <div><img src="http://images.hezongyy.com/images/help_anquan_12.jpg"></div>
            <div><img src="http://images.hezongyy.com/images/help_anquan_13.jpg"></div>
            <div><img src="http://images.hezongyy.com/images/help_anquan_14.jpg"></div>
        </div>
html;
        $templates[65] = <<<html
        <style type="text/css">
.help_container{height: 1646px;}
.help_container .main_left{height: 1646px;}
</style>
<div class="main_right">
			<div><img src="http://images.hezongyy.com/images/help_zhuce_03.jpg"></div>
			<div><img src="http://images.hezongyy.com/images/help_zhuce_05.jpg"></div>
			<div><img src="http://images.hezongyy.com/images/help_zhuce_06.jpg"></div>
			<div><img src="http://images.hezongyy.com/images/help_zhuce_08.jpg?1"></div>
		</div>
html;

        $templates[125] = <<<html
<style type="text/css">
.help_container{height: 1073px;}
.help_container .main_left{height: 1073px;}
</style>
<div class="main_right">
			<div><img src="http://images.hezongyy.com/images/helper_zizi_01.jpg"></div>
			<div><img src="http://images.hezongyy.com/images/helper_zizi_02.jpg"></div>
			<div style="position: relative">
			<img src="http://images.hezongyy.com/images/helper_zizi_03.jpg?2">
			<a href="/uploads/采购委托书模板.doc" style="position: absolute;width: 200px;height: 28px;left: 25px;top: 20px;"></a>
			<a href="/uploads/购买特殊管理药品委托书格式.doc" style="position: absolute;width: 280px;height: 28px;left: 250px;top: 20px;"> </a>
			</div>

		</div>
html;

        $templates[47] = <<<html
<style type="text/css">
.help_container{height: 600px;}
.help_container .main_left{height: 600px;}
</style>
	<div class="main_right">
			<div><img src="http://images.hezongyy.com/images/helper_wl_01.jpg?1"></div>


		</div>
html;

        $templates[49] = <<<html
<style type="text/css">
.help_container{height: 1455px;}
.help_container .main_left{height: 1455px;}
</style>
		<div class="main_right">
			<div><img src="http://images.hezongyy.com/images/helper_shifu_03.jpg"></div>
			<div><img src="http://images.hezongyy.com/adimages1/201807/yinhangxinxi.png?4"></div>


		</div>
html;

        $templates[54] = <<<html
<style type="text/css">
.help_container{height: 698px;}
.help_container .main_left{height: 698px;}
</style>
	<div class="main_right">
			<div><img src="http://images.hezongyy.com/images/helper_tuihuan_03.jpg"></div>
			<div><img src="http://images.hezongyy.com/images/helper_tuihuan_05.jpg"></div>



		</div>
html;

        $templates[91] = <<<html
<style type="text/css">
.help_container{height: 3850px;}
.help_container .main_left{height: 3850px;}
</style>
		<div class="main_right">
			<div><img src="http://images.hezongyy.com/images/helper_ylzf_03.jpg"></div>
			<div><img src="http://images.hezongyy.com/images/helper_ylzf_05.jpg"></div>
			<div><img src="http://images.hezongyy.com/images/helper_ylzf_06.jpg"></div>
			<div><img src="http://images.hezongyy.com/images/helper_ylzf_07.jpg"></div>
			<div><img src="http://images.hezongyy.com/images/helper_ylzf_09.jpg"></div>
			<div><img src="http://images.hezongyy.com/images/helper_ylzf_10.jpg"></div>
			<div><img src="http://images.hezongyy.com/images/helper_ylzf_12.jpg"></div>


		</div>
html;

        $templates[48] = <<<html
<style type="text/css">
.help_container{height:600px;}
.help_container .main_left{height: 600px;}
</style>
		<div class="main_right">
			<div><img src="http://images.hezongyy.com/images/helper_zl.jpg"></div>

		</div>
html;

        $templates[55] = <<<html
<style type="text/css">
.help_container{height: 600px;}
.help_container .main_left{height: 600px;}
</style>
		<div class="main_right">
			<div><img src="http://images.hezongyy.com/images/helper_fwdb_03.jpg"></div>
		</div>
html;

        $templates[73] = <<<html
<style type="text/css">
.help_container{height: 3636px;}
.help_container .main_left{height: 3636px;}
</style>
		<div class="main_right">
			<div><img src="http://images.hezongyy.com/images/helper_xy_03.jpg"></div>
			<div><img src="http://images.hezongyy.com/images/helper_xy_05.jpg"></div>
			<div><img src="http://images.hezongyy.com/images/helper_xy_06.jpg"></div>
			<div><img src="http://images.hezongyy.com/images/helper_xy_07.jpg"></div>
			<div><img src="http://images.hezongyy.com/images/helper_xy_09.jpg"></div>
			<div><img src="http://images.hezongyy.com/images/helper_xy_10.jpg"></div>
			<div><img src="http://images.hezongyy.com/images/helper_xy_11.jpg"></div>
			<div><img src="http://images.hezongyy.com/images/helper_xy_14.jpg"></div>
			<div><img src="http://images.hezongyy.com/images/helper_xy_16.jpg"></div>


		</div>
html;

        $templates[241] = <<<html
<style type="text/css">
.help_container{height:600px;}
.help_container .main_left{height: 600px;}
</style>
		<div class="main_right">
			<div><img src="http://images.hezongyy.com/images/helper_ad.jpg"></div>

		</div>
html;

        $templates[68] = <<<html
<style type="text/css">
.help_container{height:600px;}
.help_container .main_left{height: 600px;}
</style>
	<div class="main_right">
			<div><img src="http://images.hezongyy.com/images/helper_about_us.jpg?1"></div>

		</div>
html;

        if (isset($templates[$id])) {
            return $templates[$id];
        } else {
            return redirect()->back();
        }
    }

    public function feedback()
    {
        $user = auth()->user();
        Cache::tags('article')->flush();
        $artCat = Cache::tags('article')->remember('artCat', 8 * 60, function () {
            return ArticleCat::with([
                'article' => function ($query) {
                    $query->select('cat_id', 'article_id', 'title');
                }
            ])->where(function ($query) {
                $query->where('cat_id', '!=', 1)->where(function ($query) {
                    $query->where('cat_type', 5);
                });
            })->orderBy('parent_id', 'desc')->select('cat_id', 'cat_name')->get();
        });
        $help_nav = DB::table('article_cat')->where('show_in_nav',1)->where('parent_id',1)->get();
        //查询相关文章
        //dd($help_nav);
        $assign = [
            'page_title' => '用户反馈-',
            'user' => $user,
            'title' => '用户反馈',
            'artCat' => $artCat,
            'help_nav'=>$help_nav
        ];
        //dd($view);
        return view('help.feedback')->with($assign);
    }

    private function get_img_path($img)
    {
        $http = "http://112.74.176.233/";
        return $http . $img;
    }

}
