@if(isset($ad201)&&isset($ad202)&&isset($ad203))
    <style type="text/css">
        #ppzq {
            height: 360px;
            margin-top: 20px;
        }

        #ppzq .box1,
        #ppzq .box2,
        #ppzq .box3 {
            float: left;
            margin-left: 10px;
            position: relative;
        }

        #ppzq .btn {
            width: 100px;
            height: 40px;
            position: absolute;
            top: 0px;
            right: 0px;
            cursor: pointer;
        }

        #ppzq .box1 {
            width: 580px;
            margin-left: 0px;
        }

        #ppzq .content {
            width: 100%;
            height: 320px;
            box-sizing: border-box;
            border: 1px solid #E5E5E5;
            padding: 9px;
        }

        #ppzq .box2,
        #ppzq .box3 {
            width: 300px;
        }

        #ppzq .title {
            display: block;
            width: 100%;
            height: 40px;
        }
    </style>
    <div id="ppzq" class="container">
        <div class="container_box">
            <div class="box1">
                <img class="title" src="{{get_img_path('adimages1/201807/ppzq1.jpg')}}"/>
                <a target="_blank" href="{{route('ppzq.new')}}">
                    <div class="btn"></div>
                </a>
                <div class="content">
                    <div id="carousel" class="carousel">
                        <ul class="carousel_img">
                            @foreach($ad201 as $k=>$ad)
                                <li @if($k==0) class="cur" @endif>
                                    <a target="_blank" href="{{$ad->ad_link}}"><img src="{{$ad->ad_code}}"/>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        <ul class="carousel_nav">
                            @foreach($ad201 as $k=>$ad)
                                <li @if($k==0) class="cur"
                                    @endif>{{str_replace('2018','',$ad->ad_name)}}</li>
                            @endforeach
                        </ul>
                    </div>
                    <script type="text/javascript">
                        $('#carousel').carousel({
                            animation: "x",//x左右 y上下 d淡入淡出
                            time: "3000",
                            g: '{{boolval(count($ad201)-1)}}'//是否自动轮播
                        })
                    </script>
                </div>
            </div>
            <div class="box2">
                <img class="title" src="{{get_img_path('adimages1/201807/jpzq1.jpg')}}"/>
                <a target="_blank" href="{{route('category.index',['dis'=>2])}}">
                    <div class="btn"></div>
                </a>
                <div class="content">
                    @foreach($ad202 as $k=>$ad)
                        @if($k==0)
                            <a target="_blank" href="{{$ad->ad_link}}"><img src="{{$ad->ad_code}}"/></a>
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="box3">
                <img class="title" src="{{get_img_path('adimages1/201807/zszq.jpg')}}"/>
                <a target="_blank" href="{{route('zs.index')}}">
                    <div class="btn"></div>
                </a>
                <div class="content">
                    @foreach($ad203 as $k=>$ad)
                        @if($k==0)
                            <a target="_blank" href="{{$ad->ad_link}}"><img src="{{$ad->ad_code}}"/></a>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endif