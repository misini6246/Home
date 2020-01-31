@if(count($result)>0)
    <form id="search_form" name="search_form"
          action="{{route('member.money',['type'=>$type])}}">
    </form>
    <table style="margin-bottom: 20px;">
        <tr>
            <th class="czsj">操作时间</th>
            <th class="lx">类型</th>
            <th class="je">金额</th>
            <th class="jy">当前余额</th>
            <th class="bz">备注</th>
        </tr>
        @foreach($result as $v)
            <tr>
                <td class="czsj">{{date('Y-m-d',$v->change_time)}}</td>
                <td class="lx">@if($v->money<0)减少@else增加@endif</td>
                <td class="je">{{formated_price(abs($v->money))}}</td>
                <td class="jy">{{formated_price($v->now_money)}}</td>
                <td>
                    <div class="bz">
                        {{$v->change_desc}}
                    </div>
                </td>
            </tr>
        @endforeach
    </table>
    @include('user.pages',['pages'=>$result])
@else
    @include('user.empty',['type'=>4])
@endif
<script>
    $('.page a').click(function () {
        var url = $(this).attr('href');
        get_data(url);
        return false;
    });
    $('#search_form').submit(function () {
        var url = $(this).attr('action');
        var page = $('input[name=page]').val();
        url = url + '&page=' + page;
        get_data(url);
        return false;
    });
</script>