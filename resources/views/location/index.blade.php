<x-app-layout>
    <div class="flex">
        @foreach ($locations as $location)
            <div class="p-2"></div>
            <div class="text-blue-950 bg-white w-1/2 p-2">
                <div class="text-2xl">{{ $location->name }}</div>
                <div class="flex flex-row-reverse pt-3">
                    @if($location->_fk_user == request()->user()->id)
                        <form action="{{ route('location.destroy', $location) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-500 text-white font-bold py-2 px-4 rounded-full">Delete</button>
                        </form>
                        <a href="{{ route('location.edit', $location) }}"
                           class="bg-sky-500 text-white font-bold py-2 px-4 rounded-full">Edit</a>
                    @endif
                    <a href="{{ route('location.show', $location) }}"
                       class="bg-sky-500 text-white font-bold py-2 px-4 rounded-full">View</a>
                </div>
            </div>
        @endforeach
        <div class="p-2"></div>
    </div>
    <div class="flex flex-row-reverse pb-6 p-4">
        <a href="{{ route('location.create') }}" class="bg-sky-500 text-white font-bold py-2 p-4 rounded-full">
            New location
        </a>
    </div>
    {{ $locations->links() }}
</x-app-layout>
