<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pixel Positions</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;500;600&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-black text-white font-hanken-grotesk pb-20">
    <div id="notifications" class="fixed top-4 right-4 w-80 space-y-2 z-50"></div>

    <div class="px-10">
        <nav class="flex justify-between items-center py-4 border-b border-white/10">
            <!-- Logo -->
            <div>
                <a href="/">
                    <img src="{{ Vite::asset('resources/images/logo.svg') }}" alt="Logo">
                </a>
            </div> 

            <!-- Links -->
            <div class="space-x-6 font-bold">
                <a href="#">Jobs</a>
                <a href="#">Careers</a>
                <a href="#">Salaries</a>
                <a href="#">Companies</a>
            </div>

            <!-- Auth Section -->
            @auth
            <div class="space-x-6 font-bold flex items-center">
                <!-- 🔔 Notification Icon -->
                <a href="{{ route('notifications.index') }}" class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg" 
                         class="h-6 w-6" fill="none" viewBox="0 0 24 24" 
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 
                                 14.158V11a6.002 6.002 0 00-4-5.659V5a2 
                                 2 0 10-4 0v.341C7.67 6.165 
                                 6 8.388 6 11v3.159c0 
                                 .538-.214 1.055-.595 
                                 1.436L4 17h5m6 0v1a3 
                                 3 0 11-6 0v-1m6 0H9" />
                    </svg>

                    <!-- 🔴 Unread count badge -->
                    @if(auth()->user()->unreadNotifications->count() > 0)
                        <span class="absolute -top-2 -right-2 bg-red-500 text-white 
                                     text-xs rounded-full px-1.5 py-0.5">
                            {{ auth()->user()->unreadNotifications->count() }}
                        </span>
                    @endif
                </a>

                <!-- Post Job -->
                <a href="/jobs/create">Post a Job</a>

                <!-- Logout -->
                <form method="POST" action="/logout" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Log Out</button>
                </form>
            </div> 
            @endauth

            @guest
            <div class="space-x-6 font-bold">
                <a href="/register">Sign Up</a>
                <a href="/login">Log In</a>
            </div>
            @endguest
        </nav>

        <!-- Main Content -->
        <main class="mt-10 max-w-[980px] mx-auto">
            {{ $slot }}
        </main>
    </div>

   @auth
<script>
    window.Laravel = {
        userId: {{ Auth::id() }},
        csrfToken: '{{ csrf_token() }}'
    };
</script>
@endauth
</body>
</html>
