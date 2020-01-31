// 元素以及其他一些变量

var eleFlyElement = document.querySelector("#flyItem"), eleShopCart = document.querySelector(".mpbtn_wdsc2"),eleShopCart_1 = document.querySelector(".gouwuche");

var numberItem = 0;

// 抛物线运动

var myParabola = funParabola(eleFlyElement, eleShopCart, {

	speed:400, //抛物线速度

	curvature: 0.0008, //控制抛物线弧度

	complete: function() {

		eleFlyElement.style.visibility = "hidden";
		numberItem++;
		eleShopCart.querySelector("span").innerHTML = numberItem;
		eleShopCart_1.querySelector("span").innerHTML="("+numberItem+")"
	}

});

// 绑定点击事件

if (eleFlyElement && eleShopCart) {



	[].slice.call(document.getElementsByClassName("add_cart")).forEach(function(button) {

		button.addEventListener("click", function(event) {
			var imgsrc=$(this).parents('tr').find('.a_img').children('img').attr('src');
			$('#flyItem').children('img').attr('src',imgsrc);
			// 滚动大小
			var scrollLeft = document.documentElement.scrollLeft || document.body.scrollLeft || 0,

			    scrollTop = document.documentElement.scrollTop || document.body.scrollTop || 0;

			eleFlyElement.style.left = event.clientX + scrollLeft + "px";

			eleFlyElement.style.top = event.clientY + scrollTop + "px";

			eleFlyElement.style.visibility = "visible";



			// 需要重定位

			myParabola.position().move();

		});

	});

}