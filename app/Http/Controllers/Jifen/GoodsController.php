<?php
namespace App\Http\Controllers\Jifen;
use App\Http\Controllers\Controller;
use App\jf\Goods;
use App\jf\GoodsCate;
use Illuminate\Http\Request;

class GoodsController extends Controller
{
    use JfTrait;

    public function __construct()
    {
        $this->user = auth()->user();
        $this->now = time();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cate_id = intval($request->input('cate_id'));
        $range_id = intval($request->input('range_id'));
        $query = Goods::with('goodsImg')->where('is_verify', 1);
        if ($cate_id > 0) {
            $query->where('cate_id', $cate_id);
        }
        if ($range_id > 0) {
            $range = $this->jifen_range($range_id);
            if ($range['start'] != -1) {
                $query->where('jf', '>=', $range['start']);
            }
            if ($range['end'] != -1) {
                $query->where('jf', '<', $range['end']);
            }
        }
        $result = $query->select('id', 'goods_stock', 'name', 'jf', 'goods_image', 'market_price')->get();
        $cate = GoodsCate::lists('name', 'id');
        $cate[0] = '不限';
        $cate = $cate->sortBy(function ($v, $k) {
            return $k;
        });
        $this->set_assign('result', $result);
        $this->set_assign('cate', $cate);
        $this->set_assign('jifen_range', $this->jifen_range());
        $this->set_assign('cate_id', $cate_id);
        $this->set_assign('range_id', $range_id);
        $this->common_value();
        return view('jifen.goods_list', $this->assign);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id = intval($id);
        $info = Goods::with('goodsImg')->where('id', $id)->where('is_verify', 1)
            ->first();
        if (!$info) {
            return redirect()->to('jf');
        }
        $info->introduction = str_replace('/jf/includes/ueditor1433/', 'http://hhouttai.hezongyy.com/jf/includes/ueditor1433/', $info->introduction);
        $this->set_assign('info', $info);
        $this->set_assign('top5', $this->getTop5());
        $this->common_value();
        // dd($this->assign);
        return view('jifen.goods', $this->assign);
    }


    protected function jifen_range($key = null)
    {
        $arr = [
            '0' => [
                'start' => -1,
                'end' => -1,
                'text' => '不限'
            ],
            '1' => [
                'start' => 0,
                'end' => 30000,
                'text' => '1-30000分'
            ],
            '2' => [
                'start' => 30000,
                'end' => 100000,
                'text' => '30000-100000分'
            ],
            '3' => [
                'start' => 100000,
                'end' => 200000,
                'text' => '100000-200000分'
            ],
            '4' => [
                'start' => 200000,
                'end' => -1,
                'text' => '200000分以上'
            ],
        ];
        if (!is_null($key)) {
            if(!empty($arr[$key])){
                return $arr[$key];
            }else{
                return $arr[0];
            }
            // return $arr[$key] ?? $arr[0];
        }
        return $arr;
    }
}
