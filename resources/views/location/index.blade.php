<x-app-layout>
    <div class="location-container">
        <div class="flex p-5">
            @foreach ($locations as $location)
                <div class="p-5"></div>
                <div class="text-blue-950 bg-white w-1/2">
                    <div class="text-2xl pl-2">{{ $location->name }}</div>
                    <div class="flex p-5 pt-2">
                        <a href="{{ route('location.show', $location) }}"
                           class="bg-sky-500 text-white font-bold py-2 px-4 rounded-full">View</a>
                        @if($location->_fk_user == request()->user()->id)
                            <a href="{{ route('location.edit', $location) }}"
                               class="bg-sky-500 text-white font-bold py-2 px-4 rounded-full">Edit</a>
                            <form action="{{ route('location.destroy', $location) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-500 text-white font-bold py-2 px-4 rounded-full">Delete</button>
                            </form>
                        @endif
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
