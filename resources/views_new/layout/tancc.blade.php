<div class="comfirm_buy" style="display:none;" id="shopping_box">
    <div class="content_buy" ><a href="#" class="success"></a>
        <h4 class="tip_text">&nbsp;</h4>
        <p class="tip_txt" alt="" title="">&nbsp;</p>

        <p class="login_p tab_p1" style="display: none;">
            <a class="login_a again" >继续购物</a> <a href="/cart">去结算 ></a>
        </p>

        <p class="login_p tab_p2" style="display: none;">
            <a href="/auth/login" class="login_a" >登录</a> <a href="/auth/register">注册</a>
        </p>

        <p class="login_p tab_p3" style="display: none;">
            <a href="requirement.php" class="login_a" >去登记</a> <a class="login_a again">取消</a>
        </p>

        <p class="login_p tab_p4" style="display: none;">
            <a class="login_a confirm again">确认</a>
        </p>

        <p class="login_p tab_p5" style="display: none;">
            <a href="#" class="login_a confirm">确认</a>
        </p>

        <span class="close2"></span>
    </div>
</div>
<script>
    $(function(){
        $('.close2').click(function(){
            $('.comfirm_buy').hide();
        });
        $('.login_a').click(function(){
            $('.comfirm_buy').hide();
        });
    });

</script>