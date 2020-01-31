//加减
;(function ($) {
    $.fn.extend({
        Aas: function (option) {
            var defaults = {
                jia: this.find('' + option.jia + ''),
                jian: this.find('' + option.jian + ''),
                val: this.find('' + option.val + ''),
                max: option.max,
                callback: option.callback
            };
            var opt = $.extend(defaults, option);
            this.each(function () {

                var _this = $(this);
                var _val = _this.find(opt.val);
                var _jian = _this.find(opt.jian);
                var _jia = _this.find(opt.jia);
//				加
                _jia.on('click', function () {
                    _val.val(parseInt(_val.val()) + 1)
                    if (_this.find(opt.val).val() >= opt.max) {
                        _val.val(opt.max);
                    }
                    opt.callback()
                });
//				减
                _jian.on('click', function () {
                    _val.val(parseInt(_val.val()) - 1)
                    if (_val.val() <= 1) {
                        _val.val(1);
                    }
                    opt.callback()
                });
//				input框输入时判断上限
                _val.keyup(function () {
                    if (parseInt($(this).val()) > parseInt(opt.max)) {
                        $(this).val(opt.max);

                    }
                    opt.callback()
                })
            })
        }
    })
})(jQuery)
