/**
 * Created by wang on 14-8-28.
 */

/* 商品显示大图片js */
$(function(){
    if ($(".proviewbox")) {
        var page = 0;
        var $ul = $(".ul_prothumb"),$li = $(".ul_prothumb li");
        var $liL = $li.length;
        var $bigShowBox = $(".probigshow");
        var str = '<div class="zoomplepopup"></div><div id="probig_preview"><iframe class="T_iframe"></iframe><img src="" width="1024" height="1024" alt="" /></div>';
        $bigShowBox.append(str);

        var $pre = $("#probig_preview");
        var $preimg = $("#probig_preview img");
        var $zoom = $(".probigshow .zoomplepopup");
        var $link = $('#a_enlarge').attr('href');
        var $SPage = Math.floor($liL / 3),sLong = $li.width() * 3;
        var sto;

        function btnStyle() {
            if (page == 0) {$('.span_prev').addClass('span_prevb');} else {$('.span_prev').removeClass('span_prevb');}
            if (page == $SPage) {$('.span_next').addClass('span_nextb');} else {$('.span_next').removeClass('span_nextb');}
        }

        if (page < 1){
            var _src = $(".a_probigshow:first").attr("ref");
            $preimg.attr("src", _src);
        }else{
            $preimg.attr("src", $li.find("a").attr("href"));
        }
        btnStyle();

        //$li.overOnlyClass("now");
        $('#a_enlarge').attr('href',$link+'#'+'0');

        $(".span_prev").click(function() {
            if (page > 0) {page--;$(".ul_prothumb").animate({left: "+=" + sLong});}
            btnStyle();
        });
        $(".span_next").click(function() {
            if (page < $SPage-1) {page++;$(".ul_prothumb").animate({left: "-=" + sLong});}
            btnStyle();
        });
        window.lichange = function (indx) {
            var obj = $li.eq(indx);
            $preimg.attr("src",(obj.find("a").attr("href")));
            $(".a_probigshow img").attr("src", obj.find("img").attr("longdesc"));
            $('#a_enlarge').attr('href',$link+'#'+indx);
            $li.removeClass('now').eq(indx).addClass('now');
        };
        $li.mouseenter(function() {
            var indx = $li.index($(this));
            sto = setTimeout('lichange('+indx+')',150);
        }).mouseleave(function () {
                clearTimeout(sto);
            })	.click(function() {
                var indx = $li.index($(this));lichange(indx);
                return false;
            });

        var zoompos = {x: 0,y: 0};
        var p_w = $preimg.width();
        var p_h = $preimg.height();
        $bigShowBox.bind("mouseover",function(g) {
            $pre.css({visibility: "visible"});
            var f = $(this);
            var a = $(this).width(),c = $(this).height();
            var b = $pre.width(),d = $pre.height();
            $zoom.width(b * a / p_w).height(d * c / p_h).show();
            PositionPopupZoom(f, $zoom, g.pageX, g.pageY, p_w, p_h);
            f.bind("mousemove",function(h) {
                setTimeout(function() {PositionPopupZoom(f, $zoom, h.pageX, h.pageY, p_w, p_h)},5);
            })
        }).bind("mouseleave",function() {
                var a = $(this);
                $zoom.hide();
                $pre.css({visibility: "hidden"});
            });
        function PositionPopupZoom(a, o, m, k, n, f) {
            var c = a.offset().left;
            var i = a.offset().top;
            var d = o.width();
            var e = o.height();
            var l = a.width();
            var j = a.height();
            zoompos.x = m - c - (d / 2);
            zoompos.y = k - i - (e / 2);
            if (zoompos.x <= 0) {zoompos.x = 0}
            if (zoompos.y <= 0) {zoompos.y = 0}
            if (zoompos.x + d >= l) {zoompos.x = l - d}
            if (zoompos.y + e >= j) {zoompos.y = j - e}
            var b = n / l, g = f / j;
            o.css({left: zoompos.x,top: zoompos.y});
            $preimg.css({left: -(zoompos.x * b),top: -(zoompos.y * g)});
        }
    }
//details gallery
    if ($(".div_gallerybigshow").length) {
        var $bigshowbox = $(".div_gallerybigshow");
        var $imga = $(".ul_gallerythumb a");
        var $img = $("#img_bigshow");
        var len = $imga.length,imgh;
        var page = 1,aZoom = 0,sLong = 308,$SPage = Math.ceil(len / 80);
        var httpHref = window.location.href;
        //var nowL = parseInt(httpHref.substr(httpHref.indexOf("#") + 1));
        var  nowL =((/.*#(\d+)$/.exec(httpHref))==null)?0:parseInt(/.*#(\d+)$/.exec(httpHref)[1]);

        function mPosition(c) {
            var a = c.pageX;
            var b = c.pageY;
            return {t: b,l: a}
        }
        function autoW(b, a) {
            b.css({width: "auto",height: "auto"});
            iW = b.width();
            iH = b.height();
            if (iW > a) {b.css({width: a,height: parseInt(iH * a / iW)});aZoom = 1;} else {aZoom = 0}
            imgh = b.height();
        }
        function loadImg(a) {
            $img.load(function() {
                autoW($(this), 500);
                $bigshowbox.removeClass("preloading");
                $(this).fadeIn();
                $('.div_gallerybigshow .span_left,.div_gallerybigshow .span_right').height(imgh);
            }).hide().attr("src", a);
        }

        function thumbStyle(a) {$imga.removeClass("now").eq(a).addClass("now");}

        function pageStyle() {
            if (page == 1) {$(".b_prev").addClass("b_prevb");} else { $(".b_prev").removeClass("b_prevb")};
            if (page == $SPage) {$(".b_next").addClass("b_nextb");} else {$(".b_next").removeClass("b_nextb");}
            $(".em_totalpage").html($SPage);
            $(".em_nowpage").html(page);
        }
        function changeDo(a) {
            nowL = a;
            thumbStyle(nowL);
            $bigshowbox.addClass("preloading");
            loadImg($imga.eq(nowL).attr("href"));
        }
        function pageChange(b, a) {
            if (b == "add") {
                if (page > 1) {
                    page = page - a;
                    $(".ul_gallerythumb").animate({top: "+=" + (a * sLong)},"fast");
                    pageStyle();
                }} else {
                if (b == "reduce") {
                    if (page < $SPage) {
                        page = page + a;
                        $(".ul_gallerythumb").animate({top: "-=" + (a * sLong)},"fast");
                        pageStyle();
                    }
                }
            }
        }
        function pageDo(a) {
            p = Math.ceil((a + 1) / 8);
            if (p > page) {pageChange("reduce", (p - page));}
            if (p < page) {pageChange("add", (page - p))}
        }

        //初始化
        $(".em_gallerynum").html(len);
        nowL = (!isNaN(nowL) && nowL < len) ? nowL: 0;
        pageStyle();
        changeDo(nowL);
        pageDo(nowL);

        $imga.click(function() {
            var a = $imga.index($(this));
            changeDo(a);
            return false;
        });

        $img.mousemove(function() {
            if (aZoom == 1) {
                $(this).unbind("click").removeClass().addClass("mousezoom").attr("title", "点击查看大图").bind("click",function() {
                    window.open($(this).attr("src"));
                })}else {
                $(this).unbind("click").removeClass();}
        });


        if (len>1) {
            var strhtml = "<span class='span_left' title='点击查看上一张'>prev</span><span class='span_right' title='点击查看下一张'>next</span>";
            $bigshowbox.append(strhtml);

            $('.div_gallerybigshow .span_left').click(function () {
                nowL = (nowL + len - 1) % len;
                changeDo(nowL);
                pageDo(nowL);
            });
            $('.div_gallerybigshow .span_right').click(function () {
                nowL = (nowL + 1) % len;
                changeDo(nowL);
                pageDo(nowL);
            });
        }

        $(".b_prev").click(function() { pageChange("add", 1);});
        $(".b_next").click(function() {pageChange("reduce", 1);});
    }


})
