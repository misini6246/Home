/**
 * Created by admin on 2017/3/24.
 */
(function (I, H) {
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
        _init: function () {
            var a = this,
                c = 200;
            E.find(".banner-pic ul").each(function (g) {
                v.push([]);
                H(this).find("li").each(function () {
                    v[g].push(H(this))
                })
            });
            z.each(function (h) {
                var g = H(this);
                F.push([]);
                g.find(".ctrl-dot i").each(function () {
                    F[h].push(H(this))
                });
                i.push([]);
                g.find(".title-list p").each(function () {
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
            E.on("click", ".banner-next", function () {
                a.switchType = 0;
                a.next(2)
            });
            E.on("click", ".banner-prev", function () {
                a.switchType = 0;
                a.prev(2)
            });
            E.on("mouseenter", ".banner-ctrl li", function () {
                var g = H(this);
                clearTimeout(x);
                B = setTimeout(function () {
                    a.switchType = 0;
                    z.removeClass("current mouse-hover");
                    g.addClass("current mouse-hover").find(".title-item").slideDown();
                    a.select(g.index(), 0, 3)
                }, c)
            });
            E.on("mouseleave", ".banner-ctrl li", function () {
                clearTimeout(B)
            });
            E.on("mouseleave", ".banner-ctrl", function () {
                var g = H(this);
                clearTimeout(B);
                x = setTimeout(function () {
                    z.removeClass("mouse-hover")
                }, c)
            });
            E.on("mouseenter", ".title-list p", function () {
                var g = H(this);
                K = setTimeout(function () {
                    g.addClass("now").siblings().removeClass("now");
                    a.select(g.parents("li").index(), g.index(), 3)
                }, c)
            });
            E.on("mouseleave", ".title-list p", function () {
                clearTimeout(K)
            });
            E.on("mouseenter mousemove", function () {
                w = true;
                a._pauseAuto()
            });
            E.on("mouseleave", function () {
                w = false;
                if (a.isInScreen()) {
                    a._startAuto()
                }
            });
            if (a.isInScreen()) {
                a._startAuto();
                J = true
            }
            H(window).scroll(function () {
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
        },
        _startAuto: function () {
            var a = this;
            G = setInterval(function () {
                a.next(1)
            }, 5000)
        },
        _pauseAuto: function () {
            clearInterval(G)
        },
        select: function (e, f, b) {
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
            v[e][f].fadeIn(500).find("img[data-src]").attr("src", function () {
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
                } catch (a) {
                }
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
            NEW(e);
        },
        next: function (b) {
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
        prev: function (b) {
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
        isInScreen: function () {
            if (E.length > 0) {
                return (H(I).scrollTop() + H(window).height() - 100 > E.offset().top) && (E.offset().top + E.height() - 100 > H(I).scrollTop())
            }
        }
    };
    I.Banner = j;
    H(function () {
        I.Banner._init()
    });

    function NEW(index) {
        $('.banner-pic ul').find('.animate_img_left').css('left', '-780px')
        $('.banner-pic ul').find('.animate_img_right').css({
            'left': '780px'
        })
        $('.banner-pic ul').eq(index).find('.animate_img_left,.animate_img_right').animate({
            left: "0"
        }, 'slow')
    }
})(window, jQuery);