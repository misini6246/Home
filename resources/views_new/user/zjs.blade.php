<li id="shipping{{$v->shipping_id}}" onclick="choose_shipping('{{$v->shipping_id}}')">
    <p class="name">{{$v->shipping_name}}</p>
    <div class="xx">可查询物流信息</div>
    <div class="choose_box"><img class="select_wl"
                                 src="{{get_img_path('images/user/select.png')}}">
    </div>
</li>