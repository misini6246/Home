@if(($ad152))
    <!-- 顶部广告开始 -->
    <div class="top-wrap"
         style="background: url('{{$ad152->ad_code}}') no-repeat scroll center top;height: 100px;min-width: 1200px;">
        <div class="banner-box" style="height: 100px;">
            <a href="{{$ad152->ad_link}}" style="display:block;width:100%;height:100%" target="_blank"></a>
            {{--<span class="close-btns"></span>--}}
        </div>
    </div>
@endif