;
(function($) {
	$.extend({
		//生成随机数
		getRandom: function(_min, _max) {
			var result = fApi.getRandom(_min, _max);
			return result;
		},
		//验证密码
		regPwd: function(_val, _min, _max) {
			var result = fApi.regPwd(_val, _min, _max);
			return result;
		},
		//验证手机
		regPhone: function(_val) {
			var result = fApi.regPhone(_val);
			return result;
		},
		//获取IE浏览器版本
		IEVersion: function() {
			var result = fApi.IEVersion();
			return result;
		},
		//获取浏览器型号
		myBrowser: function() {
			var result = fApi.myBrowser();
			return result;
		}
	});
	$.fn.extend({
		//下拉菜单事件
		dropDownEvent: function(_callback) {
			mApi.dropDown(this, _callback);
		},
		//遮罩层
		maskEvent: function(_event, _callback) {
			if(typeof _event != 'string') return false;
			switch(_event) {
				case 'open':
					mApi.mask(this).open(_callback);
					break;
				case 'close':
					mApi.mask(this).close(_callback);
					break;
			}
		},
		//搜索
		searchEvent: function(_get_data_fun, _callback, _btn, _list_fun) {
			mApi.search().init(this, _get_data_fun, _callback, _btn, _list_fun);
		},
		searchDataShow: function(_data, _name) {
			mApi.search().data(this, _data, _name);
		},
		//轮播
		carouselEvent: function(_options, _callback) {
			mApi.carousel(this, _options, _callback);
		},
		//监听鼠标滚轮
		mousewheelEvent: function(_d, _u) {
			mApi.mousewheel(this, _d, _u);
		},
		//放大镜
		magnifyEvent: function(_param) {
			mApi.magnify(this, _param);
		}
	});

	var mInterface = function() {
		this.init();
	}
	mInterface.prototype = {
		//初始化
		init: function() {
			$(function() {
				//下拉菜单
				$('.dropdown').hover(
					function() {
						if($(this).find('.dropdown-toggle span.dropdown-icon').children().length == 0) $(this).find('.dropdown-toggle span.dropdown-icon').html('∧');
					},
					function() {
						if($(this).find('.dropdown-toggle span.dropdown-icon').children().length == 0) $(this).find('.dropdown-toggle span.dropdown-icon').html('∨');
					}
				)
				//遮罩层
				$('.mask').each(function() {
					var content = $(this).find('.mask-content');
					content.css({
						top: '50%',
						left: '50%',
						'margin-top': 0 - content.height() / 2,
						'margin-left': 0 - content.width() / 2
					})
				})
				//电梯导航
				$('.lift .lift-item').click(function() {
					var start = $('.lift').attr('data-start');
					if(start == '' || start == undefined) start = 0;
					var area = $(this).attr('data-area');
					if(area == '' || area == undefined) return false;
					if($('.lift').hasClass('lift-center')) {
						$("html,body").stop().animate({
							"scrollTop": $(area).offset().top - ($(window).height() / 2 - $(area).height() / 2) - start + 'px'
						});
					} else {
						$("html,body").stop().animate({
							"scrollTop": $(area).offset().top - start + 'px'
						});
					}
				})
				$('.lift .lift-item').hover(function() {
					if(!$('.lift').hasClass('lift-hover')) return false;
					$(this).click();
				})
			});
            //返回顶部
            $('.btn-top').click(function() {
                $('html,body').animate({
                    'scrollTop': 0
                })
            });
        },
		//下拉事件
		dropDown: function(_target, _callback) {
			var $this = $(_target);
			$this.find('.dropdown-toggle').click(function() {
				var icon = $(this).find('span.dropdown-icon');
				var menu = $(this).next('.dropdown-menu');
				var menu_sta = menu.css('display') == 'block' ? true : false;
				control(!menu_sta);
				menu.find('li').click(function() {
					if($(this).hasClass('dropdown-header') || $(this).hasClass('divider')) return false;
					control(menu_sta);
				})

				function control(_sta) {
					if(_sta) {
						if(icon.children().length == 0) icon.html('∧');
						menu.css('display', 'block');
					} else {
						if(icon.children().length == 0) icon.html('∨');
						menu.css('display', 'none');
					}
				}
			})
			$this.find('.dropdown-menu li').click(function() {
				if($(this).hasClass('dropdown-header') || $(this).hasClass('divider')) return false;
				$this.find('.dropdown-toggle span.dropdown-val').html($(this).html());
				if(typeof _callback == 'function') _callback($(this).data('value'));
			})
		},
		//遮罩层
		mask: function(_target) {
			var $this = _target;
			var shadow = $this.find('.mask-shadow');
			var content = $this.find('.mask-content');
			this.open = function(_callback) {
				if(typeof _callback == 'function') _callback();
				$this.show();
				content.fadeIn(300);
			}
			this.close = function(_callback) {
				content.fadeOut(300, function() {
					$this.hide();
					if(typeof _callback == 'function') _callback();
				})
			}
			return this;
		},
		//搜索
		search: function() {
			/**
			 * 初始化搜索功能
			 * @param {Object} _target DOM元素
			 * @param {Function} _get_data_fun 获取搜索数据方法
			 * @param {Function} _callback 回调方法
			 * @param {Object} _btn 按钮元素(执行搜索)
			 * @param {Function} _list_fun 搜索结果列表显示或隐藏的回调  返回true/false
			 */
			this.init = function(_target, _get_data_fun, _callback, _btn, _list_fun) {
				var $this = $(_target);
				var input = $this.find('.search-input');
				var list = $this.find('.search-list');
				input.keydown(function(e) {
					setTimeout(function() {
						if(input.val().length > 0) {
							if(e.keyCode == 40) {
								if(list.find('li.cur').index() < 0) {
									list.find('li:first-child').addClass('cur');
								} else {
									if(list.find('li.cur').index() == list.find('li').length - 1) {
										list.find('li:first-child').addClass('cur').siblings().removeClass('cur');
									} else {
										list.find('li.cur').next().addClass('cur').siblings().removeClass('cur');
									}
								}
								input.val(list.find('.cur').html());
							}
							if(e.keyCode == 38) {
								if(list.find('li.cur').index() < 0) {
									list.find('li:last-child').addClass('cur');
								} else {
									if(list.find('li.cur').index() == 0) {
										list.find('li:last-child').addClass('cur').siblings().removeClass('cur');
									} else {
										list.find('li.cur').prev().addClass('cur').siblings().removeClass('cur');
									}
								}
								input.val(list.find('.cur').html());
							}
							if(e.keyCode == 13) {
								if(typeof _callback == 'function') _callback(input.val());
							}
						} else {
							list.hide(0, function() {
								list.find('.cur').removeClass('cur');
								if(typeof _list_fun == 'function') _list_fun(false);
							});
						}
					}, 100)
				}).keyup(function(e) {
					if(input.val().length > 0 && e.keyCode != 40 && e.keyCode != 38) {
						_get_data_fun($this, input.val())
						list.show(0, function() {
							if(typeof _list_fun == 'function') _list_fun(true);
						});
					}
				}).blur(function() {
					list.hide(0, function() {
						list.find('.cur').removeClass('cur');
						if(typeof _list_fun == 'function') _list_fun(false);
					});
				}).focus(function() {
					if($(this).val().length > 0) {
						list.show(0, function() {
							if(typeof _list_fun == 'function') _list_fun(true);
						});;
					}
				})
				if(typeof _btn == 'object') {
					$(_btn).click(function() {
						if(typeof _callback == 'function') _callback(input.val());
					})
				}
				onmousedown = function(e) {
					if($(e.target).parent().hasClass('search-list')) {
						input.val($(e.target).html());
						if(typeof _callback == 'function') _callback($(e.target).html());
					}
				}
				if($.IEVersion() <= 8 && $.IEVersion() > 0) {
					document.attachEvent('onmousedown', function(e) {
						if(e.clientX > list.offset().left && e.clientX < list.width() + list.offset().left && list.offset().left > 0 && e.clientY > list.offset().top && e.clientY < list.height() + list.offset().top && list.offset().top > 0) {
							input.val(list.find('.cur').html());
							if(typeof _callback == 'function') _callback(list.find('.cur').html());
						}
					})
				}
			};
			/**
			 * 渲染搜索数据
			 * @param {Object} _target DOM元素
			 * @param {Array} _data 数据(数组)
			 * @param {String} _name 数组内下标名
			 */
			this.data = function(_target, _data, _name) {
				var $this = $(_target);
				var input = $this.find('.search-input');
				var list = $this.find('.search-list');
				list.find('li').remove();
				for(var i = 0; i < _data.length; i++) {
					list.append('<li>' + _data[i][_name] + '</li>');
				}
				list.find('li').hover(function() {
					$(this).addClass('cur').siblings().removeClass('cur');
				})
			}
			return this;
		},
		/**
		 * 轮播
		 * @param {Object} _target DOM元素
		 * @param {Object} _options 参数配置
		 * @param {Function} _callback 回调方法 返回当前索引
		 */
		carousel: function(_target, _options, _callback) {
			var $this = $(_target);
			var list = $this.find('.carousel-list');
			var nav = $this.find('.carousel-nav');
			var page = $this.find('.carousel-page');
			var int;
			var list_len = list.find('li').length;
			var default_option = {
				time: 1000, //间隔时间
				auto: true, //是否开始自动轮播
				animation: 500 //动画时间
			}
			if(typeof _options == 'function') {
				_callback = _options;
				_options = {};
			}
			var options = $.extend({}, default_option, _options);

			init();
			$(window).resize(function() {
				init();
			});

			list.find('li').eq(0).show().addClass('cur').siblings().removeClass('cur');
			nav.find('li').eq(0).addClass('cur').siblings().removeClass('cur');

			$this.hover(function() {
				off();
			}, function() {
				on();
			});
			page.find('.next').click(function() {
				jump();
			});
			page.find('.prev').click(function() {
				if($this.hasClass('carousel-x')) {
					if(list.find('li.cur').prev().index() < 0) {
						nav.find('li').eq(list_len - 1).addClass('cur').siblings().removeClass('cur');
						if(typeof _callback == 'function') _callback(nav.find('li.cur').index());
						list.prepend(list.find('li').eq(list_len - 1).clone());
						list.css('margin-left', 0 - $this.width() + 'px');
						list.stop().animate({
							'marginLeft': 0
						}, options.animate, function() {
							$(this).css('margin-left', 0 - list_len * $this.width() + 'px');
							list.find('li').eq(list_len).addClass('cur').siblings().removeClass('cur');
							list.find('li').eq(0).remove();
							$(this).css('margin-left', 0 - (list_len - 1) * $this.width() + 'px');
						})
					} else {
						jump(list.find('li.cur').prev().index() < 0 ? list_len - 1 : list.find('li.cur').prev().index());
					}
				} else if($this.hasClass('carousel-y')) {
					if(list.find('li.cur').prev().index() < 0) {
						nav.find('li').eq(list_len - 1).addClass('cur').siblings().removeClass('cur');
						if(typeof _callback == 'function') _callback(nav.find('li.cur').index());
						list.prepend(list.find('li').eq(list_len - 1).clone());
						list.css('margin-top', 0 - $this.height() + 'px');
						list.stop().animate({
							'marginTop': 0
						}, options.animate, function() {
							$(this).css('margin-top', 0 - list_len * $this.height() + 'px');
							list.find('li').eq(list_len).addClass('cur').siblings().removeClass('cur');
							list.find('li').eq(0).remove();
							$(this).css('margin-top', 0 - (list_len - 1) * $this.height() + 'px');
						})
					} else {
						jump(list.find('li.cur').prev().index() < 0 ? list_len - 1 : list.find('li.cur').prev().index());
					}
				} else {
					jump(list.find('li.cur').prev().index() < 0 ? list_len - 1 : list.find('li.cur').prev().index());
				}
			})
			nav.find('li').hover(function() {
				jump($(this).index());
			})

			on();

			function init() {
				if($this.hasClass('carousel-x')) {
					if(list.find('li').length == list_len) list.append(list.find('li').eq(0).clone());
					list.css('width', (list_len + 1) * 100 + '%');
					list.find('li').css('width', $this.width() + 'px');
					if(list.find('li.cur').index() >= 0) list.css('margin-left', 0 - list.find('li.cur').index() * $this.width() + 'px');
				} else if($this.hasClass('carousel-y')) {
					if(list.find('li').length == list_len) list.append(list.find('li').eq(0).clone());
					list.css('height', (list_len + 1) * 100 + '%');
					list.find('li').css('height', $this.height() + 'px');
					if(list.find('li.cur').index() >= 0) list.css('margin-top', 0 - list.find('li.cur').index() * $this.height() + 'px');
				}
			}

			function on() {
				if(options.auto) {
					int = setInterval(function() {
						jump()
					}, options.time);
				}
			}

			function off() {
				clearInterval(int);
			}

			function jump(_idx) {
				if($this.hasClass('carousel')) {
					if(typeof _idx == 'number') {
						nav.find('li').eq(_idx).addClass('cur').siblings().removeClass('cur');
						if(typeof _callback == 'function') _callback(nav.find('li.cur').index());
						list.find('li').eq(_idx).siblings().hide();
						list.find('li').eq(_idx).stop(false, true).fadeIn(options.animation, function() {
							$(this).addClass('cur').siblings().removeClass('cur');
						})
					} else {
						if(list.find('li.cur').index() == list_len - 1) {
							nav.find('li').eq(0).addClass('cur').siblings().removeClass('cur');
							if(typeof _callback == 'function') _callback(nav.find('li.cur').index());
							list.find('li').eq(0).siblings().hide();
							list.find('li').eq(0).stop(false, true).fadeIn(options.animation, function() {
								$(this).addClass('cur').siblings().removeClass('cur');
							})
						} else {
							nav.find('li.cur').next().addClass('cur').siblings().removeClass('cur');
							if(typeof _callback == 'function') _callback(nav.find('li.cur').index());
							list.find('li.cur').next().siblings().hide();
							list.find('li.cur').next().stop(false, true).fadeIn(options.animation, function() {
								$(this).addClass('cur').siblings().removeClass('cur');
							})
						}
					}
				} else if($this.hasClass('carousel-x')) {
					if(typeof _idx == 'number') {
						nav.find('li').eq(_idx).addClass('cur').siblings().removeClass('cur');
						if(typeof _callback == 'function') _callback(nav.find('li.cur').index());
						list.stop().animate({
							'marginLeft': 0 - $this.width() * _idx + 'px'
						}, options.animation, function() {
							$(this).find('li').eq(_idx).addClass('cur').siblings().removeClass('cur');
						});
					} else {
						if(list.find('li.cur').index() == list_len - 1) {
							nav.find('li').eq(0).addClass('cur').siblings().removeClass('cur');
							if(typeof _callback == 'function') _callback(nav.find('li.cur').index());
							list.stop().animate({
								'marginLeft': 0 - $this.width() * list_len + 'px'
							}, options.animate, function() {
								$(this).css('margin-left', 0);
								$(this).find('li').eq(0).addClass('cur').siblings().removeClass('cur');
							})
						} else {
							nav.find('li.cur').next().addClass('cur').siblings().removeClass('cur');
							if(typeof _callback == 'function') _callback(nav.find('li.cur').index());
							list.stop().animate({
								'marginLeft': 0 - $this.width() * nav.find('li.cur').index() + 'px'
							}, options.animation, function() {
								$(this).find('li').eq(nav.find('li.cur').index()).addClass('cur').siblings().removeClass('cur');
							});
						}
					}
				} else if($this.hasClass('carousel-y')) {
					if(typeof _idx == 'number') {
						nav.find('li').eq(_idx).addClass('cur').siblings().removeClass('cur');
						if(typeof _callback == 'function') _callback(nav.find('li.cur').index());
						list.stop().animate({
							'marginTop': 0 - $this.height() * _idx + 'px'
						}, options.animation, function() {
							$(this).find('li').eq(_idx).addClass('cur').siblings().removeClass('cur');
						});
					} else {
						if(list.find('li.cur').index() == list_len - 1) {
							nav.find('li').eq(0).addClass('cur').siblings().removeClass('cur');
							if(typeof _callback == 'function') _callback(nav.find('li.cur').index());
							list.stop().animate({
								'marginTop': 0 - $this.height() * list_len + 'px'
							}, options.animate, function() {
								$(this).css('margin-top', 0);
								$(this).find('li').eq(0).addClass('cur').siblings().removeClass('cur');
							})
						} else {
							nav.find('li.cur').next().addClass('cur').siblings().removeClass('cur');
							if(typeof _callback == 'function') _callback(nav.find('li.cur').index());
							list.stop().animate({
								'marginTop': 0 - $this.height() * nav.find('li.cur').index() + 'px'
							}, options.animation, function() {
								$(this).find('li').eq(nav.find('li.cur').index()).addClass('cur').siblings().removeClass('cur');
							});
						}
					}
				}
			}
		},
		/**
		 * 监听鼠标滚轮
		 */
		mousewheel: function(_e, _d, _u) {
			/**
			 * _d 滚轮向下回调
			 * _u 滚轮向上回调
			 */
			var $this = $(_e),
				addMouseWheelHandler = function() {
					if(document.addEventListener) {
						document.addEventListener('mousewheel', MouseWheelHandler, false); //IE9, Chrome, Safari, Oper
						document.addEventListener('wheel', MouseWheelHandler, false); //Firefox
						document.addEventListener('DOMMouseScroll', MouseWheelHandler, false); //Old Firefox
					} else {
						document.attachEvent('onmousewheel', MouseWheelHandler); //IE 6/7/8
					}
				},
				removeMouseWheelHandler = function() {
					if(document.addEventListener) {
						document.removeEventListener('mousewheel', MouseWheelHandler, false); //IE9, Chrome, Safari, Oper
						document.removeEventListener('wheel', MouseWheelHandler, false); //Firefox
						document.removeEventListener('DOMMouseScroll', MouseWheelHandler, false); //old Firefox
					} else {
						document.detachEvent('onmousewheel', MouseWheelHandler); //IE 6/7/8
					}
				},
				stopDefault = function(e) {
					//W3C
					if(e && e.preventDefault)
						e.preventDefault();
					//IE 
					else
						window.event.returnValue = false;
					return false;
				},
				MouseWheelHandler = function(e) { //滚动后的处理函数
					stopDefault(e);
					var e = e || window.event,
						value = e.wheelDelta || -e.deltaY || -e.detail,
						delta = Math.max(-1, Math.min(1, value));
					if(delta < 0) { //scrolling down
						if(e.x > $this.offset().left && e.x < parseInt($this.offset().left) + $this.width() && e.y > $this.offset().top && e.y < parseInt($this.offset().top) + $this.height()) {
							_d(e, value);
						}
					} else { //scrolling up
						if(e.x > $this.offset().left && e.x < parseInt($this.offset().left) + $this.width() && e.y > $this.offset().top && e.y < parseInt($this.offset().top) + $this.height()) {
							_u(e, value);
						}
					}
				};

			$this.addClass("mousewheel");
			//调用
			addMouseWheelHandler();
		},
		//放大镜
        magnify: function(_target, _param) {
            $(_target).each(function() {
                var $this = $(this),
                    $w = $this.width(),
                    $h = $this.height(),
                    $l = $this.offset().left,
                    $t = $this.offset().top,
                    src = $this.find('img').addClass('magnify').attr('src'),
                    small_box,
                    big_box,
                    img,
                    param = {
                        multiple: 2.5, //放大倍数
                        w: $w, //预览框宽
                        h: $h //预览框高
                    };

                $this.css('position', 'relative').find('img').css('position', 'absolute');
                $this.append("<div class='small_box'></div>");
                $this.append("<div class='big_box'><img src='" + src + "' /></div>");
                small_box = $this.find('.small_box');
                big_box = $this.find('.big_box');
                img = big_box.find('img');
                param = $.extend(param, _param);
                //小框样式
                small_box.css({
                    height: param.h / param.multiple + "px",
                    width: param.w / param.multiple + "px",
                    position: "absolute",
                    "background-color": "#fff",
                    opacity: 0.5,
                    filter: "Alpha(opacity=50)",
                    display: "none",
                    cursor: "move"
                })
                //预览框样式
                big_box.css({
                    height: param.h + "px",
                    width: param.w + "px",
                    position: "absolute",
                    left: $w + 5 + "px",
                    top: 0,
                    "z-index": 99999,
                    overflow: "hidden",
                    display: "none"
                }).find('img').css({
                    position: "absolute",
                    height: $h * param.multiple,
                    width: $w * param.multiple
                })

                $this.hover(
                    function(e) {
                        if($this.attr('data-src') != undefined && $this.attr('data-src') != '') src = $this.attr('data-src');
                        $l = $this.offset().left
                        $t = $this.offset().top
                        if(small_box.css('display') == "block") {
                            small_box.hide();
                            big_box.hide();
                            return false;
                        }

                        img.attr('src', src)
                        big_box.show()
                        small_box.show().mousemove(function(e) {
                            var top = e.pageY - $t - small_box.height() / 2
                            var left = e.pageX - $l - small_box.width() / 2

                            if(top > $h - small_box.height()) {
                                top = $h - small_box.height()
                            }
                            if(top < 0) {
                                top = 0
                            }
                            if(left > $w - small_box.width()) {
                                left = $w - small_box.width()
                            }
                            if(left < 0) {
                                left = 0
                            }

                            $(this).css({
                                top: top + "px",
                                left: left + "px"
                            })

                            big_box.find('img').css({
                                top: "-" + top * param.multiple + "px",
                                left: "-" + left * param.multiple + "px"
                            })
                        }).css({
                            top: e.offsetY - small_box.height() / 2 + "px",
                            left: e.offsetX - small_box.width() / 2 + "px"
                        })
                    },
                    function() {
                        big_box.hide();
                        small_box.hide();
                    }
                )
            });
        }

    }

	var fInterface = function() {}
	fInterface.prototype = {
		/**
		 * 生成min-max的随机数
		 * @param {Number} _min 最小数字
		 * @param {Number} _max 最大数字
		 */
		getRandom: function(_min, _max) {
			if(typeof _min != 'number' || typeof _max != 'number') console.error('生成随机数失败：请输入数字');
			return Math.round(Math.random() * (_max - _min) + _min);
		},
		/**
		 * 验证密码
		 * @param {String} _val 需要验证的值
		 * @param {Number} _min 最小长度 默认 6
		 * @param {Number} _max 最大长度 默认 24
		 */
		regPwd: function(_val, _min, _max) {
			var reg = /^[0-9a-zA-Z-]$/;
			var min = _min || 6;
			var max = _max || 24;
			if(reg.test && _val.length >= min && _val.length <= max) {
				return true;
			} else {
				return false;
			}
		},
		/**
		 * 正则手机号
		 * @param {String} _val 需要验证的手机号
		 */
		regPhone: function(_val) {
			var reg = /^1[34578]\d{9}$/;
			return reg.test(_val);
		},
		/**
		 * 正则正整数
		 * @param {String} _val 需要验证的值
		 */
		regPositiveNum: function(_val) {
			var reg = /^1[34578]\d{9}$/;
			return reg.test(_val);
		},
		/**
		 * 判断ie浏览器版本
		 * 值	值类型	值说明
		 * -1	Number	不是ie浏览器
		 * 6	Number	ie版本<=6
		 * 7	Number	ie7
		 * 8	Number	ie8
		 * 9	Number	ie9
		 * 10	Number	ie10
		 * 11	Number	ie11
		'edge'	String	ie的edge浏览器
		 */
		IEVersion: function() {
			var userAgent = navigator.userAgent; //取得浏览器的userAgent字符串  
			var isIE = userAgent.indexOf("compatible") > -1 && userAgent.indexOf("MSIE") > -1; //判断是否IE<11浏览器  
			var isEdge = userAgent.indexOf("Edge") > -1 && !isIE; //判断是否IE的Edge浏览器  
			var isIE11 = userAgent.indexOf('Trident') > -1 && userAgent.indexOf("rv:11.0") > -1;
			if(isIE) {
				var reIE = new RegExp("MSIE (\\d+\\.\\d+);");
				reIE.test(userAgent);
				var fIEVersion = parseFloat(RegExp["$1"]);
				if(fIEVersion == 7) {
					return 7;
				} else if(fIEVersion == 8) {
					return 8;
				} else if(fIEVersion == 9) {
					return 9;
				} else if(fIEVersion == 10) {
					return 10;
				} else {
					return 6; //IE版本<=7
				}
			} else if(isEdge) {
				return 'edge'; //edge
			} else if(isIE11) {
				return 11; //IE11  
			} else {
				return -1; //不是ie浏览器
			}
		},
		/**
		 * 判断浏览器
		 */
		myBrowser: function() {
			var userAgent = navigator.userAgent; //取得浏览器的userAgent字符串
			var isOpera = userAgent.indexOf("Opera") > -1;
			if(isOpera) {
				return "Opera"
			}; //判断是否Opera浏览器
			if(userAgent.indexOf("Firefox") > -1) {
				return "FF";
			}; //判断是否Firefox浏览器
			if(userAgent.indexOf("Chrome") > -1) {
				return "Chrome";
			};
			if(userAgent.indexOf("Safari") > -1) {
				return "Safari";
			}; //判断是否Safari浏览器
			if(userAgent.indexOf("compatible") > -1 && userAgent.indexOf("MSIE") > -1 && !isOpera) {
				return "IE";
			}; //判断是否IE浏览器
		}
	}

	var mApi = new mInterface();
	var fApi = new fInterface();
})(jQuery)