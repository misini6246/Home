<li>
    <a href="{{$url}}" @if(!empty($action)&&$action==$name)class="on"@endif>
        @if($action==$name)
            <img src="/user/img/right_03.png"/>
        @else
            <img src="/user/img/right_03.png"/>
        @endif
        <span>{{$text}}</span>
        @if($name=='znx')
            @if(msg_count()>0)
                <div class="xx msg_count">{{msg_count()}}</div>
            @endif
        @endif
    </a>
</li>