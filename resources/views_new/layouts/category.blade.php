@foreach($category->cate as $k=>$value)
    @if($k==0)
        @if(count($value->cate)>0)
            <div class="category_list_title">
                {{$category->cat_name or ''}}
            </div>
            @foreach($category->cate as $v)
                @if(count($v->cate)>0)
                    <div class="ct">
                <span class="category_list_title_left">
                    {{$v->cat_name}}
                </span>
                        <div class="category_list_link">
                            @if(!in_array($ylfl_show_area,['b','c','e','f']))
                                @foreach($v->cate as $val)
                                    <a target="_blank"
                                       href="{{route('category.index',['ylfl'=>$ylfl_show_area,'ylfl1'=>$category->cat_id,'ylfl2'=>$val->cat_id])}}">{{$val->cat_name}}</a>
                                @endforeach
                            @else
                                @foreach($v->cate as $val)
                                    <a target="_blank"
                                       href="{{route('category.index',['ylfl'=>$ylfl_show_area,'ylfl1'=>$val->cat_id])}}">{{$val->cat_name}}</a>
                                @endforeach
                            @endif
                        </div>
                    </div>
                @endif
            @endforeach
        @else
            <div class="category_list_title notitle">
                {{$category->cat_name or ''}}
            </div>
            <div class="ct notitle_ct">
                <div class="category_list_link">
                    @if($ylfl_show_area=='l')
                        @foreach($category->cate as $val)
                            <a target="_blank"
                               href="{{route('category.zyyp',['pid'=>$val->cat_id])}}">{{$val->cat_name}}</a>
                        @endforeach
                    @else
                        @foreach($category->cate as $val)
                            <a target="_blank"
                               href="{{route('category.index',['ylfl'=>$ylfl_show_area,'ylfl1'=>$val->cat_id])}}">{{$val->cat_name}}</a>
                        @endforeach
                    @endif
                </div>
            </div>
        @endif
    @endif
@endforeach