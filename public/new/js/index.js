		jQuery(".picScroll-left").slide({titCell:".hd ul",mainCell:".bd ul",autoPage:true,effect:"left",autoPlay:true,vis:5,trigger:"click"});
			$('.dongtai1').click(function(){
				$('.news1 ul').css('display','block');
				$('.news2 ul').css('display','none');
				$('.banner-right-hr').css('display','block');
				$('.banner-right-hr1').css('display','none');
                $('.dongtai1').css('color','#333333');
                $('.cuxiao1').css('color','#777777');
			});
			$('.cuxiao1').click(function(){
				$('.news2 ul').css('display','block');
				$('.news1 ul').css('display','none');
				$('.banner-right-hr').css('display','none');
				$('.banner-right-hr1').css('display','block');
                $('.cuxiao1').css('color','#333333');
                $('.dongtai1').css('color','#777777');
			});




//各版块的小图轮播
$(function(){
    var sWidth = $("#focus").width(); //获取焦点图的宽度（显示面积）
    var len = $("#focus ul li").length; //获取焦点图个数
    var index = 0;
    var picTimer;

    //以下代码添加数字按钮和按钮后的半透明条，还有上一页、下一页两个按钮
    var btn = "<div class='btnBg'></div><div class='btn'>";

    for(var i=0; i < len; i++) {
        btn += "<span></span>";
    }
    btn += "</div><div class='preNext pre'></div><div class='preNext next'></div>";
    if(len>1) {
        $("#focus").append(btn);
    }
    $("#focus .btnBg").css("opacity",0.5);

    //为小按钮添加鼠标滑入事件，以显示相应的内容
    $("#focus .btn span").css("opacity",0.4).mouseover(function() {
        index = $("#focus .btn span").index(this);
        showPics(index);
    }).eq(0).trigger("mouseover");

    //上一页、下一页按钮透明度处理
    $("#focus .preNext").css("opacity",0.2).hover(function() {
        $(this).stop(true,false).animate({"opacity":"0.5"},300);
    },function() {
        $(this).stop(true,false).animate({"opacity":"0.2"},300);
    });

    //上一页按钮
    $("#focus .pre").click(function() {
        index -= 1;
        if(index == -1) {index = len - 1;}
        showPics(index);
    });

    //下一页按钮
    $("#focus .next").click(function() {
        index += 1;
        if(index == len) {index = 0;}
        showPics(index);
    });

    //本例为左右滚动，即所有li元素都是在同一排向左浮动，所以这里需要计算出外围ul元素的宽度
    $("#focus ul").css("width",sWidth * (len));

    //鼠标滑上焦点图时停止自动播放，滑出时开始自动播放
    $("#focus").hover(function() {
        clearInterval(picTimer);
    },function() {
        picTimer = setInterval(function() {
            showPics(index);
            index++;
            if(index == len) {index = 0;}
        },4000); //此4000代表自动播放的间隔，单位：毫秒
    }).trigger("mouseleave");

    //显示图片函数，根据接收的index值显示相应的内容
    function showPics(index) { //普通切换
        var nowLeft = -index*sWidth; //根据index值计算ul元素的left值
        //$("#focus ul").stop(true,false).animate({"left":nowLeft},300); //通过animate()调整ul元素滚动到计算出的position
        $("#focus ul").stop(true,false).animate({"left":nowLeft},300);
        $("#focus .title").text($("#focus ul li").eq(index).contents("a").contents("img").attr("alt"));
        $("#focus .btn span").stop(true,false).animate({"opacity":"0.4"},300).eq(index).stop(true,false).animate({"opacity":"1"},300); //为当前的按钮切换到选中的效果
    }
});

//第二个
$(function() {
    var sWidth = $("#focus1").width(); //获取焦点图的宽度（显示面积）
    var len = $("#focus1 ul li").length; //获取焦点图个数
    var index = 0;
    var picTimer;

    //以下代码添加数字按钮和按钮后的半透明条，还有上一页、下一页两个按钮
    var btn = "<div class='btnBg'></div><div class='btn'>";

    for(var i=0; i < len; i++) {
        btn += "<span></span>";
    }
    btn += "</div><div class='preNext pre'></div><div class='preNext next'></div>";
    if(len>1) {
        $("#focus1").append(btn);
    }
    $("#focus1 .btnBg").css("opacity",0.5);

    //为小按钮添加鼠标滑入事件，以显示相应的内容
    $("#focus1 .btn span").css("opacity",0.4).mouseover(function() {
        index = $("#focus1 .btn span").index(this);
        showPics(index);
    }).eq(0).trigger("mouseover");

    //上一页、下一页按钮透明度处理
    $("#focus1 .preNext").css("opacity",0.2).hover(function() {
        $(this).stop(true,false).animate({"opacity":"0.5"},300);
    },function() {
        $(this).stop(true,false).animate({"opacity":"0.2"},300);
    });

    //上一页按钮
    $("#focus1 .pre").click(function() {
        index -= 1;
        if(index == -1) {index = len - 1;}
        showPics(index);
    });

    //下一页按钮
    $("#focus1 .next").click(function() {
        index += 1;
        if(index == len) {index = 0;}
        showPics(index);
    });

    //本例为左右滚动，即所有li元素都是在同一排向左浮动，所以这里需要计算出外围ul元素的宽度
    $("#focus1 ul").css("width",sWidth * (len));

    //鼠标滑上焦点图时停止自动播放，滑出时开始自动播放
    $("#focus1").hover(function() {
        clearInterval(picTimer);
    },function() {
        picTimer = setInterval(function() {
            showPics(index);
            index++;
            if(index == len) {index = 0;}
        },4000); //此4000代表自动播放的间隔，单位：毫秒
    }).trigger("mouseleave");

    //显示图片函数，根据接收的index值显示相应的内容
    function showPics(index) { //普通切换
        var nowLeft = -index*sWidth; //根据index值计算ul元素的left值
        //$("#focus ul").stop(true,false).animate({"left":nowLeft},300); //通过animate()调整ul元素滚动到计算出的position
        $("#focus1 ul").stop(true,false).animate({"left":nowLeft},300);
        $("#focus1 .title").text($("#focus1 ul li").eq(index).contents("a").contents("img").attr("alt"));
        $("#focus1 .btn span").stop(true,false).animate({"opacity":"0.4"},300).eq(index).stop(true,false).animate({"opacity":"1"},300); //为当前的按钮切换到选中的效果
    }
});
//第二个


//第三个
$(function() {
    var sWidth = $("#focus2").width(); //获取焦点图的宽度（显示面积）
    var len = $("#focus2 ul li").length; //获取焦点图个数
    var index = 0;
    var picTimer;

    //以下代码添加数字按钮和按钮后的半透明条，还有上一页、下一页两个按钮
    var btn = "<div class='btnBg'></div><div class='btn'>";

    for(var i=0; i < len; i++) {
        btn += "<span></span>";
    }
    btn += "</div><div class='preNext pre'></div><div class='preNext next'></div>";
    if(len>1) {
        $("#focus2").append(btn);
    }
    $("#focus2 .btnBg").css("opacity",0.5);

    //为小按钮添加鼠标滑入事件，以显示相应的内容
    $("#focus2 .btn span").css("opacity",0.4).mouseover(function() {
        index = $("#focus2 .btn span").index(this);
        showPics(index);
    }).eq(0).trigger("mouseover");

    //上一页、下一页按钮透明度处理
    $("#focus2 .preNext").css("opacity",0.2).hover(function() {
        $(this).stop(true,false).animate({"opacity":"0.5"},300);
    },function() {
        $(this).stop(true,false).animate({"opacity":"0.2"},300);
    });

    //上一页按钮
    $("#focus2 .pre").click(function() {
        index -= 1;
        if(index == -1) {index = len - 1;}
        showPics(index);
    });

    //下一页按钮
    $("#focus2 .next").click(function() {
        index += 1;
        if(index == len) {index = 0;}
        showPics(index);
    });

    //本例为左右滚动，即所有li元素都是在同一排向左浮动，所以这里需要计算出外围ul元素的宽度
    $("#focus2 ul").css("width",sWidth * (len));

    //鼠标滑上焦点图时停止自动播放，滑出时开始自动播放
    $("#focus2").hover(function() {
        clearInterval(picTimer);
    },function() {
        picTimer = setInterval(function() {
            showPics(index);
            index++;
            if(index == len) {index = 0;}
        },4000); //此4000代表自动播放的间隔，单位：毫秒
    }).trigger("mouseleave");

    //显示图片函数，根据接收的index值显示相应的内容
    function showPics(index) { //普通切换
        var nowLeft = -index*sWidth; //根据index值计算ul元素的left值
        //$("#focus ul").stop(true,false).animate({"left":nowLeft},300); //通过animate()调整ul元素滚动到计算出的position
        $("#focus2 ul").stop(true,false).animate({"left":nowLeft},300);
        $("#focus2 .title").text($("#focus2 ul li").eq(index).contents("a").contents("img").attr("alt"));
        $("#focus2 .btn span").stop(true,false).animate({"opacity":"0.4"},300).eq(index).stop(true,false).animate({"opacity":"1"},300); //为当前的按钮切换到选中的效果
    }
});
//第三个

//第四个
$(function() {
    var sWidth = $("#focus3").width(); //获取焦点图的宽度（显示面积）
    var len = $("#focus3 ul li").length; //获取焦点图个数
    var index = 0;
    var picTimer;

    //以下代码添加数字按钮和按钮后的半透明条，还有上一页、下一页两个按钮
    var btn = "<div class='btnBg'></div><div class='btn'>";

    for(var i=0; i < len; i++) {
        btn += "<span></span>";
    }
    btn += "</div><div class='preNext pre'></div><div class='preNext next'></div>";
    if(len>1) {
        $("#focus3").append(btn);
    }
    $("#focus3 .btnBg").css("opacity",0.5);

    //为小按钮添加鼠标滑入事件，以显示相应的内容
    $("#focus3 .btn span").css("opacity",0.4).mouseover(function() {
        index = $("#focus3 .btn span").index(this);
        showPics(index);
    }).eq(0).trigger("mouseover");

    //上一页、下一页按钮透明度处理
    $("#focus3 .preNext").css("opacity",0.2).hover(function() {
        $(this).stop(true,false).animate({"opacity":"0.5"},300);
    },function() {
        $(this).stop(true,false).animate({"opacity":"0.2"},300);
    });

    //上一页按钮
    $("#focus3 .pre").click(function() {
        index -= 1;
        if(index == -1) {index = len - 1;}
        showPics(index);
    });

    //下一页按钮
    $("#focus3 .next").click(function() {
        index += 1;
        if(index == len) {index = 0;}
        showPics(index);
    });

    //本例为左右滚动，即所有li元素都是在同一排向左浮动，所以这里需要计算出外围ul元素的宽度
    $("#focus3 ul").css("width",sWidth * (len));

    //鼠标滑上焦点图时停止自动播放，滑出时开始自动播放
    $("#focus3").hover(function() {
        clearInterval(picTimer);
    },function() {
        picTimer = setInterval(function() {
            showPics(index);
            index++;
            if(index == len) {index = 0;}
        },4000); //此4000代表自动播放的间隔，单位：毫秒
    }).trigger("mouseleave");

    //显示图片函数，根据接收的index值显示相应的内容
    function showPics(index) { //普通切换
        var nowLeft = -index*sWidth; //根据index值计算ul元素的left值
        //$("#focus ul").stop(true,false).animate({"left":nowLeft},300); //通过animate()调整ul元素滚动到计算出的position
        $("#focus3 ul").stop(true,false).animate({"left":nowLeft},300);
        $("#focus3 .title").text($("#focus3 ul li").eq(index).contents("a").contents("img").attr("alt"));
        $("#focus3 .btn span").stop(true,false).animate({"opacity":"0.4"},300).eq(index).stop(true,false).animate({"opacity":"1"},300); //为当前的按钮切换到选中的效果
    }
});
//第四个

//第五个
$(function() {
    var sWidth = $("#focus4").width(); //获取焦点图的宽度（显示面积）
    var len = $("#focus4 ul li").length; //获取焦点图个数
    var index = 0;
    var picTimer;

    //以下代码添加数字按钮和按钮后的半透明条，还有上一页、下一页两个按钮
    var btn = "<div class='btnBg'></div><div class='btn'>";

    for(var i=0; i < len; i++) {
        btn += "<span></span>";
    }
    btn += "</div><div class='preNext pre'></div><div class='preNext next'></div>";
    if(len>1) {
        $("#focus4").append(btn);
    }
    $("#focus4 .btnBg").css("opacity",0.5);

    //为小按钮添加鼠标滑入事件，以显示相应的内容
    $("#focus4 .btn span").css("opacity",0.4).mouseover(function() {
        index = $("#focus4 .btn span").index(this);
        showPics(index);
    }).eq(0).trigger("mouseover");

    //上一页、下一页按钮透明度处理
    $("#focus4 .preNext").css("opacity",0.2).hover(function() {
        $(this).stop(true,false).animate({"opacity":"0.5"},300);
    },function() {
        $(this).stop(true,false).animate({"opacity":"0.2"},300);
    });

    //上一页按钮
    $("#focus4 .pre").click(function() {
        index -= 1;
        if(index == -1) {index = len - 1;}
        showPics(index);
    });

    //下一页按钮
    $("#focus4 .next").click(function() {
        index += 1;
        if(index == len) {index = 0;}
        showPics(index);
    });

    //本例为左右滚动，即所有li元素都是在同一排向左浮动，所以这里需要计算出外围ul元素的宽度
    $("#focus4 ul").css("width",sWidth * (len));

    //鼠标滑上焦点图时停止自动播放，滑出时开始自动播放
    $("#focus4").hover(function() {
        clearInterval(picTimer);
    },function() {
        picTimer = setInterval(function() {
            showPics(index);
            index++;
            if(index == len) {index = 0;}
        },4000); //此4000代表自动播放的间隔，单位：毫秒
    }).trigger("mouseleave");

    //显示图片函数，根据接收的index值显示相应的内容
    function showPics(index) { //普通切换
        var nowLeft = -index*sWidth; //根据index值计算ul元素的left值
        //$("#focus ul").stop(true,false).animate({"left":nowLeft},300); //通过animate()调整ul元素滚动到计算出的position
        $("#focus4 ul").stop(true,false).animate({"left":nowLeft},300);
        $("#focus4 .title").text($("#focus4 ul li").eq(index).contents("a").contents("img").attr("alt"));
        $("#focus4 .btn span").stop(true,false).animate({"opacity":"0.4"},300).eq(index).stop(true,false).animate({"opacity":"1"},300); //为当前的按钮切换到选中的效果
    }
});
//第五个


//各版块的小图轮播




//	活动剩余时间定时器
 var SysSecond;
 var InterValObj;

 $(document).ready(function() {
  SysSecond = $('#daojs').val();; //这里获取倒计时的起始时间
  InterValObj = window.setInterval(SetRemainTime, 1000); //间隔函数，1秒执行
 });

 //将时间减去1秒，计算天、时、分、秒
 function SetRemainTime() {
  if (SysSecond > 0) {
   SysSecond = SysSecond - 1;
   var second = Math.floor(SysSecond % 60);             // 计算秒
   var minite = Math.floor((SysSecond / 60) % 60);      //计算分
   var hour = Math.floor((SysSecond / 3600) % 24);      //计算小时
   var day = Math.floor((SysSecond / 3600) / 24);        //计算天

   $("#remainTime").html('<span class="remainTimeDay">'+day+'</span>' + '<span class="remainTimeHours">'+hour+'</span>'  + '<span class="remainTimeMin">'+minite+'</span>' + '<span class="remainTimeSec">'+second+'</span>' );
  } else {//剩余时间小于或等于0的时候，就停止间隔函数
   window.clearInterval(InterValObj);
   //这里可以添加倒计时时间为0后需要执行的事件
  }
 }
	//	活动剩余时间定时器



// 左侧产品鼠标hover事件
$(function(){
    $('.category-menu ul li').hover(function(){
        $(this).find('span').css('color','white');
        $(this).find('.leftimg').hide();
        $(this).find('.leftimg-1').css('display','block')
    },function(){
        $(this).find('span').css('color','black');
        $(this).find('.leftimg').show()
        $(this).find('.leftimg-1').css('display','none')
    })
    $('.right-box-1').hover(function(){
        $('.li1 .title_text').css('color','white');
        $('.li1 .leftimg').hide();
        $('.li1 .leftimg-1').css('display','block')
    },function(){
        $('.li1 .title_text').css('color','rgb(0,0,0)');
        $('.li1 .leftimg').show();
        $('.li1 .leftimg-1').css('display','none')
    })
    $('.right-box-2').hover(function(){
        $('.li2 .title_text').css('color','white');
        $('.li2 .leftimg').hide();
        $('.li2 .leftimg-1').css('display','block')
    },function(){
        $('.li2 .title_text').css('color','rgb(0,0,0)');
        $('.li2 .leftimg').show();
        $('.li2 .leftimg-1').css('display','none')
    })
    $('.right-box-3').hover(function(){
        $('.li3 .title_text').css('color','white');
        $('.li3 .leftimg').hide();
        $('.li3 .leftimg-1').css('display','block')
    },function(){
        $('.li3 .title_text').css('color','rgb(0,0,0)');
        $('.li3 .leftimg').show();
        $('.li3 .leftimg-1').css('display','none')
    })
    $('.right-box-4').hover(function(){
        $('.li4 .title_text').css('color','white');
        $('.li4 .leftimg').hide();
        $('.li4 .leftimg-1').css('display','block')
    },function(){
        $('.li4 .title_text').css('color','rgb(0,0,0)');
        $('.li4 .leftimg').show();
        $('.li4 .leftimg-1').css('display','none')
    })
    $('.right-box-5').hover(function(){
        $('.li5 .title_text').css('color','white');
        $('.li5 .leftimg').hide();
        $('.li5 .leftimg-1').css('display','block')
    },function(){
        $('.li5 .title_text').css('color','rgb(0,0,0)');
        $('.li5 .leftimg').show();
        $('.li5 .leftimg-1').css('display','none')
    })
    $('.right-box-6').hover(function(){
        $('.li6 .title_text').css('color','white');
        $('.li6 .leftimg').hide();
        $('.li6 .leftimg-1').css('display','block')
    },function(){
        $('.li6 .title_text').css('color','rgb(0,0,0)');
        $('.li6 .leftimg').show();
        $('.li6 .leftimg-1').css('display','none')
    })
    $('.right-box-7').hover(function(){
        $('.li7 .title_text').css('color','white');
        $('.li7 .leftimg').hide();
        $('.li7 .leftimg-1').css('display','block')
    },function(){
        $('.li7 .title_text').css('color','rgb(0,0,0)');
        $('.li7 .leftimg').show();
        $('.li7 .leftimg-1').css('display','none')
    })
    $('.right-box-8').hover(function(){
        $('.li8 .title_text').css('color','white');
        $('.li8 .leftimg').hide();
        $('.li8 .leftimg-1').css('display','block')
    },function(){
        $('.li8 .title_text').css('color','rgb(0,0,0)');
        $('.li8 .leftimg').show();
        $('.li8 .leftimg-1').css('display','none')
    })
    $('.right-box-9').hover(function(){
        $('.li9 .title_text').css('color','white');
        $('.li9 .leftimg').hide();
        $('.li9 .leftimg-1').css('display','block')
    },function(){
        $('.li9 .title_text').css('color','rgb(0,0,0)');
        $('.li9 .leftimg').show();
        $('.li9 .leftimg-1').css('display','none')
    })
    $('.right-box-10').hover(function(){
        $('.li10 .title_text').css('color','white');
        $('.li10 .leftimg').hide();
        $('.li10 .leftimg-1').css('display','block')
    },function(){
        $('.li10 .title_text').css('color','rgb(0,0,0)');
        $('.li10 .leftimg').show();
        $('.li10 .leftimg-1').css('display','none')
    })
    $('.right-box-11').hover(function(){
        $('.li11 .title_text').css('color','white');
        $('.li11 .leftimg').hide();
        $('.li11 .leftimg-1').css('display','block')
    },function(){
        $('.li11 .title_text').css('color','rgb(0,0,0)');
        $('.li11 .leftimg').show();
        $('.li11 .leftimg-1').css('display','none')
    })
    $('.right-box-12').hover(function(){
        $('.li12 .title_text').css('color','white');
        $('.li12 .leftimg').hide();
        $('.li12 .leftimg-1').css('display','block')
    },function(){
        $('.li12 .title_text').css('color','rgb(0,0,0)');
        $('.li12 .leftimg').show();
        $('.li12 .leftimg-1').css('display','none')
    })

    $("#totop").click(function(){
        $('body,html').animate({scrollTop:0},400);
        return false;
    });
//顶部关闭广告
    $(".close-btns").click(function () {

        $(".top-wrap").remove();
    });
    //弹出广告效果
    $('.close').click(function(){
        $('.zzsc').hide(0);
        $('.content_mark').hide(0);
    });
    //5秒自动关闭
    $('.zzsc').show(0);
    $('.content_mark').show(0).css("filter","alpha(opacity=40)");
    setTimeout(function () {
        $(".zzsc").hide();
        $(".content_mark").hide();
    },5000);
})



// // 左侧产品鼠标hover事件


