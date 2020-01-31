

$(function () {
	$('.check_box').click(function(){
		$('#remember')[0].checked = !$('#remember')[0].checked;
		if($('#remember')[0].checked){
			$(this).html("&radic;")
		}else{
			$(this).html("")
		}
	})

    $(".login").click(function(){

        goLogin();

    });



    $(document).keydown(function(e){

        if(e.keyCode == 13) {

            goLogin()
        }

    });



    $("input[name=user_name]").focus(function () {

        $(this).parent().find(".prompt2").hide() ;

        $(".codes2").hide();

        $(this).css("color","#333");

        $(this).parents(".input-box").addClass("border-color-blue");

    });





    $("input[name=password]").focus(function () {

        $(".prompt2").hide() ;

        $(".codes").hide();

        $(this).css("color","#333");

        $(this).parents(".input-box").addClass("border-color-blue");

    })

    $("input[name=user_name]").blur(function () {

        if($(this).val()==""){

            $(".codes2").show();


        }
        if($(this).val()!=""){



            $(this).parents(".input-box").removeClass("border-color-red");


        }

        $(this).parents(".input-box").removeClass("border-color-blue");








    });



    $("input[name=password]").blur(function () {


        if($(this).val()==""){

            $(".codes").show();


        }

        if($(this).val()!=""){

            $(this).parents(".input-box").removeClass("border-color-red");

        }

        $(this).parents(".input-box").removeClass("border-color-blue");






    })





});



function goLogin(){

    var username   = $(".username").val(),

        password   = $(".password").val();

    if(username==""){
        $(".username").parent().next().show();
        $(".username").parents(".input-box").addClass("border-color-red");


    } else if(password==""){

        $(".password").parent().next().show();
        $(".password").parents(".input-box").addClass("border-color-red");


    }

    else {

        $(".username").parent().next().hide();
        $(".password").parent().next().hide();

        var act       = $(".act").val();

        var back_act  = $(".back_act").val();

        var remember  = $("#remember").val();

        var url		  = "/auth/login";

        $.ajax({
            headers: {

                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')

            },
            url: url,

            type: 'post',

            dataType: 'JSON',

            data: {

                act: act ,

                user_name:username,

                password:password,

                back_act:back_act,

                remember:remember

            },

            success:function(msg){
                if(msg.error==0){

                    location.href = msg.back;

                }

                if(msg.error==1){
                    alert(msg.message)
                    $(".prompt2").eq(1).show().html(msg.message);

                }

            }

        });

    }



    $("input[type=text]").blur();

}