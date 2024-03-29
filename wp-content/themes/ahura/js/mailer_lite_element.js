! function() {
    "use strict";

    function a() {
        void 0 !== window.jQuery && (window.ml_jQuery = window.jQuery.noConflict(!0)), c()
    }

    function b(a, b) {
        if ("function" == typeof window.ml_webform_after_success && window.ml_webform_after_success(), !a.data("continue") && !a.data("redirect")) {
            var c = b.attr("id").substr(5),
                d = c.split("-");
            if (0 === d.length) return;
            var f = "ml_webform_success_" + d[0],
                g = b.find(".ml-block-success"),
                h = b.find(".ml-block-form");
            g.length && h.length ? (g.show(), h.hide()) : "function" == typeof window[f] && (window[f](), e())
        }
        window != window.parent && window.parent.postMessage("mlWebformSubmitSuccess-" + b.attr("id").substr(5), "*");
        "function" == typeof window.ml_survey_success && (window.ml_survey_success(a.data("scope-id")), e())
    }

    function c() {
        var a = [aeml.theme_url + "/js/ml_jQuery.inputmask.bundle.min.js"];
        for (var b in a)
            if (a.hasOwnProperty(b)) {
                var c = document.createElement("script");
                c.setAttribute("type", "text/javascript"), c.setAttribute("src", a[b]), b == a.length - 1 && (c.onload = e, c.onreadystatechange = function() {
                    "complete" !== this.readyState && "loaded" !== this.readyState || e()
                }), document.getElementsByTagName("head")[0].appendChild(c)
            }
    }

    function d() {
        window.ml_jQuery(document).bind("DOMSubtreeModified", function() {
            var a = window.ml_jQuery(this).find(j);
            k !== a.length && (k = a.length, e())
        })
    }

    function e() {
        var a = "";
        if ("function" == typeof window.ml_guid) {
            a = window.ml_guid();
            try {
                window.localStorage && (window.localStorage.ml_guid ? a = window.localStorage.ml_guid : window.localStorage.ml_guid = a)
            } catch (a) {}
        }
        var c = !1;
        try {
            window && window.location && window.location.hostname && window.parent && window.parent.window && window.parent.window.location && window.parent.window.location.hostname && (c = window.location.hostname === window.parent.window.location.hostname)
        } catch (a) {
            c = !1
        }
        d(), window.ml_jQuery(j).each(function() {
            var d = window.ml_jQuery(this),
                e = window.ml_jQuery(this).closest(".ml-subscribe-form, .ml-contact-form"),
                g = window.ml_jQuery(this).find("button.primary"),
                h = window.ml_jQuery(this).find("button.loading"),
                j = h.length > 0;
            if (d.find("input,textarea,select").attr("aria-invalid", "false"), d.find(".ml-validate-date input").inputmask(void 0, {
                    oncomplete: function() {
                        window.ml_jQuery(this).closest(".ml-validate-date").addClass("ml-validate-date-valid")
                    },
                    onincomplete: function() {
                        window.ml_jQuery(this).closest(".ml-validate-date").removeClass("ml-validate-date-valid")
                    },
                    oncleared: function() {
                        window.ml_jQuery(this).closest(".ml-validate-date").removeClass("ml-validate-date-valid")
                    },
                    onKeyValidation: function() {
                        window.ml_jQuery(this).closest(".ml-validate-date").removeClass("ml-validate-date-valid")
                    }
                }), d.find(".ml-validate-phone input").inputmask(void 0, {
                    oncomplete: function() {
                        window.ml_jQuery(this).closest(".ml-validate-phone").addClass("ml-validate-phone-valid")
                    },
                    onincomplete: function() {
                        window.ml_jQuery(this).closest(".ml-validate-phone").removeClass("ml-validate-phone-valid")
                    },
                    oncleared: function() {
                        window.ml_jQuery(this).closest(".ml-validate-phone").removeClass("ml-validate-phone-valid")
                    },
                    onKeyValidation: function() {
                        window.ml_jQuery(this).closest(".ml-validate-phone").removeClass("ml-validate-phone-valid")
                    }
                }), void 0 === d.data("ml-submit-bound") || !d.data("ml-submit-bound")) {
                d.data("ml-submit-bound", 1), e.find(".ml-block-success").bind("click", function() {
                    e.find(".ml-block-success").hide(), e.find(".ml-block-form").find('input[type="text"]').val("");
                    var a = e.find(".ml-block-form").find('input[type="checkbox"],input[type="radio"]');
                    void 0 !== a.prop ? a.prop("checked", !1) : a.attr("checked", !1), e.find(".ml-block-form").show()
                }), window.ml_jQuery(":submit", d).click(function() {
                    d.find('input[type="hidden"].ml-submit-hidden-value').remove(), window.ml_jQuery(this).attr("name") && d.append(window.ml_jQuery('<input type="hidden" class="ml-submit-hidden-value">').attr({
                        name: window.ml_jQuery(this).attr("name"),
                        value: window.ml_jQuery(this).attr("value")
                    }))
                }), window.ml_jQuery("body").hasClass("ml-submit-success") && b(d, e), d.bind("submit", function(i) {
                    if (i.preventDefault(), d.data("loading")) return !1;
                    if (d.find(".ml-error").removeClass("ml-error"), d.find(":input[aria-invalid=true]").attr("aria-invalid", "false"), f(d)) {
                        j && (g.hide(), h.show());
                        var k = d.serialize();
                        k = k + "&ajax=1&guid=" + a;
                        var l = d.attr("action");
                        d.data("loading", !0);
                        /^https?:\/\/.*$/i.test(l) && (!c || k.toLowerCase().indexOf("email") >= 0) && window.ml_jQuery.ajax({
                            type: "GET",
                            url: l,
                            data: k,
                            dataType: "jsonp",
                            success: function(a) {
                                if (d.data("loading", !1), j && (g.show(), h.hide()), a.success ? b(d, e) : void 0 !== a.errors && (void 0 !== a.errors.groups && a.errors.groups && (d.find(".ml-block-groups").addClass("ml-error"), d.find(".ml-block-groups :input[aria-invalid=false]").attr("aria-invalid", "true")), void 0 !== a.errors.fields && a.errors.fields && window.ml_jQuery.each(a.errors.fields, function(a) {
                                        d.find(".ml-field-" + a).addClass("ml-error"), d.find(".ml-field-" + a + ":input[aria-invalid=false]").attr("aria-invalid", "true")
                                    })), d.data("redirect")) {
                                    var f = d.data("redirect-target");
                                    c ? window.top.open(d.data("redirect"), f || "_blank") : window.parent.postMessage("mlWebformRedirect-" + encodeURIComponent(d.data("redirect")) + (f ? "-" + f : ""), "*")
                                }
                            },
                            error: function() {
                                d.data("loading", !1), j && (g.show(), h.hide())
                            }
                        });
                        d.data("close") && "function" == typeof window.close && window.close()
                    }
                });
                var k = d.attr("data-id"),
                    l = d.attr("data-code");
                k && ((new Image).src = i + "/webforms/o/" + k + "/" + l + "?v" + Math.floor(Date.now() / 1e3))
            }
            window != window.parent && (window.ml_jQuery(document).on("click", ".overlay, .ml-subscribe-close", function() {
                window.parent.postMessage("mlCloseIframe-" + d.data("code"), "*")
            }), window.ml_jQuery(".ml-subscribe-form").bind("click", function(a) {
                var b = a.target || a.srcElement;
                window.ml_jQuery(b).is("div.ml-subscribe-close") || a.stopPropagation()
            }))
        })
    }

    function f(a) {
        var b = !0;
        return a.find(".ml-validate-required").each(function(a, c) {
            var d = !1;
            window.ml_jQuery(c).find('input[type="text"], input[type="email"], input[type="number"], select, textarea').each(function(a, b) {
                void 0 !== window.ml_jQuery(b).val() && "" !== window.ml_jQuery(b).val() && (d = !0)
            }), window.ml_jQuery(c).find('input[type="checkbox"],input[type="radio"],input[type="hidden"]').each(function(a, b) {
                void 0 !== window.ml_jQuery(b).prop ? window.ml_jQuery(b).prop("checked") && (d = !0) : window.ml_jQuery(b).attr("checked") && (d = !0)
            }), d || (window.ml_jQuery(c).addClass("ml-error"), window.ml_jQuery(c).find(":input[aria-invalid=false]").attr("aria-invalid", "true"), b = !1)
        }), a.find(".ml-validate-email").each(function(a, c) {
            var d = !0;
            window.ml_jQuery(c).find('input[type="text"], input[type="email"]').each(function(a, b) {
                void 0 === window.ml_jQuery(b).val() || "" === window.ml_jQuery(b).val() || g(window.ml_jQuery(b).val()) || (d = !1)
            }), d || (window.ml_jQuery(c).addClass("ml-error"), window.ml_jQuery(c).find(":input[aria-invalid=false]").attr("aria-invalid", "true"), b = !1)
        }), a.find(".ml-validate-date").each(function(a, c) {
            var d = !0;
            window.ml_jQuery(c).find('input[type="text"]').each(function(a, b) {
                void 0 === window.ml_jQuery(b).val() || "" === window.ml_jQuery(b).val() || window.ml_jQuery(c).hasClass("ml-validate-date-valid") || (d = !1)
            }), d || (window.ml_jQuery(c).addClass("ml-error"), window.ml_jQuery(c).find(":input[aria-invalid=false]").attr("aria-invalid", "true"), b = !1)
        }), a.find(".ml-validate-phone").each(function(a, c) {
            var d = !0;
            window.ml_jQuery(c).find('input[type="text"]').each(function(a, b) {
                void 0 === window.ml_jQuery(b).val() || "" === window.ml_jQuery(b).val() || window.ml_jQuery(c).hasClass("ml-validate-phone-valid") || (d = !1)
            }), d || (window.ml_jQuery(c).addClass("ml-error"), window.ml_jQuery(c).find(":input[aria-invalid=false]").attr("aria-invalid", "true"), b = !1)
        }), b
    }

    function g(a) {
        return /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]){2,40}$/.test(a.trim())
    }
    var h = "https://static.mailerlite.com",
        i = "https://track.mailerlite.com",
        j = ".ml-subscribe-form form, .ml-contact-form form",
        k = 0;
    if (void 0 !== window.ml_jQuery && "function" == typeof window.ml_jQuery.ajax) return void c();
    if (void 0 !== window.jQuery && "function" == typeof window.jQuery.ajax) return window.ml_jQuery = window.jQuery, void c();
    window.ml_guid = function() {
        function a() {
            return Math.floor(65536 * (1 + Math.random())).toString(16).substring(1)
        }
        return a() + a() + "-" + a() + "-" + a() + "-" + a() + "-" + a() + a() + a()
    }
}();
