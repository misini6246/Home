@if($pages->lastPage()>0)
<div class="listPageDiv">
    <div class="pageList">
        @if($pages->lastPage()>1)
            @if($pages->currentPage()-4>1)
                <span class="p1"><a href="{{pageParams(1,$params)}}">第一页</a></span>
            @endif
            @if($pages->currentPage()>1)
                <span class="p1"><a href="{{pageParams($pages->currentPage()-1,$params)}}">上一页</a></span>
            @endif
            @if($pages->currentPage()>$pages->lastPage()-3)
                @for($i=$pages->currentPage()-4-($pages->currentPage()-$pages->lastPage()+3);$i<$pages->currentPage();$i++)
                    @if($i>0)
                        <span class="p1"><a href="{{pageParams($i,$params)}}">{{$i}}</a></span>
                    @endif
                @endfor
            @else
                @for($i=$pages->currentPage()-4;$i<$pages->currentPage();$i++)
                    @if($i>0)
                        <span class="p1"><a href="{{pageParams($i,$params)}}">{{$i}}</a></span>
                    @endif
                @endfor
            @endif
            <span class="p1 p_ok">{{$pages->currentPage()}}</span>
            @if($pages->currentPage()<5)
                @for($i=$pages->currentPage()+1;$i<$pages->currentPage()+4+5-$pages->currentPage();$i++)
                    @if($i<=$pages->lastPage())
                        <span class="p1"><a href="{{pageParams($i,$params)}}">{{$i}}</a></span>
                    @endif
                @endfor
            @else
                @for($i=$pages->currentPage()+1;$i<$pages->currentPage()+4;$i++)
                    @if($i<=$pages->lastPage())
                        <span class="p1"><a href="{{pageParams($i,$params)}}">{{$i}}</a></span>
                    @endif
                @endfor
            @endif
            @if($pages->currentPage()<$pages->lastPage())
                <span class="p1"><a href="{{pageParams($pages->currentPage()+1,$params)}}">下一页</a></span>
            @endif
            @if($pages->currentPage()+3<$pages->lastPage())
                <span class="p1"><a href="{{pageParams($pages->lastPage(),$params)}}">最末页</a></span>
            @endif
        @endif
    </div>
    {!! $pagesForm !!}
</div>
@endif
<span class="p1 p_ok">1</span>
<span class="p1"><a href="http://127.0.0.1/user/collectList?type=1&page=2">2</a></span>
<span class="p1"><a href="http://127.0.0.1/user/collectList?type=1&page=3">3</a></span>