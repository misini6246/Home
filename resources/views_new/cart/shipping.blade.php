<div class="add_wuliu_box">
    <div class="add_wuliu_box_ct">
        <div class="add_wuliu_box_ct_title">
            新增收货地址
        </div>
        <ul>
            @foreach($shipping as $k=>$v)
                @if($v->shipping_id==9)
                    <li style="width: 350px;">
                        <label>
                            <input type="radio" name="shipping_id" value="{{$v->shipping_id}}"/>
                            {{$v->shipping_name}}：
                        </label>
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
                    </li>
                @elseif($v->shipping_id==13)
                    <li style="width: 100%;">
                        <label>
                            <input type="radio" name="shipping_id" value="{{$v->shipping_id}}"/>
                            {{$v->shipping_name}}
                        </label>
                        <select name="kf_name" id="kf_name">
                            <option value='郫县库房'>郫县库房</option>
                        </select>
                    </li>
                @else
                    <li style="width: 320px;">
                        <label>
                            <input type="radio" name="shipping_id" value="{{$v->shipping_id}}"/>
                            {{$v->shipping_name}}
                        </label>
                    </li>
                @endif
            @endforeach
            <li style="width: 100%;">
                <label>
                    <input type="radio" name="shipping_id" value="-1"/>
                    其他物流
                </label>
                <div>
                    <input type="text" name="shipping_name" placeholder="填写物流名称">
                    <input type="text" name="wl_dh" id="" placeholder="填写物流电话"/>
                </div>
            </li>
        </ul>
        <div class="btn_box">
            <input type="button" name="" class="bc" value="保存" onclick="save_wl()"/><input type="button" name=""
                                                                                           class="qx"
                                                                                           value="取消"/>
        </div>
    </div>
</div>
<script>
    $(function(){
        console.log($('.add_wuliu_box'));

    })
    $('.add_shdz,.add_wuliu').on('click', function () {
        if ($(this).hasClass('add_shdz')) {
            $('.add_shdz_box').show();
        } else {
            $('.add_wuliu_box').show();
        }
        $('.qx').on('click', function () {
            $('.add_shdz_box,.add_wuliu_box').hide();
        })
    })

    function save_wl() {
        var flag = true;
        var shipping_id = $('input[name=shipping_id]:checked').val();
        var area_name = $('select[name=area_name]').val();
        var kf_name = $('select[name=kf_name]').val();
        var shipping_name = $('input[name=shipping_name]').val();
        var wl_dh = $('input[name=wl_dh]').val();
        if (shipping_id == '' || shipping_id == 0 || typeof(shipping_id) == 'undefined') {
            flag = false;
            layer.msg('请选择物流', {icon: 2});
            return false;
        }
        if (shipping_id == 9) {
            if (area_name == '') {
                layer.msg('请选择配送区域', {icon: 2});
                flag = false;
                return false;
            }
        }
        if (shipping_id == 13) {
            if (kf_name == '') {
                layer.msg('请选择自提库房', {icon: 2});
                flag = false;
                return false;
            }
        }
        if (shipping_id == -1) {
            if (shipping_name == '') {
                layer.msg('请填写物流名称', {icon: 2});
                flag = false;
                return false;
            }
            if (wl_dh == '') {
                flag = false;
                layer.msg('请填写物流电话', {icon: 2});
                return false;
            }
        }
        if (flag == true) {
            $.ajax({
                url: '/member/set_wl',
                data: {
                    shipping_id: shipping_id,
                    area_name: area_name,
                    kf_name: kf_name,
                    shipping_name: shipping_name,
                    wl_dh: wl_dh
                },
                dataType: 'json',
                success: function (data) {
                    if (data.error == 0 || data.error == 2) {
                        var html = '<div class="shdz_title">物流配送 </div><div class="shdz_box"><p class="express">配送物流：<span>' + data.shipping_name + '</span></p></div>';
                        $('input[name=shipping]').val(data.shipping_id);
                        $('.add_wuliu').html(html).removeClass('add_wuliu');
                        $('.add_wuliu_box').hide();
                        if (data.error == 2) {
                            data.error = -1;
                        }
                    }
                    layer.msg(data.msg, {icon: data.error + 1})
                }
            })
        }
    }
</script>