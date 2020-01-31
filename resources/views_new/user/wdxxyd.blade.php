<li id="msg{{$v->msg_id}}">
    <div>
        <input type="checkbox" class="danxuan" value="{{$v->msg_id}}" onclick="danxuan($('.danxuan'),$('.quanxuan'))"/>
        <span>已读</span>
        <span class="biaoti">{{$v->title}}</span>
    </div>
    <div class="neirong">
        <div class="txt">
            {!! $v->text !!}
        </div>
    </div>
</li>