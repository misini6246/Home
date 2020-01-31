//==========================================插件========================================
;(function ($) {
    $.fn.extend({
        /**
         * 创建地址选择器(依赖city_data.js)
         * @param back 回调函数
         * @param split 分隔符 默认为“-” (可选)
         * @param style 设置选择器的css (可选)
         * return 选择好的省市区
         * add lx 20180702
         */
//		cityPick : function(back,split,style){
//			var $this = $(this);
//			$this.parent().css('position','relative')
//			var c = city_data;
//			var addr = "";
//			var isShow = false;
//			if(typeof split !== 'string'){
//				style = split;
//				split = '';
//			}
//			split = (split!=undefined && split!='')?split:'-';
//			var s = {
//				'left':$this[0].offsetLeft+2
//			}
//			s = $.extend(s,style);
//			
//			var htmls = "<div class='addr_box'>";
//					htmls += "<div class='addr_pick'>";
//						htmls += "<div class='title'>";
//							htmls += "<span class='pick_cur'>省</span>";
//							htmls += "<span>市</span>";
//							htmls += "<span>区</span>";
//							htmls += "<span>关闭</span>";
//						htmls += "</div>";
//						htmls += "<div class='body'>";
//							htmls += "<ul></ul>";
//						htmls += "</div>";
//					htmls += "</div>";
//				htmls += "</div>";				
//			
//			if($('.addr_pick').length > 0){$('.addr_pick').remove()}
//			$this.after(htmls)
//			$('.addr_box').hide()
//			$('.addr_pick').css(s);
//			
//			$('.addr_pick .title span:first-child+span+span+span').click(function(){on_off(false)})
//			$('.addr_pick .title span').click(function(){
//				if($(this).index()<3){$(this).addClass('pick_cur').siblings().removeClass('pick_cur')}
//				
//				if($(this).index() == 0){
//					$('.addr_pick .pick_p').show('fast')
//					$('.addr_pick .pick_c').hide('fast')
//					$('.addr_pick .pick_d').hide('fast')
//				}
//				if($(this).index() == 1){
//					$('.addr_pick .pick_p').hide('fast')
//					$('.addr_pick .pick_c').show('fast')
//					$('.addr_pick .pick_d').hide('fast')
//				}
//				if($(this).index() == 2){
//					$('.addr_pick .pick_p').hide('fast')
//					$('.addr_pick .pick_c').hide('fast')
//					$('.addr_pick .pick_d').show('fast')
//				}
//			})
//			
//			$this.click(function(){
//				on_off(!isShow)
//				
////				省
//				var html = "<li class='pick_p'>"
//						html += "<ul>"
//							for(var p=0;p<c.length;p++){
//								html += "<li id='"+p+"'>";
//									html += c[p].name;
//								html += "</li>"
//							}
//						html += "</ul>"
//					html += "</li>";
//				if($('.addr_pick .pick_p').length <= 0){$('.addr_pick .body ul').append(html);}
//				
//				$('.addr_pick .pick_p ul li').click(function(){					
//					$('.addr_pick .title span:first-child').html($(this).html())
//					$('.addr_pick .pick_p').hide('fast')
//					$('.addr_pick .title span:first-child+span').show('fast').addClass('pick_cur').html('市').siblings().removeClass('pick_cur')
//					$('.addr_pick .title span:first-child+span+span').html('区')
//					
//					$('.addr_pick .body ul').append(html_c(this.id))
//					var pid = this.id;
//					
//					$('.addr_pick .pick_c ul li').click(function(){
//						$('.addr_pick .title span:first-child+span').html($(this).html())
//						$('.addr_pick .pick_c').hide('fast')
//						$('.addr_pick .title span:first-child+span+span').show('fast').addClass('pick_cur').siblings().removeClass('pick_cur')
//						$('.addr_pick .title span:first-child+span+span').html('区')
//						
//						$('.addr_pick .body ul').append(html_d(pid,this.id))
//						
//						$('.addr_pick .pick_d ul li').click(function(){
//							$('.addr_pick .title span:first-child+span+span').html($(this).html())
//							
//							var str = '';
//							$('.addr_pick .title span').each(function(index,doc){
//								if(index < 3){
//									str += $(doc).html()+split;
//								}
//							})
//							addr = str.substring(0,str.length-1);
//							$this.val(addr)
//							if(typeof back === 'function'){back(addr);on_off(false)}
//						})
//					})
//				})
//			})
//			
////			市
//			function html_c(idx){
//				$('.addr_pick .pick_d li').remove()
//				if($('.addr_pick .pick_c').length > 0){$('.addr_pick .pick_c').remove()}
//				var html = "<li class='pick_c'>"
//						html += "<ul>"
//							for(var cc=0;cc<c[idx].city.length;cc++){
//								html += "<li id='"+cc+"'>";
//									html += c[idx].city[cc].name;
//								html += "</li>"
//							}
//						html += "</ul>"
//					html += "</li>";
//				return html;
//			}
//			
////			区
//			function html_d(pid,idx){
//				if($('.addr_pick .pick_d').length > 0){$('.addr_pick .pick_d').remove()}
//				var html = "<li class='pick_d'>"
//						html += "<ul>"
//							for(var dd=0;dd<c[pid].city[idx].area.length;dd++){
//								html += "<li id='"+dd+"'>";
//									html += c[pid].city[idx].area[dd];
//								html += "</li>"
//							}
//						html += "</ul>"
//					html += "</li>";
//				return html;
//			}
//			
////			开关
//			function on_off(bl){
//				if(bl){
//					$('.addr_box').show();
//					isShow = true;
//				}else{
//					$('.addr_box').hide();
//					isShow = false;
//				}
//			}			
//		},
        /**
         * 创建地址选择器(依赖city_data.js)
         * @param back 回调函数
         * @param split 分隔符 默认为“ ” (可选)
         * @param style 设置选择器的css (可选)
         * return 选择好的省市区
         * add lx 20180702
         */
        cityPick: function (back, split, style) {
            var $this = $(this);
            $this.parent().css('position', 'relative')
            var p_data = province;
            var c_data = city;
            var d_data = district;
            var pid;
            var cid;
            var did;
            var addr = "";
            var isShow = false;
            if (typeof split !== 'string') {
                style = split;
                split = '';
            }
            split = (split != undefined && split != '') ? split : ' ';
            var s = {
                'left': $this[0].offsetLeft + 2
            }
            s = $.extend(s, style);

            var htmls = "<div class='addr_box'>";
            htmls += "<div class='addr_pick'>";
            htmls += "<div class='title'>";
            htmls += "<span class='pick_cur'>省</span>";
            htmls += "<span>市</span>";
            htmls += "<span>区</span>";
            htmls += "<span>关闭</span>";
            htmls += "</div>";
            htmls += "<div class='body'>";
            htmls += "<ul></ul>";
            htmls += "</div>";
            htmls += "</div>";
            htmls += "</div>";

            if ($('.addr_pick').length > 0) {
                $('.addr_pick').remove()
            }
            $this.after(htmls)
            $('.addr_box').hide()
            $('.addr_pick').css(s);

            $('.addr_pick .title span:first-child+span+span+span').click(function () {
                on_off(false)
            })
            $('.addr_pick .title span').click(function () {
                if ($(this).index() < 3) {
                    $(this).addClass('pick_cur').siblings().removeClass('pick_cur')
                }

                if ($(this).index() == 0) {
                    $('.addr_pick .pick_p').show('fast')
                    $('.addr_pick .pick_c').hide('fast')
                    $('.addr_pick .pick_d').hide('fast')
                }
                if ($(this).index() == 1) {
                    $('.addr_pick .pick_p').hide('fast')
                    $('.addr_pick .pick_c').show('fast')
                    $('.addr_pick .pick_d').hide('fast')
                }
                if ($(this).index() == 2) {
                    $('.addr_pick .pick_p').hide('fast')
                    $('.addr_pick .pick_c').hide('fast')
                    $('.addr_pick .pick_d').show('fast')
                }
            })

            $this.click(function () {
                on_off(!isShow)

//				省
                var html = "<li class='pick_p'>"
                html += "<ul>"
                $.each(p_data, function (index, dom) {
                    html += "<li id='" + dom.id + "'>";
                    html += index;
                    html += "</li>"
                });
                html += "</ul>"
                html += "</li>";
                if ($('.addr_pick .pick_p').length <= 0) {
                    $('.addr_pick .body ul').append(html);
                }

//				点击省
                $('.addr_pick .pick_p ul li').click(function () {
                    $('.addr_pick .title span:first-child').html($(this).html())
                    $('.addr_pick .pick_p').hide('fast')
                    $('.addr_pick .title span:first-child+span').show('fast').addClass('pick_cur').html('市').siblings().removeClass('pick_cur')
                    $('.addr_pick .title span:first-child+span+span').html('区')

                    pid = this.id;
                    $('.addr_pick .body ul').append(html_c(pid))

//					点击市
                    $('.addr_pick .pick_c ul li').click(function () {
                        $('.addr_pick .title span:first-child+span').html($(this).html())
                        $('.addr_pick .pick_c').hide('fast')
                        $('.addr_pick .title span:first-child+span+span').show('fast').addClass('pick_cur').siblings().removeClass('pick_cur')
                        $('.addr_pick .title span:first-child+span+span').html('区')

                        cid = this.id
                        $('.addr_pick .body ul').append(html_d(cid))

//						点击区
                        $('.addr_pick .pick_d ul li').click(function () {
                            $('.addr_pick .title span:first-child+span+span').html($(this).html())
                            did = this.id
                            var str = '';
                            $('.addr_pick .title span').each(function (index, doc) {
                                if (index < 3) {
                                    str += $(doc).html() + split;
                                }
                            })
                            addr = str.substring(0, str.length - 1);
                            $this.val(addr)
                            if (typeof back === 'function') {
                                back({pid: pid, cid: cid, did: did});
                                on_off(false)
                            }
                        })
                    })
                })
            })

//			市
            function html_c(idx) {
                $('.addr_pick .pick_d li').remove()
                if ($('.addr_pick .pick_c').length > 0) {
                    $('.addr_pick .pick_c').remove()
                }
                var html = "<li class='pick_c'>"
                html += "<ul>"
                $.each(c_data[pid], function (index, dom) {
                    html += "<li id='" + dom.id + "'>";
                    html += dom.name;
                    html += "</li>"
                });
                html += "</ul>"
                html += "</li>";
                return html;
            }

//			区
            function html_d(idx) {
                if ($('.addr_pick .pick_d').length > 0) {
                    $('.addr_pick .pick_d').remove()
                }
                var html = "<li class='pick_d'>"
                html += "<ul>"
                $.each(d_data[idx], function (index, dom) {
                    html += "<li id='" + dom.id + "'>";
                    html += dom.name;
                    html += "</li>"
                });
                html += "</ul>"
                html += "</li>";
                return html;
            }

//			开关
            function on_off(bl) {
                if (bl) {
                    $('.addr_box').show();
                    isShow = true;
                } else {
                    $('.addr_box').hide();
                    isShow = false;
                }
            }
        },
        /**
         * 模拟placeholder功能 ie专用
         * add lx 20180703
         */
        placeholder: function () {
            if ("placeholder" in document.createElement("input")) {
                return this //如果原生支持placeholder属性，则返回对象本身
            } else {
                var _this = $(this);
                _this.val(_this.attr("placeholder")).focus(function () {
                    if (_this.val() === _this.attr("placeholder")) {
                        _this.val("")
                    }
                }).blur(function () {
                    if (_this.val().length === 0) {
                        _this.val(_this.attr("placeholder"))
                    }
                }).keyup(function () {
                    if (_this.val().length == 0) {
                        _this.blur()
                    }
                })
            }
        }
    })
})(jQuery)

//==========================================function====================================

/**
 * 验证密码
 * @param {String} val 需要验证的值
 * add lx 20180629
 */
function reg_pwd(val) {
    var reg = /^[0-9a-zA-Z-]{6,24}$/;
    return reg.test(val)
}

/**
 * 正则手机号
 * @param {String} val 需要验证的手机号
 * add lx 20180627
 */
function reg_phone(val) {
    var reg = /^1[34578]\d{9}$/;
    return reg.test(val);
}

/**
 * 跳转页面
 * @param {String} url 地址
 * add lx 20180703
 */
function jump_url(url) {
    window.location.href = url
}

/**
 * 判断ie浏览器版本
 * 值    值类型    值说明
 * -1    Number     不是ie浏览器
 * 6    Number    ie版本<=6
 * 7    Number    ie7
 * 8    Number    ie8
 * 9    Number    ie9
 * 10    Number    ie10
 * 11    Number    ie11
 'edge'    String    ie的edge浏览器
 */
function IEVersion() {
    var userAgent = navigator.userAgent; //取得浏览器的userAgent字符串  
    var isIE = userAgent.indexOf("compatible") > -1 && userAgent.indexOf("MSIE") > -1; //判断是否IE<11浏览器  
    var isEdge = userAgent.indexOf("Edge") > -1 && !isIE; //判断是否IE的Edge浏览器  
    var isIE11 = userAgent.indexOf('Trident') > -1 && userAgent.indexOf("rv:11.0") > -1;
    if (isIE) {
        var reIE = new RegExp("MSIE (\\d+\\.\\d+);");
        reIE.test(userAgent);
        var fIEVersion = parseFloat(RegExp["$1"]);
        if (fIEVersion == 7) {
            return 7;
        } else if (fIEVersion == 8) {
            return 8;
        } else if (fIEVersion == 9) {
            return 9;
        } else if (fIEVersion == 10) {
            return 10;
        } else {
            return 6;//IE版本<=7
        }
    } else if (isEdge) {
        return 'edge';//edge
    } else if (isIE11) {
        return 11; //IE11  
    } else {
        return -1;//不是ie浏览器
    }
}

/**
 * 判断是否支持placeholder
 */
function isPlaceholer() {
    var input = document.createElement('input');
    return "placeholder" in input;
}


//========================================================================================页面级========================================================================================

//单选盒子点击改变样式
$('.radio span:not(:first)').click(function () {
    $(this).addClass('radio_cur')
    $(this).siblings().removeClass('radio_cur')
})

/**
 * 设置元素样式和值
 * @param {Object} dom 元素节点
 * @param {String} val 如果不修改传空字符串
 * @param {Object} style css样式
 * add lx 20180628
 */
function set_dom_style(dom, val, style) {
    if (style) {
        dom.css(style)
    }
    if (typeof val == 'string' && val.length > 0) {
        dom.val(val)
    }
}

/**
 * 在input内添加按钮
 * @param {Object} input 需要添加的对象
 * @param {String} parent input的父级选择器(非对象)
 * @param {Number} type 1为true/false按钮 2为自定义
 * @param {Boolean} bl 判断是添加错误还是正确按钮(当type为1时)
 * @param {String} bg_img 已封装好背景图的class(当type为2时)
 * @param {Object} box_style 存放按钮盒子的样式
 * add lx 20180627
 */
function add_input_btn(input, parent, type, bl, bg_img, box_style) {
    var input = $(input);
    var _type = 1;
    var bg;//按钮样式
    if (input.attr('type') === 'text' || input.attr('type') === 'password') {
        //清除按钮
        if ($(parent + ' .btn_ipt_box').length > 0) {
            $(parent + ' .btn_ipt_box').remove()
        }

        input.parent().addClass('posR')//为父级添加相对定位
        if (type !== undefined && type !== null) {
            _type = type
        }

        if (_type == 1) {
            if (bl) {
                bg = "bg_btn_ipt_true"
                input.parent().append("<div class='btn_ipt_box bg_btn_ipt_true' data-idx='" + input[0].id + "'></div>")
            } else {
                bg = "bg_btn_ipt_cler"
                input.parent().append("<div class='btn_ipt_box bg_btn_ipt_cler' data-idx='" + input[0].id + "'></div>")
            }
        } else {
            bg = bg_img
            input.parent().append("<div class='btn_ipt_box " + bg + "' data-idx='" + input[0].id + "'></div>")
        }

        if (box_style !== undefined && box_style !== null) {
            $(parent + ' .btn_ipt_box').css(box_style)
        }

        //定位按钮
        var left = input.position().left + (input.outerWidth() - 10) + 'px';
        if (IEVersion() == 7) {
            left = input.position().left + (input.outerWidth() - 25) + 'px'
        }
        set_dom_style($(parent + ' .btn_ipt_box'), '', {
            'top': input.position().top + ((input.height() / 2) - ($(parent + ' .' + bg).outerHeight() / 2)) + 1 + 'px',
            'left': left
        })
    }
}