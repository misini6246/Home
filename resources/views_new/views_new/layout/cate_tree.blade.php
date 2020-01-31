
 {{--* Created by PhpStorm.--}}
 {{--* User: 蠢羊--}}
 {{--* Date: 2016/5/29--}}
 {{--* Time: 0:48--}}
<div class="left_nav fn_clear">
    <ul class="nav_list" >
        @if($cate_tree)
        @foreach($cate_tree as $v)
            <li class="child_li @if($v=='中西成药'||$v=='国/川.基药') jiyao @endif">
                <p>
                    <span class="menu_ico @if($v=='进口.合资') recommend @endif
                    @if($v=='国/川.基药') new @endif
                    @if($v=='中药饮片') medical @endif
                    @if($v=='保健食品') health @endif
                    @if($v=='器械.计生') pieces @endif"></span>
                    <a href="@if($v=='中西成药'){{route('category.index',['dis'=>1])}} @endif
                    @if($v=='进口.合资') {{route('category.index',['dis'=>9])}} @endif
                    @if($v=='国/川.基药') {{route('category.index',['dis'=>8])}} @endif
                    @if($v=='中药饮片') /zy @endif
                    @if($v=='保健食品') {{route('category.index',['dis'=>5])}} @endif
                    @if($v=='器械.计生') {{route('category.index',['dis'=>6])}} @endif">
                        <span class="title_text">{{$v}}</span></a> <span class="right_ico"></span></p></li>
        @endforeach
        @endif
    </ul>
    <ul class="box fn_clear">
        <li style="display: none;" class="jiyao fn_clear"><!-- 中西成药 -->
            <h3>西药</h3>
            <div class="fn_clear">
                @foreach(cate_tree(22) as $v)
                    <a href="{{route('category.index',['dis'=>1,'phaid'=>$v->cat_id])}}" title="{{$v->cat_name}}">{{$v->cat_name}}</a>
                @endforeach
            </div>
            <h3 class="h_t">中成药</h3>
            <div>
                @foreach(cate_tree(188) as $v)
                    <a href="{{route('category.index',['dis'=>1,'phaid'=>$v->cat_id])}}" title="{{$v->cat_name}}">{{$v->cat_name}}</a>
                @endforeach
            </div>
        </li>
        <li class="fn_clear"><!-- 进口.合资 -->
            <h3>进口.合资</h3>
            <div class="fn_clear">
                @foreach(cate_tree(399) as $v)
                    <a href="{{route('category.index',['dis'=>9,'phaid'=>$v->cat_id])}}" title="{{$v->cat_name}}">{{$v->cat_name}}</a>
                @endforeach
            </div>
        </li>
        <li class="jiyao fn_clear"><!-- 基药 -->
            <h3>西药</h3>
            <div class="fn_clear">
                @foreach(cate_tree(22) as $v)
                    <a href="{{route('category.index',['dis'=>8,'phaid'=>$v->cat_id])}}" title="{{$v->cat_name}}">{{$v->cat_name}}</a>
                @endforeach
            </div>
            <h3 class="h_t">中成药</h3>
            <div>
                @foreach(cate_tree(188) as $v)
                    <a href="{{route('category.index',['dis'=>8,'phaid'=>$v->cat_id])}}" title="{{$v->cat_name}}">{{$v->cat_name}}</a>
                @endforeach
            </div>
        </li>
        <li class="fn_clear"><!-- 器械.计生 -->
            <h3>器械.计生</h3>
            <div class="fn_clear">
                @foreach(cate_tree(1) as $v)
                    <a href="{{route('category.index',['dis'=>6,'phaid'=>$v->cat_id])}}" title="{{$v->cat_name}}">{{$v->cat_name}}</a>
                @endforeach
            </div>
        </li>
        <li class="fn_clear"><!-- 保健食品 -->
            <h3>保健食品</h3>
            <div class="fn_clear">
                @foreach(cate_tree(12) as $v)
                    <a href="{{route('category.index',['dis'=>5,'phaid'=>$v->cat_id])}}" title="{{$v->cat_name}}">{{$v->cat_name}}</a>
                @endforeach
            </div>
        </li>
        <li class="fn_clear"><!-- 中药饮片 -->
            <h3>中药饮片</h3>
            <div class="fn_clear">
                @foreach(cate_tree(6) as $v)
                    <a href="/zy" title="{{$v->cat_name}}">{{$v->cat_name}}</a>
                @endforeach
            </div>
        </li>
    </ul>

</div>