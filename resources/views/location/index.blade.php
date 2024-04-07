<x-app-layout>
    <div class="location-container">
        <div class="flex p-5">
            @foreach ($locations as $location)
                <div class="location border-double border-4 border-white w-1/2">
                    <p class="text-sky-400 text-xl">{{ $location->name }}</p>
                    <div class="flex">
                        <a href="{{ route('location.show', $location) }}"
                           class="bg-sky-500 text-white font-bold py-2 px-4 rounded-full">View</a>
                        <a href="{{ route('location.edit', $location) }}"
                           class="bg-sky-500 text-white font-bold py-2 px-4 rounded-full">Edit</a>
                        <form action="{{ route('location.destroy', $location) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-500 text-white font-bold py-2 px-4 rounded-full">Delete</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <a href="{{ route('location.create') }}" class="bg-sky-500 text-white font-bold py-2 px-4 rounded-full">
        New location
    </a>
    {{ $locations->links() }}
</x-app-layout>
