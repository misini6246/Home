<div class="genzong">
    <img src="{{get_img_path('images/user/sanjiao.png')}}" class="sanjiao"/>
    <div class="wuliu">
        @if($info->ddgz->get('end'))
            <div class="end"
                 @if(count($info->ddgz)==1) style="border-left: none;" @endif>
                @if(count($info->ddgz)==1)
                    <img src="/user/img/wl_green.png"
                         class="icon"/>
                @elseif($info->ddgz->get('end')['step']==2)
                    <img src="/user/img/wl_qx.png"
                         class="icon"/>
                @else
                    <img src="/user/img/zhuizong_2.png"
                         class="icon"/>
                @endif
                <div class="xx"
                     @if(count($info->ddgz)==1) style="border-bottom: none;" @endif>
                    <div class="time">{{$info->ddgz->get('end')['time']}}</div>
                    <div class="xiangqing">
                        <div class="zhuangtai">【{{$info->ddgz->get('end')['title']}}
                            】
                        </div>
                        {{$info->ddgz->get('end')['content']}}
                    </div>
                </div>
            </div>
        @endif
        @if(count($info->ddgz)>=3)
            <ul>
                @if(count($info->ddgz)>=5)
                    <div class="gengduo">
                        <img src="/user/img/zhuizong_dian.png"
                             class="icon"/>
                        查看全部……
                    </div>
                @endif
                @foreach($info->ddgz as $key=>$ddgz)
                    @if(!in_array((string)$key,['start','end']))
                        <li @if(count($info->ddgz)<5) style="display: block !important;" @endif>
                            <img src="/user/img/zhuizong_dian.png"
                                 class="icon"/>
                            <div class="xx">
                                <div class="time">{{$ddgz['time']}}</div>
                                <div class="xiangqing">
                                    <div class="zhuangtai">【{{$ddgz['title']}}】</div>
                                    {{$ddgz['content']}}
                                </div>
                            </div>
                        </li>
                    @endif
                @endforeach
            </ul>
        @endif
        @if($info->ddgz->get('start'))
            <div class="start">
                <img src="/user/img/zhuizong_2.png"
                     class="icon"/>
                <div class="xx">
                    <div class="time">{{$info->ddgz->get('start')['time']}}</div>
                    <div class="xiangqing">
                        <div class="zhuangtai">【{{$info->ddgz->get('start')['title']}}
                            】
                        </div>
                        {{$info->ddgz->get('start')['content']}}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>