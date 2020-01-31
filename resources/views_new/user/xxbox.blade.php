@if(count($result)>0)
    <div class="right_top">
        <input type="checkbox" name="quanxuan" value="" class="quanxuan"
               onclick="quanxuan($(this),$('.danxuan'))"/><label for="quanxuan" class="quanxuan"
                                                                 onclick="quanxuan($(this),$('.danxuan'))">全选</label>
        <span class="shanchu" onclick="plsc($('#plsc'))">删除</span>
    </div>
    <ul class="xiaoxi">
        @foreach($result as $v)
            @if($v->status==1)
                @include('user.wdxxyd')
            @elseif($v->status==0)
                @include('user.wdxxwd')
            @endif
        @endforeach
    </ul>
    <div class="xiaoxi_page">
        <input type="checkbox" name="quanxuan" value="" class="quanxuan" style="margin-left: 10px;"
               onclick="quanxuan($(this),$('.danxuan'))"/><label for="quanxuan" class="quanxuan"
                                                                 onclick="quanxuan($(this),$('.danxuan'))">全选</label>|
        <span class="shanchu" onclick="plsc($(this))" id="plsc"
              data-config='{"url":"{{route('member.wodexiaoxi.destroy',['id'=>'','type'=>$type])}}","msg":"确定删除该条消息?",
                          "method":"delete","dataType":"json","box":"xxbox"}'>删除</span>
    </div>
    @include('user.pages',['pages'=>$result])
@else
    @include('user.empty',['type'=>4,'emsg'=>'暂无消息'])
@endif