<script type="text/javascript" src="{{path('new/js/common.js')}}"></script>
<div id="nav">
    <div class="nav-box">
        <ul>
            <li class="fenlei">
                <a href="#" style="font-size:16px">
                    <img src="{{path('new/images/fenlei.jpg')}}"/>
                    全部商品分类
                </a>

            </li>
            @if($middle_nav)
                @foreach($middle_nav as $k=>$v)
                    <li class="li2"><a
                                @if(isset($dh_check)&&$v->id==$dh_check)
                                class="checked"
                                @endif href="{{$v->url}}" @if($v->opennew==1)target="_blank" @endif >{{$v->name}}</a>
                    </li>
                @endforeach
            @endif
            <li style="float: right">
                <!--<img src="images/dianhua.gif"/>-->
                <img style="vertical-align: baseline;" src="{{path('new/images/dianhua.gif')}}"/>
            </li>
        </ul>
    </div>
    <div class="site-content container">
        <div class="category-menu fn_clear" style="margin-top: -13px;">
            <ul class="category-list">
                <li class="child-li jiyao li1">
                    <p>
                        <img src="{{path('new/images/left01.png')}}" class="leftimg"/>
                        <img src="{{path('new/images/left01_1.png')}}" class="leftimg-1"/>
                        <a href="{{route('category.index',['dis'=>'b'])}}">
											<span class="title_text">
												呼吸系统用药
											</span>
                        </a>
                        <img src="{{path('new/images/jiantou-right.png')}}" class="img-jiantou"/>
                    </p>
                </li>
                <li class="child-li li2">
                    <p>
                        <img src="{{path('new/images/left02.png')}}" class="leftimg"/>
                        <img src="{{path('new/images/left02_1.png')}}" class="leftimg-1"/>
                        <a href="{{route('category.index',['dis'=>'c'])}}">
											<span class="title_text">
												清热、消炎
											</span>
                        </a>
                        <img src="{{path('new/images/jiantou-right.png')}}" class="img-jiantou"/>

                    </p>
                </li>
                <li class="child-li jiyao li3">
                    <p><img src="{{path('new/images/left03.png')}}" class="leftimg"/>
                        <img src="{{path('new/images/left03_1.png')}}" class="leftimg-1"/>
                        <a href="{{route('category.index',['dis'=>'d'])}}"><span class="title_text">五官、皮肤及外用</span></a>
                        <img src="{{path('new/images/jiantou-right.png')}}" class="img-jiantou"/></p>
                </li>
                <li class="child-li li4">
                    <p><img src="{{path('new/images/left04.png')}}" class="leftimg"/>
                        <img src="{{path('new/images/left04_1.png')}}" class="leftimg-1"/>
                        <a href="{{route('category.index',['dis'=>'e'])}}"><span class="title_text">消化、肝胆系统</span></a>
                        <img src="{{path('new/images/jiantou-right.png')}}" class="img-jiantou"/></p>
                </li>
                <li class="child-li li5">
                    <p><img src="{{path('new/images/left05.png')}}" class="leftimg"/>
                        <img src="{{path('new/images/left05_1.png')}}" class="leftimg-1"/>
                        <a href="{{route('category.index',['dis'=>'f'])}}"><span class="title_text">补益安神及维矿类</span></a>
                        <img src="{{path('new/images/jiantou-right.png')}}" class="img-jiantou"/></p>
                </li>
                <li class="child-li li6">
                    <p><img src="{{path('new/images/left06.png')}}" class="leftimg"/>
                        <img src="{{path('new/images/left06_1.png')}}" class="leftimg-1"/>
                        <a href="{{route('category.index',['dis'=>'g'])}}"><span class="title_text">妇、儿科</span></a>
                        <img src="{{path('new/images/jiantou-right.png')}}" class="img-jiantou"/>
                    </p>
                </li>
                <li class="child-li li7">
                    <p><img src="{{path('new/images/left07.png')}}" class="leftimg"/>
                        <img src="{{path('new/images/left07_1.png')}}" class="leftimg-1"/>
                        <a href="{{route('category.index',['dis'=>'h'])}}"><span
                                    class="title_text">心脑血管及神经类用药</span></a>
                        <img src="{{path('new/images/jiantou-right.png')}}" class="img-jiantou"/>
                    </p>
                </li>
                <li class="child-li li8">
                    <p><img src="{{path('new/images/left08.png')}}" class="leftimg"/>
                        <img src="{{path('new/images/left08_1.png')}}" class="leftimg-1"/>
                        <a href="{{route('category.index',['dis'=>'i'])}}"><span
                                    class="title_text">内分泌系统(含糖尿病)</span></a>
                        <img src="{{path('new/images/jiantou-right.png')}}" class="img-jiantou"/>
                    </p>
                </li>
                <li class="child-li li9">
                    <p><img src="{{path('new/images/left09.png')}}" class="leftimg"/>
                        <img src="{{path('new/images/left09_1.png')}}" class="leftimg-1"/>
                        <a href="{{route('category.index',['dis'=>'j'])}}"><span class="title_text">风湿骨伤及其它药品</span></a>
                        <img src="{{path('new/images/jiantou-right.png')}}" class="img-jiantou"/>
                    </p>
                </li>
                <li class="child-li li10">
                    <p><img src="{{path('new/images/left10.png')}}" class="leftimg"/>
                        <img src="{{path('new/images/left10_1.png')}}" class="leftimg-1"/>
                        <a href="{{route('category.index',['dis'=>'k'])}}"><span
                                    class="title_text">特殊复方制剂、生物制品</span></a>
                        <img src="{{path('new/images/jiantou-right.png')}}" class="img-jiantou"/>
                    </p>
                </li>
                <li class="child-li li11">
                    <p><img src="{{path('new/images/left11.png')}}" class="leftimg"/>
                        <img src="{{path('new/images/left11_1.png')}}" class="leftimg-1"/>
                        <a href="/zy"><span class="title_text">中药饮片</span></a>
                        <img src="{{path('new/images/jiantou-right.png')}}" class="img-jiantou"/>
                    </p>
                </li>
                <li class="child-li li12">
                    <p><img src="{{path('new/images/left12.png')}}" class="leftimg"/>
                        <img src="{{path('new/images/left12_1.png')}}" class="leftimg-1"/>
                        <a href="{{route('category.index',['dis'=>'m'])}}"><span class="title_text">非药品</span></a>
                        <img src="{{path('new/images/jiantou-right.png')}}" class="img-jiantou"/>
                    </p>
                </li>
            </ul>

            <ul class="category-list-child fn_clear" style="padding-bottom: 30px">
                <li style="display: none;" class="jiyao fn_clear right-box-1">
                    @foreach($cate_tree->where('cat_id','490')->first()->cate as $k=>$cat1)
                        @if($k==0)
                            <p>{{$cate_tree->where('cat_id','490')->first()->cat_name}}</p>
                        @endif
                        <div @if($k==0) class="xiyao-box" @else class="zhongyao-box" @endif>
                            <div @if($k==0) class="xiyao" @else class="zhongchengyao" @endif>{{$cat1->cat_name}}</div>
                            <div class="fn_clear content-xiyao">
                                @foreach($cat1->cate as $cat2)
                                    <a href="{{route('category.index',['phaid'=>$cat2->cat_id])}}" target="_blank"
                                       title="{{$cat2->cat_name}}">{{$cat2->cat_name}}</a>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </li>
                <li class="jiyao fn_clear right-box-2">
                    @foreach($cate_tree->where('cat_id','496')->first()->cate as $k=>$cat1)
                        @if($k==0)
                            <p>{{$cate_tree->where('cat_id','496')->first()->cat_name}}</p>
                        @endif
                        <div @if($k==0) class="xiyao-box" @else class="zhongyao-box" @endif>
                            <div @if($k==0) class="moretxt" @else class="moretxt" @endif>{{$cat1->cat_name}}</div>
                            <div class="fn_clear content-xiyao">
                                @foreach($cat1->cate as $cat2)
                                    <a href="{{route('category.index',['phaid'=>$cat2->cat_id])}}" target="_blank"
                                       title="{{$cat2->cat_name}}">{{$cat2->cat_name}}</a>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </li>
                <li class="jiyao fn_clear right-box-3">
                    @foreach($cate_tree->where('cat_id','531')->first()->cate as $k=>$cat1)
                        @if($k==0)
                            <p>{{$cate_tree->where('cat_id','531')->first()->cat_name}}</p>
                        @endif
                        <div @if($k==0) class="xiyao-box" @else class="zhongyao-box" @endif>
                            <div @if($k==0) class="xiyao" @else class="zhongchengyao" @endif>{{$cat1->cat_name}}</div>
                            <div class="fn_clear content-xiyao">
                                @foreach($cat1->cate as $cat2)
                                    <a href="{{route('category.index',['phaid'=>$cat2->cat_id])}}" target="_blank"
                                       title="{{$cat2->cat_name}}">{{$cat2->cat_name}}</a>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                    @foreach($cate_tree->where('cat_id','548')->first()->cate as $k=>$cat1)
                        @if($k==0)
                            <p>{{$cate_tree->where('cat_id','548')->first()->cat_name}}</p>
                        @endif
                        <div @if($k==0) class="xiyao-box" @else class="zhongyao-box" @endif>
                            <div @if($k==0) class="xiyao" @else class="zhongchengyao" @endif>{{$cat1->cat_name}}</div>
                            <div class="fn_clear content-xiyao">
                                @foreach($cat1->cate as $cat2)
                                    <a href="{{route('category.index',['phaid'=>$cat2->cat_id])}}" target="_blank"
                                       title="{{$cat2->cat_name}}">{{$cat2->cat_name}}</a>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </li>
                <li class="fn_clear right-box-4">
                    @foreach($cate_tree->where('cat_id','575')->first()->cate as $k=>$cat1)
                        @if($k==0)
                            <p>{{$cate_tree->where('cat_id','575')->first()->cat_name}}</p>
                        @endif
                        <div @if($k==0) class="xiyao-box" @else class="zhongyao-box" @endif>
                            <div @if($k==0) class="xiyao" @else class="zhongchengyao" @endif>{{$cat1->cat_name}}</div>
                            <div class="fn_clear content-xiyao">
                                @foreach($cat1->cate as $cat2)
                                    <a href="{{route('category.index',['phaid'=>$cat2->cat_id])}}" target="_blank"
                                       title="{{$cat2->cat_name}}">{{$cat2->cat_name}}</a>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </li>
                <li class="fn_clear right-box-5">
                    @foreach($cate_tree->where('cat_id','620')->first()->cate as $k=>$cat1)
                        @if($k==0)
                            <p>{{$cate_tree->where('cat_id','620')->first()->cat_name}}</p>
                        @endif
                        <div @if($k==0) class="xiyao-box" @else class="zhongyao-box" @endif>
                            <div @if($k==0) class="xiyao" @else class="zhongchengyao" @endif>{{$cat1->cat_name}}</div>
                            <div class="fn_clear content-xiyao">
                                @foreach($cat1->cate as $cat2)
                                    <a href="{{route('category.index',['phaid'=>$cat2->cat_id])}}" target="_blank"
                                       title="{{$cat2->cat_name}}">{{$cat2->cat_name}}</a>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </li>
                <li class="fn_clear right-box-6">
                    @foreach($cate_tree->where('cat_id','536')->first()->cate as $k=>$cat1)
                        @if($k==0)
                            <p>{{$cate_tree->where('cat_id','536')->first()->cat_name}}</p>
                        @endif
                        <div @if($k==0) class="xiyao-box" @else class="zhongyao-box" @endif>
                            <div @if($k==0) class="xiyao" @else class="zhongchengyao" @endif>{{$cat1->cat_name}}</div>
                            <div class="fn_clear content-xiyao">
                                @foreach($cat1->cate as $cat2)
                                    <a href="{{route('category.index',['phaid'=>$cat2->cat_id])}}" target="_blank"
                                       title="{{$cat2->cat_name}}">{{$cat2->cat_name}}</a>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                    @foreach($cate_tree->where('cat_id','584')->first()->cate as $k=>$cat1)
                        @if($k==0)
                            <p>{{$cate_tree->where('cat_id','584')->first()->cat_name}}</p>
                        @endif
                        <div @if($k==0) class="xiyao-box" @else class="zhongyao-box" @endif>
                            <div @if($k==0) class="xiyao" @else class="zhongchengyao" @endif>{{$cat1->cat_name}}</div>
                            <div class="fn_clear content-xiyao">
                                @foreach($cat1->cate as $cat2)
                                    <a href="{{route('category.index',['phaid'=>$cat2->cat_id])}}" target="_blank"
                                       title="{{$cat2->cat_name}}">{{$cat2->cat_name}}</a>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </li>
                <li class="fn_clear right-box-7">
                    @foreach($cate_tree->where('cat_id','619')->first()->cate as $k=>$cat1)
                        @if($k==0)
                            <p>{{$cate_tree->where('cat_id','619')->first()->cat_name}}</p>
                        @endif
                        <div @if($k==0) class="xiyao-box" @else class="zhongyao-box" @endif>
                            <div @if($k==0) class="xiyao" @else class="zhongchengyao" @endif>{{$cat1->cat_name}}</div>
                            <div class="fn_clear content-xiyao">
                                @foreach($cat1->cate as $cat2)
                                    <a href="{{route('category.index',['phaid'=>$cat2->cat_id])}}" target="_blank"
                                       title="{{$cat2->cat_name}}">{{$cat2->cat_name}}</a>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                    @foreach($cate_tree->where('cat_id','767')->first()->cate as $k=>$cat1)
                        @if($k==0)
                            <p>{{$cate_tree->where('cat_id','767')->first()->cat_name}}</p>
                        @endif
                        <div @if($k==0) class="xiyao-box" @else class="zhongyao-box" @endif>
                            <div @if($k==0) class="xiyao" @else class="zhongchengyao" @endif>{{$cat1->cat_name}}</div>
                            <div class="fn_clear content-xiyao">
                                @foreach($cat1->cate as $cat2)
                                    <a href="{{route('category.index',['phaid'=>$cat2->cat_id])}}" target="_blank"
                                       title="{{$cat2->cat_name}}">{{$cat2->cat_name}}</a>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </li>
                <li style="" class="jiyao fn_clear right-box-8">
                    @foreach($cate_tree->where('cat_id','788')->first()->cate as $k=>$cat1)
                        @if($k==0)
                            <p>{{$cate_tree->where('cat_id','788')->first()->cat_name}}</p>
                        @endif
                        <div @if($k==0) class="xiyao-box" @else class="zhongyao-box" @endif>
                            <div @if($k==0) class="xiyao" @else class="zhongchengyao" @endif>{{$cat1->cat_name}}</div>
                            <div class="fn_clear content-xiyao">
                                @foreach($cat1->cate as $cat2)
                                    <a href="{{route('category.index',['phaid'=>$cat2->cat_id])}}" target="_blank"
                                       title="{{$cat2->cat_name}}">{{$cat2->cat_name}}</a>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                    @foreach($cate_tree->where('cat_id','778')->first()->cate as $k=>$cat1)
                        @if($k==0)
                            <p>{{$cate_tree->where('cat_id','778')->first()->cat_name}}</p>
                        @endif
                        <div @if($k==0) class="xiyao-box" @else class="zhongyao-box" @endif>
                            <div @if($k==0) class="xiyao" @else class="zhongchengyao" @endif>{{$cat1->cat_name}}</div>
                            <div class="fn_clear content-xiyao">
                                @foreach($cat1->cate as $cat2)
                                    <a href="{{route('category.index',['phaid'=>$cat2->cat_id])}}" target="_blank"
                                       title="{{$cat2->cat_name}}">{{$cat2->cat_name}}</a>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                    @foreach($cate_tree->where('cat_id','796')->first()->cate as $k=>$cat1)
                        @if($k==0)
                            <p>{{$cate_tree->where('cat_id','796')->first()->cat_name}}</p>
                        @endif
                        <div @if($k==0) class="xiyao-box" @else class="zhongyao-box" @endif>
                            <div @if($k==0) class="xiyao" @else class="zhongchengyao" @endif>{{$cat1->cat_name}}</div>
                            <div class="fn_clear content-xiyao">
                                @foreach($cat1->cate as $cat2)
                                    <a href="{{route('category.index',['phaid'=>$cat2->cat_id])}}" target="_blank"
                                       title="{{$cat2->cat_name}}">{{$cat2->cat_name}}</a>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </li>
                <li style="display: none;" class="jiyao fn_clear right-box-9">
                    @foreach($cate_tree->where('cat_id','801')->first()->cate as $k=>$cat1)
                        @if($k==0)
                            <p>{{$cate_tree->where('cat_id','801')->first()->cat_name}}</p>
                        @endif
                        <div @if($k==0) class="xiyao-box" @else class="zhongyao-box" @endif>
                            <div @if($k==0) class="xiyao" @else class="zhongchengyao" @endif>{{$cat1->cat_name}}</div>
                            <div class="fn_clear content-xiyao">
                                @foreach($cat1->cate as $cat2)
                                    <a href="{{route('category.index',['phaid'=>$cat2->cat_id])}}" target="_blank"
                                       title="{{$cat2->cat_name}}">{{$cat2->cat_name}}</a>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                    @foreach($cate_tree->where('cat_id','655')->first()->cate as $k=>$cat1)
                        @if($k==0)
                            <p>{{$cate_tree->where('cat_id','655')->first()->cat_name}}</p>
                        @endif
                        <div @if($k==0) class="xiyao-box" @else class="zhongyao-box" @endif>
                            <div @if($k==0) class="xiyao" @else class="zhongchengyao" @endif>{{$cat1->cat_name}}</div>
                            <div class="fn_clear content-xiyao">
                                @foreach($cat1->cate as $cat2)
                                    <a href="{{route('category.index',['phaid'=>$cat2->cat_id])}}" target="_blank"
                                       title="{{$cat2->cat_name}}">{{$cat2->cat_name}}</a>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                    @foreach($cate_tree->where('cat_id','665')->first()->cate as $k=>$cat1)
                        @if($k==0)
                            <p>{{$cate_tree->where('cat_id','665')->first()->cat_name}}</p>
                        @endif
                        <div @if($k==0) class="xiyao-box" @else class="zhongyao-box" @endif>
                            <div @if($k==0) class="xiyao" @else class="zhongchengyao" @endif>{{$cat1->cat_name}}</div>
                            <div class="fn_clear content-xiyao">
                                @foreach($cat1->cate as $cat2)
                                    <a href="{{route('category.index',['phaid'=>$cat2->cat_id])}}" target="_blank"
                                       title="{{$cat2->cat_name}}">{{$cat2->cat_name}}</a>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </li>
                <li style="display: none;" class="jiyao fn_clear right-box-10">
                    @foreach($cate_tree->where('cat_id','674')->first()->cate as $k=>$cat1)
                        @if($k==0)
                            <p>{{$cate_tree->where('cat_id','674')->first()->cat_name}}</p>
                        @endif
                        <div @if($k==0) class="xiyao-box" @else class="zhongyao-box" @endif>
                            <div @if($k==0) class="xiyao" @else class="zhongchengyao" @endif>{{$cat1->cat_name}}</div>
                            <div class="fn_clear content-xiyao">
                                @foreach($cat1->cate as $cat2)
                                    <a href="{{route('category.index',['phaid'=>$cat2->cat_id])}}" target="_blank"
                                       title="{{$cat2->cat_name}}">{{$cat2->cat_name}}</a>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                    <p>{{$cate_tree->where('cat_id','682')->first()->cat_name}}</p>
                    <div class="xiyao-box">
                        <div class="Notitle"></div>
                        <div class="fn_clear content-xiyao">
                            @foreach($cate_tree->where('cat_id','682')->first()->cate as $cat2)
                                <a href="{{route('category.index',['phaid'=>$cat2->cat_id])}}" target="_blank"
                                   title="{{$cat2->cat_name}}">{{$cat2->cat_name}}</a>
                            @endforeach
                        </div>
                    </div>
                </li>
                <li style="display: none;" class="jiyao fn_clear right-box-11">
                    <p>{{$cate_tree->where('cat_id','445')->first()->cat_name}}</p>
                    <div class="xiyao-box">
                        <div class="Notitle"></div>
                        <div class="fn_clear content-xiyao">
                            @foreach($cate_tree->where('cat_id','445')->first()->cate as $cat2)
                                <a href="{{route('category.index',['phaid'=>$cat2->cat_id])}}" target="_blank"
                                   title="{{$cat2->cat_name}}">{{$cat2->cat_name}}</a>
                            @endforeach
                        </div>
                    </div>
                </li>
                <li style="display: none;" class="jiyao fn_clear right-box-12">
                    <p>{{$cate_tree->where('cat_id','683')->first()->cat_name}}</p>
                    <div class="xiyao-box">
                        <div class="Notitle"></div>
                        <div class="fn_clear content-xiyao">
                            @foreach($cate_tree->where('cat_id','683')->first()->cate as $cat2)
                                <a href="{{route('category.index',['phaid'=>$cat2->cat_id])}}" target="_blank"
                                   title="{{$cat2->cat_name}}">{{$cat2->cat_name}}</a>
                            @endforeach
                        </div>
                    </div>
                    <p>{{$cate_tree->where('cat_id','12')->first()->cat_name}}</p>
                    <div class="xiyao-box">
                        <div class="Notitle"></div>
                        <div class="fn_clear content-xiyao">
                            @foreach($cate_tree->where('cat_id','12')->first()->cate as $cat2)
                                <a href="{{route('category.index',['phaid'=>$cat2->cat_id])}}" target="_blank"
                                   title="{{$cat2->cat_name}}">{{$cat2->cat_name}}</a>
                            @endforeach
                        </div>
                    </div>
                    <p>{{$cate_tree->where('cat_id','732')->first()->cat_name}}</p>
                    <div class="xiyao-box">
                        <div class="Notitle"></div>
                        <div class="fn_clear content-xiyao">
                            @foreach($cate_tree->where('cat_id','732')->first()->cate as $cat2)
                                <a href="{{route('category.index',['phaid'=>$cat2->cat_id])}}" target="_blank"
                                   title="{{$cat2->cat_name}}">{{$cat2->cat_name}}</a>
                            @endforeach
                        </div>
                    </div>
                    <p>{{$cate_tree->where('cat_id','739')->first()->cat_name}}</p>
                    <div class="xiyao-box">
                        <div class="Notitle"></div>
                        <div class="fn_clear content-xiyao">
                            @foreach($cate_tree->where('cat_id','739')->first()->cate as $cat2)
                                <a href="{{route('category.index',['phaid'=>$cat2->cat_id])}}" target="_blank"
                                   title="{{$cat2->cat_name}}">{{$cat2->cat_name}}</a>
                            @endforeach
                        </div>
                    </div>
                    <p>{{$cate_tree->where('cat_id','751')->first()->cat_name}}</p>
                    <div class="xiyao-box">
                        <div class="Notitle"></div>
                        <div class="fn_clear content-xiyao">
                            @foreach($cate_tree->where('cat_id','751')->first()->cate as $cat2)
                                <a href="{{route('category.index',['phaid'=>$cat2->cat_id])}}" target="_blank"
                                   title="{{$cat2->cat_name}}">{{$cat2->cat_name}}</a>
                            @endforeach
                        </div>
                    </div>
                    <p>{{$cate_tree->where('cat_id','899')->first()->cat_name}}</p>
                    <div class="xiyao-box">
                        <div class="Notitle"></div>
                        <div class="fn_clear content-xiyao">
                            @foreach($cate_tree->where('cat_id','899')->first()->cate as $cat2)
                                <a href="{{route('category.index',['phaid'=>$cat2->cat_id])}}" target="_blank"
                                   title="{{$cat2->cat_name}}">{{$cat2->cat_name}}</a>
                            @endforeach
                        </div>
                    </div>
                    <p>{{$cate_tree->where('cat_id','922')->first()->cat_name}}</p>
                    <div class="xiyao-box">
                        <div class="Notitle"></div>
                        <div class="fn_clear content-xiyao">
                            @foreach($cate_tree->where('cat_id','922')->first()->cate as $cat2)
                                <a href="{{route('category.index',['phaid'=>$cat2->cat_id])}}" target="_blank"
                                   title="{{$cat2->cat_name}}">{{$cat2->cat_name}}</a>
                            @endforeach
                        </div>
                    </div>
                </li>

            </ul>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('.fenlei').hover(function () {
        $('.category-menu').show()
    }, function () {
        $('.category-menu').hide()
    });
    $('.category-menu').hover(function () {
        $('.category-menu').show()
    }, function () {
        $('.category-menu').hide()
    });
</script>