(function (fn) {
  typeof define == "function" && define.amd ? define(fn) : fn();
})(function () {
  "use strict";
  (function () {
    function s() {
      for (var t = arguments.length, i = 0; i < t; i++) {
        var n = i < 0 || arguments.length <= i ? void 0 : arguments[i];
        n.nodeType === 1 || n.nodeType === 11
          ? this.appendChild(n)
          : this.appendChild(document.createTextNode(String(n)));
      }
    }
    function e() {
      for (; this.lastChild; ) this.removeChild(this.lastChild);
      arguments.length && this.append.apply(this, arguments);
    }
    function r() {
      for (
        var t = this.parentNode, i = arguments.length, n = new Array(i), o = 0;
        o < i;
        o++
      )
        n[o] = arguments[o];
      var a = n.length;
      if (!!t)
        for (a || t.removeChild(this); a--; ) {
          var l = n[a];
          typeof l != "object"
            ? (l = this.ownerDocument.createTextNode(l))
            : l.parentNode && l.parentNode.removeChild(l),
            a
              ? t.insertBefore(this.previousSibling, l)
              : t.replaceChild(l, this);
        }
    }
    typeof Element != "undefined" &&
      (Element.prototype.append ||
        ((Element.prototype.append = s),
        (DocumentFragment.prototype.append = s)),
      Element.prototype.replaceChildren ||
        ((Element.prototype.replaceChildren = e),
        (DocumentFragment.prototype.replaceChildren = e)),
      Element.prototype.replaceWith ||
        ((Element.prototype.replaceWith = r),
        (DocumentFragment.prototype.replaceWith = r)));
  })();
  function fn(s, e) {
    if (!(s instanceof e))
      throw new TypeError("Cannot call a class as a function");
  }
  function ko(s, e) {
    for (var r = 0; r < e.length; r++) {
      var t = e[r];
      (t.enumerable = t.enumerable || !1),
        (t.configurable = !0),
        "value" in t && (t.writable = !0),
        Object.defineProperty(s, t.key, t);
    }
  }
  function Co(s, e, r) {
    return e && ko(s.prototype, e), r && ko(s, r), s;
  }
  function oc(s, e, r) {
    return (
      e in s
        ? Object.defineProperty(s, e, {
            value: r,
            enumerable: !0,
            configurable: !0,
            writable: !0,
          })
        : (s[e] = r),
      s
    );
  }
  function Ao(s, e) {
    var r = Object.keys(s);
    if (Object.getOwnPropertySymbols) {
      var t = Object.getOwnPropertySymbols(s);
      e &&
        (t = t.filter(function (i) {
          return Object.getOwnPropertyDescriptor(s, i).enumerable;
        })),
        r.push.apply(r, t);
    }
    return r;
  }
  function Po(s) {
    for (var e = 1; e < arguments.length; e++) {
      var r = arguments[e] != null ? arguments[e] : {};
      e % 2
        ? Ao(Object(r), !0).forEach(function (t) {
            oc(s, t, r[t]);
          })
        : Object.getOwnPropertyDescriptors
        ? Object.defineProperties(s, Object.getOwnPropertyDescriptors(r))
        : Ao(Object(r)).forEach(function (t) {
            Object.defineProperty(s, t, Object.getOwnPropertyDescriptor(r, t));
          });
    }
    return s;
  }
  function Oo(s, e) {
    return lc(s) || uc(s, e) || Lo(s, e) || dc();
  }
  function st(s) {
    return ac(s) || cc(s) || Lo(s) || fc();
  }
  function ac(s) {
    if (Array.isArray(s)) return ns(s);
  }
  function lc(s) {
    if (Array.isArray(s)) return s;
  }
  function cc(s) {
    if (typeof Symbol != "undefined" && Symbol.iterator in Object(s))
      return Array.from(s);
  }
  function uc(s, e) {
    if (!(typeof Symbol == "undefined" || !(Symbol.iterator in Object(s)))) {
      var r = [],
        t = !0,
        i = !1,
        n = void 0;
      try {
        for (
          var o = s[Symbol.iterator](), a;
          !(t = (a = o.next()).done) &&
          (r.push(a.value), !(e && r.length === e));
          t = !0
        );
      } catch (l) {
        (i = !0), (n = l);
      } finally {
        try {
          !t && o.return != null && o.return();
        } finally {
          if (i) throw n;
        }
      }
      return r;
    }
  }
  function Lo(s, e) {
    if (!!s) {
      if (typeof s == "string") return ns(s, e);
      var r = Object.prototype.toString.call(s).slice(8, -1);
      if (
        (r === "Object" && s.constructor && (r = s.constructor.name),
        r === "Map" || r === "Set")
      )
        return Array.from(s);
      if (
        r === "Arguments" ||
        /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(r)
      )
        return ns(s, e);
    }
  }
  function ns(s, e) {
    (e == null || e > s.length) && (e = s.length);
    for (var r = 0, t = new Array(e); r < e; r++) t[r] = s[r];
    return t;
  }
  function fc() {
    throw new TypeError(`Invalid attempt to spread non-iterable instance.
In order to be iterable, non-array objects must have a [Symbol.iterator]() method.`);
  }
  function dc() {
    throw new TypeError(`Invalid attempt to destructure non-iterable instance.
In order to be iterable, non-array objects must have a [Symbol.iterator]() method.`);
  }
  function zr(s, e) {
    return Object.getOwnPropertyNames(Object(s)).reduce(function (r, t) {
      var i = Object.getOwnPropertyDescriptor(Object(s), t),
        n = Object.getOwnPropertyDescriptor(Object(e), t);
      return Object.defineProperty(r, t, n || i);
    }, {});
  }
  function Mi(s) {
    return typeof s == "string";
  }
  function ss(s) {
    return Array.isArray(s);
  }
  function dn() {
    var s = arguments.length > 0 && arguments[0] !== void 0 ? arguments[0] : {},
      e = zr(s),
      r;
    return (
      e.types !== void 0 ? (r = e.types) : e.split !== void 0 && (r = e.split),
      r !== void 0 &&
        (e.types = (Mi(r) || ss(r) ? String(r) : "")
          .split(",")
          .map(function (t) {
            return String(t).trim();
          })
          .filter(function (t) {
            return /((line)|(word)|(char))/i.test(t);
          })),
      (e.absolute || e.position) &&
        (e.absolute = e.absolute || /absolute/.test(s.position)),
      e
    );
  }
  function os(s) {
    var e = Mi(s) || ss(s) ? String(s) : "";
    return {
      none: !e,
      lines: /line/i.test(e),
      words: /word/i.test(e),
      chars: /char/i.test(e),
    };
  }
  function hn(s) {
    return s !== null && typeof s == "object";
  }
  function hc(s) {
    return hn(s) && /^(1|3|11)$/.test(s.nodeType);
  }
  function pc(s) {
    return typeof s == "number" && s > -1 && s % 1 == 0;
  }
  function _c(s) {
    return hn(s) && pc(s.length);
  }
  function Dr(s) {
    return ss(s)
      ? s
      : s == null
      ? []
      : _c(s)
      ? Array.prototype.slice.call(s)
      : [s];
  }
  function Mo(s) {
    var e = s;
    return (
      Mi(s) &&
        (/^(#[a-z]\w+)$/.test(s.trim())
          ? (e = document.getElementById(s.trim().slice(1)))
          : (e = document.querySelectorAll(s))),
      Dr(e).reduce(function (r, t) {
        return [].concat(st(r), st(Dr(t).filter(hc)));
      }, [])
    );
  }
  var mc = Object.entries,
    pn = "_splittype",
    $t = {},
    gc = 0;
  function Qt(s, e, r) {
    if (!hn(s)) return console.warn("[data.set] owner is not an object"), null;
    var t = s[pn] || (s[pn] = ++gc),
      i = $t[t] || ($t[t] = {});
    return (
      r === void 0
        ? !!e &&
          Object.getPrototypeOf(e) === Object.prototype &&
          ($t[t] = Po(Po({}, i), e))
        : e !== void 0 && (i[e] = r),
      r
    );
  }
  function Rr(s, e) {
    var r = hn(s) ? s[pn] : null,
      t = (r && $t[r]) || {};
    return e === void 0 ? t : t[e];
  }
  function zo(s) {
    var e = s && s[pn];
    e && (delete s[e], delete $t[e]);
  }
  function vc() {
    Object.keys($t).forEach(function (s) {
      delete $t[s];
    });
  }
  function yc() {
    mc($t).forEach(function (s) {
      var e = Oo(s, 2),
        r = e[0],
        t = e[1],
        i = t.isRoot,
        n = t.isSplit;
      (!i || !n) && (($t[r] = null), delete $t[r]);
    });
  }
  function bc(s) {
    var e =
        arguments.length > 1 && arguments[1] !== void 0 ? arguments[1] : " ",
      r = s ? String(s) : "";
    return r.trim().replace(/\s+/g, " ").split(e);
  }
  var as = "\\ud800-\\udfff",
    Do = "\\u0300-\\u036f\\ufe20-\\ufe23",
    Ro = "\\u20d0-\\u20f0",
    No = "\\ufe0e\\ufe0f",
    wc = "[".concat(as, "]"),
    ls = "[".concat(Do).concat(Ro, "]"),
    cs = "\\ud83c[\\udffb-\\udfff]",
    Sc = "(?:".concat(ls, "|").concat(cs, ")"),
    qo = "[^".concat(as, "]"),
    Io = "(?:\\ud83c[\\udde6-\\uddff]){2}",
    Fo = "[\\ud800-\\udbff][\\udc00-\\udfff]",
    Bo = "\\u200d",
    $o = "".concat(Sc, "?"),
    Wo = "[".concat(No, "]?"),
    xc = "(?:" + Bo + "(?:" + [qo, Io, Fo].join("|") + ")" + Wo + $o + ")*",
    Tc = Wo + $o + xc,
    Ec = "(?:".concat(
      ["".concat(qo).concat(ls, "?"), ls, Io, Fo, wc].join("|"),
      `
)`
    ),
    kc = RegExp(
      "".concat(cs, "(?=").concat(cs, ")|").concat(Ec).concat(Tc),
      "g"
    ),
    Cc = [Bo, as, Do, Ro, No],
    Ac = RegExp("[".concat(Cc.join(""), "]"));
  function Pc(s) {
    return s.split("");
  }
  function Yo(s) {
    return Ac.test(s);
  }
  function Oc(s) {
    return s.match(kc) || [];
  }
  function Lc(s) {
    return Yo(s) ? Oc(s) : Pc(s);
  }
  function Mc(s) {
    return s == null ? "" : String(s);
  }
  function zc(s) {
    var e = arguments.length > 1 && arguments[1] !== void 0 ? arguments[1] : "";
    return (s = Mc(s)), s && Mi(s) && !e && Yo(s) ? Lc(s) : s.split(e);
  }
  function us(s, e) {
    var r = document.createElement(s);
    return (
      e &&
        Object.keys(e).forEach(function (t) {
          var i = e[t],
            n = Mi(i) ? i.trim() : i;
          n === null ||
            n === "" ||
            (t === "children"
              ? r.append.apply(r, st(Dr(n)))
              : r.setAttribute(t, n));
        }),
      r
    );
  }
  var fs = {
    splitClass: "",
    lineClass: "line",
    wordClass: "word",
    charClass: "char",
    types: ["lines", "words", "chars"],
    absolute: !1,
    tagName: "div",
  };
  function Dc(s, e) {
    e = zr(fs, e);
    var r = os(e.types),
      t = e.tagName,
      i = s.nodeValue,
      n = document.createDocumentFragment(),
      o = [],
      a = [];
    return (
      /^\s/.test(i) && n.append(" "),
      (o = bc(i).reduce(function (l, c, u, _) {
        var p, f;
        return (
          r.chars &&
            (f = zc(c).map(function (m) {
              var h = us(t, {
                class: "".concat(e.splitClass, " ").concat(e.charClass),
                style: "display: inline-block;",
                children: m,
              });
              return Qt(h, "isChar", !0), (a = [].concat(st(a), [h])), h;
            })),
          r.words || r.lines
            ? ((p = us(t, {
                class: "".concat(e.wordClass, " ").concat(e.splitClass),
                style: "display: inline-block; ".concat(
                  r.words && e.absolute ? "position: relative;" : ""
                ),
                children: r.chars ? f : c,
              })),
              Qt(p, { isWord: !0, isWordStart: !0, isWordEnd: !0 }),
              n.appendChild(p))
            : f.forEach(function (m) {
                n.appendChild(m);
              }),
          u < _.length - 1 && n.append(" "),
          r.words ? l.concat(p) : l
        );
      }, [])),
      /\s$/.test(i) && n.append(" "),
      s.replaceWith(n),
      { words: o, chars: a }
    );
  }
  function Xo(s, e) {
    var r = s.nodeType,
      t = { words: [], chars: [] };
    if (!/(1|3|11)/.test(r)) return t;
    if (r === 3 && /\S/.test(s.nodeValue)) return Dc(s, e);
    var i = Dr(s.childNodes);
    if (i.length && (Qt(s, "isSplit", !0), !Rr(s).isRoot)) {
      (s.style.display = "inline-block"), (s.style.position = "relative");
      var n = s.nextSibling,
        o = s.previousSibling,
        a = s.textContent || "",
        l = n ? n.textContent : " ",
        c = o ? o.textContent : " ";
      Qt(s, {
        isWordEnd: /\s$/.test(a) || /^\s/.test(l),
        isWordStart: /^\s/.test(a) || /\s$/.test(c),
      });
    }
    return i.reduce(function (u, _) {
      var p = Xo(_, e),
        f = p.words,
        m = p.chars;
      return {
        words: [].concat(st(u.words), st(f)),
        chars: [].concat(st(u.chars), st(m)),
      };
    }, t);
  }
  function Rc(s, e, r, t) {
    if (!r.absolute) return { top: e ? s.offsetTop : null };
    var i = s.offsetParent,
      n = Oo(t, 2),
      o = n[0],
      a = n[1],
      l = 0,
      c = 0;
    if (i && i !== document.body) {
      var u = i.getBoundingClientRect();
      (l = u.x + o), (c = u.y + a);
    }
    var _ = s.getBoundingClientRect(),
      p = _.width,
      f = _.height,
      m = _.x,
      h = _.y,
      v = h + a - c,
      T = m + o - l;
    return { width: p, height: f, top: v, left: T };
  }
  function Vo(s) {
    Rr(s).isWord
      ? (zo(s), s.replaceWith.apply(s, st(s.childNodes)))
      : Dr(s.children).forEach(function (e) {
          return Vo(e);
        });
  }
  var Nc = function () {
    return document.createDocumentFragment();
  };
  function qc(s, e, r) {
    var t = os(e.types),
      i = e.tagName,
      n = s.getElementsByTagName("*"),
      o = [],
      a = [],
      l = null,
      c,
      u,
      _,
      p = [],
      f = s.parentElement,
      m = s.nextElementSibling,
      h = Nc(),
      v = window.getComputedStyle(s),
      T = v.textAlign,
      E = parseFloat(v.fontSize),
      P = E * 0.2;
    return (
      e.absolute &&
        ((_ = { left: s.offsetLeft, top: s.offsetTop, width: s.offsetWidth }),
        (u = s.offsetWidth),
        (c = s.offsetHeight),
        Qt(s, { cssWidth: s.style.width, cssHeight: s.style.height })),
      Dr(n).forEach(function (g) {
        var y = g.parentElement === s,
          w = Rc(g, y, e, r),
          S = w.width,
          A = w.height,
          C = w.top,
          L = w.left;
        /^br$/i.test(g.nodeName) ||
          (t.lines &&
            y &&
            ((l === null || C - l >= P) && ((l = C), o.push((a = []))),
            a.push(g)),
          e.absolute && Qt(g, { top: C, left: L, width: S, height: A }));
      }),
      f && f.removeChild(s),
      t.lines &&
        ((p = o.map(function (g) {
          var y = us(i, {
            class: "".concat(e.splitClass, " ").concat(e.lineClass),
            style: "display: block; text-align: ".concat(T, "; width: 100%;"),
          });
          Qt(y, "isLine", !0);
          var w = { height: 0, top: 1e4 };
          return (
            h.appendChild(y),
            g.forEach(function (S, A, C) {
              var L = Rr(S),
                z = L.isWordEnd,
                x = L.top,
                H = L.height,
                q = C[A + 1];
              (w.height = Math.max(w.height, H)),
                (w.top = Math.min(w.top, x)),
                y.appendChild(S),
                z && Rr(q).isWordStart && y.append(" ");
            }),
            e.absolute && Qt(y, { height: w.height, top: w.top }),
            y
          );
        })),
        t.words || Vo(h),
        s.replaceChildren(h)),
      e.absolute &&
        ((s.style.width = "".concat(s.style.width || u, "px")),
        (s.style.height = "".concat(c, "px")),
        Dr(n).forEach(function (g) {
          var y = Rr(g),
            w = y.isLine,
            S = y.top,
            A = y.left,
            C = y.width,
            L = y.height,
            z = Rr(g.parentElement),
            x = !w && z.isLine;
          (g.style.top = "".concat(x ? S - z.top : S, "px")),
            (g.style.left = w
              ? "".concat(_.left, "px")
              : "".concat(A - (x ? _.left : 0), "px")),
            (g.style.height = "".concat(L, "px")),
            (g.style.width = w ? "".concat(_.width, "px") : "".concat(C, "px")),
            (g.style.position = "absolute");
        })),
      f && (m ? f.insertBefore(s, m) : f.appendChild(s)),
      p
    );
  }
  var ai = zr(fs, {}),
    Ic = (function () {
      Co(s, null, [
        {
          key: "clearData",
          value: function () {
            vc();
          },
        },
        {
          key: "setDefaults",
          value: function (r) {
            return (ai = zr(ai, dn(r))), fs;
          },
        },
        {
          key: "revert",
          value: function (r) {
            Mo(r).forEach(function (t) {
              var i = Rr(t),
                n = i.isSplit,
                o = i.html,
                a = i.cssWidth,
                l = i.cssHeight;
              n &&
                ((t.innerHTML = o),
                (t.style.width = a || ""),
                (t.style.height = l || ""),
                zo(t));
            });
          },
        },
        {
          key: "create",
          value: function (r, t) {
            return new s(r, t);
          },
        },
        {
          key: "data",
          get: function () {
            return $t;
          },
        },
        {
          key: "defaults",
          get: function () {
            return ai;
          },
          set: function (r) {
            ai = zr(ai, dn(r));
          },
        },
      ]);
      function s(e, r) {
        fn(this, s),
          (this.isSplit = !1),
          (this.settings = zr(ai, dn(r))),
          (this.elements = Mo(e)),
          this.split();
      }
      return (
        Co(s, [
          {
            key: "split",
            value: function (r) {
              var t = this;
              this.revert(),
                this.elements.forEach(function (o) {
                  Qt(o, "html", o.innerHTML);
                }),
                (this.lines = []),
                (this.words = []),
                (this.chars = []);
              var i = [window.pageXOffset, window.pageYOffset];
              r !== void 0 && (this.settings = zr(this.settings, dn(r)));
              var n = os(this.settings.types);
              n.none ||
                (this.elements.forEach(function (o) {
                  Qt(o, "isRoot", !0);
                  var a = Xo(o, t.settings),
                    l = a.words,
                    c = a.chars;
                  (t.words = [].concat(st(t.words), st(l))),
                    (t.chars = [].concat(st(t.chars), st(c)));
                }),
                this.elements.forEach(function (o) {
                  if (n.lines || t.settings.absolute) {
                    var a = qc(o, t.settings, i);
                    t.lines = [].concat(st(t.lines), st(a));
                  }
                }),
                (this.isSplit = !0),
                window.scrollTo(i[0], i[1]),
                yc());
            },
          },
          {
            key: "revert",
            value: function () {
              this.isSplit &&
                ((this.lines = null),
                (this.words = null),
                (this.chars = null),
                (this.isSplit = !1)),
                s.revert(this.elements);
            },
          },
        ]),
        s
      );
    })();
  function lr(s) {
    if (s === void 0)
      throw new ReferenceError(
        "this hasn't been initialised - super() hasn't been called"
      );
    return s;
  }
  function Uo(s, e) {
    (s.prototype = Object.create(e.prototype)),
      (s.prototype.constructor = s),
      (s.__proto__ = e);
  }
  /*!
   * GSAP 3.12.2
   * https://greensock.com
   *
   * @license Copyright 2008-2023, GreenSock. All rights reserved.
   * Subject to the terms at https://greensock.com/standard-license or for
   * Club GreenSock members, the agreement issued with that membership.
   * @author: Jack Doyle, jack@greensock.com
   */ var wt = {
      autoSleep: 120,
      force3D: "auto",
      nullTargetWarn: 1,
      units: { lineHeight: "" },
    },
    li = { duration: 0.5, overwrite: !1, delay: 0 },
    ds,
    Je,
    Ee,
    Lt = 1e8,
    ue = 1 / Lt,
    hs = Math.PI * 2,
    Fc = hs / 4,
    Bc = 0,
    Ho = Math.sqrt,
    $c = Math.cos,
    Wc = Math.sin,
    Be = function (e) {
      return typeof e == "string";
    },
    ke = function (e) {
      return typeof e == "function";
    },
    cr = function (e) {
      return typeof e == "number";
    },
    ps = function (e) {
      return typeof e == "undefined";
    },
    Jt = function (e) {
      return typeof e == "object";
    },
    pt = function (e) {
      return e !== !1;
    },
    _s = function () {
      return typeof window != "undefined";
    },
    _n = function (e) {
      return ke(e) || Be(e);
    },
    jo =
      (typeof ArrayBuffer == "function" && ArrayBuffer.isView) ||
      function () {},
    Ze = Array.isArray,
    ms = /(?:-?\.?\d|\.)+/gi,
    Go = /[-+=.]*\d+[.e\-+]*\d*[e\-+]*\d*/g,
    ci = /[-+=.]*\d+[.e-]*\d*[a-z%]*/g,
    gs = /[-+=.]*\d+\.?\d*(?:e-|e\+)?\d*/gi,
    Ko = /[+-]=-?[.\d]+/,
    Qo = /[^,'"\[\]\s]+/gi,
    Yc = /^[+\-=e\s\d]*\d+[.\d]*([a-z]*|%)\s*$/i,
    ye,
    Mt,
    vs,
    ys,
    St = {},
    mn = {},
    Jo,
    Zo = function (e) {
      return (mn = qr(e, St)) && vt;
    },
    bs = function (e, r) {
      return console.warn(
        "Invalid property",
        e,
        "set to",
        r,
        "Missing plugin? gsap.registerPlugin()"
      );
    },
    gn = function (e, r) {
      return !r && console.warn(e);
    },
    ea = function (e, r) {
      return (e && (St[e] = r) && mn && (mn[e] = r)) || St;
    },
    zi = function () {
      return 0;
    },
    Xc = { suppressEvents: !0, isStart: !0, kill: !1 },
    vn = { suppressEvents: !0, kill: !1 },
    Vc = { suppressEvents: !0 },
    ws = {},
    vr = [],
    Ss = {},
    ta,
    xt = {},
    xs = {},
    ra = 30,
    yn = [],
    Ts = "",
    Es = function (e) {
      var r = e[0],
        t,
        i;
      if ((Jt(r) || ke(r) || (e = [e]), !(t = (r._gsap || {}).harness))) {
        for (i = yn.length; i-- && !yn[i].targetTest(r); );
        t = yn[i];
      }
      for (i = e.length; i--; )
        (e[i] && (e[i]._gsap || (e[i]._gsap = new La(e[i], t)))) ||
          e.splice(i, 1);
      return e;
    },
    Nr = function (e) {
      return e._gsap || Es(Rt(e))[0]._gsap;
    },
    ia = function (e, r, t) {
      return (t = e[r]) && ke(t)
        ? e[r]()
        : (ps(t) && e.getAttribute && e.getAttribute(r)) || t;
    },
    _t = function (e, r) {
      return (e = e.split(",")).forEach(r) || e;
    },
    Pe = function (e) {
      return Math.round(e * 1e5) / 1e5 || 0;
    },
    Ue = function (e) {
      return Math.round(e * 1e7) / 1e7 || 0;
    },
    ui = function (e, r) {
      var t = r.charAt(0),
        i = parseFloat(r.substr(2));
      return (
        (e = parseFloat(e)),
        t === "+" ? e + i : t === "-" ? e - i : t === "*" ? e * i : e / i
      );
    },
    Uc = function (e, r) {
      for (var t = r.length, i = 0; e.indexOf(r[i]) < 0 && ++i < t; );
      return i < t;
    },
    bn = function () {
      var e = vr.length,
        r = vr.slice(0),
        t,
        i;
      for (Ss = {}, vr.length = 0, t = 0; t < e; t++)
        (i = r[t]),
          i && i._lazy && (i.render(i._lazy[0], i._lazy[1], !0)._lazy = 0);
    },
    na = function (e, r, t, i) {
      vr.length && !Je && bn(),
        e.render(r, t, i || (Je && r < 0 && (e._initted || e._startAt))),
        vr.length && !Je && bn();
    },
    sa = function (e) {
      var r = parseFloat(e);
      return (r || r === 0) && (e + "").match(Qo).length < 2
        ? r
        : Be(e)
        ? e.trim()
        : e;
    },
    oa = function (e) {
      return e;
    },
    zt = function (e, r) {
      for (var t in r) t in e || (e[t] = r[t]);
      return e;
    },
    Hc = function (e) {
      return function (r, t) {
        for (var i in t)
          i in r || (i === "duration" && e) || i === "ease" || (r[i] = t[i]);
      };
    },
    qr = function (e, r) {
      for (var t in r) e[t] = r[t];
      return e;
    },
    aa = function s(e, r) {
      for (var t in r)
        t !== "__proto__" &&
          t !== "constructor" &&
          t !== "prototype" &&
          (e[t] = Jt(r[t]) ? s(e[t] || (e[t] = {}), r[t]) : r[t]);
      return e;
    },
    wn = function (e, r) {
      var t = {},
        i;
      for (i in e) i in r || (t[i] = e[i]);
      return t;
    },
    Di = function (e) {
      var r = e.parent || ye,
        t = e.keyframes ? Hc(Ze(e.keyframes)) : zt;
      if (pt(e.inherit))
        for (; r; ) t(e, r.vars.defaults), (r = r.parent || r._dp);
      return e;
    },
    jc = function (e, r) {
      for (var t = e.length, i = t === r.length; i && t-- && e[t] === r[t]; );
      return t < 0;
    },
    la = function (e, r, t, i, n) {
      t === void 0 && (t = "_first"), i === void 0 && (i = "_last");
      var o = e[i],
        a;
      if (n) for (a = r[n]; o && o[n] > a; ) o = o._prev;
      return (
        o
          ? ((r._next = o._next), (o._next = r))
          : ((r._next = e[t]), (e[t] = r)),
        r._next ? (r._next._prev = r) : (e[i] = r),
        (r._prev = o),
        (r.parent = r._dp = e),
        r
      );
    },
    Sn = function (e, r, t, i) {
      t === void 0 && (t = "_first"), i === void 0 && (i = "_last");
      var n = r._prev,
        o = r._next;
      n ? (n._next = o) : e[t] === r && (e[t] = o),
        o ? (o._prev = n) : e[i] === r && (e[i] = n),
        (r._next = r._prev = r.parent = null);
    },
    yr = function (e, r) {
      e.parent &&
        (!r || e.parent.autoRemoveChildren) &&
        e.parent.remove &&
        e.parent.remove(e),
        (e._act = 0);
    },
    Ir = function (e, r) {
      if (e && (!r || r._end > e._dur || r._start < 0))
        for (var t = e; t; ) (t._dirty = 1), (t = t.parent);
      return e;
    },
    Gc = function (e) {
      for (var r = e.parent; r && r.parent; )
        (r._dirty = 1), r.totalDuration(), (r = r.parent);
      return e;
    },
    ks = function (e, r, t, i) {
      return (
        e._startAt &&
        (Je
          ? e._startAt.revert(vn)
          : (e.vars.immediateRender && !e.vars.autoRevert) ||
            e._startAt.render(r, !0, i))
      );
    },
    Kc = function s(e) {
      return !e || (e._ts && s(e.parent));
    },
    ca = function (e) {
      return e._repeat ? fi(e._tTime, (e = e.duration() + e._rDelay)) * e : 0;
    },
    fi = function (e, r) {
      var t = Math.floor((e /= r));
      return e && t === e ? t - 1 : t;
    },
    xn = function (e, r) {
      return (
        (e - r._start) * r._ts +
        (r._ts >= 0 ? 0 : r._dirty ? r.totalDuration() : r._tDur)
      );
    },
    Tn = function (e) {
      return (e._end = Ue(
        e._start + (e._tDur / Math.abs(e._ts || e._rts || ue) || 0)
      ));
    },
    En = function (e, r) {
      var t = e._dp;
      return (
        t &&
          t.smoothChildTiming &&
          e._ts &&
          ((e._start = Ue(
            t._time -
              (e._ts > 0
                ? r / e._ts
                : ((e._dirty ? e.totalDuration() : e._tDur) - r) / -e._ts)
          )),
          Tn(e),
          t._dirty || Ir(t, e)),
        e
      );
    },
    ua = function (e, r) {
      var t;
      if (
        ((r._time ||
          (!r._dur && r._initted) ||
          (r._start < e._time && (r._dur || !r.add))) &&
          ((t = xn(e.rawTime(), r)),
          (!r._dur || Ni(0, r.totalDuration(), t) - r._tTime > ue) &&
            r.render(t, !0)),
        Ir(e, r)._dp && e._initted && e._time >= e._dur && e._ts)
      ) {
        if (e._dur < e.duration())
          for (t = e; t._dp; )
            t.rawTime() >= 0 && t.totalTime(t._tTime), (t = t._dp);
        e._zTime = -ue;
      }
    },
    Zt = function (e, r, t, i) {
      return (
        r.parent && yr(r),
        (r._start = Ue(
          (cr(t) ? t : t || e !== ye ? Dt(e, t, r) : e._time) + r._delay
        )),
        (r._end = Ue(
          r._start + (r.totalDuration() / Math.abs(r.timeScale()) || 0)
        )),
        la(e, r, "_first", "_last", e._sort ? "_start" : 0),
        Cs(r) || (e._recent = r),
        i || ua(e, r),
        e._ts < 0 && En(e, e._tTime),
        e
      );
    },
    fa = function (e, r) {
      return (
        (St.ScrollTrigger || bs("scrollTrigger", r)) &&
        St.ScrollTrigger.create(r, e)
      );
    },
    da = function (e, r, t, i, n) {
      if ((Ns(e, r, n), !e._initted)) return 1;
      if (
        !t &&
        e._pt &&
        !Je &&
        ((e._dur && e.vars.lazy !== !1) || (!e._dur && e.vars.lazy)) &&
        ta !== Tt.frame
      )
        return vr.push(e), (e._lazy = [n, i]), 1;
    },
    Qc = function s(e) {
      var r = e.parent;
      return r && r._ts && r._initted && !r._lock && (r.rawTime() < 0 || s(r));
    },
    Cs = function (e) {
      var r = e.data;
      return r === "isFromStart" || r === "isStart";
    },
    Jc = function (e, r, t, i) {
      var n = e.ratio,
        o =
          r < 0 ||
          (!r &&
            ((!e._start && Qc(e) && !(!e._initted && Cs(e))) ||
              ((e._ts < 0 || e._dp._ts < 0) && !Cs(e))))
            ? 0
            : 1,
        a = e._rDelay,
        l = 0,
        c,
        u,
        _;
      if (
        (a &&
          e._repeat &&
          ((l = Ni(0, e._tDur, r)),
          (u = fi(l, a)),
          e._yoyo && u & 1 && (o = 1 - o),
          u !== fi(e._tTime, a) &&
            ((n = 1 - o),
            e.vars.repeatRefresh && e._initted && e.invalidate())),
        o !== n || Je || i || e._zTime === ue || (!r && e._zTime))
      ) {
        if (!e._initted && da(e, r, i, t, l)) return;
        for (
          _ = e._zTime,
            e._zTime = r || (t ? ue : 0),
            t || (t = r && !_),
            e.ratio = o,
            e._from && (o = 1 - o),
            e._time = 0,
            e._tTime = l,
            c = e._pt;
          c;

        )
          c.r(o, c.d), (c = c._next);
        r < 0 && ks(e, r, t, !0),
          e._onUpdate && !t && Nt(e, "onUpdate"),
          l && e._repeat && !t && e.parent && Nt(e, "onRepeat"),
          (r >= e._tDur || r < 0) &&
            e.ratio === o &&
            (o && yr(e, 1),
            !t &&
              !Je &&
              (Nt(e, o ? "onComplete" : "onReverseComplete", !0),
              e._prom && e._prom()));
      } else e._zTime || (e._zTime = r);
    },
    Zc = function (e, r, t) {
      var i;
      if (t > r)
        for (i = e._first; i && i._start <= t; ) {
          if (i.data === "isPause" && i._start > r) return i;
          i = i._next;
        }
      else
        for (i = e._last; i && i._start >= t; ) {
          if (i.data === "isPause" && i._start < r) return i;
          i = i._prev;
        }
    },
    di = function (e, r, t, i) {
      var n = e._repeat,
        o = Ue(r) || 0,
        a = e._tTime / e._tDur;
      return (
        a && !i && (e._time *= o / e._dur),
        (e._dur = o),
        (e._tDur = n ? (n < 0 ? 1e10 : Ue(o * (n + 1) + e._rDelay * n)) : o),
        a > 0 && !i && En(e, (e._tTime = e._tDur * a)),
        e.parent && Tn(e),
        t || Ir(e.parent, e),
        e
      );
    },
    ha = function (e) {
      return e instanceof mt ? Ir(e) : di(e, e._dur);
    },
    eu = { _start: 0, endTime: zi, totalDuration: zi },
    Dt = function s(e, r, t) {
      var i = e.labels,
        n = e._recent || eu,
        o = e.duration() >= Lt ? n.endTime(!1) : e._dur,
        a,
        l,
        c;
      return Be(r) && (isNaN(r) || r in i)
        ? ((l = r.charAt(0)),
          (c = r.substr(-1) === "%"),
          (a = r.indexOf("=")),
          l === "<" || l === ">"
            ? (a >= 0 && (r = r.replace(/=/, "")),
              (l === "<" ? n._start : n.endTime(n._repeat >= 0)) +
                (parseFloat(r.substr(1)) || 0) *
                  (c ? (a < 0 ? n : t).totalDuration() / 100 : 1))
            : a < 0
            ? (r in i || (i[r] = o), i[r])
            : ((l = parseFloat(r.charAt(a - 1) + r.substr(a + 1))),
              c && t && (l = (l / 100) * (Ze(t) ? t[0] : t).totalDuration()),
              a > 1 ? s(e, r.substr(0, a - 1), t) + l : o + l))
        : r == null
        ? o
        : +r;
    },
    Ri = function (e, r, t) {
      var i = cr(r[1]),
        n = (i ? 2 : 1) + (e < 2 ? 0 : 1),
        o = r[n],
        a,
        l;
      if ((i && (o.duration = r[1]), (o.parent = t), e)) {
        for (a = o, l = t; l && !("immediateRender" in a); )
          (a = l.vars.defaults || {}), (l = pt(l.vars.inherit) && l.parent);
        (o.immediateRender = pt(a.immediateRender)),
          e < 2 ? (o.runBackwards = 1) : (o.startAt = r[n - 1]);
      }
      return new Me(r[0], o, r[n + 1]);
    },
    br = function (e, r) {
      return e || e === 0 ? r(e) : r;
    },
    Ni = function (e, r, t) {
      return t < e ? e : t > r ? r : t;
    },
    et = function (e, r) {
      return !Be(e) || !(r = Yc.exec(e)) ? "" : r[1];
    },
    tu = function (e, r, t) {
      return br(t, function (i) {
        return Ni(e, r, i);
      });
    },
    As = [].slice,
    pa = function (e, r) {
      return (
        e &&
        Jt(e) &&
        "length" in e &&
        ((!r && !e.length) || (e.length - 1 in e && Jt(e[0]))) &&
        !e.nodeType &&
        e !== Mt
      );
    },
    ru = function (e, r, t) {
      return (
        t === void 0 && (t = []),
        e.forEach(function (i) {
          var n;
          return (Be(i) && !r) || pa(i, 1)
            ? (n = t).push.apply(n, Rt(i))
            : t.push(i);
        }) || t
      );
    },
    Rt = function (e, r, t) {
      return Ee && !r && Ee.selector
        ? Ee.selector(e)
        : Be(e) && !t && (vs || !pi())
        ? As.call((r || ys).querySelectorAll(e), 0)
        : Ze(e)
        ? ru(e, t)
        : pa(e)
        ? As.call(e, 0)
        : e
        ? [e]
        : [];
    },
    Ps = function (e) {
      return (
        (e = Rt(e)[0] || gn("Invalid scope") || {}),
        function (r) {
          var t = e.current || e.nativeElement || e;
          return Rt(
            r,
            t.querySelectorAll
              ? t
              : t === e
              ? gn("Invalid scope") || ys.createElement("div")
              : e
          );
        }
      );
    },
    _a = function (e) {
      return e.sort(function () {
        return 0.5 - Math.random();
      });
    },
    ma = function (e) {
      if (ke(e)) return e;
      var r = Jt(e) ? e : { each: e },
        t = Fr(r.ease),
        i = r.from || 0,
        n = parseFloat(r.base) || 0,
        o = {},
        a = i > 0 && i < 1,
        l = isNaN(i) || a,
        c = r.axis,
        u = i,
        _ = i;
      return (
        Be(i)
          ? (u = _ = { center: 0.5, edges: 0.5, end: 1 }[i] || 0)
          : !a && l && ((u = i[0]), (_ = i[1])),
        function (p, f, m) {
          var h = (m || r).length,
            v = o[h],
            T,
            E,
            P,
            g,
            y,
            w,
            S,
            A,
            C;
          if (!v) {
            if (((C = r.grid === "auto" ? 0 : (r.grid || [1, Lt])[1]), !C)) {
              for (
                S = -Lt;
                S < (S = m[C++].getBoundingClientRect().left) && C < h;

              );
              C--;
            }
            for (
              v = o[h] = [],
                T = l ? Math.min(C, h) * u - 0.5 : i % C,
                E = C === Lt ? 0 : l ? (h * _) / C - 0.5 : (i / C) | 0,
                S = 0,
                A = Lt,
                w = 0;
              w < h;
              w++
            )
              (P = (w % C) - T),
                (g = E - ((w / C) | 0)),
                (v[w] = y =
                  c ? Math.abs(c === "y" ? g : P) : Ho(P * P + g * g)),
                y > S && (S = y),
                y < A && (A = y);
            i === "random" && _a(v),
              (v.max = S - A),
              (v.min = A),
              (v.v = h =
                (parseFloat(r.amount) ||
                  parseFloat(r.each) *
                    (C > h
                      ? h - 1
                      : c
                      ? c === "y"
                        ? h / C
                        : C
                      : Math.max(C, h / C)) ||
                  0) * (i === "edges" ? -1 : 1)),
              (v.b = h < 0 ? n - h : n),
              (v.u = et(r.amount || r.each) || 0),
              (t = t && h < 0 ? Aa(t) : t);
          }
          return (
            (h = (v[p] - v.min) / v.max || 0),
            Ue(v.b + (t ? t(h) : h) * v.v) + v.u
          );
        }
      );
    },
    Os = function (e) {
      var r = Math.pow(10, ((e + "").split(".")[1] || "").length);
      return function (t) {
        var i = Ue(Math.round(parseFloat(t) / e) * e * r);
        return (i - (i % 1)) / r + (cr(t) ? 0 : et(t));
      };
    },
    ga = function (e, r) {
      var t = Ze(e),
        i,
        n;
      return (
        !t &&
          Jt(e) &&
          ((i = t = e.radius || Lt),
          e.values
            ? ((e = Rt(e.values)), (n = !cr(e[0])) && (i *= i))
            : (e = Os(e.increment))),
        br(
          r,
          t
            ? ke(e)
              ? function (o) {
                  return (n = e(o)), Math.abs(n - o) <= i ? n : o;
                }
              : function (o) {
                  for (
                    var a = parseFloat(n ? o.x : o),
                      l = parseFloat(n ? o.y : 0),
                      c = Lt,
                      u = 0,
                      _ = e.length,
                      p,
                      f;
                    _--;

                  )
                    n
                      ? ((p = e[_].x - a),
                        (f = e[_].y - l),
                        (p = p * p + f * f))
                      : (p = Math.abs(e[_] - a)),
                      p < c && ((c = p), (u = _));
                  return (
                    (u = !i || c <= i ? e[u] : o),
                    n || u === o || cr(o) ? u : u + et(o)
                  );
                }
            : Os(e)
        )
      );
    },
    va = function (e, r, t, i) {
      return br(Ze(e) ? !r : t === !0 ? !!(t = 0) : !i, function () {
        return Ze(e)
          ? e[~~(Math.random() * e.length)]
          : (t = t || 1e-5) &&
              (i = t < 1 ? Math.pow(10, (t + "").length - 2) : 1) &&
              Math.floor(
                Math.round(
                  (e - t / 2 + Math.random() * (r - e + t * 0.99)) / t
                ) *
                  t *
                  i
              ) / i;
      });
    },
    iu = function () {
      for (var e = arguments.length, r = new Array(e), t = 0; t < e; t++)
        r[t] = arguments[t];
      return function (i) {
        return r.reduce(function (n, o) {
          return o(n);
        }, i);
      };
    },
    nu = function (e, r) {
      return function (t) {
        return e(parseFloat(t)) + (r || et(t));
      };
    },
    su = function (e, r, t) {
      return ba(e, r, 0, 1, t);
    },
    ya = function (e, r, t) {
      return br(t, function (i) {
        return e[~~r(i)];
      });
    },
    ou = function s(e, r, t) {
      var i = r - e;
      return Ze(e)
        ? ya(e, s(0, e.length), r)
        : br(t, function (n) {
            return ((i + ((n - e) % i)) % i) + e;
          });
    },
    au = function s(e, r, t) {
      var i = r - e,
        n = i * 2;
      return Ze(e)
        ? ya(e, s(0, e.length - 1), r)
        : br(t, function (o) {
            return (o = (n + ((o - e) % n)) % n || 0), e + (o > i ? n - o : o);
          });
    },
    qi = function (e) {
      for (var r = 0, t = "", i, n, o, a; ~(i = e.indexOf("random(", r)); )
        (o = e.indexOf(")", i)),
          (a = e.charAt(i + 7) === "["),
          (n = e.substr(i + 7, o - i - 7).match(a ? Qo : ms)),
          (t +=
            e.substr(r, i - r) +
            va(a ? n : +n[0], a ? 0 : +n[1], +n[2] || 1e-5)),
          (r = o + 1);
      return t + e.substr(r, e.length - r);
    },
    ba = function (e, r, t, i, n) {
      var o = r - e,
        a = i - t;
      return br(n, function (l) {
        return t + (((l - e) / o) * a || 0);
      });
    },
    lu = function s(e, r, t, i) {
      var n = isNaN(e + r)
        ? 0
        : function (f) {
            return (1 - f) * e + f * r;
          };
      if (!n) {
        var o = Be(e),
          a = {},
          l,
          c,
          u,
          _,
          p;
        if ((t === !0 && (i = 1) && (t = null), o))
          (e = { p: e }), (r = { p: r });
        else if (Ze(e) && !Ze(r)) {
          for (u = [], _ = e.length, p = _ - 2, c = 1; c < _; c++)
            u.push(s(e[c - 1], e[c]));
          _--,
            (n = function (m) {
              m *= _;
              var h = Math.min(p, ~~m);
              return u[h](m - h);
            }),
            (t = r);
        } else i || (e = qr(Ze(e) ? [] : {}, e));
        if (!u) {
          for (l in r) Ds.call(a, e, l, "get", r[l]);
          n = function (m) {
            return Fs(m, a) || (o ? e.p : e);
          };
        }
      }
      return br(t, n);
    },
    wa = function (e, r, t) {
      var i = e.labels,
        n = Lt,
        o,
        a,
        l;
      for (o in i)
        (a = i[o] - r),
          a < 0 == !!t && a && n > (a = Math.abs(a)) && ((l = o), (n = a));
      return l;
    },
    Nt = function (e, r, t) {
      var i = e.vars,
        n = i[r],
        o = Ee,
        a = e._ctx,
        l,
        c,
        u;
      if (!!n)
        return (
          (l = i[r + "Params"]),
          (c = i.callbackScope || e),
          t && vr.length && bn(),
          a && (Ee = a),
          (u = l ? n.apply(c, l) : n.call(c)),
          (Ee = o),
          u
        );
    },
    Ii = function (e) {
      return (
        yr(e),
        e.scrollTrigger && e.scrollTrigger.kill(!!Je),
        e.progress() < 1 && Nt(e, "onInterrupt"),
        e
      );
    },
    hi,
    Sa = [],
    xa = function (e) {
      if (_s() && e) {
        e = (!e.name && e.default) || e;
        var r = e.name,
          t = ke(e),
          i =
            r && !t && e.init
              ? function () {
                  this._props = [];
                }
              : e,
          n = {
            init: zi,
            render: Fs,
            add: Ds,
            kill: Tu,
            modifier: xu,
            rawVars: 0,
          },
          o = {
            targetTest: 0,
            get: 0,
            getSetter: Is,
            aliases: {},
            register: 0,
          };
        if ((pi(), e !== i)) {
          if (xt[r]) return;
          zt(i, zt(wn(e, n), o)),
            qr(i.prototype, qr(n, wn(e, o))),
            (xt[(i.prop = r)] = i),
            e.targetTest && (yn.push(i), (ws[r] = 1)),
            (r =
              (r === "css" ? "CSS" : r.charAt(0).toUpperCase() + r.substr(1)) +
              "Plugin");
        }
        ea(r, i), e.register && e.register(vt, i, gt);
      } else e && Sa.push(e);
    },
    fe = 255,
    Fi = {
      aqua: [0, fe, fe],
      lime: [0, fe, 0],
      silver: [192, 192, 192],
      black: [0, 0, 0],
      maroon: [128, 0, 0],
      teal: [0, 128, 128],
      blue: [0, 0, fe],
      navy: [0, 0, 128],
      white: [fe, fe, fe],
      olive: [128, 128, 0],
      yellow: [fe, fe, 0],
      orange: [fe, 165, 0],
      gray: [128, 128, 128],
      purple: [128, 0, 128],
      green: [0, 128, 0],
      red: [fe, 0, 0],
      pink: [fe, 192, 203],
      cyan: [0, fe, fe],
      transparent: [fe, fe, fe, 0],
    },
    Ls = function (e, r, t) {
      return (
        (e += e < 0 ? 1 : e > 1 ? -1 : 0),
        ((e * 6 < 1
          ? r + (t - r) * e * 6
          : e < 0.5
          ? t
          : e * 3 < 2
          ? r + (t - r) * (2 / 3 - e) * 6
          : r) *
          fe +
          0.5) |
          0
      );
    },
    Ta = function (e, r, t) {
      var i = e ? (cr(e) ? [e >> 16, (e >> 8) & fe, e & fe] : 0) : Fi.black,
        n,
        o,
        a,
        l,
        c,
        u,
        _,
        p,
        f,
        m;
      if (!i) {
        if ((e.substr(-1) === "," && (e = e.substr(0, e.length - 1)), Fi[e]))
          i = Fi[e];
        else if (e.charAt(0) === "#") {
          if (
            (e.length < 6 &&
              ((n = e.charAt(1)),
              (o = e.charAt(2)),
              (a = e.charAt(3)),
              (e =
                "#" +
                n +
                n +
                o +
                o +
                a +
                a +
                (e.length === 5 ? e.charAt(4) + e.charAt(4) : ""))),
            e.length === 9)
          )
            return (
              (i = parseInt(e.substr(1, 6), 16)),
              [i >> 16, (i >> 8) & fe, i & fe, parseInt(e.substr(7), 16) / 255]
            );
          (e = parseInt(e.substr(1), 16)),
            (i = [e >> 16, (e >> 8) & fe, e & fe]);
        } else if (e.substr(0, 3) === "hsl") {
          if (((i = m = e.match(ms)), !r))
            (l = (+i[0] % 360) / 360),
              (c = +i[1] / 100),
              (u = +i[2] / 100),
              (o = u <= 0.5 ? u * (c + 1) : u + c - u * c),
              (n = u * 2 - o),
              i.length > 3 && (i[3] *= 1),
              (i[0] = Ls(l + 1 / 3, n, o)),
              (i[1] = Ls(l, n, o)),
              (i[2] = Ls(l - 1 / 3, n, o));
          else if (~e.indexOf("="))
            return (i = e.match(Go)), t && i.length < 4 && (i[3] = 1), i;
        } else i = e.match(ms) || Fi.transparent;
        i = i.map(Number);
      }
      return (
        r &&
          !m &&
          ((n = i[0] / fe),
          (o = i[1] / fe),
          (a = i[2] / fe),
          (_ = Math.max(n, o, a)),
          (p = Math.min(n, o, a)),
          (u = (_ + p) / 2),
          _ === p
            ? (l = c = 0)
            : ((f = _ - p),
              (c = u > 0.5 ? f / (2 - _ - p) : f / (_ + p)),
              (l =
                _ === n
                  ? (o - a) / f + (o < a ? 6 : 0)
                  : _ === o
                  ? (a - n) / f + 2
                  : (n - o) / f + 4),
              (l *= 60)),
          (i[0] = ~~(l + 0.5)),
          (i[1] = ~~(c * 100 + 0.5)),
          (i[2] = ~~(u * 100 + 0.5))),
        t && i.length < 4 && (i[3] = 1),
        i
      );
    },
    Ea = function (e) {
      var r = [],
        t = [],
        i = -1;
      return (
        e.split(wr).forEach(function (n) {
          var o = n.match(ci) || [];
          r.push.apply(r, o), t.push((i += o.length + 1));
        }),
        (r.c = t),
        r
      );
    },
    ka = function (e, r, t) {
      var i = "",
        n = (e + i).match(wr),
        o = r ? "hsla(" : "rgba(",
        a = 0,
        l,
        c,
        u,
        _;
      if (!n) return e;
      if (
        ((n = n.map(function (p) {
          return (
            (p = Ta(p, r, 1)) &&
            o +
              (r
                ? p[0] + "," + p[1] + "%," + p[2] + "%," + p[3]
                : p.join(",")) +
              ")"
          );
        })),
        t && ((u = Ea(e)), (l = t.c), l.join(i) !== u.c.join(i)))
      )
        for (c = e.replace(wr, "1").split(ci), _ = c.length - 1; a < _; a++)
          i +=
            c[a] +
            (~l.indexOf(a)
              ? n.shift() || o + "0,0,0,0)"
              : (u.length ? u : n.length ? n : t).shift());
      if (!c)
        for (c = e.split(wr), _ = c.length - 1; a < _; a++) i += c[a] + n[a];
      return i + c[_];
    },
    wr = (function () {
      var s =
          "(?:\\b(?:(?:rgb|rgba|hsl|hsla)\\(.+?\\))|\\B#(?:[0-9a-f]{3,4}){1,2}\\b",
        e;
      for (e in Fi) s += "|" + e + "\\b";
      return new RegExp(s + ")", "gi");
    })(),
    cu = /hsl[a]?\(/,
    Ca = function (e) {
      var r = e.join(" "),
        t;
      if (((wr.lastIndex = 0), wr.test(r)))
        return (
          (t = cu.test(r)),
          (e[1] = ka(e[1], t)),
          (e[0] = ka(e[0], t, Ea(e[1]))),
          !0
        );
    },
    Bi,
    Tt = (function () {
      var s = Date.now,
        e = 500,
        r = 33,
        t = s(),
        i = t,
        n = 1e3 / 240,
        o = n,
        a = [],
        l,
        c,
        u,
        _,
        p,
        f,
        m = function h(v) {
          var T = s() - i,
            E = v === !0,
            P,
            g,
            y,
            w;
          if (
            (T > e && (t += T - r),
            (i += T),
            (y = i - t),
            (P = y - o),
            (P > 0 || E) &&
              ((w = ++_.frame),
              (p = y - _.time * 1e3),
              (_.time = y = y / 1e3),
              (o += P + (P >= n ? 4 : n - P)),
              (g = 1)),
            E || (l = c(h)),
            g)
          )
            for (f = 0; f < a.length; f++) a[f](y, p, w, v);
        };
      return (
        (_ = {
          time: 0,
          frame: 0,
          tick: function () {
            m(!0);
          },
          deltaRatio: function (v) {
            return p / (1e3 / (v || 60));
          },
          wake: function () {
            Jo &&
              (!vs &&
                _s() &&
                ((Mt = vs = window),
                (ys = Mt.document || {}),
                (St.gsap = vt),
                (Mt.gsapVersions || (Mt.gsapVersions = [])).push(vt.version),
                Zo(mn || Mt.GreenSockGlobals || (!Mt.gsap && Mt) || {}),
                (u = Mt.requestAnimationFrame),
                Sa.forEach(xa)),
              l && _.sleep(),
              (c =
                u ||
                function (v) {
                  return setTimeout(v, (o - _.time * 1e3 + 1) | 0);
                }),
              (Bi = 1),
              m(2));
          },
          sleep: function () {
            (u ? Mt.cancelAnimationFrame : clearTimeout)(l), (Bi = 0), (c = zi);
          },
          lagSmoothing: function (v, T) {
            (e = v || 1 / 0), (r = Math.min(T || 33, e));
          },
          fps: function (v) {
            (n = 1e3 / (v || 240)), (o = _.time * 1e3 + n);
          },
          add: function (v, T, E) {
            var P = T
              ? function (g, y, w, S) {
                  v(g, y, w, S), _.remove(P);
                }
              : v;
            return _.remove(v), a[E ? "unshift" : "push"](P), pi(), P;
          },
          remove: function (v, T) {
            ~(T = a.indexOf(v)) && a.splice(T, 1) && f >= T && f--;
          },
          _listeners: a,
        }),
        _
      );
    })(),
    pi = function () {
      return !Bi && Tt.wake();
    },
    te = {},
    uu = /^[\d.\-M][\d.\-,\s]/,
    fu = /["']/g,
    du = function (e) {
      for (
        var r = {},
          t = e.substr(1, e.length - 3).split(":"),
          i = t[0],
          n = 1,
          o = t.length,
          a,
          l,
          c;
        n < o;
        n++
      )
        (l = t[n]),
          (a = n !== o - 1 ? l.lastIndexOf(",") : l.length),
          (c = l.substr(0, a)),
          (r[i] = isNaN(c) ? c.replace(fu, "").trim() : +c),
          (i = l.substr(a + 1).trim());
      return r;
    },
    hu = function (e) {
      var r = e.indexOf("(") + 1,
        t = e.indexOf(")"),
        i = e.indexOf("(", r);
      return e.substring(r, ~i && i < t ? e.indexOf(")", t + 1) : t);
    },
    pu = function (e) {
      var r = (e + "").split("("),
        t = te[r[0]];
      return t && r.length > 1 && t.config
        ? t.config.apply(
            null,
            ~e.indexOf("{") ? [du(r[1])] : hu(e).split(",").map(sa)
          )
        : te._CE && uu.test(e)
        ? te._CE("", e)
        : t;
    },
    Aa = function (e) {
      return function (r) {
        return 1 - e(1 - r);
      };
    },
    Pa = function s(e, r) {
      for (var t = e._first, i; t; )
        t instanceof mt
          ? s(t, r)
          : t.vars.yoyoEase &&
            (!t._yoyo || !t._repeat) &&
            t._yoyo !== r &&
            (t.timeline
              ? s(t.timeline, r)
              : ((i = t._ease),
                (t._ease = t._yEase),
                (t._yEase = i),
                (t._yoyo = r))),
          (t = t._next);
    },
    Fr = function (e, r) {
      return (e && (ke(e) ? e : te[e] || pu(e))) || r;
    },
    Br = function (e, r, t, i) {
      t === void 0 &&
        (t = function (l) {
          return 1 - r(1 - l);
        }),
        i === void 0 &&
          (i = function (l) {
            return l < 0.5 ? r(l * 2) / 2 : 1 - r((1 - l) * 2) / 2;
          });
      var n = { easeIn: r, easeOut: t, easeInOut: i },
        o;
      return (
        _t(e, function (a) {
          (te[a] = St[a] = n), (te[(o = a.toLowerCase())] = t);
          for (var l in n)
            te[
              o + (l === "easeIn" ? ".in" : l === "easeOut" ? ".out" : ".inOut")
            ] = te[a + "." + l] = n[l];
        }),
        n
      );
    },
    Oa = function (e) {
      return function (r) {
        return r < 0.5 ? (1 - e(1 - r * 2)) / 2 : 0.5 + e((r - 0.5) * 2) / 2;
      };
    },
    Ms = function s(e, r, t) {
      var i = r >= 1 ? r : 1,
        n = (t || (e ? 0.3 : 0.45)) / (r < 1 ? r : 1),
        o = (n / hs) * (Math.asin(1 / i) || 0),
        a = function (u) {
          return u === 1 ? 1 : i * Math.pow(2, -10 * u) * Wc((u - o) * n) + 1;
        },
        l =
          e === "out"
            ? a
            : e === "in"
            ? function (c) {
                return 1 - a(1 - c);
              }
            : Oa(a);
      return (
        (n = hs / n),
        (l.config = function (c, u) {
          return s(e, c, u);
        }),
        l
      );
    },
    zs = function s(e, r) {
      r === void 0 && (r = 1.70158);
      var t = function (o) {
          return o ? --o * o * ((r + 1) * o + r) + 1 : 0;
        },
        i =
          e === "out"
            ? t
            : e === "in"
            ? function (n) {
                return 1 - t(1 - n);
              }
            : Oa(t);
      return (
        (i.config = function (n) {
          return s(e, n);
        }),
        i
      );
    };
  _t("Linear,Quad,Cubic,Quart,Quint,Strong", function (s, e) {
    var r = e < 5 ? e + 1 : e;
    Br(
      s + ",Power" + (r - 1),
      e
        ? function (t) {
            return Math.pow(t, r);
          }
        : function (t) {
            return t;
          },
      function (t) {
        return 1 - Math.pow(1 - t, r);
      },
      function (t) {
        return t < 0.5
          ? Math.pow(t * 2, r) / 2
          : 1 - Math.pow((1 - t) * 2, r) / 2;
      }
    );
  }),
    (te.Linear.easeNone = te.none = te.Linear.easeIn),
    Br("Elastic", Ms("in"), Ms("out"), Ms()),
    (function (s, e) {
      var r = 1 / e,
        t = 2 * r,
        i = 2.5 * r,
        n = function (a) {
          return a < r
            ? s * a * a
            : a < t
            ? s * Math.pow(a - 1.5 / e, 2) + 0.75
            : a < i
            ? s * (a -= 2.25 / e) * a + 0.9375
            : s * Math.pow(a - 2.625 / e, 2) + 0.984375;
        };
      Br(
        "Bounce",
        function (o) {
          return 1 - n(1 - o);
        },
        n
      );
    })(7.5625, 2.75),
    Br("Expo", function (s) {
      return s ? Math.pow(2, 10 * (s - 1)) : 0;
    }),
    Br("Circ", function (s) {
      return -(Ho(1 - s * s) - 1);
    }),
    Br("Sine", function (s) {
      return s === 1 ? 1 : -$c(s * Fc) + 1;
    }),
    Br("Back", zs("in"), zs("out"), zs()),
    (te.SteppedEase =
      te.steps =
      St.SteppedEase =
        {
          config: function (e, r) {
            e === void 0 && (e = 1);
            var t = 1 / e,
              i = e + (r ? 0 : 1),
              n = r ? 1 : 0,
              o = 1 - ue;
            return function (a) {
              return (((i * Ni(0, o, a)) | 0) + n) * t;
            };
          },
        }),
    (li.ease = te["quad.out"]),
    _t(
      "onComplete,onUpdate,onStart,onRepeat,onReverseComplete,onInterrupt",
      function (s) {
        return (Ts += s + "," + s + "Params,");
      }
    );
  var La = function (e, r) {
      (this.id = Bc++),
        (e._gsap = this),
        (this.target = e),
        (this.harness = r),
        (this.get = r ? r.get : ia),
        (this.set = r ? r.getSetter : Is);
    },
    $i = (function () {
      function s(r) {
        (this.vars = r),
          (this._delay = +r.delay || 0),
          (this._repeat = r.repeat === 1 / 0 ? -2 : r.repeat || 0) &&
            ((this._rDelay = r.repeatDelay || 0),
            (this._yoyo = !!r.yoyo || !!r.yoyoEase)),
          (this._ts = 1),
          di(this, +r.duration, 1, 1),
          (this.data = r.data),
          Ee && ((this._ctx = Ee), Ee.data.push(this)),
          Bi || Tt.wake();
      }
      var e = s.prototype;
      return (
        (e.delay = function (t) {
          return t || t === 0
            ? (this.parent &&
                this.parent.smoothChildTiming &&
                this.startTime(this._start + t - this._delay),
              (this._delay = t),
              this)
            : this._delay;
        }),
        (e.duration = function (t) {
          return arguments.length
            ? this.totalDuration(
                this._repeat > 0 ? t + (t + this._rDelay) * this._repeat : t
              )
            : this.totalDuration() && this._dur;
        }),
        (e.totalDuration = function (t) {
          return arguments.length
            ? ((this._dirty = 0),
              di(
                this,
                this._repeat < 0
                  ? t
                  : (t - this._repeat * this._rDelay) / (this._repeat + 1)
              ))
            : this._tDur;
        }),
        (e.totalTime = function (t, i) {
          if ((pi(), !arguments.length)) return this._tTime;
          var n = this._dp;
          if (n && n.smoothChildTiming && this._ts) {
            for (
              En(this, t), !n._dp || n.parent || ua(n, this);
              n && n.parent;

            )
              n.parent._time !==
                n._start +
                  (n._ts >= 0
                    ? n._tTime / n._ts
                    : (n.totalDuration() - n._tTime) / -n._ts) &&
                n.totalTime(n._tTime, !0),
                (n = n.parent);
            !this.parent &&
              this._dp.autoRemoveChildren &&
              ((this._ts > 0 && t < this._tDur) ||
                (this._ts < 0 && t > 0) ||
                (!this._tDur && !t)) &&
              Zt(this._dp, this, this._start - this._delay);
          }
          return (
            (this._tTime !== t ||
              (!this._dur && !i) ||
              (this._initted && Math.abs(this._zTime) === ue) ||
              (!t && !this._initted && (this.add || this._ptLookup))) &&
              (this._ts || (this._pTime = t), na(this, t, i)),
            this
          );
        }),
        (e.time = function (t, i) {
          return arguments.length
            ? this.totalTime(
                Math.min(this.totalDuration(), t + ca(this)) %
                  (this._dur + this._rDelay) || (t ? this._dur : 0),
                i
              )
            : this._time;
        }),
        (e.totalProgress = function (t, i) {
          return arguments.length
            ? this.totalTime(this.totalDuration() * t, i)
            : this.totalDuration()
            ? Math.min(1, this._tTime / this._tDur)
            : this.ratio;
        }),
        (e.progress = function (t, i) {
          return arguments.length
            ? this.totalTime(
                this.duration() *
                  (this._yoyo && !(this.iteration() & 1) ? 1 - t : t) +
                  ca(this),
                i
              )
            : this.duration()
            ? Math.min(1, this._time / this._dur)
            : this.ratio;
        }),
        (e.iteration = function (t, i) {
          var n = this.duration() + this._rDelay;
          return arguments.length
            ? this.totalTime(this._time + (t - 1) * n, i)
            : this._repeat
            ? fi(this._tTime, n) + 1
            : 1;
        }),
        (e.timeScale = function (t) {
          if (!arguments.length) return this._rts === -ue ? 0 : this._rts;
          if (this._rts === t) return this;
          var i =
            this.parent && this._ts ? xn(this.parent._time, this) : this._tTime;
          return (
            (this._rts = +t || 0),
            (this._ts = this._ps || t === -ue ? 0 : this._rts),
            this.totalTime(Ni(-Math.abs(this._delay), this._tDur, i), !0),
            Tn(this),
            Gc(this)
          );
        }),
        (e.paused = function (t) {
          return arguments.length
            ? (this._ps !== t &&
                ((this._ps = t),
                t
                  ? ((this._pTime =
                      this._tTime || Math.max(-this._delay, this.rawTime())),
                    (this._ts = this._act = 0))
                  : (pi(),
                    (this._ts = this._rts),
                    this.totalTime(
                      this.parent && !this.parent.smoothChildTiming
                        ? this.rawTime()
                        : this._tTime || this._pTime,
                      this.progress() === 1 &&
                        Math.abs(this._zTime) !== ue &&
                        (this._tTime -= ue)
                    ))),
              this)
            : this._ps;
        }),
        (e.startTime = function (t) {
          if (arguments.length) {
            this._start = t;
            var i = this.parent || this._dp;
            return (
              i && (i._sort || !this.parent) && Zt(i, this, t - this._delay),
              this
            );
          }
          return this._start;
        }),
        (e.endTime = function (t) {
          return (
            this._start +
            (pt(t) ? this.totalDuration() : this.duration()) /
              Math.abs(this._ts || 1)
          );
        }),
        (e.rawTime = function (t) {
          var i = this.parent || this._dp;
          return i
            ? t &&
              (!this._ts ||
                (this._repeat && this._time && this.totalProgress() < 1))
              ? this._tTime % (this._dur + this._rDelay)
              : this._ts
              ? xn(i.rawTime(t), this)
              : this._tTime
            : this._tTime;
        }),
        (e.revert = function (t) {
          t === void 0 && (t = Vc);
          var i = Je;
          return (
            (Je = t),
            (this._initted || this._startAt) &&
              (this.timeline && this.timeline.revert(t),
              this.totalTime(-0.01, t.suppressEvents)),
            this.data !== "nested" && t.kill !== !1 && this.kill(),
            (Je = i),
            this
          );
        }),
        (e.globalTime = function (t) {
          for (var i = this, n = arguments.length ? t : i.rawTime(); i; )
            (n = i._start + n / (i._ts || 1)), (i = i._dp);
          return !this.parent && this._sat
            ? this._sat.vars.immediateRender
              ? -1 / 0
              : this._sat.globalTime(t)
            : n;
        }),
        (e.repeat = function (t) {
          return arguments.length
            ? ((this._repeat = t === 1 / 0 ? -2 : t), ha(this))
            : this._repeat === -2
            ? 1 / 0
            : this._repeat;
        }),
        (e.repeatDelay = function (t) {
          if (arguments.length) {
            var i = this._time;
            return (this._rDelay = t), ha(this), i ? this.time(i) : this;
          }
          return this._rDelay;
        }),
        (e.yoyo = function (t) {
          return arguments.length ? ((this._yoyo = t), this) : this._yoyo;
        }),
        (e.seek = function (t, i) {
          return this.totalTime(Dt(this, t), pt(i));
        }),
        (e.restart = function (t, i) {
          return this.play().totalTime(t ? -this._delay : 0, pt(i));
        }),
        (e.play = function (t, i) {
          return t != null && this.seek(t, i), this.reversed(!1).paused(!1);
        }),
        (e.reverse = function (t, i) {
          return (
            t != null && this.seek(t || this.totalDuration(), i),
            this.reversed(!0).paused(!1)
          );
        }),
        (e.pause = function (t, i) {
          return t != null && this.seek(t, i), this.paused(!0);
        }),
        (e.resume = function () {
          return this.paused(!1);
        }),
        (e.reversed = function (t) {
          return arguments.length
            ? (!!t !== this.reversed() &&
                this.timeScale(-this._rts || (t ? -ue : 0)),
              this)
            : this._rts < 0;
        }),
        (e.invalidate = function () {
          return (this._initted = this._act = 0), (this._zTime = -ue), this;
        }),
        (e.isActive = function () {
          var t = this.parent || this._dp,
            i = this._start,
            n;
          return !!(
            !t ||
            (this._ts &&
              this._initted &&
              t.isActive() &&
              (n = t.rawTime(!0)) >= i &&
              n < this.endTime(!0) - ue)
          );
        }),
        (e.eventCallback = function (t, i, n) {
          var o = this.vars;
          return arguments.length > 1
            ? (i
                ? ((o[t] = i),
                  n && (o[t + "Params"] = n),
                  t === "onUpdate" && (this._onUpdate = i))
                : delete o[t],
              this)
            : o[t];
        }),
        (e.then = function (t) {
          var i = this;
          return new Promise(function (n) {
            var o = ke(t) ? t : oa,
              a = function () {
                var c = i.then;
                (i.then = null),
                  ke(o) && (o = o(i)) && (o.then || o === i) && (i.then = c),
                  n(o),
                  (i.then = c);
              };
            (i._initted && i.totalProgress() === 1 && i._ts >= 0) ||
            (!i._tTime && i._ts < 0)
              ? a()
              : (i._prom = a);
          });
        }),
        (e.kill = function () {
          Ii(this);
        }),
        s
      );
    })();
  zt($i.prototype, {
    _time: 0,
    _start: 0,
    _end: 0,
    _tTime: 0,
    _tDur: 0,
    _dirty: 0,
    _repeat: 0,
    _yoyo: !1,
    parent: null,
    _initted: !1,
    _rDelay: 0,
    _ts: 1,
    _dp: 0,
    ratio: 0,
    _zTime: -ue,
    _prom: 0,
    _ps: !1,
    _rts: 1,
  });
  var mt = (function (s) {
    Uo(e, s);
    function e(t, i) {
      var n;
      return (
        t === void 0 && (t = {}),
        (n = s.call(this, t) || this),
        (n.labels = {}),
        (n.smoothChildTiming = !!t.smoothChildTiming),
        (n.autoRemoveChildren = !!t.autoRemoveChildren),
        (n._sort = pt(t.sortChildren)),
        ye && Zt(t.parent || ye, lr(n), i),
        t.reversed && n.reverse(),
        t.paused && n.paused(!0),
        t.scrollTrigger && fa(lr(n), t.scrollTrigger),
        n
      );
    }
    var r = e.prototype;
    return (
      (r.to = function (i, n, o) {
        return Ri(0, arguments, this), this;
      }),
      (r.from = function (i, n, o) {
        return Ri(1, arguments, this), this;
      }),
      (r.fromTo = function (i, n, o, a) {
        return Ri(2, arguments, this), this;
      }),
      (r.set = function (i, n, o) {
        return (
          (n.duration = 0),
          (n.parent = this),
          Di(n).repeatDelay || (n.repeat = 0),
          (n.immediateRender = !!n.immediateRender),
          new Me(i, n, Dt(this, o), 1),
          this
        );
      }),
      (r.call = function (i, n, o) {
        return Zt(this, Me.delayedCall(0, i, n), o);
      }),
      (r.staggerTo = function (i, n, o, a, l, c, u) {
        return (
          (o.duration = n),
          (o.stagger = o.stagger || a),
          (o.onComplete = c),
          (o.onCompleteParams = u),
          (o.parent = this),
          new Me(i, o, Dt(this, l)),
          this
        );
      }),
      (r.staggerFrom = function (i, n, o, a, l, c, u) {
        return (
          (o.runBackwards = 1),
          (Di(o).immediateRender = pt(o.immediateRender)),
          this.staggerTo(i, n, o, a, l, c, u)
        );
      }),
      (r.staggerFromTo = function (i, n, o, a, l, c, u, _) {
        return (
          (a.startAt = o),
          (Di(a).immediateRender = pt(a.immediateRender)),
          this.staggerTo(i, n, a, l, c, u, _)
        );
      }),
      (r.render = function (i, n, o) {
        var a = this._time,
          l = this._dirty ? this.totalDuration() : this._tDur,
          c = this._dur,
          u = i <= 0 ? 0 : Ue(i),
          _ = this._zTime < 0 != i < 0 && (this._initted || !c),
          p,
          f,
          m,
          h,
          v,
          T,
          E,
          P,
          g,
          y,
          w,
          S;
        if (
          (this !== ye && u > l && i >= 0 && (u = l),
          u !== this._tTime || o || _)
        ) {
          if (
            (a !== this._time &&
              c &&
              ((u += this._time - a), (i += this._time - a)),
            (p = u),
            (g = this._start),
            (P = this._ts),
            (T = !P),
            _ && (c || (a = this._zTime), (i || !n) && (this._zTime = i)),
            this._repeat)
          ) {
            if (
              ((w = this._yoyo),
              (v = c + this._rDelay),
              this._repeat < -1 && i < 0)
            )
              return this.totalTime(v * 100 + i, n, o);
            if (
              ((p = Ue(u % v)),
              u === l
                ? ((h = this._repeat), (p = c))
                : ((h = ~~(u / v)),
                  h && h === u / v && ((p = c), h--),
                  p > c && (p = c)),
              (y = fi(this._tTime, v)),
              !a &&
                this._tTime &&
                y !== h &&
                this._tTime - y * v - this._dur <= 0 &&
                (y = h),
              w && h & 1 && ((p = c - p), (S = 1)),
              h !== y && !this._lock)
            ) {
              var A = w && y & 1,
                C = A === (w && h & 1);
              if (
                (h < y && (A = !A),
                (a = A ? 0 : u % c ? c : u),
                (this._lock = 1),
                (this.render(a || (S ? 0 : Ue(h * v)), n, !c)._lock = 0),
                (this._tTime = u),
                !n && this.parent && Nt(this, "onRepeat"),
                this.vars.repeatRefresh && !S && (this.invalidate()._lock = 1),
                (a && a !== this._time) ||
                  T !== !this._ts ||
                  (this.vars.onRepeat && !this.parent && !this._act))
              )
                return this;
              if (
                ((c = this._dur),
                (l = this._tDur),
                C &&
                  ((this._lock = 2),
                  (a = A ? c : -1e-4),
                  this.render(a, !0),
                  this.vars.repeatRefresh && !S && this.invalidate()),
                (this._lock = 0),
                !this._ts && !T)
              )
                return this;
              Pa(this, S);
            }
          }
          if (
            (this._hasPause &&
              !this._forcing &&
              this._lock < 2 &&
              ((E = Zc(this, Ue(a), Ue(p))), E && (u -= p - (p = E._start))),
            (this._tTime = u),
            (this._time = p),
            (this._act = !P),
            this._initted ||
              ((this._onUpdate = this.vars.onUpdate),
              (this._initted = 1),
              (this._zTime = i),
              (a = 0)),
            !a && p && !n && !h && (Nt(this, "onStart"), this._tTime !== u))
          )
            return this;
          if (p >= a && i >= 0)
            for (f = this._first; f; ) {
              if (
                ((m = f._next), (f._act || p >= f._start) && f._ts && E !== f)
              ) {
                if (f.parent !== this) return this.render(i, n, o);
                if (
                  (f.render(
                    f._ts > 0
                      ? (p - f._start) * f._ts
                      : (f._dirty ? f.totalDuration() : f._tDur) +
                          (p - f._start) * f._ts,
                    n,
                    o
                  ),
                  p !== this._time || (!this._ts && !T))
                ) {
                  (E = 0), m && (u += this._zTime = -ue);
                  break;
                }
              }
              f = m;
            }
          else {
            f = this._last;
            for (var L = i < 0 ? i : p; f; ) {
              if (
                ((m = f._prev), (f._act || L <= f._end) && f._ts && E !== f)
              ) {
                if (f.parent !== this) return this.render(i, n, o);
                if (
                  (f.render(
                    f._ts > 0
                      ? (L - f._start) * f._ts
                      : (f._dirty ? f.totalDuration() : f._tDur) +
                          (L - f._start) * f._ts,
                    n,
                    o || (Je && (f._initted || f._startAt))
                  ),
                  p !== this._time || (!this._ts && !T))
                ) {
                  (E = 0), m && (u += this._zTime = L ? -ue : ue);
                  break;
                }
              }
              f = m;
            }
          }
          if (
            E &&
            !n &&
            (this.pause(),
            (E.render(p >= a ? 0 : -ue)._zTime = p >= a ? 1 : -1),
            this._ts)
          )
            return (this._start = g), Tn(this), this.render(i, n, o);
          this._onUpdate && !n && Nt(this, "onUpdate", !0),
            ((u === l && this._tTime >= this.totalDuration()) || (!u && a)) &&
              (g === this._start || Math.abs(P) !== Math.abs(this._ts)) &&
              (this._lock ||
                ((i || !c) &&
                  ((u === l && this._ts > 0) || (!u && this._ts < 0)) &&
                  yr(this, 1),
                !n &&
                  !(i < 0 && !a) &&
                  (u || a || !l) &&
                  (Nt(
                    this,
                    u === l && i >= 0 ? "onComplete" : "onReverseComplete",
                    !0
                  ),
                  this._prom &&
                    !(u < l && this.timeScale() > 0) &&
                    this._prom())));
        }
        return this;
      }),
      (r.add = function (i, n) {
        var o = this;
        if ((cr(n) || (n = Dt(this, n, i)), !(i instanceof $i))) {
          if (Ze(i))
            return (
              i.forEach(function (a) {
                return o.add(a, n);
              }),
              this
            );
          if (Be(i)) return this.addLabel(i, n);
          if (ke(i)) i = Me.delayedCall(0, i);
          else return this;
        }
        return this !== i ? Zt(this, i, n) : this;
      }),
      (r.getChildren = function (i, n, o, a) {
        i === void 0 && (i = !0),
          n === void 0 && (n = !0),
          o === void 0 && (o = !0),
          a === void 0 && (a = -Lt);
        for (var l = [], c = this._first; c; )
          c._start >= a &&
            (c instanceof Me
              ? n && l.push(c)
              : (o && l.push(c),
                i && l.push.apply(l, c.getChildren(!0, n, o)))),
            (c = c._next);
        return l;
      }),
      (r.getById = function (i) {
        for (var n = this.getChildren(1, 1, 1), o = n.length; o--; )
          if (n[o].vars.id === i) return n[o];
      }),
      (r.remove = function (i) {
        return Be(i)
          ? this.removeLabel(i)
          : ke(i)
          ? this.killTweensOf(i)
          : (Sn(this, i),
            i === this._recent && (this._recent = this._last),
            Ir(this));
      }),
      (r.totalTime = function (i, n) {
        return arguments.length
          ? ((this._forcing = 1),
            !this._dp &&
              this._ts &&
              (this._start = Ue(
                Tt.time -
                  (this._ts > 0
                    ? i / this._ts
                    : (this.totalDuration() - i) / -this._ts)
              )),
            s.prototype.totalTime.call(this, i, n),
            (this._forcing = 0),
            this)
          : this._tTime;
      }),
      (r.addLabel = function (i, n) {
        return (this.labels[i] = Dt(this, n)), this;
      }),
      (r.removeLabel = function (i) {
        return delete this.labels[i], this;
      }),
      (r.addPause = function (i, n, o) {
        var a = Me.delayedCall(0, n || zi, o);
        return (
          (a.data = "isPause"), (this._hasPause = 1), Zt(this, a, Dt(this, i))
        );
      }),
      (r.removePause = function (i) {
        var n = this._first;
        for (i = Dt(this, i); n; )
          n._start === i && n.data === "isPause" && yr(n), (n = n._next);
      }),
      (r.killTweensOf = function (i, n, o) {
        for (var a = this.getTweensOf(i, o), l = a.length; l--; )
          Sr !== a[l] && a[l].kill(i, n);
        return this;
      }),
      (r.getTweensOf = function (i, n) {
        for (var o = [], a = Rt(i), l = this._first, c = cr(n), u; l; )
          l instanceof Me
            ? Uc(l._targets, a) &&
              (c
                ? (!Sr || (l._initted && l._ts)) &&
                  l.globalTime(0) <= n &&
                  l.globalTime(l.totalDuration()) > n
                : !n || l.isActive()) &&
              o.push(l)
            : (u = l.getTweensOf(a, n)).length && o.push.apply(o, u),
            (l = l._next);
        return o;
      }),
      (r.tweenTo = function (i, n) {
        n = n || {};
        var o = this,
          a = Dt(o, i),
          l = n,
          c = l.startAt,
          u = l.onStart,
          _ = l.onStartParams,
          p = l.immediateRender,
          f,
          m = Me.to(
            o,
            zt(
              {
                ease: n.ease || "none",
                lazy: !1,
                immediateRender: !1,
                time: a,
                overwrite: "auto",
                duration:
                  n.duration ||
                  Math.abs(
                    (a - (c && "time" in c ? c.time : o._time)) / o.timeScale()
                  ) ||
                  ue,
                onStart: function () {
                  if ((o.pause(), !f)) {
                    var v =
                      n.duration ||
                      Math.abs(
                        (a - (c && "time" in c ? c.time : o._time)) /
                          o.timeScale()
                      );
                    m._dur !== v && di(m, v, 0, 1).render(m._time, !0, !0),
                      (f = 1);
                  }
                  u && u.apply(m, _ || []);
                },
              },
              n
            )
          );
        return p ? m.render(0) : m;
      }),
      (r.tweenFromTo = function (i, n, o) {
        return this.tweenTo(n, zt({ startAt: { time: Dt(this, i) } }, o));
      }),
      (r.recent = function () {
        return this._recent;
      }),
      (r.nextLabel = function (i) {
        return i === void 0 && (i = this._time), wa(this, Dt(this, i));
      }),
      (r.previousLabel = function (i) {
        return i === void 0 && (i = this._time), wa(this, Dt(this, i), 1);
      }),
      (r.currentLabel = function (i) {
        return arguments.length
          ? this.seek(i, !0)
          : this.previousLabel(this._time + ue);
      }),
      (r.shiftChildren = function (i, n, o) {
        o === void 0 && (o = 0);
        for (var a = this._first, l = this.labels, c; a; )
          a._start >= o && ((a._start += i), (a._end += i)), (a = a._next);
        if (n) for (c in l) l[c] >= o && (l[c] += i);
        return Ir(this);
      }),
      (r.invalidate = function (i) {
        var n = this._first;
        for (this._lock = 0; n; ) n.invalidate(i), (n = n._next);
        return s.prototype.invalidate.call(this, i);
      }),
      (r.clear = function (i) {
        i === void 0 && (i = !0);
        for (var n = this._first, o; n; )
          (o = n._next), this.remove(n), (n = o);
        return (
          this._dp && (this._time = this._tTime = this._pTime = 0),
          i && (this.labels = {}),
          Ir(this)
        );
      }),
      (r.totalDuration = function (i) {
        var n = 0,
          o = this,
          a = o._last,
          l = Lt,
          c,
          u,
          _;
        if (arguments.length)
          return o.timeScale(
            (o._repeat < 0 ? o.duration() : o.totalDuration()) /
              (o.reversed() ? -i : i)
          );
        if (o._dirty) {
          for (_ = o.parent; a; )
            (c = a._prev),
              a._dirty && a.totalDuration(),
              (u = a._start),
              u > l && o._sort && a._ts && !o._lock
                ? ((o._lock = 1), (Zt(o, a, u - a._delay, 1)._lock = 0))
                : (l = u),
              u < 0 &&
                a._ts &&
                ((n -= u),
                ((!_ && !o._dp) || (_ && _.smoothChildTiming)) &&
                  ((o._start += u / o._ts), (o._time -= u), (o._tTime -= u)),
                o.shiftChildren(-u, !1, -1 / 0),
                (l = 0)),
              a._end > n && a._ts && (n = a._end),
              (a = c);
          di(o, o === ye && o._time > n ? o._time : n, 1, 1), (o._dirty = 0);
        }
        return o._tDur;
      }),
      (e.updateRoot = function (i) {
        if ((ye._ts && (na(ye, xn(i, ye)), (ta = Tt.frame)), Tt.frame >= ra)) {
          ra += wt.autoSleep || 120;
          var n = ye._first;
          if ((!n || !n._ts) && wt.autoSleep && Tt._listeners.length < 2) {
            for (; n && !n._ts; ) n = n._next;
            n || Tt.sleep();
          }
        }
      }),
      e
    );
  })($i);
  zt(mt.prototype, { _lock: 0, _hasPause: 0, _forcing: 0 });
  var _u = function (e, r, t, i, n, o, a) {
      var l = new gt(this._pt, e, r, 0, 1, qa, null, n),
        c = 0,
        u = 0,
        _,
        p,
        f,
        m,
        h,
        v,
        T,
        E;
      for (
        l.b = t,
          l.e = i,
          t += "",
          i += "",
          (T = ~i.indexOf("random(")) && (i = qi(i)),
          o && ((E = [t, i]), o(E, e, r), (t = E[0]), (i = E[1])),
          p = t.match(gs) || [];
        (_ = gs.exec(i));

      )
        (m = _[0]),
          (h = i.substring(c, _.index)),
          f ? (f = (f + 1) % 5) : h.substr(-5) === "rgba(" && (f = 1),
          m !== p[u++] &&
            ((v = parseFloat(p[u - 1]) || 0),
            (l._pt = {
              _next: l._pt,
              p: h || u === 1 ? h : ",",
              s: v,
              c: m.charAt(1) === "=" ? ui(v, m) - v : parseFloat(m) - v,
              m: f && f < 4 ? Math.round : 0,
            }),
            (c = gs.lastIndex));
      return (
        (l.c = c < i.length ? i.substring(c, i.length) : ""),
        (l.fp = a),
        (Ko.test(i) || T) && (l.e = 0),
        (this._pt = l),
        l
      );
    },
    Ds = function (e, r, t, i, n, o, a, l, c, u) {
      ke(i) && (i = i(n || 0, e, o));
      var _ = e[r],
        p =
          t !== "get"
            ? t
            : ke(_)
            ? c
              ? e[
                  r.indexOf("set") || !ke(e["get" + r.substr(3)])
                    ? r
                    : "get" + r.substr(3)
                ](c)
              : e[r]()
            : _,
        f = ke(_) ? (c ? bu : Ra) : qs,
        m;
      if (
        (Be(i) &&
          (~i.indexOf("random(") && (i = qi(i)),
          i.charAt(1) === "=" &&
            ((m = ui(p, i) + (et(p) || 0)), (m || m === 0) && (i = m))),
        !u || p !== i || Rs)
      )
        return !isNaN(p * i) && i !== ""
          ? ((m = new gt(
              this._pt,
              e,
              r,
              +p || 0,
              i - (p || 0),
              typeof _ == "boolean" ? Su : Na,
              0,
              f
            )),
            c && (m.fp = c),
            a && m.modifier(a, this, e),
            (this._pt = m))
          : (!_ && !(r in e) && bs(r, i),
            _u.call(this, e, r, p, i, f, l || wt.stringFilter, c));
    },
    mu = function (e, r, t, i, n) {
      if (
        (ke(e) && (e = Wi(e, n, r, t, i)),
        !Jt(e) || (e.style && e.nodeType) || Ze(e) || jo(e))
      )
        return Be(e) ? Wi(e, n, r, t, i) : e;
      var o = {},
        a;
      for (a in e) o[a] = Wi(e[a], n, r, t, i);
      return o;
    },
    Ma = function (e, r, t, i, n, o) {
      var a, l, c, u;
      if (
        xt[e] &&
        (a = new xt[e]()).init(
          n,
          a.rawVars ? r[e] : mu(r[e], i, n, o, t),
          t,
          i,
          o
        ) !== !1 &&
        ((t._pt = l = new gt(t._pt, n, e, 0, 1, a.render, a, 0, a.priority)),
        t !== hi)
      )
        for (c = t._ptLookup[t._targets.indexOf(n)], u = a._props.length; u--; )
          c[a._props[u]] = l;
      return a;
    },
    Sr,
    Rs,
    Ns = function s(e, r, t) {
      var i = e.vars,
        n = i.ease,
        o = i.startAt,
        a = i.immediateRender,
        l = i.lazy,
        c = i.onUpdate,
        u = i.onUpdateParams,
        _ = i.callbackScope,
        p = i.runBackwards,
        f = i.yoyoEase,
        m = i.keyframes,
        h = i.autoRevert,
        v = e._dur,
        T = e._startAt,
        E = e._targets,
        P = e.parent,
        g = P && P.data === "nested" ? P.vars.targets : E,
        y = e._overwrite === "auto" && !ds,
        w = e.timeline,
        S,
        A,
        C,
        L,
        z,
        x,
        H,
        q,
        B,
        U,
        F,
        G,
        Q;
      if (
        (w && (!m || !n) && (n = "none"),
        (e._ease = Fr(n, li.ease)),
        (e._yEase = f ? Aa(Fr(f === !0 ? n : f, li.ease)) : 0),
        f &&
          e._yoyo &&
          !e._repeat &&
          ((f = e._yEase), (e._yEase = e._ease), (e._ease = f)),
        (e._from = !w && !!i.runBackwards),
        !w || (m && !i.stagger))
      ) {
        if (
          ((q = E[0] ? Nr(E[0]).harness : 0),
          (G = q && i[q.prop]),
          (S = wn(i, ws)),
          T &&
            (T._zTime < 0 && T.progress(1),
            r < 0 && p && a && !h
              ? T.render(-1, !0)
              : T.revert(p && v ? vn : Xc),
            (T._lazy = 0)),
          o)
        ) {
          if (
            (yr(
              (e._startAt = Me.set(
                E,
                zt(
                  {
                    data: "isStart",
                    overwrite: !1,
                    parent: P,
                    immediateRender: !0,
                    lazy: !T && pt(l),
                    startAt: null,
                    delay: 0,
                    onUpdate: c,
                    onUpdateParams: u,
                    callbackScope: _,
                    stagger: 0,
                  },
                  o
                )
              ))
            ),
            (e._startAt._dp = 0),
            (e._startAt._sat = e),
            r < 0 && (Je || (!a && !h)) && e._startAt.revert(vn),
            a && v && r <= 0 && t <= 0)
          ) {
            r && (e._zTime = r);
            return;
          }
        } else if (p && v && !T) {
          if (
            (r && (a = !1),
            (C = zt(
              {
                overwrite: !1,
                data: "isFromStart",
                lazy: a && !T && pt(l),
                immediateRender: a,
                stagger: 0,
                parent: P,
              },
              S
            )),
            G && (C[q.prop] = G),
            yr((e._startAt = Me.set(E, C))),
            (e._startAt._dp = 0),
            (e._startAt._sat = e),
            r < 0 && (Je ? e._startAt.revert(vn) : e._startAt.render(-1, !0)),
            (e._zTime = r),
            !a)
          )
            s(e._startAt, ue, ue);
          else if (!r) return;
        }
        for (
          e._pt = e._ptCache = 0, l = (v && pt(l)) || (l && !v), A = 0;
          A < E.length;
          A++
        ) {
          if (
            ((z = E[A]),
            (H = z._gsap || Es(E)[A]._gsap),
            (e._ptLookup[A] = U = {}),
            Ss[H.id] && vr.length && bn(),
            (F = g === E ? A : g.indexOf(z)),
            q &&
              (B = new q()).init(z, G || S, e, F, g) !== !1 &&
              ((e._pt = L =
                new gt(e._pt, z, B.name, 0, 1, B.render, B, 0, B.priority)),
              B._props.forEach(function (b) {
                U[b] = L;
              }),
              B.priority && (x = 1)),
            !q || G)
          )
            for (C in S)
              xt[C] && (B = Ma(C, S, e, F, z, g))
                ? B.priority && (x = 1)
                : (U[C] = L =
                    Ds.call(e, z, C, "get", S[C], F, g, 0, i.stringFilter));
          e._op && e._op[A] && e.kill(z, e._op[A]),
            y &&
              e._pt &&
              ((Sr = e),
              ye.killTweensOf(z, U, e.globalTime(r)),
              (Q = !e.parent),
              (Sr = 0)),
            e._pt && l && (Ss[H.id] = 1);
        }
        x && Ia(e), e._onInit && e._onInit(e);
      }
      (e._onUpdate = c),
        (e._initted = (!e._op || e._pt) && !Q),
        m && r <= 0 && w.render(Lt, !0, !0);
    },
    gu = function (e, r, t, i, n, o, a) {
      var l = ((e._pt && e._ptCache) || (e._ptCache = {}))[r],
        c,
        u,
        _,
        p;
      if (!l)
        for (
          l = e._ptCache[r] = [], _ = e._ptLookup, p = e._targets.length;
          p--;

        ) {
          if (((c = _[p][r]), c && c.d && c.d._pt))
            for (c = c.d._pt; c && c.p !== r && c.fp !== r; ) c = c._next;
          if (!c) return (Rs = 1), (e.vars[r] = "+=0"), Ns(e, a), (Rs = 0), 1;
          l.push(c);
        }
      for (p = l.length; p--; )
        (u = l[p]),
          (c = u._pt || u),
          (c.s = (i || i === 0) && !n ? i : c.s + (i || 0) + o * c.c),
          (c.c = t - c.s),
          u.e && (u.e = Pe(t) + et(u.e)),
          u.b && (u.b = c.s + et(u.b));
    },
    vu = function (e, r) {
      var t = e[0] ? Nr(e[0]).harness : 0,
        i = t && t.aliases,
        n,
        o,
        a,
        l;
      if (!i) return r;
      n = qr({}, r);
      for (o in i)
        if (o in n)
          for (l = i[o].split(","), a = l.length; a--; ) n[l[a]] = n[o];
      return n;
    },
    yu = function (e, r, t, i) {
      var n = r.ease || i || "power1.inOut",
        o,
        a;
      if (Ze(r))
        (a = t[e] || (t[e] = [])),
          r.forEach(function (l, c) {
            return a.push({ t: (c / (r.length - 1)) * 100, v: l, e: n });
          });
      else
        for (o in r)
          (a = t[o] || (t[o] = [])),
            o === "ease" || a.push({ t: parseFloat(e), v: r[o], e: n });
    },
    Wi = function (e, r, t, i, n) {
      return ke(e)
        ? e.call(r, t, i, n)
        : Be(e) && ~e.indexOf("random(")
        ? qi(e)
        : e;
    },
    za = Ts + "repeat,repeatDelay,yoyo,repeatRefresh,yoyoEase,autoRevert",
    Da = {};
  _t(za + ",id,stagger,delay,duration,paused,scrollTrigger", function (s) {
    return (Da[s] = 1);
  });
  var Me = (function (s) {
    Uo(e, s);
    function e(t, i, n, o) {
      var a;
      typeof i == "number" && ((n.duration = i), (i = n), (n = null)),
        (a = s.call(this, o ? i : Di(i)) || this);
      var l = a.vars,
        c = l.duration,
        u = l.delay,
        _ = l.immediateRender,
        p = l.stagger,
        f = l.overwrite,
        m = l.keyframes,
        h = l.defaults,
        v = l.scrollTrigger,
        T = l.yoyoEase,
        E = i.parent || ye,
        P = (Ze(t) || jo(t) ? cr(t[0]) : "length" in i) ? [t] : Rt(t),
        g,
        y,
        w,
        S,
        A,
        C,
        L,
        z;
      if (
        ((a._targets = P.length
          ? Es(P)
          : gn(
              "GSAP target " + t + " not found. https://greensock.com",
              !wt.nullTargetWarn
            ) || []),
        (a._ptLookup = []),
        (a._overwrite = f),
        m || p || _n(c) || _n(u))
      ) {
        if (
          ((i = a.vars),
          (g = a.timeline =
            new mt({
              data: "nested",
              defaults: h || {},
              targets: E && E.data === "nested" ? E.vars.targets : P,
            })),
          g.kill(),
          (g.parent = g._dp = lr(a)),
          (g._start = 0),
          p || _n(c) || _n(u))
        ) {
          if (((S = P.length), (L = p && ma(p)), Jt(p)))
            for (A in p) ~za.indexOf(A) && (z || (z = {}), (z[A] = p[A]));
          for (y = 0; y < S; y++)
            (w = wn(i, Da)),
              (w.stagger = 0),
              T && (w.yoyoEase = T),
              z && qr(w, z),
              (C = P[y]),
              (w.duration = +Wi(c, lr(a), y, C, P)),
              (w.delay = (+Wi(u, lr(a), y, C, P) || 0) - a._delay),
              !p &&
                S === 1 &&
                w.delay &&
                ((a._delay = u = w.delay), (a._start += u), (w.delay = 0)),
              g.to(C, w, L ? L(y, C, P) : 0),
              (g._ease = te.none);
          g.duration() ? (c = u = 0) : (a.timeline = 0);
        } else if (m) {
          Di(zt(g.vars.defaults, { ease: "none" })),
            (g._ease = Fr(m.ease || i.ease || "none"));
          var x = 0,
            H,
            q,
            B;
          if (Ze(m))
            m.forEach(function (U) {
              return g.to(P, U, ">");
            }),
              g.duration();
          else {
            w = {};
            for (A in m)
              A === "ease" || A === "easeEach" || yu(A, m[A], w, m.easeEach);
            for (A in w)
              for (
                H = w[A].sort(function (U, F) {
                  return U.t - F.t;
                }),
                  x = 0,
                  y = 0;
                y < H.length;
                y++
              )
                (q = H[y]),
                  (B = {
                    ease: q.e,
                    duration: ((q.t - (y ? H[y - 1].t : 0)) / 100) * c,
                  }),
                  (B[A] = q.v),
                  g.to(P, B, x),
                  (x += B.duration);
            g.duration() < c && g.to({}, { duration: c - g.duration() });
          }
        }
        c || a.duration((c = g.duration()));
      } else a.timeline = 0;
      return (
        f === !0 && !ds && ((Sr = lr(a)), ye.killTweensOf(P), (Sr = 0)),
        Zt(E, lr(a), n),
        i.reversed && a.reverse(),
        i.paused && a.paused(!0),
        (_ ||
          (!c &&
            !m &&
            a._start === Ue(E._time) &&
            pt(_) &&
            Kc(lr(a)) &&
            E.data !== "nested")) &&
          ((a._tTime = -ue), a.render(Math.max(0, -u) || 0)),
        v && fa(lr(a), v),
        a
      );
    }
    var r = e.prototype;
    return (
      (r.render = function (i, n, o) {
        var a = this._time,
          l = this._tDur,
          c = this._dur,
          u = i < 0,
          _ = i > l - ue && !u ? l : i < ue ? 0 : i,
          p,
          f,
          m,
          h,
          v,
          T,
          E,
          P,
          g;
        if (!c) Jc(this, i, n, o);
        else if (
          _ !== this._tTime ||
          !i ||
          o ||
          (!this._initted && this._tTime) ||
          (this._startAt && this._zTime < 0 !== u)
        ) {
          if (((p = _), (P = this.timeline), this._repeat)) {
            if (((h = c + this._rDelay), this._repeat < -1 && u))
              return this.totalTime(h * 100 + i, n, o);
            if (
              ((p = Ue(_ % h)),
              _ === l
                ? ((m = this._repeat), (p = c))
                : ((m = ~~(_ / h)),
                  m && m === _ / h && ((p = c), m--),
                  p > c && (p = c)),
              (T = this._yoyo && m & 1),
              T && ((g = this._yEase), (p = c - p)),
              (v = fi(this._tTime, h)),
              p === a && !o && this._initted)
            )
              return (this._tTime = _), this;
            m !== v &&
              (P && this._yEase && Pa(P, T),
              this.vars.repeatRefresh &&
                !T &&
                !this._lock &&
                ((this._lock = o = 1),
                (this.render(Ue(h * m), !0).invalidate()._lock = 0)));
          }
          if (!this._initted) {
            if (da(this, u ? i : p, o, n, _)) return (this._tTime = 0), this;
            if (a !== this._time) return this;
            if (c !== this._dur) return this.render(i, n, o);
          }
          if (
            ((this._tTime = _),
            (this._time = p),
            !this._act && this._ts && ((this._act = 1), (this._lazy = 0)),
            (this.ratio = E = (g || this._ease)(p / c)),
            this._from && (this.ratio = E = 1 - E),
            p && !a && !n && !m && (Nt(this, "onStart"), this._tTime !== _))
          )
            return this;
          for (f = this._pt; f; ) f.r(E, f.d), (f = f._next);
          (P &&
            P.render(
              i < 0 ? i : !p && T ? -ue : P._dur * P._ease(p / this._dur),
              n,
              o
            )) ||
            (this._startAt && (this._zTime = i)),
            this._onUpdate &&
              !n &&
              (u && ks(this, i, n, o), Nt(this, "onUpdate")),
            this._repeat &&
              m !== v &&
              this.vars.onRepeat &&
              !n &&
              this.parent &&
              Nt(this, "onRepeat"),
            (_ === this._tDur || !_) &&
              this._tTime === _ &&
              (u && !this._onUpdate && ks(this, i, !0, !0),
              (i || !c) &&
                ((_ === this._tDur && this._ts > 0) || (!_ && this._ts < 0)) &&
                yr(this, 1),
              !n &&
                !(u && !a) &&
                (_ || a || T) &&
                (Nt(this, _ === l ? "onComplete" : "onReverseComplete", !0),
                this._prom &&
                  !(_ < l && this.timeScale() > 0) &&
                  this._prom()));
        }
        return this;
      }),
      (r.targets = function () {
        return this._targets;
      }),
      (r.invalidate = function (i) {
        return (
          (!i || !this.vars.runBackwards) && (this._startAt = 0),
          (this._pt = this._op = this._onUpdate = this._lazy = this.ratio = 0),
          (this._ptLookup = []),
          this.timeline && this.timeline.invalidate(i),
          s.prototype.invalidate.call(this, i)
        );
      }),
      (r.resetTo = function (i, n, o, a) {
        Bi || Tt.wake(), this._ts || this.play();
        var l = Math.min(this._dur, (this._dp._time - this._start) * this._ts),
          c;
        return (
          this._initted || Ns(this, l),
          (c = this._ease(l / this._dur)),
          gu(this, i, n, o, a, c, l)
            ? this.resetTo(i, n, o, a)
            : (En(this, 0),
              this.parent ||
                la(
                  this._dp,
                  this,
                  "_first",
                  "_last",
                  this._dp._sort ? "_start" : 0
                ),
              this.render(0))
        );
      }),
      (r.kill = function (i, n) {
        if ((n === void 0 && (n = "all"), !i && (!n || n === "all")))
          return (this._lazy = this._pt = 0), this.parent ? Ii(this) : this;
        if (this.timeline) {
          var o = this.timeline.totalDuration();
          return (
            this.timeline.killTweensOf(i, n, Sr && Sr.vars.overwrite !== !0)
              ._first || Ii(this),
            this.parent &&
              o !== this.timeline.totalDuration() &&
              di(this, (this._dur * this.timeline._tDur) / o, 0, 1),
            this
          );
        }
        var a = this._targets,
          l = i ? Rt(i) : a,
          c = this._ptLookup,
          u = this._pt,
          _,
          p,
          f,
          m,
          h,
          v,
          T;
        if ((!n || n === "all") && jc(a, l))
          return n === "all" && (this._pt = 0), Ii(this);
        for (
          _ = this._op = this._op || [],
            n !== "all" &&
              (Be(n) &&
                ((h = {}),
                _t(n, function (E) {
                  return (h[E] = 1);
                }),
                (n = h)),
              (n = vu(a, n))),
            T = a.length;
          T--;

        )
          if (~l.indexOf(a[T])) {
            (p = c[T]),
              n === "all"
                ? ((_[T] = n), (m = p), (f = {}))
                : ((f = _[T] = _[T] || {}), (m = n));
            for (h in m)
              (v = p && p[h]),
                v &&
                  ((!("kill" in v.d) || v.d.kill(h) === !0) &&
                    Sn(this, v, "_pt"),
                  delete p[h]),
                f !== "all" && (f[h] = 1);
          }
        return this._initted && !this._pt && u && Ii(this), this;
      }),
      (e.to = function (i, n) {
        return new e(i, n, arguments[2]);
      }),
      (e.from = function (i, n) {
        return Ri(1, arguments);
      }),
      (e.delayedCall = function (i, n, o, a) {
        return new e(n, 0, {
          immediateRender: !1,
          lazy: !1,
          overwrite: !1,
          delay: i,
          onComplete: n,
          onReverseComplete: n,
          onCompleteParams: o,
          onReverseCompleteParams: o,
          callbackScope: a,
        });
      }),
      (e.fromTo = function (i, n, o) {
        return Ri(2, arguments);
      }),
      (e.set = function (i, n) {
        return (n.duration = 0), n.repeatDelay || (n.repeat = 0), new e(i, n);
      }),
      (e.killTweensOf = function (i, n, o) {
        return ye.killTweensOf(i, n, o);
      }),
      e
    );
  })($i);
  zt(Me.prototype, { _targets: [], _lazy: 0, _startAt: 0, _op: 0, _onInit: 0 }),
    _t("staggerTo,staggerFrom,staggerFromTo", function (s) {
      Me[s] = function () {
        var e = new mt(),
          r = As.call(arguments, 0);
        return r.splice(s === "staggerFromTo" ? 5 : 4, 0, 0), e[s].apply(e, r);
      };
    });
  var qs = function (e, r, t) {
      return (e[r] = t);
    },
    Ra = function (e, r, t) {
      return e[r](t);
    },
    bu = function (e, r, t, i) {
      return e[r](i.fp, t);
    },
    wu = function (e, r, t) {
      return e.setAttribute(r, t);
    },
    Is = function (e, r) {
      return ke(e[r]) ? Ra : ps(e[r]) && e.setAttribute ? wu : qs;
    },
    Na = function (e, r) {
      return r.set(r.t, r.p, Math.round((r.s + r.c * e) * 1e6) / 1e6, r);
    },
    Su = function (e, r) {
      return r.set(r.t, r.p, !!(r.s + r.c * e), r);
    },
    qa = function (e, r) {
      var t = r._pt,
        i = "";
      if (!e && r.b) i = r.b;
      else if (e === 1 && r.e) i = r.e;
      else {
        for (; t; )
          (i =
            t.p +
            (t.m
              ? t.m(t.s + t.c * e)
              : Math.round((t.s + t.c * e) * 1e4) / 1e4) +
            i),
            (t = t._next);
        i += r.c;
      }
      r.set(r.t, r.p, i, r);
    },
    Fs = function (e, r) {
      for (var t = r._pt; t; ) t.r(e, t.d), (t = t._next);
    },
    xu = function (e, r, t, i) {
      for (var n = this._pt, o; n; )
        (o = n._next), n.p === i && n.modifier(e, r, t), (n = o);
    },
    Tu = function (e) {
      for (var r = this._pt, t, i; r; )
        (i = r._next),
          (r.p === e && !r.op) || r.op === e
            ? Sn(this, r, "_pt")
            : r.dep || (t = 1),
          (r = i);
      return !t;
    },
    Eu = function (e, r, t, i) {
      i.mSet(e, r, i.m.call(i.tween, t, i.mt), i);
    },
    Ia = function (e) {
      for (var r = e._pt, t, i, n, o; r; ) {
        for (t = r._next, i = n; i && i.pr > r.pr; ) i = i._next;
        (r._prev = i ? i._prev : o) ? (r._prev._next = r) : (n = r),
          (r._next = i) ? (i._prev = r) : (o = r),
          (r = t);
      }
      e._pt = n;
    },
    gt = (function () {
      function s(r, t, i, n, o, a, l, c, u) {
        (this.t = t),
          (this.s = n),
          (this.c = o),
          (this.p = i),
          (this.r = a || Na),
          (this.d = l || this),
          (this.set = c || qs),
          (this.pr = u || 0),
          (this._next = r),
          r && (r._prev = this);
      }
      var e = s.prototype;
      return (
        (e.modifier = function (t, i, n) {
          (this.mSet = this.mSet || this.set),
            (this.set = Eu),
            (this.m = t),
            (this.mt = n),
            (this.tween = i);
        }),
        s
      );
    })();
  _t(
    Ts +
      "parent,duration,ease,delay,overwrite,runBackwards,startAt,yoyo,immediateRender,repeat,repeatDelay,data,paused,reversed,lazy,callbackScope,stringFilter,id,yoyoEase,stagger,inherit,repeatRefresh,keyframes,autoRevert,scrollTrigger",
    function (s) {
      return (ws[s] = 1);
    }
  ),
    (St.TweenMax = St.TweenLite = Me),
    (St.TimelineLite = St.TimelineMax = mt),
    (ye = new mt({
      sortChildren: !1,
      defaults: li,
      autoRemoveChildren: !0,
      id: "root",
      smoothChildTiming: !0,
    })),
    (wt.stringFilter = Ca);
  var $r = [],
    kn = {},
    ku = [],
    Fa = 0,
    Cu = 0,
    Bs = function (e) {
      return (kn[e] || ku).map(function (r) {
        return r();
      });
    },
    $s = function () {
      var e = Date.now(),
        r = [];
      e - Fa > 2 &&
        (Bs("matchMediaInit"),
        $r.forEach(function (t) {
          var i = t.queries,
            n = t.conditions,
            o,
            a,
            l,
            c;
          for (a in i)
            (o = Mt.matchMedia(i[a]).matches),
              o && (l = 1),
              o !== n[a] && ((n[a] = o), (c = 1));
          c && (t.revert(), l && r.push(t));
        }),
        Bs("matchMediaRevert"),
        r.forEach(function (t) {
          return t.onMatch(t);
        }),
        (Fa = e),
        Bs("matchMedia"));
    },
    Ba = (function () {
      function s(r, t) {
        (this.selector = t && Ps(t)),
          (this.data = []),
          (this._r = []),
          (this.isReverted = !1),
          (this.id = Cu++),
          r && this.add(r);
      }
      var e = s.prototype;
      return (
        (e.add = function (t, i, n) {
          ke(t) && ((n = i), (i = t), (t = ke));
          var o = this,
            a = function () {
              var c = Ee,
                u = o.selector,
                _;
              return (
                c && c !== o && c.data.push(o),
                n && (o.selector = Ps(n)),
                (Ee = o),
                (_ = i.apply(o, arguments)),
                ke(_) && o._r.push(_),
                (Ee = c),
                (o.selector = u),
                (o.isReverted = !1),
                _
              );
            };
          return (o.last = a), t === ke ? a(o) : t ? (o[t] = a) : a;
        }),
        (e.ignore = function (t) {
          var i = Ee;
          (Ee = null), t(this), (Ee = i);
        }),
        (e.getTweens = function () {
          var t = [];
          return (
            this.data.forEach(function (i) {
              return i instanceof s
                ? t.push.apply(t, i.getTweens())
                : i instanceof Me &&
                    !(i.parent && i.parent.data === "nested") &&
                    t.push(i);
            }),
            t
          );
        }),
        (e.clear = function () {
          this._r.length = this.data.length = 0;
        }),
        (e.kill = function (t, i) {
          var n = this;
          if (t) {
            var o = this.getTweens();
            this.data.forEach(function (l) {
              l.data === "isFlip" &&
                (l.revert(),
                l.getChildren(!0, !0, !1).forEach(function (c) {
                  return o.splice(o.indexOf(c), 1);
                }));
            }),
              o
                .map(function (l) {
                  return { g: l.globalTime(0), t: l };
                })
                .sort(function (l, c) {
                  return c.g - l.g || -1 / 0;
                })
                .forEach(function (l) {
                  return l.t.revert(t);
                }),
              this.data.forEach(function (l) {
                return !(l instanceof Me) && l.revert && l.revert(t);
              }),
              this._r.forEach(function (l) {
                return l(t, n);
              }),
              (this.isReverted = !0);
          } else
            this.data.forEach(function (l) {
              return l.kill && l.kill();
            });
          if ((this.clear(), i))
            for (var a = $r.length; a--; )
              $r[a].id === this.id && $r.splice(a, 1);
        }),
        (e.revert = function (t) {
          this.kill(t || {});
        }),
        s
      );
    })(),
    Au = (function () {
      function s(r) {
        (this.contexts = []), (this.scope = r);
      }
      var e = s.prototype;
      return (
        (e.add = function (t, i, n) {
          Jt(t) || (t = { matches: t });
          var o = new Ba(0, n || this.scope),
            a = (o.conditions = {}),
            l,
            c,
            u;
          Ee && !o.selector && (o.selector = Ee.selector),
            this.contexts.push(o),
            (i = o.add("onMatch", i)),
            (o.queries = t);
          for (c in t)
            c === "all"
              ? (u = 1)
              : ((l = Mt.matchMedia(t[c])),
                l &&
                  ($r.indexOf(o) < 0 && $r.push(o),
                  (a[c] = l.matches) && (u = 1),
                  l.addListener
                    ? l.addListener($s)
                    : l.addEventListener("change", $s)));
          return u && i(o), this;
        }),
        (e.revert = function (t) {
          this.kill(t || {});
        }),
        (e.kill = function (t) {
          this.contexts.forEach(function (i) {
            return i.kill(t, !0);
          });
        }),
        s
      );
    })(),
    Cn = {
      registerPlugin: function () {
        for (var e = arguments.length, r = new Array(e), t = 0; t < e; t++)
          r[t] = arguments[t];
        r.forEach(function (i) {
          return xa(i);
        });
      },
      timeline: function (e) {
        return new mt(e);
      },
      getTweensOf: function (e, r) {
        return ye.getTweensOf(e, r);
      },
      getProperty: function (e, r, t, i) {
        Be(e) && (e = Rt(e)[0]);
        var n = Nr(e || {}).get,
          o = t ? oa : sa;
        return (
          t === "native" && (t = ""),
          e &&
            (r
              ? o(((xt[r] && xt[r].get) || n)(e, r, t, i))
              : function (a, l, c) {
                  return o(((xt[a] && xt[a].get) || n)(e, a, l, c));
                })
        );
      },
      quickSetter: function (e, r, t) {
        if (((e = Rt(e)), e.length > 1)) {
          var i = e.map(function (u) {
              return vt.quickSetter(u, r, t);
            }),
            n = i.length;
          return function (u) {
            for (var _ = n; _--; ) i[_](u);
          };
        }
        e = e[0] || {};
        var o = xt[r],
          a = Nr(e),
          l = (a.harness && (a.harness.aliases || {})[r]) || r,
          c = o
            ? function (u) {
                var _ = new o();
                (hi._pt = 0),
                  _.init(e, t ? u + t : u, hi, 0, [e]),
                  _.render(1, _),
                  hi._pt && Fs(1, hi);
              }
            : a.set(e, l);
        return o
          ? c
          : function (u) {
              return c(e, l, t ? u + t : u, a, 1);
            };
      },
      quickTo: function (e, r, t) {
        var i,
          n = vt.to(
            e,
            qr(((i = {}), (i[r] = "+=0.1"), (i.paused = !0), i), t || {})
          ),
          o = function (l, c, u) {
            return n.resetTo(r, l, c, u);
          };
        return (o.tween = n), o;
      },
      isTweening: function (e) {
        return ye.getTweensOf(e, !0).length > 0;
      },
      defaults: function (e) {
        return e && e.ease && (e.ease = Fr(e.ease, li.ease)), aa(li, e || {});
      },
      config: function (e) {
        return aa(wt, e || {});
      },
      registerEffect: function (e) {
        var r = e.name,
          t = e.effect,
          i = e.plugins,
          n = e.defaults,
          o = e.extendTimeline;
        (i || "").split(",").forEach(function (a) {
          return (
            a &&
            !xt[a] &&
            !St[a] &&
            gn(r + " effect requires " + a + " plugin.")
          );
        }),
          (xs[r] = function (a, l, c) {
            return t(Rt(a), zt(l || {}, n), c);
          }),
          o &&
            (mt.prototype[r] = function (a, l, c) {
              return this.add(xs[r](a, Jt(l) ? l : (c = l) && {}, this), c);
            });
      },
      registerEase: function (e, r) {
        te[e] = Fr(r);
      },
      parseEase: function (e, r) {
        return arguments.length ? Fr(e, r) : te;
      },
      getById: function (e) {
        return ye.getById(e);
      },
      exportRoot: function (e, r) {
        e === void 0 && (e = {});
        var t = new mt(e),
          i,
          n;
        for (
          t.smoothChildTiming = pt(e.smoothChildTiming),
            ye.remove(t),
            t._dp = 0,
            t._time = t._tTime = ye._time,
            i = ye._first;
          i;

        )
          (n = i._next),
            (r ||
              !(
                !i._dur &&
                i instanceof Me &&
                i.vars.onComplete === i._targets[0]
              )) &&
              Zt(t, i, i._start - i._delay),
            (i = n);
        return Zt(ye, t, 0), t;
      },
      context: function (e, r) {
        return e ? new Ba(e, r) : Ee;
      },
      matchMedia: function (e) {
        return new Au(e);
      },
      matchMediaRefresh: function () {
        return (
          $r.forEach(function (e) {
            var r = e.conditions,
              t,
              i;
            for (i in r) r[i] && ((r[i] = !1), (t = 1));
            t && e.revert();
          }) || $s()
        );
      },
      addEventListener: function (e, r) {
        var t = kn[e] || (kn[e] = []);
        ~t.indexOf(r) || t.push(r);
      },
      removeEventListener: function (e, r) {
        var t = kn[e],
          i = t && t.indexOf(r);
        i >= 0 && t.splice(i, 1);
      },
      utils: {
        wrap: ou,
        wrapYoyo: au,
        distribute: ma,
        random: va,
        snap: ga,
        normalize: su,
        getUnit: et,
        clamp: tu,
        splitColor: Ta,
        toArray: Rt,
        selector: Ps,
        mapRange: ba,
        pipe: iu,
        unitize: nu,
        interpolate: lu,
        shuffle: _a,
      },
      install: Zo,
      effects: xs,
      ticker: Tt,
      updateRoot: mt.updateRoot,
      plugins: xt,
      globalTimeline: ye,
      core: {
        PropTween: gt,
        globals: ea,
        Tween: Me,
        Timeline: mt,
        Animation: $i,
        getCache: Nr,
        _removeLinkedListItem: Sn,
        reverting: function () {
          return Je;
        },
        context: function (e) {
          return e && Ee && (Ee.data.push(e), (e._ctx = Ee)), Ee;
        },
        suppressOverwrites: function (e) {
          return (ds = e);
        },
      },
    };
  _t("to,from,fromTo,delayedCall,set,killTweensOf", function (s) {
    return (Cn[s] = Me[s]);
  }),
    Tt.add(mt.updateRoot),
    (hi = Cn.to({}, { duration: 0 }));
  var Pu = function (e, r) {
      for (var t = e._pt; t && t.p !== r && t.op !== r && t.fp !== r; )
        t = t._next;
      return t;
    },
    Ou = function (e, r) {
      var t = e._targets,
        i,
        n,
        o;
      for (i in r)
        for (n = t.length; n--; )
          (o = e._ptLookup[n][i]),
            o &&
              (o = o.d) &&
              (o._pt && (o = Pu(o, i)),
              o && o.modifier && o.modifier(r[i], e, t[n], i));
    },
    Ws = function (e, r) {
      return {
        name: e,
        rawVars: 1,
        init: function (i, n, o) {
          o._onInit = function (a) {
            var l, c;
            if (
              (Be(n) &&
                ((l = {}),
                _t(n, function (u) {
                  return (l[u] = 1);
                }),
                (n = l)),
              r)
            ) {
              l = {};
              for (c in n) l[c] = r(n[c]);
              n = l;
            }
            Ou(a, n);
          };
        },
      };
    },
    vt =
      Cn.registerPlugin(
        {
          name: "attr",
          init: function (e, r, t, i, n) {
            var o, a, l;
            this.tween = t;
            for (o in r)
              (l = e.getAttribute(o) || ""),
                (a = this.add(
                  e,
                  "setAttribute",
                  (l || 0) + "",
                  r[o],
                  i,
                  n,
                  0,
                  0,
                  o
                )),
                (a.op = o),
                (a.b = l),
                this._props.push(o);
          },
          render: function (e, r) {
            for (var t = r._pt; t; )
              Je ? t.set(t.t, t.p, t.b, t) : t.r(e, t.d), (t = t._next);
          },
        },
        {
          name: "endArray",
          init: function (e, r) {
            for (var t = r.length; t--; )
              this.add(e, t, e[t] || 0, r[t], 0, 0, 0, 0, 0, 1);
          },
        },
        Ws("roundProps", Os),
        Ws("modifiers"),
        Ws("snap", ga)
      ) || Cn;
  (Me.version = mt.version = vt.version = "3.12.2"),
    (Jo = 1),
    _s() && pi(),
    te.Power0,
    te.Power1,
    te.Power2,
    te.Power3,
    te.Power4,
    te.Linear,
    te.Quad,
    te.Cubic,
    te.Quart,
    te.Quint,
    te.Strong,
    te.Elastic,
    te.Back,
    te.SteppedEase,
    te.Bounce,
    te.Sine,
    te.Expo,
    te.Circ;
  /*!
   * CSSPlugin 3.12.2
   * https://greensock.com
   *
   * Copyright 2008-2023, GreenSock. All rights reserved.
   * Subject to the terms at https://greensock.com/standard-license or for
   * Club GreenSock members, the agreement issued with that membership.
   * @author: Jack Doyle, jack@greensock.com
   */ var $a,
    xr,
    _i,
    Ys,
    Wr,
    Wa,
    Xs,
    Lu = function () {
      return typeof window != "undefined";
    },
    ur = {},
    Yr = 180 / Math.PI,
    mi = Math.PI / 180,
    gi = Math.atan2,
    Ya = 1e8,
    Vs = /([A-Z])/g,
    Mu = /(left|right|width|margin|padding|x)/i,
    zu = /[\s,\(]\S/,
    er = {
      autoAlpha: "opacity,visibility",
      scale: "scaleX,scaleY",
      alpha: "opacity",
    },
    Us = function (e, r) {
      return r.set(r.t, r.p, Math.round((r.s + r.c * e) * 1e4) / 1e4 + r.u, r);
    },
    Du = function (e, r) {
      return r.set(
        r.t,
        r.p,
        e === 1 ? r.e : Math.round((r.s + r.c * e) * 1e4) / 1e4 + r.u,
        r
      );
    },
    Ru = function (e, r) {
      return r.set(
        r.t,
        r.p,
        e ? Math.round((r.s + r.c * e) * 1e4) / 1e4 + r.u : r.b,
        r
      );
    },
    Nu = function (e, r) {
      var t = r.s + r.c * e;
      r.set(r.t, r.p, ~~(t + (t < 0 ? -0.5 : 0.5)) + r.u, r);
    },
    Xa = function (e, r) {
      return r.set(r.t, r.p, e ? r.e : r.b, r);
    },
    Va = function (e, r) {
      return r.set(r.t, r.p, e !== 1 ? r.b : r.e, r);
    },
    qu = function (e, r, t) {
      return (e.style[r] = t);
    },
    Iu = function (e, r, t) {
      return e.style.setProperty(r, t);
    },
    Fu = function (e, r, t) {
      return (e._gsap[r] = t);
    },
    Bu = function (e, r, t) {
      return (e._gsap.scaleX = e._gsap.scaleY = t);
    },
    $u = function (e, r, t, i, n) {
      var o = e._gsap;
      (o.scaleX = o.scaleY = t), o.renderTransform(n, o);
    },
    Wu = function (e, r, t, i, n) {
      var o = e._gsap;
      (o[r] = t), o.renderTransform(n, o);
    },
    be = "transform",
    Wt = be + "Origin",
    Yu = function s(e, r) {
      var t = this,
        i = this.target,
        n = i.style;
      if (e in ur && n) {
        if (((this.tfm = this.tfm || {}), e !== "transform"))
          (e = er[e] || e),
            ~e.indexOf(",")
              ? e.split(",").forEach(function (o) {
                  return (t.tfm[o] = fr(i, o));
                })
              : (this.tfm[e] = i._gsap.x ? i._gsap[e] : fr(i, e));
        else
          return er.transform.split(",").forEach(function (o) {
            return s.call(t, o, r);
          });
        if (this.props.indexOf(be) >= 0) return;
        i._gsap.svg &&
          ((this.svgo = i.getAttribute("data-svg-origin")),
          this.props.push(Wt, r, "")),
          (e = be);
      }
      (n || r) && this.props.push(e, r, n[e]);
    },
    Ua = function (e) {
      e.translate &&
        (e.removeProperty("translate"),
        e.removeProperty("scale"),
        e.removeProperty("rotate"));
    },
    Xu = function () {
      var e = this.props,
        r = this.target,
        t = r.style,
        i = r._gsap,
        n,
        o;
      for (n = 0; n < e.length; n += 3)
        e[n + 1]
          ? (r[e[n]] = e[n + 2])
          : e[n + 2]
          ? (t[e[n]] = e[n + 2])
          : t.removeProperty(
              e[n].substr(0, 2) === "--"
                ? e[n]
                : e[n].replace(Vs, "-$1").toLowerCase()
            );
      if (this.tfm) {
        for (o in this.tfm) i[o] = this.tfm[o];
        i.svg &&
          (i.renderTransform(),
          r.setAttribute("data-svg-origin", this.svgo || "")),
          (n = Xs()),
          (!n || !n.isStart) && !t[be] && (Ua(t), (i.uncache = 1));
      }
    },
    Ha = function (e, r) {
      var t = { target: e, props: [], revert: Xu, save: Yu };
      return (
        e._gsap || vt.core.getCache(e),
        r &&
          r.split(",").forEach(function (i) {
            return t.save(i);
          }),
        t
      );
    },
    ja,
    Hs = function (e, r) {
      var t = xr.createElementNS
        ? xr.createElementNS(
            (r || "http://www.w3.org/1999/xhtml").replace(/^https/, "http"),
            e
          )
        : xr.createElement(e);
      return t.style ? t : xr.createElement(e);
    },
    tr = function s(e, r, t) {
      var i = getComputedStyle(e);
      return (
        i[r] ||
        i.getPropertyValue(r.replace(Vs, "-$1").toLowerCase()) ||
        i.getPropertyValue(r) ||
        (!t && s(e, vi(r) || r, 1)) ||
        ""
      );
    },
    Ga = "O,Moz,ms,Ms,Webkit".split(","),
    vi = function (e, r, t) {
      var i = r || Wr,
        n = i.style,
        o = 5;
      if (e in n && !t) return e;
      for (
        e = e.charAt(0).toUpperCase() + e.substr(1);
        o-- && !(Ga[o] + e in n);

      );
      return o < 0 ? null : (o === 3 ? "ms" : o >= 0 ? Ga[o] : "") + e;
    },
    js = function () {
      Lu() &&
        window.document &&
        (($a = window),
        (xr = $a.document),
        (_i = xr.documentElement),
        (Wr = Hs("div") || { style: {} }),
        Hs("div"),
        (be = vi(be)),
        (Wt = be + "Origin"),
        (Wr.style.cssText =
          "border-width:0;line-height:0;position:absolute;padding:0"),
        (ja = !!vi("perspective")),
        (Xs = vt.core.reverting),
        (Ys = 1));
    },
    Gs = function s(e) {
      var r = Hs(
          "svg",
          (this.ownerSVGElement &&
            this.ownerSVGElement.getAttribute("xmlns")) ||
            "http://www.w3.org/2000/svg"
        ),
        t = this.parentNode,
        i = this.nextSibling,
        n = this.style.cssText,
        o;
      if (
        (_i.appendChild(r),
        r.appendChild(this),
        (this.style.display = "block"),
        e)
      )
        try {
          (o = this.getBBox()),
            (this._gsapBBox = this.getBBox),
            (this.getBBox = s);
        } catch {}
      else this._gsapBBox && (o = this._gsapBBox());
      return (
        t && (i ? t.insertBefore(this, i) : t.appendChild(this)),
        _i.removeChild(r),
        (this.style.cssText = n),
        o
      );
    },
    Ka = function (e, r) {
      for (var t = r.length; t--; )
        if (e.hasAttribute(r[t])) return e.getAttribute(r[t]);
    },
    Qa = function (e) {
      var r;
      try {
        r = e.getBBox();
      } catch {
        r = Gs.call(e, !0);
      }
      return (
        (r && (r.width || r.height)) ||
          e.getBBox === Gs ||
          (r = Gs.call(e, !0)),
        r && !r.width && !r.x && !r.y
          ? {
              x: +Ka(e, ["x", "cx", "x1"]) || 0,
              y: +Ka(e, ["y", "cy", "y1"]) || 0,
              width: 0,
              height: 0,
            }
          : r
      );
    },
    Ja = function (e) {
      return !!(e.getCTM && (!e.parentNode || e.ownerSVGElement) && Qa(e));
    },
    Yi = function (e, r) {
      if (r) {
        var t = e.style;
        r in ur && r !== Wt && (r = be),
          t.removeProperty
            ? ((r.substr(0, 2) === "ms" || r.substr(0, 6) === "webkit") &&
                (r = "-" + r),
              t.removeProperty(r.replace(Vs, "-$1").toLowerCase()))
            : t.removeAttribute(r);
      }
    },
    Tr = function (e, r, t, i, n, o) {
      var a = new gt(e._pt, r, t, 0, 1, o ? Va : Xa);
      return (e._pt = a), (a.b = i), (a.e = n), e._props.push(t), a;
    },
    Za = { deg: 1, rad: 1, turn: 1 },
    Vu = { grid: 1, flex: 1 },
    Er = function s(e, r, t, i) {
      var n = parseFloat(t) || 0,
        o = (t + "").trim().substr((n + "").length) || "px",
        a = Wr.style,
        l = Mu.test(r),
        c = e.tagName.toLowerCase() === "svg",
        u = (c ? "client" : "offset") + (l ? "Width" : "Height"),
        _ = 100,
        p = i === "px",
        f = i === "%",
        m,
        h,
        v,
        T;
      return i === o || !n || Za[i] || Za[o]
        ? n
        : (o !== "px" && !p && (n = s(e, r, t, "px")),
          (T = e.getCTM && Ja(e)),
          (f || o === "%") && (ur[r] || ~r.indexOf("adius"))
            ? ((m = T ? e.getBBox()[l ? "width" : "height"] : e[u]),
              Pe(f ? (n / m) * _ : (n / 100) * m))
            : ((a[l ? "width" : "height"] = _ + (p ? o : i)),
              (h =
                ~r.indexOf("adius") || (i === "em" && e.appendChild && !c)
                  ? e
                  : e.parentNode),
              T && (h = (e.ownerSVGElement || {}).parentNode),
              (!h || h === xr || !h.appendChild) && (h = xr.body),
              (v = h._gsap),
              v && f && v.width && l && v.time === Tt.time && !v.uncache
                ? Pe((n / v.width) * _)
                : ((f || o === "%") &&
                    !Vu[tr(h, "display")] &&
                    (a.position = tr(e, "position")),
                  h === e && (a.position = "static"),
                  h.appendChild(Wr),
                  (m = Wr[u]),
                  h.removeChild(Wr),
                  (a.position = "absolute"),
                  l && f && ((v = Nr(h)), (v.time = Tt.time), (v.width = h[u])),
                  Pe(p ? (m * n) / _ : m && n ? (_ / m) * n : 0))));
    },
    fr = function (e, r, t, i) {
      var n;
      return (
        Ys || js(),
        r in er &&
          r !== "transform" &&
          ((r = er[r]), ~r.indexOf(",") && (r = r.split(",")[0])),
        ur[r] && r !== "transform"
          ? ((n = Vi(e, i)),
            (n =
              r !== "transformOrigin"
                ? n[r]
                : n.svg
                ? n.origin
                : Pn(tr(e, Wt)) + " " + n.zOrigin + "px"))
          : ((n = e.style[r]),
            (!n || n === "auto" || i || ~(n + "").indexOf("calc(")) &&
              (n =
                (An[r] && An[r](e, r, t)) ||
                tr(e, r) ||
                ia(e, r) ||
                (r === "opacity" ? 1 : 0))),
        t && !~(n + "").trim().indexOf(" ") ? Er(e, r, n, t) + t : n
      );
    },
    Uu = function (e, r, t, i) {
      if (!t || t === "none") {
        var n = vi(r, e, 1),
          o = n && tr(e, n, 1);
        o && o !== t
          ? ((r = n), (t = o))
          : r === "borderColor" && (t = tr(e, "borderTopColor"));
      }
      var a = new gt(this._pt, e.style, r, 0, 1, qa),
        l = 0,
        c = 0,
        u,
        _,
        p,
        f,
        m,
        h,
        v,
        T,
        E,
        P,
        g,
        y;
      if (
        ((a.b = t),
        (a.e = i),
        (t += ""),
        (i += ""),
        i === "auto" &&
          ((e.style[r] = i), (i = tr(e, r) || i), (e.style[r] = t)),
        (u = [t, i]),
        Ca(u),
        (t = u[0]),
        (i = u[1]),
        (p = t.match(ci) || []),
        (y = i.match(ci) || []),
        y.length)
      ) {
        for (; (_ = ci.exec(i)); )
          (v = _[0]),
            (E = i.substring(l, _.index)),
            m
              ? (m = (m + 1) % 5)
              : (E.substr(-5) === "rgba(" || E.substr(-5) === "hsla(") &&
                (m = 1),
            v !== (h = p[c++] || "") &&
              ((f = parseFloat(h) || 0),
              (g = h.substr((f + "").length)),
              v.charAt(1) === "=" && (v = ui(f, v) + g),
              (T = parseFloat(v)),
              (P = v.substr((T + "").length)),
              (l = ci.lastIndex - P.length),
              P ||
                ((P = P || wt.units[r] || g),
                l === i.length && ((i += P), (a.e += P))),
              g !== P && (f = Er(e, r, h, P) || 0),
              (a._pt = {
                _next: a._pt,
                p: E || c === 1 ? E : ",",
                s: f,
                c: T - f,
                m: (m && m < 4) || r === "zIndex" ? Math.round : 0,
              }));
        a.c = l < i.length ? i.substring(l, i.length) : "";
      } else a.r = r === "display" && i === "none" ? Va : Xa;
      return Ko.test(i) && (a.e = 0), (this._pt = a), a;
    },
    el = {
      top: "0%",
      bottom: "100%",
      left: "0%",
      right: "100%",
      center: "50%",
    },
    Hu = function (e) {
      var r = e.split(" "),
        t = r[0],
        i = r[1] || "50%";
      return (
        (t === "top" || t === "bottom" || i === "left" || i === "right") &&
          ((e = t), (t = i), (i = e)),
        (r[0] = el[t] || t),
        (r[1] = el[i] || i),
        r.join(" ")
      );
    },
    ju = function (e, r) {
      if (r.tween && r.tween._time === r.tween._dur) {
        var t = r.t,
          i = t.style,
          n = r.u,
          o = t._gsap,
          a,
          l,
          c;
        if (n === "all" || n === !0) (i.cssText = ""), (l = 1);
        else
          for (n = n.split(","), c = n.length; --c > -1; )
            (a = n[c]),
              ur[a] && ((l = 1), (a = a === "transformOrigin" ? Wt : be)),
              Yi(t, a);
        l &&
          (Yi(t, be),
          o &&
            (o.svg && t.removeAttribute("transform"),
            Vi(t, 1),
            (o.uncache = 1),
            Ua(i)));
      }
    },
    An = {
      clearProps: function (e, r, t, i, n) {
        if (n.data !== "isFromStart") {
          var o = (e._pt = new gt(e._pt, r, t, 0, 0, ju));
          return (o.u = i), (o.pr = -10), (o.tween = n), e._props.push(t), 1;
        }
      },
    },
    Xi = [1, 0, 0, 1, 0, 0],
    tl = {},
    rl = function (e) {
      return e === "matrix(1, 0, 0, 1, 0, 0)" || e === "none" || !e;
    },
    il = function (e) {
      var r = tr(e, be);
      return rl(r) ? Xi : r.substr(7).match(Go).map(Pe);
    },
    Ks = function (e, r) {
      var t = e._gsap || Nr(e),
        i = e.style,
        n = il(e),
        o,
        a,
        l,
        c;
      return t.svg && e.getAttribute("transform")
        ? ((l = e.transform.baseVal.consolidate().matrix),
          (n = [l.a, l.b, l.c, l.d, l.e, l.f]),
          n.join(",") === "1,0,0,1,0,0" ? Xi : n)
        : (n === Xi &&
            !e.offsetParent &&
            e !== _i &&
            !t.svg &&
            ((l = i.display),
            (i.display = "block"),
            (o = e.parentNode),
            (!o || !e.offsetParent) &&
              ((c = 1), (a = e.nextElementSibling), _i.appendChild(e)),
            (n = il(e)),
            l ? (i.display = l) : Yi(e, "display"),
            c &&
              (a
                ? o.insertBefore(e, a)
                : o
                ? o.appendChild(e)
                : _i.removeChild(e))),
          r && n.length > 6 ? [n[0], n[1], n[4], n[5], n[12], n[13]] : n);
    },
    Qs = function (e, r, t, i, n, o) {
      var a = e._gsap,
        l = n || Ks(e, !0),
        c = a.xOrigin || 0,
        u = a.yOrigin || 0,
        _ = a.xOffset || 0,
        p = a.yOffset || 0,
        f = l[0],
        m = l[1],
        h = l[2],
        v = l[3],
        T = l[4],
        E = l[5],
        P = r.split(" "),
        g = parseFloat(P[0]) || 0,
        y = parseFloat(P[1]) || 0,
        w,
        S,
        A,
        C;
      t
        ? l !== Xi &&
          (S = f * v - m * h) &&
          ((A = g * (v / S) + y * (-h / S) + (h * E - v * T) / S),
          (C = g * (-m / S) + y * (f / S) - (f * E - m * T) / S),
          (g = A),
          (y = C))
        : ((w = Qa(e)),
          (g = w.x + (~P[0].indexOf("%") ? (g / 100) * w.width : g)),
          (y =
            w.y + (~(P[1] || P[0]).indexOf("%") ? (y / 100) * w.height : y))),
        i || (i !== !1 && a.smooth)
          ? ((T = g - c),
            (E = y - u),
            (a.xOffset = _ + (T * f + E * h) - T),
            (a.yOffset = p + (T * m + E * v) - E))
          : (a.xOffset = a.yOffset = 0),
        (a.xOrigin = g),
        (a.yOrigin = y),
        (a.smooth = !!i),
        (a.origin = r),
        (a.originIsAbsolute = !!t),
        (e.style[Wt] = "0px 0px"),
        o &&
          (Tr(o, a, "xOrigin", c, g),
          Tr(o, a, "yOrigin", u, y),
          Tr(o, a, "xOffset", _, a.xOffset),
          Tr(o, a, "yOffset", p, a.yOffset)),
        e.setAttribute("data-svg-origin", g + " " + y);
    },
    Vi = function (e, r) {
      var t = e._gsap || new La(e);
      if ("x" in t && !r && !t.uncache) return t;
      var i = e.style,
        n = t.scaleX < 0,
        o = "px",
        a = "deg",
        l = getComputedStyle(e),
        c = tr(e, Wt) || "0",
        u,
        _,
        p,
        f,
        m,
        h,
        v,
        T,
        E,
        P,
        g,
        y,
        w,
        S,
        A,
        C,
        L,
        z,
        x,
        H,
        q,
        B,
        U,
        F,
        G,
        Q,
        b,
        le,
        Re,
        rt,
        de,
        Ce;
      return (
        (u = _ = p = h = v = T = E = P = g = 0),
        (f = m = 1),
        (t.svg = !!(e.getCTM && Ja(e))),
        l.translate &&
          ((l.translate !== "none" ||
            l.scale !== "none" ||
            l.rotate !== "none") &&
            (i[be] =
              (l.translate !== "none"
                ? "translate3d(" +
                  (l.translate + " 0 0").split(" ").slice(0, 3).join(", ") +
                  ") "
                : "") +
              (l.rotate !== "none" ? "rotate(" + l.rotate + ") " : "") +
              (l.scale !== "none"
                ? "scale(" + l.scale.split(" ").join(",") + ") "
                : "") +
              (l[be] !== "none" ? l[be] : "")),
          (i.scale = i.rotate = i.translate = "none")),
        (S = Ks(e, t.svg)),
        t.svg &&
          (t.uncache
            ? ((G = e.getBBox()),
              (c = t.xOrigin - G.x + "px " + (t.yOrigin - G.y) + "px"),
              (F = ""))
            : (F = !r && e.getAttribute("data-svg-origin")),
          Qs(e, F || c, !!F || t.originIsAbsolute, t.smooth !== !1, S)),
        (y = t.xOrigin || 0),
        (w = t.yOrigin || 0),
        S !== Xi &&
          ((z = S[0]),
          (x = S[1]),
          (H = S[2]),
          (q = S[3]),
          (u = B = S[4]),
          (_ = U = S[5]),
          S.length === 6
            ? ((f = Math.sqrt(z * z + x * x)),
              (m = Math.sqrt(q * q + H * H)),
              (h = z || x ? gi(x, z) * Yr : 0),
              (E = H || q ? gi(H, q) * Yr + h : 0),
              E && (m *= Math.abs(Math.cos(E * mi))),
              t.svg && ((u -= y - (y * z + w * H)), (_ -= w - (y * x + w * q))))
            : ((Ce = S[6]),
              (rt = S[7]),
              (b = S[8]),
              (le = S[9]),
              (Re = S[10]),
              (de = S[11]),
              (u = S[12]),
              (_ = S[13]),
              (p = S[14]),
              (A = gi(Ce, Re)),
              (v = A * Yr),
              A &&
                ((C = Math.cos(-A)),
                (L = Math.sin(-A)),
                (F = B * C + b * L),
                (G = U * C + le * L),
                (Q = Ce * C + Re * L),
                (b = B * -L + b * C),
                (le = U * -L + le * C),
                (Re = Ce * -L + Re * C),
                (de = rt * -L + de * C),
                (B = F),
                (U = G),
                (Ce = Q)),
              (A = gi(-H, Re)),
              (T = A * Yr),
              A &&
                ((C = Math.cos(-A)),
                (L = Math.sin(-A)),
                (F = z * C - b * L),
                (G = x * C - le * L),
                (Q = H * C - Re * L),
                (de = q * L + de * C),
                (z = F),
                (x = G),
                (H = Q)),
              (A = gi(x, z)),
              (h = A * Yr),
              A &&
                ((C = Math.cos(A)),
                (L = Math.sin(A)),
                (F = z * C + x * L),
                (G = B * C + U * L),
                (x = x * C - z * L),
                (U = U * C - B * L),
                (z = F),
                (B = G)),
              v &&
                Math.abs(v) + Math.abs(h) > 359.9 &&
                ((v = h = 0), (T = 180 - T)),
              (f = Pe(Math.sqrt(z * z + x * x + H * H))),
              (m = Pe(Math.sqrt(U * U + Ce * Ce))),
              (A = gi(B, U)),
              (E = Math.abs(A) > 2e-4 ? A * Yr : 0),
              (g = de ? 1 / (de < 0 ? -de : de) : 0)),
          t.svg &&
            ((F = e.getAttribute("transform")),
            (t.forceCSS = e.setAttribute("transform", "") || !rl(tr(e, be))),
            F && e.setAttribute("transform", F))),
        Math.abs(E) > 90 &&
          Math.abs(E) < 270 &&
          (n
            ? ((f *= -1),
              (E += h <= 0 ? 180 : -180),
              (h += h <= 0 ? 180 : -180))
            : ((m *= -1), (E += E <= 0 ? 180 : -180))),
        (r = r || t.uncache),
        (t.x =
          u -
          ((t.xPercent =
            u &&
            ((!r && t.xPercent) ||
              (Math.round(e.offsetWidth / 2) === Math.round(-u) ? -50 : 0)))
            ? (e.offsetWidth * t.xPercent) / 100
            : 0) +
          o),
        (t.y =
          _ -
          ((t.yPercent =
            _ &&
            ((!r && t.yPercent) ||
              (Math.round(e.offsetHeight / 2) === Math.round(-_) ? -50 : 0)))
            ? (e.offsetHeight * t.yPercent) / 100
            : 0) +
          o),
        (t.z = p + o),
        (t.scaleX = Pe(f)),
        (t.scaleY = Pe(m)),
        (t.rotation = Pe(h) + a),
        (t.rotationX = Pe(v) + a),
        (t.rotationY = Pe(T) + a),
        (t.skewX = E + a),
        (t.skewY = P + a),
        (t.transformPerspective = g + o),
        (t.zOrigin = parseFloat(c.split(" ")[2]) || 0) && (i[Wt] = Pn(c)),
        (t.xOffset = t.yOffset = 0),
        (t.force3D = wt.force3D),
        (t.renderTransform = t.svg ? Ku : ja ? nl : Gu),
        (t.uncache = 0),
        t
      );
    },
    Pn = function (e) {
      return (e = e.split(" "))[0] + " " + e[1];
    },
    Js = function (e, r, t) {
      var i = et(r);
      return Pe(parseFloat(r) + parseFloat(Er(e, "x", t + "px", i))) + i;
    },
    Gu = function (e, r) {
      (r.z = "0px"),
        (r.rotationY = r.rotationX = "0deg"),
        (r.force3D = 0),
        nl(e, r);
    },
    Xr = "0deg",
    Ui = "0px",
    Vr = ") ",
    nl = function (e, r) {
      var t = r || this,
        i = t.xPercent,
        n = t.yPercent,
        o = t.x,
        a = t.y,
        l = t.z,
        c = t.rotation,
        u = t.rotationY,
        _ = t.rotationX,
        p = t.skewX,
        f = t.skewY,
        m = t.scaleX,
        h = t.scaleY,
        v = t.transformPerspective,
        T = t.force3D,
        E = t.target,
        P = t.zOrigin,
        g = "",
        y = (T === "auto" && e && e !== 1) || T === !0;
      if (P && (_ !== Xr || u !== Xr)) {
        var w = parseFloat(u) * mi,
          S = Math.sin(w),
          A = Math.cos(w),
          C;
        (w = parseFloat(_) * mi),
          (C = Math.cos(w)),
          (o = Js(E, o, S * C * -P)),
          (a = Js(E, a, -Math.sin(w) * -P)),
          (l = Js(E, l, A * C * -P + P));
      }
      v !== Ui && (g += "perspective(" + v + Vr),
        (i || n) && (g += "translate(" + i + "%, " + n + "%) "),
        (y || o !== Ui || a !== Ui || l !== Ui) &&
          (g +=
            l !== Ui || y
              ? "translate3d(" + o + ", " + a + ", " + l + ") "
              : "translate(" + o + ", " + a + Vr),
        c !== Xr && (g += "rotate(" + c + Vr),
        u !== Xr && (g += "rotateY(" + u + Vr),
        _ !== Xr && (g += "rotateX(" + _ + Vr),
        (p !== Xr || f !== Xr) && (g += "skew(" + p + ", " + f + Vr),
        (m !== 1 || h !== 1) && (g += "scale(" + m + ", " + h + Vr),
        (E.style[be] = g || "translate(0, 0)");
    },
    Ku = function (e, r) {
      var t = r || this,
        i = t.xPercent,
        n = t.yPercent,
        o = t.x,
        a = t.y,
        l = t.rotation,
        c = t.skewX,
        u = t.skewY,
        _ = t.scaleX,
        p = t.scaleY,
        f = t.target,
        m = t.xOrigin,
        h = t.yOrigin,
        v = t.xOffset,
        T = t.yOffset,
        E = t.forceCSS,
        P = parseFloat(o),
        g = parseFloat(a),
        y,
        w,
        S,
        A,
        C;
      (l = parseFloat(l)),
        (c = parseFloat(c)),
        (u = parseFloat(u)),
        u && ((u = parseFloat(u)), (c += u), (l += u)),
        l || c
          ? ((l *= mi),
            (c *= mi),
            (y = Math.cos(l) * _),
            (w = Math.sin(l) * _),
            (S = Math.sin(l - c) * -p),
            (A = Math.cos(l - c) * p),
            c &&
              ((u *= mi),
              (C = Math.tan(c - u)),
              (C = Math.sqrt(1 + C * C)),
              (S *= C),
              (A *= C),
              u &&
                ((C = Math.tan(u)),
                (C = Math.sqrt(1 + C * C)),
                (y *= C),
                (w *= C))),
            (y = Pe(y)),
            (w = Pe(w)),
            (S = Pe(S)),
            (A = Pe(A)))
          : ((y = _), (A = p), (w = S = 0)),
        ((P && !~(o + "").indexOf("px")) || (g && !~(a + "").indexOf("px"))) &&
          ((P = Er(f, "x", o, "px")), (g = Er(f, "y", a, "px"))),
        (m || h || v || T) &&
          ((P = Pe(P + m - (m * y + h * S) + v)),
          (g = Pe(g + h - (m * w + h * A) + T))),
        (i || n) &&
          ((C = f.getBBox()),
          (P = Pe(P + (i / 100) * C.width)),
          (g = Pe(g + (n / 100) * C.height))),
        (C =
          "matrix(" +
          y +
          "," +
          w +
          "," +
          S +
          "," +
          A +
          "," +
          P +
          "," +
          g +
          ")"),
        f.setAttribute("transform", C),
        E && (f.style[be] = C);
    },
    Qu = function (e, r, t, i, n) {
      var o = 360,
        a = Be(n),
        l = parseFloat(n) * (a && ~n.indexOf("rad") ? Yr : 1),
        c = l - i,
        u = i + c + "deg",
        _,
        p;
      return (
        a &&
          ((_ = n.split("_")[1]),
          _ === "short" &&
            ((c %= o), c !== c % (o / 2) && (c += c < 0 ? o : -o)),
          _ === "cw" && c < 0
            ? (c = ((c + o * Ya) % o) - ~~(c / o) * o)
            : _ === "ccw" && c > 0 && (c = ((c - o * Ya) % o) - ~~(c / o) * o)),
        (e._pt = p = new gt(e._pt, r, t, i, c, Du)),
        (p.e = u),
        (p.u = "deg"),
        e._props.push(t),
        p
      );
    },
    sl = function (e, r) {
      for (var t in r) e[t] = r[t];
      return e;
    },
    Ju = function (e, r, t) {
      var i = sl({}, t._gsap),
        n = "perspective,force3D,transformOrigin,svgOrigin",
        o = t.style,
        a,
        l,
        c,
        u,
        _,
        p,
        f,
        m;
      i.svg
        ? ((c = t.getAttribute("transform")),
          t.setAttribute("transform", ""),
          (o[be] = r),
          (a = Vi(t, 1)),
          Yi(t, be),
          t.setAttribute("transform", c))
        : ((c = getComputedStyle(t)[be]),
          (o[be] = r),
          (a = Vi(t, 1)),
          (o[be] = c));
      for (l in ur)
        (c = i[l]),
          (u = a[l]),
          c !== u &&
            n.indexOf(l) < 0 &&
            ((f = et(c)),
            (m = et(u)),
            (_ = f !== m ? Er(t, l, c, m) : parseFloat(c)),
            (p = parseFloat(u)),
            (e._pt = new gt(e._pt, a, l, _, p - _, Us)),
            (e._pt.u = m || 0),
            e._props.push(l));
      sl(a, i);
    };
  _t("padding,margin,Width,Radius", function (s, e) {
    var r = "Top",
      t = "Right",
      i = "Bottom",
      n = "Left",
      o = (e < 3 ? [r, t, i, n] : [r + n, r + t, i + t, i + n]).map(function (
        a
      ) {
        return e < 2 ? s + a : "border" + a + s;
      });
    An[e > 1 ? "border" + s : s] = function (a, l, c, u, _) {
      var p, f;
      if (arguments.length < 4)
        return (
          (p = o.map(function (m) {
            return fr(a, m, c);
          })),
          (f = p.join(" ")),
          f.split(p[0]).length === 5 ? p[0] : f
        );
      (p = (u + "").split(" ")),
        (f = {}),
        o.forEach(function (m, h) {
          return (f[m] = p[h] = p[h] || p[((h - 1) / 2) | 0]);
        }),
        a.init(l, f, _);
    };
  });
  var ol = {
    name: "css",
    register: js,
    targetTest: function (e) {
      return e.style && e.nodeType;
    },
    init: function (e, r, t, i, n) {
      var o = this._props,
        a = e.style,
        l = t.vars.startAt,
        c,
        u,
        _,
        p,
        f,
        m,
        h,
        v,
        T,
        E,
        P,
        g,
        y,
        w,
        S,
        A;
      Ys || js(),
        (this.styles = this.styles || Ha(e)),
        (A = this.styles.props),
        (this.tween = t);
      for (h in r)
        if (
          h !== "autoRound" &&
          ((u = r[h]), !(xt[h] && Ma(h, r, t, i, e, n)))
        ) {
          if (
            ((f = typeof u),
            (m = An[h]),
            f === "function" && ((u = u.call(t, i, e, n)), (f = typeof u)),
            f === "string" && ~u.indexOf("random(") && (u = qi(u)),
            m)
          )
            m(this, e, h, u, t) && (S = 1);
          else if (h.substr(0, 2) === "--")
            (c = (getComputedStyle(e).getPropertyValue(h) + "").trim()),
              (u += ""),
              (wr.lastIndex = 0),
              wr.test(c) || ((v = et(c)), (T = et(u))),
              T ? v !== T && (c = Er(e, h, c, T) + T) : v && (u += v),
              this.add(a, "setProperty", c, u, i, n, 0, 0, h),
              o.push(h),
              A.push(h, 0, a[h]);
          else if (f !== "undefined") {
            if (
              (l && h in l
                ? ((c =
                    typeof l[h] == "function" ? l[h].call(t, i, e, n) : l[h]),
                  Be(c) && ~c.indexOf("random(") && (c = qi(c)),
                  et(c + "") || (c += wt.units[h] || et(fr(e, h)) || ""),
                  (c + "").charAt(1) === "=" && (c = fr(e, h)))
                : (c = fr(e, h)),
              (p = parseFloat(c)),
              (E = f === "string" && u.charAt(1) === "=" && u.substr(0, 2)),
              E && (u = u.substr(2)),
              (_ = parseFloat(u)),
              h in er &&
                (h === "autoAlpha" &&
                  (p === 1 && fr(e, "visibility") === "hidden" && _ && (p = 0),
                  A.push("visibility", 0, a.visibility),
                  Tr(
                    this,
                    a,
                    "visibility",
                    p ? "inherit" : "hidden",
                    _ ? "inherit" : "hidden",
                    !_
                  )),
                h !== "scale" &&
                  h !== "transform" &&
                  ((h = er[h]), ~h.indexOf(",") && (h = h.split(",")[0]))),
              (P = h in ur),
              P)
            ) {
              if (
                (this.styles.save(h),
                g ||
                  ((y = e._gsap),
                  (y.renderTransform && !r.parseTransform) ||
                    Vi(e, r.parseTransform),
                  (w = r.smoothOrigin !== !1 && y.smooth),
                  (g = this._pt =
                    new gt(this._pt, a, be, 0, 1, y.renderTransform, y, 0, -1)),
                  (g.dep = 1)),
                h === "scale")
              )
                (this._pt = new gt(
                  this._pt,
                  y,
                  "scaleY",
                  y.scaleY,
                  (E ? ui(y.scaleY, E + _) : _) - y.scaleY || 0,
                  Us
                )),
                  (this._pt.u = 0),
                  o.push("scaleY", h),
                  (h += "X");
              else if (h === "transformOrigin") {
                A.push(Wt, 0, a[Wt]),
                  (u = Hu(u)),
                  y.svg
                    ? Qs(e, u, 0, w, 0, this)
                    : ((T = parseFloat(u.split(" ")[2]) || 0),
                      T !== y.zOrigin && Tr(this, y, "zOrigin", y.zOrigin, T),
                      Tr(this, a, h, Pn(c), Pn(u)));
                continue;
              } else if (h === "svgOrigin") {
                Qs(e, u, 1, w, 0, this);
                continue;
              } else if (h in tl) {
                Qu(this, y, h, p, E ? ui(p, E + u) : u);
                continue;
              } else if (h === "smoothOrigin") {
                Tr(this, y, "smooth", y.smooth, u);
                continue;
              } else if (h === "force3D") {
                y[h] = u;
                continue;
              } else if (h === "transform") {
                Ju(this, u, e);
                continue;
              }
            } else h in a || (h = vi(h) || h);
            if (
              P ||
              ((_ || _ === 0) && (p || p === 0) && !zu.test(u) && h in a)
            )
              (v = (c + "").substr((p + "").length)),
                _ || (_ = 0),
                (T = et(u) || (h in wt.units ? wt.units[h] : v)),
                v !== T && (p = Er(e, h, c, T)),
                (this._pt = new gt(
                  this._pt,
                  P ? y : a,
                  h,
                  p,
                  (E ? ui(p, E + _) : _) - p,
                  !P && (T === "px" || h === "zIndex") && r.autoRound !== !1
                    ? Nu
                    : Us
                )),
                (this._pt.u = T || 0),
                v !== T && T !== "%" && ((this._pt.b = c), (this._pt.r = Ru));
            else if (h in a) Uu.call(this, e, h, c, E ? E + u : u);
            else if (h in e) this.add(e, h, c || e[h], E ? E + u : u, i, n);
            else if (h !== "parseTransform") {
              bs(h, u);
              continue;
            }
            P || (h in a ? A.push(h, 0, a[h]) : A.push(h, 1, c || e[h])),
              o.push(h);
          }
        }
      S && Ia(this);
    },
    render: function (e, r) {
      if (r.tween._time || !Xs())
        for (var t = r._pt; t; ) t.r(e, t.d), (t = t._next);
      else r.styles.revert();
    },
    get: fr,
    aliases: er,
    getSetter: function (e, r, t) {
      var i = er[r];
      return (
        i && i.indexOf(",") < 0 && (r = i),
        r in ur && r !== Wt && (e._gsap.x || fr(e, "x"))
          ? t && Wa === t
            ? r === "scale"
              ? Bu
              : Fu
            : (Wa = t || {}) && (r === "scale" ? $u : Wu)
          : e.style && !ps(e.style[r])
          ? qu
          : ~r.indexOf("-")
          ? Iu
          : Is(e, r)
      );
    },
    core: { _removeProperty: Yi, _getMatrix: Ks },
  };
  (vt.utils.checkPrefix = vi),
    (vt.core.getStyleSaver = Ha),
    (function (s, e, r, t) {
      var i = _t(s + "," + e + "," + r, function (n) {
        ur[n] = 1;
      });
      _t(e, function (n) {
        (wt.units[n] = "deg"), (tl[n] = 1);
      }),
        (er[i[13]] = s + "," + e),
        _t(t, function (n) {
          var o = n.split(":");
          er[o[1]] = i[o[0]];
        });
    })(
      "x,y,z,scale,scaleX,scaleY,xPercent,yPercent",
      "rotation,rotationX,rotationY,skewX,skewY",
      "transform,transformOrigin,svgOrigin,force3D,smoothOrigin,transformPerspective",
      "0:translateX,1:translateY,2:translateZ,8:rotate,8:rotationZ,8:rotateZ,9:rotateX,10:rotateY"
    ),
    _t(
      "x,y,z,top,right,bottom,left,width,height,fontSize,padding,margin,perspective",
      function (s) {
        wt.units[s] = "px";
      }
    ),
    vt.registerPlugin(ol);
  var qe = vt.registerPlugin(ol) || vt;
  qe.core.Tween;
  function al(s, e) {
    for (var r = 0; r < e.length; r++) {
      var t = e[r];
      (t.enumerable = t.enumerable || !1),
        (t.configurable = !0),
        "value" in t && (t.writable = !0),
        Object.defineProperty(
          s,
          typeof (i = (function (n, o) {
            if (typeof n != "object" || n === null) return n;
            var a = n[Symbol.toPrimitive];
            if (a !== void 0) {
              var l = a.call(n, "string");
              if (typeof l != "object") return l;
              throw new TypeError(
                "@@toPrimitive must return a primitive value."
              );
            }
            return String(n);
          })(t.key)) == "symbol"
            ? i
            : String(i),
          t
        );
    }
    var i;
  }
  function ll(s, e, r) {
    return (
      e && al(s.prototype, e),
      r && al(s, r),
      Object.defineProperty(s, "prototype", { writable: !1 }),
      s
    );
  }
  function Zs() {
    return (
      (Zs = Object.assign
        ? Object.assign.bind()
        : function (s) {
            for (var e = 1; e < arguments.length; e++) {
              var r = arguments[e];
              for (var t in r)
                Object.prototype.hasOwnProperty.call(r, t) && (s[t] = r[t]);
            }
            return s;
          }),
      Zs.apply(this, arguments)
    );
  }
  function On(s, e, r) {
    return Math.max(s, Math.min(e, r));
  }
  var Zu = (function () {
      function s() {}
      var e = s.prototype;
      return (
        (e.advance = function (r) {
          var t, i, n, o;
          if (this.isRunning) {
            var a = !1;
            if (this.lerp)
              (this.value =
                ((i = this.value),
                (n = this.to),
                (1 - (o = 1 - Math.exp(-60 * this.lerp * r))) * i + o * n)),
                Math.round(this.value) === this.to &&
                  ((this.value = this.to), (a = !0));
            else {
              this.currentTime += r;
              var l = On(0, this.currentTime / this.duration, 1),
                c = (a = l >= 1) ? 1 : this.easing(l);
              this.value = this.from + (this.to - this.from) * c;
            }
            (t = this.onUpdate) == null || t.call(this, this.value, a),
              a && this.stop();
          }
        }),
        (e.stop = function () {
          this.isRunning = !1;
        }),
        (e.fromTo = function (r, t, i) {
          var n = i.lerp,
            o = n === void 0 ? 0.1 : n,
            a = i.duration,
            l = a === void 0 ? 1 : a,
            c = i.easing,
            u =
              c === void 0
                ? function (f) {
                    return f;
                  }
                : c,
            _ = i.onStart,
            p = i.onUpdate;
          (this.from = this.value = r),
            (this.to = t),
            (this.lerp = o),
            (this.duration = l),
            (this.easing = u),
            (this.currentTime = 0),
            (this.isRunning = !0),
            _ == null || _(),
            (this.onUpdate = p);
        }),
        s
      );
    })(),
    ef = (function () {
      function s(e) {
        var r,
          t,
          i = this,
          n = e === void 0 ? {} : e,
          o = n.wrapper,
          a = n.content,
          l = n.autoResize,
          c = l === void 0 || l;
        if (
          ((this.resize = function () {
            i.onWrapperResize(), i.onContentResize();
          }),
          (this.onWrapperResize = function () {
            i.wrapper === window
              ? ((i.width = window.innerWidth), (i.height = window.innerHeight))
              : ((i.width = i.wrapper.clientWidth),
                (i.height = i.wrapper.clientHeight));
          }),
          (this.onContentResize = function () {
            (i.scrollHeight = i.content.scrollHeight),
              (i.scrollWidth = i.content.scrollWidth);
          }),
          (this.wrapper = o),
          (this.content = a),
          c)
        ) {
          var u =
            ((r = this.resize),
            function () {
              var _ = arguments,
                p = this;
              clearTimeout(t),
                (t = setTimeout(function () {
                  r.apply(p, _);
                }, 250));
            });
          this.wrapper !== window &&
            ((this.wrapperResizeObserver = new ResizeObserver(u)),
            this.wrapperResizeObserver.observe(this.wrapper)),
            (this.contentResizeObserver = new ResizeObserver(u)),
            this.contentResizeObserver.observe(this.content);
        }
        this.resize();
      }
      return (
        (s.prototype.destroy = function () {
          var e, r;
          (e = this.wrapperResizeObserver) == null || e.disconnect(),
            (r = this.contentResizeObserver) == null || r.disconnect();
        }),
        ll(s, [
          {
            key: "limit",
            get: function () {
              return {
                x: this.scrollWidth - this.width,
                y: this.scrollHeight - this.height,
              };
            },
          },
        ]),
        s
      );
    })(),
    cl = (function () {
      function s() {
        this.events = {};
      }
      var e = s.prototype;
      return (
        (e.emit = function (r) {
          for (var t = this.events[r] || [], i = 0, n = t.length; i < n; i++)
            t[i].apply(t, [].slice.call(arguments, 1));
        }),
        (e.on = function (r, t) {
          var i,
            n = this;
          return (
            ((i = this.events[r]) == null ? void 0 : i.push(t)) ||
              (this.events[r] = [t]),
            function () {
              var o;
              n.events[r] =
                (o = n.events[r]) == null
                  ? void 0
                  : o.filter(function (a) {
                      return t !== a;
                    });
            }
          );
        }),
        (e.off = function (r, t) {
          var i;
          this.events[r] =
            (i = this.events[r]) == null
              ? void 0
              : i.filter(function (n) {
                  return t !== n;
                });
        }),
        (e.destroy = function () {
          this.events = {};
        }),
        s
      );
    })(),
    tf = (function () {
      function s(r, t) {
        var i = this,
          n = t.wheelMultiplier,
          o = n === void 0 ? 1 : n,
          a = t.touchMultiplier,
          l = a === void 0 ? 2 : a,
          c = t.normalizeWheel,
          u = c !== void 0 && c;
        (this.onTouchStart = function (_) {
          var p = _.targetTouches ? _.targetTouches[0] : _,
            f = p.clientY;
          (i.touchStart.x = p.clientX),
            (i.touchStart.y = f),
            (i.lastDelta = { x: 0, y: 0 });
        }),
          (this.onTouchMove = function (_) {
            var p = _.targetTouches ? _.targetTouches[0] : _,
              f = p.clientX,
              m = p.clientY,
              h = -(f - i.touchStart.x) * i.touchMultiplier,
              v = -(m - i.touchStart.y) * i.touchMultiplier;
            (i.touchStart.x = f),
              (i.touchStart.y = m),
              (i.lastDelta = { x: h, y: v }),
              i.emitter.emit("scroll", { deltaX: h, deltaY: v, event: _ });
          }),
          (this.onTouchEnd = function (_) {
            i.emitter.emit("scroll", {
              deltaX: i.lastDelta.x,
              deltaY: i.lastDelta.y,
              event: _,
            });
          }),
          (this.onWheel = function (_) {
            var p = _.deltaX,
              f = _.deltaY;
            i.normalizeWheel &&
              ((p = On(-100, p, 100)), (f = On(-100, f, 100))),
              i.emitter.emit("scroll", {
                deltaX: (p *= i.wheelMultiplier),
                deltaY: (f *= i.wheelMultiplier),
                event: _,
              });
          }),
          (this.element = r),
          (this.wheelMultiplier = o),
          (this.touchMultiplier = l),
          (this.normalizeWheel = u),
          (this.touchStart = { x: null, y: null }),
          (this.emitter = new cl()),
          this.element.addEventListener("wheel", this.onWheel, { passive: !1 }),
          this.element.addEventListener("touchstart", this.onTouchStart, {
            passive: !1,
          }),
          this.element.addEventListener("touchmove", this.onTouchMove, {
            passive: !1,
          }),
          this.element.addEventListener("touchend", this.onTouchEnd, {
            passive: !1,
          });
      }
      var e = s.prototype;
      return (
        (e.on = function (r, t) {
          return this.emitter.on(r, t);
        }),
        (e.destroy = function () {
          this.emitter.destroy(),
            this.element.removeEventListener("wheel", this.onWheel, {
              passive: !1,
            }),
            this.element.removeEventListener("touchstart", this.onTouchStart, {
              passive: !1,
            }),
            this.element.removeEventListener("touchmove", this.onTouchMove, {
              passive: !1,
            }),
            this.element.removeEventListener("touchend", this.onTouchEnd, {
              passive: !1,
            });
        }),
        s
      );
    })(),
    ul = (function () {
      function s(r) {
        var t = this,
          i = r === void 0 ? {} : r,
          n = i.wrapper,
          o = n === void 0 ? window : n,
          a = i.content,
          l = a === void 0 ? document.documentElement : a,
          c = i.wheelEventsTarget,
          u = c === void 0 ? o : c,
          _ = i.eventsTarget,
          p = _ === void 0 ? u : _,
          f = i.smoothWheel,
          m = f === void 0 || f,
          h = i.smoothTouch,
          v = h !== void 0 && h,
          T = i.syncTouch,
          E = T !== void 0 && T,
          P = i.syncTouchLerp,
          g = P === void 0 ? 0.1 : P,
          y = i.__iosNoInertiaSyncTouchLerp,
          w = y === void 0 ? 0.4 : y,
          S = i.touchInertiaMultiplier,
          A = S === void 0 ? 35 : S,
          C = i.duration,
          L = i.easing,
          z =
            L === void 0
              ? function (me) {
                  return Math.min(1, 1.001 - Math.pow(2, -10 * me));
                }
              : L,
          x = i.lerp,
          H = x === void 0 ? !C && 0.1 : x,
          q = i.infinite,
          B = q !== void 0 && q,
          U = i.orientation,
          F = U === void 0 ? "vertical" : U,
          G = i.gestureOrientation,
          Q = G === void 0 ? "vertical" : G,
          b = i.touchMultiplier,
          le = b === void 0 ? 1 : b,
          Re = i.wheelMultiplier,
          rt = Re === void 0 ? 1 : Re,
          de = i.normalizeWheel,
          Ce = de !== void 0 && de,
          Ne = i.autoResize,
          _e = Ne === void 0 || Ne;
        (this.onVirtualScroll = function (me) {
          var ge = me.deltaX,
            Ye = me.deltaY,
            ve = me.event;
          if (!ve.ctrlKey) {
            var Xe = ve.type.includes("touch"),
              V = ve.type.includes("wheel");
            if (
              !(
                (t.options.gestureOrientation === "both" &&
                  ge === 0 &&
                  Ye === 0) ||
                (t.options.gestureOrientation === "vertical" && Ye === 0) ||
                (t.options.gestureOrientation === "horizontal" && ge === 0) ||
                (Xe &&
                  t.options.gestureOrientation === "vertical" &&
                  t.scroll === 0 &&
                  !t.options.infinite &&
                  Ye <= 0)
              )
            ) {
              var ce = ve.composedPath();
              if (
                !(ce = ce.slice(0, ce.indexOf(t.rootElement))).find(function (
                  O
                ) {
                  var M;
                  return (
                    (O.hasAttribute == null
                      ? void 0
                      : O.hasAttribute("data-lenis-prevent")) ||
                    (Xe &&
                      (O.hasAttribute == null
                        ? void 0
                        : O.hasAttribute("data-lenis-prevent-touch"))) ||
                    (V &&
                      (O.hasAttribute == null
                        ? void 0
                        : O.hasAttribute("data-lenis-prevent-wheel"))) ||
                    ((M = O.classList) == null ? void 0 : M.contains("lenis"))
                  );
                })
              )
                if (t.isStopped || t.isLocked) ve.preventDefault();
                else {
                  if (
                    ((t.isSmooth =
                      ((t.options.smoothTouch || t.options.syncTouch) && Xe) ||
                      (t.options.smoothWheel && V)),
                    !t.isSmooth)
                  )
                    return (t.isScrolling = !1), void t.animate.stop();
                  ve.preventDefault();
                  var Se = Ye;
                  t.options.gestureOrientation === "both"
                    ? (Se = Math.abs(Ye) > Math.abs(ge) ? Ye : ge)
                    : t.options.gestureOrientation === "horizontal" &&
                      (Se = ge);
                  var k = Xe && t.options.syncTouch,
                    d = Xe && ve.type === "touchend" && Math.abs(Se) > 1;
                  d && (Se = t.velocity * t.options.touchInertiaMultiplier),
                    t.scrollTo(
                      t.targetScroll + Se,
                      Zs(
                        { programmatic: !1 },
                        k && {
                          lerp: d
                            ? t.syncTouchLerp
                            : t.options.__iosNoInertiaSyncTouchLerp,
                        }
                      )
                    );
                }
            }
          }
        }),
          (this.onNativeScroll = function () {
            if (!t.__preventNextScrollEvent && !t.isScrolling) {
              var me = t.animatedScroll;
              (t.animatedScroll = t.targetScroll = t.actualScroll),
                (t.velocity = 0),
                (t.direction = Math.sign(t.animatedScroll - me)),
                t.emit();
            }
          }),
          (window.lenisVersion = "1.0.28"),
          (o !== document.documentElement && o !== document.body) ||
            (o = window),
          (this.options = {
            wrapper: o,
            content: l,
            wheelEventsTarget: u,
            eventsTarget: p,
            smoothWheel: m,
            smoothTouch: v,
            syncTouch: E,
            syncTouchLerp: g,
            __iosNoInertiaSyncTouchLerp: w,
            touchInertiaMultiplier: A,
            duration: C,
            easing: z,
            lerp: H,
            infinite: B,
            gestureOrientation: Q,
            orientation: F,
            touchMultiplier: le,
            wheelMultiplier: rt,
            normalizeWheel: Ce,
            autoResize: _e,
          }),
          (this.animate = new Zu()),
          (this.emitter = new cl()),
          (this.dimensions = new ef({
            wrapper: o,
            content: l,
            autoResize: _e,
          })),
          this.toggleClass("lenis", !0),
          (this.velocity = 0),
          (this.isLocked = !1),
          (this.isStopped = !1),
          (this.isSmooth = E || m || v),
          (this.isScrolling = !1),
          (this.targetScroll = this.animatedScroll = this.actualScroll),
          this.options.wrapper.addEventListener("scroll", this.onNativeScroll, {
            passive: !1,
          }),
          (this.virtualScroll = new tf(p, {
            touchMultiplier: le,
            wheelMultiplier: rt,
            normalizeWheel: Ce,
          })),
          this.virtualScroll.on("scroll", this.onVirtualScroll);
      }
      var e = s.prototype;
      return (
        (e.destroy = function () {
          this.emitter.destroy(),
            this.options.wrapper.removeEventListener(
              "scroll",
              this.onNativeScroll,
              { passive: !1 }
            ),
            this.virtualScroll.destroy(),
            this.dimensions.destroy(),
            this.toggleClass("lenis", !1),
            this.toggleClass("lenis-smooth", !1),
            this.toggleClass("lenis-scrolling", !1),
            this.toggleClass("lenis-stopped", !1),
            this.toggleClass("lenis-locked", !1);
        }),
        (e.on = function (r, t) {
          return this.emitter.on(r, t);
        }),
        (e.off = function (r, t) {
          return this.emitter.off(r, t);
        }),
        (e.setScroll = function (r) {
          this.isHorizontal
            ? (this.rootElement.scrollLeft = r)
            : (this.rootElement.scrollTop = r);
        }),
        (e.resize = function () {
          this.dimensions.resize();
        }),
        (e.emit = function () {
          this.emitter.emit("scroll", this);
        }),
        (e.reset = function () {
          (this.isLocked = !1),
            (this.isScrolling = !1),
            (this.animatedScroll = this.targetScroll = this.actualScroll),
            (this.velocity = 0),
            this.animate.stop();
        }),
        (e.start = function () {
          (this.isStopped = !1), this.reset();
        }),
        (e.stop = function () {
          (this.isStopped = !0), this.animate.stop(), this.reset();
        }),
        (e.raf = function (r) {
          var t = r - (this.time || r);
          (this.time = r), this.animate.advance(0.001 * t);
        }),
        (e.scrollTo = function (r, t) {
          var i = this,
            n = t === void 0 ? {} : t,
            o = n.offset,
            a = o === void 0 ? 0 : o,
            l = n.immediate,
            c = l !== void 0 && l,
            u = n.lock,
            _ = u !== void 0 && u,
            p = n.duration,
            f = p === void 0 ? this.options.duration : p,
            m = n.easing,
            h = m === void 0 ? this.options.easing : m,
            v = n.lerp,
            T = v === void 0 ? !f && this.options.lerp : v,
            E = n.onComplete,
            P = E === void 0 ? null : E,
            g = n.force,
            y = n.programmatic,
            w = y === void 0 || y;
          if ((!this.isStopped && !this.isLocked) || (g !== void 0 && g)) {
            if (["top", "left", "start"].includes(r)) r = 0;
            else if (["bottom", "right", "end"].includes(r)) r = this.limit;
            else {
              var S, A;
              if (
                (typeof r == "string"
                  ? (A = document.querySelector(r))
                  : (S = r) != null && S.nodeType && (A = r),
                A)
              ) {
                if (this.options.wrapper !== window) {
                  var C = this.options.wrapper.getBoundingClientRect();
                  a -= this.isHorizontal ? C.left : C.top;
                }
                var L = A.getBoundingClientRect();
                r = (this.isHorizontal ? L.left : L.top) + this.animatedScroll;
              }
            }
            if (typeof r == "number") {
              if (
                ((r += a),
                (r = Math.round(r)),
                this.options.infinite
                  ? w && (this.targetScroll = this.animatedScroll = this.scroll)
                  : (r = On(0, r, this.limit)),
                c)
              )
                return (
                  (this.animatedScroll = this.targetScroll = r),
                  this.setScroll(this.scroll),
                  this.reset(),
                  void (P == null || P(this))
                );
              if (!w) {
                if (r === this.targetScroll) return;
                this.targetScroll = r;
              }
              this.animate.fromTo(this.animatedScroll, r, {
                duration: f,
                easing: h,
                lerp: T,
                onStart: function () {
                  _ && (i.isLocked = !0), (i.isScrolling = !0);
                },
                onUpdate: function (z, x) {
                  (i.isScrolling = !0),
                    (i.velocity = z - i.animatedScroll),
                    (i.direction = Math.sign(i.velocity)),
                    (i.animatedScroll = z),
                    i.setScroll(i.scroll),
                    w && (i.targetScroll = z),
                    x || i.emit(),
                    x &&
                      (i.reset(),
                      i.emit(),
                      P == null || P(i),
                      (i.__preventNextScrollEvent = !0),
                      requestAnimationFrame(function () {
                        delete i.__preventNextScrollEvent;
                      }));
                },
              });
            }
          }
        }),
        (e.toggleClass = function (r, t) {
          this.rootElement.classList.toggle(r, t),
            this.emitter.emit("className change", this);
        }),
        ll(s, [
          {
            key: "rootElement",
            get: function () {
              return this.options.wrapper === window
                ? this.options.content
                : this.options.wrapper;
            },
          },
          {
            key: "limit",
            get: function () {
              return this.dimensions.limit[this.isHorizontal ? "x" : "y"];
            },
          },
          {
            key: "isHorizontal",
            get: function () {
              return this.options.orientation === "horizontal";
            },
          },
          {
            key: "actualScroll",
            get: function () {
              return this.isHorizontal
                ? this.rootElement.scrollLeft
                : this.rootElement.scrollTop;
            },
          },
          {
            key: "scroll",
            get: function () {
              return this.options.infinite
                ? ((this.animatedScroll % (r = this.limit)) + r) % r
                : this.animatedScroll;
              var r;
            },
          },
          {
            key: "progress",
            get: function () {
              return this.limit === 0 ? 1 : this.scroll / this.limit;
            },
          },
          {
            key: "isSmooth",
            get: function () {
              return this.__isSmooth;
            },
            set: function (r) {
              this.__isSmooth !== r &&
                ((this.__isSmooth = r), this.toggleClass("lenis-smooth", r));
            },
          },
          {
            key: "isScrolling",
            get: function () {
              return this.__isScrolling;
            },
            set: function (r) {
              this.__isScrolling !== r &&
                ((this.__isScrolling = r),
                this.toggleClass("lenis-scrolling", r));
            },
          },
          {
            key: "isStopped",
            get: function () {
              return this.__isStopped;
            },
            set: function (r) {
              this.__isStopped !== r &&
                ((this.__isStopped = r), this.toggleClass("lenis-stopped", r));
            },
          },
          {
            key: "isLocked",
            get: function () {
              return this.__isLocked;
            },
            set: function (r) {
              this.__isLocked !== r &&
                ((this.__isLocked = r), this.toggleClass("lenis-locked", r));
            },
          },
          {
            key: "className",
            get: function () {
              var r = "lenis";
              return (
                this.isStopped && (r += " lenis-stopped"),
                this.isLocked && (r += " lenis-locked"),
                this.isScrolling && (r += " lenis-scrolling"),
                this.isSmooth && (r += " lenis-smooth"),
                r
              );
            },
          },
        ]),
        s
      );
    })();
  function fl(s, e) {
    for (var r = 0; r < e.length; r++) {
      var t = e[r];
      (t.enumerable = t.enumerable || !1),
        (t.configurable = !0),
        "value" in t && (t.writable = !0),
        Object.defineProperty(s, t.key, t);
    }
  }
  function rf(s, e, r) {
    return e && fl(s.prototype, e), r && fl(s, r), s;
  }
  /*!
   * Observer 3.12.2
   * https://greensock.com
   *
   * @license Copyright 2008-2023, GreenSock. All rights reserved.
   * Subject to the terms at https://greensock.com/standard-license or for
   * Club GreenSock members, the agreement issued with that membership.
   * @author: Jack Doyle, jack@greensock.com
   */ var He,
    eo,
    Et,
    kr,
    Cr,
    yi,
    dl,
    Ur,
    Hi,
    hl,
    dr,
    Yt,
    pl,
    _l = function () {
      return (
        He ||
        (typeof window != "undefined" &&
          (He = window.gsap) &&
          He.registerPlugin &&
          He)
      );
    },
    ml = 1,
    bi = [],
    Z = [],
    rr = [],
    ji = Date.now,
    to = function (e, r) {
      return r;
    },
    nf = function () {
      var e = Hi.core,
        r = e.bridge || {},
        t = e._scrollers,
        i = e._proxies;
      t.push.apply(t, Z),
        i.push.apply(i, rr),
        (Z = t),
        (rr = i),
        (to = function (o, a) {
          return r[o](a);
        });
    },
    Ar = function (e, r) {
      return ~rr.indexOf(e) && rr[rr.indexOf(e) + 1][r];
    },
    Gi = function (e) {
      return !!~hl.indexOf(e);
    },
    ot = function (e, r, t, i, n) {
      return e.addEventListener(r, t, { passive: !i, capture: !!n });
    },
    at = function (e, r, t, i) {
      return e.removeEventListener(r, t, !!i);
    },
    Ln = "scrollLeft",
    Mn = "scrollTop",
    ro = function () {
      return (dr && dr.isPressed) || Z.cache++;
    },
    zn = function (e, r) {
      var t = function i(n) {
        if (n || n === 0) {
          ml && (Et.history.scrollRestoration = "manual");
          var o = dr && dr.isPressed;
          (n = i.v = Math.round(n) || (dr && dr.iOS ? 1 : 0)),
            e(n),
            (i.cacheID = Z.cache),
            o && to("ss", n);
        } else
          (r || Z.cache !== i.cacheID || to("ref")) &&
            ((i.cacheID = Z.cache), (i.v = e()));
        return i.v + i.offset;
      };
      return (t.offset = 0), e && t;
    },
    lt = {
      s: Ln,
      p: "left",
      p2: "Left",
      os: "right",
      os2: "Right",
      d: "width",
      d2: "Width",
      a: "x",
      sc: zn(function (s) {
        return arguments.length
          ? Et.scrollTo(s, Ie.sc())
          : Et.pageXOffset || kr[Ln] || Cr[Ln] || yi[Ln] || 0;
      }),
    },
    Ie = {
      s: Mn,
      p: "top",
      p2: "Top",
      os: "bottom",
      os2: "Bottom",
      d: "height",
      d2: "Height",
      a: "y",
      op: lt,
      sc: zn(function (s) {
        return arguments.length
          ? Et.scrollTo(lt.sc(), s)
          : Et.pageYOffset || kr[Mn] || Cr[Mn] || yi[Mn] || 0;
      }),
    },
    yt = function (e, r) {
      return (
        ((r && r._ctx && r._ctx.selector) || He.utils.toArray)(e)[0] ||
        (typeof e == "string" && He.config().nullTargetWarn !== !1
          ? console.warn("Element not found:", e)
          : null)
      );
    },
    Pr = function (e, r) {
      var t = r.s,
        i = r.sc;
      Gi(e) && (e = kr.scrollingElement || Cr);
      var n = Z.indexOf(e),
        o = i === Ie.sc ? 1 : 2;
      !~n && (n = Z.push(e) - 1), Z[n + o] || ot(e, "scroll", ro);
      var a = Z[n + o],
        l =
          a ||
          (Z[n + o] =
            zn(Ar(e, t), !0) ||
            (Gi(e)
              ? i
              : zn(function (c) {
                  return arguments.length ? (e[t] = c) : e[t];
                })));
      return (
        (l.target = e),
        a || (l.smooth = He.getProperty(e, "scrollBehavior") === "smooth"),
        l
      );
    },
    io = function (e, r, t) {
      var i = e,
        n = e,
        o = ji(),
        a = o,
        l = r || 50,
        c = Math.max(500, l * 3),
        u = function (m, h) {
          var v = ji();
          h || v - o > l
            ? ((n = i), (i = m), (a = o), (o = v))
            : t
            ? (i += m)
            : (i = n + ((m - n) / (v - a)) * (o - a));
        },
        _ = function () {
          (n = i = t ? 0 : i), (a = o = 0);
        },
        p = function (m) {
          var h = a,
            v = n,
            T = ji();
          return (
            (m || m === 0) && m !== i && u(m),
            o === a || T - a > c
              ? 0
              : ((i + (t ? v : -v)) / ((t ? T : o) - h)) * 1e3
          );
        };
      return { update: u, reset: _, getVelocity: p };
    },
    Ki = function (e, r) {
      return (
        r && !e._gsapAllow && e.preventDefault(),
        e.changedTouches ? e.changedTouches[0] : e
      );
    },
    gl = function (e) {
      var r = Math.max.apply(Math, e),
        t = Math.min.apply(Math, e);
      return Math.abs(r) >= Math.abs(t) ? r : t;
    },
    vl = function () {
      (Hi = He.core.globals().ScrollTrigger), Hi && Hi.core && nf();
    },
    yl = function (e) {
      return (
        (He = e || _l()),
        He &&
          typeof document != "undefined" &&
          document.body &&
          ((Et = window),
          (kr = document),
          (Cr = kr.documentElement),
          (yi = kr.body),
          (hl = [Et, kr, Cr, yi]),
          He.utils.clamp,
          (pl = He.core.context || function () {}),
          (Ur = "onpointerenter" in yi ? "pointer" : "mouse"),
          (dl = ze.isTouch =
            Et.matchMedia &&
            Et.matchMedia("(hover: none), (pointer: coarse)").matches
              ? 1
              : "ontouchstart" in Et ||
                navigator.maxTouchPoints > 0 ||
                navigator.msMaxTouchPoints > 0
              ? 2
              : 0),
          (Yt = ze.eventTypes =
            (
              "ontouchstart" in Cr
                ? "touchstart,touchmove,touchcancel,touchend"
                : "onpointerdown" in Cr
                ? "pointerdown,pointermove,pointercancel,pointerup"
                : "mousedown,mousemove,mouseup,mouseup"
            ).split(",")),
          setTimeout(function () {
            return (ml = 0);
          }, 500),
          vl(),
          (eo = 1)),
        eo
      );
    };
  (lt.op = Ie), (Z.cache = 0);
  var ze = (function () {
    function s(r) {
      this.init(r);
    }
    var e = s.prototype;
    return (
      (e.init = function (t) {
        eo || yl(He) || console.warn("Please gsap.registerPlugin(Observer)"),
          Hi || vl();
        var i = t.tolerance,
          n = t.dragMinimum,
          o = t.type,
          a = t.target,
          l = t.lineHeight,
          c = t.debounce,
          u = t.preventDefault,
          _ = t.onStop,
          p = t.onStopDelay,
          f = t.ignore,
          m = t.wheelSpeed,
          h = t.event,
          v = t.onDragStart,
          T = t.onDragEnd,
          E = t.onDrag,
          P = t.onPress,
          g = t.onRelease,
          y = t.onRight,
          w = t.onLeft,
          S = t.onUp,
          A = t.onDown,
          C = t.onChangeX,
          L = t.onChangeY,
          z = t.onChange,
          x = t.onToggleX,
          H = t.onToggleY,
          q = t.onHover,
          B = t.onHoverEnd,
          U = t.onMove,
          F = t.ignoreCheck,
          G = t.isNormalizer,
          Q = t.onGestureStart,
          b = t.onGestureEnd,
          le = t.onWheel,
          Re = t.onEnable,
          rt = t.onDisable,
          de = t.onClick,
          Ce = t.scrollSpeed,
          Ne = t.capture,
          _e = t.allowClicks,
          me = t.lockAxis,
          ge = t.onLockAxis;
        (this.target = a = yt(a) || Cr),
          (this.vars = t),
          f && (f = He.utils.toArray(f)),
          (i = i || 1e-9),
          (n = n || 0),
          (m = m || 1),
          (Ce = Ce || 1),
          (o = o || "wheel,touch,pointer"),
          (c = c !== !1),
          l || (l = parseFloat(Et.getComputedStyle(yi).lineHeight) || 22);
        var Ye,
          ve,
          Xe,
          V,
          ce,
          Se,
          k,
          d = this,
          O = 0,
          M = 0,
          Y = Pr(a, lt),
          D = Pr(a, Ie),
          I = Y(),
          oe = D(),
          Bt =
            ~o.indexOf("touch") &&
            !~o.indexOf("pointer") &&
            Yt[0] === "pointerdown",
          Ge = Gi(a),
          Oe = a.ownerDocument || kr,
          Vt = [0, 0, 0],
          Ut = [0, 0, 0],
          ti = 0,
          mr = function () {
            return (ti = ji());
          },
          nr = function (W, ae) {
            return (
              ((d.event = W) && f && ~f.indexOf(W.target)) ||
              (ae && Bt && W.pointerType !== "touch") ||
              (F && F(W, ae))
            );
          },
          bt = function () {
            d._vx.reset(), d._vy.reset(), ve.pause(), _ && _(d);
          },
          ri = function () {
            var W = (d.deltaX = gl(Vt)),
              ae = (d.deltaY = gl(Ut)),
              Ae = Math.abs(W) >= i,
              N = Math.abs(ae) >= i;
            z && (Ae || N) && z(d, W, ae, Vt, Ut),
              Ae &&
                (y && d.deltaX > 0 && y(d),
                w && d.deltaX < 0 && w(d),
                C && C(d),
                x && d.deltaX < 0 != O < 0 && x(d),
                (O = d.deltaX),
                (Vt[0] = Vt[1] = Vt[2] = 0)),
              N &&
                (A && d.deltaY > 0 && A(d),
                S && d.deltaY < 0 && S(d),
                L && L(d),
                H && d.deltaY < 0 != M < 0 && H(d),
                (M = d.deltaY),
                (Ut[0] = Ut[1] = Ut[2] = 0)),
              (V || Xe) && (U && U(d), Xe && (E(d), (Xe = !1)), (V = !1)),
              Se && !(Se = !1) && ge && ge(d),
              ce && (le(d), (ce = !1)),
              (Ye = 0);
          },
          Pi = function (W, ae, Ae) {
            (Vt[Ae] += W),
              (Ut[Ae] += ae),
              d._vx.update(W),
              d._vy.update(ae),
              c ? Ye || (Ye = requestAnimationFrame(ri)) : ri();
          },
          Oi = function (W, ae) {
            me &&
              !k &&
              ((d.axis = k = Math.abs(W) > Math.abs(ae) ? "x" : "y"),
              (Se = !0)),
              k !== "y" && ((Vt[2] += W), d._vx.update(W, !0)),
              k !== "x" && ((Ut[2] += ae), d._vy.update(ae, !0)),
              c ? Ye || (Ye = requestAnimationFrame(ri)) : ri();
          },
          ii = function (W) {
            if (!nr(W, 1)) {
              W = Ki(W, u);
              var ae = W.clientX,
                Ae = W.clientY,
                N = ae - d.x,
                ie = Ae - d.y,
                X = d.isDragging;
              (d.x = ae),
                (d.y = Ae),
                (X ||
                  Math.abs(d.startX - ae) >= n ||
                  Math.abs(d.startY - Ae) >= n) &&
                  (E && (Xe = !0),
                  X || (d.isDragging = !0),
                  Oi(N, ie),
                  X || (v && v(d)));
            }
          },
          Lr = (d.onPress = function (j) {
            nr(j, 1) ||
              (j && j.button) ||
              ((d.axis = k = null),
              ve.pause(),
              (d.isPressed = !0),
              (j = Ki(j)),
              (O = M = 0),
              (d.startX = d.x = j.clientX),
              (d.startY = d.y = j.clientY),
              d._vx.reset(),
              d._vy.reset(),
              ot(G ? a : Oe, Yt[1], ii, u, !0),
              (d.deltaX = d.deltaY = 0),
              P && P(d));
          }),
          Mr = (d.onRelease = function (j) {
            if (!nr(j, 1)) {
              at(G ? a : Oe, Yt[1], ii, !0);
              var W = !isNaN(d.y - d.startY),
                ae =
                  d.isDragging &&
                  (Math.abs(d.x - d.startX) > 3 ||
                    Math.abs(d.y - d.startY) > 3),
                Ae = Ki(j);
              !ae &&
                W &&
                (d._vx.reset(),
                d._vy.reset(),
                u &&
                  _e &&
                  He.delayedCall(0.08, function () {
                    if (ji() - ti > 300 && !j.defaultPrevented) {
                      if (j.target.click) j.target.click();
                      else if (Oe.createEvent) {
                        var N = Oe.createEvent("MouseEvents");
                        N.initMouseEvent(
                          "click",
                          !0,
                          !0,
                          Et,
                          1,
                          Ae.screenX,
                          Ae.screenY,
                          Ae.clientX,
                          Ae.clientY,
                          !1,
                          !1,
                          !1,
                          !1,
                          0,
                          null
                        ),
                          j.target.dispatchEvent(N);
                      }
                    }
                  })),
                (d.isDragging = d.isGesturing = d.isPressed = !1),
                _ && !G && ve.restart(!0),
                T && ae && T(d),
                g && g(d, ae);
            }
          }),
          ne = function (W) {
            return (
              W.touches &&
              W.touches.length > 1 &&
              (d.isGesturing = !0) &&
              Q(W, d.isDragging)
            );
          },
          ni = function () {
            return (d.isGesturing = !1) || b(d);
          },
          Ht = function (W) {
            if (!nr(W)) {
              var ae = Y(),
                Ae = D();
              Pi((ae - I) * Ce, (Ae - oe) * Ce, 1),
                (I = ae),
                (oe = Ae),
                _ && ve.restart(!0);
            }
          },
          jt = function (W) {
            if (!nr(W)) {
              (W = Ki(W, u)), le && (ce = !0);
              var ae =
                (W.deltaMode === 1
                  ? l
                  : W.deltaMode === 2
                  ? Et.innerHeight
                  : 1) * m;
              Pi(W.deltaX * ae, W.deltaY * ae, 0), _ && !G && ve.restart(!0);
            }
          },
          Gt = function (W) {
            if (!nr(W)) {
              var ae = W.clientX,
                Ae = W.clientY,
                N = ae - d.x,
                ie = Ae - d.y;
              (d.x = ae), (d.y = Ae), (V = !0), (N || ie) && Oi(N, ie);
            }
          },
          si = function (W) {
            (d.event = W), q(d);
          },
          Li = function (W) {
            (d.event = W), B(d);
          },
          gr = function (W) {
            return nr(W) || (Ki(W, u) && de(d));
          };
        (ve = d._dc = He.delayedCall(p || 0.25, bt).pause()),
          (d.deltaX = d.deltaY = 0),
          (d._vx = io(0, 50, !0)),
          (d._vy = io(0, 50, !0)),
          (d.scrollX = Y),
          (d.scrollY = D),
          (d.isDragging = d.isGesturing = d.isPressed = !1),
          pl(this),
          (d.enable = function (j) {
            return (
              d.isEnabled ||
                (ot(Ge ? Oe : a, "scroll", ro),
                o.indexOf("scroll") >= 0 &&
                  ot(Ge ? Oe : a, "scroll", Ht, u, Ne),
                o.indexOf("wheel") >= 0 && ot(a, "wheel", jt, u, Ne),
                ((o.indexOf("touch") >= 0 && dl) ||
                  o.indexOf("pointer") >= 0) &&
                  (ot(a, Yt[0], Lr, u, Ne),
                  ot(Oe, Yt[2], Mr),
                  ot(Oe, Yt[3], Mr),
                  _e && ot(a, "click", mr, !1, !0),
                  de && ot(a, "click", gr),
                  Q && ot(Oe, "gesturestart", ne),
                  b && ot(Oe, "gestureend", ni),
                  q && ot(a, Ur + "enter", si),
                  B && ot(a, Ur + "leave", Li),
                  U && ot(a, Ur + "move", Gt)),
                (d.isEnabled = !0),
                j && j.type && Lr(j),
                Re && Re(d)),
              d
            );
          }),
          (d.disable = function () {
            d.isEnabled &&
              (bi.filter(function (j) {
                return j !== d && Gi(j.target);
              }).length || at(Ge ? Oe : a, "scroll", ro),
              d.isPressed &&
                (d._vx.reset(), d._vy.reset(), at(G ? a : Oe, Yt[1], ii, !0)),
              at(Ge ? Oe : a, "scroll", Ht, Ne),
              at(a, "wheel", jt, Ne),
              at(a, Yt[0], Lr, Ne),
              at(Oe, Yt[2], Mr),
              at(Oe, Yt[3], Mr),
              at(a, "click", mr, !0),
              at(a, "click", gr),
              at(Oe, "gesturestart", ne),
              at(Oe, "gestureend", ni),
              at(a, Ur + "enter", si),
              at(a, Ur + "leave", Li),
              at(a, Ur + "move", Gt),
              (d.isEnabled = d.isPressed = d.isDragging = !1),
              rt && rt(d));
          }),
          (d.kill = d.revert =
            function () {
              d.disable();
              var j = bi.indexOf(d);
              j >= 0 && bi.splice(j, 1), dr === d && (dr = 0);
            }),
          bi.push(d),
          G && Gi(a) && (dr = d),
          d.enable(h);
      }),
      rf(s, [
        {
          key: "velocityX",
          get: function () {
            return this._vx.getVelocity();
          },
        },
        {
          key: "velocityY",
          get: function () {
            return this._vy.getVelocity();
          },
        },
      ]),
      s
    );
  })();
  (ze.version = "3.12.2"),
    (ze.create = function (s) {
      return new ze(s);
    }),
    (ze.register = yl),
    (ze.getAll = function () {
      return bi.slice();
    }),
    (ze.getById = function (s) {
      return bi.filter(function (e) {
        return e.vars.id === s;
      })[0];
    }),
    _l() && He.registerPlugin(ze);
  /*!
   * ScrollTrigger 3.12.2
   * https://greensock.com
   *
   * @license Copyright 2008-2023, GreenSock. All rights reserved.
   * Subject to the terms at https://greensock.com/standard-license or for
   * Club GreenSock members, the agreement issued with that membership.
   * @author: Jack Doyle, jack@greensock.com
   */ var R,
    wi,
    re,
    we,
    Xt,
    pe,
    bl,
    Dn,
    Rn,
    Si,
    Nn,
    qn,
    tt,
    In,
    no,
    ct,
    wl,
    Sl,
    xi,
    xl,
    so,
    Tl,
    kt,
    El,
    kl,
    Cl,
    Or,
    oo,
    ao,
    Ti,
    lo,
    co,
    Fn = 1,
    ut = Date.now,
    uo = ut(),
    qt = 0,
    Qi = 0,
    Al = function (e, r, t) {
      var i = Ct(e) && (e.substr(0, 6) === "clamp(" || e.indexOf("max") > -1);
      return (t["_" + r + "Clamp"] = i), i ? e.substr(6, e.length - 7) : e;
    },
    Pl = function (e, r) {
      return r && (!Ct(e) || e.substr(0, 6) !== "clamp(")
        ? "clamp(" + e + ")"
        : e;
    },
    sf = function s() {
      return Qi && requestAnimationFrame(s);
    },
    Ol = function () {
      return (In = 1);
    },
    Ll = function () {
      return (In = 0);
    },
    ir = function (e) {
      return e;
    },
    Ji = function (e) {
      return Math.round(e * 1e5) / 1e5 || 0;
    },
    Ml = function () {
      return typeof window != "undefined";
    },
    zl = function () {
      return R || (Ml() && (R = window.gsap) && R.registerPlugin && R);
    },
    Hr = function (e) {
      return !!~bl.indexOf(e);
    },
    Dl = function (e) {
      return (
        (e === "Height" ? lo : re["inner" + e]) ||
        Xt["client" + e] ||
        pe["client" + e]
      );
    },
    Rl = function (e) {
      return (
        Ar(e, "getBoundingClientRect") ||
        (Hr(e)
          ? function () {
              return (Jn.width = re.innerWidth), (Jn.height = lo), Jn;
            }
          : function () {
              return pr(e);
            })
      );
    },
    of = function (e, r, t) {
      var i = t.d,
        n = t.d2,
        o = t.a;
      return (o = Ar(e, "getBoundingClientRect"))
        ? function () {
            return o()[i];
          }
        : function () {
            return (r ? Dl(n) : e["client" + n]) || 0;
          };
    },
    af = function (e, r) {
      return !r || ~rr.indexOf(e)
        ? Rl(e)
        : function () {
            return Jn;
          };
    },
    hr = function (e, r) {
      var t = r.s,
        i = r.d2,
        n = r.d,
        o = r.a;
      return Math.max(
        0,
        (t = "scroll" + i) && (o = Ar(e, t))
          ? o() - Rl(e)()[n]
          : Hr(e)
          ? (Xt[t] || pe[t]) - Dl(i)
          : e[t] - e["offset" + i]
      );
    },
    Bn = function (e, r) {
      for (var t = 0; t < xi.length; t += 3)
        (!r || ~r.indexOf(xi[t + 1])) && e(xi[t], xi[t + 1], xi[t + 2]);
    },
    Ct = function (e) {
      return typeof e == "string";
    },
    ft = function (e) {
      return typeof e == "function";
    },
    $n = function (e) {
      return typeof e == "number";
    },
    jr = function (e) {
      return typeof e == "object";
    },
    Zi = function (e, r, t) {
      return e && e.progress(r ? 0 : 1) && t && e.pause();
    },
    fo = function (e, r) {
      if (e.enabled) {
        var t = r(e);
        t && t.totalTime && (e.callbackAnimation = t);
      }
    },
    Ei = Math.abs,
    Nl = "left",
    ql = "top",
    ho = "right",
    po = "bottom",
    Gr = "width",
    Kr = "height",
    en = "Right",
    tn = "Left",
    rn = "Top",
    nn = "Bottom",
    De = "padding",
    It = "margin",
    ki = "Width",
    _o = "Height",
    je = "px",
    Ft = function (e) {
      return re.getComputedStyle(e);
    },
    lf = function (e) {
      var r = Ft(e).position;
      e.style.position = r === "absolute" || r === "fixed" ? r : "relative";
    },
    Il = function (e, r) {
      for (var t in r) t in e || (e[t] = r[t]);
      return e;
    },
    pr = function (e, r) {
      var t =
          r &&
          Ft(e)[no] !== "matrix(1, 0, 0, 1, 0, 0)" &&
          R.to(e, {
            x: 0,
            y: 0,
            xPercent: 0,
            yPercent: 0,
            rotation: 0,
            rotationX: 0,
            rotationY: 0,
            scale: 1,
            skewX: 0,
            skewY: 0,
          }).progress(1),
        i = e.getBoundingClientRect();
      return t && t.progress(0).kill(), i;
    },
    mo = function (e, r) {
      var t = r.d2;
      return e["offset" + t] || e["client" + t] || 0;
    },
    Fl = function (e) {
      var r = [],
        t = e.labels,
        i = e.duration(),
        n;
      for (n in t) r.push(t[n] / i);
      return r;
    },
    cf = function (e) {
      return function (r) {
        return R.utils.snap(Fl(e), r);
      };
    },
    go = function (e) {
      var r = R.utils.snap(e),
        t =
          Array.isArray(e) &&
          e.slice(0).sort(function (i, n) {
            return i - n;
          });
      return t
        ? function (i, n, o) {
            o === void 0 && (o = 0.001);
            var a;
            if (!n) return r(i);
            if (n > 0) {
              for (i -= o, a = 0; a < t.length; a++) if (t[a] >= i) return t[a];
              return t[a - 1];
            } else for (a = t.length, i += o; a--; ) if (t[a] <= i) return t[a];
            return t[0];
          }
        : function (i, n, o) {
            o === void 0 && (o = 0.001);
            var a = r(i);
            return !n || Math.abs(a - i) < o || a - i < 0 == n < 0
              ? a
              : r(n < 0 ? i - e : i + e);
          };
    },
    uf = function (e) {
      return function (r, t) {
        return go(Fl(e))(r, t.direction);
      };
    },
    Wn = function (e, r, t, i) {
      return t.split(",").forEach(function (n) {
        return e(r, n, i);
      });
    },
    $e = function (e, r, t, i, n) {
      return e.addEventListener(r, t, { passive: !i, capture: !!n });
    },
    We = function (e, r, t, i) {
      return e.removeEventListener(r, t, !!i);
    },
    Yn = function (e, r, t) {
      (t = t && t.wheelHandler), t && (e(r, "wheel", t), e(r, "touchmove", t));
    },
    Bl = {
      startColor: "green",
      endColor: "red",
      indent: 0,
      fontSize: "16px",
      fontWeight: "normal",
    },
    Xn = { toggleActions: "play", anticipatePin: 0 },
    Vn = { top: 0, left: 0, center: 0.5, bottom: 1, right: 1 },
    Un = function (e, r) {
      if (Ct(e)) {
        var t = e.indexOf("="),
          i = ~t ? +(e.charAt(t - 1) + 1) * parseFloat(e.substr(t + 1)) : 0;
        ~t && (e.indexOf("%") > t && (i *= r / 100), (e = e.substr(0, t - 1))),
          (e =
            i +
            (e in Vn
              ? Vn[e] * r
              : ~e.indexOf("%")
              ? (parseFloat(e) * r) / 100
              : parseFloat(e) || 0));
      }
      return e;
    },
    Hn = function (e, r, t, i, n, o, a, l) {
      var c = n.startColor,
        u = n.endColor,
        _ = n.fontSize,
        p = n.indent,
        f = n.fontWeight,
        m = we.createElement("div"),
        h = Hr(t) || Ar(t, "pinType") === "fixed",
        v = e.indexOf("scroller") !== -1,
        T = h ? pe : t,
        E = e.indexOf("start") !== -1,
        P = E ? c : u,
        g =
          "border-color:" +
          P +
          ";font-size:" +
          _ +
          ";color:" +
          P +
          ";font-weight:" +
          f +
          ";pointer-events:none;white-space:nowrap;font-family:sans-serif,Arial;z-index:1000;padding:4px 8px;border-width:0;border-style:solid;";
      return (
        (g += "position:" + ((v || l) && h ? "fixed;" : "absolute;")),
        (v || l || !h) &&
          (g += (i === Ie ? ho : po) + ":" + (o + parseFloat(p)) + "px;"),
        a &&
          (g +=
            "box-sizing:border-box;text-align:left;width:" +
            a.offsetWidth +
            "px;"),
        (m._isStart = E),
        m.setAttribute("class", "gsap-marker-" + e + (r ? " marker-" + r : "")),
        (m.style.cssText = g),
        (m.innerText = r || r === 0 ? e + "-" + r : e),
        T.children[0] ? T.insertBefore(m, T.children[0]) : T.appendChild(m),
        (m._offset = m["offset" + i.op.d2]),
        jn(m, 0, i, E),
        m
      );
    },
    jn = function (e, r, t, i) {
      var n = { display: "block" },
        o = t[i ? "os2" : "p2"],
        a = t[i ? "p2" : "os2"];
      (e._isFlipped = i),
        (n[t.a + "Percent"] = i ? -100 : 0),
        (n[t.a] = i ? "1px" : 0),
        (n["border" + o + ki] = 1),
        (n["border" + a + ki] = 0),
        (n[t.p] = r + "px"),
        R.set(e, n);
    },
    J = [],
    vo = {},
    sn,
    $l = function () {
      return ut() - qt > 34 && (sn || (sn = requestAnimationFrame(_r)));
    },
    Ci = function () {
      (!kt || !kt.isPressed || kt.startX > pe.clientWidth) &&
        (Z.cache++,
        kt ? sn || (sn = requestAnimationFrame(_r)) : _r(),
        qt || Jr("scrollStart"),
        (qt = ut()));
    },
    yo = function () {
      (Cl = re.innerWidth), (kl = re.innerHeight);
    },
    on = function () {
      Z.cache++,
        !tt &&
          !Tl &&
          !we.fullscreenElement &&
          !we.webkitFullscreenElement &&
          (!El ||
            Cl !== re.innerWidth ||
            Math.abs(re.innerHeight - kl) > re.innerHeight * 0.25) &&
          Dn.restart(!0);
    },
    Qr = {},
    ff = [],
    Wl = function s() {
      return We(K, "scrollEnd", s) || ei(!0);
    },
    Jr = function (e) {
      return (
        (Qr[e] &&
          Qr[e].map(function (r) {
            return r();
          })) ||
        ff
      );
    },
    At = [],
    Yl = function (e) {
      for (var r = 0; r < At.length; r += 5)
        (!e || (At[r + 4] && At[r + 4].query === e)) &&
          ((At[r].style.cssText = At[r + 1]),
          At[r].getBBox && At[r].setAttribute("transform", At[r + 2] || ""),
          (At[r + 3].uncache = 1));
    },
    bo = function (e, r) {
      var t;
      for (ct = 0; ct < J.length; ct++)
        (t = J[ct]),
          t && (!r || t._ctx === r) && (e ? t.kill(1) : t.revert(!0, !0));
      r && Yl(r), r || Jr("revert");
    },
    Xl = function (e, r) {
      Z.cache++,
        (r || !dt) &&
          Z.forEach(function (t) {
            return ft(t) && t.cacheID++ && (t.rec = 0);
          }),
        Ct(e) && (re.history.scrollRestoration = ao = e);
    },
    dt,
    Zr = 0,
    Vl,
    df = function () {
      if (Vl !== Zr) {
        var e = (Vl = Zr);
        requestAnimationFrame(function () {
          return e === Zr && ei(!0);
        });
      }
    },
    Ul = function () {
      pe.appendChild(Ti),
        (lo = Ti.offsetHeight || re.innerHeight),
        pe.removeChild(Ti);
    },
    ei = function (e, r) {
      if (qt && !e) {
        $e(K, "scrollEnd", Wl);
        return;
      }
      Ul(),
        (dt = K.isRefreshing = !0),
        Z.forEach(function (i) {
          return ft(i) && ++i.cacheID && (i.rec = i());
        });
      var t = Jr("refreshInit");
      xl && K.sort(),
        r || bo(),
        Z.forEach(function (i) {
          ft(i) && (i.smooth && (i.target.style.scrollBehavior = "auto"), i(0));
        }),
        J.slice(0).forEach(function (i) {
          return i.refresh();
        }),
        J.forEach(function (i, n) {
          if (i._subPinOffset && i.pin) {
            var o = i.vars.horizontal ? "offsetWidth" : "offsetHeight",
              a = i.pin[o];
            i.revert(!0, 1), i.adjustPinSpacing(i.pin[o] - a), i.refresh();
          }
        }),
        J.forEach(function (i) {
          var n = hr(i.scroller, i._dir);
          (i.vars.end === "max" || (i._endClamp && i.end > n)) &&
            i.setPositions(i.start, Math.max(i.start + 1, n), !0);
        }),
        t.forEach(function (i) {
          return i && i.render && i.render(-1);
        }),
        Z.forEach(function (i) {
          ft(i) &&
            (i.smooth &&
              requestAnimationFrame(function () {
                return (i.target.style.scrollBehavior = "smooth");
              }),
            i.rec && i(i.rec));
        }),
        Xl(ao, 1),
        Dn.pause(),
        Zr++,
        (dt = 2),
        _r(2),
        J.forEach(function (i) {
          return ft(i.vars.onRefresh) && i.vars.onRefresh(i);
        }),
        (dt = K.isRefreshing = !1),
        Jr("refresh");
    },
    wo = 0,
    Gn = 1,
    an,
    _r = function (e) {
      if (!dt || e === 2) {
        (K.isUpdating = !0), an && an.update(0);
        var r = J.length,
          t = ut(),
          i = t - uo >= 50,
          n = r && J[0].scroll();
        if (
          ((Gn = wo > n ? -1 : 1),
          dt || (wo = n),
          i &&
            (qt && !In && t - qt > 200 && ((qt = 0), Jr("scrollEnd")),
            (Nn = uo),
            (uo = t)),
          Gn < 0)
        ) {
          for (ct = r; ct-- > 0; ) J[ct] && J[ct].update(0, i);
          Gn = 1;
        } else for (ct = 0; ct < r; ct++) J[ct] && J[ct].update(0, i);
        K.isUpdating = !1;
      }
      sn = 0;
    },
    So = [
      Nl,
      ql,
      po,
      ho,
      It + nn,
      It + en,
      It + rn,
      It + tn,
      "display",
      "flexShrink",
      "float",
      "zIndex",
      "gridColumnStart",
      "gridColumnEnd",
      "gridRowStart",
      "gridRowEnd",
      "gridArea",
      "justifySelf",
      "alignSelf",
      "placeSelf",
      "order",
    ],
    Kn = So.concat([
      Gr,
      Kr,
      "boxSizing",
      "max" + ki,
      "max" + _o,
      "position",
      It,
      De,
      De + rn,
      De + en,
      De + nn,
      De + tn,
    ]),
    hf = function (e, r, t) {
      Ai(t);
      var i = e._gsap;
      if (i.spacerIsNative) Ai(i.spacerState);
      else if (e._gsap.swappedIn) {
        var n = r.parentNode;
        n && (n.insertBefore(e, r), n.removeChild(r));
      }
      e._gsap.swappedIn = !1;
    },
    xo = function (e, r, t, i) {
      if (!e._gsap.swappedIn) {
        for (var n = So.length, o = r.style, a = e.style, l; n--; )
          (l = So[n]), (o[l] = t[l]);
        (o.position = t.position === "absolute" ? "absolute" : "relative"),
          t.display === "inline" && (o.display = "inline-block"),
          (a[po] = a[ho] = "auto"),
          (o.flexBasis = t.flexBasis || "auto"),
          (o.overflow = "visible"),
          (o.boxSizing = "border-box"),
          (o[Gr] = mo(e, lt) + je),
          (o[Kr] = mo(e, Ie) + je),
          (o[De] = a[It] = a[ql] = a[Nl] = "0"),
          Ai(i),
          (a[Gr] = a["max" + ki] = t[Gr]),
          (a[Kr] = a["max" + _o] = t[Kr]),
          (a[De] = t[De]),
          e.parentNode !== r &&
            (e.parentNode.insertBefore(r, e), r.appendChild(e)),
          (e._gsap.swappedIn = !0);
      }
    },
    pf = /([A-Z])/g,
    Ai = function (e) {
      if (e) {
        var r = e.t.style,
          t = e.length,
          i = 0,
          n,
          o;
        for ((e.t._gsap || R.core.getCache(e.t)).uncache = 1; i < t; i += 2)
          (o = e[i + 1]),
            (n = e[i]),
            o
              ? (r[n] = o)
              : r[n] && r.removeProperty(n.replace(pf, "-$1").toLowerCase());
      }
    },
    Qn = function (e) {
      for (var r = Kn.length, t = e.style, i = [], n = 0; n < r; n++)
        i.push(Kn[n], t[Kn[n]]);
      return (i.t = e), i;
    },
    _f = function (e, r, t) {
      for (var i = [], n = e.length, o = t ? 8 : 0, a; o < n; o += 2)
        (a = e[o]), i.push(a, a in r ? r[a] : e[o + 1]);
      return (i.t = e.t), i;
    },
    Jn = { left: 0, top: 0 },
    Hl = function (e, r, t, i, n, o, a, l, c, u, _, p, f, m) {
      ft(e) && (e = e(l)),
        Ct(e) &&
          e.substr(0, 3) === "max" &&
          (e = p + (e.charAt(4) === "=" ? Un("0" + e.substr(3), t) : 0));
      var h = f ? f.time() : 0,
        v,
        T,
        E;
      if ((f && f.seek(0), isNaN(e) || (e = +e), $n(e)))
        f &&
          (e = R.utils.mapRange(
            f.scrollTrigger.start,
            f.scrollTrigger.end,
            0,
            p,
            e
          )),
          a && jn(a, t, i, !0);
      else {
        ft(r) && (r = r(l));
        var P = (e || "0").split(" "),
          g,
          y,
          w,
          S;
        (E = yt(r, l) || pe),
          (g = pr(E) || {}),
          (!g || (!g.left && !g.top)) &&
            Ft(E).display === "none" &&
            ((S = E.style.display),
            (E.style.display = "block"),
            (g = pr(E)),
            S ? (E.style.display = S) : E.style.removeProperty("display")),
          (y = Un(P[0], g[i.d])),
          (w = Un(P[1] || "0", t)),
          (e = g[i.p] - c[i.p] - u + y + n - w),
          a && jn(a, w, i, t - w < 20 || (a._isStart && w > 20)),
          (t -= t - w);
      }
      if ((m && ((l[m] = e || -0.001), e < 0 && (e = 0)), o)) {
        var A = e + t,
          C = o._isStart;
        (v = "scroll" + i.d2),
          jn(
            o,
            A,
            i,
            (C && A > 20) ||
              (!C && (_ ? Math.max(pe[v], Xt[v]) : o.parentNode[v]) <= A + 1)
          ),
          _ &&
            ((c = pr(a)),
            _ && (o.style[i.op.p] = c[i.op.p] - i.op.m - o._offset + je));
      }
      return (
        f &&
          E &&
          ((v = pr(E)),
          f.seek(p),
          (T = pr(E)),
          (f._caScrollDist = v[i.p] - T[i.p]),
          (e = (e / f._caScrollDist) * p)),
        f && f.seek(h),
        f ? e : Math.round(e)
      );
    },
    mf = /(webkit|moz|length|cssText|inset)/i,
    jl = function (e, r, t, i) {
      if (e.parentNode !== r) {
        var n = e.style,
          o,
          a;
        if (r === pe) {
          (e._stOrig = n.cssText), (a = Ft(e));
          for (o in a)
            !+o &&
              !mf.test(o) &&
              a[o] &&
              typeof n[o] == "string" &&
              o !== "0" &&
              (n[o] = a[o]);
          (n.top = t), (n.left = i);
        } else n.cssText = e._stOrig;
        (R.core.getCache(e).uncache = 1), r.appendChild(e);
      }
    },
    Gl = function (e, r, t) {
      var i = r,
        n = i;
      return function (o) {
        var a = Math.round(e());
        return (
          a !== i &&
            a !== n &&
            Math.abs(a - i) > 3 &&
            Math.abs(a - n) > 3 &&
            ((o = a), t && t()),
          (n = i),
          (i = o),
          o
        );
      };
    },
    Zn = function (e, r, t) {
      var i = {};
      (i[r.p] = "+=" + t), R.set(e, i);
    },
    Kl = function (e, r) {
      var t = Pr(e, r),
        i = "_scroll" + r.p2,
        n = function o(a, l, c, u, _) {
          var p = o.tween,
            f = l.onComplete,
            m = {};
          c = c || t();
          var h = Gl(t, c, function () {
            p.kill(), (o.tween = 0);
          });
          return (
            (_ = (u && _) || 0),
            (u = u || a - c),
            p && p.kill(),
            (l[i] = a),
            (l.modifiers = m),
            (m[i] = function () {
              return h(c + u * p.ratio + _ * p.ratio * p.ratio);
            }),
            (l.onUpdate = function () {
              Z.cache++, _r();
            }),
            (l.onComplete = function () {
              (o.tween = 0), f && f.call(p);
            }),
            (p = o.tween = R.to(e, l)),
            p
          );
        };
      return (
        (e[i] = t),
        (t.wheelHandler = function () {
          return n.tween && n.tween.kill() && (n.tween = 0);
        }),
        $e(e, "wheel", t.wheelHandler),
        K.isTouch && $e(e, "touchmove", t.wheelHandler),
        n
      );
    },
    K = (function () {
      function s(r, t) {
        wi ||
          s.register(R) ||
          console.warn("Please gsap.registerPlugin(ScrollTrigger)"),
          oo(this),
          this.init(r, t);
      }
      var e = s.prototype;
      return (
        (e.init = function (t, i) {
          if (
            ((this.progress = this.start = 0),
            this.vars && this.kill(!0, !0),
            !Qi)
          ) {
            this.update = this.refresh = this.kill = ir;
            return;
          }
          t = Il(Ct(t) || $n(t) || t.nodeType ? { trigger: t } : t, Xn);
          var n = t,
            o = n.onUpdate,
            a = n.toggleClass,
            l = n.id,
            c = n.onToggle,
            u = n.onRefresh,
            _ = n.scrub,
            p = n.trigger,
            f = n.pin,
            m = n.pinSpacing,
            h = n.invalidateOnRefresh,
            v = n.anticipatePin,
            T = n.onScrubComplete,
            E = n.onSnapComplete,
            P = n.once,
            g = n.snap,
            y = n.pinReparent,
            w = n.pinSpacer,
            S = n.containerAnimation,
            A = n.fastScrollEnd,
            C = n.preventOverlaps,
            L =
              t.horizontal || (t.containerAnimation && t.horizontal !== !1)
                ? lt
                : Ie,
            z = !_ && _ !== 0,
            x = yt(t.scroller || re),
            H = R.core.getCache(x),
            q = Hr(x),
            B =
              ("pinType" in t
                ? t.pinType
                : Ar(x, "pinType") || (q && "fixed")) === "fixed",
            U = [t.onEnter, t.onLeave, t.onEnterBack, t.onLeaveBack],
            F = z && t.toggleActions.split(" "),
            G = "markers" in t ? t.markers : Xn.markers,
            Q = q ? 0 : parseFloat(Ft(x)["border" + L.p2 + ki]) || 0,
            b = this,
            le =
              t.onRefreshInit &&
              function () {
                return t.onRefreshInit(b);
              },
            Re = of(x, q, L),
            rt = af(x, q),
            de = 0,
            Ce = 0,
            Ne = 0,
            _e = Pr(x, L),
            me,
            ge,
            Ye,
            ve,
            Xe,
            V,
            ce,
            Se,
            k,
            d,
            O,
            M,
            Y,
            D,
            I,
            oe,
            Bt,
            Ge,
            Oe,
            Vt,
            Ut,
            ti,
            mr,
            nr,
            bt,
            ri,
            Pi,
            Oi,
            ii,
            Lr,
            Mr,
            ne,
            ni,
            Ht,
            jt,
            Gt,
            si,
            Li,
            gr;
          if (
            ((b._startClamp = b._endClamp = !1),
            (b._dir = L),
            (v *= 45),
            (b.scroller = x),
            (b.scroll = S ? S.time.bind(S) : _e),
            (ve = _e()),
            (b.vars = t),
            (i = i || t.animation),
            "refreshPriority" in t &&
              ((xl = 1), t.refreshPriority === -9999 && (an = b)),
            (H.tweenScroll = H.tweenScroll || {
              top: Kl(x, Ie),
              left: Kl(x, lt),
            }),
            (b.tweenTo = me = H.tweenScroll[L.p]),
            (b.scrubDuration = function (N) {
              (ni = $n(N) && N),
                ni
                  ? ne
                    ? ne.duration(N)
                    : (ne = R.to(i, {
                        ease: "expo",
                        totalProgress: "+=0",
                        duration: ni,
                        paused: !0,
                        onComplete: function () {
                          return T && T(b);
                        },
                      }))
                  : (ne && ne.progress(1).kill(), (ne = 0));
            }),
            i &&
              ((i.vars.lazy = !1),
              (i._initted && !b.isReverted) ||
                (i.vars.immediateRender !== !1 &&
                  t.immediateRender !== !1 &&
                  i.duration() &&
                  i.render(0, !0, !0)),
              (b.animation = i.pause()),
              (i.scrollTrigger = b),
              b.scrubDuration(_),
              (Lr = 0),
              l || (l = i.vars.id)),
            g &&
              ((!jr(g) || g.push) && (g = { snapTo: g }),
              "scrollBehavior" in pe.style &&
                R.set(q ? [pe, Xt] : x, { scrollBehavior: "auto" }),
              Z.forEach(function (N) {
                return (
                  ft(N) &&
                  N.target === (q ? we.scrollingElement || Xt : x) &&
                  (N.smooth = !1)
                );
              }),
              (Ye = ft(g.snapTo)
                ? g.snapTo
                : g.snapTo === "labels"
                ? cf(i)
                : g.snapTo === "labelsDirectional"
                ? uf(i)
                : g.directional !== !1
                ? function (N, ie) {
                    return go(g.snapTo)(N, ut() - Ce < 500 ? 0 : ie.direction);
                  }
                : R.utils.snap(g.snapTo)),
              (Ht = g.duration || { min: 0.1, max: 2 }),
              (Ht = jr(Ht) ? Si(Ht.min, Ht.max) : Si(Ht, Ht)),
              (jt = R.delayedCall(g.delay || ni / 2 || 0.1, function () {
                var N = _e(),
                  ie = ut() - Ce < 500,
                  X = me.tween;
                if (
                  (ie || Math.abs(b.getVelocity()) < 10) &&
                  !X &&
                  !In &&
                  de !== N
                ) {
                  var ee = (N - V) / D,
                    Ve = i && !z ? i.totalProgress() : ee,
                    se = ie ? 0 : ((Ve - Mr) / (ut() - Nn)) * 1e3 || 0,
                    Le = R.utils.clamp(-ee, 1 - ee, (Ei(se / 2) * se) / 0.185),
                    ht = ee + (g.inertia === !1 ? 0 : Le),
                    Ke = Si(0, 1, Ye(ht, b)),
                    xe = Math.round(V + Ke * D),
                    he = g,
                    Kt = he.onStart,
                    Te = he.onInterrupt,
                    Pt = he.onComplete;
                  if (N <= ce && N >= V && xe !== N) {
                    if (X && !X._initted && X.data <= Ei(xe - N)) return;
                    g.inertia === !1 && (Le = Ke - ee),
                      me(
                        xe,
                        {
                          duration: Ht(
                            Ei(
                              (Math.max(Ei(ht - Ve), Ei(Ke - Ve)) * 0.185) /
                                se /
                                0.05 || 0
                            )
                          ),
                          ease: g.ease || "power3",
                          data: Ei(xe - N),
                          onInterrupt: function () {
                            return jt.restart(!0) && Te && Te(b);
                          },
                          onComplete: function () {
                            b.update(),
                              (de = _e()),
                              (Lr = Mr =
                                i && !z ? i.totalProgress() : b.progress),
                              E && E(b),
                              Pt && Pt(b);
                          },
                        },
                        N,
                        Le * D,
                        xe - N - Le * D
                      ),
                      Kt && Kt(b, me.tween);
                  }
                } else b.isActive && de !== N && jt.restart(!0);
              }).pause())),
            l && (vo[l] = b),
            (p = b.trigger = yt(p || (f !== !0 && f))),
            (gr = p && p._gsap && p._gsap.stRevert),
            gr && (gr = gr(b)),
            (f = f === !0 ? p : yt(f)),
            Ct(a) && (a = { targets: p, className: a }),
            f &&
              (m === !1 ||
                m === It ||
                (m =
                  !m &&
                  f.parentNode &&
                  f.parentNode.style &&
                  Ft(f.parentNode).display === "flex"
                    ? !1
                    : De),
              (b.pin = f),
              (ge = R.core.getCache(f)),
              ge.spacer
                ? (I = ge.pinState)
                : (w &&
                    ((w = yt(w)),
                    w && !w.nodeType && (w = w.current || w.nativeElement),
                    (ge.spacerIsNative = !!w),
                    w && (ge.spacerState = Qn(w))),
                  (ge.spacer = Ge = w || we.createElement("div")),
                  Ge.classList.add("pin-spacer"),
                  l && Ge.classList.add("pin-spacer-" + l),
                  (ge.pinState = I = Qn(f))),
              t.force3D !== !1 && R.set(f, { force3D: !0 }),
              (b.spacer = Ge = ge.spacer),
              (ii = Ft(f)),
              (nr = ii[m + L.os2]),
              (Vt = R.getProperty(f)),
              (Ut = R.quickSetter(f, L.a, je)),
              xo(f, Ge, ii),
              (Bt = Qn(f))),
            G)
          ) {
            (M = jr(G) ? Il(G, Bl) : Bl),
              (d = Hn("scroller-start", l, x, L, M, 0)),
              (O = Hn("scroller-end", l, x, L, M, 0, d)),
              (Oe = d["offset" + L.op.d2]);
            var j = yt(Ar(x, "content") || x);
            (Se = this.markerStart = Hn("start", l, j, L, M, Oe, 0, S)),
              (k = this.markerEnd = Hn("end", l, j, L, M, Oe, 0, S)),
              S && (Li = R.quickSetter([Se, k], L.a, je)),
              !B &&
                !(rr.length && Ar(x, "fixedMarkers") === !0) &&
                (lf(q ? pe : x),
                R.set([d, O], { force3D: !0 }),
                (ri = R.quickSetter(d, L.a, je)),
                (Oi = R.quickSetter(O, L.a, je)));
          }
          if (S) {
            var W = S.vars.onUpdate,
              ae = S.vars.onUpdateParams;
            S.eventCallback("onUpdate", function () {
              b.update(0, 0, 1), W && W.apply(S, ae || []);
            });
          }
          if (
            ((b.previous = function () {
              return J[J.indexOf(b) - 1];
            }),
            (b.next = function () {
              return J[J.indexOf(b) + 1];
            }),
            (b.revert = function (N, ie) {
              if (!ie) return b.kill(!0);
              var X = N !== !1 || !b.enabled,
                ee = tt;
              X !== b.isReverted &&
                (X &&
                  ((Gt = Math.max(_e(), b.scroll.rec || 0)),
                  (Ne = b.progress),
                  (si = i && i.progress())),
                Se &&
                  [Se, k, d, O].forEach(function (Ve) {
                    return (Ve.style.display = X ? "none" : "block");
                  }),
                X && ((tt = b), b.update(X)),
                f &&
                  (!y || !b.isActive) &&
                  (X ? hf(f, Ge, I) : xo(f, Ge, Ft(f), bt)),
                X || b.update(X),
                (tt = ee),
                (b.isReverted = X));
            }),
            (b.refresh = function (N, ie, X, ee) {
              if (!((tt || !b.enabled) && !ie)) {
                if (f && N && qt) {
                  $e(s, "scrollEnd", Wl);
                  return;
                }
                !dt && le && le(b),
                  (tt = b),
                  me.tween && !X && (me.tween.kill(), (me.tween = 0)),
                  ne && ne.pause(),
                  h && i && i.revert({ kill: !1 }).invalidate(),
                  b.isReverted || b.revert(!0, !0),
                  (b._subPinOffset = !1);
                var Ve = Re(),
                  se = rt(),
                  Le = S ? S.duration() : hr(x, L),
                  ht = D <= 0.01,
                  Ke = 0,
                  xe = ee || 0,
                  he = jr(X) ? X.end : t.end,
                  Kt = t.endTrigger || p,
                  Te = jr(X)
                    ? X.start
                    : t.start ||
                      (t.start === 0 || !p ? 0 : f ? "0 0" : "0 100%"),
                  Pt = (b.pinnedContainer =
                    t.pinnedContainer && yt(t.pinnedContainer, b)),
                  sr = (p && Math.max(0, J.indexOf(b))) || 0,
                  Ot = sr,
                  Qe,
                  it,
                  oi,
                  rs,
                  nt,
                  Fe,
                  or,
                  Eo,
                  sc,
                  ln,
                  ar,
                  cn,
                  is;
                for (
                  G &&
                  jr(X) &&
                  ((cn = R.getProperty(d, L.p)), (is = R.getProperty(O, L.p)));
                  Ot--;

                )
                  (Fe = J[Ot]),
                    Fe.end || Fe.refresh(0, 1) || (tt = b),
                    (or = Fe.pin),
                    or &&
                      (or === p || or === f || or === Pt) &&
                      !Fe.isReverted &&
                      (ln || (ln = []), ln.unshift(Fe), Fe.revert(!0, !0)),
                    Fe !== J[Ot] && (sr--, Ot--);
                for (
                  ft(Te) && (Te = Te(b)),
                    Te = Al(Te, "start", b),
                    V =
                      Hl(
                        Te,
                        p,
                        Ve,
                        L,
                        _e(),
                        Se,
                        d,
                        b,
                        se,
                        Q,
                        B,
                        Le,
                        S,
                        b._startClamp && "_startClamp"
                      ) || (f ? -0.001 : 0),
                    ft(he) && (he = he(b)),
                    Ct(he) &&
                      !he.indexOf("+=") &&
                      (~he.indexOf(" ")
                        ? (he = (Ct(Te) ? Te.split(" ")[0] : "") + he)
                        : ((Ke = Un(he.substr(2), Ve)),
                          (he = Ct(Te)
                            ? Te
                            : (S
                                ? R.utils.mapRange(
                                    0,
                                    S.duration(),
                                    S.scrollTrigger.start,
                                    S.scrollTrigger.end,
                                    V
                                  )
                                : V) + Ke),
                          (Kt = p))),
                    he = Al(he, "end", b),
                    ce =
                      Math.max(
                        V,
                        Hl(
                          he || (Kt ? "100% 0" : Le),
                          Kt,
                          Ve,
                          L,
                          _e() + Ke,
                          k,
                          O,
                          b,
                          se,
                          Q,
                          B,
                          Le,
                          S,
                          b._endClamp && "_endClamp"
                        )
                      ) || -0.001,
                    Ke = 0,
                    Ot = sr;
                  Ot--;

                )
                  (Fe = J[Ot]),
                    (or = Fe.pin),
                    or &&
                      Fe.start - Fe._pinPush <= V &&
                      !S &&
                      Fe.end > 0 &&
                      ((Qe =
                        Fe.end -
                        (b._startClamp ? Math.max(0, Fe.start) : Fe.start)),
                      ((or === p && Fe.start - Fe._pinPush < V) || or === Pt) &&
                        isNaN(Te) &&
                        (Ke += Qe * (1 - Fe.progress)),
                      or === f && (xe += Qe));
                if (
                  ((V += Ke),
                  (ce += Ke),
                  b._startClamp && (b._startClamp += Ke),
                  b._endClamp &&
                    !dt &&
                    ((b._endClamp = ce || -0.001),
                    (ce = Math.min(ce, hr(x, L)))),
                  (D = ce - V || ((V -= 0.01) && 0.001)),
                  ht &&
                    (Ne = R.utils.clamp(0, 1, R.utils.normalize(V, ce, Gt))),
                  (b._pinPush = xe),
                  Se &&
                    Ke &&
                    ((Qe = {}),
                    (Qe[L.a] = "+=" + Ke),
                    Pt && (Qe[L.p] = "-=" + _e()),
                    R.set([Se, k], Qe)),
                  f)
                )
                  (Qe = Ft(f)),
                    (rs = L === Ie),
                    (oi = _e()),
                    (ti = parseFloat(Vt(L.a)) + xe),
                    !Le &&
                      ce > 1 &&
                      ((ar = (q ? we.scrollingElement || Xt : x).style),
                      (ar = {
                        style: ar,
                        value: ar["overflow" + L.a.toUpperCase()],
                      }),
                      q &&
                        Ft(pe)["overflow" + L.a.toUpperCase()] !== "scroll" &&
                        (ar.style["overflow" + L.a.toUpperCase()] = "scroll")),
                    xo(f, Ge, Qe),
                    (Bt = Qn(f)),
                    (it = pr(f, !0)),
                    (Eo = B && Pr(x, rs ? lt : Ie)()),
                    m &&
                      ((bt = [m + L.os2, D + xe + je]),
                      (bt.t = Ge),
                      (Ot = m === De ? mo(f, L) + D + xe : 0),
                      Ot && bt.push(L.d, Ot + je),
                      Ai(bt),
                      Pt &&
                        J.forEach(function (un) {
                          un.pin === Pt &&
                            un.vars.pinSpacing !== !1 &&
                            (un._subPinOffset = !0);
                        }),
                      B && _e(Gt)),
                    B &&
                      ((nt = {
                        top: it.top + (rs ? oi - V : Eo) + je,
                        left: it.left + (rs ? Eo : oi - V) + je,
                        boxSizing: "border-box",
                        position: "fixed",
                      }),
                      (nt[Gr] = nt["max" + ki] = Math.ceil(it.width) + je),
                      (nt[Kr] = nt["max" + _o] = Math.ceil(it.height) + je),
                      (nt[It] =
                        nt[It + rn] =
                        nt[It + en] =
                        nt[It + nn] =
                        nt[It + tn] =
                          "0"),
                      (nt[De] = Qe[De]),
                      (nt[De + rn] = Qe[De + rn]),
                      (nt[De + en] = Qe[De + en]),
                      (nt[De + nn] = Qe[De + nn]),
                      (nt[De + tn] = Qe[De + tn]),
                      (oe = _f(I, nt, y)),
                      dt && _e(0)),
                    i
                      ? ((sc = i._initted),
                        so(1),
                        i.render(i.duration(), !0, !0),
                        (mr = Vt(L.a) - ti + D + xe),
                        (Pi = Math.abs(D - mr) > 1),
                        B && Pi && oe.splice(oe.length - 2, 2),
                        i.render(0, !0, !0),
                        sc || i.invalidate(!0),
                        i.parent || i.totalTime(i.totalTime()),
                        so(0))
                      : (mr = D),
                    ar &&
                      (ar.value
                        ? (ar.style["overflow" + L.a.toUpperCase()] = ar.value)
                        : ar.style.removeProperty("overflow-" + L.a));
                else if (p && _e() && !S)
                  for (it = p.parentNode; it && it !== pe; )
                    it._pinOffset &&
                      ((V -= it._pinOffset), (ce -= it._pinOffset)),
                      (it = it.parentNode);
                ln &&
                  ln.forEach(function (un) {
                    return un.revert(!1, !0);
                  }),
                  (b.start = V),
                  (b.end = ce),
                  (ve = Xe = dt ? Gt : _e()),
                  !S && !dt && (ve < Gt && _e(Gt), (b.scroll.rec = 0)),
                  b.revert(!1, !0),
                  (Ce = ut()),
                  jt && ((de = -1), jt.restart(!0)),
                  (tt = 0),
                  i &&
                    z &&
                    (i._initted || si) &&
                    i.progress() !== si &&
                    i.progress(si || 0, !0).render(i.time(), !0, !0),
                  (ht || Ne !== b.progress || S) &&
                    (i &&
                      !z &&
                      i.totalProgress(
                        S && V < -0.001 && !Ne
                          ? R.utils.normalize(V, ce, 0)
                          : Ne,
                        !0
                      ),
                    (b.progress = ht || (ve - V) / D === Ne ? 0 : Ne)),
                  f && m && (Ge._pinOffset = Math.round(b.progress * mr)),
                  ne && ne.invalidate(),
                  isNaN(cn) ||
                    ((cn -= R.getProperty(d, L.p)),
                    (is -= R.getProperty(O, L.p)),
                    Zn(d, L, cn),
                    Zn(Se, L, cn - (ee || 0)),
                    Zn(O, L, is),
                    Zn(k, L, is - (ee || 0))),
                  ht && !dt && b.update(),
                  u && !dt && !Y && ((Y = !0), u(b), (Y = !1));
              }
            }),
            (b.getVelocity = function () {
              return ((_e() - Xe) / (ut() - Nn)) * 1e3 || 0;
            }),
            (b.endAnimation = function () {
              Zi(b.callbackAnimation),
                i &&
                  (ne
                    ? ne.progress(1)
                    : i.paused()
                    ? z || Zi(i, b.direction < 0, 1)
                    : Zi(i, i.reversed()));
            }),
            (b.labelToScroll = function (N) {
              return (
                (i &&
                  i.labels &&
                  (V || b.refresh() || V) + (i.labels[N] / i.duration()) * D) ||
                0
              );
            }),
            (b.getTrailing = function (N) {
              var ie = J.indexOf(b),
                X =
                  b.direction > 0 ? J.slice(0, ie).reverse() : J.slice(ie + 1);
              return (
                Ct(N)
                  ? X.filter(function (ee) {
                      return ee.vars.preventOverlaps === N;
                    })
                  : X
              ).filter(function (ee) {
                return b.direction > 0 ? ee.end <= V : ee.start >= ce;
              });
            }),
            (b.update = function (N, ie, X) {
              if (!(S && !X && !N)) {
                var ee = dt === !0 ? Gt : b.scroll(),
                  Ve = N ? 0 : (ee - V) / D,
                  se = Ve < 0 ? 0 : Ve > 1 ? 1 : Ve || 0,
                  Le = b.progress,
                  ht,
                  Ke,
                  xe,
                  he,
                  Kt,
                  Te,
                  Pt,
                  sr;
                if (
                  (ie &&
                    ((Xe = ve),
                    (ve = S ? _e() : ee),
                    g && ((Mr = Lr), (Lr = i && !z ? i.totalProgress() : se))),
                  v &&
                    !se &&
                    f &&
                    !tt &&
                    !Fn &&
                    qt &&
                    V < ee + ((ee - Xe) / (ut() - Nn)) * v &&
                    (se = 1e-4),
                  se !== Le && b.enabled)
                ) {
                  if (
                    ((ht = b.isActive = !!se && se < 1),
                    (Ke = !!Le && Le < 1),
                    (Te = ht !== Ke),
                    (Kt = Te || !!se != !!Le),
                    (b.direction = se > Le ? 1 : -1),
                    (b.progress = se),
                    Kt &&
                      !tt &&
                      ((xe = se && !Le ? 0 : se === 1 ? 1 : Le === 1 ? 2 : 3),
                      z &&
                        ((he =
                          (!Te && F[xe + 1] !== "none" && F[xe + 1]) || F[xe]),
                        (sr =
                          i &&
                          (he === "complete" || he === "reset" || he in i)))),
                    C &&
                      (Te || sr) &&
                      (sr || _ || !i) &&
                      (ft(C)
                        ? C(b)
                        : b.getTrailing(C).forEach(function (oi) {
                            return oi.endAnimation();
                          })),
                    z ||
                      (ne && !tt && !Fn
                        ? (ne._dp._time - ne._start !== ne._time &&
                            ne.render(ne._dp._time - ne._start),
                          ne.resetTo
                            ? ne.resetTo(
                                "totalProgress",
                                se,
                                i._tTime / i._tDur
                              )
                            : ((ne.vars.totalProgress = se),
                              ne.invalidate().restart()))
                        : i && i.totalProgress(se, !!(tt && (Ce || N)))),
                    f)
                  ) {
                    if ((N && m && (Ge.style[m + L.os2] = nr), !B))
                      Ut(Ji(ti + mr * se));
                    else if (Kt) {
                      if (
                        ((Pt =
                          !N && se > Le && ce + 1 > ee && ee + 1 >= hr(x, L)),
                        y)
                      )
                        if (!N && (ht || Pt)) {
                          var Ot = pr(f, !0),
                            Qe = ee - V;
                          jl(
                            f,
                            pe,
                            Ot.top + (L === Ie ? Qe : 0) + je,
                            Ot.left + (L === Ie ? 0 : Qe) + je
                          );
                        } else jl(f, Ge);
                      Ai(ht || Pt ? oe : Bt),
                        (Pi && se < 1 && ht) ||
                          Ut(ti + (se === 1 && !Pt ? mr : 0));
                    }
                  }
                  g && !me.tween && !tt && !Fn && jt.restart(!0),
                    a &&
                      (Te || (P && se && (se < 1 || !co))) &&
                      Rn(a.targets).forEach(function (oi) {
                        return oi.classList[ht || P ? "add" : "remove"](
                          a.className
                        );
                      }),
                    o && !z && !N && o(b),
                    Kt && !tt
                      ? (z &&
                          (sr &&
                            (he === "complete"
                              ? i.pause().totalProgress(1)
                              : he === "reset"
                              ? i.restart(!0).pause()
                              : he === "restart"
                              ? i.restart(!0)
                              : i[he]()),
                          o && o(b)),
                        (Te || !co) &&
                          (c && Te && fo(b, c),
                          U[xe] && fo(b, U[xe]),
                          P && (se === 1 ? b.kill(!1, 1) : (U[xe] = 0)),
                          Te ||
                            ((xe = se === 1 ? 1 : 3), U[xe] && fo(b, U[xe]))),
                        A &&
                          !ht &&
                          Math.abs(b.getVelocity()) > ($n(A) ? A : 2500) &&
                          (Zi(b.callbackAnimation),
                          ne
                            ? ne.progress(1)
                            : Zi(i, he === "reverse" ? 1 : !se, 1)))
                      : z && o && !tt && o(b);
                }
                if (Oi) {
                  var it = S
                    ? (ee / S.duration()) * (S._caScrollDist || 0)
                    : ee;
                  ri(it + (d._isFlipped ? 1 : 0)), Oi(it);
                }
                Li && Li((-ee / S.duration()) * (S._caScrollDist || 0));
              }
            }),
            (b.enable = function (N, ie) {
              b.enabled ||
                ((b.enabled = !0),
                $e(x, "resize", on),
                q || $e(x, "scroll", Ci),
                le && $e(s, "refreshInit", le),
                N !== !1 && ((b.progress = Ne = 0), (ve = Xe = de = _e())),
                ie !== !1 && b.refresh());
            }),
            (b.getTween = function (N) {
              return N && me ? me.tween : ne;
            }),
            (b.setPositions = function (N, ie, X, ee) {
              if (S) {
                var Ve = S.scrollTrigger,
                  se = S.duration(),
                  Le = Ve.end - Ve.start;
                (N = Ve.start + (Le * N) / se),
                  (ie = Ve.start + (Le * ie) / se);
              }
              b.refresh(
                !1,
                !1,
                {
                  start: Pl(N, X && !!b._startClamp),
                  end: Pl(ie, X && !!b._endClamp),
                },
                ee
              ),
                b.update();
            }),
            (b.adjustPinSpacing = function (N) {
              if (bt && N) {
                var ie = bt.indexOf(L.d) + 1;
                (bt[ie] = parseFloat(bt[ie]) + N + je),
                  (bt[1] = parseFloat(bt[1]) + N + je),
                  Ai(bt);
              }
            }),
            (b.disable = function (N, ie) {
              if (
                b.enabled &&
                (N !== !1 && b.revert(!0, !0),
                (b.enabled = b.isActive = !1),
                ie || (ne && ne.pause()),
                (Gt = 0),
                ge && (ge.uncache = 1),
                le && We(s, "refreshInit", le),
                jt &&
                  (jt.pause(), me.tween && me.tween.kill() && (me.tween = 0)),
                !q)
              ) {
                for (var X = J.length; X--; )
                  if (J[X].scroller === x && J[X] !== b) return;
                We(x, "resize", on), q || We(x, "scroll", Ci);
              }
            }),
            (b.kill = function (N, ie) {
              b.disable(N, ie), ne && !ie && ne.kill(), l && delete vo[l];
              var X = J.indexOf(b);
              X >= 0 && J.splice(X, 1),
                X === ct && Gn > 0 && ct--,
                (X = 0),
                J.forEach(function (ee) {
                  return ee.scroller === b.scroller && (X = 1);
                }),
                X || dt || (b.scroll.rec = 0),
                i &&
                  ((i.scrollTrigger = null),
                  N && i.revert({ kill: !1 }),
                  ie || i.kill()),
                Se &&
                  [Se, k, d, O].forEach(function (ee) {
                    return ee.parentNode && ee.parentNode.removeChild(ee);
                  }),
                an === b && (an = 0),
                f &&
                  (ge && (ge.uncache = 1),
                  (X = 0),
                  J.forEach(function (ee) {
                    return ee.pin === f && X++;
                  }),
                  X || (ge.spacer = 0)),
                t.onKill && t.onKill(b);
            }),
            J.push(b),
            b.enable(!1, !1),
            gr && gr(b),
            i && i.add && !D)
          ) {
            var Ae = b.update;
            (b.update = function () {
              (b.update = Ae), V || ce || b.refresh();
            }),
              R.delayedCall(0.01, b.update),
              (D = 0.01),
              (V = ce = 0);
          } else b.refresh();
          f && df();
        }),
        (s.register = function (t) {
          return (
            wi ||
              ((R = t || zl()),
              Ml() && window.document && s.enable(),
              (wi = Qi)),
            wi
          );
        }),
        (s.defaults = function (t) {
          if (t) for (var i in t) Xn[i] = t[i];
          return Xn;
        }),
        (s.disable = function (t, i) {
          (Qi = 0),
            J.forEach(function (o) {
              return o[i ? "kill" : "disable"](t);
            }),
            We(re, "wheel", Ci),
            We(we, "scroll", Ci),
            clearInterval(qn),
            We(we, "touchcancel", ir),
            We(pe, "touchstart", ir),
            Wn(We, we, "pointerdown,touchstart,mousedown", Ol),
            Wn(We, we, "pointerup,touchend,mouseup", Ll),
            Dn.kill(),
            Bn(We);
          for (var n = 0; n < Z.length; n += 3)
            Yn(We, Z[n], Z[n + 1]), Yn(We, Z[n], Z[n + 2]);
        }),
        (s.enable = function () {
          if (
            ((re = window),
            (we = document),
            (Xt = we.documentElement),
            (pe = we.body),
            R &&
              ((Rn = R.utils.toArray),
              (Si = R.utils.clamp),
              (oo = R.core.context || ir),
              (so = R.core.suppressOverwrites || ir),
              (ao = re.history.scrollRestoration || "auto"),
              (wo = re.pageYOffset),
              R.core.globals("ScrollTrigger", s),
              pe))
          ) {
            (Qi = 1),
              (Ti = document.createElement("div")),
              (Ti.style.height = "100vh"),
              (Ti.style.position = "absolute"),
              Ul(),
              sf(),
              ze.register(R),
              (s.isTouch = ze.isTouch),
              (Or =
                ze.isTouch &&
                /(iPad|iPhone|iPod|Mac)/g.test(navigator.userAgent)),
              $e(re, "wheel", Ci),
              (bl = [re, we, Xt, pe]),
              R.matchMedia
                ? ((s.matchMedia = function (l) {
                    var c = R.matchMedia(),
                      u;
                    for (u in l) c.add(u, l[u]);
                    return c;
                  }),
                  R.addEventListener("matchMediaInit", function () {
                    return bo();
                  }),
                  R.addEventListener("matchMediaRevert", function () {
                    return Yl();
                  }),
                  R.addEventListener("matchMedia", function () {
                    ei(0, 1), Jr("matchMedia");
                  }),
                  R.matchMedia("(orientation: portrait)", function () {
                    return yo(), yo;
                  }))
                : console.warn("Requires GSAP 3.11.0 or later"),
              yo(),
              $e(we, "scroll", Ci);
            var t = pe.style,
              i = t.borderTopStyle,
              n = R.core.Animation.prototype,
              o,
              a;
            for (
              n.revert ||
                Object.defineProperty(n, "revert", {
                  value: function () {
                    return this.time(-0.01, !0);
                  },
                }),
                t.borderTopStyle = "solid",
                o = pr(pe),
                Ie.m = Math.round(o.top + Ie.sc()) || 0,
                lt.m = Math.round(o.left + lt.sc()) || 0,
                i
                  ? (t.borderTopStyle = i)
                  : t.removeProperty("border-top-style"),
                qn = setInterval($l, 250),
                R.delayedCall(0.5, function () {
                  return (Fn = 0);
                }),
                $e(we, "touchcancel", ir),
                $e(pe, "touchstart", ir),
                Wn($e, we, "pointerdown,touchstart,mousedown", Ol),
                Wn($e, we, "pointerup,touchend,mouseup", Ll),
                no = R.utils.checkPrefix("transform"),
                Kn.push(no),
                wi = ut(),
                Dn = R.delayedCall(0.2, ei).pause(),
                xi = [
                  we,
                  "visibilitychange",
                  function () {
                    var l = re.innerWidth,
                      c = re.innerHeight;
                    we.hidden
                      ? ((wl = l), (Sl = c))
                      : (wl !== l || Sl !== c) && on();
                  },
                  we,
                  "DOMContentLoaded",
                  ei,
                  re,
                  "load",
                  ei,
                  re,
                  "resize",
                  on,
                ],
                Bn($e),
                J.forEach(function (l) {
                  return l.enable(0, 1);
                }),
                a = 0;
              a < Z.length;
              a += 3
            )
              Yn(We, Z[a], Z[a + 1]), Yn(We, Z[a], Z[a + 2]);
          }
        }),
        (s.config = function (t) {
          "limitCallbacks" in t && (co = !!t.limitCallbacks);
          var i = t.syncInterval;
          (i && clearInterval(qn)) || ((qn = i) && setInterval($l, i)),
            "ignoreMobileResize" in t &&
              (El = s.isTouch === 1 && t.ignoreMobileResize),
            "autoRefreshEvents" in t &&
              (Bn(We) || Bn($e, t.autoRefreshEvents || "none"),
              (Tl = (t.autoRefreshEvents + "").indexOf("resize") === -1));
        }),
        (s.scrollerProxy = function (t, i) {
          var n = yt(t),
            o = Z.indexOf(n),
            a = Hr(n);
          ~o && Z.splice(o, a ? 6 : 2),
            i && (a ? rr.unshift(re, i, pe, i, Xt, i) : rr.unshift(n, i));
        }),
        (s.clearMatchMedia = function (t) {
          J.forEach(function (i) {
            return i._ctx && i._ctx.query === t && i._ctx.kill(!0, !0);
          });
        }),
        (s.isInViewport = function (t, i, n) {
          var o = (Ct(t) ? yt(t) : t).getBoundingClientRect(),
            a = o[n ? Gr : Kr] * i || 0;
          return n
            ? o.right - a > 0 && o.left + a < re.innerWidth
            : o.bottom - a > 0 && o.top + a < re.innerHeight;
        }),
        (s.positionInViewport = function (t, i, n) {
          Ct(t) && (t = yt(t));
          var o = t.getBoundingClientRect(),
            a = o[n ? Gr : Kr],
            l =
              i == null
                ? a / 2
                : i in Vn
                ? Vn[i] * a
                : ~i.indexOf("%")
                ? (parseFloat(i) * a) / 100
                : parseFloat(i) || 0;
          return n
            ? (o.left + l) / re.innerWidth
            : (o.top + l) / re.innerHeight;
        }),
        (s.killAll = function (t) {
          if (
            (J.slice(0).forEach(function (n) {
              return n.vars.id !== "ScrollSmoother" && n.kill();
            }),
            t !== !0)
          ) {
            var i = Qr.killAll || [];
            (Qr = {}),
              i.forEach(function (n) {
                return n();
              });
          }
        }),
        s
      );
    })();
  (K.version = "3.12.2"),
    (K.saveStyles = function (s) {
      return s
        ? Rn(s).forEach(function (e) {
            if (e && e.style) {
              var r = At.indexOf(e);
              r >= 0 && At.splice(r, 5),
                At.push(
                  e,
                  e.style.cssText,
                  e.getBBox && e.getAttribute("transform"),
                  R.core.getCache(e),
                  oo()
                );
            }
          })
        : At;
    }),
    (K.revert = function (s, e) {
      return bo(!s, e);
    }),
    (K.create = function (s, e) {
      return new K(s, e);
    }),
    (K.refresh = function (s) {
      return s ? on() : (wi || K.register()) && ei(!0);
    }),
    (K.update = function (s) {
      return ++Z.cache && _r(s === !0 ? 2 : 0);
    }),
    (K.clearScrollMemory = Xl),
    (K.maxScroll = function (s, e) {
      return hr(s, e ? lt : Ie);
    }),
    (K.getScrollFunc = function (s, e) {
      return Pr(yt(s), e ? lt : Ie);
    }),
    (K.getById = function (s) {
      return vo[s];
    }),
    (K.getAll = function () {
      return J.filter(function (s) {
        return s.vars.id !== "ScrollSmoother";
      });
    }),
    (K.isScrolling = function () {
      return !!qt;
    }),
    (K.snapDirectional = go),
    (K.addEventListener = function (s, e) {
      var r = Qr[s] || (Qr[s] = []);
      ~r.indexOf(e) || r.push(e);
    }),
    (K.removeEventListener = function (s, e) {
      var r = Qr[s],
        t = r && r.indexOf(e);
      t >= 0 && r.splice(t, 1);
    }),
    (K.batch = function (s, e) {
      var r = [],
        t = {},
        i = e.interval || 0.016,
        n = e.batchMax || 1e9,
        o = function (c, u) {
          var _ = [],
            p = [],
            f = R.delayedCall(i, function () {
              u(_, p), (_ = []), (p = []);
            }).pause();
          return function (m) {
            _.length || f.restart(!0),
              _.push(m.trigger),
              p.push(m),
              n <= _.length && f.progress(1);
          };
        },
        a;
      for (a in e)
        t[a] =
          a.substr(0, 2) === "on" && ft(e[a]) && a !== "onRefreshInit"
            ? o(a, e[a])
            : e[a];
      return (
        ft(n) &&
          ((n = n()),
          $e(K, "refresh", function () {
            return (n = e.batchMax());
          })),
        Rn(s).forEach(function (l) {
          var c = {};
          for (a in t) c[a] = t[a];
          (c.trigger = l), r.push(K.create(c));
        }),
        r
      );
    });
  var Ql = function (e, r, t, i) {
      return (
        r > i ? e(i) : r < 0 && e(0),
        t > i ? (i - r) / (t - r) : t < 0 ? r / (r - t) : 1
      );
    },
    To = function s(e, r) {
      r === !0
        ? e.style.removeProperty("touch-action")
        : (e.style.touchAction =
            r === !0
              ? "auto"
              : r
              ? "pan-" + r + (ze.isTouch ? " pinch-zoom" : "")
              : "none"),
        e === Xt && s(pe, r);
    },
    es = { auto: 1, scroll: 1 },
    gf = function (e) {
      var r = e.event,
        t = e.target,
        i = e.axis,
        n = (r.changedTouches ? r.changedTouches[0] : r).target,
        o = n._gsap || R.core.getCache(n),
        a = ut(),
        l;
      if (!o._isScrollT || a - o._isScrollT > 2e3) {
        for (
          ;
          n &&
          n !== pe &&
          ((n.scrollHeight <= n.clientHeight &&
            n.scrollWidth <= n.clientWidth) ||
            !(es[(l = Ft(n)).overflowY] || es[l.overflowX]));

        )
          n = n.parentNode;
        (o._isScroll =
          n &&
          n !== t &&
          !Hr(n) &&
          (es[(l = Ft(n)).overflowY] || es[l.overflowX])),
          (o._isScrollT = a);
      }
      (o._isScroll || i === "x") && (r.stopPropagation(), (r._gsapAllow = !0));
    },
    Jl = function (e, r, t, i) {
      return ze.create({
        target: e,
        capture: !0,
        debounce: !1,
        lockAxis: !0,
        type: r,
        onWheel: (i = i && gf),
        onPress: i,
        onDrag: i,
        onScroll: i,
        onEnable: function () {
          return t && $e(we, ze.eventTypes[0], ec, !1, !0);
        },
        onDisable: function () {
          return We(we, ze.eventTypes[0], ec, !0);
        },
      });
    },
    vf = /(input|label|select|textarea)/i,
    Zl,
    ec = function (e) {
      var r = vf.test(e.target.tagName);
      (r || Zl) && ((e._gsapAllow = !0), (Zl = r));
    },
    yf = function (e) {
      jr(e) || (e = {}),
        (e.preventDefault = e.isNormalizer = e.allowClicks = !0),
        e.type || (e.type = "wheel,touch"),
        (e.debounce = !!e.debounce),
        (e.id = e.id || "normalizer");
      var r = e,
        t = r.normalizeScrollX,
        i = r.momentum,
        n = r.allowNestedScroll,
        o = r.onRelease,
        a,
        l,
        c = yt(e.target) || Xt,
        u = R.core.globals().ScrollSmoother,
        _ = u && u.get(),
        p =
          Or &&
          ((e.content && yt(e.content)) ||
            (_ && e.content !== !1 && !_.smooth() && _.content())),
        f = Pr(c, Ie),
        m = Pr(c, lt),
        h = 1,
        v =
          (ze.isTouch && re.visualViewport
            ? re.visualViewport.scale * re.visualViewport.width
            : re.outerWidth) / re.innerWidth,
        T = 0,
        E = ft(i)
          ? function () {
              return i(a);
            }
          : function () {
              return i || 2.8;
            },
        P,
        g,
        y = Jl(c, e.type, !0, n),
        w = function () {
          return (g = !1);
        },
        S = ir,
        A = ir,
        C = function () {
          (l = hr(c, Ie)),
            (A = Si(Or ? 1 : 0, l)),
            t && (S = Si(0, hr(c, lt))),
            (P = Zr);
        },
        L = function () {
          (p._gsap.y = Ji(parseFloat(p._gsap.y) + f.offset) + "px"),
            (p.style.transform =
              "matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, " +
              parseFloat(p._gsap.y) +
              ", 0, 1)"),
            (f.offset = f.cacheID = 0);
        },
        z = function () {
          if (g) {
            requestAnimationFrame(w);
            var G = Ji(a.deltaY / 2),
              Q = A(f.v - G);
            if (p && Q !== f.v + f.offset) {
              f.offset = Q - f.v;
              var b = Ji((parseFloat(p && p._gsap.y) || 0) - f.offset);
              (p.style.transform =
                "matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, " +
                b +
                ", 0, 1)"),
                (p._gsap.y = b + "px"),
                (f.cacheID = Z.cache),
                _r();
            }
            return !0;
          }
          f.offset && L(), (g = !0);
        },
        x,
        H,
        q,
        B,
        U = function () {
          C(),
            x.isActive() &&
              x.vars.scrollY > l &&
              (f() > l ? x.progress(1) && f(l) : x.resetTo("scrollY", l));
        };
      return (
        p && R.set(p, { y: "+=0" }),
        (e.ignoreCheck = function (F) {
          return (
            (Or && F.type === "touchmove" && z()) ||
            (h > 1.05 && F.type !== "touchstart") ||
            a.isGesturing ||
            (F.touches && F.touches.length > 1)
          );
        }),
        (e.onPress = function () {
          g = !1;
          var F = h;
          (h = Ji(((re.visualViewport && re.visualViewport.scale) || 1) / v)),
            x.pause(),
            F !== h && To(c, h > 1.01 ? !0 : t ? !1 : "x"),
            (H = m()),
            (q = f()),
            C(),
            (P = Zr);
        }),
        (e.onRelease = e.onGestureStart =
          function (F, G) {
            if ((f.offset && L(), !G)) B.restart(!0);
            else {
              Z.cache++;
              var Q = E(),
                b,
                le;
              t &&
                ((b = m()),
                (le = b + (Q * 0.05 * -F.velocityX) / 0.227),
                (Q *= Ql(m, b, le, hr(c, lt))),
                (x.vars.scrollX = S(le))),
                (b = f()),
                (le = b + (Q * 0.05 * -F.velocityY) / 0.227),
                (Q *= Ql(f, b, le, hr(c, Ie))),
                (x.vars.scrollY = A(le)),
                x.invalidate().duration(Q).play(0.01),
                ((Or && x.vars.scrollY >= l) || b >= l - 1) &&
                  R.to({}, { onUpdate: U, duration: Q });
            }
            o && o(F);
          }),
        (e.onWheel = function () {
          x._ts && x.pause(), ut() - T > 1e3 && ((P = 0), (T = ut()));
        }),
        (e.onChange = function (F, G, Q, b, le) {
          if (
            (Zr !== P && C(),
            G && t && m(S(b[2] === G ? H + (F.startX - F.x) : m() + G - b[1])),
            Q)
          ) {
            f.offset && L();
            var Re = le[2] === Q,
              rt = Re ? q + F.startY - F.y : f() + Q - le[1],
              de = A(rt);
            Re && rt !== de && (q += de - rt), f(de);
          }
          (Q || G) && _r();
        }),
        (e.onEnable = function () {
          To(c, t ? !1 : "x"),
            K.addEventListener("refresh", U),
            $e(re, "resize", U),
            f.smooth &&
              ((f.target.style.scrollBehavior = "auto"),
              (f.smooth = m.smooth = !1)),
            y.enable();
        }),
        (e.onDisable = function () {
          To(c, !0),
            We(re, "resize", U),
            K.removeEventListener("refresh", U),
            y.kill();
        }),
        (e.lockAxis = e.lockAxis !== !1),
        (a = new ze(e)),
        (a.iOS = Or),
        Or && !f() && f(1),
        Or && R.ticker.add(ir),
        (B = a._dc),
        (x = R.to(a, {
          ease: "power4",
          paused: !0,
          scrollX: t ? "+=0.1" : "+=0",
          scrollY: "+=0.1",
          modifiers: {
            scrollY: Gl(f, f(), function () {
              return x.pause();
            }),
          },
          onUpdate: _r,
          onComplete: B.vars.onComplete,
        })),
        a
      );
    };
  (K.sort = function (s) {
    return J.sort(
      s ||
        function (e, r) {
          return (
            (e.vars.refreshPriority || 0) * -1e6 +
            e.start -
            (r.start + (r.vars.refreshPriority || 0) * -1e6)
          );
        }
    );
  }),
    (K.observe = function (s) {
      return new ze(s);
    }),
    (K.normalizeScroll = function (s) {
      if (typeof s == "undefined") return kt;
      if (s === !0 && kt) return kt.enable();
      if (s === !1) return kt && kt.kill();
      var e = s instanceof ze ? s : yf(s);
      return (
        kt && kt.target === e.target && kt.kill(), Hr(e.target) && (kt = e), e
      );
    }),
    (K.core = {
      _getVelocityProp: io,
      _inputObserver: Jl,
      _scrollers: Z,
      _proxies: rr,
      bridge: {
        ss: function () {
          qt || Jr("scrollStart"), (qt = ut());
        },
        ref: function () {
          return tt;
        },
      },
    }),
    zl() && R.registerPlugin(K);
  function bf() {
    qe.registerPlugin(K);
    const s = new ul();
    qe.timeline(),
      s.on("scroll", K.update),
      qe.ticker.add((g) => {
        s.raf(g * 1e3);
      }),
      qe.ticker.lagSmoothing(0),
      new Ic("[text-split], [from-bottom]", {
        types: "words, chars",
        tagName: "span",
      });
    function e() {
      const g = document.querySelectorAll(".horizontal-item"),
        y = document.querySelector(".horizontal-section"),
        w = document.querySelector(".horizontal-sticky__content");
      if (w) {
        const S = w.offsetWidth,
          A = (g.length - 1) * 100,
          C = () => {
            window.innerWidth > 991
              ? (y.style.height = `${S / 16}rem`)
              : (y.style.height = "auto");
          };
        C(),
          window.addEventListener("resize", C),
          qe.matchMedia().add("(min-width: 991px)", () => {
            qe.to(".horizontal-item", {
              xPercent: -A,
              ease: "none",
              scrollTrigger: {
                trigger: ".horizontal-section",
                start: "top top",
                end: "bottom bottom",
                scrub: !0,
              },
            }),
              g.forEach((z) => {
                const H = (0.5 + Math.random() * 0.5) * 300;
                qe.to(z.querySelectorAll(".image-full"), {
                  x: () => `${H}px`,
                  ease: "none",
                  scrollTrigger: {
                    trigger: ".horizontal-section",
                    start: "top top",
                    end: "bottom bottom",
                    scrub: !0,
                  },
                });
              });
          });
      }
    }
    e();
    function r(g) {
      document.querySelectorAll("[animate]").forEach(function (y, w) {
        qe.from(y.querySelectorAll(".char"), {
          opacity: 0,
          yPercent: 100,
          duration: 0.5,
          stagger: { amount: 0.5 },
          delay: g,
          ease: ".19,1,.22,1",
        });
      }),
        qe.from(".hero-background", {
          y: "-10%",
          "-webkit-filter": "blur(8px)",
          filter: "blur(8px)",
          opacity: 0,
          delay: g + 0.25,
          duration: 0.7,
          ease: ".19,1,.22,1",
        });
    }
    r(2.4);
    function t(g, y, w, S) {
      qe.timeline({
        scrollTrigger: { trigger: g, start: y, end: w, scrub: 1 },
      }).to(g, { y: S, duration: 1 });
    }
    const i = document.querySelectorAll(
      ".hero-background, .customize-content__main"
    );
    t(i[0], "top top", "bottom top", "-100%"),
      t(i[1], "top bottom", "bottom top", "-20%");
    function n() {
      function g(y, w) {
        const S = window.innerWidth > 991 ? "top 90%" : "top bottom";
        K.create({
          trigger: y,
          start: "top bottom",
          onLeaveBack: () => {
            w.progress(0), w.pause();
          },
        }),
          K.create({
            trigger: y,
            start: S,
            onEnter: () => {
              w.play();
            },
          });
      }
      $("[from-bottom]").each(function (y) {
        let w = $(this).attr("from-bottom");
        const S = window.innerWidth > 991 ? 100 : 50;
        let A = qe.timeline({ paused: !0 });
        A.from($(this).find(".char"), {
          opacity: 0,
          yPercent: S,
          duration: 0.3,
          stagger: { amount: 0.5 },
          ease: ".19,1,.22,1",
          delay: w ? parseFloat(w) : 0,
        }),
          g($(this), A);
      }),
        $("[data-bottom]").each(function (y) {
          let w = qe.timeline({ paused: !0 });
          w.from($(this).find("[data-animate]"), {
            opacity: 0,
            yPercent: 50,
            duration: 0.5,
            stagger: { amount: 0.4 },
            ease: ".19,1,.22,1",
          }),
            g($(this), w);
        }),
        document
          .querySelectorAll(".content-full__asset")
          .forEach(function (y, w) {
            let S = qe.timeline({ paused: !0 }),
              A = qe.from(y.querySelector(".image-mask.mask--vertical-full"), {
                height: "100%",
                duration: 0.8,
                ease: ".19,1,.22,1",
              }),
              C = qe.from(
                y.querySelector(".image-mask.mask--horizontal-full"),
                { width: "100%", duration: 0.8, ease: ".19,1,.22,1" }
              ),
              L = qe.from(y.querySelector(".content-full__asset-image"), {
                scale: 1.2,
                duration: 0.8,
                ease: ".19,1,.22,1",
              }),
              z = qe.from(y.querySelector(".triangle-wrapper"), {
                width: "0%",
                height: "0%",
                duration: 0.8,
                ease: ".19,1,.22,1",
              });
            S.add([A, C, L, z], 0), g(y, S);
          });
    }
    n();
    function o() {
      const g = document.querySelector(".step-content__grid"),
        y = document.querySelectorAll(".step-grid__item-number");
      let w = !1;
      const S = () => {
          y.forEach((z) => {
            z.classList.remove("is--active");
          });
        },
        A = (z) => {
          z.classList.add("is--active");
        };
      function C(z, x) {
        z.forEach((H, q) => {
          setTimeout(() => {
            S(), x(H);
          }, q * 500);
        });
      }
      const L = (z, x) => {
        qe.to(z, {
          scrollTrigger: {
            trigger: g,
            start: "top center",
            end: "bottom center",
            scrub: 1,
            onEnter: () => {
              w || ((w = !0), console.log("triggered"), S(), C(y, A));
            },
            onLeaveBack: () => {},
          },
        });
      };
      y.forEach((z, x) => {
        L(z);
      });
    }
    setTimeout(o, 2e3);
    function a() {
      const g = document.querySelector(".footer"),
        y = document.querySelector(".cta-trigger");
      g &&
        y &&
        new IntersectionObserver(function (S) {
          S.forEach(function (A) {
            A.isIntersecting
              ? y.classList.add("is--hidden")
              : y.classList.remove("is--hidden");
          });
        }).observe(g);
    }
    a();
    const l = document.querySelectorAll(".w-checkbox-input--inputType-custom");
    function c(g) {
      g.forEach((y) => {
        if (y.type === "attributes" && y.attributeName === "class") {
          const w = y.target;
          if (w.classList.contains("cc-error")) {
            const S = w.parentElement;
            S && S.classList.add("cc-error");
          } else {
            const S = w.parentElement;
            S && S.classList.remove("cc-error");
          }
        }
      });
    }
    l.forEach((g) => {
      const y = new MutationObserver(c),
        w = { attributes: !0, attributeFilter: ["class"] };
      y.observe(g, w);
    });
    const u = {
      init: () => {
        u.rippleEffectMovement();
      },
      rippleEffectMovement: () => {
        document.querySelectorAll(".submit-button").forEach((y) => {
          const w = y.querySelector(".span");
          y.addEventListener("mousemove", function (S) {
            const A = y.getBoundingClientRect(),
              C = S.clientX - A.left,
              L = S.clientY - A.top;
            (w.style.left = `${C}px`), (w.style.top = `${L}px`);
          });
        });
      },
    };
    u.init();
    var _ = document.querySelectorAll(".submit-button");
    _.length > 0 &&
      _.forEach(function (g) {
        g.addEventListener("click", function (y) {
          y.preventDefault();
          var w = g.nextElementSibling;
          w ? w.click() : console.error("Parent form not found");
        });
      });
    const p = document.querySelectorAll(".nav-link, a.is--nav"),
      f = () => {
        document.querySelector(".navbar-menu__open-button").click();
      };
    p.forEach((g) => {
      g.addEventListener("click", f);
    });
    const m = document.getElementById("nav-button");
    m.addEventListener("click", () => {
      h(m);
    });
    function h(g) {
      g.querySelector(".text-size-0-625"),
        g.classList.contains("w--open")
          ? (document.querySelector("body").classList.remove("overflow-hidden"),
            s.start())
          : (document.querySelector("body").classList.add("overflow-hidden"),
            s.stop());
    }
    document
      .querySelectorAll(".faq-content__main-number")
      .forEach(function (g, y) {
        const w = y + 1;
        g.textContent = w;
      }),
      document.querySelectorAll("img").forEach((g) => {
        g.removeAttribute("srcset");
      });
    const E = new Swiper(".swiper", {
      spaceBetween: 20,
      navigation: {
        nextEl: ".slider-button__next",
        prevEl: ".slider-button__prev",
      },
    });
    document.querySelectorAll('[data-sidebar="slider"]').forEach((g, y) => {
      g.addEventListener("click", () => {
        E.slideTo(y);
      });
    });
  }
  function wf() {
    const s = new ul(),
      e = document.querySelectorAll('[data-sidebar="slider"]'),
      r = document.querySelectorAll('[data-sidebar="form"]'),
      t = document.querySelectorAll('[data-sidebar="cta"]'),
      i = document.querySelectorAll('[data-sidebar="slider-close"]'),
      n = document.querySelectorAll('[data-sidebar="form-close"]'),
      o = document.querySelectorAll('[data-sidebar="cta-close"]'),
      a = document.querySelectorAll('[data-sidebar="cta-mobile"]'),
      l = document.querySelector(".cta-trigger"),
      c = document.querySelector(".is--slider-popup"),
      u = document.querySelector(".is--form-popup"),
      _ = document.querySelector(".is--cta-popup"),
      p = (h) => {
        h.classList.add("popup-open"), s.stop();
        let v = h.querySelector(".popup-content");
        v.style.cssText =
          "animation:slide-in .5s ease; animation-fill-mode: forwards;";
      },
      f = (h) => {
        let v = h.querySelector(".popup-content");
        v.classList.contains("is--cta-content")
          ? (v.style.cssText = "opacity: 0;")
          : (s.start(),
            (v.style.cssText =
              "animation:slide-out .5s ease; animation-fill-mode: forwards;")),
          setTimeout(() => {
            h.classList.remove("popup-open"),
              h.classList.contains("is--open-mobile") &&
                h.classList.remove("is--open-mobile");
          }, 500);
      },
      m = (h, v) => {
        h.classList.add("popup-open"),
          v && h.classList.add(v),
          h && (h.style.cssText = "opacity: 1;");
        let T = h.querySelector(".popup-content");
        T && (T.style.cssText = "opacity: 1;");
      };
    l &&
      setTimeout(function () {
        m(l);
      }, 1e4),
      a.forEach((h) => {
        h.addEventListener("click", (v) => {
          m(_, "is--open-mobile");
        });
      }),
      o.forEach((h) => {
        window.addEventListener("click", (v) => {
          (v.target === h ||
            v.target.parentElement === h ||
            v.target.parentElement.parentElement === h) &&
            f(_);
        });
      }),
      t.forEach((h) => {
        h.addEventListener("click", () => {
          m(_);
        });
      }),
      e.forEach((h) => {
        h.addEventListener("click", () => {
          p(c);
        });
      }),
      i.forEach((h) => {
        window.addEventListener("click", (v) => {
          (v.target === h || v.currentTarget.parentNode === h) && f(c);
        });
      }),
      r.forEach((h) => {
        h.addEventListener("click", () => {
          p(u);
        });
      }),
      n.forEach((h) => {
        window.addEventListener("click", (v) => {
          (v.target === h || v.currentTarget.parentNode === h) && f(u);
        });
      });
  }
  const Sf = async (s) => {
      const e = new Headers();
      e.append("Content-Type", "application/json");
      const r = "https://api3dwizard.ozero.aegas.it",
        t = "https://api.qudrix.com",
        n = window.location.href.includes("webflow") ? r : t,
        o = JSON.stringify(s),
        a = { method: "POST", headers: e, body: o, redirect: "follow" };
      return fetch(`${n}/sessions?projectId=1`, a)
        .then((l) => {
          if (!l.ok) throw new Error("Network response was not ok");
          return l.json();
        })
        .catch((l) => {
          throw (console.error("Error creating session:", l), l);
        });
    },
    xf = (s, e) => {
      const r = new Headers();
      r.append("Content-Type", "application/json");
      const t = JSON.stringify(s),
        i = { method: "PUT", headers: r, body: t, redirect: "follow" };
      return fetch(`https://api.qudrix.com/sessions/${e}/raw-data`, i)
        .then((n) => {
          if (!n.ok) throw new Error("Network response was not ok");
          return n.json();
        })
        .catch((n) => {
          throw (console.error("Error updating session:", n), n);
        });
    };
  function Tf() {
    const s = document.querySelectorAll(".dropdown"),
      e = (i) => {
        i.classList.add("dropdown-open");
        const n = i.querySelector(".dropdown-list"),
          o = n.querySelector(".dropdown-list__content");
        n.style.height = `${o.offsetHeight}px`;
      },
      r = (i) => {
        i.classList.remove("dropdown-open");
        const n = i.querySelector(".dropdown-list");
        n.style.height = "0px";
      },
      t = (i) => {
        i.classList.contains("dropdown-open") ? r(i) : e(i);
      };
    s.forEach((i, n) => {
      i.querySelector(".dropdown-toggle").addEventListener("click", () => {
        s.forEach((a) => {
          r(a);
        }),
          t(i);
      });
    }),
      window.addEventListener("DOMContentLoaded", () => {
        e(s[0]);
      });
  }
  function Ef() {
    document.querySelectorAll(".item-price").forEach((e) => {
      if (e.textContent !== "") {
        let r = e.textContent;
        (r = r.replace(/(\d)(?=(\d{3})+$)/g, "$1,")),
          (r = `+$${r}`),
          (e.textContent = r);
      }
    });
  }
  const kf = () => {
    const s = document.querySelector("pre"),
      e = document.querySelectorAll(".wizard-tab__nav-link div"),
      r = document.querySelectorAll(".wizard-tab__content-item"),
      t = document.querySelector("#total-price"),
      i = document.querySelectorAll(".wizard-tab__nav-link"),
      n = document.querySelectorAll(".dropdown"),
      o = document.querySelectorAll(".accessories-button"),
      a = document.querySelector(".wizard-sidebar__accessories-sidebar"),
      l = document.querySelector(".wizard-sidebar__accessories-sidebar-close"),
      c = document.querySelectorAll(
        ".wizard-sidebar__elements-list.is--accessories .wizard-sidebar__element"
      ),
      u = document.querySelector(".combine-color-checkbox");
    document.querySelector(".combine-color__wrapper");
    const _ = document.querySelectorAll(".color-element__button"),
      p = document.querySelectorAll(".color-elements__list");
    document.querySelector('[data-name="Swivel Sliding pergola Q25"]'),
      document.querySelectorAll('[data-accessory-name="Automatic sunscreen"]'),
      document.querySelector('[data-colors="roof"]'),
      document.querySelector('[data-colors="sunscreen"]');
    const f = document.querySelectorAll(".wizard-summary__list-item"),
      m = document.querySelector("#subtotal"),
      h = document.querySelector("#shipping"),
      v = document.querySelector("#total"),
      T = document.querySelector(".wizard-open__button"),
      E = document.querySelector(".wizard-sidebar__overlay"),
      P = document.querySelector("#wizard-sidebar"),
      g = document.querySelectorAll('[data-name="Glass Window Paid"]'),
      y = document.querySelectorAll('[data-name="Glass Window"]'),
      w = document.querySelector("iframe.model-iframe");
    i.forEach((k) => {
      k.addEventListener("click", (d) => {
        const O = d.target
          .closest(".wizard-tab__nav-link")
          .getAttribute("data-tab");
        w.src.includes("#")
          ? (w.src = w.src.split("#")[0] + `#${O}`)
          : (w.src = w.src + `#${O}`);
      });
    }),
      n.forEach((k) => {
        k.addEventListener("click", (d) => {
          const O = d.target.closest("[data-side]")
            ? d.target.closest("[data-side]").getAttribute("data-side")
            : null;
          w.src.includes("#") && (w.src = w.src.split("#")[0] + `#sides-${O}`);
        });
      });
    const S = () => {
        P.classList.add("is--open");
      },
      A = () => {
        P.classList.remove("is--open");
      };
    T && T.addEventListener("click", S),
      E &&
        E.addEventListener("click", () => {
          A();
        }),
      Ef();
    const C = (k) =>
      !!(
        k.classList.contains("active") ||
        k.firstChild.classList.contains("active")
      );
    window.location.pathname === "/wizard/cube" && Tf();
    let L,
      z = 0;
    const x = {},
      H = {},
      q = (k) => {
        const d = k.querySelector(".wizard-element__icon-default"),
          O = k.querySelector(".wizard-element__icon-active");
        d && O && ((O.style.display = "block"), (d.style.display = "none"));
      },
      B = (k) => {
        const d = k.querySelector(".wizard-element__icon-default"),
          O = k.querySelector(".wizard-element__icon-active");
        d && O && ((O.style.display = "none"), (d.style.display = "block"));
      };
    function U(k) {
      k.parentElement.style.display = "none";
    }
    g.length > 0 &&
      g.forEach((k) => {
        U(k);
      });
    function F() {
      let k = !1;
      for (let d = 0; d < y.length && ((k = C(y[d])), !k); d++);
      if (k) {
        let d;
        y.forEach((O) => {
          C(O) && (d = O.getAttribute("data-side"));
        }),
          g.forEach((O) => {
            O.getAttribute("data-side") !== d
              ? (O.parentElement.style.display = "flex")
              : U(O);
          }),
          y.forEach((O) => {
            O.getAttribute("data-side") !== d
              ? U(O)
              : (O.parentElement.style.display = "flex");
          });
      } else
        y.forEach((d) => {
          d.parentElement.style.display = "flex";
        }),
          g.forEach((d) => {
            U(d);
          });
    }
    function G(k) {
      const d = k.target;
      if (
        d.tagName === "LABEL" ||
        (d.tagName === "INPUT" &&
          d.type === "radio" &&
          !d.classList.contains("color-element__button") &&
          !d.parentElement.classList.contains("color-element__button"))
      ) {
        const O = d.closest(".radio-trigger"),
          M = d.closest(".checkbox-trigger");
        O
          ? (O.querySelectorAll("label").forEach((oe) => {
              oe.classList.remove("active"), B(oe);
            }),
            d.tagName === "LABEL"
              ? (d.classList.add("active"),
                (d.querySelector("input").checked = !0),
                q(d))
              : d.tagName === "INPUT" &&
                (d.parentElement.classList.add("active"),
                (d.checked = !0),
                q(d.parentElement)))
          : M &&
            (M.querySelectorAll("label").forEach((oe) => {
              oe.classList.remove("active"), B(oe);
            }),
            d.tagName === "LABEL"
              ? (d.classList.add("active"),
                (d.querySelector("input").checked = !0),
                q(d))
              : d.tagName === "INPUT" &&
                (d.parentElement.classList.add("active"),
                (d.checked = !0),
                q(d.parentElement))),
          ve();
        const Y = d.closest("[data-side]"),
          D = Y ? Y.dataset.side : null;
        D !== "null" && D !== null && F();
      } else if (d.type === "checkbox") {
        if (
          (d.parentElement.classList.contains("active")
            ? (d.parentElement.classList.remove("active"),
              (d.checked = !1),
              B(d.parentElement))
            : (d.parentElement.classList.add("active"),
              (d.checked = !0),
              q(d.parentElement)),
          d.parentElement.parentElement.getAttribute("data-accessory-name") ===
            "No accessories")
        )
          d
            .closest(".wizard-sidebar__accessories-sidebar")
            .querySelectorAll(".wizard-sidebar__element.visible")
            .forEach((D) => {
              D.getAttribute("data-accessory-name") !== "No accessories" &&
                (D.firstChild.classList.remove("active"),
                (D.querySelector("input").checked = !1),
                B(D.firstChild));
            }),
            d.parentElement.classList.add("active"),
            (d.checked = !0),
            q(d.parentElement);
        else {
          const Y = d
            .closest(".wizard-sidebar__accessories-sidebar")
            .querySelectorAll(".wizard-sidebar__element.visible");
          Y.length > 0 &&
            Y.forEach((D) => {
              D.getAttribute("data-accessory-name") === "No accessories" &&
                (D.firstChild.classList.remove("active"),
                (D.querySelector("input").checked = !1),
                B(D));
            });
        }
        const O = d
          .closest(".wizard-sidebar__accessories-sidebar")
          .querySelectorAll(".wizard-sidebar__element.visible");
        let M = !1;
        O.forEach((Y) => {
          Y.getAttribute("data-accessory-name") !== "No accessories" &&
            Y.querySelector("input").checked &&
            (M = !0);
        }),
          M ||
            O.forEach((Y) => {
              Y.getAttribute("data-accessory-name") === "No accessories" &&
                (Y.firstChild.classList.add("active"),
                (Y.querySelector("input").checked = !0),
                q(Y.firstChild));
            }),
          ve();
      }
    }
    document.addEventListener("click", G);
    const Q = () => {
      (s.textContent = JSON.stringify(x, null, 2).replace(
        /,/g,
        `,
`
      )),
        localStorage.setItem("wizardParametrs", JSON.stringify(x)),
        f.forEach((k) => {
          const d = k.getAttribute("data-item"),
            O = k.querySelector(".text-color-gray");
          d === "sides"
            ? (O.textContent = `S1 (${x[d]["side-01"]["element-name"]}), S2 (${x[d]["side-02"]["element-name"]}), S3 (${x[d]["side-03"]["element-name"]}), S4 (${x[d]["side-04"]["element-name"]})`)
            : d === "color"
            ? (O.textContent = `Frame (${
                x[d].frame ? x[d].frame : "None"
              }), Roof (${x[d].roof ? x[d].roof : "None"}), Sunscreen (${
                x[d].sunscreen ? x[d].sunscreen : "None"
              }),`)
            : d === "size"
            ? x[d]["element-name"] === "Q1"
              ? (O.textContent = "3.1 X 3.1 YD")
              : x[d]["element-name"] === "Q2" &&
                (O.textContent = "4.1 X 4.1 YD")
            : (O.textContent = x[d] ? x[d]["element-name"] : "None");
        });
    };
    e.forEach((k, d) => {
      const O = k.textContent.trim().toLowerCase();
      O !== "summary" && ((x[O] = {}), r[d].setAttribute("data-tab", O));
    }),
      (x.size = { "element-name": "Q01" }),
      (x.roof = { "element-name": "Solid Panels", "accessory1-name": "None" }),
      (x.sides = {
        "side-01": {
          "element-name": "Slider Door",
          "accessory1-name": "None",
          "accessory2-name": "None",
        },
        "side-02": {
          "element-name": "Glass Window",
          "accessory1-name": "None",
          "accessory2-name": "None",
        },
        "side-03": {
          "element-name": "Solid Panels",
          "accessory1-name": "None",
          "accessory2-name": "None",
        },
        "side-04": {
          "element-name": "Solid Panels",
          "accessory1-name": "None",
          "accessory2-name": "None",
        },
      }),
      (x.attachment = { "element-name": "" }),
      (x.light = { "element-name": "" }),
      (x.color = { frame: "Black" }),
      document
        .querySelectorAll("[data-tab], .wizard-sidebar__accessories-sidebar")
        .forEach((k) => {
          const d = k.querySelectorAll('input[type="radio"]'),
            O = k.getAttribute("data-tab");
          d.forEach((M) => {
            const Y = M.parentElement.getAttribute("data-name"),
              D = k.getAttribute("data-tab"),
              I = M.closest("[data-side]"),
              oe = I ? I.dataset.side : null;
            oe !== "null" && oe !== null
              ? x[D][oe] &&
                x[D][oe]["element-name"] === Y &&
                (M.parentElement.classList.add("active"),
                (M.checked = !0),
                q(M.parentElement))
              : x[D]
              ? x[D]["element-name"] === Y &&
                (M.parentElement.classList.add("active"),
                (M.checked = !0),
                q(M.parentElement))
              : D === "size" &&
                x[D]["element-name"] === Y &&
                (M.parentElement.classList.add("active"),
                (M.checked = !0),
                q(M.parentElement));
          }),
            k.addEventListener("click", (M) => {
              const Y = M.target.closest("[data-side]"),
                D = Y ? Y.dataset.side : null,
                I = k.dataset.tab;
              D
                ? (le(I, D, M.target.parentElement),
                  Ce(I, M.target.parentElement))
                : O !== "last" &&
                  (rt(I, M.target.parentElement),
                  de(I, M.target.parentElement)),
                x.size["element-name"] === "Q2"
                  ? (document.querySelector(
                      ".tab-content__size-notification"
                    ).style.display = "block")
                  : (document.querySelector(
                      ".tab-content__size-notification"
                    ).style.display = "none");
            });
        }),
      F();
    function le(k, d, O) {
      const M = O.getAttribute("data-name");
      d !== "null" &&
        d !== null &&
        M !== "null" &&
        M !== null &&
        ((x[k][d]["element-name"] = M),
        x[k][d]["accessory1-name"] &&
          x[k][d]["accessory2-name"] &&
          ((x[k][d]["accessory1-name"] = "None"),
          (x[k][d]["accessory2-name"] = "None")),
        Q(),
        V());
    }
    function Re(k) {
      k.firstChild.classList.remove("active"), B(k.firstChild);
    }
    function rt(k, d) {
      const O = d.getAttribute("data-name");
      d.closest("[data-tab]").getAttribute("data-tab"),
        O !== "null" &&
          O !== null &&
          ((x[k]["element-name"] = O),
          x[k]["accessory1-name"] && (x[k]["accessory1-name"] = "None"),
          Q(),
          V());
    }
    function de(k, d) {
      const O = d.parentElement.getAttribute("data-accessory-name"),
        M = d.parentElement.getAttribute("data-side")
          ? d.parentElement.getAttribute("data-side")
          : null,
        Y = d.closest("[data-tab]").getAttribute("data-tab");
      if (
        ([
          ...d.parentElement.parentElement.querySelectorAll(
            ".wizard-sidebar__element.visible"
          ),
        ].indexOf(d.parentElement),
        O !== "null" && O !== null && M === null)
      ) {
        if (!d.classList.contains("active"))
          O === "No accessories"
            ? (x[k]["accessory1-name"] = "None")
            : (x[k]["accessory1-name"] = O),
            Q(),
            V();
        else {
          x[k]["accessory1-name"] = "None";
          const D = d.parentElement.parentElement.querySelectorAll(
            ".wizard-sidebar__element.visible"
          );
          let I = !1;
          D.forEach((oe) => {
            oe.getAttribute("data-accessory-name") !== "No accessories" &&
              oe.querySelector("input").checked &&
              (I = !0);
          }),
            I || (x[k]["accessory1-name"] = "None"),
            Q(),
            V();
        }
        H[Y] = d.parentElement;
      }
    }
    function Ce(k, d) {
      const O = d.parentElement.getAttribute("data-accessory-name"),
        M = d.parentElement.getAttribute("data-side")
          ? d.parentElement.getAttribute("data-side")
          : null,
        Y = d.closest("[data-tab]").getAttribute("data-tab"),
        D = [
          ...d.parentElement.parentElement.querySelectorAll(
            ".wizard-sidebar__element.visible"
          ),
        ].indexOf(d.parentElement);
      if (O !== "null" && O !== null && M !== "null" && M !== null) {
        if (d.classList.contains("active")) {
          x[k][M][`accessory${D}-name`] = "None";
          const I = d.parentElement.parentElement.querySelectorAll(
            ".wizard-sidebar__element.visible"
          );
          let oe = !1;
          I.forEach((Bt) => {
            Bt.getAttribute("data-accessory-name") !== "No accessories" &&
              Bt.querySelector("input").checked &&
              (oe = !0);
          }),
            oe || (x[k][M]["accessory1-name"] = "None");
        } else if (O === "No accessories")
          for (let I = 1; I < 3; I++) x[k][M][`accessory${I}-name`] = "None";
        else
          x[k][M]["accessory1-name"] === "None" &&
            (x[k][M]["accessory1-name"] = "None"),
            (x[k][M][`accessory${D}-name`] = O);
        (H[Y][M] = d.parentElement), Q(), V();
      }
    }
    function Ne() {
      (a.style.display = "block"), a.classList.add("active"), Ye();
    }
    function _e() {
      a.classList.remove("active"),
        setTimeout(() => {
          a.style.display = "none";
        }, 500),
        c.forEach((k) => {
          k.classList.remove("visible");
        });
    }
    const me = (k) => {
      const d = k.parentElement.parentElement
          .querySelector(".wizard-sidebar__element-button")
          .getAttribute("data-name"),
        O = k.closest("[data-side]")
          ? k.closest("[data-side]").getAttribute("data-side")
          : null,
        M = k.closest(".wizard-tab__content-item").getAttribute("data-tab");
      a.setAttribute("data-tab", M),
        Ne(),
        O !== "null" && O !== null && d !== "null" && d !== null
          ? c.forEach((I) => {
              I.getAttribute("data-side") === O &&
              I.getAttribute("data-accessory-to") === d
                ? I.classList.add("visible")
                : I.classList.remove("visible");
            })
          : ((d !== "null" && d !== null && O === "null") || O === null) &&
            c.forEach((I) => {
              I.getAttribute("data-accessory-to") === d
                ? I.classList.add("visible")
                : I.classList.remove("visible");
            });
      let Y = document.querySelectorAll(
          ".wizard-sidebar__elements-list.is--accessories .wizard-sidebar__element.visible"
        ),
        D = !1;
      Y.forEach((I) => {
        const oe = I.getAttribute("data-accessory-name");
        O === null || O === "null"
          ? x[M] &&
            Object.values(x[M]).forEach((Bt) => {
              Bt === oe &&
                (console.log(oe),
                I.firstElementChild.classList.add("active"),
                I.firstElementChild.setAttribute("checked", !0),
                (D = !0));
            })
          : (O !== null || O !== "null") &&
            x[M][O] &&
            Object.values(x[M][O]).forEach((Bt) => {
              Bt === oe &&
                (I.firstElementChild.classList.add("active"),
                I.firstElementChild.setAttribute("checked", !0),
                (D = !0));
            });
      }),
        D ||
          (Y.forEach((I) => {
            ge(I);
          }),
          (D = !1));
    };
    function ge(k) {
      let d = k.querySelector(".wizard-sidebar__element-button");
      k.getAttribute("data-accessory-name") === "No accessories" &&
        (d.classList.add("active"),
        d.setAttribute("checked", !0),
        (k.style.order = -1),
        q(d),
        Q(),
        V());
    }
    function Ye() {
      let k = document.querySelectorAll(
          ".wizard-sidebar__elements-list.is--accessories .wizard-sidebar__element.visible"
        ),
        d = !1;
      k.forEach((O) => {
        O.getAttribute("data-accessory-name") !== "No accessories" &&
          O.firstChild.classList.contains("active") &&
          (d = !0);
      }),
        d
          ? k.forEach((O) => {
              O.getAttribute("data-accessory-name") === "No accessories" &&
                Re(O);
            })
          : (k.forEach((O) => {
              ge(O);
            }),
            (d = !1));
    }
    function ve() {
      c.forEach((k) => {
        const d = k.getAttribute("data-accessory-to"),
          O = k.getAttribute("data-side") ? k.getAttribute("data-side") : null;
        if (O === null || O === "null") {
          let M = !1;
          for (const [Y, D] of Object.entries(x))
            typeof D == "object"
              ? Object.values(D).forEach((I) => {
                  I === d && (M = !0);
                })
              : D === d && (M = !0);
          M || (k.firstChild.classList.remove("active"), B(k.firstChild));
        } else if (O !== null || O !== "null") {
          let M = !1;
          for (const [Y, D] of Object.entries(x))
            typeof D == "object" &&
              Object.values(D).forEach((I) => {
                typeof I == "object" &&
                  Object.values(I).forEach((oe) => {
                    oe === d && (M = !0);
                  });
              });
          M || (k.firstChild.classList.remove("active"), B(k.firstChild));
        }
      });
    }
    o.forEach((k) => {
      k.addEventListener("click", (d) => {
        me(d.target),
          (H[d.target.closest("[data-tab]").getAttribute("data-tab")] = {}),
          Ye();
      });
    }),
      u &&
        u.addEventListener("click", (k) => {
          k.target.classList.contains("is--active")
            ? k.target.classList.remove("is--active")
            : k.target.classList.add("is--active"),
            _.forEach((d) => {
              d.addEventListener("click", (O) => {
                if (u.classList.contains("is--active")) {
                  const M = O.currentTarget.querySelector("input").value,
                    Y = document.querySelectorAll(
                      `.color-tab__content-raw.is--default input:not([value="${M}"])`
                    );
                  console.log(Y),
                    Y.forEach((I) => {
                      (I.parentElement.checked = !1),
                        I.previousElementSibling.classList.remove(
                          "w--redirected-checked"
                        );
                    });
                  const D = document.querySelectorAll(
                    `.color-tab__content-raw.is--default input[value="${M}"]`
                  );
                  console.log(D),
                    D.forEach((I) => {
                      (I.parentElement.checked = !0),
                        I.previousElementSibling.classList.add(
                          "w--redirected-checked"
                        );
                    });
                }
              });
            });
        });
    function Xe() {
      p &&
        p.forEach((k) => {
          k.closest(".color-tab__content-raw.is--default") &&
            k
              .querySelectorAll(".w-form-formradioinput--inputType-custom")
              .forEach((M, Y) => {
                Y === 0
                  ? ((M.parentElement.checked = !0),
                    M.classList.add("w--redirected-checked"))
                  : ((M.parentElement.checked = !1),
                    M.classList.remove("w--redirected-checked"));
              });
        });
    }
    Xe(),
      p.forEach((k) => {
        k.addEventListener("click", (d) => {
          if (u.classList.contains("is--active"))
            document
              .querySelectorAll(
                ".color-tab__content-raw.is--default .color-elements__list"
              )
              .forEach((M) => {
                const Y = M.getAttribute("data-color"),
                  D = M.querySelector(
                    ".color-radio__button.w--redirected-checked"
                  ).nextElementSibling.value;
                x.color[Y] = D;
              });
          else if (
            d.target.tagName === "INPUT" ||
            d.target.tagName === "LABEL"
          ) {
            const O = k.getAttribute("data-color"),
              M =
                d.target.tagName === "INPUT"
                  ? d.target.value
                  : d.target.querySelector("input").value;
            x.color[O] = M;
          }
          Q(), V();
        });
      }),
      l.addEventListener("click", _e),
      Q();
    function V() {
      L
        ? xf(x, L)
            .then((k) => {
              Se(k.calculatedPrice);
            })
            .catch((k) => {
              console.error("Error updating session:", k);
            })
        : Sf(x)
            .then((k) => {
              const d = "https://model.qudrix.com/",
                O = "https://spiffy-frangollo-487b0a.netlify.app/",
                Y = window.location.href.includes("webflow") ? O : d;
              Se(k.price),
                (L = k.sessionId),
                (document.cookie = `sessionId=${L}`),
                w.setAttribute("src", `${Y}?sessionId=${L}`);
              const D = document.querySelector(".preloader");
              setTimeout(() => {
                (D.style.opacity = 0),
                  setTimeout(() => {
                    D.style.display = "none";
                  }, 500);
              }, 400);
            })
            .catch((k) => {
              console.error("Error:", k);
            });
    }
    V();
    function ce(k) {
      const d = k.toString();
      if (d.length > 3) {
        const O = d.split("");
        O.splice(O.length - 3, 0, ","), (k = O.join(""));
      }
      return k;
    }
    const Se = (k) => {
      if (k == null) {
        console.error("Price is undefined or null");
        return;
      } else {
        const d = h.textContent,
          O = parseInt(d.replace(/\D/g, "")),
          M = k + O;
        (z = k),
          (document.cookie = `amount=${z}`),
          (t.textContent = "$" + ce(k)),
          (m.textContent = "$" + ce(k)),
          (h.textContent = "$" + ce(O)),
          (v.textContent = "$" + ce(M)),
          localStorage.setItem("price", m.textContent),
          localStorage.setItem("shipping", h.textContent),
          localStorage.setItem("totalPrice", v.textContent);
      }
    };
  };
  var tc = "https://js.stripe.com/v3",
    Cf = /^https:\/\/js\.stripe\.com\/v3\/?(\?.*)?$/,
    rc =
      "loadStripe.setLoadParameters was called but an existing Stripe.js script already exists in the document; existing script parameters will be used",
    Af = function () {
      for (
        var e = document.querySelectorAll('script[src^="'.concat(tc, '"]')),
          r = 0;
        r < e.length;
        r++
      ) {
        var t = e[r];
        if (!!Cf.test(t.src)) return t;
      }
      return null;
    },
    Pf = function (e) {
      var r = e && !e.advancedFraudSignals ? "?advancedFraudSignals=false" : "",
        t = document.createElement("script");
      t.src = "".concat(tc).concat(r);
      var i = document.head || document.body;
      if (!i)
        throw new Error(
          "Expected document.body not to be null. Stripe.js requires a <body> element."
        );
      return i.appendChild(t), t;
    },
    Of = function (e, r) {
      !e ||
        !e._registerWrapper ||
        e._registerWrapper({
          name: "stripe-js",
          version: "2.2.0",
          startTime: r,
        });
    },
    ts = null,
    Lf = function (e) {
      return (
        ts !== null ||
          (ts = new Promise(function (r, t) {
            if (
              typeof window == "undefined" ||
              typeof document == "undefined"
            ) {
              r(null);
              return;
            }
            if ((window.Stripe && e && console.warn(rc), window.Stripe)) {
              r(window.Stripe);
              return;
            }
            try {
              var i = Af();
              i && e ? console.warn(rc) : i || (i = Pf(e)),
                i.addEventListener("load", function () {
                  window.Stripe
                    ? r(window.Stripe)
                    : t(new Error("Stripe.js not available"));
                }),
                i.addEventListener("error", function () {
                  t(new Error("Failed to load Stripe.js"));
                });
            } catch (n) {
              t(n);
              return;
            }
          })),
        ts
      );
    },
    Mf = function (e, r, t) {
      if (e === null) return null;
      var i = e.apply(void 0, r);
      return Of(i, t), i;
    },
    ic = Promise.resolve().then(function () {
      return Lf(null);
    }),
    nc = !1;
  ic.catch(function (s) {
    nc || console.warn(s);
  });
  var zf = function () {
    for (var e = arguments.length, r = new Array(e), t = 0; t < e; t++)
      r[t] = arguments[t];
    nc = !0;
    var i = Date.now();
    return ic.then(function (n) {
      return Mf(n, r, i);
    });
  };
  const Df = async (s) => {
    const e = "https://api3dwizard.ozero.aegas.it",
      r = "https://api.qudrix.com",
      t =
        "pk_test_51MUELBG2BGcSuzlBbE8Y3jkJMllhaLM6RzCOnVVMtyRgrS4OJkC4KeKE5paS5jqx1okOXjl8xWqKaIvCrqztjWq400m2Qg3JWN",
      i =
        "pk_live_51NlJI1BXPjHeXiPV5ekd4In9FDE98fb2V9L53O0ESqmurFepdbWzqBsZyqUvFtYSUpVTcSMIVmuX9TSngLo4N6px00SSWa3Kro",
      n = window.location.href,
      o = n.includes("webflow") ? e : r,
      a = n.includes("webflow") ? t : i;
    console.log(a, o);
    const l = await zf(a);
    let c = await u();
    document.getElementById("payment-form").addEventListener("submit", _);
    async function u() {
      const p = await fetch(`${o}/sessions/${s}/checkout`, {
          method: "GET",
          redirect: "follow",
        }),
        { clientSecret: f } = await p.json(),
        m = { mode: "shipping" },
        h = {
          theme: "flat",
          rules: {
            ".p-Field": {
              position: "relative",
              fontFamily: "Aeonik, sans-serif",
            },
            ".Input": {
              backgroundColor: "transparent",
              borderBottom: "1px solid #C4C4C4",
              height: "3.56rem",
              letterSpacing: ".0125rem",
              textTransform: "uppercase",
              marginBottom: "0",
              fontSize: ".625rem",
              borderRadius: "0",
              paddingLeft: "0",
              paddingBottom: "0.88rem",
              paddingTop: "0.38rem",
              marginBottom: "1.5rem",
            },
            ".Input:focus": { boxShadow: "none", borderColor: "#161616" },
            ".Input--invalid": { borderColor: "#CC0300", boxShadow: "none" },
            ".Input:autofill": { backgroundColor: "transparent" },
            ".Error": {
              color: "#CC0300",
              fontSize: ".625rem",
              letterSpacing: ".0125rem",
              textTransform: "uppercase",
              marginTop: "0.25rem",
              marginBottom: "0.25rem",
            },
            ".Label": {
              fontSize: ".625rem",
              textTransform: "uppercase",
              letterSpacing: ".0125rem",
              color: "#161616",
            },
            ".Label--invalid": { color: "#CC0300" },
            ".CheckboxInput": {
              backgroundColor: "transparent",
              borderRadius: "100%",
              border: "1px solid #161616",
            },
            ".CheckboxInput--checked": {
              backgroundColor: "#161616",
              borderRadius: "100%",
            },
            ".p-CheckboxInput--focused": { boxShadow: "none", outline: "none" },
            ".CheckboxLabel": {
              fontSize: ".625rem",
              textTransform: "uppercase",
              letterSpacing: ".0125rem",
              color: "#161616",
            },
          },
        };
      let v = l.elements({ appearance: h, clientSecret: f });
      const T = v.create("address", m),
        E = v.create("payment");
      return T.mount("#address-element"), E.mount("#payment-element"), v;
    }
    async function _(p) {
      p.preventDefault();
      const f = "https://www.qudrix.com/success",
        m = "https://qudrix.webflow.io/success",
        v = window.location.href.includes("webflow") ? m : f,
        { error: T } = await l.confirmPayment({
          elements: c,
          confirmParams: { return_url: v },
        });
      T.type === "card_error" || T.type === "validation_error"
        ? showMessage(T.message)
        : showMessage("An unexpected error occurred."),
        setLoading(!1);
    }
  };
  function Rf() {
    let s = [...document.querySelectorAll("video")];
    if (
      (s.forEach((r) => {
        r.querySelector("source").getAttribute("data-src") ||
          r.parentElement.remove();
      }),
      "IntersectionObserver" in window)
    ) {
      let r = new IntersectionObserver(function (t) {
        t.forEach(function (i) {
          if (i.isIntersecting) {
            for (let n in i.target.children) {
              let o = i.target.children[n];
              typeof o.tagName == "string" &&
                o.tagName === "SOURCE" &&
                (o.src = o.dataset.src);
            }
            i.target.classList.contains("loaded") || i.target.load(),
              i.target.classList.add("loaded"),
              i.target.classList.remove("lazy");
          } else i.target.pause();
        });
      });
      s.forEach(function (t) {
        r.observe(t);
      });
    }
    document.querySelectorAll(".assemble-main__item").forEach((r, t) => {
      const i = r.querySelector("video");
      if (i)
        r.addEventListener("mouseenter", () => {
          i.play();
        }),
          r.addEventListener("mouseleave", () => {
            i.pause();
          }),
          window.innerWidth < 991 &&
            new IntersectionObserver(function (o) {
              o.forEach(function (a) {
                a.isIntersecting
                  ? (a.target.classList.contains("loaded") || a.target.load(),
                    a.target.play())
                  : a.target.pause();
              });
            }).observe(i);
      else return;
    });
  }
  function Nf() {
    const s = JSON.parse(localStorage.getItem("wizardParametrs"));
    s &&
      document.querySelectorAll(".wizard-summary__list-item").forEach((l) => {
        const c = l.getAttribute("data-item"),
          u = l.querySelector(".text-color-gray");
        c === "sides"
          ? (u.textContent = `S1 (${s[c]["side-01"]["element-name"]}), S2 (${s[c]["side-02"]["element-name"]}), S3 (${s[c]["side-03"]["element-name"]}), S4 (${s[c]["side-04"]["element-name"]})`)
          : c === "color"
          ? (u.textContent = `Frame (${
              s[c].frame ? s[c].frame : "None"
            }), Roof (${s[c].roof ? s[c].roof : "None"}), Sunscreen (${
              s[c].sunscreen ? s[c].sunscreen : "None"
            }),`)
          : c === "size"
          ? s[c]["element-name"] === "Q1"
            ? (u.textContent = "3.1 X 3.1 YD")
            : s[c]["element-name"] === "Q2" && (u.textContent = "4.1 X 4.1 YD")
          : (u.textContent = s[c] ? s[c]["element-name"] : "None");
      });
    const e = localStorage.getItem("price"),
      r = localStorage.getItem("shipping"),
      t = localStorage.getItem("totalPrice"),
      i = document.querySelector("#subtotal"),
      n = document.querySelector("#shipping"),
      o = document.querySelector("#total");
    (i.textContent = e), (n.textContent = r), (o.textContent = t);
  }
  if (
    window.location.pathname !== "/404" &&
    window.location.pathname !== "/wizard/cube" &&
    window.location.pathname !== "/success"
  )
    bf(), wf(), Rf();
  else if (window.location.pathname === "/wizard/cube") {
    kf();
    const s = document.querySelector(".is--checkout-popup"),
      e = (o) => {
        o.classList.add("popup-open");
        let a = o.querySelector(".popup-content");
        a.style.cssText =
          "animation:slide-in .5s ease; animation-fill-mode: forwards;";
      },
      r = (o) => {
        let a = o.querySelector(".popup-content");
        a.classList.contains("is--cta-content")
          ? (a.style.cssText = "opacity: 0;")
          : (a.style.cssText =
              "animation:slide-out .5s ease; animation-fill-mode: forwards;"),
          setTimeout(() => {
            o.classList.remove("popup-open"),
              o.classList.contains("is--open-mobile") &&
                o.classList.remove("is--open-mobile");
          }, 500);
      },
      t = async () => {
        const o = document.cookie
          .split(";")
          .find((a) => a.includes("sessionId"))
          .split("=")[1];
        document.cookie
          .split(";")
          .find((a) => a.includes("amount"))
          .split("=")[1],
          Df(o),
          e(s);
      };
    document.querySelector("#checkout-button").addEventListener("click", t),
      document
        .querySelectorAll('[data-sidebar="checkout-close"]')
        .forEach((o) => {
          window.addEventListener("click", (a) => {
            (a.target === o || a.currentTarget.parentNode === o) && r(s);
          });
        });
  } else window.location.pathname === "/success" && Nf();
});
