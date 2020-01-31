<ul class="youhuijuan_list">
    @if(isset($type)&&$type==0)
        @foreach($result as $k=>$v)
            @if($k==0)
                <li class="use active">
                    <div class="use_box">
                        <div class="ct_left">
                            <p class="money">￥{{intval($v->je)}}</p>
                            <p class="tj">{{$v->category->title}}</p>
                            <p class="data">@if($v->end-$v->start>3600*24)
                                    {{date('Y.m.d',$v->start)}}-{{date('Y.m.d',$v->end - 1)}}@else
                                    仅限{{date('Y.m.d',$v->start)}}@endif可用</p>
                        </div>
                        <div class="ct_right">
                            感恩券
                        </div>
                        <img style="position: absolute;right: 0;bottom: 0;"
                             src="/index/img/youhuijuan_choose.png">
                    </div>
                </li>
                <input class="yhq_id_use" type="hidden" name="yhq_id[]" value="-1">
            @endif
        @endforeach
    @else
        @foreach($result as $v)
            @if($v->is_used==1)
                <li class="use @if($v->is_used==1) active @endif">
                    <div class="use_box">
                        <div class="ct_left">
                            <p class="money">￥{{intval($v->je)}}</p>
                            <p class="tj">{{$v->category->title}}</p>
                            <p class="data">@if($v->end-$v->start>3600*24)
                                    {{date('Y.m.d',$v->start)}}-{{date('Y.m.d',$v->end - 1)}}@else
                                    仅限{{date('Y.m.d',$v->start)}}@endif可用</p>
                        </div>
                        <div class="ct_right">
                            优惠券
                        </div>
                        @if($v->is_used==1)
                            <img style="position: absolute;right: 0;bottom: 0;"
                                 src="/index/img/youhuijuan_choose.png">
                        @endif
                    </div>
                </li>
                @if($v->is_used==1)
                    <input class="yhq_id_use" type="hidden" name="yhq_id[]" value="{{$v->yhq_id}}">
                @endif
            @else
                <li class="none">
                    <div class="none_box">
                        <div class="ct_left">
                            <p class="money">￥{{intval($v->je)}}</p>
                            <p class="tj">{{$v->category->title}}</p>
                            <p class="data">@if($v->end-$v->start>3600*24)
                                    {{date('Y.m.d',$v->start)}}-{{date('Y.m.d',$v->end - 1)}}@else
                                    仅限{{date('Y.m.d',$v->start)}}@endif可用</p>
                        </div>
                        <div class="ct_right">
                            优惠券
                        </div>
                    </div>
                    <div class="tj_text">
                        {{--<img src="/index/img/juan_bg_none.png"/>--}}
                        <span>订单金额不满足此券使用条件</span>
                    </div>
                </li>
            @endif
        @endforeach
    @endif
</ul>
<script>
    var len = $('.yhq_id_use').length;
    $('#yhq_count').text(len);
</script>