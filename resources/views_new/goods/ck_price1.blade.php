@extends('layouts.body')
@section('links')
    <link rel="stylesheet" type="text/css" href="{{path('css/index/new_common.css')}}"/>
    @if(isset($keywords)&&!empty($keywords))
        <link href="{{path('css/new/puyao1.css')}}2" rel="stylesheet" type="text/css"/>
    @else
        <link href="{{path('css/new/puyao.css')}}2" rel="stylesheet" type="text/css"/>
    @endif
    <link href="{{path('css/new/pages.css')}}" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="{{path('js/new/puyao.js')}}"></script>
    <script type="text/javascript" src="{{path('js/new/change_num.js')}}"></script>
    <script type="text/javascript" src="{{path('js/new/AAS.js')}}"></script>
    <script type="text/javascript" src="{{path('js/zs/lazyload.js')}}"></script>
    <script type="text/javascript" src="{{path('js/index/lb.js')}}"></script>
    <!--IE兼容-->
    <!--[if lte IE 8]>
    <link rel="stylesheet" type="text/css" href="{{path('css/index/iehack.css')}}"/>
    <![endif]-->
    <!--IE兼容-->
    <!--[if lte IE 7]>
    <script src="{{path('js/index/IEhack.js')}}" type="text/javascript" charset="utf-8"></script>
    <![endif]-->
@endsection
@section('content')
    @include('layouts.header')
    @include('layouts.search')
    @include('layouts.nav')
    <div class="goods-box">
        @if(isset($keywords)&&!empty($keywords))
            @include('goods.left')
        @endif
        <div class="goods-box-right">
            <div class="container-topimg">
                <a href="{{$fl_url}}"><img src="{{get_img_path('images/new/img-title.png')}}"/><span>药品筛选</span></a>
            </div>
            @if(isset($ylfl))
                <div class="shaixuan-yongtu" style="display: inline-block;z-index: 6;">
                    <img src="{{get_img_path('images/new/shaixuan-right.png')}}" class="toright"/>
                    <div class="shaixuan-box">

                        <div class="shaixuan-mingzi">
                            药理分类：<span class="choose-name">{{$show_area[$ylfl]}}</span>
                        </div>
                        <a href="{{$fl_url}}"><span
                                    class="title-shanchu">×</span></a>
                        <div class="yongtu-all" style="width: 950px;">
                            <ul>
                                @foreach($show_area as $k=>$v)
                                    @if($k!=$ylfl)
                                        <a href="{{$fl_url}}&ylfl={{$k}}">
                                            <li>
                                                <div>{{$v}}</div>
                                            </li>
                                        </a>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
            @if(isset($ylfl1))
                <div class="shaixuan-yongtu" style="display: inline-block;z-index: 6;">
                    <div class="shaixuan-box">

                        <div class="shaixuan-mingzi">
                            药理分类：<span class="choose-name">{{$ylfl1_name}}</span>
                        </div>
                        <a href="{{$fl_url1}}"><span
                                    class="title-shanchu">×</span></a>
                        <div class="yongtu-all" @if(in_array($ylfl,['d','g','h','k'])) style="width: 100%;"
                             @elseif(in_array($ylfl,['i','j']))
                             style="width: 340px;"
                             @else style="width: 800px;" @endif>
                            <ul>
                                @foreach($shaixuan['ylfl']['list'] as $v)
                                    @if($shaixuan['ylfl']['type']==1)
                                        @foreach($v['cate'] as $val)
                                            @foreach($val['cate'] as $value)
                                                @if($value->cat_id!=$ylfl1)
                                                    <a href="{{$fl_url1}}&ylfl1={{$value->cat_id}}">
                                                        <li>
                                                            <div>{{str_limit($value->cat_name,20)}}</div>
                                                        </li>
                                                    </a>
                                                @endif
                                            @endforeach
                                        @endforeach
                                    @else
                                        @if($v->cat_id!=$ylfl1)
                                            <a href="{{$fl_url1}}&ylfl1={{$v->cat_id}}">
                                                <li>
                                                    <div>{{str_limit($v->cat_name,20)}}</div>
                                                </li>
                                            </a>
                                        @endif
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
            @if(isset($ylfl2))
                <div @if(in_array($ylfl2,[923,753])) class="shaixuan-none" @else class="shaixuan-yongtu"
                     @endif style="display: inline-block;z-index: 6;">
                    <div class="shaixuan-box">

                        <div class="shaixuan-mingzi">
                            药理分类：<span class="choose-name">{{$ylfl2_name}}</span>
                        </div>
                        <a href="{{$fl_url2}}"><span
                                    class="title-shanchu">×</span></a>
                        <div class="yongtu-all" style="width: 650px;">
                            <ul>
                                @foreach($shaixuan['ylfl']['list'] as $v)
                                    @if($v->cat_id==$ylfl1)
                                        @if($shaixuan['ylfl']['type']==2)
                                            @foreach($v['cate'] as $val)
                                                @if($ylfl1==682)
                                                    @if($val->cat_id!=$ylfl2)
                                                        <a href="{{$fl_url2}}&ylfl2={{$val->cat_id}}">
                                                            <li>
                                                                <div>{{str_limit($val->cat_name,20)}}</div>
                                                            </li>
                                                        </a>
                                                    @endif
                                                @else
                                                    @foreach($val['cate'] as $value)
                                                        @if($ylfl1==$v->cat_id)
                                                            <a href="{{$fl_url2}}&ylfl2={{$value->cat_id}}">
                                                                <li>
                                                                    <div>{{str_limit($value->cat_name,20)}}
                                                                    </div>
                                                                </li>
                                                            </a>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        @else
                                            @foreach($v['cate'] as $val)
                                                @if($val->cat_id!=$ylfl2)
                                                    <a href="{{$fl_url2}}&ylfl2={{$val->cat_id}}">
                                                        <li>
                                                            <div>{{str_limit($val->cat_name,20)}}</div>
                                                        </li>
                                                    </a>
                                                @endif
                                            @endforeach
                                        @endif
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
            @if(!empty($xz_arr['jx']))
                <div @if(count($shaixuan['jx'])<=1) class="shaixuan-none" @else class="shaixuan-jixing"
                     @endif style="display: inline-block;z-index: 3;">
                    @if(!isset($ylfl))
                        <img src="{{get_img_path('images/new/shaixuan-right.png')}}" class="toright"/>
                    @endif
                    <div class="shaixuan-box">
                        <div class="shaixuan-mingzi">
                            剂型：<span class="choose-name">{{$xz_arr['jx']}}</span>
                        </div>
                        <a href="{{str_replace('jx='.$xz_arr['jx'],'',$result->url(1))}}">
                            <span class="title-shanchu">×</span>
                        </a>
                        <div class="yongtu-all" @if(count($shaixuan['jx'])>8) style="width: 630px"
                             @elseif(count($shaixuan['jx'])==2) style="width: 100%"
                             @else style="width: {{(count($shaixuan['jx'])-1)*80+30}}px" @endif>
                            <ul>
                                @foreach($shaixuan['jx'] as $v)
                                    @if($v!==$xz_arr['jx'])
                                        <a href="{{$result->url(1)}}&jx={{$v}}">
                                            <li>{{$v}}</li>
                                        </a>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
            @if(isset($ypgg))
                <div @if(count($shaixuan['ypgg'])<=1) class="shaixuan-none" @else class="shaixuan-guige"
                     @endif style="display: inline-block;z-index: 2;">
                    @if(!isset($ylfl))
                        <img src="{{get_img_path('images/new/shaixuan-right.png')}}" class="toright"/>
                    @endif
                    <div class="shaixuan-box">
                        <div class="shaixuan-mingzi">
                            规格：<span class="choose-name">{{$ypgg}}</span>
                        </div>
                        <a href="{{str_replace('ypgg='.$ypgg,'',$result->url(1))}}">
                            <span class="title-shanchu">×</span>
                        </a>
                        <div class="yongtu-all" @if(count($shaixuan['ypgg'])>8) style="width: 630px"
                             @elseif(count($shaixuan['ypgg'])==2) style="width: 100%"
                             @else style="width: {{(count($shaixuan['jx'])-1)*80+30}}px" @endif>
                            @if(count($shaixuan['ypgg'])>1)
                                <ul>
                                    @foreach($shaixuan['ypgg'] as $v)
                                        @if($v!==$ypgg)
                                            <a href="{{$result->url(1)}}&ypgg={{$v}}">
                                                <li>{{$v}}</li>
                                            </a>
                                        @endif
                                    @endforeach
                                </ul>
                            @endif
                        </div>

                    </div>
                </div>
            @endif
            @if(!empty($product))
                <div class="shaixuan-none" style="display: inline-block;z-index: 2;">
                    @if(!isset($ylfl))
                        <img src="{{get_img_path('images/new/shaixuan-right.png')}}" class="toright"/>
                    @endif
                    <div class="shaixuan-box">
                        <div class="shaixuan-mingzi">
                            <span class="choose-name">{{$product}}</span>
                        </div>
                        <a href="{{str_replace('product='.$product,'',$result->url(1))}}">
                            <span class="title-shanchu">×</span>
                        </a>
                    </div>
                </div>
            @endif
            <div class="shaixuan">
                <ul class="shaixuan-ul-1">
                    @if(count($fl_list)>0)
                        <li class="sx-li1 zhankai">
                            <div class="title">
                                药理分类：
                            </div>
                            @if(count($fl_list)>9)
                                <div class="more">
                                    更多
                                    <img src="{{get_img_path('images/new/xia.jpg')}}"/>
                                </div>
                                <div class="more-1">
                                    收起
                                    <img src="{{get_img_path('images/new/shang.jpg')}}"/>
                                </div>
                            @endif
                            <ul class="shaixuan-ul-2 shaixuan-1">
                                @foreach($fl_list as $k=>$v)
                                    @if(isset($ylfl1))
                                        <a href="{{$result->url(1)}}&ylfl2={{$v->cat_id}}">
                                            <li>{{$v->cat_name}}</li>
                                        </a>
                                    @elseif(isset($ylfl))
                                        <a href="{{$result->url(1)}}&ylfl1={{$v->cat_id}}">
                                            <li>{{$v->cat_name}}</li>
                                        </a>
                                    @else
                                        @if($k=='l')
                                            <a href="/zy">
                                                <li>{{$v}}</li>
                                            </a>
                                        @else
                                            <a href="{{$result->url(1)}}&ylfl={{$k}}">
                                                <li>{{$v}}</li>
                                            </a>
                                        @endif
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                    @endif
                    @if(count($shaixuan['jx'])>0&&empty($xz_arr['jx']))
                        <li class="sx-li2 zhankai">
                            <div class="title">
                                剂型：
                            </div>
                            @if(count($shaixuan['jx'])>9)
                                <div class="more">
                                    更多
                                    <img src="{{get_img_path('images/new/xia.jpg')}}"/>
                                </div>
                                <div class="more-1">
                                    收起
                                    <img src="{{get_img_path('images/new/shang.jpg')}}"/>
                                </div>
                            @endif
                            <ul class="shaixuan-ul-2 shaixuan-2">
                                @foreach($shaixuan['jx'] as $v)
                                    <a href="{{$result->url(1)}}&jx={{$v}}">
                                        <li>{{$v}}</li>
                                    </a>
                                @endforeach
                            </ul>
                        </li>
                    @endif
                    @if(count($shaixuan['ypgg'])>0&&empty($ypgg))
                        <li class="sx-li4 zhankai">
                            <div class="title">
                                规格：
                            </div>
                            @if(count($shaixuan['ypgg'])>9)
                                <div class="more">
                                    更多
                                    <img src="{{get_img_path('images/new/xia.jpg')}}"/>
                                </div>
                                <div class="more-1">
                                    收起
                                    <img src="{{get_img_path('images/new/shang.jpg')}}"/>
                                </div>
                            @endif
                            <ul class="shaixuan-ul-3 shaixuan-3">
                                @foreach($shaixuan['ypgg'] as $v)
                                    <a href="{{$result->url(1)}}&ypgg={{$v}}">
                                        <li>{{$v}}</li>
                                    </a>
                                @endforeach
                            </ul>
                        </li>
                    @endif
                    @if(count($shaixuan['sccj'])>0&&empty($product))
                        <li class="sx-li3">
                            <div class="title">
                                厂家首字母：
                            </div>

                            <ul class="shaixuan-ul-2 zimu">
                                @foreach(range('A','Z') as $v)
                                    <li id="{{$v}}" @if(!isset($shaixuan['sccj'][$v])) class="company-none"
                                        @else class="xuanzhe" @endif>
                                        {{$v}}
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
            @if(count($shaixuan['sccj'])>0&&empty($product))
                @foreach(range('A','Z') as $k=>$v)

                    @if(isset($shaixuan['sccj'][$v])&&count($shaixuan['sccj'][$v])>0)
                        <div class="shaixuan-company-box" id="zm{{$v}}">
                            @foreach($shaixuan['sccj'][$v] as $product)
                                <a href="{{$result->url(1)}}&product={{$product}}">
                                    {{$product}}
                                </a>
                            @endforeach
                        </div>
                    @endif
                @endforeach
            @endif
            <div class="content">
                @if(count($result)==0)
                    <div id="none" class="container">
                        <div class="container_box">
                            <div class="none">
                                <div class="img_box">
                                    <img src="{{get_img_path('images/goods/puyao_search_none.png')}}"/>
                                </div>
                                <div class="text">
                                    <p>抱歉！没有找到@if(!empty($keywords))与“<span>{{$keywords}}</span>”@endif相关的药品</p>
                                    <p>你可以发布求购意向，{{config('services.web.name')}}网会尽快补货！</p>
                                    <a target="_blank" href="/requirement" class="link">发布求购</a>
                                </div>
                            </div>
                            @if(isset($cx_goods[6]))
                                <div id="wntj" class="container">
                                    <div class="container_box">
                                        <div id="ban3" class="ban">
                                            <div class="section_title">
                                                <i class="myicon wntj_icon"></i>
                                                <span class="biaoti">为您推荐</span>
                                            </div>
                                            <div class="banner">
                                                <ul class="img">
                                                    @if(count($cx_goods[6])>0)
                                                        <li>
                                                            @foreach($cx_goods[6] as $k=>$v)
                                                                @if($k<5)
                                                                    <a target="_blank"
                                                                       href="{{route('goods.index',['id'=>$v->goods_id])}}">
                                                                        <div class="wntj-cp">
                                                                            <div class="img_box">
                                                                                <img src="{{$v->goods_thumb}}"/>
                                                                            </div>
                                                                            <p class="name">{{$v->goods_name}}</p>
                                                                            <p class="gg">{{$v->ypgg}}</p>
                                                                            <p class="money login">{{$v->format_price}}</p>
                                                                        </div>
                                                                    </a>
                                                                @endif
                                                            @endforeach
                                                        </li>
                                                    @endif
                                                    @if(count($cx_goods[6])>5)
                                                        <li>
                                                            @foreach($cx_goods[6] as $k=>$v)
                                                                @if($k>=5&$k<10)
                                                                    <a target="_blank"
                                                                       href="{{route('goods.index',['id'=>$v->goods_id])}}">
                                                                        <div class="wntj-cp">
                                                                            <div class="img_box">
                                                                                <img src="{{$v->goods_thumb}}"/>
                                                                            </div>
                                                                            <p class="name">{{$v->goods_name}}</p>
                                                                            <p class="gg">{{$v->ypgg}}</p>
                                                                            <p class="money login">{{$v->format_price}}</p>
                                                                        </div>
                                                                    </a>
                                                                @endif
                                                            @endforeach
                                                        </li>
                                                    @endif
                                                </ul>
                                                <div class="btn btn_l">
                                                    <i class="myicon lb_left_icon"></i>
                                                </div>
                                                <div class="btn btn_r">
                                                    <i class="myicon lb_right_icon"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @else
                    <div id="puyao_sx" class="container">
                        <div class="container_box">
                            <div class="puyao_title">
                                <ul class="puyao_title_list">
                                    @if(!isset($sort)||(isset($sort)&&$sort=='sort_order')&&(!isset($step)||(isset($step)&&empty($step))))
                                        <li class="active">
                                            默认排序
                                        </li>
                                    @else
                                        <li>
                                            <a {!! $result->sort['sort_order'] !!}>
                                                默认排序
                                            </a>
                                        </li>
                                    @endif
                                    <li @if(isset($sort)&&$sort=='click_count') class="active" @endif>
                                        <a {!! $result->sort['click_count'] !!}>
                                            人气<span class="a-z">由低到高</span><span class="z-a">由高到低</span>
                                        </a>
                                    </li>
                                    <li @if(isset($sort)&&$sort=='sales_volume') class="active" @endif>
                                        <a {!! $result->sort['sales_volume'] !!}>
                                            销量<span class="a-z">由低到高</span><span class="z-a">由高到低</span>
                                        </a>
                                    </li>
                                    <li @if(isset($sort)&&$sort=='shop_price') class="active" @endif>
                                        <a {!! $result->sort['shop_price'] !!}>
                                            价格<span class="a-z">由低到高</span><span class="z-a">由高到低</span>
                                        </a>
                                    </li>
                                    <li @if(isset($sort)&&$sort=='goods_name') class="active" @endif>
                                        <a {!! $result->sort['goods_name'] !!}>
                                            品名
                                        </a>
                                    </li>
                                    <li @if(isset($sort)&&$sort=='product_name') class="active" @endif>
                                        <a {!! $result->sort['product_name'] !!}>
                                            厂家
                                        </a>
                                    </li>
                                    <li>
                                    </li>
                                </ul>
                                <div class="puyao_title_right">
                                    <span>共<span class="red">{{$result->total()}}</span>个商品 每页显示{{$result->perPage()}}
                                        个商品</span>
                                    @if($result->currentPage()==1)
                                        <input type="image" src="{{get_img_path('images/goods/puyao_left.jpg')}}"
                                               class="prev"/>
                                    @else
                                        <a href="{{$result->url($result->currentPage() - 1)}}">
                                            <input type="image" src="{{get_img_path('images/goods/puyao_left_1.jpg')}}"
                                                   class="prev"/>
                                        </a>
                                    @endif
                                    <span class="nu"><span
                                                class="red">{{$result->currentPage()}}</span> / {{$result->lastPage()}}</span>
                                    @if($result->currentPage()==$result->lastPage())
                                        <input type="image" src="{{get_img_path('images/goods/puyao_right_1.jpg')}}"
                                               class="next"/>
                                    @else
                                        <a href="{{$result->url($result->currentPage() + 1)}}">
                                            <input type="image" src="{{get_img_path('images/goods/puyao_right.jpg')}}"
                                                   class="next"/>
                                        </a>
                                    @endif
                                    @if($style=='l')
                                        <span class="liebiao_icon">
							            <img title="列表" src="{{get_img_path('images/goods/puyao_liebiao.jpg')}}"/>
						            </span>
                                        <a href="{{$result->url(1)}}&step={{$step or ''}}&style=g"><span
                                                    class="datu_icon">
							            <img title="大图" src="{{get_img_path('images/goods/puyao_datu.jpg')}}"/>
						            </span></a>
                                    @else
                                        <a href="{{$result->url(1)}}&step={{$step or ''}}&style=l"><span
                                                    class="liebiao_icon">
							            <img title="列表" src="{{get_img_path('images/goods/puyao_liebiao_1.jpg')}}"/>
                                            </span></a>
                                        <span class="datu_icon">
							            <img title="大图" src="{{get_img_path('images/goods/puyao_datu_1.jpg')}}"/>
						            </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($style=='l')
                        <div id="liebiao" class="container">
                            <div class="container_box">
                                <table>
                                    <tr>
                                        <th class="cxbs">促销标识</th>
                                        <th class="cpmc">产品名称</th>
                                        <th class="gg">规格</th>
                                        <th class="dw">单位</th>
                                        <th class="sccj">生产厂家</th>
                                        <th class="xq">效期</th>
                                        <th class="jzl">件装量</th>
                                        <th class="zbz">中包装</th>
                                        <th class="sl">数量</th>
                                        <th class="kc">库存</th>
                                        <th class="hyj">会员价</th>
                                        <th class="cz">操作</th>
                                    </tr>
                                    @foreach($result as $v)
                                        <tr>
                                            <td class="cxbs">
                                                        <span class="tj_bs layer_tips" id="1lb_tj{{$v->goods_id}}"
                                                              data-msg="{{trans('goods.tmpz')}}">特卖<i
                                                                    class="jiantou xia_i"></i></span>
                                                @if($v->is_xqpz==1)
                                                    <span class="tj_bs layer_tips" id="1lb_xq{{$v->goods_id}}"
                                                          data-msg="此品种为效期品种">效期<i
                                                                class="jiantou xia_i"></i></span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="cpmc">
                                                    <a target="_blank" href="{{$v->goods_url}}"
                                                       title="{{$v->goods_name}}">{{str_limit($v->goods_name,20)}}</a>
                                                    <div class="goods_hover_box">
                                                        <a target="_blank" href="{{$v->goods_url}}">
                                                            <p class="name">{{$v->goods_name}}</p>
                                                        </a>
                                                        <div class="img_box">
                                                            <a target="_blank" href="{{$v->goods_url}}">
                                                                <img class="lazy_show"
                                                                     data-original="{{$v->goods_thumb}}"/>
                                                            </a>
                                                        </div>
                                                        <p class="xiaoqi">效期：{{$v->xq}}</p>
                                                        {{--<p class="xiaoliang">总销量：<span>{{$v->sales_volume}}</span></p>--}}
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="gg">{{$v->spgg}}</p>
                                            </td>
                                            <td>
                                                <p class="dw">{{$v->dw}}</p>
                                            </td>
                                            <td>
                                                <p class="sccj">{{$v->sccj}}</p>
                                            </td>
                                            <td>
                                                <p class="xq"
                                                   @if($v->is_xq_red==1) style="color: #e70000" @endif>{{$v->xq}}</p>
                                            </td>
                                            <td>
                                                <p class="jzl">@if($v->is_zyyp==0){{$v->jzl}}@endif</p>
                                            </td>
                                            <td>
                                                <p class="zbz">{{$v->zbz}}</p>
                                            </td>
                                            <td class="sl">
                                                <span class="jian min">-</span><input
                                                        id="J_dgoods_num1_{{$v->goods_id}}"
                                                        type="text"
                                                        value="{{$v->zbz}}"
                                                        class="input_val"
                                                        data-zbz="{{$v->zbz}}"
                                                        data-kc="{{$v->goods_number}}"
                                                        data-jzl="{{$v->jzl}}"
                                                        data-xl="{{$v->xg_num}}"
                                                        data-isxl="{{$v->is_xg}}"/><span
                                                        class="jia">+</span>
                                            </td>
                                            <td>
                                                <p class="kc">@if($v->goods_number>=800)充裕@elseif($v->goods_number==0)
                                                        缺货@else{{$v->goods_number}}@endif</p>
                                            </td>
                                            <td>
                                                <p class="hyj">@if($v->is_can_see==0) 会员可见 @else
                                                        {{formated_price($v->real_price)}}
                                                    @endif</p>
                                            </td>
                                            <td>
                                                <p class="cz">
                                                    <img title="加入购物车"
                                                         src="{{get_img_path('images/goods/jrgwc_btn.png')}}"
                                                         data-img="{{$v->goods_thumb}}"
                                                         class="jrgwc_btn fly_to_cart{{$v->goods_id}}"
                                                         onclick="tocart('{{$v->goods_id}}',1)"/>
                                                    <img title="加入收藏夹" src="{{get_img_path('images/goods/sc_btn.png')}}"
                                                         class="sc_btn" onclick="tocollect('{{$v->goods_id}}')"/>
                                                </p>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                                @if($result->hasPages())
                                    {!! $pages_view !!}
                                @endif
                            </div>
                        </div>
                    @else
                        <div id="datu" class="container">
                            <div class="container_box">
                                <ul class="datu">
                                    @foreach($result as $k=>$v)
                                        <li>
                                            <div class="datu-chanpin-img">
                                                <a target="_blank" href="{{$v->goods_url}}">
                                                    @if($k<5)
                                                        <img src="{{$v->goods_thumb}}"/>
                                                    @else
                                                        <img class="lazy" data-original="{{$v->goods_thumb}}"/>
                                                    @endif
                                                </a>
                                                <img title="加入收藏夹" onclick="tocollect('{{$v->goods_id}}')"
                                                     src="{{get_img_path('images/goods/datu-shoucang.png')}}"
                                                     class="datu-shoucang"/>
                                                <div class="datu_bs">
                                                    <div class="tj layer_tips" id="1dt_tj{{$v->goods_id}}"
                                                         data-msg="{{trans('goods.tmpz')}}">
                                                        特卖<i class="jiantou xia_i"></i>
                                                    </div>
                                                    @if($v->is_xqpz==1)
                                                        <div class="tj layer_tips" id="1dt_xq{{$v->goods_id}}"
                                                             data-msg="此品种为效期品种">
                                                            效期<i class="jiantou xia_i"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            @if($v->is_can_see==0)
                                                <div class="datu-jiage-none">
                                                    会员可见
                                                </div>
                                            @else
                                                <div class="datu-jiage">
                                                    {{formated_price($v->real_price)}}
                                                </div>
                                            @endif
                                            <div class="datu-mingzi">
                                                {{$v->goods_name}}
                                            </div>
                                            <div class="datu-compamy">
                                                {{$v->sccj}}
                                            </div>
                                            <div class="datu-guige">
                                                规格：<span>{{$v->spgg}}</span>
                                            </div>
                                            <div class="datu-xiaoqi">
                                                效期：<span
                                                        @if($v->is_xq_red==1) class="daoqi" @endif>{{$v->xq}}</span>
                                                @if($v->is_zyyp==0)
                                                    件装量：
                                                    <span class="jianzhuang">{{$v->jzl}}</span>
                                                @endif
                                            </div>
                                            <div class="datu-jianzhuang">
                                                库存：<span>@if($v->goods_number>=800)充裕@elseif($v->goods_number==0)
                                                        缺货@else{{$v->goods_number}}@endif</span> 中包装：
                                                <span>{{$v->zbz}}</span>
                                            </div>
                                            <div class="btn_box">
                                                <div class="datu-jrgwc fly_to_cart{{$v->goods_id}}"
                                                     data-img="{{$v->goods_thumb}}"
                                                     onclick="tocart('{{$v->goods_id}}',1)">
                                                    <img src="{{get_img_path('images/goods/datu_jrgwc.png')}}"/> 加入购物车
                                                </div>
                                                <div class="jiajian">
                                                    <div class="jian min">
                                                        -
                                                    </div>
                                                    <input id="J_dgoods_num1_{{$v->goods_id}}"
                                                           type="text"
                                                           value="{{$v->zbz}}" class="input_val"
                                                           data-zbz="{{$v->zbz}}"
                                                           data-kc="{{$v->goods_number}}"
                                                           data-jzl="{{$v->jzl}}" data-xl="{{$v->xg_num}}"
                                                           data-isxl="{{$v->is_xg}}"/>
                                                    <div class="jia">
                                                        +
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                                @if($result->hasPages())
                                    {!! $pages_view !!}
                                @endif
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        </div>
        <div class="clear_both"></div>
    </div>
    @include('layouts.old_footer')
    <script type="text/javascript">
        $('.cpmc').hover(function () {
            $(this).find('.lazy_show').attr('src', $(this).find('.lazy_show').data('original'))
        });
        $("img.lazy").lazyload({
            effect: "fadeIn",
            threshold: 300,
            placeholder: "http://app.hezongyy.com/images/small.gif"
        });
        $('.layer_tips').hover(function () {
            var msg = $(this).data('msg');
            var id = $(this).attr('id');
            layer.tips(msg, '#' + id, {
                tips: [3, '#fff'],
                id: 'layer_tips'
            });
        }, function () {
            layer.closeAll();
        });

        function last_page(url, lastPage) {
            var currentPage = $('#currentPage').val();
            if (parseInt(currentPage) > parseInt(lastPage)) {
                alert('你要访问的页码不存在!');
                $('#currentPage').val(lastPage);
                return false;
            }
        }
    </script>
@endsection
