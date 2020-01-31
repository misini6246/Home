<input type="hidden" id="daojs" value="{{collect($ad124->first())->get('end_time')-time()}}"/>
<div class="meiri-box">
    <div class="timeout">
        <div id="remainTime"></div>
    </div>
    <div class="meiri-shangpin" style="position: relative;">
        @if($ad124)
            @foreach($ad124 as $k=>$v)
                @if($k<2)
                    @if($k==0)
                        <a target="_blank" href="{{$v->ad_link}}"
                           style="position: absolute;top:10px;left:10px;overflow: hidden;height: 450px;">
                            <img src="{{$v->ad_code}}"
                                 style="transition: all .5s linear;width: 295px;height: 450px;"/>
                        </a>
                    @else
                        <a target="_blank" href="{{$v->ad_link}}"
                           style="float:right;margin-right: 10px;margin-top: 10px;overflow: hidden;height: 450px;">
                            <img src="{{$v->ad_code}}"
                                 style="transition: all .5s linear;width: 295px;height: 450px;"/>
                        </a>
                    @endif
                @endif
            @endforeach
        @endif
        <ul style="position: relative;">
            @if($ad125)
                @foreach($ad125 as $k=>$v)
                    @if($k<4)
                        <li @if($k<2) class="topimg1" @else class="topimg2" @endif>
                            <a href="{{$v->ad_link}}" target="_blank">
                                <img src="{{$v->ad_code}}" style="width: 280px;height: 220px;"/>
                            </a>
                        </li>
                    @endif
                @endforeach
            @endif
        </ul>

    </div>
</div>