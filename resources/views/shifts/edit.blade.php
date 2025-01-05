@vite('resources/css/app.css')

<x-layout title="Edit Shift">
    <div class="max-w-2xl mx-auto mt-10">
        <h1 class="text-3xl font-bold mb-6">Edit Shift</h1>

        <form action="{{ route('shifts.update', $shift->id) }}" method="POST" class="bg-white p-6 rounded-lg shadow-lg">
            @csrf
            @method('PUT') <!-- Specifies the HTTP method for updating -->

            <div class="mb-4">
                <label for="title" class="block text-[#1F1015] font-semibold mb-2">Title</label>
                <input type="text" name="title" id="title" value="{{ old('title', $shift->title) }}" class="w-full text-black p-3 border rounded" required>
            </div>

            <div class="mb-4">
                <label for="description" class="block text-[#1F1015] font-semibold mb-2">Description</label>
                <textarea name="description" id="description" class="w-full text-black p-3 border rounded">{{ old('description', $shift->description) }}</textarea>
            </div>

            <div class="mb-4">
                <label for="start" class="block text-[#1F1015] font-semibold mb-2">Start Time</label>
                <input type="datetime-local" name="start" id="start" value="{{ old('start', $shift->start) }}" class="w-full text-black p-3 border rounded" required>
            </div>

            <div class="mb-4">
                <label for="end" class="block text-[#1F1015] font-semibold mb-2">End Time</label>
                <input type="datetime-local" name="end" id="end" value="{{ old('end', $shift->end) }}" class="w-full text-black p-3 border rounded" required>
            </div>

            <div class="mb-4">
                <label for="location" class="block text-[#1F1015] font-semibold mb-2">Location</label>
                <input type="text" name="location" id="location" value="{{ old('location', $shift->location) }}" class="w-full text-black p-3 border rounded" required>
            </div>

            <div class="mb-4">
                <label for="status" class="block text-[#1F1015] font-semibold mb-2">Status</label>
                <select name="status" id="status" class="w-full text-black p-3 border rounded">
                    <option value="available" {{ old('status', $shift->status) == 'available' ? 'selected' : '' }}>Available</option>
                    <option value="reserved" {{ old('status', $shift->status) == 'reserved' ? 'selected' : '' }}>Reserved</option>
                </select>
            </div>

            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update Shift</button>
            <a href="{{ route('shifts.index') }}" class="ml-4 text-gray-500">Cancel</a>
        </form>
    </div>
</x-layout>
