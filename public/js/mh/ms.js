//秒杀
;
(function ($) {
    $.fn.extend({
        ms: function (option) {
            var defaults = {
                now_time: option.now_time, //当前时间
                start_time: option.start_time, //活动开始时间
                end_time: option.end_time, //活动结束时间
                day: this.find('' + option.day + ''), //天  有没有天下面会自行转换时间 没有可布写
                hourse: this.find('' + option.hourse + ''), //小时
                minute: this.find('' + option.minute + ''), //分钟
                second: this.find('' + option.second + ''), //秒
                parent: $(option.parent), //点击切换的父元素  一定为ul 因为默认取该节点的子集li
                content: $(option.content), //切换的内容 一定为ul 因为默认取该节点的子集li
                Boolean: option.Boolean, //定时器为0后的操作 true为清除定时器
                callback: option.callback, //自定义方法
                time_zt: option.time_zt, //title
                remaintime_zt: option.remaintime_zt, //时间前面的状态文字
                current: option.current, //当前点击需要增加的classname
                ajax_url: option.ajax_url  //ajax
            };
            var o = $.extend(defaults, option);
            var dsq; //申明定时器
            var time_arr = [];
            var jieshu; //结束时间减去当前时间再换算成秒取整
            var now_check = -1;
            var sjs = Math.random() * 1000 + 1;
            var h = $(o.parent).children('li').height();
            var tar;
            this.each(function () {
                var _this = this;
                $(o.parent).find('li').hover(function () {
                    $(this).click();
                });
                for (var i = 0; i < o.state.length; i++) {
                    if (o.state[i] == 1) {  //判断是否手动结束 1为不结束 2为结束 数组对应秒杀时间断的数组
                        $(o.parent).children('li').click(function () {
                            tar = $(this).index(); //获取当前点击下标

                            var start = parseInt($(this).data('start')); //当前秒杀类的开始时间

                            var end = parseInt($(this).data('end')); //当前秒杀类的结束时间

                            $(this).addClass(o.current).siblings('li').removeClass(o.current); //增加选中样式

                            $(o.content).children('li').eq(tar).addClass(o.current).siblings('li').removeClass(o.current); //下标绑定切换产品

                            if (o.now_time < start) { //当当前时间小于开始时间

                                $(o.remaintime_zt).html("开始"); //改变时间段文字为开始

                                $(o.parent).children('li').eq(tar).find('.zt').html("即将开始"); //改变title为即将开始

                                $(this).removeClass('time_ing'); //去除进行中的样式

                                $(this).data('hdcheck', 0);  //李龙的属性，我也布晓得是啥

                                $(o.content).children('li').eq(tar).find('.btn').text('即将开始'); //改变购买按钮文字为即将开始

                                kc(); //执行库存判断
                                $(o.content).children('li').eq(tar).find('.btn_box').removeClass('qiang'); //去除按钮抢购的样式

                                jieshu = start - o.now_time; //重新对定时器倒计时赋值

                            } else if (o.now_time >= start && o.now_time < end) { //判断当前时间正在秒杀时间之内

                                $(o.remaintime_zt).html("结束"); //改变时间段文字为结束

                                $(o.parent).children('li').eq(tar).find('.zt').html("正在秒杀"); //改变title为正在秒杀

                                $(this).addClass('time_ing').removeClass('time_begin'); //去除即将开始的样式

                                $(this).data('hdcheck', 1);//李龙的属性，我也布晓得是啥

                                $(o.content).children('li').eq(tar).find('.btn').text('正在秒杀'); //改变购买按钮文字为正在秒杀

                                kc(); //执行库存判断

                                jieshu = end - o.now_time; //重新对定时器倒计时赋值

                            } else if (o.now_time >= end) { //判断当前时间大于或者等于结束时间

                                $(o.parent).children('li').eq(tar).css('line-height', h + 'px').html("秒杀结束"); //对title的line-height进行自身高度赋值

                                $(this).data('hdcheck', 2); //李龙的属性，我也布晓得是啥

                                $(o.content).children('li').eq(tar).find('.sp_box').data('kc', 0) //把所有data库存赋值为0 以免点击购买按钮出错

                                $(o.content).children('li').eq(tar).find('.sl span').text('0') //把所有库存赋值为0

                                $(o.content).children('li').eq(tar).find('.btn').text('已抢完').addClass('maiwan').removeClass('qiang'); //改变结束后的按钮状态

                                $(o.content).children('li').eq(tar).find('.none').show(); //显示卖完图片
                            }

                            //以下为时间切换平滑
                            minite = Math.floor((jieshu / 60) % 60); //计算分

                            hour = Math.floor((jieshu / 3600)); //计算小时

                            $("." + _this.className + " " + o.hourse).html(hour);

                            $("." + _this.className + " " + o.minute).html(minite);

                        });

                    } else if (o.state[i] == 2) {  //当state为2时默认该时间段的所有秒杀为结束
                        judge()
                        $(o.parent).children('li').eq(i).css('line-height', h + 'px');
                        $(o.parent).children('li').eq(i).html("秒杀结束");
                        $(o.content).children('li').eq(i).find('.sl').html("数量：0")
                        $(o.content).children('li').eq(i).find('.btn_box').addClass('btn_box_maiwan').removeClass('qiang')
                        $(o.content).children('li').eq(i).find('.sp_box').data('kc', 0)
                        $(o.content).children('li').eq(i).find('.none').show();
                    }

                }
                judge();
                remaintime();
                window.setInterval(remaintime, 1000);

                function judge() {
                    if (o.now_time < o.start_time) {
                        $(o.parent).children('li').eq(0).click();
                        time_arr.push($(o.parent).children('li').eq(0).data('start'));
                        time_arr.push($(o.parent).children('li').eq(0).data('end'));
                    } else if (o.now_time > o.end_time) {
                        $(o.parent).children('li').eq(0).click();
                    }
                    else {
                        $(o.parent).children('li').each(function (index) {
                            var tar = index;
                            var _this = $(o.parent).children('li').eq(tar);
                            time_arr.push(_this.data('start'));
                            time_arr.push(_this.data('end'));
                            if (o.now_time >= _this.data('start')) {
                                _this.click();
                                now_check = tar;
                            }
                        });
                        var hdcheck = $(o.content).children('li').eq(now_check).data('hdcheck');
                        if (hdcheck == 2) {
                            $(o.parent).children('li').eq(now_check + 1).click();
                        }
                    }
                }

                function remaintime() {
                    o.now_time++;
                    jieshu--; //时间递减
                    //申明时间
                    var s = Math.floor(jieshu % 60), // 计算秒
                        m = Math.floor((jieshu / 60) % 60), //计算分
                        d = Math.floor(jieshu / 86400), //计算天
                        h;

                    //判断是否传递了天这个参数
                    if (typeof o.day == "string") {
                        h = Math.floor((jieshu / 3600) % 24); //当有天的时候计算小时
                        $("." + _this.className + " " + o.day).html(d);
                    } else {
                        h = Math.floor(jieshu / 3600); //当没有天的时候计算小时
                    }
                    //传递Boolean值为true时 清除定时器
                    if (o.Boolean == true) {
                        if (jieshu <= 0) {
                            clearInterval(dsq);
                        }
                    }
                    $("." + _this.className + " " + o.hourse).html(h);
                    $("." + _this.className + " " + o.minute).html(m);
                    $("." + _this.className + " " + o.second).html(s);
                    if ($.inArray(o.now_time, time_arr) != -1) {
                        judge();
                    }
                    //判断是否有该参数传递，当有时执行自定义方法  没有则不执行
                    if (o.callback != undefined) {
                        //执行自定义方法
                        o.callback(o.hourse, o.minute, o.second, o.day, o.parent, o.content, o.Boolean, o.start_time, o.end_time, o.now_time);
                    }
                }

                //判断库存
                function kc() {
                    $(o.content).children('li').eq(tar).find('.sp_box').each(function () {
                        var kc = $(this).data('kc');
                        if (kc > 0) {
                            //										$(this).find('.btn').text('立即抢购');
                            $(this).find('.btn_box').addClass('qiang').removeClass('maiwan');
                            $(this).find('.btn').unbind('click');
                            $(this).find('.btn').bind('click', function () {
                                var goods_id = $(this).data('id');
                                add_to_redis(goods_id)
                            });
                            $(this).find('.sl span').text($(this).data('kc'))
                        } else {
                            $(this).find('.btn').text('已抢完').addClass('maiwan').removeClass('qiang');
                            $(this).find('.sl span').text(0)
                            $(this).find('.btn_box').addClass('btn_box_maiwan');
                            $(this).find('.none').show()
                        }
                    });
                }

                function add_to_redis(id) {
                    var type = $('#' + id).data('type');
                    var group_id = $('#' + id).data('group');
                    if (type != 0 && type != -1) {
                        $('#' + id).data('type', -1);
                        layer.load(1, {
                            shade: [0.1, '#fff'] //0.1透明度的白色背景
                        });
                        setTimeout(function () {
                            $.ajax({
                                url: '/ms',
                                type: 'post',
                                data: {
                                    goods_id: id,
                                    group_id: group_id,
                                },
                                dataType: 'json',
                                complete: function () {
                                    layer.closeAll('loading');
                                },
                                success: function (result) {
                                    if (result) {
                                        if (result.error == 0) {
                                            if (result.kc <= 0) {
                                                result.kc = 0;
                                                $('#btn' + id).addClass('maiwan').removeClass('begin').removeClass('qiang');
                                                $('#btn' + id).text('已抢完');
                                                $('#none' + id).show();
                                            }
                                            $('#kc' + id).text(result.kc);
                                            $('#' + id).data('kc', result.kc);
                                            layer.confirm(result.msg, {
                                                btn: ['继续购物', '去结算'], //按钮
                                                icon: 1
                                            }, function (index) {
                                                layer.close(index);
                                            }, function () {
                                                location.href = '/cart';
                                                return false;
                                            });
                                        } else if (result.error == 2) {
                                            layer.confirm(result.msg, {
                                                btn: ['注册', '登录'], //按钮
                                                icon: 2
                                            }, function () {
                                                location.href = '/auth/register';
                                            }, function () {
                                                location.href = '/auth/login';
                                                return false;
                                            });
                                        } else {
                                            layer.msg(result.msg, {
                                                icon: result.error + 1
                                            });
                                        }
                                        $('#' + id).data('type', result.error)
                                    }
                                }
                            })
                        }, sjs)
                    } else if (type == 0) {
                        layer.confirm('商品已抢购', {
                            btn: ['继续购物', '去结算'], //按钮
                            icon: 1
                        }, function (index) {
                            layer.close(index);
                        }, function () {
                            location.href = '/cart';
                            return false;
                        });
                    }
                }
            })

        }
    })
})(jQuery)