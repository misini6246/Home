<ul>
    @if($pages->lastPage()>1)
        @if($pages->currentPage()>1)
            <li class='pagination_toLeft' ><a href="{{pageParams($pages->currentPage()-1,$params)}}"><button class='reset_btn'></button></a></li>
        @endif
        @if($pages->currentPage()>$pages->lastPage()-3)
            @for($i=$pages->currentPage()-4-($pages->currentPage()-$pages->lastPage()+3);$i<$pages->currentPage();$i++)
                @if($i>0)
                    <li class='page_num'><a href='{{pageParams($i,$params)}}'>{{$i}}</a></li>
                @endif
            @endfor
        @else
            @for($i=$pages->currentPage()-4;$i<$pages->currentPage();$i++)
                @if($i>0)
                    <li class='page_num'><a href='{{pageParams($i,$params)}}'>{{$i}}</a></li>
                @endif
            @endfor
        @endif
        <li class='clicked page_num'><a href=''>{{$pages->currentPage()}}</a></li>
        @if($pages->currentPage()<5)
            @for($i=$pages->currentPage()+1;$i<$pages->currentPage()+4+5-$pages->currentPage();$i++)
                @if($i<=$pages->lastPage())
                    <li class='page_num'><a href='{{pageParams($i,$params)}}'>{{$i}}</a></li>
                @endif
            @endfor
        @else
            @for($i=$pages->currentPage()+1;$i<$pages->currentPage()+4;$i++)
                @if($i<=$pages->lastPage())
                    <li class='page_num'><a href='{{pageParams($i,$params)}}'>{{$i}}</a></li>
                @endif
            @endfor
        @endif
        @if($pages->currentPage()<$pages->lastPage())
            <li class='pagination_toRight'><a href="{{pageParams($pages->currentPage()+1,$params)}}"><button class='reset_btn'></button></a></li>
        @endif
    @endif


</ul>