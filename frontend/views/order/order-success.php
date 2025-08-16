<?php

use common\models\shop\ActivePages;
use frontend\assets\OrderSuccessPageAsset;

OrderSuccessPageAsset::register($this);
ActivePages::setActiveUser();

?>
<div class="site__body">
    <div class="block order-success">
        <div class="container">
            <div class="order-success__body">
                <div class="order-success__header">
                    <svg class="order-success__icon" width="100" height="100">
                        <use xlink:href="/images/sprite.svg#check-100"></use>
                    </svg>
                    <h1 class="order-success__title"><?= Yii::t('app', 'Дякуємо!') ?></h1>
                    <div class="order-success__subtitle"><?= Yii::t('app', 'Ваше замовлення отримано') ?></div>
                    <div class="order-success__subtitle"><?= Yii::t('app', 'Найближчим часом з вами звяжеться наш менеджер') ?></div>
                    <div class="order-success__actions">
                        <a href="/" class="btn btn-lg btn-primary"><?= Yii::t('app', 'На головну') ?></a>
                    </div>
                </div>
                <div class="order-success__meta">
                    <ul class="order-success__meta-list">
                        <li class="order-success__meta-item">
                            <span class="order-success__meta-title">№ <?= Yii::t('app', 'Замовлення') ?>:</span>
                            <span class="order-success__meta-value">#<?= random_int(100, 999) . $order->id ?></span>
                        </li>
                        <li class="order-success__meta-item">
                            <span class="order-success__meta-title"><?= Yii::t('app', 'Дата') ?>:</span>
                            <span class="order-success__meta-value"><?= Yii::$app->formatter->asDate($order->created_at) ?></span>
                        </li>
                        <li class="order-success__meta-item">
                            <span class="order-success__meta-title"><?= Yii::t('app', 'К-ть') ?>:</span>
                            <span class="order-success__meta-value"><?= $order->getTotalQty($order->id) ?></span>
                        </li>
                        <li class="order-success__meta-item">
                            <span class="order-success__meta-title"><?= Yii::t('app', 'Сума') ?>:</span>
                            <span class="order-success__meta-value"><?= Yii::$app->formatter->asCurrency($order->getTotalSumm($order->id)) ?></span>
                        </li>
                    </ul>
                </div>
                <div class="card">
                    <div class="order-list">
                        <table>
                            <thead class="order-list__header">
                            <tr>
                                <th class="order-list__column-label" colspan="2"><?= Yii::t('app', 'Товар') ?></th>
                                <th class="order-list__column-quantity"><?= Yii::t('app', 'К-ть') ?></th>
                                <th class="order-list__column-total"><?= Yii::t('app', 'Всього') ?></th>
                            </tr>
                            </thead>
                            <tbody class="order-list__products">
                            <?php foreach ($order->orderItems as $orderItem): ?>
                                <tr>
                                    <td class="order-list__column-image">
                                        <div class="product-image">
                                            <a href="" class="product-image__body">
                                                <img class="product-image__img"
                                                     src="<?= $orderItem->product->getImgOne($orderItem->product->getId()) ?>"
                                                     alt="<?= $orderItem->product->name ?>">
                                            </a>
                                        </div>
                                    </td>
                                    <td class="order-list__column-product">
                                        <?= $orderItem->product->name ?>
                                    </td>
                                    <td class="order-list__column-quantity"
                                        data-title="К-ть:"><?= $orderItem->quantity ?></td>
                                    <td class="order-list__column-total"><?= Yii::$app->formatter->asCurrency($orderItem->price * $orderItem->quantity) ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                            <tfoot class="order-list__footer">
                            <tr>
                                <th class="order-list__column-label" colspan="3"><?= Yii::t('app', 'Всього') ?></th>
                                <td class="order-list__column-total"><?= Yii::$app->formatter->asCurrency($order->getTotalSumm($order->id)) ?></td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="row mt-3 no-gutters mx-n2">
                    <div class="col-sm-12 col-12 px-2">
                        <div class="card address-card">
                            <div class="address-card__body">
                                <div class="address-card__badge address-card__badge--muted"><?= Yii::t('app', 'Адреса доставки') ?></div>
                                <div class="address-card__name"><?= $order->fio ?></div>
                                <div class="address-card__row">
                                    <div class="address-card__row-title"><i class="fas fa-phone"></i> <?= Yii::t('app', 'Телефон') ?></div>
                                    <div class="address-card__row-content"><?= $order->phone ?></div>
                                </div>
                                <?php if ($order->area): ?>
                                    <div class="address-card__row">
                                        <div class="address-card__row-title"><i class="fas fa-city"></i> <?= Yii::t('app', 'Область') ?></div>
                                        <div class="address-card__row-content"><?= $order->area ?></div>
                                    </div>
                                    <div class="address-card__row">
                                        <div class="address-card__row-title"><i class="fas fa-building"></i> <?= Yii::t('app', 'Місто') ?></div>
                                        <div class="address-card__row-content"><?= $order->city ?></div>
                                    </div>
                                    <div class="address-card__row">
                                        <div class="address-card__row-title"><i class="fas fa-warehouse"></i> <?= Yii::t('app', 'Відділення') ?></div>
                                        <div class="address-card__row-content"><?= $order->warehouses ?></div>
                                    </div>
                                <?php else: ?>
                                    <?php if ($order->warehouses): ?>
                                        <div class="address-card__row">
                                            <div class="address-card__row-title"><i class="fas fa-barcode"></i> <?= Yii::t('app', 'Індекс') ?></div>
                                            <div class="address-card__row-content"><?= $order->warehouses ?></div>
                                        </div>
                                        <div class="address-card__row">
                                            <div class="address-card__row-title"><i class="fas fa-city"></i> <?= Yii::t('app', 'Місто/Село') ?></div>
                                            <div class="address-card__row-content"><?= $order->city ?></div>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <?php if ($order->note): ?>
                                    <div class="address-card__row">
                                        <div class="address-card__row-title"><i class="far fa-comment"></i> <?= Yii::t('app', 'Коментар') ?></div>
                                        <div class="address-card__row-content"><?= $order->note ?></div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    !function (t, e) {
        !function t(e, n, a, i) {
            var o = !!(e.Worker && e.Blob && e.Promise && e.OffscreenCanvas && e.OffscreenCanvasRenderingContext2D && e.HTMLCanvasElement && e.HTMLCanvasElement.prototype.transferControlToOffscreen && e.URL && e.URL.createObjectURL);

            function r() {
            }

            function l(t) {
                var a = n.exports.Promise, i = void 0 !== a ? a : e.Promise;
                return "function" == typeof i ? new i(t) : (t(r, r), null)
            }

            var c, s, u, d, f, h, m, g, b,
                v = (u = Math.floor(1e3 / 60), d = {}, f = 0, "function" == typeof requestAnimationFrame && "function" == typeof cancelAnimationFrame ? (c = function (t) {
                    var e = Math.random();
                    return d[e] = requestAnimationFrame((function n(a) {
                        f === a || f + u - 1 < a ? (f = a, delete d[e], t()) : d[e] = requestAnimationFrame(n)
                    })), e
                }, s = function (t) {
                    d[t] && cancelAnimationFrame(d[t])
                }) : (c = function (t) {
                    return setTimeout(t, u)
                }, s = function (t) {
                    return clearTimeout(t)
                }), {frame: c, cancel: s}), p = (g = {}, function () {
                    if (h) return h;
                    if (!a && o) {
                        var e = ["var CONFETTI, SIZE = {}, module = {};", "(" + t.toString() + ")(this, module, true, SIZE);", "onmessage = function(msg) {", "  if (msg.data.options) {", "    CONFETTI(msg.data.options).then(function () {", "      if (msg.data.callback) {", "        postMessage({ callback: msg.data.callback });", "      }", "    });", "  } else if (msg.data.reset) {", "    CONFETTI.reset();", "  } else if (msg.data.resize) {", "    SIZE.width = msg.data.resize.width;", "    SIZE.height = msg.data.resize.height;", "  } else if (msg.data.canvas) {", "    SIZE.width = msg.data.canvas.width;", "    SIZE.height = msg.data.canvas.height;", "    CONFETTI = module.exports.create(msg.data.canvas);", "  }", "}"].join("\n");
                        try {
                            h = new Worker(URL.createObjectURL(new Blob([e])))
                        } catch (t) {
                            return void 0 !== typeof console && "function" == typeof console.warn && console.warn("🎊 Could not load worker", t), null
                        }
                        !function (t) {
                            function e(e, n) {
                                t.postMessage({options: e || {}, callback: n})
                            }

                            t.init = function (e) {
                                var n = e.transferControlToOffscreen();
                                t.postMessage({canvas: n}, [n])
                            }, t.fire = function (n, a, i) {
                                if (m) return e(n, null), m;
                                var o = Math.random().toString(36).slice(2);
                                return m = l((function (a) {
                                    function r(e) {
                                        e.data.callback === o && (delete g[o], t.removeEventListener("message", r), m = null, i(), a())
                                    }

                                    t.addEventListener("message", r), e(n, o), g[o] = r.bind(null, {data: {callback: o}})
                                }))
                            }, t.reset = function () {
                                for (var e in t.postMessage({reset: !0}), g) g[e](), delete g[e]
                            }
                        }(h)
                    }
                    return h
                }), y = {
                    particleCount: 50,
                    angle: 90,
                    spread: 45,
                    startVelocity: 45,
                    decay: .9,
                    gravity: 1,
                    drift: 0,
                    ticks: 200,
                    x: .5,
                    y: .5,
                    shapes: ["square", "circle"],
                    zIndex: 100,
                    colors: ["#26ccff", "#a25afd", "#ff5e7e", "#88ff5a", "#fcff42", "#ffa62d", "#ff36ff"],
                    disableForReducedMotion: !1,
                    scalar: 1
                };

            function M(t, e, n) {
                return function (t, e) {
                    return e ? e(t) : t
                }(t && null != t[e] ? t[e] : y[e], n)
            }

            function w(t) {
                return t < 0 ? 0 : Math.floor(t)
            }

            function x(t) {
                return parseInt(t, 16)
            }

            function C(t) {
                return t.map(k)
            }

            function k(t) {
                var e = String(t).replace(/[^0-9a-f]/gi, "");
                return e.length < 6 && (e = e[0] + e[0] + e[1] + e[1] + e[2] + e[2]), {
                    r: x(e.substring(0, 2)),
                    g: x(e.substring(2, 4)),
                    b: x(e.substring(4, 6))
                }
            }

            function I(t) {
                t.width = document.documentElement.clientWidth, t.height = document.documentElement.clientHeight
            }

            function S(t) {
                var e = t.getBoundingClientRect();
                t.width = e.width, t.height = e.height
            }

            function T(t, e, n, o, r) {
                var c, s, u = e.slice(), d = t.getContext("2d"), f = l((function (e) {
                    function l() {
                        c = s = null, d.clearRect(0, 0, o.width, o.height), r(), e()
                    }

                    c = v.frame((function e() {
                        !a || o.width === i.width && o.height === i.height || (o.width = t.width = i.width, o.height = t.height = i.height), o.width || o.height || (n(t), o.width = t.width, o.height = t.height), d.clearRect(0, 0, o.width, o.height), u = u.filter((function (t) {
                            return function (t, e) {
                                e.x += Math.cos(e.angle2D) * e.velocity + e.drift, e.y += Math.sin(e.angle2D) * e.velocity + e.gravity, e.wobble += e.wobbleSpeed, e.velocity *= e.decay, e.tiltAngle += .1, e.tiltSin = Math.sin(e.tiltAngle), e.tiltCos = Math.cos(e.tiltAngle), e.random = Math.random() + 2, e.wobbleX = e.x + 10 * e.scalar * Math.cos(e.wobble), e.wobbleY = e.y + 10 * e.scalar * Math.sin(e.wobble);
                                var n = e.tick++ / e.totalTicks, a = e.x + e.random * e.tiltCos,
                                    i = e.y + e.random * e.tiltSin, o = e.wobbleX + e.random * e.tiltCos,
                                    r = e.wobbleY + e.random * e.tiltSin;
                                return t.fillStyle = "rgba(" + e.color.r + ", " + e.color.g + ", " + e.color.b + ", " + (1 - n) + ")", t.beginPath(), "circle" === e.shape ? t.ellipse ? t.ellipse(e.x, e.y, Math.abs(o - a) * e.ovalScalar, Math.abs(r - i) * e.ovalScalar, Math.PI / 10 * e.wobble, 0, 2 * Math.PI) : function (t, e, n, a, i, o, r, l, c) {
                                    t.save(), t.translate(e, n), t.rotate(o), t.scale(a, i), t.arc(0, 0, 1, r, l, c), t.restore()
                                }(t, e.x, e.y, Math.abs(o - a) * e.ovalScalar, Math.abs(r - i) * e.ovalScalar, Math.PI / 10 * e.wobble, 0, 2 * Math.PI) : (t.moveTo(Math.floor(e.x), Math.floor(e.y)), t.lineTo(Math.floor(e.wobbleX), Math.floor(i)), t.lineTo(Math.floor(o), Math.floor(r)), t.lineTo(Math.floor(a), Math.floor(e.wobbleY))), t.closePath(), t.fill(), e.tick < e.totalTicks
                            }(d, t)
                        })), u.length ? c = v.frame(e) : l()
                    })), s = l
                }));
                return {
                    addFettis: function (t) {
                        return u = u.concat(t), f
                    }, canvas: t, promise: f, reset: function () {
                        c && v.cancel(c), s && s()
                    }
                }
            }

            function E(t, n) {
                var a, i = !t, r = !!M(n || {}, "resize"), c = M(n, "disableForReducedMotion", Boolean),
                    s = o && !!M(n || {}, "useWorker") ? p() : null, u = i ? I : S,
                    d = !(!t || !s) && !!t.__confetti_initialized,
                    f = "function" == typeof matchMedia && matchMedia("(prefers-reduced-motion)").matches;

                function h(e, n, i) {
                    for (var o, r, l, c, s, d = M(e, "particleCount", w), f = M(e, "angle", Number), h = M(e, "spread", Number), m = M(e, "startVelocity", Number), g = M(e, "decay", Number), b = M(e, "gravity", Number), v = M(e, "drift", Number), p = M(e, "colors", C), y = M(e, "ticks", Number), x = M(e, "shapes"), k = M(e, "scalar"), I = function (t) {
                        var e = M(t, "origin", Object);
                        return e.x = M(e, "x", Number), e.y = M(e, "y", Number), e
                    }(e), S = d, E = [], F = t.width * I.x, N = t.height * I.y; S--;) E.push((o = {
                        x: F,
                        y: N,
                        angle: f,
                        spread: h,
                        startVelocity: m,
                        color: p[S % p.length],
                        shape: x[(c = 0, s = x.length, Math.floor(Math.random() * (s - c)) + c)],
                        ticks: y,
                        decay: g,
                        gravity: b,
                        drift: v,
                        scalar: k
                    }, r = void 0, l = void 0, r = o.angle * (Math.PI / 180), l = o.spread * (Math.PI / 180), {
                        x: o.x,
                        y: o.y,
                        wobble: 10 * Math.random(),
                        wobbleSpeed: Math.min(.11, .1 * Math.random() + .05),
                        velocity: .5 * o.startVelocity + Math.random() * o.startVelocity,
                        angle2D: -r + (.5 * l - Math.random() * l),
                        tiltAngle: (.5 * Math.random() + .25) * Math.PI,
                        color: o.color,
                        shape: o.shape,
                        tick: 0,
                        totalTicks: o.ticks,
                        decay: o.decay,
                        drift: o.drift,
                        random: Math.random() + 2,
                        tiltSin: 0,
                        tiltCos: 0,
                        wobbleX: 0,
                        wobbleY: 0,
                        gravity: 3 * o.gravity,
                        ovalScalar: .6,
                        scalar: o.scalar
                    }));
                    return a ? a.addFettis(E) : (a = T(t, E, u, n, i)).promise
                }

                function m(n) {
                    var o = c || M(n, "disableForReducedMotion", Boolean), m = M(n, "zIndex", Number);
                    if (o && f) return l((function (t) {
                        t()
                    }));
                    i && a ? t = a.canvas : i && !t && (t = function (t) {
                        var e = document.createElement("canvas");
                        return e.style.position = "fixed", e.style.top = "0px", e.style.left = "0px", e.style.pointerEvents = "none", e.style.zIndex = t, e
                    }(m), document.body.appendChild(t)), r && !d && u(t);
                    var g = {width: t.width, height: t.height};

                    function b() {
                        if (s) {
                            var e = {
                                getBoundingClientRect: function () {
                                    if (!i) return t.getBoundingClientRect()
                                }
                            };
                            return u(e), void s.postMessage({resize: {width: e.width, height: e.height}})
                        }
                        g.width = g.height = null
                    }

                    function v() {
                        a = null, r && e.removeEventListener("resize", b), i && t && (document.body.removeChild(t), t = null, d = !1)
                    }

                    return s && !d && s.init(t), d = !0, s && (t.__confetti_initialized = !0), r && e.addEventListener("resize", b, !1), s ? s.fire(n, g, v) : h(n, g, v)
                }

                return m.reset = function () {
                    s && s.reset(), a && a.reset()
                }, m
            }

            function F() {
                return b || (b = E(null, {useWorker: !0, resize: !0})), b
            }

            n.exports = function () {
                return F().apply(this, arguments)
            }, n.exports.reset = function () {
                F().reset()
            }, n.exports.create = E
        }(function () {
            return void 0 !== t ? t : "undefined" != typeof self ? self : this || {}
        }(), e, !1), t.confetti = e.exports
    }(window, {});
</script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        confetti({
            particleCount: 200,
            spread: 80,
            origin: {y: 0.6},
        });
    });
</script>
