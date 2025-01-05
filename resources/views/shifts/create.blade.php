@vite('resources/css/app.css')

<x-layout title="Create New Shift">
    <div class="max-w-2xl mx-auto mt-10">
        <h1 class="text-3xl font-bold mb-6">Create a New Shift</h1>

        <form action="{{ route('shifts.store') }}" method="POST" class="dark:bg-orange-200 p-6 rounded-lg shadow-lg">
            @csrf

            <div class="mb-4">
                <label for="title" class="block text-[#1F1015] font-semibold mb-2">Title</label>
                <input type="text" name="title" id="title" class="w-full  text-black p-3 border rounded" required>
            </div>

            <div class="mb-4">
                <label for="description" class="block text-[#1F1015] font-semibold mb-2">Description</label>
                <textarea name="description" id="description" class="w-full text-black p-3 border rounded"></textarea>
            </div>

            <div class="mb-4">
                <label for="start_time" class="block text-[#1F1015] font-semibold mb-2">Start Time</label>
                <input type="datetime-local" name="start" id="start" class="w-full text-black p-3 border rounded" required>
            </div>

            <div class="mb-4">
                <label for="end_time" class="block text-[#1F1015] font-semibold mb-2">End Time</label>
                <input type="datetime-local" name="end" id="end" class="w-full text-black p-3 border rounded" required>
            </div>

            <div class="mb-4">
                <label for="location" class="block text-[#1F1015] font-semibold mb-2">Location</label>
                <input type="text" name="location" id="location" class="w-full text-black p-3 border rounded" required>
            </div>

            <div class="mb-4">
                <label for="status" class="block text-[#1F1015] font-semibold mb-2">Status</label>
                <select name="status" id="status" class="w-full text-black p-3 border rounded">
                    <option value="available">Available</option>
                    <option value="reserved">Reserved</option>
                </select>
            </div>

            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Create Shift</button>
            <a href="{{ route('shifts.index') }}" class="ml-4 text-gray-500">Cancel</a>
        </form>
    </div>
</x-layout>
