@if($id==12)
    <div class="choujiang_result_box">
        <div class="choujiang_result">
            <p class="lx">抽中<span>1000积分</span></p>
            <p class="txt">*此积分已冲入积分账户</p>
            <p class="number">中奖编号：{{$bm}}</p>
        </div>
    </div>
@elseif($id==13)
    <div class="choujiang_result_box">
        <div class="choujiang_result">
            <p class="lx">抽中<span>9折</span>大奖</p>
            <p class="txt">*此订单将享受9折优惠</p>
            <p class="number">中奖编号：{{$bm}}</p>
        </div>
    </div>
@elseif($id==14)
    <div class="choujiang_result_box">
        <div class="choujiang_result">
            <p class="lx">抽中<span>8折</span>大奖</p>
            <p class="txt">*此订单将享受8折优惠</p>
            <p class="number">中奖编号：{{$bm}}</p>
        </div>
    </div>
@elseif($id==15)
    <div class="choujiang_result_box">
        <div class="choujiang_result">
            <p class="lx">抽中<span>7折</span>大奖</p>
            <p class="txt">*此订单将享受7折优惠</p>
            <p class="number">中奖编号：{{$bm}}</p>
        </div>
    </div>
@elseif($id==16)
    <div class="choujiang_result_box">
        <div class="choujiang_result">
            <p class="lx">抽中<span>免单</span>大奖</p>
            <p class="txt">*此订单将享受免单优惠</p>
            <p class="number">中奖编号：{{$bm}}</p>
        </div>
    </div>
@endif