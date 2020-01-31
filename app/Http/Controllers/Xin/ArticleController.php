<?php

namespace App\Http\Controllers\Xin;

use App\Article;
use App\ArticleCat;
use App\Common\Page;
use App\Http\Controllers\Controller;
use App\Models\FanKui;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    use Page;

    private $sort;

    private $order;

    private $page_mum = 10;

    public $assign;

    public $user;

    public function __construct()
    {
        $this->user           = auth()->user();
        $this->assign['user'] = $this->user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cat_id = intval($request->input('cat_id', 4));
        $info   = ArticleCat::find($cat_id);
        if (!$info) {
            tips1('您访问的页面不存在');
        }
        $this->result = Article::where('cat_id', $cat_id)->where('is_open', 1)->select('*')->orderBy('add_time', 'desc')->Paginate($this->page_mum);
        $this->result = $this->add_params($this->result, ['cat_id' => $cat_id]);
        foreach ($this->result as $v) {
            $v->content = cutstr_html($v->content, 120);
        }
        $this->assign['cat_id']     = $cat_id;
        $this->assign['result']     = $this->result;
        $this->assign['info']       = $info;
        $this->assign['pages_view'] = $this->pagesView();
        $this->assign['page_title'] = $info->cat_name . '-';
        return view('article.index', $this->assign);
    }

    protected function help(Request $request)
    {
        $cat_id                     = intval($request->input('cat_id', 1));
        $article_id                 = intval($request->input('article_id', 1));
        $articles                   = $this->articles($cat_id);
        $this->assign['cat_id']     = $cat_id;
        $this->assign['article_id'] = $article_id;
        $this->assign['category']   = $this->category();
        $this->assign['articles']   = $articles;
        $this->assign['page_title'] = $articles[$article_id] . '-';
        $view                       = 'article.help.article' . $cat_id . $article_id;
        return view($view, $this->assign);
    }

    private function category()
    {
        return [
            1 => '新人指南',
            2 => '配送方式',
            3 => '支付方式',
            4 => '售后服务',
            5 => '关于我们',
            6 => '商业合作',
        ];
    }

    private function articles($cat_id)
    {
        $arr = [
            1 => [
                1 => '免费注册',
                2 => '安全购药',
                3 => '所需资质',
                4 => '积分说明',
                5 => '找回密码',
                6 => '常见问题',
            ],
            2 => [
                1 => '物流配送',
                2 => '包装流程',
                3 => '验收流程',
            ],
            3 => [
                1 => '在线支付',
                2 => '转账汇款',
                3 => '开具发票',
            ],
            4 => [
                1 => '退换货政策',
                2 => '退换货流程',
                3 => '退款说明',
                4 => '投诉与建议',
                5 => '用户协议',
            ],
            5 => [
                1 => '业界荣耀',
                2 => '联系我们',
                3 => '公司简介',
            ],
            6 => [
                1 => '广告合作',
            ],
        ];
        return isset($arr[$cat_id]) ? $arr[$cat_id] : $arr[1];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article = Article::where('is_open', 1)->find($id);
        $prev    = Article::where('article_id', '<', $id)->where('is_open', 1)->orderBy('article_id', 'desc')->first();
        $next    = Article::where('article_id', '>', $id)->where('is_open', 1)->orderBy('article_id', 'asc')->first();
        $info    = ArticleCat::find($article->cat_id);
        if ($article->article_id >= 348) {
            $article->content = str_replace('/ueditor/php/upload/image/', $this->get_img_path('/ueditor/php/upload/image/'), $article->content);
        } else {
            $article->content = str_replace('/images/ueditor/upload/image/', get_img_path('images/ueditor/upload/image/'), $article->content);
        }
        $this->assign['cat_id']     = $info->cat_id;
        $this->assign['article']    = $article;
        $this->assign['info']       = $info;
        $this->assign['prev']       = $prev;
        $this->assign['next']       = $next;
        $this->assign['page_title'] = $info->cat_name . '-';
        return view('article.show', $this->assign);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function add_params($result, $params = [])
    {
        $params = array_merge($params, [
            'sort'     => $this->sort,
            'order'    => $this->order,
            'page_num' => $this->page_mum,
        ]);
        foreach ($params as $k => $v) {
            if (!empty($v)) {
                $this->assign[$k] = $v;
                $result->appends([$k => $v]);
            }
        }
        $result->params = $params;
        return $result;
    }

    private function get_img_path($img)
    {
        $http = "http://manage.hezongyy.com/";
        return $http . $img;
    }

    public function fankui(Request $request)
    {
        $type         = intval($request->input('type'));
        $connect_info = trim($request->input('connect_info'));
        $msg_content  = trim($request->input('msg_content'));
        $start        = strtotime(date('Ymd'));
        $end          = strtotime('+1 day');
        $count        = FanKui::where('user_id', $this->user->user_id)->whereBetween('add_time', [$start, $end])->count();
        if ($count >= 3) {
            ajax_return('每位用户一天可以提交三条意见！感谢您的宝贵意见。', 1);
        }
        $fankui               = new FanKui();
        $fankui->user_id      = $this->user->user_id;
        $fankui->type         = $type;
        $fankui->connect_info = $connect_info;
        $fankui->msg_content  = $msg_content;
        $fankui->add_time     = time();
        $fankui->save();
        ajax_return('提交成功！感谢您的宝贵意见。');
    }
}
