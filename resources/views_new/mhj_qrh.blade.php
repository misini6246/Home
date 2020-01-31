<style>
    .invitation_box {
        width: 600px;
        position: fixed;
        top: 50%;
        left: 50%;
        margin: -205px 0 0 -300px;
        z-index: 1002;
    }

    .zhezhao {
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        z-index: 1001;
        background: #000;
        opacity: 0.4;
        filter: alpha(opacity=40);
        display: block;
        position: fixed;
    }
</style>
<div class="invitation_box">
    <table>
        <thead>
        <tr>
            <th>商品名称</th>
            <th>厂家</th>
            <th>规格</th>
            <th>总金额</th>
        </tr>
        </thead>
        <tbody>
        @foreach($mhj_dfqr as $v)
            <tr>
                <td>{{$v->goods_name}}</td>
                <td>{{$v->sccj}}</td>
                <td>{{$v->ypgg}}</td>
                <td>{{$v->goods_amount}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="zhezhao"></div>