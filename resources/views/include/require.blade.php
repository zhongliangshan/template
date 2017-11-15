  <script type="text/javascript" src="/js_src/require/require.js"></script>
  <script type="text/javascript">
        require({
            baseUrl: "/js_src/",
            urlArgs: "{!! app_update_time() !!}"
        });
        require(["/js_src/config.js"], function () {
            require(["{!! isset($requireJs) ? $requireJs : 'empty' !!}"]);
        });
  </script>

@yield('js')
