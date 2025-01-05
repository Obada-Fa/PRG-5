@vite('resources/css/app.css')

<x-layout title="El-crew | Welcome">
    <div class="flex flex-col items-center justify-center min-h-screen bg-[#301B22] text-white">

        <section class="text-center py-20 px-4">
            <h1 class="text-4xl md:text-6xl font-extrabold mb-6 text-[#FFFFFF]">Join our team today!</h1>
            <p class="text-lg md:text-xl text-[#FFFFFF] max-w-2xl mx-auto mb-8">
                The best platform for finding work shifts and managing your schedule with ease. Join us today to start exploring job opportunities around you!
            </p>
            <div class="flex justify-center space-x-4">
                <a href="{{ route('shifts.index') }}" class="bg-[#C5AE68] text-[#1F1015] font-bold py-3 px-6 rounded-full shadow-lg hover:bg-[#D4BC7A] transition">View Available Shifts</a>
                @guest
                    <a href="{{ route('login') }}" class="bg-[#1F1015] text-[#FFFFFF] font-bold py-3 px-6 rounded-full shadow-lg hover:bg-[#301B22] transition">Login</a>
                    <a href="{{ route('register') }}" class="bg-[#1F1015] text-[#FFFFFF] font-bold py-3 px-6 rounded-full shadow-lg hover:bg-[#301B22] transition">Register</a>
                @endguest
            </div>
        </section>

    </div>
</x-layout>
