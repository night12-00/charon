<!DOCTYPE html>
<html lang="en">
    <head>
      <title>@yield('title')</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      
      @vite('resources/assets/css/app.css')
      <script>
        // Work around for "global is not defined" error with local-storage.js
        window.global = window
      </script>
    </head>
    <body>
        <div id="app"></div>
        <noscript>It may sound funny, but Charon requires JavaScript to sing. Please enable it.</noscript>
        <script>
            window.PUSHER_APP_KEY = @json(config('broadcasting.connections.pusher.key'));
            window.PUSHER_APP_CLUSTER = @json(config('broadcasting.connections.pusher.options.cluster'));
        </script>
        @stack('scripts')
    </body>
</html>
