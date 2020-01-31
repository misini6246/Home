<div class="right_title">
    <img src="/new_gwc/jiesuan_img/椭圆.png"/>
    <span>我的收藏</span>
    <ul>
        <a href="{{route('member.collection.index')}}">
            <li @if(empty($show_area))class="active"@endif>全部</li>
        </a>
        {{--<a href="{{route('member.collection.index',['show_area'=>2])}}">--}}
            {{--<li @if($show_area==2)class="active"@endif>精品专区</li>--}}
        {{--</a>--}}
        <a href="{{route('member.collection.index',['show_area'=>11])}}">
            <li @if($show_area==11)class="active"@endif>普药</li>
        </a>
        <a href="{{route('member.collection.index',['show_area'=>4])}}">
            <li @if($show_area==4)class="active"@endif>中药饮片</li>
        </a>
    </ul>
</div>
@if(count($result)>0)
    <form id="pl_buy" action="{{route('user.plBuy')}}" method="get">
        <table>
            <tr>
                <th class="input">
                    <input type="checkbox" class="quanxuan" onclick="quanxuan($(this),$('.danxuan'))"/>
                </th>
                <th class="spmc">
                    <label for="qx_1">全选</label>
                    <span>商品名称</span>
                </th>
                <th class="sccj">生产厂家</th>
                <th class="bzdw">包装单位</th>
                <th class="gg">规格</th>
                <th class="jg">价格</th>
                <th class="cgcs">采购次数</th>
                <th class="cz">操作</th>
            </tr>
            @foreach($result as $v)
                <tr>
                    <td><input name="ids[]" value="{{$v->goods_id}}" class="danxuan" type="checkbox"
                               onclick="danxuan($('.danxuan'),$('.quanxuan'))"/></td>
                    <td class="spmc">
                        <a target="_blank" href="{{$v->goods_url}}">
                            <img class="fly_img{{$v->goods_id}}" src="{{$v->goods_thumb}}"/>
                            <span title="{{$v->goods_name}}">{{str_limit($v->goods_name,24)}}</span>
                        </a>
                    </td>
                    <td>
                        <div class="sccj" title="{{$v->sccj}}">{{str_limit($v->sccj,28)}}</div>
                    </td>
                    <td class="bzdw">
                        {{$v->dw}}
                    </td>
                    <td>
                        <div class="gg" title="{{$v->ypgg}}">{{str_limit($v->ypgg,20)}}</div>
                    </td>
                    <td class="jg">{{formated_price($v->real_price)}}</td>
                    <td class="cgcs">{{$v->num}}次</td>
                    <td class="cz">
                        <input type="hidden" value="{{$v->zbz or 1}}" id="J_dgoods_num_{{$v->goods_id}}">
                        <img src="/new_gwc/img/gwc.png"
                             data-img="{{$v->goods_thumb}}"
                             class="jrgwc fly_to_cart{{$v->goods_id}}" onclick="tocart({{$v->goods_id}})">
                        <img src="/new_gwc/img/shanchu.png" class="shanchu"
                             onclick="del($(this))"
                             data-config='{"url":"{{route('member.collection.destroy',['id'=>$v->goods_id,'show_area'=>$show_area])}}","msg":"确定从收藏夹删除该商品?",
                          "method":"delete","dataType":"json","box":"sc1"}'/>
                    </td>
                </tr>
            @endforeach
        </table>
    </form>
    <div class="right_bottom">
        <input type="checkbox" class="quanxuan" onclick="quanxuan($(this),$('.danxuan'))"/><label for="qx_2">全选</label>
        <span class="jrgwc" onclick="pljr()">加入购物车</span>
        <span class="qxsc" onclick="plsc($(this))" id="plsc"
              data-config='{"url":"{{route('member.collection.destroy',['id'=>'','show_area'=>$show_area])}}","msg":"确定从收藏夹删除选中商品?",
                          "method":"delete","dataType":"json","box":"sc1"}'>取消收藏</span>
    </div>
    @include('user.pages',['pages'=>$result])
@else
    @include('user.empty',['type'=>1])
@endif
<script>
    var url = '{{route('member.collection.destroy',['id'=>'','show_area'=>$show_area])}}';
    $('input[type=checkbox]').click(function () {
        var str = '';
        $('.danxuan:checked').each(function () {
            str = str + $(this).val() + ',';
        });
        var config = $('#plsc').data('config');
        var new_url = url.replace('?', '/' + str + '?');
        config.url = new_url;
        console.log(config.url)
    })
</script>