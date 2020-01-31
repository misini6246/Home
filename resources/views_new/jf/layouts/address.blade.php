@foreach($address as $v)
    <li class="address @if($v->is_default==1) active @endif" id="address{{$v->id}}" onclick="set_default({{$v->id}})">
        <div class="username">
            <img src="{{get_img_path('images/jf/user_icon.png')}}"/>
            <span>{{$v->true_name}}</span>
        </div>
        <div class="user_phone">
            <img src="{{get_img_path('images/jf/phone_icon.png')}}"/>
            <span>{{$v->mob_phone}}</span>
        </div>
        <div class="user_add">
            <img src="{{get_img_path('images/jf/add_icon.png')}}"/>
            <span>{{$v->location}}{{$v->address}}</span>
        </div>
        <img src="{{get_img_path('images/jf/add_choose.png')}}" class="add_choose"/>
        <div class="moren">
            默认地址
        </div>
    </li>
    @if($v->is_default==1)
        <input type="hidden" name="address_id" value="{{$v->id}}">
    @endif
@endforeach
@if(count($address)<5)
    <li class="zengjia"
        onclick="load_html()">
        <div class="add_add">
            <img src="{{get_img_path('images/jf/add_add.jpg')}}"/>
            <span>新增收货地址</span>
        </div>
    </li>
@endif