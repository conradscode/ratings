<x-app-layout>
    <div class="pl-5">
        <div class="text-3xl py-4 text-white">Create a new location</div>
        <form action="{{ route('location.store') }}" method="POST">
            @csrf
            <input name="name" type="text" placeholder="Enter the location name"><br>
            <textarea
                name="description"
                rows="10"
                placeholder="Enter your description here"></textarea>
            <div class="flex">
                <div class="text-3xl py-4 text-white pr-5">Rate this location between 1 and 5:</div>
                <select name="rating">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>
            <div class="flex">
                <button class="bg-sky-500 text-white font-bold py-2 px-4 rounded-full">Create</button>
                <a href="{{ route('location.index') }}"
                   class="bg-red-500 text-white font-bold py-2 px-4 rounded-full">Cancel</a>
            </div>
        </form>
    </div>
</x-app-layout>
