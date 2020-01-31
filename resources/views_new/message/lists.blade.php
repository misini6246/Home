<div class="t-title fn_clear">
    <div class="weidu">
        <label>
            <input style="margin-top: -3px;" type="checkbox" class="xwd" name="item" id="check_all"
                   onclick="check_all($(this))"> 全选</label>

    </div>
    <div class="r-xinxi">
        <label><input style="margin-top: -3px;" type="checkbox" onchange="wd_znx($(this))"
                      @if($status==1)checked="checked"@endif/> 只显示未读消息</label> | <span id="yd"
                                                                                       onclick="yd()">标记为已读 | </span>
        <span id="sc" onclick="shanchu()">删除</span>

    </div>


</div>
@if(count($pages)>0)
    @foreach($pages as $v)
        <table class="youjian" id="msg{{$v->msg_id}}">
            <tr class="tr1">
                <td class="td1"></td>
                <td class="td2"></td>
                <td class="td3"
                    style="text-align:left;font-weight:bold;color:#333;font-size:14px;">{{$v->message->title or ''}}</td>
                <td class="td4">{{$v->add_time->format('Y-m-d H:i')}}</td>
            </tr>
            <tr>
                <td class="td1"><input type="checkbox" name="item" class="znx_id id_check"
                                       onclick="is_check('id_check','check_all')"
                                       znx_id="{{$v->msg_id}}"/><label></label></td>
                <td class="td2" style="cursor: pointer;">
                    <a href="{{route('user.znx_info',['id'=>$v->msg_id])}}">
                        @if($v->status==1)
                            <span class="xyd"><img id="status{{$v->msg_id}}"
                                                   src="{{get_img_path('images/msg-03.png')}}" alt=""
                                                   style="margin-top:10px;"></span>
                        @else
                            <span class="xwd"><img id="status{{$v->msg_id}}"
                                                   src="{{get_img_path('images/msg-01.jpg')}}" alt=""
                                                   style="margin-top:10px;"></span>
                        @endif
                    </a>
                </td>
                <td colspan="2" style="text-align:left;">
                    <span>{{$v->message->msg_desc or ''}}</span>
                    <a href="{{route('user.znx_info',['id'=>$v->msg_id])}}"
                       style="color:#06f;">点击查看全文>></a>
                </td>

            </tr>
            <tr>
                <td colspan="4" style="text-align:right;">发件人：系统管理员</td>
            </tr>
        </table>
    @endforeach
@else
    <table class="youjian">
        <tr>
            <td colspan="7">暂无任何信息！</td>
        </tr>
    </table>
@endif


@if($pages->lastPage()>0)
    {!! pagesView($pages->currentPage(),$pages->lastPage(),3,3,[
    'url'=>'user.znx_list',
    'status'=>$status,
    ]) !!}
@endif