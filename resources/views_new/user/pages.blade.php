@if($pages->hasPages())
    <style>
        #fenye a {
            display: inline-block;
            width: 100%;
            height: 100%;
            color: #777;
        }
    </style>
    <div class="page" id="fenye">
        <ul>
            @if($pages->currentPage()>1)
                <li class="prev"><a href="{{$pages->previousPageUrl()}}">上一页</a></li>
            @endif
            @for($i=$pages->currentPage()-2;$i<$pages->currentPage();$i++)
                @if($i>0)
                    <li><a href="{{$pages->url($i)}}">{{$i}}</a></li>
                @endif
            @endfor
            <li class="active">{{$pages->currentPage()}}</li>
            @for($i=$pages->currentPage()+1;$i<=$pages->currentPage()+2;$i++)
                @if($i<=$pages->lastPage())
                    <li><a href="{{$pages->url($i)}}">{{$i}}</a></li>
                @endif
            @endfor
            @if($pages->currentPage()<$pages->lastPage())
                <li class="next"><a href="{{$pages->nextPageUrl()}}">下一页</a></li>
            @endif
        </ul>
        <span>共{{$pages->lastPage()}}页</span>
        <span>到第</span>
        <input name="page" type="text" form="search_form" class="val" value="{{$pages->currentPage()}}"/>
        <span>页</span>
        <input type="submit" form="search_form" id="page_btn" value="确定"/>
    </div>
@endif