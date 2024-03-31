<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield("htmlheader_title")</title>

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">

    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/buttons.bootstrap4.min.css') }}">

    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
    <script nonce="eb953075-b4f4-4d25-b974-5a91f271e97c">
        try {
            (function(w, d) {
                ! function(k, l, m, n) {
                    k[m] = k[m] || {};
                    k[m].executed = [];
                    k.zaraz = {
                        deferred: [],
                        listeners: []
                    };
                    k.zaraz.q = [];
                    k.zaraz._f = function(o) {
                        return async function() {
                            var p = Array.prototype.slice.call(arguments);
                            k.zaraz.q.push({
                                m: o,
                                a: p
                            })
                        }
                    };
                    for (const q of ["track", "set", "debug"]) k.zaraz[q] = k.zaraz._f(q);
                    k.zaraz.init = () => {
                        var r = l.getElementsByTagName(n)[0],
                            s = l.createElement(n),
                            t = l.getElementsByTagName("title")[0];
                        t && (k[m].t = l.getElementsByTagName("title")[0].text);
                        k[m].x = Math.random();
                        k[m].w = k.screen.width;
                        k[m].h = k.screen.height;
                        k[m].j = k.innerHeight;
                        k[m].e = k.innerWidth;
                        k[m].l = k.location.href;
                        k[m].r = l.referrer;
                        k[m].k = k.screen.colorDepth;
                        k[m].n = l.characterSet;
                        k[m].o = (new Date).getTimezoneOffset();
                        if (k.dataLayer)
                            for (const x of Object.entries(Object.entries(dataLayer).reduce(((y, z) => ({
                                    ...y[1],
                                    ...z[1]
                                })), {}))) zaraz.set(x[0], x[1], {
                                scope: "page"
                            });
                        k[m].q = [];
                        for (; k.zaraz.q.length;) {
                            const A = k.zaraz.q.shift();
                            k[m].q.push(A)
                        }
                        s.defer = !0;
                        for (const B of [localStorage, sessionStorage]) Object.keys(B || {}).filter((D => D
                            .startsWith("_zaraz_"))).forEach((C => {
                            try {
                                k[m]["z_" + C.slice(7)] = JSON.parse(B.getItem(C))
                            } catch {
                                k[m]["z_" + C.slice(7)] = B.getItem(C)
                            }
                        }));
                        s.referrerPolicy = "origin";
                        s.src = "/cdn-cgi/zaraz/s.js?z=" + btoa(encodeURIComponent(JSON.stringify(k[m])));
                        r.parentNode.insertBefore(s, r)
                    };
                    ["complete", "interactive"].includes(l.readyState) ? zaraz.init() : k.addEventListener(
                        "DOMContentLoaded", zaraz.init)
                }(w, d, "zarazData", "script");
            })(window, document)
        } catch (e) {
            throw fetch("/cdn-cgi/zaraz/t"), e;
        };
    </script>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        @extends("layouts.partials.sidebar")

        <div class="content-wrapper">
            @yield("content")
        </div>

        @extends("layouts.partials.footer")

        <aside class="control-sidebar control-sidebar-dark">

        </aside>

    </div>


    <script src="{{asset("js/jquery.min.js")}}"></script>

    <script src="{{asset("js/bootstrap.bundle.min.js")}}"></script>

    <script src="{{asset("js/jquery.dataTables.min.js")}}"></script>
    <script src="{{asset("js/dataTables.bootstrap4.min.js")}}"></script>
    <script src="{{asset("js/dataTables.responsive.min.js")}}"></script>
    <script src="{{asset("js/responsive.bootstrap4.min.js")}}"></script>
    <script src="{{asset("js/dataTables.buttons.min.js")}}"></script>
    <script src="{{asset("js/buttons.bootstrap4.min.js")}}"></script>
    <script src="{{asset("js/jszip.min.js")}}"></script>
    <script src="{{asset("js/pdfmake.min.js")}}"></script>
    <script src="{{asset("js/vfs_fonts.js")}}"></script>
    <script src="{{asset("js/buttons.html5.min.js")}}"></script>
    <script src="{{asset("js/buttons.print.min.js")}}"></script>
    <script src="{{asset("js/buttons.colVis.min.js")}}"></script>

    <script src="{{asset("js/adminlte.min.js?v=3.2.0")}}"></script>

    {{-- <script src="{{asset("js/demo.js")}}"></script> --}}


</body>

</html>
