<div class="comfirm_buy" style="display:none;" id="shopping_box">
    <div class="content_buy" ><a href="#" class="success"></a>
        <h4>&nbsp;</h4>
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
<script type="text/javascript">
    function add_num(id){
        var gn = parseInt($('#gn_'+id).val());
        var yl = parseInt($('#yl_'+id).val());
        var isYl = parseInt($('#isYl_'+id).val());
        var lsgg = parseInt($('#lsgg_'+id).val());
        var zbz = parseInt($('#zbz_'+id).val());
        var jzl = parseInt($('#jzl_'+id).val());
        var num = parseInt($('#J_dgoods_num_'+id).val());
        //console.log(gn,yl,isYl,lsgg,zbz,jzl,num);
        num = num + zbz;
        if(jzl){//件装量存在
            if((num%jzl)/jzl>=0.8){//购买数量达到件装量80%
                alert('温馨提示：你所选择的数量已接近件装量，为避免拆零引起的运输破损，系统自动调为整件。')
                num = Math.ceil(num/jzl)*jzl;
            }
        }

        if(num%zbz!=0){//不为中包装整数倍
            num = num - num%zbz + zbz;
        }

        if(isYl>0&&num>isYl&&yl==1){//商品限购
            num = isYl;
        }

        if(num>gn&&gn>0){
//            alert('库存不足');
//            return false;
            num = gn;
        }
        $('#J_dgoods_num_'+id).val(num);
    }

    function reduce_num(id){
        var gn = parseInt($('#gn_'+id).val());
        var yl = parseInt($('#yl_'+id).val());
        var isYl = parseInt($('#isYl_'+id).val());
        var lsgg = parseInt($('#lsgg_'+id).val());
        var zbz = parseInt($('#zbz_'+id).val());
        var jzl = parseInt($('#jzl_'+id).val());
        var num = parseInt($('#J_dgoods_num_'+id).val());
        num = num - zbz;
        if(jzl){//件装量存在
            if((num%jzl)/jzl>=0.8&&(num%jzl)/jzl<=1){//购买数量达到件装量80%
                num = num - num%jzl + parseInt(jzl*0.8);
            }
        }

        if(num%zbz!=0){//不为中包装整数倍
            num = num - num%zbz;
        }

        if(isYl>0&&num>isYl&&yl==1){//商品限购
            num = isYl;
        }

        if(num<1){
            num = zbz;
        }
        $('#J_dgoods_num_'+id).val(num);
    }

    function changePrice(id){
        var gn = parseInt($('#gn_'+id).val());
        var yl = parseInt($('#yl_'+id).val());
        var isYl = parseInt($('#isYl_'+id).val());
        var lsgg = parseInt($('#lsgg_'+id).val());
        var zbz = parseInt($('#zbz_'+id).val());
        var jzl = parseInt($('#jzl_'+id).val());
        var num = parseInt($('#J_dgoods_num_'+id).val());
        if(num<0){
            alert('请输入正确的数量');
            $('#J_dgoods_num_'+id).val(0-zbz);
            return false;
        }
        var old = num;

        if(num%zbz!=0){//不为中包装整数倍
            num = num - num%zbz + zbz;
        }

        if(jzl){//件装量存在
            if((num%jzl)/jzl>=0.8&&(num%jzl)/jzl<=1){//购买数量达到件装量80%
                alert('温馨提示：你所选择的数量已接近件装量，为避免拆零引起的运输破损，系统自动调为整件。')
                num = Math.ceil(num/jzl)*jzl;
//                if(num>gn){
//                    alert('库存不足');
//                    num = old - old%jzl + parseInt(jzl*0.8) - zbz;
//                }
            }
        }

        if(isYl>0&&num>isYl&&yl==1){//商品限购
            num = isYl;
        }

        if(num>gn&&gn>0){
//            alert('库存不足');
//            $('#J_dgoods_num_'+id).val(zbz);
//            return false;
            num = gn;
        }
        $('#J_dgoods_num_'+id).val(num);
    }

    function tocart(id){
        var num = $('#J_dgoods_num_'+id).val();
        addToCart1(id,num);
    }
</script>
<script>
    $(function(){

        $(".table2 tr td  .t-tip").hover(function(){



            $(this).find(".tip_span").show();


        },function(){

            $(this).find(".tip_span").hide();

        })


    })

</script>