<div class="footer container">
    <div class="container_box">
        <ul class="footer_list">
            <li>
                <a href="{{route('index')}}">药品采购</a>
            </li>
            <li>
                <a href="{{route('category.index',['dis'=>1,'py'=>1])}}">普药</a>
            </li>
            <li>
                <a href="{{route('category.index',['dis'=>2])}}">精品专区</a>
            </li>
            <li>
                <a href="{{route('ppzq.index')}}">品牌专区</a>
            </li>
            <li>
                <a href="/cxzq">促销专区</a>
            </li>
            <li>
                <a href="/zyyp">中药专区</a>
            </li>
            <li>
                <a href="{{route('xin.article.show',['id'=>68])}}">联系我们</a>
            </li>
            <li>
                <a href="/gsjj">公司简介</a>
            </li>
        </ul>
        <p>copyright © 2014-{{date('Y')}}
            <a href="{{route('index')}}">{{config('services.web.name')}}</a> 版权所有 蜀ICP备14007234号-1</p>
        <p>本网站未发布毒性药品、麻醉药品、精神药品、放射性药品、戒毒药品和医疗机构制剂的产品信息</p>
    </div>
</div>