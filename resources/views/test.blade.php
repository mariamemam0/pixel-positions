<!DOCTYPE html>
<html>
<head>
    <title>Pusher Test</title>
    <meta name="csrf-token" content="{{ csrf_token() }}"> {{-- ADD THIS --}}
    @vite(['resources/js/app.js'])
</head>
<body>
    <h1>Pusher Test Page</h1>
    <div id="notifications"></div>
    
    <script>
        window.Laravel = {
            userId: 22,
            csrfToken: '{{ csrf_token() }}'
        };
    </script>
</body>
</html>