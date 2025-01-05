@vite('resources/css/app.css')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'El Crew' }}</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-[#301B22] text-white">
<!-- Navbar -->
<nav class="bg-[#1F1015] p-4 shadow-lg">
    <div class="container mx-auto flex justify-between items-center">
        <a href="/" class="text-2xl font-bold text-[#C5AE68]">El Crew</a>
        <div class="flex space-x-4">
            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('shifts.create') }}" class="text-white hover:text-[#C5AE68] px-3">Add Shifts</a>
                @endif
                    <a href="{{route('profile')}}">Profile</a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-white hover:text-[#C5AE68] px-3">Logout</button>
                    </form>
            @else
                <a href="{{ route('login') }}" class="text-white hover:text-[#C5AE68] px-3">Login</a>
                <a href="{{ route('register') }}" class="px-4 py-2 bg-[#C5AE68] text-[#1F1015] font-semibold rounded-lg hover:bg-[#D4BC7A] transition">Register</a>
            @endguest
        </div>
    </div>
</nav>

<!-- Main Content -->
<main class="container mx-auto p-6">
    {{ $slot }}
</main>

<!-- Footer -->
<footer class="bg-[#1F1015] text-[#C5AE68] text-center py-4">
    <p>&copy; {{ date('Y') }} El Crew. All rights reserved.</p>
</footer>
</body>
</html>
