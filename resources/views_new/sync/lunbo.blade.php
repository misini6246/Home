<ul class="banner-ctrl" style="width: {{count($ad121)*62}}px">
    @if($ad121)
        @foreach($ad121 as $k=>$ad)
            <li @if($k==0) class="current" @endif>
                <span class="bg"></span>
                <div class="ctrl-dot">
                    <i @if($k==0) class="on" @endif></i>
                </div>
                <div class="title-item">
                    <span class="title-bg"></span>
                    <div class="title-list">
                        <p><i></i></p>
                    </div>
                </div>
                <h4>{{str_replace('2017','',$ad->ad_name)}}</h4>
            </li>
        @endforeach
    @endif
</ul>
<a class="banner-btn banner-prev" href="javascript:void(0);"></a>
<a class="banner-btn banner-next" href="javascript:void(0);"></a>
<div class="banner-pic">
    @if($ad121)
        @foreach($ad121 as $k=>$ad)
            <ul>
                <li style="@if($k==0) display:list-item; @endif">
                    <a onClick="_hmt.push(['_trackEvent','首页焦点图1','浏览','{{str_replace('2017','',$ad->ad_name)}}'])"
                       href="{{$ad->ad_link}}" title="" target="_blank" style="position:relative;">
                        <img data-src="{{get_img_path('data/afficheimg/'.$ad->ad_code)}}"
                             src="{{get_img_path('data/afficheimg/'.$ad->ad_code)}}" height="480"
                             width="780" alt=" "/>
                        <!--<span class="addSign">
                            <img alt="" src="//static.jianke.com/home/front/images/ad_tag.png">
                        </span>-->
                    </a>
                </li>
            </ul>
        @endforeach
    @endif

</div>