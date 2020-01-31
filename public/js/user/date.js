(function (a) {
    if (typeof define === "function" && define.amd) {
        define(["jquery"], a)
    } else {
        if (typeof exports === "object") {
            a(require("jquery"))
        } else {
            a(jQuery)
        }
    }
}(function (f, c) {
    if (!("indexOf" in Array.prototype)) {
        Array.prototype.indexOf = function (k, j) {
            if (j === c) {
                j = 0
            }
            if (j < 0) {
                j += this.length
            }
            if (j < 0) {
                j = 0
            }
            for (var l = this.length; j < l; j++) {
                if (j in this && this[j] === k) {
                    return j
                }
            }
            return -1
        }
    }
    function e(l) {
        var k = f(l);
        var j = k.add(k.parents());
        var m = false;
        j.each(function () {
            if (f(this).css("position") === "fixed") {
                m = true;
                return false
            }
        });
        return m
    }

    function h() {
        return new Date(Date.UTC.apply(Date, arguments))
    }

    function d() {
        var j = new Date();
        return h(j.getUTCFullYear(), j.getUTCMonth(), j.getUTCDate(), j.getUTCHours(), j.getUTCMinutes(), j.getUTCSeconds(), 0)
    }

    var i = function (l, k) {
        var n = this;
        this.element = f(l);
        this.container = k.container || "body";
        this.language = k.language || this.element.data("date-language") || "en";
        this.language = this.language in a ? this.language : this.language.split("-")[0];
        this.language = this.language in a ? this.language : "en";
        this.isRTL = a[this.language].rtl || false;
        this.formatType = k.formatType || this.element.data("format-type") || "standard";
        this.format = g.parseFormat(k.format || this.element.data("date-format") || a[this.language].format || g.getDefaultFormat(this.formatType, "input"), this.formatType);
        this.isInline = false;
        this.isVisible = false;
        this.isInput = this.element.is("input");
        this.fontAwesome = k.fontAwesome || this.element.data("font-awesome") || false;
        this.bootcssVer = k.bootcssVer || (this.isInput ? (this.element.is(".form-control") ? 3 : 2) : (this.bootcssVer = this.element.is(".input-group") ? 3 : 2));
        this.component = this.element.is(".date") ? (this.bootcssVer == 3 ? this.element.find(".input-group-addon .glyphicon-th, .input-group-addon .glyphicon-time, .input-group-addon .glyphicon-remove, .input-group-addon .glyphicon-calendar, .input-group-addon .fa-calendar, .input-group-addon .fa-clock-o").parent() : this.element.find(".add-on .icon-th, .add-on .icon-time, .add-on .icon-calendar, .add-on .fa-calendar, .add-on .fa-clock-o").parent()) : false;
        this.componentReset = this.element.is(".date") ? (this.bootcssVer == 3 ? this.element.find(".input-group-addon .glyphicon-remove, .input-group-addon .fa-times").parent() : this.element.find(".add-on .icon-remove, .add-on .fa-times").parent()) : false;
        this.hasInput = this.component && this.element.find("input").length;
        if (this.component && this.component.length === 0) {
            this.component = false
        }
        this.linkField = k.linkField || this.element.data("link-field") || false;
        this.linkFormat = g.parseFormat(k.linkFormat || this.element.data("link-format") || g.getDefaultFormat(this.formatType, "link"), this.formatType);
        this.minuteStep = k.minuteStep || this.element.data("minute-step") || 5;
        this.pickerPosition = k.pickerPosition || this.element.data("picker-position") || "bottom-right";
        this.showMeridian = k.showMeridian || this.element.data("show-meridian") || false;
        this.initialDate = k.initialDate || new Date();
        this.zIndex = k.zIndex || this.element.data("z-index") || c;
        this.title = typeof k.title === "undefined" ? false : k.title;
        this.icons = {
            leftArrow: this.fontAwesome ? "fa-arrow-left" : (this.bootcssVer === 3 ? "glyphicon-arrow-left" : "icon-arrow-left"),
            rightArrow: this.fontAwesome ? "fa-arrow-right" : (this.bootcssVer === 3 ? "glyphicon-arrow-right" : "icon-arrow-right")
        };
        this.icontype = this.fontAwesome ? "fa" : "glyphicon";
        this._attachEvents();
        this.clickedOutside = function (o) {
            if (f(o.target).closest(".datetimepicker").length === 0) {
                n.hide()
            }
        };
        this.formatViewType = "datetime";
        if ("formatViewType" in k) {
            this.formatViewType = k.formatViewType
        } else {
            if ("formatViewType" in this.element.data()) {
                this.formatViewType = this.element.data("formatViewType")
            }
        }
        this.minView = 0;
        if ("minView" in k) {
            this.minView = k.minView
        } else {
            if ("minView" in this.element.data()) {
                this.minView = this.element.data("min-view")
            }
        }
        this.minView = g.convertViewMode(this.minView);
        this.maxView = g.modes.length - 1;
        if ("maxView" in k) {
            this.maxView = k.maxView
        } else {
            if ("maxView" in this.element.data()) {
                this.maxView = this.element.data("max-view")
            }
        }
        this.maxView = g.convertViewMode(this.maxView);
        this.wheelViewModeNavigation = false;
        if ("wheelViewModeNavigation" in k) {
            this.wheelViewModeNavigation = k.wheelViewModeNavigation
        } else {
            if ("wheelViewModeNavigation" in this.element.data()) {
                this.wheelViewModeNavigation = this.element.data("view-mode-wheel-navigation")
            }
        }
        this.wheelViewModeNavigationInverseDirection = false;
        if ("wheelViewModeNavigationInverseDirection" in k) {
            this.wheelViewModeNavigationInverseDirection = k.wheelViewModeNavigationInverseDirection
        } else {
            if ("wheelViewModeNavigationInverseDirection" in this.element.data()) {
                this.wheelViewModeNavigationInverseDirection = this.element.data("view-mode-wheel-navigation-inverse-dir")
            }
        }
        this.wheelViewModeNavigationDelay = 100;
        if ("wheelViewModeNavigationDelay" in k) {
            this.wheelViewModeNavigationDelay = k.wheelViewModeNavigationDelay
        } else {
            if ("wheelViewModeNavigationDelay" in this.element.data()) {
                this.wheelViewModeNavigationDelay = this.element.data("view-mode-wheel-navigation-delay")
            }
        }
        this.startViewMode = 2;
        if ("startView" in k) {
            this.startViewMode = k.startView
        } else {
            if ("startView" in this.element.data()) {
                this.startViewMode = this.element.data("start-view")
            }
        }
        this.startViewMode = g.convertViewMode(this.startViewMode);
        this.viewMode = this.startViewMode;
        this.viewSelect = this.minView;
        if ("viewSelect" in k) {
            this.viewSelect = k.viewSelect
        } else {
            if ("viewSelect" in this.element.data()) {
                this.viewSelect = this.element.data("view-select")
            }
        }
        this.viewSelect = g.convertViewMode(this.viewSelect);
        this.forceParse = true;
        if ("forceParse" in k) {
            this.forceParse = k.forceParse
        } else {
            if ("dateForceParse" in this.element.data()) {
                this.forceParse = this.element.data("date-force-parse")
            }
        }
        var m = this.bootcssVer === 3 ? g.templateV3 : g.template;
        while (m.indexOf("{iconType}") !== -1) {
            m = m.replace("{iconType}", this.icontype)
        }
        while (m.indexOf("{leftArrow}") !== -1) {
            m = m.replace("{leftArrow}", this.icons.leftArrow)
        }
        while (m.indexOf("{rightArrow}") !== -1) {
            m = m.replace("{rightArrow}", this.icons.rightArrow)
        }
        this.picker = f(m).appendTo(this.isInline ? this.element : this.container).on({
            click: f.proxy(this.click, this),
            mousedown: f.proxy(this.mousedown, this)
        });
        if (this.wheelViewModeNavigation) {
            if (f.fn.mousewheel) {
                this.picker.on({mousewheel: f.proxy(this.mousewheel, this)})
            } else {
                console.log("Mouse Wheel event is not supported. Please include the jQuery Mouse Wheel plugin before enabling this option")
            }
        }
        if (this.isInline) {
            this.picker.addClass("datetimepicker-inline")
        } else {
            this.picker.addClass("datetimepicker-dropdown-" + this.pickerPosition + " dropdown-menu")
        }
        if (this.isRTL) {
            this.picker.addClass("datetimepicker-rtl");
            var j = this.bootcssVer === 3 ? ".prev span, .next span" : ".prev i, .next i";
            this.picker.find(j).toggleClass(this.icons.leftArrow + " " + this.icons.rightArrow)
        }
        f(document).on("mousedown", this.clickedOutside);
        this.autoclose = false;
        if ("autoclose" in k) {
            this.autoclose = k.autoclose
        } else {
            if ("dateAutoclose" in this.element.data()) {
                this.autoclose = this.element.data("date-autoclose")
            }
        }
        this.keyboardNavigation = true;
        if ("keyboardNavigation" in k) {
            this.keyboardNavigation = k.keyboardNavigation
        } else {
            if ("dateKeyboardNavigation" in this.element.data()) {
                this.keyboardNavigation = this.element.data("date-keyboard-navigation")
            }
        }
        this.todayBtn = (k.todayBtn || this.element.data("date-today-btn") || false);
        this.clearBtn = (k.clearBtn || this.element.data("date-clear-btn") || false);
        this.todayHighlight = (k.todayHighlight || this.element.data("date-today-highlight") || false);
        this.weekStart = ((k.weekStart || this.element.data("date-weekstart") || a[this.language].weekStart || 0) % 7);
        this.weekEnd = ((this.weekStart + 6) % 7);
        this.startDate = -Infinity;
        this.endDate = Infinity;
        this.datesDisabled = [];
        this.daysOfWeekDisabled = [];
        this.setStartDate(k.startDate || this.element.data("date-startdate"));
        this.setEndDate(k.endDate || this.element.data("date-enddate"));
        this.setDatesDisabled(k.datesDisabled || this.element.data("date-dates-disabled"));
        this.setDaysOfWeekDisabled(k.daysOfWeekDisabled || this.element.data("date-days-of-week-disabled"));
        this.setMinutesDisabled(k.minutesDisabled || this.element.data("date-minute-disabled"));
        this.setHoursDisabled(k.hoursDisabled || this.element.data("date-hour-disabled"));
        this.fillDow();
        this.fillMonths();
        this.update();
        this.showMode();
        if (this.isInline) {
            this.show()
        }
    };
    i.prototype = {
        constructor: i, _events: [], _attachEvents: function () {
            this._detachEvents();
            if (this.isInput) {
                this._events = [[this.element, {
                    focus: f.proxy(this.show, this),
                    keyup: f.proxy(this.update, this),
                    keydown: f.proxy(this.keydown, this)
                }]]
            } else {
                if (this.component && this.hasInput) {
                    this._events = [[this.element.find("input"), {
                        focus: f.proxy(this.show, this),
                        keyup: f.proxy(this.update, this),
                        keydown: f.proxy(this.keydown, this)
                    }], [this.component, {click: f.proxy(this.show, this)}]];
                    if (this.componentReset) {
                        this._events.push([this.componentReset, {click: f.proxy(this.reset, this)}])
                    }
                } else {
                    if (this.element.is("div")) {
                        this.isInline = true
                    } else {
                        this._events = [[this.element, {click: f.proxy(this.show, this)}]]
                    }
                }
            }
            for (var j = 0, k, l; j < this._events.length; j++) {
                k = this._events[j][0];
                l = this._events[j][1];
                k.on(l)
            }
        }, _detachEvents: function () {
            for (var j = 0, k, l; j < this._events.length; j++) {
                k = this._events[j][0];
                l = this._events[j][1];
                k.off(l)
            }
            this._events = []
        }, show: function (j) {
            this.picker.show();
            this.height = this.component ? this.component.outerHeight() : this.element.outerHeight();
            if (this.forceParse) {
                this.update()
            }
            this.place();
            f(window).on("resize", f.proxy(this.place, this));
            if (j) {
                j.stopPropagation();
                j.preventDefault()
            }
            this.isVisible = true;
            this.element.trigger({type: "show", date: this.date})
        }, hide: function (j) {
            if (!this.isVisible) {
                return
            }
            if (this.isInline) {
                return
            }
            this.picker.hide();
            f(window).off("resize", this.place);
            this.viewMode = this.startViewMode;
            this.showMode();
            if (!this.isInput) {
                f(document).off("mousedown", this.hide)
            }
            if (this.forceParse && (this.isInput && this.element.val() || this.hasInput && this.element.find("input").val())) {
                this.setValue()
            }
            this.isVisible = false;
            this.element.trigger({type: "hide", date: this.date})
        }, remove: function () {
            this._detachEvents();
            f(document).off("mousedown", this.clickedOutside);
            this.picker.remove();
            delete this.picker;
            delete this.element.data().datetimepicker
        }, getDate: function () {
            var j = this.getUTCDate();
            return new Date(j.getTime() + (j.getTimezoneOffset() * 60000))
        }, getUTCDate: function () {
            return this.date
        }, getInitialDate: function () {
            return this.initialDate
        }, setInitialDate: function (j) {
            this.initialDate = j
        }, setDate: function (j) {
            this.setUTCDate(new Date(j.getTime() - (j.getTimezoneOffset() * 60000)))
        }, setUTCDate: function (j) {
            if (j >= this.startDate && j <= this.endDate) {
                this.date = j;
                this.setValue();
                this.viewDate = this.date;
                this.fill()
            } else {
                this.element.trigger({type: "outOfRange", date: j, startDate: this.startDate, endDate: this.endDate})
            }
        }, setFormat: function (k) {
            this.format = g.parseFormat(k, this.formatType);
            var j;
            if (this.isInput) {
                j = this.element
            } else {
                if (this.component) {
                    j = this.element.find("input")
                }
            }
            if (j && j.val()) {
                this.setValue()
            }
        }, setValue: function () {
            var j = this.getFormattedDate();
            if (!this.isInput) {
                if (this.component) {
                    this.element.find("input").val(j)
                }
                this.element.data("date", j)
            } else {
                this.element.val(j)
            }
            if (this.linkField) {
                f("#" + this.linkField).val(this.getFormattedDate(this.linkFormat))
            }
        }, getFormattedDate: function (j) {
            if (j == c) {
                j = this.format
            }
            return g.formatDate(this.date, j, this.language, this.formatType)
        }, setStartDate: function (j) {
            this.startDate = j || -Infinity;
            if (this.startDate !== -Infinity) {
                this.startDate = g.parseDate(this.startDate, this.format, this.language, this.formatType)
            }
            this.update();
            this.updateNavArrows()
        }, setEndDate: function (j) {
            this.endDate = j || Infinity;
            if (this.endDate !== Infinity) {
                this.endDate = g.parseDate(this.endDate, this.format, this.language, this.formatType)
            }
            this.update();
            this.updateNavArrows()
        }, setDatesDisabled: function (j) {
            this.datesDisabled = j || [];
            if (!f.isArray(this.datesDisabled)) {
                this.datesDisabled = this.datesDisabled.split(/,\s*/)
            }
            this.datesDisabled = f.map(this.datesDisabled, function (k) {
                return g.parseDate(k, this.format, this.language, this.formatType).toDateString()
            });
            this.update();
            this.updateNavArrows()
        }, setTitle: function (j, k) {
            return this.picker.find(j).find("th:eq(1)").text(this.title === false ? k : this.title)
        }, setDaysOfWeekDisabled: function (j) {
            this.daysOfWeekDisabled = j || [];
            if (!f.isArray(this.daysOfWeekDisabled)) {
                this.daysOfWeekDisabled = this.daysOfWeekDisabled.split(/,\s*/)
            }
            this.daysOfWeekDisabled = f.map(this.daysOfWeekDisabled, function (k) {
                return parseInt(k, 10)
            });
            this.update();
            this.updateNavArrows()
        }, setMinutesDisabled: function (j) {
            this.minutesDisabled = j || [];
            if (!f.isArray(this.minutesDisabled)) {
                this.minutesDisabled = this.minutesDisabled.split(/,\s*/)
            }
            this.minutesDisabled = f.map(this.minutesDisabled, function (k) {
                return parseInt(k, 10)
            });
            this.update();
            this.updateNavArrows()
        }, setHoursDisabled: function (j) {
            this.hoursDisabled = j || [];
            if (!f.isArray(this.hoursDisabled)) {
                this.hoursDisabled = this.hoursDisabled.split(/,\s*/)
            }
            this.hoursDisabled = f.map(this.hoursDisabled, function (k) {
                return parseInt(k, 10)
            });
            this.update();
            this.updateNavArrows()
        }, place: function () {
            if (this.isInline) {
                return
            }
            if (!this.zIndex) {
                var k = 0;
                f("div").each(function () {
                    var p = parseInt(f(this).css("zIndex"), 10);
                    if (p > k) {
                        k = p
                    }
                });
                this.zIndex = k + 10
            }
            var o, n, m, l;
            if (this.container instanceof f) {
                l = this.container.offset()
            } else {
                l = f(this.container).offset()
            }
            if (this.component) {
                o = this.component.offset();
                m = o.left;
                if (this.pickerPosition == "bottom-left" || this.pickerPosition == "top-left") {
                    m += this.component.outerWidth() - this.picker.outerWidth()
                }
            } else {
                o = this.element.offset();
                m = o.left;
                if (this.pickerPosition == "bottom-left" || this.pickerPosition == "top-left") {
                    m += this.element.outerWidth() - this.picker.outerWidth()
                }
            }
            var j = document.body.clientWidth || window.innerWidth;
            if (m + 220 > j) {
                m = j - 220
            }
            if (this.pickerPosition == "top-left" || this.pickerPosition == "top-right") {
                n = o.top - this.picker.outerHeight()
            } else {
                n = o.top + this.height
            }
            n = n - l.top;
            m = m - l.left;
            this.picker.css({top: n, left: m, zIndex: this.zIndex})
        }, update: function () {
            var j, k = false;
            if (arguments && arguments.length && (typeof arguments[0] === "string" || arguments[0] instanceof Date)) {
                j = arguments[0];
                k = true
            } else {
                j = (this.isInput ? this.element.val() : this.element.find("input").val()) || this.element.data("date") || this.initialDate;
                if (typeof j == "string" || j instanceof String) {
                    j = j.replace(/^\s+|\s+$/g, "")
                }
            }
            if (!j) {
                j = new Date();
                k = false
            }
            this.date = g.parseDate(j, this.format, this.language, this.formatType);
            if (k) {
                this.setValue()
            }
            if (this.date < this.startDate) {
                this.viewDate = new Date(this.startDate)
            } else {
                if (this.date > this.endDate) {
                    this.viewDate = new Date(this.endDate)
                } else {
                    this.viewDate = new Date(this.date)
                }
            }
            this.fill()
        }, fillDow: function () {
            var j = this.weekStart, k = "<tr>";
            while (j < this.weekStart + 7) {
                k += '<th class="dow">' + a[this.language].daysMin[(j++) % 7] + "</th>"
            }
            k += "</tr>";
            this.picker.find(".datetimepicker-days thead").append(k)
        }, fillMonths: function () {
            var k = "", j = 0;
            while (j < 12) {
                k += '<span class="month">' + a[this.language].monthsShort[j++] + "</span>"
            }
            this.picker.find(".datetimepicker-months td").html(k)
        }, fill: function () {
            if (this.date == null || this.viewDate == null) {
                return
            }
            var H = new Date(this.viewDate), u = H.getUTCFullYear(), I = H.getUTCMonth(), n = H.getUTCDate(),
                D = H.getUTCHours(), y = H.getUTCMinutes(),
                z = this.startDate !== -Infinity ? this.startDate.getUTCFullYear() : -Infinity,
                E = this.startDate !== -Infinity ? this.startDate.getUTCMonth() + 1 : -Infinity,
                q = this.endDate !== Infinity ? this.endDate.getUTCFullYear() : Infinity,
                A = this.endDate !== Infinity ? this.endDate.getUTCMonth() + 1 : Infinity,
                r = (new h(this.date.getUTCFullYear(), this.date.getUTCMonth(), this.date.getUTCDate())).valueOf(),
                G = new Date();
            this.setTitle(".datetimepicker-days", a[this.language].months[I] + " " + u);
            if (this.formatViewType == "time") {
                var k = this.getFormattedDate();
                this.setTitle(".datetimepicker-hours", k);
                this.setTitle(".datetimepicker-minutes", k)
            } else {
                this.setTitle(".datetimepicker-hours", n + " " + a[this.language].months[I] + " " + u);
                this.setTitle(".datetimepicker-minutes", n + " " + a[this.language].months[I] + " " + u)
            }
            this.picker.find("tfoot th.today").text(a[this.language].today || a.en.today).toggle(this.todayBtn !== false);
            this.picker.find("tfoot th.clear").text(a[this.language].clear || a.en.clear).toggle(this.clearBtn !== false);
            this.updateNavArrows();
            this.fillMonths();
            var K = h(u, I - 1, 28, 0, 0, 0, 0), C = g.getDaysInMonth(K.getUTCFullYear(), K.getUTCMonth());
            K.setUTCDate(C);
            K.setUTCDate(C - (K.getUTCDay() - this.weekStart + 7) % 7);
            var j = new Date(K);
            j.setUTCDate(j.getUTCDate() + 42);
            j = j.valueOf();
            var s = [];
            var v;
            while (K.valueOf() < j) {
                if (K.getUTCDay() == this.weekStart) {
                    s.push("<tr>")
                }
                v = "";
                if (K.getUTCFullYear() < u || (K.getUTCFullYear() == u && K.getUTCMonth() < I)) {
                    v += " old"
                } else {
                    if (K.getUTCFullYear() > u || (K.getUTCFullYear() == u && K.getUTCMonth() > I)) {
                        v += " new"
                    }
                }
                if (this.todayHighlight && K.getUTCFullYear() == G.getFullYear() && K.getUTCMonth() == G.getMonth() && K.getUTCDate() == G.getDate()) {
                    v += " today"
                }
                if (K.valueOf() == r) {
                    v += " active"
                }
                if ((K.valueOf() + 86400000) <= this.startDate || K.valueOf() > this.endDate || f.inArray(K.getUTCDay(), this.daysOfWeekDisabled) !== -1 || f.inArray(K.toDateString(), this.datesDisabled) !== -1) {
                    v += " disabled"
                }
                s.push('<td class="day' + v + '">' + K.getUTCDate() + "</td>");
                if (K.getUTCDay() == this.weekEnd) {
                    s.push("</tr>")
                }
                K.setUTCDate(K.getUTCDate() + 1)
            }
            this.picker.find(".datetimepicker-days tbody").empty().append(s.join(""));
            s = [];
            var w = "", F = "", t = "";
            var l = this.hoursDisabled || [];
            for (var B = 0; B < 24; B++) {
                if (l.indexOf(B) !== -1) {
                    continue
                }
                var x = h(u, I, n, B);
                v = "";
                if ((x.valueOf() + 3600000) <= this.startDate || x.valueOf() > this.endDate) {
                    v += " disabled"
                } else {
                    if (D == B) {
                        v += " active"
                    }
                }
                if (this.showMeridian && a[this.language].meridiem.length == 2) {
                    F = (B < 12 ? a[this.language].meridiem[0] : a[this.language].meridiem[1]);
                    if (F != t) {
                        if (t != "") {
                            s.push("</fieldset>")
                        }
                        s.push('<fieldset class="hour"><legend>' + F.toUpperCase() + "</legend>")
                    }
                    t = F;
                    w = (B % 12 ? B % 12 : 12);
                    s.push('<span class="hour' + v + " hour_" + (B < 12 ? "am" : "pm") + '">' + w + "</span>");
                    if (B == 23) {
                        s.push("</fieldset>")
                    }
                } else {
                    w = B + ":00";
                    s.push('<span class="hour' + v + '">' + w + "</span>")
                }
            }
            this.picker.find(".datetimepicker-hours td").html(s.join(""));
            s = [];
            w = "", F = "", t = "";
            var m = this.minutesDisabled || [];
            for (var B = 0; B < 60; B += this.minuteStep) {
                if (m.indexOf(B) !== -1) {
                    continue
                }
                var x = h(u, I, n, D, B, 0);
                v = "";
                if (x.valueOf() < this.startDate || x.valueOf() > this.endDate) {
                    v += " disabled"
                } else {
                    if (Math.floor(y / this.minuteStep) == Math.floor(B / this.minuteStep)) {
                        v += " active"
                    }
                }
                if (this.showMeridian && a[this.language].meridiem.length == 2) {
                    F = (D < 12 ? a[this.language].meridiem[0] : a[this.language].meridiem[1]);
                    if (F != t) {
                        if (t != "") {
                            s.push("</fieldset>")
                        }
                        s.push('<fieldset class="minute"><legend>' + F.toUpperCase() + "</legend>")
                    }
                    t = F;
                    w = (D % 12 ? D % 12 : 12);
                    s.push('<span class="minute' + v + '">' + w + ":" + (B < 10 ? "0" + B : B) + "</span>");
                    if (B == 59) {
                        s.push("</fieldset>")
                    }
                } else {
                    w = B + ":00";
                    s.push('<span class="minute' + v + '">' + D + ":" + (B < 10 ? "0" + B : B) + "</span>")
                }
            }
            this.picker.find(".datetimepicker-minutes td").html(s.join(""));
            var L = this.date.getUTCFullYear();
            var p = this.setTitle(".datetimepicker-months", u).end().find("span").removeClass("active");
            if (L == u) {
                var o = p.length - 12;
                p.eq(this.date.getUTCMonth() + o).addClass("active")
            }
            if (u < z || u > q) {
                p.addClass("disabled")
            }
            if (u == z) {
                p.slice(0, E + 1).addClass("disabled")
            }
            if (u == q) {
                p.slice(A).addClass("disabled")
            }
            s = "";
            u = parseInt(u / 10, 10) * 10;
            var J = this.setTitle(".datetimepicker-years", u + "-" + (u + 9)).end().find("td");
            u -= 1;
            for (var B = -1; B < 11; B++) {
                s += '<span class="year' + (B == -1 || B == 10 ? " old" : "") + (L == u ? " active" : "") + (u < z || u > q ? " disabled" : "") + '">' + u + "</span>";
                u += 1
            }
            J.html(s);
            this.place()
        }, updateNavArrows: function () {
            var n = new Date(this.viewDate), l = n.getUTCFullYear(), m = n.getUTCMonth(), k = n.getUTCDate(),
                j = n.getUTCHours();
            switch (this.viewMode) {
                case 0:
                    if (this.startDate !== -Infinity && l <= this.startDate.getUTCFullYear() && m <= this.startDate.getUTCMonth() && k <= this.startDate.getUTCDate() && j <= this.startDate.getUTCHours()) {
                        this.picker.find(".prev").css({visibility: "hidden"})
                    } else {
                        this.picker.find(".prev").css({visibility: "visible"})
                    }
                    if (this.endDate !== Infinity && l >= this.endDate.getUTCFullYear() && m >= this.endDate.getUTCMonth() && k >= this.endDate.getUTCDate() && j >= this.endDate.getUTCHours()) {
                        this.picker.find(".next").css({visibility: "hidden"})
                    } else {
                        this.picker.find(".next").css({visibility: "visible"})
                    }
                    break;
                case 1:
                    if (this.startDate !== -Infinity && l <= this.startDate.getUTCFullYear() && m <= this.startDate.getUTCMonth() && k <= this.startDate.getUTCDate()) {
                        this.picker.find(".prev").css({visibility: "hidden"})
                    } else {
                        this.picker.find(".prev").css({visibility: "visible"})
                    }
                    if (this.endDate !== Infinity && l >= this.endDate.getUTCFullYear() && m >= this.endDate.getUTCMonth() && k >= this.endDate.getUTCDate()) {
                        this.picker.find(".next").css({visibility: "hidden"})
                    } else {
                        this.picker.find(".next").css({visibility: "visible"})
                    }
                    break;
                case 2:
                    if (this.startDate !== -Infinity && l <= this.startDate.getUTCFullYear() && m <= this.startDate.getUTCMonth()) {
                        this.picker.find(".prev").css({visibility: "hidden"})
                    } else {
                        this.picker.find(".prev").css({visibility: "visible"})
                    }
                    if (this.endDate !== Infinity && l >= this.endDate.getUTCFullYear() && m >= this.endDate.getUTCMonth()) {
                        this.picker.find(".next").css({visibility: "hidden"})
                    } else {
                        this.picker.find(".next").css({visibility: "visible"})
                    }
                    break;
                case 3:
                case 4:
                    if (this.startDate !== -Infinity && l <= this.startDate.getUTCFullYear()) {
                        this.picker.find(".prev").css({visibility: "hidden"})
                    } else {
                        this.picker.find(".prev").css({visibility: "visible"})
                    }
                    if (this.endDate !== Infinity && l >= this.endDate.getUTCFullYear()) {
                        this.picker.find(".next").css({visibility: "hidden"})
                    } else {
                        this.picker.find(".next").css({visibility: "visible"})
                    }
                    break
            }
        }, mousewheel: function (k) {
            k.preventDefault();
            k.stopPropagation();
            if (this.wheelPause) {
                return
            }
            this.wheelPause = true;
            var j = k.originalEvent;
            var m = j.wheelDelta;
            var l = m > 0 ? 1 : (m === 0) ? 0 : -1;
            if (this.wheelViewModeNavigationInverseDirection) {
                l = -l
            }
            this.showMode(l);
            setTimeout(f.proxy(function () {
                this.wheelPause = false
            }, this), this.wheelViewModeNavigationDelay)
        }, click: function (n) {
            n.stopPropagation();
            n.preventDefault();
            var o = f(n.target).closest("span, td, th, legend");
            if (o.is("." + this.icontype)) {
                o = f(o).parent().closest("span, td, th, legend")
            }
            if (o.length == 1) {
                if (o.is(".disabled")) {
                    this.element.trigger({
                        type: "outOfRange",
                        date: this.viewDate,
                        startDate: this.startDate,
                        endDate: this.endDate
                    });
                    return
                }
                switch (o[0].nodeName.toLowerCase()) {
                    case"th":
                        switch (o[0].className) {
                            case"switch":
                                this.showMode(1);
                                break;
                            case"prev":
                            case"next":
                                var j = g.modes[this.viewMode].navStep * (o[0].className == "prev" ? -1 : 1);
                                switch (this.viewMode) {
                                    case 0:
                                        this.viewDate = this.moveHour(this.viewDate, j);
                                        break;
                                    case 1:
                                        this.viewDate = this.moveDate(this.viewDate, j);
                                        break;
                                    case 2:
                                        this.viewDate = this.moveMonth(this.viewDate, j);
                                        break;
                                    case 3:
                                    case 4:
                                        this.viewDate = this.moveYear(this.viewDate, j);
                                        break
                                }
                                this.fill();
                                this.element.trigger({
                                    type: o[0].className + ":" + this.convertViewModeText(this.viewMode),
                                    date: this.viewDate,
                                    startDate: this.startDate,
                                    endDate: this.endDate
                                });
                                break;
                            case"clear":
                                this.reset();
                                if (this.autoclose) {
                                    this.hide()
                                }
                                break;
                            case"today":
                                var k = new Date();
                                k = h(k.getFullYear(), k.getMonth(), k.getDate(), k.getHours(), k.getMinutes(), k.getSeconds(), 0);
                                if (k < this.startDate) {
                                    k = this.startDate
                                } else {
                                    if (k > this.endDate) {
                                        k = this.endDate
                                    }
                                }
                                this.viewMode = this.startViewMode;
                                this.showMode(0);
                                this._setDate(k);
                                this.fill();
                                if (this.autoclose) {
                                    this.hide()
                                }
                                break
                        }
                        break;
                    case"span":
                        if (!o.is(".disabled")) {
                            var q = this.viewDate.getUTCFullYear(), p = this.viewDate.getUTCMonth(),
                                r = this.viewDate.getUTCDate(), s = this.viewDate.getUTCHours(),
                                l = this.viewDate.getUTCMinutes(), t = this.viewDate.getUTCSeconds();
                            if (o.is(".month")) {
                                this.viewDate.setUTCDate(1);
                                p = o.parent().find("span").index(o);
                                r = this.viewDate.getUTCDate();
                                this.viewDate.setUTCMonth(p);
                                this.element.trigger({type: "changeMonth", date: this.viewDate});
                                if (this.viewSelect >= 3) {
                                    this._setDate(h(q, p, r, s, l, t, 0))
                                }
                            } else {
                                if (o.is(".year")) {
                                    this.viewDate.setUTCDate(1);
                                    q = parseInt(o.text(), 10) || 0;
                                    this.viewDate.setUTCFullYear(q);
                                    this.element.trigger({type: "changeYear", date: this.viewDate});
                                    if (this.viewSelect >= 4) {
                                        this._setDate(h(q, p, r, s, l, t, 0))
                                    }
                                } else {
                                    if (o.is(".hour")) {
                                        s = parseInt(o.text(), 10) || 0;
                                        if (o.hasClass("hour_am") || o.hasClass("hour_pm")) {
                                            if (s == 12 && o.hasClass("hour_am")) {
                                                s = 0
                                            } else {
                                                if (s != 12 && o.hasClass("hour_pm")) {
                                                    s += 12
                                                }
                                            }
                                        }
                                        this.viewDate.setUTCHours(s);
                                        this.element.trigger({type: "changeHour", date: this.viewDate});
                                        if (this.viewSelect >= 1) {
                                            this._setDate(h(q, p, r, s, l, t, 0))
                                        }
                                    } else {
                                        if (o.is(".minute")) {
                                            l = parseInt(o.text().substr(o.text().indexOf(":") + 1), 10) || 0;
                                            this.viewDate.setUTCMinutes(l);
                                            this.element.trigger({type: "changeMinute", date: this.viewDate});
                                            if (this.viewSelect >= 0) {
                                                this._setDate(h(q, p, r, s, l, t, 0))
                                            }
                                        }
                                    }
                                }
                            }
                            if (this.viewMode != 0) {
                                var m = this.viewMode;
                                this.showMode(-1);
                                this.fill();
                                if (m == this.viewMode && this.autoclose) {
                                    this.hide()
                                }
                            } else {
                                this.fill();
                                if (this.autoclose) {
                                    this.hide()
                                }
                            }
                        }
                        break;
                    case"td":
                        if (o.is(".day") && !o.is(".disabled")) {
                            var r = parseInt(o.text(), 10) || 1;
                            var q = this.viewDate.getUTCFullYear(), p = this.viewDate.getUTCMonth(),
                                s = this.viewDate.getUTCHours(), l = this.viewDate.getUTCMinutes(),
                                t = this.viewDate.getUTCSeconds();
                            if (o.is(".old")) {
                                if (p === 0) {
                                    p = 11;
                                    q -= 1
                                } else {
                                    p -= 1
                                }
                            } else {
                                if (o.is(".new")) {
                                    if (p == 11) {
                                        p = 0;
                                        q += 1
                                    } else {
                                        p += 1
                                    }
                                }
                            }
                            this.viewDate.setUTCFullYear(q);
                            this.viewDate.setUTCMonth(p, r);
                            this.element.trigger({type: "changeDay", date: this.viewDate});
                            if (this.viewSelect >= 2) {
                                this._setDate(h(q, p, r, s, l, t, 0))
                            }
                        }
                        var m = this.viewMode;
                        this.showMode(-1);
                        this.fill();
                        if (m == this.viewMode && this.autoclose) {
                            this.hide()
                        }
                        break
                }
            }
        }, _setDate: function (j, l) {
            if (!l || l == "date") {
                this.date = j
            }
            if (!l || l == "view") {
                this.viewDate = j
            }
            this.fill();
            this.setValue();
            var k;
            if (this.isInput) {
                k = this.element
            } else {
                if (this.component) {
                    k = this.element.find("input")
                }
            }
            if (k) {
                k.change();
                if (this.autoclose && (!l || l == "date")) {
                }
            }
            this.element.trigger({type: "changeDate", date: this.getDate()});
            if (j == null) {
                this.date = this.viewDate
            }
        }, moveMinute: function (k, j) {
            if (!j) {
                return k
            }
            var l = new Date(k.valueOf());
            l.setUTCMinutes(l.getUTCMinutes() + (j * this.minuteStep));
            return l
        }, moveHour: function (k, j) {
            if (!j) {
                return k
            }
            var l = new Date(k.valueOf());
            l.setUTCHours(l.getUTCHours() + j);
            return l
        }, moveDate: function (k, j) {
            if (!j) {
                return k
            }
            var l = new Date(k.valueOf());
            l.setUTCDate(l.getUTCDate() + j);
            return l
        }, moveMonth: function (j, k) {
            if (!k) {
                return j
            }
            var n = new Date(j.valueOf()), r = n.getUTCDate(), o = n.getUTCMonth(), m = Math.abs(k), q, p;
            k = k > 0 ? 1 : -1;
            if (m == 1) {
                p = k == -1 ? function () {
                    return n.getUTCMonth() == o
                } : function () {
                    return n.getUTCMonth() != q
                };
                q = o + k;
                n.setUTCMonth(q);
                if (q < 0 || q > 11) {
                    q = (q + 12) % 12
                }
            } else {
                for (var l = 0; l < m; l++) {
                    n = this.moveMonth(n, k)
                }
                q = n.getUTCMonth();
                n.setUTCDate(r);
                p = function () {
                    return q != n.getUTCMonth()
                }
            }
            while (p()) {
                n.setUTCDate(--r);
                n.setUTCMonth(q)
            }
            return n
        }, moveYear: function (k, j) {
            return this.moveMonth(k, j * 12)
        }, dateWithinRange: function (j) {
            return j >= this.startDate && j <= this.endDate
        }, keydown: function (n) {
            if (this.picker.is(":not(:visible)")) {
                if (n.keyCode == 27) {
                    this.show()
                }
                return
            }
            var p = false, k, q, o, r, j;
            switch (n.keyCode) {
                case 27:
                    this.hide();
                    n.preventDefault();
                    break;
                case 37:
                case 39:
                    if (!this.keyboardNavigation) {
                        break
                    }
                    k = n.keyCode == 37 ? -1 : 1;
                    viewMode = this.viewMode;
                    if (n.ctrlKey) {
                        viewMode += 2
                    } else {
                        if (n.shiftKey) {
                            viewMode += 1
                        }
                    }
                    if (viewMode == 4) {
                        r = this.moveYear(this.date, k);
                        j = this.moveYear(this.viewDate, k)
                    } else {
                        if (viewMode == 3) {
                            r = this.moveMonth(this.date, k);
                            j = this.moveMonth(this.viewDate, k)
                        } else {
                            if (viewMode == 2) {
                                r = this.moveDate(this.date, k);
                                j = this.moveDate(this.viewDate, k)
                            } else {
                                if (viewMode == 1) {
                                    r = this.moveHour(this.date, k);
                                    j = this.moveHour(this.viewDate, k)
                                } else {
                                    if (viewMode == 0) {
                                        r = this.moveMinute(this.date, k);
                                        j = this.moveMinute(this.viewDate, k)
                                    }
                                }
                            }
                        }
                    }
                    if (this.dateWithinRange(r)) {
                        this.date = r;
                        this.viewDate = j;
                        this.setValue();
                        this.update();
                        n.preventDefault();
                        p = true
                    }
                    break;
                case 38:
                case 40:
                    if (!this.keyboardNavigation) {
                        break
                    }
                    k = n.keyCode == 38 ? -1 : 1;
                    viewMode = this.viewMode;
                    if (n.ctrlKey) {
                        viewMode += 2
                    } else {
                        if (n.shiftKey) {
                            viewMode += 1
                        }
                    }
                    if (viewMode == 4) {
                        r = this.moveYear(this.date, k);
                        j = this.moveYear(this.viewDate, k)
                    } else {
                        if (viewMode == 3) {
                            r = this.moveMonth(this.date, k);
                            j = this.moveMonth(this.viewDate, k)
                        } else {
                            if (viewMode == 2) {
                                r = this.moveDate(this.date, k * 7);
                                j = this.moveDate(this.viewDate, k * 7)
                            } else {
                                if (viewMode == 1) {
                                    if (this.showMeridian) {
                                        r = this.moveHour(this.date, k * 6);
                                        j = this.moveHour(this.viewDate, k * 6)
                                    } else {
                                        r = this.moveHour(this.date, k * 4);
                                        j = this.moveHour(this.viewDate, k * 4)
                                    }
                                } else {
                                    if (viewMode == 0) {
                                        r = this.moveMinute(this.date, k * 4);
                                        j = this.moveMinute(this.viewDate, k * 4)
                                    }
                                }
                            }
                        }
                    }
                    if (this.dateWithinRange(r)) {
                        this.date = r;
                        this.viewDate = j;
                        this.setValue();
                        this.update();
                        n.preventDefault();
                        p = true
                    }
                    break;
                case 13:
                    if (this.viewMode != 0) {
                        var m = this.viewMode;
                        this.showMode(-1);
                        this.fill();
                        if (m == this.viewMode && this.autoclose) {
                            this.hide()
                        }
                    } else {
                        this.fill();
                        if (this.autoclose) {
                            this.hide()
                        }
                    }
                    n.preventDefault();
                    break;
                case 9:
                    this.hide();
                    break
            }
            if (p) {
                var l;
                if (this.isInput) {
                    l = this.element
                } else {
                    if (this.component) {
                        l = this.element.find("input")
                    }
                }
                if (l) {
                    l.change()
                }
                this.element.trigger({type: "changeDate", date: this.getDate()})
            }
        }, showMode: function (j) {
            if (j) {
                var k = Math.max(0, Math.min(g.modes.length - 1, this.viewMode + j));
                if (k >= this.minView && k <= this.maxView) {
                    this.element.trigger({
                        type: "changeMode",
                        date: this.viewDate,
                        oldViewMode: this.viewMode,
                        newViewMode: k
                    });
                    this.viewMode = k
                }
            }
            this.picker.find(">div").hide().filter(".datetimepicker-" + g.modes[this.viewMode].clsName).css("display", "block");
            this.updateNavArrows()
        }, reset: function (j) {
            this._setDate(null, "date")
        }, convertViewModeText: function (j) {
            switch (j) {
                case 4:
                    return "decade";
                case 3:
                    return "year";
                case 2:
                    return "month";
                case 1:
                    return "day";
                case 0:
                    return "hour"
            }
        }
    };
    var b = f.fn.datetimepicker;
    f.fn.datetimepicker = function (l) {
        var j = Array.apply(null, arguments);
        j.shift();
        var k;
        this.each(function () {
            var o = f(this), n = o.data("datetimepicker"), m = typeof l == "object" && l;
            if (!n) {
                o.data("datetimepicker", (n = new i(this, f.extend({}, f.fn.datetimepicker.defaults, m))))
            }
            if (typeof l == "string" && typeof n[l] == "function") {
                k = n[l].apply(n, j);
                if (k !== c) {
                    return false
                }
            }
        });
        if (k !== c) {
            return k
        } else {
            return this
        }
    };
    f.fn.datetimepicker.defaults = {};
    f.fn.datetimepicker.Constructor = i;
    var a = f.fn.datetimepicker.dates = {
        en: {
            days: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
            daysShort: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
            daysMin: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa", "Su"],
            months: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
            monthsShort: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            meridiem: ["am", "pm"],
            suffix: ["st", "nd", "rd", "th"],
            today: "Today",
            clear: "Clear"
        }
    };
    var g = {
        modes: [{clsName: "minutes", navFnc: "Hours", navStep: 1}, {
            clsName: "hours",
            navFnc: "Date",
            navStep: 1
        }, {clsName: "days", navFnc: "Month", navStep: 1}, {
            clsName: "months",
            navFnc: "FullYear",
            navStep: 1
        }, {clsName: "years", navFnc: "FullYear", navStep: 10}],
        isLeapYear: function (j) {
            return (((j % 4 === 0) && (j % 100 !== 0)) || (j % 400 === 0))
        },
        getDaysInMonth: function (j, k) {
            return [31, (g.isLeapYear(j) ? 29 : 28), 31, 30, 31, 30, 31, 31, 30, 31, 30, 31][k]
        },
        getDefaultFormat: function (j, k) {
            if (j == "standard") {
                if (k == "input") {
                    return "yyyy-mm-dd hh:ii"
                } else {
                    return "yyyy-mm-dd hh:ii:ss"
                }
            } else {
                if (j == "php") {
                    if (k == "input") {
                        return "Y-m-d H:i"
                    } else {
                        return "Y-m-d H:i:s"
                    }
                } else {
                    throw new Error("Invalid format type.")
                }
            }
        },
        validParts: function (j) {
            if (j == "standard") {
                return /t|hh?|HH?|p|P|ii?|ss?|dd?|DD?|mm?|MM?|yy(?:yy)?/g
            } else {
                if (j == "php") {
                    return /[dDjlNwzFmMnStyYaABgGhHis]/g
                } else {
                    throw new Error("Invalid format type.")
                }
            }
        },
        nonpunctuation: /[^ -\/:-@\[-`{-~\t\n\rTZ]+/g,
        parseFormat: function (m, k) {
            var j = m.replace(this.validParts(k), "\0").split("\0"), l = m.match(this.validParts(k));
            if (!j || !j.length || !l || l.length == 0) {
                throw new Error("Invalid date format.")
            }
            return {separators: j, parts: l}
        },
        parseDate: function (n, w, q, u) {
            if (n instanceof Date) {
                var y = new Date(n.valueOf() - n.getTimezoneOffset() * 60000);
                y.setMilliseconds(0);
                return y
            }
            if (/^\d{4}\-\d{1,2}\-\d{1,2}$/.test(n)) {
                w = this.parseFormat("yyyy-mm-dd", u)
            }
            if (/^\d{4}\-\d{1,2}\-\d{1,2}[T ]\d{1,2}\:\d{1,2}$/.test(n)) {
                w = this.parseFormat("yyyy-mm-dd hh:ii", u)
            }
            if (/^\d{4}\-\d{1,2}\-\d{1,2}[T ]\d{1,2}\:\d{1,2}\:\d{1,2}[Z]{0,1}$/.test(n)) {
                w = this.parseFormat("yyyy-mm-dd hh:ii:ss", u)
            }
            if (/^[-+]\d+[dmwy]([\s,]+[-+]\d+[dmwy])*$/.test(n)) {
                var z = /([-+]\d+)([dmwy])/, o = n.match(/([-+]\d+)([dmwy])/g), j, m;
                n = new Date();
                for (var p = 0; p < o.length; p++) {
                    j = z.exec(o[p]);
                    m = parseInt(j[1]);
                    switch (j[2]) {
                        case"d":
                            n.setUTCDate(n.getUTCDate() + m);
                            break;
                        case"m":
                            n = i.prototype.moveMonth.call(i.prototype, n, m);
                            break;
                        case"w":
                            n.setUTCDate(n.getUTCDate() + m * 7);
                            break;
                        case"y":
                            n = i.prototype.moveYear.call(i.prototype, n, m);
                            break
                    }
                }
                return h(n.getUTCFullYear(), n.getUTCMonth(), n.getUTCDate(), n.getUTCHours(), n.getUTCMinutes(), n.getUTCSeconds(), 0)
            }
            var o = n && n.toString().match(this.nonpunctuation) || [], n = new Date(0, 0, 0, 0, 0, 0, 0), t = {},
                v = ["hh", "h", "ii", "i", "ss", "s", "yyyy", "yy", "M", "MM", "m", "mm", "D", "DD", "d", "dd", "H", "HH", "p", "P"],
                x = {
                    hh: function (B, s) {
                        return B.setUTCHours(s)
                    }, h: function (B, s) {
                        return B.setUTCHours(s)
                    }, HH: function (B, s) {
                        return B.setUTCHours(s == 12 ? 0 : s)
                    }, H: function (B, s) {
                        return B.setUTCHours(s == 12 ? 0 : s)
                    }, ii: function (B, s) {
                        return B.setUTCMinutes(s)
                    }, i: function (B, s) {
                        return B.setUTCMinutes(s)
                    }, ss: function (B, s) {
                        return B.setUTCSeconds(s)
                    }, s: function (B, s) {
                        return B.setUTCSeconds(s)
                    }, yyyy: function (B, s) {
                        return B.setUTCFullYear(s)
                    }, yy: function (B, s) {
                        return B.setUTCFullYear(2000 + s)
                    }, m: function (B, s) {
                        s -= 1;
                        while (s < 0) {
                            s += 12
                        }
                        s %= 12;
                        B.setUTCMonth(s);
                        while (B.getUTCMonth() != s) {
                            if (isNaN(B.getUTCMonth())) {
                                return B
                            } else {
                                B.setUTCDate(B.getUTCDate() - 1)
                            }
                        }
                        return B
                    }, d: function (B, s) {
                        return B.setUTCDate(s)
                    }, p: function (B, s) {
                        return B.setUTCHours(s == 1 ? B.getUTCHours() + 12 : B.getUTCHours())
                    }
                }, l, r, j;
            x.M = x.MM = x.mm = x.m;
            x.dd = x.d;
            x.P = x.p;
            n = h(n.getFullYear(), n.getMonth(), n.getDate(), n.getHours(), n.getMinutes(), n.getSeconds());
            if (o.length == w.parts.length) {
                for (var p = 0, k = w.parts.length; p < k; p++) {
                    l = parseInt(o[p], 10);
                    j = w.parts[p];
                    if (isNaN(l)) {
                        switch (j) {
                            case"MM":
                                r = f(a[q].months).filter(function () {
                                    var s = this.slice(0, o[p].length), B = o[p].slice(0, s.length);
                                    return s == B
                                });
                                l = f.inArray(r[0], a[q].months) + 1;
                                break;
                            case"M":
                                r = f(a[q].monthsShort).filter(function () {
                                    var s = this.slice(0, o[p].length), B = o[p].slice(0, s.length);
                                    return s.toLowerCase() == B.toLowerCase()
                                });
                                l = f.inArray(r[0], a[q].monthsShort) + 1;
                                break;
                            case"p":
                            case"P":
                                l = f.inArray(o[p].toLowerCase(), a[q].meridiem);
                                break
                        }
                    }
                    t[j] = l
                }
                for (var p = 0, A; p < v.length; p++) {
                    A = v[p];
                    if (A in t && !isNaN(t[A])) {
                        x[A](n, t[A])
                    }
                }
            }
            return n
        },
        formatDate: function (j, o, q, m) {
            if (j == null) {
                return ""
            }
            var p;
            if (m == "standard") {
                p = {
                    t: j.getTime(),
                    yy: j.getUTCFullYear().toString().substring(2),
                    yyyy: j.getUTCFullYear(),
                    m: j.getUTCMonth() + 1,
                    M: a[q].monthsShort[j.getUTCMonth()],
                    MM: a[q].months[j.getUTCMonth()],
                    d: j.getUTCDate(),
                    D: a[q].daysShort[j.getUTCDay()],
                    DD: a[q].days[j.getUTCDay()],
                    p: (a[q].meridiem.length == 2 ? a[q].meridiem[j.getUTCHours() < 12 ? 0 : 1] : ""),
                    h: j.getUTCHours(),
                    i: j.getUTCMinutes(),
                    s: j.getUTCSeconds()
                };
                if (a[q].meridiem.length == 2) {
                    p.H = (p.h % 12 == 0 ? 12 : p.h % 12)
                } else {
                    p.H = p.h
                }
                p.HH = (p.H < 10 ? "0" : "") + p.H;
                p.P = p.p.toUpperCase();
                p.hh = (p.h < 10 ? "0" : "") + p.h;
                p.ii = (p.i < 10 ? "0" : "") + p.i;
                p.ss = (p.s < 10 ? "0" : "") + p.s;
                p.dd = (p.d < 10 ? "0" : "") + p.d;
                p.mm = (p.m < 10 ? "0" : "") + p.m
            } else {
                if (m == "php") {
                    p = {
                        y: j.getUTCFullYear().toString().substring(2),
                        Y: j.getUTCFullYear(),
                        F: a[q].months[j.getUTCMonth()],
                        M: a[q].monthsShort[j.getUTCMonth()],
                        n: j.getUTCMonth() + 1,
                        t: g.getDaysInMonth(j.getUTCFullYear(), j.getUTCMonth()),
                        j: j.getUTCDate(),
                        l: a[q].days[j.getUTCDay()],
                        D: a[q].daysShort[j.getUTCDay()],
                        w: j.getUTCDay(),
                        N: (j.getUTCDay() == 0 ? 7 : j.getUTCDay()),
                        S: (j.getUTCDate() % 10 <= a[q].suffix.length ? a[q].suffix[j.getUTCDate() % 10 - 1] : ""),
                        a: (a[q].meridiem.length == 2 ? a[q].meridiem[j.getUTCHours() < 12 ? 0 : 1] : ""),
                        g: (j.getUTCHours() % 12 == 0 ? 12 : j.getUTCHours() % 12),
                        G: j.getUTCHours(),
                        i: j.getUTCMinutes(),
                        s: j.getUTCSeconds()
                    };
                    p.m = (p.n < 10 ? "0" : "") + p.n;
                    p.d = (p.j < 10 ? "0" : "") + p.j;
                    p.A = p.a.toString().toUpperCase();
                    p.h = (p.g < 10 ? "0" : "") + p.g;
                    p.H = (p.G < 10 ? "0" : "") + p.G;
                    p.i = (p.i < 10 ? "0" : "") + p.i;
                    p.s = (p.s < 10 ? "0" : "") + p.s
                } else {
                    throw new Error("Invalid format type.")
                }
            }
            var j = [], n = f.extend([], o.separators);
            for (var l = 0, k = o.parts.length; l < k; l++) {
                if (n.length) {
                    j.push(n.shift())
                }
                j.push(p[o.parts[l]])
            }
            if (n.length) {
                j.push(n.shift())
            }
            return j.join("")
        },
        convertViewMode: function (j) {
            switch (j) {
                case 4:
                case"decade":
                    j = 4;
                    break;
                case 3:
                case"year":
                    j = 3;
                    break;
                case 2:
                case"month":
                    j = 2;
                    break;
                case 1:
                case"day":
                    j = 1;
                    break;
                case 0:
                case"hour":
                    j = 0;
                    break
            }
            return j
        },
        headTemplate: '<thead><tr><th class="prev"><img src="http://images.hezongyy.com/images/user/lb_left_03.png"></th><th colspan="5" class="switch"></th><th class="next"><img src="http://images.hezongyy.com/images/user/lb_right_03.png"></th></tr></thead>',
        headTemplateV3: '<thead><tr><th class="prev"><span class="{iconType} {leftArrow}"></span> </th><th colspan="5" class="switch"></th><th class="next"><span class="{iconType} {rightArrow}"></span> </th></tr></thead>',
        contTemplate: '<tbody><tr><td colspan="7"></td></tr></tbody>',
        footTemplate: '<tfoot><tr><th colspan="7" class="today"></th></tr><tr><th colspan="7" class="clear"></th></tr></tfoot>'
    };
    g.template = '<div class="datetimepicker"><div class="datetimepicker-minutes"><table class=" table-condensed">' + g.headTemplate + g.contTemplate + g.footTemplate + '</table></div><div class="datetimepicker-hours"><table class=" table-condensed">' + g.headTemplate + g.contTemplate + g.footTemplate + '</table></div><div class="datetimepicker-days"><table class=" table-condensed">' + g.headTemplate + "<tbody></tbody>" + g.footTemplate + '</table></div><div class="datetimepicker-months"><table class="table-condensed">' + g.headTemplate + g.contTemplate + g.footTemplate + '</table></div><div class="datetimepicker-years"><table class="table-condensed">' + g.headTemplate + g.contTemplate + g.footTemplate + "</table></div></div>";
    g.templateV3 = '<div class="datetimepicker"><div class="datetimepicker-minutes"><table class=" table-condensed">' + g.headTemplateV3 + g.contTemplate + g.footTemplate + '</table></div><div class="datetimepicker-hours"><table class=" table-condensed">' + g.headTemplateV3 + g.contTemplate + g.footTemplate + '</table></div><div class="datetimepicker-days"><table class=" table-condensed">' + g.headTemplateV3 + "<tbody></tbody>" + g.footTemplate + '</table></div><div class="datetimepicker-months"><table class="table-condensed">' + g.headTemplateV3 + g.contTemplate + g.footTemplate + '</table></div><div class="datetimepicker-years"><table class="table-condensed">' + g.headTemplateV3 + g.contTemplate + g.footTemplate + "</table></div></div>";
    f.fn.datetimepicker.DPGlobal = g;
    f.fn.datetimepicker.noConflict = function () {
        f.fn.datetimepicker = b;
        return this
    };
    f(document).on("focus.datetimepicker.data-api click.datetimepicker.data-api", '[data-provide="datetimepicker"]', function (k) {
        var j = f(this);
        if (j.data("datetimepicker")) {
            return
        }
        k.preventDefault();
        j.datetimepicker("show")
    });
    f(function () {
        f('[data-provide="datetimepicker-inline"]').datetimepicker()
    })
}));