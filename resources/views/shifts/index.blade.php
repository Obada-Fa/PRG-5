<x-layout title="Available Shifts">
    <h1 class="text-2xl font-bold mb-4">Available Shifts</h1>
    <form method="GET" action="{{ route('shifts.index') }}" class="mb-6 flex space-x-4">
        <!-- Search Input -->
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by title, description, or location"
               class="border text-black border-gray-300 rounded py-2 px-4 w-full">

        <!-- Status Filter -->
        <select name="status" class="border text-black border-gray-300 rounded py-2 px-4">
            <option value="">All Statuses</option>
            <option value="available" {{ request('status') === 'available' ? 'selected' : '' }}>Available</option>
            <option value="reserved" {{ request('status') === 'reserved' ? 'selected' : '' }}>Reserved</option>
        </select>

        <!-- Submit Button -->
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Search
        </button>
    </form>
    @if(auth()->check() && auth()->user()->isAdmin())
    <a href="{{ route('shifts.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        Add New Shift
    </a>
    @endif
    <div class="grid gap-6">
        @foreach ($shifts as $shift)
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl text-gray-700 font-semibold">{{ $shift->title }}</h2>
                <p class="text-gray-700">{{ $shift->description }}</p>
                <p class="text-gray-700">{{ $shift->start->format('Y-M-d')}} - {{$shift->end->format('Y-M-d')}}</p>
                <p class="text-gray-700">{{ $shift->start->format(' H:i')}} - {{$shift->end->format(' H:i')}}</p>
                <p class="text-gray-500">Location: {{ $shift->location }}</p>
                <p class="text-gray-500">Status: {{ $shift->status }}</p>
@if(auth()->check() && auth()->user()->isAdmin())
                    <div class="mt-4">

                        <a href="{{ route('shifts.edit', $shift->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-4 rounded">Edit</a>
                        <form action="{{ route('shifts.destroy', $shift->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-4 rounded">Delete</button>
                        </form>
                        <form action="{{ route('shifts.toggleStatus', $shift->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit"
                                    class="flex items-center w-28 h-10 rounded-full text-white font-bold transition
                                       {{ $shift->status === 'available' ? 'bg-blue-500' : 'bg-gray-300' }}">
                                <span class="flex-1 text-center">{{ $shift->status === 'available' ? 'available' : 'reserved' }}</span>
                                <span class="inline-block w-6 h-6 bg-white rounded-full shadow ml-2
                                         {{ $shift->status === 'available' ? 'translate-x-0' : 'translate-x-6' }}"></span>
                            </button>
                        </form>
                    </div>
@endif

            </div>
        @endforeach
    </div>
</x-layout>
