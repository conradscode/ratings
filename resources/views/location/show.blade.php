<x-app-layout>
    <div class="text-blue-950 bg-white w-1/4">
        <div class="text-2xl">{{ $location->name }}</div>
        <div>{{ $location->description }}</div>
        <div class="flex">
            <a href="{{ route('location.edit', $location) }}"
               class="bg-sky-500 text-white font-bold py-2 px-4 rounded-full">Edit</a>
            <form action="{{ route('location.destroy', $location) }}" method="POST">
                @csrf
                @method('DELETE')
                <button class="bg-red-500 text-white font-bold py-2 px-4 rounded-full"
                >Delete
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
