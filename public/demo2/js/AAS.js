//加减
;
(function($) {
	$.fn.extend({
		Aas: function(option) {
			var defaults = {
				jia: this.find('' + option.jia + ''),
				jian: this.find('' + option.jian + ''),
				val: this.find('' + option.val + ''),
				max: option.max,
				callback: option.callback,
				state: option.state
			};
			var opt = $.extend(defaults, option);
			this.each(function() {
				var _this = $(this);
				var _val = _this.find(opt.val); //input的value值
				var _jian = _this.find(opt.jian); //减按钮
				var _jia = _this.find(opt.jia); //加按钮
				var kc = parseInt(_val.attr('data-kc')); //库存
				var xl = parseInt(_val.attr('data-xl')); //限量
				var isxl = parseInt(_val.attr('data-isxl')); //是否处于限量
				var zbz = parseFloat(_val.attr('data-zbz')); //中包装
				var jzl = parseInt(_val.attr('data-jzl')); //件装量
				var num;
				//				加
				_jia.on('click', function() {
					add_py();
					callback()
				});
				//				减
				_jian.on('click', function() {
					reduce_py();
					callback();
				});
				//购物车以及普药input blur事件
				if(opt.state === 1) {
					_val.blur(function() {
						changePrice()
						callback()
					})
				} else if(opt.state === 2) {
					_val.keyup(function() {
						if(parseInt($(this).val()) > parseInt(opt.max)) {
							$(this).val(opt.max);
						}
						callback()
					})
				}

				//购物车以及普药input数量加
				function add_py() {
					num = parseFloat(_val.val()); //当前数量
					num = num + zbz;
					font_color();
					if(opt.state === 1) {
						if(jzl) { //件装量存在
							if((num % jzl) / jzl >= 0.8) { //购买数量达到件装量80%
								layer.msg('温馨提示：你所选择的数量已接近件装量，为避免拆零引起的运输破损，系统自动调为整件。', {
									icon: 0
								});
								num = Math.ceil(num / jzl) * jzl;
							}
						}
						
						if(num % zbz != 0) { //不为中包装整数倍
							num = num - num % zbz + zbz;
						}
						
						if(isxl > 0 && num > xl && xl > 0) { //商品限购
							num = xl;
							layer.msg('最大限购数量' + xl, {
								icon: 2
							});
						}

						if(num > kc && kc > 0) {
							//            alert('库存不足');
							//            return false;
							num = kc;
						}
						var zbz_str = zbz + '';
						var zbz_arr = zbz_str.split('.');
						if(zbz_arr.length >= 2)
							num = num.toFixed(2);

						_val.val(num);
					} else if(opt.state === 2) {
						_val.val(parseInt(_val.val()) + 1)
						if(_this.find(opt.val).val() >= opt.max) {
							_val.val(opt.max);
						}
					}
				}

				//购物车以及普药input数量减
				function reduce_py() {
					num = parseFloat(_val.val()); //当前数量
					num = num - zbz;
					font_color();
					if(opt.state === 1) {
						if(jzl) { //件装量存在
							if((num % jzl) / jzl >= 0.8 && (num % jzl) / jzl <= 1) { //购买数量达到件装量80%
								num = num - num % jzl + parseInt(jzl * 0.8);
							}
						}

						if(num % zbz != 0) { //不为中包装整数倍
							num = num - num % zbz;
						}

						if(isxl > 0 && num > xl && xl > 0) { //商品限购
							num = xl;
							layer.msg('最大限购数量' + xl, {
								icon: 2
							});
						}

						if(num < zbz) {
							num = zbz;
						}
						var zbz_str = zbz + '';
						var zbz_arr = zbz_str.split('.');
						if(zbz_arr.length >= 2)
							num = num.toFixed(2);

						_val.val(num);
					} else if(opt.state === 2) {
						_val.val(parseInt(_val.val()) - 1)
						if(_val.val() <= 1) {
							_val.val(1);
						}
					}
				}

				//购物车以及普药input的blur事件
				function changePrice() {
					num = parseInt(_val.val()); //当前数量
					font_color();
					if(num < 0) {
						layer.msg('不能低于中包装的数量', {
							icon: 2
						});
						_val.val(zbz);
						return false;
					}
					var old = num;

					if(num % zbz != 0) { //不为中包装整数倍
						console.log(num % zbz, zbz)
						num = num - num % zbz + zbz;
					}

					if(jzl) { //件装量存在
						if((num % jzl) / jzl >= 0.8 && (num % jzl) / jzl <= 1) { //购买数量达到件装量80%
							layer.msg('温馨提示：你所选择的数量已接近件装量，为避免拆零引起的运输破损，系统自动调为整件。', {
								icon: 0
							});
							num = Math.ceil(num / jzl) * jzl;
							//                if(num>gn){
							//                    alert('库存不足');
							//                    num = old - old%jzl + parseInt(jzl*0.8) - zbz;
							//                }
						}
					}

					if(isxl > 0 && num > xl && xl > 0) { //商品限购
						num = xl;
						layer.msg('最大限购数量' + xl, {
							icon: 2
						});
					}

					if(num > kc && kc > 0) {
						//            alert('库存不足');
						//            $('#J_dgoods_num_'+id).val(zbz);
						//            return false;
						num = kc;
					}
					var zbz_str = zbz + '';
						var zbz_arr = zbz_str.split('.');
						if(zbz_arr.length >= 2)
							num = num.toFixed(2);

					_val.val(num);
				}

				function callback() {
					if(opt.callback != undefined) {
						opt.callback()
					}
				}

				function font_color() {
					if(isxl > 0 && num >= xl && xl > 0) {
						_jia.addClass('max');
						_jian.removeClass('min');
					} else if(num <= zbz) {
						_jia.removeClass('max');
						_jian.addClass('min');
					} else if(num >= kc) {
						_jia.addClass('max');
						_jian.removeClass('min');
					} else if(num > zbz && num < kc) {
						_jia.removeClass('max');
						_jian.removeClass('min');
					}
				}
			})
		}
	});
	$.fn.extend({
		Aas: $.fn.Aas
	})
})(jQuery)