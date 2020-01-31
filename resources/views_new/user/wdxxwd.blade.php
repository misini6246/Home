<li id="msg{{$v->msg_id}}">
    <div>
        <input type="checkbox" class="danxuan" value="{{$v->msg_id}}" onclick="danxuan($('.danxuan'),$('.quanxuan'))"/>
        <span class="weidu">未读</span>
        <span class="biaoti">{{$v->title}}</span>
    </div>
    <div class="neirong">
        <div class="chakan" onclick="cknr('{{$v->msg_id}}')">点击查看内容</div>
    </div>
</li>