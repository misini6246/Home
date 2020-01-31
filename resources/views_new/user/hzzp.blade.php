<li id="shipping{{$v->shipping_id}}" onclick="choose_shipping('{{$v->shipping_id}}')">
    <p class="name">{{$v->shipping_name}}</p>
    <div class="xx">
        <select name="area_name">
            <option value="">选择配送区域</option>
            <option value='都江堰'>都江堰</option>
            <option value='邛崃'>邛崃</option>
            <option value='金堂'>金堂</option>
            <option value='双流'>双流</option>
            <option value='简阳'>简阳</option>
            <option value='郫县'>郫县</option>

            <option value='新津'>新津</option>

            <option value='仁寿'>仁寿</option>
            <option value='新都'>新都</option>
            <option value='彭州'>彭州</option>
            <option value='什邡'>什邡</option>
            <option value='绵阳'>绵阳</option>
            <option value='德阳'>德阳</option>
            <option value='温江'>温江</option>
            <option value='宜宾'>宜宾</option>
            <option value='乐山'>乐山</option>
            <option value='中江'>中江</option>
            <option value='龙泉'>龙泉</option>
            <option value='崇州'>崇州</option>
            <option value='大邑'>大邑</option>
            <option value='蒲江'>蒲江</option>
            <option value='内江'>内江</option>
            <option value='巴中'>巴中</option>
        </select>
    </div>
    <div class="choose_box"><img class="select_wl" src="{{get_img_path('images/user/select.png')}}"></div>
</li>