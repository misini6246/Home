(function($){
    var PopUpWin = function(ele,opts){
        opts = $.extend({
            id:'',
            content:undefined,//内容
            closeCallback:undefined//关闭时调用的方法
        },opts);
        this.init(ele,opts);
    }

    PopUpWin.prototype = {
        template:'<div class="pop-wraper" id="{id}">\
                <div class="pop-outer">\
                    <div class="pop-inner">\
                        <div class="pop-content">\
                            {content}\
                        </div>\
                        <div class="btn btn_cancel"><i class="ico_cancel"></i></div>\
                    </div>\
                </div>\
            </div>',
        init:function(ele,opts){
            this.render(ele,opts);
            this.initEvent(ele,opts);
        },
        initEvent:function(ele,opts){
            var self = this;
            ele.find('.btn_cancel').click(function(){
                ele.find('#'+self.id).remove();
                if(opts.closeCallback !== undefined && $.isFunction(opts.closeCallback)){
                    opts.closeCallback();
                }
            });
        },
        elId:function(){//自动生成7位8进制DOM元素ID
            return 'win-xxx'.replace(/[x]/g,function(c){
                var r = Math.random() * 16|0, v = c === 'x' ? r : (r&0x3|0x8);
                return v.toString(8);
            }).toLocaleLowerCase();
        },
        render:function(ele,opts){
            if(ele === undefined){
                ele = $('body');
            }
            
            var content = opts.content;
            this.id = this.elId();
            
            if($.isFunction(content)){
                content  = content(this);
            }
                tpl = this.template.replace(/\{id\}/,this.id).replace(/\{content\}/,content);
            ele.append(tpl);
        }
    };

    $.fn.popUpWin = function(opts){
        return this.each(function(){
             var that = $(this);
             var popUp = new PopUpWin(that,opts);
        });
    };

})(jQuery);



(function(win,$,h){
    $(document).ready(function(){
         var routeUrl = {
            'orderInfo':'order.html',//订单提交页面
            'orderInfo_method':'submitOrderInfo',//订单提交action方法
            'queryOrder':'queryOrder.html',
            'queryOrder_method':'queryOrder',
            'refundTest':'refundTest.html',
            'refundTest_method':'submitRefund',
            'queryRefund':'queryRefund.html',
            'queryRefund_method':'queryRefund'
        }, validateField = {//需要验证的字段
            'orderInfo':['out_trade_no','body','total_fee','mch_create_ip'],//字段名
            'orderInfo_msg':['商户订单号','商品描述','总金额','终端IP'],//字段对应的中文名
            'refundTest':['out_refund_no','total_fee','refund_fee'],
            'refundTest_msg':['商户退款单号','总金额','退款金额']
        };

        
        



        $('#pay_platform').delegate('span','click',function(e){
            if(e.target.className.indexOf('submit') === -1){
                return;
            }

            var input = $('div.form_wrap').find('input,select'), param = {method:'submitOrderInfo'}, vField = validateField[curPage];
            input.each(function(i,item){
                item = $(item);
                var vType = item.attr('vtype'), ind = 0;
                param[item.attr('name')] = item.val();
            });

            //判断不能为空的字段
            if(vField !== undefined){
                for(var i=0, field='', msg = ''; i<vField.length; i++){
                    field = vField[i];
                    msg = validateField[curPage+'_msg'][i];
                    if(param[field] === ''){
                        $('body').popUpWin({
                            content:msg+'不能为空！'
                        });
                        return;
                    }
                }
            }
            //设计提交方法
            param['method']=routeUrl[curPage+'_method'];

            var mask = $('<div class="mask"></div>');
                $('body').append(mask);
            $.post('/payInterface_native/request.php',param,function(res){
                $('body').find('.mask').remove();
                if(typeof(res) === 'string'){
                    res = JSON.parse(res);
                }

                if(res.status === 500){
                    _content = res.msg;
                    $('body').popUpWin({
                        content:res.msg
                    });
                }else{
                    if(curPage === 'orderInfo'){ 
						$('body').popUpWin({
							content:function(){
								return '<img src="'+res.code_img_url+'" /><div class="msg_default_box"><i class="icon60_qr pngFix"></i><p>请使用微信扫描<br>二维码以完成支付</p></div>';
							},
							closeCallback:function(){
								self.popWin = undefined;
								self.opts.qrCodeClose = true;
							}
						}); 
                    }else{
                        $('body').popUpWin({
                            content:res.msg
                        });
                    }
                }

                
            });
        });
    });
})(window,jQuery);