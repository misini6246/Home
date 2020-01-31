;(function ($) {
    $.fn.extend({
        carousel: function (_param) {
            var $this = $(this);
            var param = {
                animation: "d",//动画效果 x:横向 y:纵向 d:淡入淡出
                time: "1000",//间隔时间
                animate_speed: "slow",//横向或纵向移动的时间  可能的值 "slow" "fast"
                self_adaption: false,//是否开启自动适应屏幕宽度 值为true时动画效果只能为"d"
                g: true//是否自动轮播

            }
            var a;
            var doc_img = $this.find('.carousel_img')
            var doc_page = $this.find('.carousel_page')
            var left = $this.find('.carousel_page li:first-child');
            var right = $this.find('.carousel_page li:first-child+li');
            var doc_nav = $this.find('.carousel_nav');
            var doc_first = doc_img.find('li:first-child').clone();

            param = $.extend(param, _param);
            doc_first.removeClass('cur')
            if (param.animation != "d") {
                doc_img.append(doc_first)
            }
            $this.find('.carousel_page li').hide();
            if (!param.g) {
                param.time = 99999999999999999999;
            }
            setA();
            doc_nav.css('left', ($this.width() / 2) - (doc_nav.width() / 2));
            set_nav(1);
            $this.mouseover(function () {
                stopA();
                if (param.animation == "y") {
                    left.css('left', doc_img.find('.cur').position().left + 5 + 'px')
                    right.css('right', doc_img.find('.cur').position().left + 5 + 'px')
                }
                $this.find('.carousel_page li').show();
            }).mouseout(function () {
                setA();
                $this.find('.carousel_page li').hide();
            })

            //设置动画效果
            function setA() {
                if (param.self_adaption) {
                    param.animation = "d";
                }
                switch (param.animation) {
                    case "x":
                        doc_img.addClass('animation_x')
                        doc_img.css('width', doc_img.find('li').length * doc_img.find('.cur').width())
                        a = setInterval(function () {
                            doc_img.find('.cur').removeClass('cur').next().addClass('cur');
                            doc_img.animate({
                                marginLeft: 0 - (doc_img.find('.cur').width() * doc_img.find('.cur').index())
                            }, param.animate_speed, function () {
                                if (doc_img.find('.cur').index() == doc_img.find('li').length - 1) {
                                    doc_img.find('li:first-child').addClass('cur').siblings().removeClass('cur')
                                    doc_img.css('margin-left', '0')
                                }
                            })
                            set_nav(0);
                        }, param.time)
                        break;
                    case "y":
                        doc_img.addClass('animation_y')
                        doc_img.css('height', doc_img.find('li').length * doc_img.find('.cur').height())
                        a = setInterval(function () {
                            doc_img.find('.cur').removeClass('cur').next().addClass('cur');
                            doc_img.animate({
                                marginTop: 0 - (doc_img.find('.cur').height() * doc_img.find('.cur').index())
                            }, param.animate_speed, function () {
                                if (doc_img.find('.cur').index() == doc_img.find('li').length - 1) {
                                    doc_img.find('li:first-child').addClass('cur').siblings().removeClass('cur')
                                    doc_img.css('margin-top', '0')
                                }
                            })
                            set_nav(0);
                        }, param.time)
                        break;
                    case "d":
                        doc_img.addClass('animation_d')
                        if (param.self_adaption) {
                            $this.addClass('self_adaption');
                            doc_img.find('li img').addClass('self_adaption');
                        }
                        a = setInterval(function () {
                            if (doc_img.find('.cur').index() == doc_img.find('li').length - 1) {
                                doc_img.find('li:first-child').fadeIn().addClass('cur').siblings().removeClass('cur').hide()
                            } else {
                                doc_img.find('.cur').removeClass('cur').hide().next().fadeIn().addClass('cur');
                            }
                            set_nav(0);
                        }, param.time)
                        break;
                }
            }

            //停止动画
            function stopA() {
                clearInterval(a)
            }

            //翻页
            left.click(function () {
                switch (param.animation) {
                    case "x":
                        if (parseInt(doc_img.css('margin-left')) === 0) {
                            doc_img.find('li:last-child').addClass('cur').siblings().removeClass('cur')
                            doc_img.animate({
                                marginLeft: 0 - (doc_img.find('.cur').width() * (doc_img.find('li').length - 1))
                            }, param.animate_speed)
                        } else {
                            doc_img.find('.cur').removeClass('cur').prev().addClass('cur');
                            var num = doc_img.find('.cur').width() * doc_img.find('.cur').index();
                            num = num == 0 ? 0 - parseInt(doc_img.css('margin-left')) : num;
                            doc_img.animate({
                                marginLeft: parseInt(doc_img.css('margin-left')) + num
                            }, param.animate_speed)
                        }
                        break;
                    case "y":
                        if (parseInt(doc_img.css('margin-top')) === 0) {
                            doc_img.find('li:last-child').addClass('cur').siblings().removeClass('cur')
                            doc_img.animate({
                                marginTop: 0 - (doc_img.find('.cur').height() * (doc_img.find('li').length - 1))
                            }, param.animate_speed)
                        } else {
                            doc_img.find('.cur').removeClass('cur').prev().addClass('cur');
                            var num = doc_img.find('.cur').height() * doc_img.find('.cur').index();
                            num = num == 0 ? 0 - parseInt(doc_img.css('margin-top')) : num;
                            doc_img.animate({
                                marginTop: parseInt(doc_img.css('margin-top')) + num
                            }, param.animate_speed)
                        }
                        break;
                    case "d":
                        if (doc_img.find('.cur').index() === 0) {
                            doc_img.find('li:last-child').fadeIn().addClass('cur').siblings().removeClass('cur').hide()
                        } else {
                            doc_img.find('.cur').removeClass('cur').hide().prev().fadeIn().addClass('cur');
                        }
                        break;
                }
            })
            right.click(function () {
                switch (param.animation) {
                    case "x":
                        if (doc_img.find('.cur').index() == doc_img.find('li').length - 1) {
                            doc_img.find('li:first-child').addClass('cur').siblings().removeClass('cur')
                        } else {
                            doc_img.find('.cur').removeClass('cur').next().addClass('cur');
                        }
                        doc_img.animate({
                            marginLeft: 0 - (doc_img.find('.cur').width() * doc_img.find('.cur').index())
                        }, param.animate_speed)
                        break;
                    case "y":
                        if (doc_img.find('.cur').index() == doc_img.find('li').length - 1) {
                            doc_img.find('li:first-child').addClass('cur').siblings().removeClass('cur')
                        } else {
                            doc_img.find('.cur').removeClass('cur').next().addClass('cur');
                        }
                        doc_img.animate({
                            marginTop: 0 - (doc_img.find('.cur').height() * doc_img.find('.cur').index())
                        }, param.animate_speed)
                        break;
                    case "d":
                        if (doc_img.find('.cur').index() == doc_img.find('li').length - 1) {
                            doc_img.find('li:first-child').fadeIn().addClass('cur').siblings().removeClass('cur').hide()
                        } else {
                            doc_img.find('.cur').removeClass('cur').hide().next().fadeIn().addClass('cur');
                        }
                        break;
                }
            })

//			导航按钮
            function set_nav(type) {
                switch (type) {
                    case 0://默认
                        if (doc_nav.find('.cur').index() == doc_nav.find('li').length - 1) {
                            doc_nav.find('li:first-child').addClass('cur').siblings().removeClass('cur');
                        } else {
                            doc_nav.find('.cur').next().addClass('cur').siblings().removeClass('cur');
                        }
                        break;
                    case 1://hover状态
                        doc_nav.find('li').hover(function () {
                            $(this).addClass('cur').siblings().removeClass('cur');
                            doc_img.find('li').eq(doc_nav.find('.cur').index()).addClass('cur').siblings().removeClass('cur');
                            switch (param.animation) {
                                case "x":
                                    doc_img.animate({
                                        marginLeft: 0 - (doc_img.find('.cur').width() * $(this).index())
                                    }, 100)
                                    break;
                                case "y":
                                    doc_img.animate({
                                        marginTop: 0 - (doc_img.find('.cur').height() * $(this).index())
                                    }, 100)
                                    break;
                                case "d":
                                    doc_img.find('li').eq($(this).index()).fadeIn().addClass('cur').siblings().hide().removeClass('cur');
                                    break;
                            }
                        })
                        break;
                }
            }
        }
    })
})(jQuery)
