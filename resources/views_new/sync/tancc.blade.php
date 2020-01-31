@if($ad27)
    <!-- 弹出层开始 -->
    <div class="zzsc" style="display: block;z-index: 999999;">
        <div class="content_tj"><a href="{{$ad27->ad_link}}" target="_blank"><img
                        src="{{get_img_path('data/afficheimg/'.$ad27->ad_code)}}" class="ad"></a>
            <span class="close" onclick="close_tcc()"><img
                        src="{{path('/images/close.png')}}" alt=""></span>
        </div>
    </div>

    <div class="content_mark" style="display: block;z-index: 999990"></div>
    <script>
        function close_tcc() {
            $('.zzsc').hide();
            $('.content_mark').hide();
        }
    </script>
@endif