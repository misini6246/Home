/**
 * Created by wang on 14-8-13.
 */

(function($){
    var banner=function(element,option){
        var $this=this;
        this.parents=$(element);
        this.$e=$(element).find(".slide_detail");//父元素
        this.slideImg=this.$e.find("li a");//所有轮换元素
        this.option=option;//设置
        this.att = this.option.hover ? "data-slide-to" : "data-slide";
        this.parents.parent().bind("mouseover",function(e){
            e.preventDefault();
            $.proxy($this.stop(),$this);
            $(this).find("[data-slide]").stop().animate({opacity: 0.7},200);
        });
        this.parents.parent().bind("mouseout", function(e){
            e.preventDefault();
            $.proxy($this.auto(),$this);
            $(this).find("[data-slide]").stop().animate({opacity: 0},200);
        });
        this.parents.find("[data-slide-to]").live("mouseover",function(e){
            e.preventDefault();
            var data=$(this).attr("data-slide-to");
            $this.waitTime=setTimeout(function(){
                $.proxy($this.to(data),$this);
            },100);
        });
        this.parents.find("[data-slide-to]").live("mouseout", function(e){
            e.preventDefault();
            e.stopPropagation();
            clearTimeout($this.waitTime);
        });
        this.parents.siblings("[data-slide]").live("click",function(e){
            e.preventDefault();
            var data=$(this).attr("data-slide");
            $.proxy($this.to(data),$this);
        });
    };
    banner.prototype={
        getActiveIndex: function(){
            this.active=this.slideNum.filter(".on");//当前显示元素
            return this.active.index()+1;
        },next: function(){
            this.to("next");
        },prev: function(){
            this.to("prev");
        },to:function(index){
            this.slideNum=this.parents.find(".slideNumber li");//所有数字
            this.slideLi=this.$e.find("li");
            this.activeImg=this.slideLi.eq(this.getActiveIndex()-1);
            if(this.getActiveIndex()!=index){
                if(index=="next"){
                    if(this.getActiveIndex()<this.slideNum.length){
                        this.slide(this.getActiveIndex()+1);
                    }else{
                        this.slide(1);
                    }
                }else if(index=="prev"){
                    if(this.getActiveIndex()>1){
                        this.slide(this.getActiveIndex()-1);
                    }else{
                        this.slide(this.slideNum.length);
                    }
                }else if(/^[0-9]+$/.test(index)){
                    this.slide(index);
                }
            }
        },slide: function(index){//切换
            this.slideImg=this.$e.find("li a");//所有轮换元素
            var $this=this;
            var width=parseInt(this.slideImg.find("img").width());
            if(this.option.type=="fade"){
                $this.slideLi.stop(false,true).fadeOut(600);
                $this.slideLi.eq(index-1).stop(false,true).fadeIn(600);
            }else if(this.option.type=="blinds"){
                var img=this.slideImg.find("img").eq(index-1).attr("src");
                var oLeft=($this.slideImg.width()-$this.parents.width())/2;
                if(!$this.parents.children("div").length){
                    var html=
                        "<div style='height: 100%;width: 100%;position: absolute;top: 0;left: 0;overflow: hidden'>" +
                            "<div style='width: 33.33%;height: 100%;float: left;background: url("+img+") "+(-width)+"px 0 no-repeat'></div>" +
                            "<div style='width: 33.33%;height: 100%;float: left;background: url("+img+") "+(-width)+"px 0 no-repeat'></div>" +
                            "<div style='width: 33.33%;height: 100%;float: left;background: url("+img+") "+(-width)+"px 0 no-repeat'></div>" +
                        "</div>";
                    this.parents.append(html);
                    var div=this.parents.find("div div");
                }else{
                    var par_children=$this.parents.children("div");
                    div=par_children.find("div");
                    div.css({backgroundImage: "url("+img+")",backgroundPositionX: -width+"px"});
                    par_children.css({display: "block"});
                }
                div.eq(0).stop().animate({backgroundPositionX: -oLeft+"px"},900);
                div.eq(1).stop().animate({backgroundPositionX: -(oLeft+1/3*width)+"px"},1200);
                div.eq(2).stop().animate({backgroundPositionX: -(oLeft+2/3*width)+"px"},1500,function(){
                    $this.slideLi.removeClass("active");
                    $this.slideLi.eq(index-1).addClass("active");
                    div.css({backgroundImage: "none"});
                    $this.parents.children("div").css({display: "none"});
                    div=null;
                    $this=null;
                    width=null;
                });
            }else{
                setTimeout(function(){
                    $this.$e.stop().animate({
                        marginLeft: (-(index-1)*width)+"px"
                    });
                },300);
            }
            $this.slideNum.filter("["+$this.att+"="+this.getActiveIndex()+"]").removeClass("on");
            $this.slideNum.filter("["+$this.att+"="+index+"]").addClass("on");
        },auto: function(){//自动
            var $this=this;
            clearInterval(this.interval);
            this.interval=setInterval(function(){$this.to("next");},$this.option.time);
        },stop: function(){//停止
            if(this.interval){
                clearInterval(this.interval);
            }
        },createNum: function(){//添加轮播数字
            if(this.option.width){
                this.parents.css({width: this.option.width+"px",marginLeft: -this.option.width/2+"px"});
                if(this.option.type=="fade"){
                    this.$e.css({width: this.option.width+"px"});
                }else{
                    this.$e.css({width: this.option.width*this.slideImg.length+"px"});
                }
                this.$e.find("li").css({width: this.option.width+"px"});
            }
            if(this.option.height){
                this.parents.css({height: this.option.height+"px"});
            }
            var html="<li class='on' "+this.att+"=1></li>";
            for (var i = 1; i < this.slideImg.length; i++) {
                html+="<li "+this.att+"="+(i+1)+"> </li>";
            }
            this.parents.find(".slideNumber").html(html);
        }
    };

    /**
     * 幻灯片插件
     * @param option
     *         {
     *          type:  幻灯片类型，fade：图片透明度切换，其他为滑动切换
     *          time:  幻灯片切换时间
     *          hover: 点击数字图片切换方式，true：hover，false：click，默认true
     *          width: 轮播里面的宽度
     *          height:轮播里面的高度
     *         }
     * @returns {*}
     */

    $.fn.slide=function(option){
        var opt= $.extend({},$.fn.slide.defaults, option);
        return this.each(function() {
            var ban= new banner(this, opt);
            ban.createNum();
            ban.auto();
        });
    };
    $.fn.slide.defaults={
        type: "fade",//幻灯片类型，fade：图片透明度切换，其他为滑动切换
        time: 5000,
        hover:true//图片切换是hover还是click
    }
})(jQuery);