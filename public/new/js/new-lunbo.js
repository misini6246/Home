/**
 * Created by admin on 2017/3/24.
 */
var bigscreen=0;
(function(i, h, f) {
    var g = f(i, h);
    i.util = i.util || {};
    i.util.toucher = i.util.toucher || g;
    i.define && define(function(b, c, a) {
        return g
    })
})(this, document, function(n, k) {
    function p(a, b) {
        return a.className.match(new RegExp("(\\s|^)" + b + "(\\s|$)"))
    }

    function r(j, a, b) {
        this._events = this._events || {};
        var f, c;
        if (typeof(a) == "string") {
            f = a.replace(/^\./, "");
            c = b
        } else {
            f = null;
            c = a
        }
        if (typeof(c) == "function" && j && j.length) {
            var i = j.split(/\s+/);
            for (var h = 0, e = i.length; h < e; h++) {
                var g = i[h];
                if (!this._events[g]) {
                    this._events[g] = []
                }
                this._events[g].push({
                    className: f,
                    fn: c
                })
            }
        }
        return this
    }

    function m(f, e) {
        this._events = this._events || {};
        if (!this._events[f]) {
            return
        }
        var i = this._events[f];
        var c = e.target;
        while (1) {
            if (i.length == 0) {
                return
            }
            if (c == this.dom || !c) {
                for (var g = 0, a = i.length; g < a; g++) {
                    var h = i[g]["className"];
                    var j = i[g]["fn"];
                    if (h == null) {
                        o(f, j, c, e)
                    }
                }
                return
            }
            var b = i;
            i = [];
            for (var g = 0, a = b.length; g < a; g++) {
                var h = b[g]["className"];
                var j = b[g]["fn"];
                if (p(c, h)) {
                    if (o(f, j, c, e) == false) {
                        return
                    }
                } else {
                    i.push(b[g])
                }
            }
            c = c.parentNode
        }
    }

    function o(b, a, f, g) {
        var e = g.touches.length ? g.touches[0] : {};
        var h = {
            type: b,
            target: g.target,
            pageX: e.clientX || 0,
            pageY: e.clientY || 0
        };
        if (b == "swipe" && g.startPosition) {
            h.startX = g.startPosition.pageX, h.startY = g.startPosition.pageY, h.moveX = h.pageX - h.startX, h.moveY = h.pageY - h.startY
        }
        var c = a.call(f, h);
        if (c == false) {
            g.preventDefault();
            g.stopPropagation()
        }
        return c
    }

    function l(b, c, e, a) {
        return Math.abs(b - c) >= Math.abs(e - a) ? (b - c > 0 ? "Left" : "Right") : (e - a > 0 ? "Up" : "Down")
    }

    function s(j) {
        var G = this;
        var b = 0;
        var i = 0;
        var g, D, h, F;
        var a;
        var A;
        var B = false;a
        var E = null;

        function f(t) {
            B = false;
            clearTimeout(A);
            clearTimeout(a)
        }

        function e(t) {
            E = t;
            g = t.touches[0].pageX;
            D = t.touches[0].pageY;
            h = 0;
            F = 0;
            B = true;
            b = new Date();
            m.call(G, "swipeStart", t);
            clearTimeout(A);
            A = setTimeout(function() {
                f(t);
                m.call(G, "longTap", t)
            }, 500)
        }

        function C(u) {
            m.call(G, "swipeEnd", E);
            if (!B) {
                return
            }
            var t = new Date();
            if (t - i > 260) {
                a = setTimeout(function() {
                    f();
                    m.call(G, "singleTap", E)
                }, 250)
            } else {
                clearTimeout(a);
                f(u);
                m.call(G, "doubleTap", E)
            }
            i = t
        }

        function c(u) {
            E = u;
            u.startPosition = {
                pageX: g,
                pageY: D
            };
            m.call(G, "swipe", u);
            if (!B) {
                return
            }
            h = u.touches[0].pageX;
            F = u.touches[0].pageY;
            if (Math.abs(g - h) > 2 || Math.abs(D - F) > 2) {
                var t = l(g, h, D, F);
                m.call(G, "swipe" + t, u)
            } else {
                f(u);
                m.call(G, "singleTap", u)
            }
            f(u)
        }
        j.addEventListener("touchstart", e);
        j.addEventListener("MSPointerDown", e);
        j.addEventListener("pointerdown", e);
        j.addEventListener("touchend", C);
        j.addEventListener("MSPointerUp", C);
        j.addEventListener("pointerup", C);
        j.addEventListener("touchmove", c);
        j.addEventListener("MSPointerMove", c);
        j.addEventListener("pointermove", c);
        j.addEventListener("touchcancel", f);
        j.addEventListener("MSPointerCancel", f);
        j.addEventListener("pointercancel", f)
    }

    function q(b, a) {
        var a = a || {};
        this.dom = b;
        s.call(this, this.dom)
    }
    q.prototype.on = r;
    return function(a) {
        return new q(a)
    }
});
(function(I, H) {
    var E = H(".banner2"),
        z = E.find(".banner-ctrl li"),
        v = [],
        F = [],
        i = [],
        C = true,
        w = false,
        y = -1,
        A = -1,
        K, G, B, x, D, J = false;
    if (E.length == 0) {
        return
    }
    var j = {
        switchType: 1,
        _init: function() {
            var a = this,
                c = 200;
            E.find(".banner-pic ul").each(function(g) {
                v.push([]);
                H(this).find("li").each(function() {
                    v[g].push(H(this))
                })
            });
            z.each(function(h) {
                var g = H(this);
                F.push([]);
                g.find(".ctrl-dot i").each(function() {
                    F[h].push(H(this))
                });
                i.push([]);
                g.find(".title-list p").each(function() {
                    i[h].push(H(this))
                })
            });
            if (z.filter("[data-rec]").size() == 0) {
                var e = Math.floor(Math.random() * v.length),
                    f = Math.floor(Math.random() * v[e].length);
                a.select(0, f, 1)
            } else {
                var b = Math.floor(Math.random() * v[0].length);
                a.select(0, b, 1)
            }
            E.on("click", ".banner-next", function() {
                a.switchType = 0;
                a.next(2)
            });
            E.on("click", ".banner-prev", function() {
                a.switchType = 0;
                a.prev(2)
            });
            E.on("mouseenter", ".banner-ctrl li", function() {
                var g = H(this);
                clearTimeout(x);
                B = setTimeout(function() {
                    a.switchType = 0;
                    z.removeClass("current mouse-hover");
                    g.addClass("current mouse-hover").find(".title-item").slideDown();
                    a.select(g.index(), 0, 3)
                }, c)
            });
            E.on("mouseleave", ".banner-ctrl li", function() {
                clearTimeout(B)
            });
            E.on("mouseleave", ".banner-ctrl", function() {
                var g = H(this);
                clearTimeout(B);
                x = setTimeout(function() {
                    z.removeClass("mouse-hover")
                }, c)
            });
            E.on("mouseenter", ".title-list p", function() {
                var g = H(this);
                K = setTimeout(function() {
                    g.addClass("now").siblings().removeClass("now");
                    a.select(g.parents("li").index(), g.index(), 3)
                }, c)
            });
            E.on("mouseleave", ".title-list p", function() {
                clearTimeout(K)
            });
            E.on("mouseenter mousemove", function() {
                w = true;
                a._pauseAuto()
            });
            E.on("mouseleave", function() {
                w = false;
                if (a.isInScreen()) {
                    a._startAuto()
                }
            });
            if (a.isInScreen()) {
                a._startAuto();
                J = true
            }
            H(window).scroll(function() {
                if (a.isInScreen() && J == false) {
                    J = true;
                    w = false;
                    a._startAuto()
                } else {
                    if (!a.isInScreen() && J == true) {
                        J = false;
                        w = true;
                        a._pauseAuto()
                    }
                }
            });
            H(document).keyup(function(g) {
                if (a.isInScreen()) {
                    if (g.which == 37 || g.which == 75) {
                        a.switchType = 0;
                        a.prev(2)
                    }
                    if (g.which == 39 || g.which == 74) {
                        a.switchType = 0;
                        a.next(2)
                    }
                    if (!w) {
                        a._pauseAuto();
                        a._startAuto()
                    }
                }
            })
        },
        _startAuto: function() {
            var a = this;
            G = setInterval(function() {
                a.next(1)
            }, 30000)
        },
        _pauseAuto: function() {
            clearInterval(G)
        },
        select: function(e, f, b) {
            if (y == e && A == f) {
                return
            }
            if (C) {
                H(".banner").css("background", "none");
                C = false
            }
            if (y >= 0 && A >= 0) {
                v[y][A].stop().fadeOut(500);
                if (y != e) {
                    z.eq(y).removeClass("current mouse-hover")
                }
                F[y][A].removeClass("on");
                i[y][A].removeClass("now")
            }
            v[e][f].fadeIn(500).find("img[data-src]").attr("src", function() {
                return H(this).attr("data-src")
            }).removeAttr("data-src");
            if (y != e) {
                z.eq(e).addClass("current")
            }
            F[e][f].addClass("on");
            i[e][f].addClass("now");
            D = v[e][f].attr("cptId");
            if (D) {
                try {
                    apsAdboardCptPvObj.aps_adboard_loadAdCptPv(D)
                } catch (a) {}
            }
            y = e;
            A = f;
            if (window.saExportUtil) {
                var c = v[y][A].children("a").attr("expo");
                switch (b) {
                    case 1:
                        saExportUtil.adverCarousel(c);
                        break;
                    case 2:
                        saExportUtil.adverClick(c);
                        break;
                    case 3:
                        saExportUtil.sendCustomExpoData(c, 2);
                        break
                }
            }
        },
        next: function(b) {
            var a = this,
                c, e;
            if (v[y][A + 1]) {
                if (a.switchType) {
                    if (z.eq(y).attr("data-rec")) {
                        c = y;
                        e = A + 1
                    } else {
                        c = y == (v.length - 1) ? 0 : (y + 1);
                        e = 0
                    }
                } else {
                    c = y;
                    e = A + 1
                }
            } else {
                c = y == (v.length - 1) ? 0 : (y + 1);
                e = 0
            }
            this.select(c, e, b)
        },
        prev: function(b) {
            var a = this,
                c, e;
            if (v[y][A - 1]) {
                if (a.switchType) {
                    if (z.eq(y).attr("data-rec")) {
                        c = y;
                        e = A - 1
                    } else {
                        c = y == 0 ? (v.length - 1) : (y - 1);
                        e = 0
                    }
                } else {
                    c = y;
                    e = A - 1
                }
            } else {
                c = y == 0 ? (v.length - 1) : (y - 1);
                if (a.switchType && !z.eq(c).attr("data-rec")) {
                    e = 0
                } else {
                    e = v[c].length - 1
                }
            }
            this.select(c, e, b)
        },
        // },
        isInScreen: function() {
            if (E.length > 0) {
                return (H(I).scrollTop() + H(window).height() - 100 > E.offset().top) && (E.offset().top + E.height() - 100 > H(I).scrollTop())
            }
        }
    };
    I.Banner = j;
    H(function() {
        I.Banner._init()
    })
})(window, jQuery);








$(function(){





    //logo滚动
    function LogoScroll(obj) {
        return function(){
            $(obj).find("ul").animate({
                marginTop: "-20px"
            }, 500, function () {
                $(this).css({ marginTop: "0px" }).find("li:first").appendTo(this);
            })
        }
    };


    //
    if($.browser.msie && ($.browser.version <="9.0")){
         $('.right_box_l li').each(function(){
            $(this).hover(function(){
                $(this).children('a').find('img').animate({
                    marginLeft: '15px'},300);
                // alert($(this).children('a').find('img').attr('class'));
            },function(){
                $(this).children('a').find('img').stop(true).animate({
                    marginLeft: '25px'},300);
            })
        })
        $('.right_box_r li').each(function(){
            $(this).hover(function(){
                $(this).children('a').find('img').animate({
                    marginLeft: '97px'},300);
                // alert($(this).children('a').find('img').attr('class'));
            },function(){
                $(this).children('a').find('img').stop(true).animate({
                    marginLeft: '107px'},300);
            })
        })
    }
    $('.banner-pic,.banner-btn').mousemove(function(){
        $('.banner-btn').show(0);
    }).mouseleave(function(){
        $('.banner-btn').hide(0);
    });

    //居中
    // var len=$('.banner-ctrl li').size();
    // //alert(len)
    // $('.banner-ctrl').css({'width':len*62});
    //$('.banner-ctrl li:gt('+(len-3)+')').find('div').css({'right':0,'left':'auto'});
});



