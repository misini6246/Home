$(function() {
	if((navigator.appName == "Microsoft Internet Explorer") && (document.documentMode < 10 || document.documentMode == undefined)) {
		var $placeholder = $("input[placeholder]");
		for(var i = 0; i < $placeholder.length; i++) {
			if($placeholder.eq(i).attr("type") == "password") {
				$placeholder.eq(i).siblings("label").text($placeholder.eq(i).attr("placeholder")).show()
			} else {
				$placeholder.eq(i).val($placeholder.eq(i).attr("placeholder")).css({
					"color": "#ccc"
				})
			}
		}
		$placeholder.focus(function() {
			if($(this).attr("type") == "password") {
				$(this).siblings("label").hide()
			} else {
				if($(this).val() == $(this).attr("placeholder")) {
					$(this).val("").css({
						"color": "#333"
					})
				}
			}
		}).blur(function() {
			if($(this).attr("type") == "password") {
				if($(this).val() == "") {
					$(this).siblings("label").text($(this).attr("placeholder")).show()
				}
			} else {
				if($(this).val() == "") {
					$(this).val($(this).attr("placeholder")).css({
						"color": "#ccc"
					})
				}
			}
		});
		$(".clone_input_text").focus(function() {
			$(this).siblings("label").hide()
		}).blur(function() {
			if($(this).val() == "") {
				$(this).siblings("label").text($(this).attr("placeholder")).show()
			}
		});
		$placeholder.siblings("label").click(function() {
			if($(this).parent("div").siblings(".see_pwd_btn").attr("data-flag") == "1") {
				$(this).hide().next("input").next("input").focus()
			} else {
				$(this).hide().next("input").focus()
			}
		})
	}
})