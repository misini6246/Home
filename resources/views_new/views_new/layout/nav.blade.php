<div class="nav" id="nav">
    <div class="nav_box fn_clear">
        <div class="title_nav">
            <div class="nav_img">
                <img src="{{get_img_path('images/all_category.jpg')}}" alt=""/>
            </div>
        </div>
        <div @if(!isset($nav_shijian))style="display:none;background-color: #fff" shijian="1"@else shijian="0" @endif class="all-goods" >
            <div class="item btnone">
                <div class="product">
                    <span class="ico ico1"></span>
                    <h3> <a href="{{route('category.index',['dis'=>'b'])}}">呼吸系统用药</a> </h3>
                    <s style="display:block;"></s>
                </div>
                <div class="product-wrap posone">
                    @foreach($cate_tree->where('cat_id','490')->first()->cate as $k=>$cat1)
                    <div class="cf">
                        <div class="erjifenlei">
                            @if($k==0)
                            {{$cate_tree->where('cat_id','490')->first()->cat_name}}
                            @endif
                        </div>
                        <div class="fl wd252 pr20">
                            <h2><span>{{$cat1->cat_name}}</span></h2>
                            <ul class="cf">
                                @foreach($cat1->cate as $cat2)
                                <li> <a href="{{route('category.index',['phaid'=>$cat2->cat_id])}}" target="_blank">{{$cat2->cat_name}}</a> </li>
                                @endforeach
                            </ul>
                        </div>

                    </div>
                    @endforeach
                </div>
            </div>
            <div class="item">
                <div class="product">
                    <span class="ico ico2"></span>
                    <h3> <a href="{{route('category.index',['dis'=>'c'])}}">清热、消炎</a> </h3>
                    <s></s>
                </div>
                <div class="product-wrap postwo">
                    @foreach($cate_tree->where('cat_id','496')->first()->cate as $k=>$cat1)
                        <div class="cf">
                            <div class="erjifenlei">
                                @if($k==0)
                                {{$cate_tree->where('cat_id','496')->first()->cat_name}}
                                @endif
                            </div>
                            <div class="fl wd252 pr20">
                                <h2><span>{{$cat1->cat_name}}</span></h2>
                                <ul class="cf">
                                    @foreach($cat1->cate as $cat2)
                                        <li> <a href="{{route('category.index',['phaid'=>$cat2->cat_id])}}" target="_blank">{{$cat2->cat_name}}</a> </li>
                                    @endforeach
                                </ul>
                            </div>

                        </div>
                    @endforeach
                </div>
            </div>
            <div class="item">
                <div class="product">
                    <span class="ico ico3"></span>
                    <h3> <a href="{{route('category.index',['dis'=>'d'])}}">五官、皮肤及外用</a> </h3>
                    <s></s>
                </div>
                <div class="product-wrap posthree">
                    @foreach($cate_tree->where('cat_id','531')->first()->cate as $k=>$cat1)
                        <div class="cf">
                            <div class="erjifenlei">
                                @if($k==0)
                                {{$cate_tree->where('cat_id','531')->first()->cat_name}}
                                @endif
                            </div>
                            <div class="fl wd252 pr20">
                                <h2><span>{{$cat1->cat_name}}</span></h2>
                                <ul class="cf">
                                    @foreach($cat1->cate as $cat2)
                                        <li> <a href="{{route('category.index',['phaid'=>$cat2->cat_id])}}" target="_blank">{{$cat2->cat_name}}</a> </li>
                                    @endforeach
                                </ul>
                            </div>

                        </div>
                    @endforeach
                        @foreach($cate_tree->where('cat_id','548')->first()->cate as $k=>$cat1)
                            <div class="cf">
                                <div class="erjifenlei">
                                    @if($k==0)
                                    {{$cate_tree->where('cat_id','548')->first()->cat_name}}
                                    @endif
                                </div>
                                <div class="fl wd252 pr20">
                                    <h2><span>{{$cat1->cat_name}}</span></h2>
                                    <ul class="cf">
                                        @foreach($cat1->cate as $cat2)
                                            <li> <a href="{{route('category.index',['phaid'=>$cat2->cat_id])}}" target="_blank">{{$cat2->cat_name}}</a> </li>
                                        @endforeach
                                    </ul>
                                </div>

                            </div>
                        @endforeach
                </div>
            </div>
            <div class="item">
                <div class="product">
                    <span class="ico ico4"></span>
                    <h3> <a href="{{route('category.index',['dis'=>'e'])}}">消化、肝胆系统</a> </h3>
                    <s></s>
                </div>
                <div class="product-wrap posfour">
                    @foreach($cate_tree->where('cat_id','575')->first()->cate as $k=>$cat1)
                        <div class="cf">
                            <div class="erjifenlei">
                                @if($k==0)
                                {{$cate_tree->where('cat_id','575')->first()->cat_name}}
                                @endif
                            </div>
                            <div class="fl wd252 pr20">
                                <h2><span>{{$cat1->cat_name}}</span></h2>
                                <ul class="cf">
                                    @foreach($cat1->cate as $cat2)
                                        <li> <a href="{{route('category.index',['phaid'=>$cat2->cat_id])}}" target="_blank">{{$cat2->cat_name}}</a> </li>
                                    @endforeach
                                </ul>
                            </div>

                        </div>
                    @endforeach
                </div>
            </div>
            <div class="item">
                <div class="product">

                    <span class="ico ico5"></span>
                    <h3> <a href="{{route('category.index',['dis'=>'f'])}}">补益安神及维矿类</a> </h3>
                    <s></s> </div>
                <div class="product-wrap posfive">
                    @foreach($cate_tree->where('cat_id','620')->first()->cate as $k=>$cat1)
                        <div class="cf">
                            <div class="erjifenlei">
                                @if($k==0)
                                {{$cate_tree->where('cat_id','620')->first()->cat_name}}
                                @endif
                            </div>
                            <div class="fl wd252 pr20">
                                <h2><span>{{$cat1->cat_name}}</span></h2>
                                <ul class="cf">
                                    @foreach($cat1->cate as $cat2)
                                        <li> <a href="{{route('category.index',['phaid'=>$cat2->cat_id])}}" target="_blank">{{$cat2->cat_name}}</a> </li>
                                    @endforeach
                                </ul>
                            </div>

                        </div>
                    @endforeach
                </div>
            </div>
            <div class="item">
                <div class="product">
                    <span class="ico ico6"></span>
                    <h3> <a href="{{route('category.index',['dis'=>'g'])}}">妇、儿科</a> </h3>
                    <s></s>
                </div>
                <div class="product-wrap possix">
                    @foreach($cate_tree->where('cat_id','536')->first()->cate as $k=>$cat1)
                        <div class="cf">
                            <div class="erjifenlei">
                                @if($k==0)
                                {{$cate_tree->where('cat_id','536')->first()->cat_name}}
                                @endif
                            </div>
                            <div class="fl wd252 pr20">
                                <h2><span>{{$cat1->cat_name}}</span></h2>
                                <ul class="cf">
                                    @foreach($cat1->cate as $cat2)
                                        <li> <a href="{{route('category.index',['phaid'=>$cat2->cat_id])}}" target="_blank">{{$cat2->cat_name}}</a> </li>
                                    @endforeach
                                </ul>
                            </div>

                        </div>
                    @endforeach
                        @foreach($cate_tree->where('cat_id','584')->first()->cate as $k=>$cat1)
                            <div class="cf">
                                <div class="erjifenlei">
                                    @if($k==0)
                                    {{$cate_tree->where('cat_id','584')->first()->cat_name}}
                                    @endif
                                </div>
                                <div class="fl wd252 pr20">
                                    <h2><span>{{$cat1->cat_name}}</span></h2>
                                    <ul class="cf">
                                        @foreach($cat1->cate as $cat2)
                                            <li> <a href="{{route('category.index',['phaid'=>$cat2->cat_id])}}" target="_blank">{{$cat2->cat_name}}</a> </li>
                                        @endforeach
                                    </ul>
                                </div>

                            </div>
                        @endforeach
                </div>
            </div>
            <div class="item">
                <div class="product">
                    <span class="ico ico7"></span>
                    <h3> <a href="{{route('category.index',['dis'=>'h'])}}">心脑血管及神经类用药</a> </h3>
                    <s></s>
                </div>
                <div class="product-wrap posseven">
                    @foreach($cate_tree->where('cat_id','619')->first()->cate as $k=>$cat1)
                        <div class="cf">
                            <div class="erjifenlei">
                                @if($k==0)
                                {{$cate_tree->where('cat_id','619')->first()->cat_name}}
                                @endif
                            </div>
                            <div class="fl wd252 pr20">
                                <h2><span>{{$cat1->cat_name}}</span></h2>
                                <ul class="cf">
                                    @foreach($cat1->cate as $cat2)
                                        <li> <a href="{{route('category.index',['phaid'=>$cat2->cat_id])}}" target="_blank">{{$cat2->cat_name}}</a> </li>
                                    @endforeach
                                </ul>
                            </div>

                        </div>
                    @endforeach
                        @foreach($cate_tree->where('cat_id','767')->first()->cate as $k=>$cat1)
                            <div class="cf">
                                <div class="erjifenlei">
                                    @if($k==0)
                                    {{$cate_tree->where('cat_id','767')->first()->cat_name}}
                                    @endif
                                </div>
                                <div class="fl wd252 pr20">
                                    <h2><span>{{$cat1->cat_name}}</span></h2>
                                    <ul class="cf">
                                        @foreach($cat1->cate as $cat2)
                                            <li> <a href="{{route('category.index',['phaid'=>$cat2->cat_id])}}" target="_blank">{{$cat2->cat_name}}</a> </li>
                                        @endforeach
                                    </ul>
                                </div>

                            </div>
                        @endforeach
                </div>
            </div>
            <div class="item">
                <div class="product">
                    <span class="ico ico8"></span>
                    <h3> <a href="{{route('category.index',['dis'=>'i'])}}">内分泌系统（含糖尿病）</a> </h3>
                    <s></s>
                </div>
                <div class="product-wrap poseight">
                    @foreach($cate_tree->where('cat_id','788')->first()->cate as $k=>$cat1)
                        <div class="cf">
                            <div class="erjifenlei">
                                @if($k==0)
                                {{$cate_tree->where('cat_id','788')->first()->cat_name}}
                                @endif
                            </div>
                            <div class="fl wd252 pr20">
                                <h2><span>{{$cat1->cat_name}}</span></h2>
                                <ul class="cf">
                                    @foreach($cat1->cate as $cat2)
                                        <li> <a href="{{route('category.index',['phaid'=>$cat2->cat_id])}}" target="_blank">{{$cat2->cat_name}}</a> </li>
                                    @endforeach
                                </ul>
                            </div>

                        </div>
                    @endforeach
                        @foreach($cate_tree->where('cat_id','778')->first()->cate as $k=>$cat1)
                            <div class="cf">
                                <div class="erjifenlei">
                                    @if($k==0)
                                    {{$cate_tree->where('cat_id','778')->first()->cat_name}}
                                    @endif
                                </div>
                                <div class="fl wd252 pr20">
                                    <h2><span>{{$cat1->cat_name}}</span></h2>
                                    <ul class="cf">
                                        @foreach($cat1->cate as $cat2)
                                            <li> <a href="{{route('category.index',['phaid'=>$cat2->cat_id])}}" target="_blank">{{$cat2->cat_name}}</a> </li>
                                        @endforeach
                                    </ul>
                                </div>

                            </div>
                        @endforeach
                        @foreach($cate_tree->where('cat_id','796')->first()->cate as $k=>$cat1)
                            <div class="cf">
                                <div class="erjifenlei">
                                    @if($k==0)
                                        {{$cate_tree->where('cat_id','796')->first()->cat_name}}
                                    @endif
                                </div>
                                <div class="fl wd252 pr20">
                                    <h2><span>{{$cat1->cat_name}}</span></h2>
                                    <ul class="cf">
                                        @foreach($cat1->cate as $cat2)
                                            <li> <a href="{{route('category.index',['phaid'=>$cat2->cat_id])}}" target="_blank">{{$cat2->cat_name}}</a> </li>
                                        @endforeach
                                    </ul>
                                </div>

                            </div>
                        @endforeach
                </div>
            </div>
            <div class="item">
                <div class="product">
                    <span class="ico ico9"></span>
                    <h3> <a href="{{route('category.index',['dis'=>'j'])}}">风湿骨伤及其他药品</a> </h3>
                    <s></s>
                </div>
                <div class="product-wrap posnine">
                    @foreach($cate_tree->where('cat_id','801')->first()->cate as $k=>$cat1)
                        <div class="cf">
                            <div class="erjifenlei">
                                @if($k==0)
                                    {{$cate_tree->where('cat_id','801')->first()->cat_name}}
                                @endif
                            </div>
                            <div class="fl wd252 pr20">
                                <h2><span>{{$cat1->cat_name}}</span></h2>
                                <ul class="cf">
                                    @foreach($cat1->cate as $cat2)
                                        <li> <a href="{{route('category.index',['phaid'=>$cat2->cat_id])}}" target="_blank">{{$cat2->cat_name}}</a> </li>
                                    @endforeach
                                </ul>
                            </div>

                        </div>
                    @endforeach
                        @foreach($cate_tree->where('cat_id','655')->first()->cate as $k=>$cat1)
                            <div class="cf">
                                <div class="erjifenlei">
                                    @if($k==0)
                                        {{$cate_tree->where('cat_id','655')->first()->cat_name}}
                                    @endif
                                </div>
                                <div class="fl wd252 pr20">
                                    <h2><span>{{$cat1->cat_name}}</span></h2>
                                    <ul class="cf">
                                        @foreach($cat1->cate as $cat2)
                                            <li> <a href="{{route('category.index',['phaid'=>$cat2->cat_id])}}" target="_blank">{{$cat2->cat_name}}</a> </li>
                                        @endforeach
                                    </ul>
                                </div>

                            </div>
                        @endforeach
                        @foreach($cate_tree->where('cat_id','665')->first()->cate as $k=>$cat1)
                            <div class="cf">
                                <div class="erjifenlei">
                                    @if($k==0)
                                        {{$cate_tree->where('cat_id','665')->first()->cat_name}}
                                    @endif
                                </div>
                                <div class="fl wd252 pr20">
                                    <h2><span>{{$cat1->cat_name}}</span></h2>
                                    <ul class="cf">
                                        @foreach($cat1->cate as $cat2)
                                            <li> <a href="{{route('category.index',['phaid'=>$cat2->cat_id])}}" target="_blank">{{$cat2->cat_name}}</a> </li>
                                        @endforeach
                                    </ul>
                                </div>

                            </div>
                        @endforeach
                </div>
            </div>
            <div class="item">
                <div class="product">
                    <span class="ico ico10"></span>
                    <h3> <a href="{{route('category.index',['dis'=>'k'])}}">特殊复方制剂、生物制品</a> </h3>
                    <s></s>
                </div>
                <div class="product-wrap posten">
                        @foreach($cate_tree->where('cat_id','674')->first()->cate as $k=>$cat1)
                            <div class="cf">
                                <div class="erjifenlei">
                                    @if($k==0)
                                        {{$cate_tree->where('cat_id','674')->first()->cat_name}}
                                    @endif
                                </div>
                                <div class="fl wd252 pr20">
                                    <h2><span>{{$cat1->cat_name}}</span></h2>
                                    <ul class="cf">
                                        @foreach($cat1->cate as $cat2)
                                            <li> <a href="{{route('category.index',['phaid'=>$cat2->cat_id])}}" target="_blank">{{$cat2->cat_name}}</a> </li>
                                        @endforeach
                                    </ul>
                                </div>

                            </div>
                        @endforeach
                            <div class="cf">
                                <div class="erjifenlei" style="margin: 14px 25px 0px 0;">
                                    {{--@if($k==0)--}}
                                    {{$cate_tree->where('cat_id','682')->first()->cat_name}}
                                    {{--@endif--}}
                                </div>
                                <div class="fl wd252 pr20">
                                    <h2>
                                        {{--<span>{{$cat1->cat_name}}</span>--}}
                                    </h2>
                                    <ul class="cf">
                                        {{--@foreach($cat1->cate as $cat2)--}}
                                        {{--<li> <a href="{{route('category.index',['phaid'=>$cat2->cat_id])}}" target="_blank">{{$cat2->cat_name}}</a> </li>--}}
                                        {{--@endforeach--}}
                                        @foreach($cate_tree->where('cat_id','682')->first()->cate as $cat2)
                                            <li> <a href="{{route('category.index',['phaid'=>$cat2->cat_id])}}" target="_blank">{{$cat2->cat_name}}</a> </li>
                                        @endforeach
                                    </ul>
                                </div>

                            </div>
                </div>
            </div>
            <div class="item">
                <div class="product">
                    <span class="ico ico11"></span>
                    <h3> <a href="{{route('zy.index')}}">中药饮片</a> </h3>
                    <s></s>
                </div>
                <div class="product-wrap poseleven">
                    {{--@foreach($cate_tree->where('cat_id','445')->first()->cate as $k=>$cat1)--}}
                        <div class="cf">
                            <div class="erjifenlei" style="margin: 14px 25px 0px 0;">
                                {{--@if($k==0)--}}
                                {{$cate_tree->where('cat_id','445')->first()->cat_name}}
                                {{--@endif--}}
                            </div>
                            <div class="fl wd252 pr20">
                                <h2>
                                    {{--<span>{{$cat1->cat_name}}</span>--}}
                                </h2>
                                <ul class="cf">
                                    {{--@foreach($cat1->cate as $cat2)--}}
                                    {{--<li> <a href="{{route('category.index',['phaid'=>$cat2->cat_id])}}" target="_blank">{{$cat2->cat_name}}</a> </li>--}}
                                    {{--@endforeach--}}
                                    @foreach($cate_tree->where('cat_id','445')->first()->cate as $cat2)
                                        <li> <a href="{{route('category.zyyp',['pid'=>$cat2->cat_id])}}" target="_blank">{{$cat2->cat_name}}</a> </li>
                                    @endforeach
                                </ul>
                            </div>

                        </div>
                    {{--@endforeach--}}
                </div>
            </div>
            <div class="item">
                <div class="product">
                    <span class="ico ico12"></span>
                    <h3> <a href="{{route('category.index',['dis'=>'m'])}}">非药品</a> </h3>
                    <s></s>
                </div>
                <div class="product-wrap posetw">
                    {{--@foreach($cate_tree->where('cat_id','683')->first()->cate as $k=>$cat1)--}}
                        <div class="cf">
                            <div class="erjifenlei" style="margin: 14px 25px 0px 0;">
                                {{--@if($k==0)--}}
                                    {{$cate_tree->where('cat_id','683')->first()->cat_name}}
                                {{--@endif--}}
                            </div>
                            <div class="fl wd252 pr20">
                                <h2>
                                    {{--<span>{{$cat1->cat_name}}</span>--}}
                                </h2>
                                <ul class="cf">
                                    {{--@foreach($cat1->cate as $cat2)--}}
                                        {{--<li> <a href="{{route('category.index',['phaid'=>$cat2->cat_id])}}" target="_blank">{{$cat2->cat_name}}</a> </li>--}}
                                    {{--@endforeach--}}
                                        @foreach($cate_tree->where('cat_id','683')->first()->cate as $cat2)
                                            <li> <a href="{{route('category.index',['phaid'=>$cat2->cat_id])}}" target="_blank">{{$cat2->cat_name}}</a> </li>
                                        @endforeach
                                </ul>
                            </div>

                        </div>
                    {{--@endforeach--}}
                        {{--@foreach($cate_tree->where('cat_id','12')->first()->cate as $k=>$cat1)--}}
                    <div class="cf">
                        <div class="erjifenlei" style="margin: 14px 25px 0px 0;">
                            {{--@if($k==0)--}}
                            {{$cate_tree->where('cat_id','12')->first()->cat_name}}
                            {{--@endif--}}
                        </div>
                        <div class="fl wd252 pr20">
                            <h2>
                                {{--<span>{{$cat1->cat_name}}</span>--}}
                            </h2>
                            <ul class="cf">
                                {{--@foreach($cat1->cate as $cat2)--}}
                                {{--<li> <a href="{{route('category.index',['phaid'=>$cat2->cat_id])}}" target="_blank">{{$cat2->cat_name}}</a> </li>--}}
                                {{--@endforeach--}}
                                @foreach($cate_tree->where('cat_id','12')->first()->cate as $cat2)
                                    <li> <a href="{{route('category.index',['phaid'=>$cat2->cat_id])}}" target="_blank">{{$cat2->cat_name}}</a> </li>
                                @endforeach
                            </ul>
                        </div>

                    </div>
                        {{--@endforeach--}}
                        {{--@foreach($cate_tree->where('cat_id','732')->first()->cate as $k=>$cat1)--}}
                    <div class="cf">
                        <div class="erjifenlei" style="margin: 14px 25px 0px 0;">
                            {{--@if($k==0)--}}
                            {{$cate_tree->where('cat_id','732')->first()->cat_name}}
                            {{--@endif--}}
                        </div>
                        <div class="fl wd252 pr20">
                            <h2>
                                {{--<span>{{$cat1->cat_name}}</span>--}}
                            </h2>
                            <ul class="cf">
                                {{--@foreach($cat1->cate as $cat2)--}}
                                {{--<li> <a href="{{route('category.index',['phaid'=>$cat2->cat_id])}}" target="_blank">{{$cat2->cat_name}}</a> </li>--}}
                                {{--@endforeach--}}
                                @foreach($cate_tree->where('cat_id','732')->first()->cate as $cat2)
                                    <li> <a href="{{route('category.index',['phaid'=>$cat2->cat_id])}}" target="_blank">{{$cat2->cat_name}}</a> </li>
                                @endforeach
                            </ul>
                        </div>

                    </div>
                        {{--@endforeach--}}
                        {{--@foreach($cate_tree->where('cat_id','739')->first()->cate as $k=>$cat1)--}}
                    <div class="cf">
                        <div class="erjifenlei" style="margin: 14px 25px 0px 0;">
                            {{--@if($k==0)--}}
                            {{$cate_tree->where('cat_id','739')->first()->cat_name}}
                            {{--@endif--}}
                        </div>
                        <div class="fl wd252 pr20">
                            <h2>
                                {{--<span>{{$cat1->cat_name}}</span>--}}
                            </h2>
                            <ul class="cf">
                                {{--@foreach($cat1->cate as $cat2)--}}
                                {{--<li> <a href="{{route('category.index',['phaid'=>$cat2->cat_id])}}" target="_blank">{{$cat2->cat_name}}</a> </li>--}}
                                {{--@endforeach--}}
                                @foreach($cate_tree->where('cat_id','739')->first()->cate as $cat2)
                                    <li> <a href="{{route('category.index',['phaid'=>$cat2->cat_id])}}" target="_blank">{{$cat2->cat_name}}</a> </li>
                                @endforeach
                            </ul>
                        </div>

                    </div>
                        {{--@endforeach--}}
                        {{--@foreach($cate_tree->where('cat_id','751')->first()->cate as $k=>$cat1)--}}
                    <div class="cf">
                        <div class="erjifenlei" style="margin: 14px 25px 0px 0;">
                            {{--@if($k==0)--}}
                            {{$cate_tree->where('cat_id','751')->first()->cat_name}}
                            {{--@endif--}}
                        </div>
                        <div class="fl wd252 pr20">
                            <h2>
                                {{--<span>{{$cat1->cat_name}}</span>--}}
                            </h2>
                            <ul class="cf">
                                {{--@foreach($cat1->cate as $cat2)--}}
                                {{--<li> <a href="{{route('category.index',['phaid'=>$cat2->cat_id])}}" target="_blank">{{$cat2->cat_name}}</a> </li>--}}
                                {{--@endforeach--}}
                                @foreach($cate_tree->where('cat_id','751')->first()->cate as $cat2)
                                    <li> <a href="{{route('category.index',['phaid'=>$cat2->cat_id])}}" target="_blank">{{$cat2->cat_name}}</a> </li>
                                @endforeach
                            </ul>
                        </div>

                    </div>
                        {{--@endforeach--}}
                    {{--@foreach($cate_tree->where('cat_id','751')->first()->cate as $k=>$cat1)--}}
                    <div class="cf">
                        <div class="erjifenlei" style="margin: 14px 25px 0px 0;">
                            {{--@if($k==0)--}}
                            {{$cate_tree->where('cat_id','899')->first()->cat_name}}
                            {{--@endif--}}
                        </div>
                        <div class="fl wd252 pr20">
                            <h2>
                                {{--<span>{{$cat1->cat_name}}</span>--}}
                            </h2>
                            <ul class="cf">
                                {{--@foreach($cat1->cate as $cat2)--}}
                                {{--<li> <a href="{{route('category.index',['phaid'=>$cat2->cat_id])}}" target="_blank">{{$cat2->cat_name}}</a> </li>--}}
                                {{--@endforeach--}}
                                @foreach($cate_tree->where('cat_id','899')->first()->cate as $cat2)
                                    <li> <a href="{{route('category.index',['phaid'=>$cat2->cat_id])}}" target="_blank">{{$cat2->cat_name}}</a> </li>
                                @endforeach
                            </ul>
                        </div>

                    </div>
                    {{--@endforeach--}}
                    {{--@foreach($cate_tree->where('cat_id','751')->first()->cate as $k=>$cat1)--}}
                    <div class="cf">
                        <div class="erjifenlei" style="margin: 14px 25px 0px 0;">
                            {{--@if($k==0)--}}
                            {{$cate_tree->where('cat_id','922')->first()->cat_name}}
                            {{--@endif--}}
                        </div>
                        <div class="fl wd252 pr20">
                            <h2>
                                {{--<span>{{$cat1->cat_name}}</span>--}}
                            </h2>
                            <ul class="cf">
                                {{--@foreach($cat1->cate as $cat2)--}}
                                {{--<li> <a href="{{route('category.index',['phaid'=>$cat2->cat_id])}}" target="_blank">{{$cat2->cat_name}}</a> </li>--}}
                                {{--@endforeach--}}
                                @foreach($cate_tree->where('cat_id','922')->first()->cate as $cat2)
                                    <li> <a href="{{route('category.index',['phaid'=>$cat2->cat_id])}}" target="_blank">{{$cat2->cat_name}}</a> </li>
                                @endforeach
                            </ul>
                        </div>

                    </div>
                    {{--@endforeach--}}
                </div>
            </div>
        </div>


        <ul class="nav_title">
            @if($middle_nav)
                @foreach($middle_nav as $k=>$v)
                    <li><a
                                @if(isset($dh_check)&&$v->id==$dh_check)
                                    class="checked"
                                    @endif href="{{$v->url}}" @if($v->opennew==1)target="_blank" @endif >{{$v->name}}</a>@if($k<count($middle_nav) - 1)<span class="separate"></span>@endif @if($v->is_hot==1)<span class="hot"></span>@endif</li>
                @endforeach
            @endif
        </ul>

        <div class="goshopping2">
            <a href="{{route('cart.index')}}"><img src="{{get_img_path('images/new-index08.jpg')}}" alt="" /></a>
            <span class="num" style="text-align: center">{{$cart_num}}</span>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function(){
        var shijian = $('.all-goods').attr('shijian');
        if(shijian==1) {
            $('.title_nav').hover(function () {
                $('.all-goods').show();
            }, function () {
                $('.all-goods').hide();
            });
            $('.all-goods').hover(function () {
                $('.all-goods').show();
            }, function () {
                $('.all-goods').hide();
            });
        }
    })
</script>