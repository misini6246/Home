@if($user_ad==1)
    <div class="content-right">

        <ul class="fn_clear">
            <li>
                <a target="_blank" href="/miaosha.html">
                    <img src="{{get_img_path('images/mc_033.jpg')}}">
                </a>
            </li>
            <li>
                <a target="_blank" href="@if(strtotime('2016-11-11 00:00:00')<time()){{route('category.index',['step'=>'promotion'])}}@else{{route('category.index',['step'=>'nextpro'])}}@endif">
                    <img src="{{get_img_path('images/mc_022.jpg')}}">
                </a>
            </li>
            <li>
                <a target="_blank" href="{{route('cj.jfdh')}}">
                    <img src="{{get_img_path('images/mc_011.jpg')}}">
                </a>
            </li>


        </ul>
    </div>
@else
    <div class="content-right">

        <ul class="fn_clear">
            <li>
                <a href="{{route('category.index',['dis'=>2,'showi'=>0])}}">
                    <img src="{{path('images/mc_01.png')}}">
                </a>
            </li>
            <li>
                <a href="{{url('cxzq')}}">
                    <img src="{{path('images/mc_02.png')}}">
                </a>
            </li>
            <li>
                <a href="{{route('category.index',['dis'=>3,'showi'=>0])}}">
                    <img src="{{path('images/mc_03.png')}}">
                </a>
            </li>


        </ul>
    </div>
@endif