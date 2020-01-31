
<ul>
    @foreach($status as $k=>$v)
    <li class="fn_clear @if($k==0) on_hover @endif">
        <span class="date_txt">{{$v['times']}}</span> <span class="data_txt">{!! $v['con'] !!}</span>
    </li>
    @endforeach
</ul>
