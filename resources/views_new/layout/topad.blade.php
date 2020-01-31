@if(($ad26))
    <!-- 顶部广告开始 -->
    <div class="top-wrap" style="background: url('{{$ad26->ad_code}}') no-repeat scroll center top;height: 100px;">
        <div class="banner-box" ><a href="{{$ad26->ad_link}}" style="display:block;width:100%;height:100%" target="_blank"></a>
            {{--<span class="close-btns"></span>--}}
        </div>
    </div>
@endif