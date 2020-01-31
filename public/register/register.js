$(function () {

    var username   = $(".username"),
        password   = $(".password"),
        email      = $(".email"),
        sure_pass  = $(".sure_pass"),
        real_name  = $(".real_name"),
        enterprise = $(".enterprise"),
        qq         = $(".qq"),
        phone      = $(".phone"),
        safe_level = $(".safe_level"),
        city       = $("#city"),
        country    = $("#country"),
        province   = $("#province"),
        psw2       =$(".psw2"),
        psw3       =$(".psw3");
    function testNull(e) {

        return $(e).val() == "";
    }

	$('.input-com').focus(function(){
		$(this).siblings('.prompt2').hide()
	}).blur(function(){
		if($(this).val() == ''){
			$(this).siblings('.prompt2').show()
		}
	})

    country.on("change",function(){


        if($(this).val()==$(this).find("option:first").text()){


            province.val("请选择");


            city.val("请选择");


        }else{


            //查询省份


        }


    });


    province.on("change",function(){


        if($(this).val()==$(this).find("option:first").text()){


            city.val("请选择");


        }else{


            //查询城市


        }


    });


    username.focusout(function(){testUsername($(this))});


    password.focusout(function(){testPassword($(this))});


    password.keyup(function(){testPassSafe($(this))});


    email.focusout(function(){testEmail($(this))});


    sure_pass.focusout(function(){testSurePass($(this))});


    enterprise.focusout(function(){testEnterprise($(this))});


    qq.focusout(function(){testQQ($(this))});


    phone.focusout(function(){testPhone($(this))});





    function testUsername($this) {//验证用户名


        $this.val($.trim($this.val()));


        //alert($.trim($this.val()));


        if (testNull($this.val())) {


            $this.next(".prompt").addClass("prompt-bg").removeClass('prompt-bg2').html("请输入用户名");


            $this.next(".prompt").css("color", "#fa5403");


            return false;


        }



        // else if (!(/^[\d\D]{2,30}$/.test($this.val()))) {
        else if ($this.val().length<=2 || $this.val().length>=30) {

            $this.next(".prompt").addClass("prompt-bg").removeClass('prompt-bg2').html("用户名只能是2到30个字符！");

            $this.next(".prompt").css("color", "#fa5403");


            return false;


        } else {


            //查询用户名是否被注册


            var is=false;


            $.ajax({
                type: "post",
                url: "/reg/reg_check",
                async: false,
                data: {
                    act: "is_name",
                    id: $this.val()
                },
                headers: {

                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')

                },
                success: function(m){


                    if(m==1){

                        $this.next(".prompt").removeClass("prompt-bg").addClass("prompt-bg2").html("　");


                        is=true;



                    }else{

                        $this.next(".prompt").addClass("prompt-bg").removeClass('prompt-bg2').html("该用户名已被注册！");


                        $this.next(".prompt").css("color", "#fa5403");



                    }


                }


            });


            return is;


        }


    }





    function testPassword($this) {//验证密码


        if (testNull($this)) {


            $this.next(".prompt").addClass("prompt-bg").removeClass('prompt-bg2').html("请输入密码");


            $this.next(".prompt").css("color", "#fa5403");


            return false;


        } else if (/^[A-Za-z0-9_]{0,5}$/.test($this.val())) {


            $this.next(".prompt").addClass("prompt-bg").removeClass('prompt-bg2').html("密码不能少于6位");


            $this.next(".prompt").css("color", "#fa5403");


            return false;





        } else if (/^[A-Za-z0-9_]{25,}$/.test($this.val())) {


            $this.next(".prompt").addClass("prompt-bg").removeClass('prompt-bg2').html("密码不能超过24位");


            $this.next(".prompt").css("color", "#fa5403");


            return false;


        } else if (!(/^[A-Za-z0-9_]{6,24}$/.test($this.val()))) {


            $this.next(".prompt").addClass("prompt-bg").removeClass('prompt-bg2').html("请输入6-24位英文、数字、\"_\"的组合字符");


            $this.next(".prompt").css("color", "#fa5403");


            return false;





        } else if ($this.val() == sure_pass.val() && sure_pass.val() != "") {


            $this.next(".prompt").removeClass("prompt-bg").addClass("prompt-bg2").html("　");

            return true;


        } else {

            $this.next(".prompt").removeClass("prompt-bg").addClass("prompt-bg2").html("　");

            return true;


        }


        if($this.val() != sure_pass.val() && sure_pass.val() != ""){


            sure_pass.next(".prompt").addClass("prompt-bg").removeClass('prompt-bg2').html("确认密码与密码不一致！");


            sure_pass.next(".prompt").css("color", "#fa5403");


            return false;


        }


    }





    function testPassSafe($this) {//密码强度


        if (/^[A-Za-z]{0,24}$|^[0-9]{0,24}$|^[_]{0,24}$/.test($this.val())) {//?


            safe_level.css("background-color", "#ccc");


            safe_level.eq(0).css("background-color", "#ff3f3f");


        } else if (/^[a-zA-Z0-9_]{6,16}$/.test($this.val())) {


            safe_level.css("background-color", "#ccc");


            safe_level.eq(2).prevAll("span").css("background-color", "orange");


        }


        if (/[A-Za-z0-9_]{17,24}$/.test($this.val())) {


            safe_level.css("background-color", "#ccc");


            safe_level.css("background-color", "#00b950");


        }


    }





    function testEmail($this) {//验证电子邮箱

        $this.next(".prompt").removeClass('prompt-bg2');
        if (testNull($this)) {


            $this.next(".prompt").addClass("prompt-bg").removeClass('prompt-bg2').html("请输入电子邮箱");


            $this.next(".prompt").css("color", "#fa5403");


            return false;





        } else if (!(/^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/.test($this.val()))) {


            $this.next(".prompt").addClass("prompt-bg").removeClass('prompt-bg2').html("电子邮箱格式不正确！");


            $this.next(".prompt").css("color", "#fa5403");


            return false;





        } else {
            var is=false;
            var email = $this.val();
            $.ajax({
                type: "post",
                url: "/reg/reg_check",
                async: false,
                data: {id:email,act:'is_email'},
                headers: {

                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')

                },
                success: function(m){
                    if(m == 1){
                        $this.next(".prompt").removeClass("prompt-bg").addClass("prompt-bg2").html("　");
                        is=true;
                    }else{
                        $this.next(".prompt").addClass("prompt-bg").removeClass('prompt-bg2').html("该邮箱已注册！");


                        $this.next(".prompt").css("color", "#fa5403");
                    }
                }
            });
            return is;

        }


    }





    function  testSurePass($this) {//验证确认密码


        if (testNull($this)) {


            $this.next(".prompt").addClass("prompt-bg").removeClass('prompt-bg2').html("确认密码不能为空！");


            $this.next(".prompt").css("color", "#fa5403");


            return false;


        }else if ($this.val() != password.val()) {


            $this.next(".prompt").addClass("prompt-bg").removeClass('prompt-bg2').html("确认密码与密码不一致！");


            $this.next(".prompt").css("color", "#fa5403");


            return false;


        } else {

            $this.next(".prompt").removeClass("prompt-bg").addClass("prompt-bg2").html("　");


            return true;


        }


    }





    function testEnterprise($this) {//验证企业


        if (testNull($this)) {


            $this.next(".prompt").addClass("prompt-bg").removeClass('prompt-bg2').html("请输入企业名称");


            $this.next(".prompt").css("color", "#fa5403");


            return false;





        } else {


            //查询企业名称是否已存在


            var is=false;


            var msn = $this.val();


            $.ajax({


                type: "post",
                url: "/reg/reg_check",
                async: false,
                data: {id:msn,act:'is_msn'},
                headers: {

                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')

                },
                success: function(m){

                    if(m==1){


                        $this.next(".prompt").removeClass("prompt-bg").addClass("prompt-bg2").html("");


                        is=true;


                    }else{


                        $this.next(".prompt").addClass("prompt-bg").removeClass('prompt-bg2').html("企业名称已存在！");


                        $this.next(".prompt").css("color", "#fa5403");


                    }


                }


            });


            return is;


        }


    }





    function testQQ($this) {//验证qq


        if ($this.val() != "") {


            if (!(/^[1-9][0-9]{4,11}$/.test($this.val()))) {


                $this.next(".prompt").addClass("prompt-bg").removeClass('prompt-bg2').html("请输入正确的QQ");


                $this.next(".prompt").css("color", "#fa5403");


                return false;


            } else {


                //查询QQ是否已存在


                var is=false;


                $.ajax({


                    type: "post",
                    url: "/reg/reg_check",
                    async: false,
                    data: {id:$this.val(),act:'is_qq'},
                    headers: {

                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')

                    },

                    success: function(m){


                        if(m==1){


                            $this.next(".prompt").removeClass("prompt-bg").addClass("prompt-bg2").html("");


                            is=true;


                        }else{


                            $this.next(".prompt").addClass("prompt-bg").removeClass('prompt-bg2').html("该QQ已注册！");


                            $this.next(".prompt").css("color", "#fa5403");


                        }


                    }


                });


                return is;


            }


        }else{


            $this.next(".prompt").addClass("prompt-bg").removeClass('prompt-bg2').html("QQ不能为空！");


            $this.next(".prompt").css("color", "#fa5403");


            return false;


        }


    }





    function testPhone($this) {//验证电话


        if (testNull($this)) {


            $this.next(".prompt").addClass("prompt-bg").removeClass('prompt-bg2').html("请输入电话号码");


            $this.next(".prompt").css("color", "#fa5403");


            return false;





        } else if ($this.val() != "") {


            var isPhone = /^([0-9]{3,4}-)?[0-9]{7,8}$/;


            var isMob=/^((\+?86)|(\(\+86\)))?(13[012356789][0-9]{8}|15[012356789][0-9]{8}|18[0123456789][0-9]{8}|199[0-9]{8}|147[0-9]{8}|134[0-9]{8}|17[0-9]{9})$/;





            if (!(isPhone.test($this.val()) || isMob.test($this.val()))) {


                $this.next(".prompt").addClass("prompt-bg").removeClass('prompt-bg2').html("请输入正确的电话号码！");


                $this.next(".prompt").css("color", "#fa5403");


                return false;


            } else {


                //查询电话是否已存在


                var is=false;


                $.ajax({


                    type: "post",
                    url: "/reg/reg_check",
                    async: false,
                    data: {act:'is_tel',id:$this.val()},
                    headers: {

                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')

                    },

                    success: function(m){


                        if(m==1){


                            $this.next(".prompt").removeClass("prompt-bg").addClass("prompt-bg2").html("");

                            is=true;


                        }else{


                            $this.next(".prompt").addClass("prompt-bg").removeClass('prompt-bg2').html("该电话已注册！");


                            $this.next(".prompt").css("color", "#fa5403");


                        }


                    }


                });


                return is;


            }


        } else {


            $this.next(".prompt").html("");


            return true;


        }


    }








    // 重置密码


    psw2.focusout(function(){testPassword($(this))});


    psw3.focusout(function(){testSurePass2($(this))});





    function  testSurePass2($this) {//验证确认密码


        if (testNull($this)) {


            $this.next(".prompt").html("·确认密码不能为空！");


            $this.next(".prompt").css("color", "#fa5403");


            return false;


        }else if ($this.val() != psw2.val()) {


            $this.next(".prompt").html("·确认密码与密码不一致！");



            return false;


        } else {

            $this.next(".prompt").removeClass("prompt-bg").addClass("prompt-bg2").html("");


            return true;


        }


    }











    $(".psw_btn").click(function () {


        if( testPassword(psw2)==false||testSurePass2(psw3)==false){return false;} else{return true;}


    });





    function test_address(){


        var span=$(".choose_address .select_choose span");


//        验证所在地区下拉框


        var select1=parseInt(span.eq(0).attr("data-id"))!=0;


        var select2=parseInt(span.eq(1).attr("data-id"))!=0;


        var select3=parseInt(span.eq(2).attr("data-id"))!=0;





        //end


        if(select1&&select2&&select3){


            $(".choose_address .prompt").text("*");


            $(".choose_address .prompt").css("color", "#fa5403");


            return true


        }else{


            $(".choose_address .prompt").css("color", "#fa5403");


            $(".choose_address .prompt").text("·请完整选择所在地区！");


            return false;


        }


    }





    //地址在这里第一个参数改


    $(".province .select_options li").live("mouseup",function(){select_area("/reg/reg_check",$(this),".city");return false});


    $(".city .select_options li").live("mouseup",function(){select_area("/reg/reg_check",$(this),".district");return false});


    /**


     *


     * @param url   请求地址


     * @param e     当前操作的节点


     * @param where 结果添加的地方（父元素），格式：jquery选择器


     */


    function select_area(url,e,where){


        var id=parseInt(e.attr("data-id"));


        if(id){


            $.ajax({
                type:"post",
                url:url,
                data:{id:id,act:'select_area'},
                headers: {

                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')

                },
                success:function(msg){


                var html="<li data-id='0' style='border: 0'>请选择";


                html += msg ;


                $(where+" .select_options").html(html);


            }})


        } else {


            if(where == '.city') {


                $('.city .select_choose', '.distrct .select_choose').html("<li data-id='0'>请选择") ;


                $('.city .select_choose', '.distrct .select_choose').html("<li data-id='0' style='border: 0'>请选择") ;


            } else if(where == '.district') {


                $('.distrct .select_choose').html("<li data-id='0'>请选择") ;


                $('.distrct .select_choose').html("<li data-id='0' style='border: 0'>请选择") ;


            }


        }


    }





    //阻止冒泡


    function stopPropagation(e) {


        e = e || window.event;


        if(e.stopPropagation) { //W3C阻止冒泡方法


            e.stopPropagation();


        } else {


            e.cancelBubble = true; //IE阻止冒泡方法


        }


    }





    $(".select_choose").click(function(e){


        // alert();


        stopPropagation(e);//阻止冒泡但是允许默认事件的发生


        if($(this).next().find("li").length>0){


            $(this).next(".select_options").slideDown(150);


        }


        if($(this).next().height()<300){


            //$(this).next().css({"overflow": "hidden"});


        }else{


            $(this).next().css({"overflow": "scroll"});


        }
        $(this).siblings('.select_options').css('overflow','auto');

    });


    $(".select_options li").live({"mouseover":function(){


        $(this).css({backgroundColor: "#ddd"});


    },"mouseout":function(){


        $(this).css({background: "none"});


    }});


    $(".select_options li").live("click",function(){


        var span=$(this).parent().prev().find("span");


        span.text($(this).text());


        span.attr("data-id",$(this).attr("data-id"));


        var next=$(this).parent().parent().nextAll(".choose_select");


        $(this).parent().slideUp(100);





        next.find(".select_choose span").attr("data-id",0);


        next.find(".select_choose span").html("请选择");


        next.find("ul").html("");





        return false;


    });


    $(":not(.select_choose)").click(function(){


        $(".select .select_options").slideUp(100);


    });




    /*邮箱提示*/


    email.keydown(function(e){//禁止按空格


        if(e.keyCode==32)return false;


    });


    email.keyup(function(){


        var cemail=$(".cemail");


        var val=$(this).val();


        var html="";


        var arr= ["@qq.com","@163.com","@126.com","@sohu.com","@sina.com","@hotmail.com","@gmail.com","@foxmail.com","@139.com","@189.cn"];


        var reg=new RegExp("@");


        for(var i=0;i<arr.length;i++){


            html+="<li>"+val+arr[i]+"</li>";


        }


        if(/(^[\u2E80-\u9FFF]+$)|@/.test(val)){


            cemail.css({display: "none"});


        }else{


            cemail.find("ul").html(html);


            cemail.css({display: "block"});


        }


    });


    $(".cemail ul").on("click","li",function(){


        email.val($(this).text());

        testEmail(email);
        $(".cemail").css({display: "none"});


    });


    $(".cemail ul").on("mouseover","li",function(){


        $(this).addClass("hover");


    });


    $(".cemail ul").on("mouseout","li",function(){


        $(this).removeClass("hover");


    });


    $("body:not(.cemail)").click(function(){


        $(".cemail").css({display: "none"});


    });


    $(".input_box input").focus(function(){

        $(this).addClass("border-blue");
    })

    $(".input_box input").blur(function(){

        $(this).removeClass("border-blue");
    })



    //2015-6-10


    $("input[type=radio]").click(function () {


        $(this).attr("checked" ,"checked").siblings().attr("checked",false);


    });
    /*end*/


    $("#submit").click(function (e) {//点击注册


        if ($(".agree input").attr("checked")) {


            $(".input_box input").trigger("focusout");





            var username=$("input[name='user_name']");
            var password=$("input[name='password']");
            var sure_pass=$("input[name='password_confirmation']");
            var email=$("input[name='email']");
            var enterprise=$("input[name='msn']");
            var qq=$("input[name='qq']");
            var phone=$("input[name='mobile_phone']");





            var mark=testUsername(username)&&


                testPassword(password)&&


                // testEmail(email)&&


                testSurePass(sure_pass)&&


                testEnterprise(enterprise)&&


                // testQQ(qq)&&


                testPhone(phone) &&


                test_address();

            if (mark) {


                $('#province').val(parseInt($(".select_choose span").eq(0).attr("data-id")));
                $('#city').val(parseInt($(".select_choose span").eq(1).attr("data-id")));
                $('#district').val(parseInt($(".select_choose span").eq(2).attr("data-id")));

                $('#register').submit();

            }


        }else{

            alert("你还没有接受用户协议！");
        }


    });





});





