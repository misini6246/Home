<form name="selectPageForm" action="{{route('user.index')}}" method="get">


    <div id="pager" class="pagebar" style="width:100%; height:40px; float:left;">
        <span class="f_l f6" style="margin-right:10px;">总计 <b>{{$pages->total()}}</b>  个记录</span>
        @if($pages->lastPage()>1)
        @if($pages->currentPage()>1)
            <a class="pre" href="{{pageParams($pages->currentPage()-1,$params)}}">上一页</a>
        @endif
        @if($pages->currentPage()>$pages->lastPage()-3)
            @for($i=$pages->currentPage()-4-($pages->currentPage()-$pages->lastPage()+3);$i<$pages->currentPage();$i++)
                @if($i>0)
                    <a href="{{pageParams($i,$params)}}">[{{$i}}]</a>
                @endif
            @endfor
        @else
            @for($i=$pages->currentPage()-4;$i<$pages->currentPage();$i++)
                @if($i>0)
                <a href="{{pageParams($i,$params)}}">[{{$i}}]</a>
                @endif
            @endfor
        @endif
        <span class="page_now">{{$pages->currentPage()}}</span>
        @if($pages->currentPage()<5)
            @for($i=$pages->currentPage()+1;$i<$pages->currentPage()+4+5-$pages->currentPage();$i++)
                @if($i<=$pages->lastPage())
                    <a href="{{pageParams($i,$params)}}">[{{$i}}]</a>
                @endif
            @endfor
        @else
            @for($i=$pages->currentPage()+1;$i<$pages->currentPage()+4;$i++)
                @if($i<=$pages->lastPage())
                <a href="{{pageParams($i,$params)}}">[{{$i}}]</a>
                @endif
            @endfor
        @endif
        @if($pages->currentPage()<$pages->lastPage())
            <a class="pre" href="{{pageParams($pages->currentPage()+1,$params)}}">下一页</a>
        @endif
        @endif
    </div>

</form>