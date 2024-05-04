<x-app-layout>
    <div class="text-blue-950 bg-white w-1/4 mx-auto p-2">
        <div class="text-2xl pb-3">{{ $location->name }}</div>
        <div>{{ $location->description }}</div>
        @if($location->_fk_user == request()->user()->id)
            <div class="flex flex-row-reverse">
                <form action="{{ route('location.destroy', $location) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="bg-red-500 text-white font-bold py-2 px-4 rounded-full"
                    >Delete
                    </button>
                </form>
                <a href="{{ route('location.edit', $location) }}"
                   class="bg-sky-500 text-white font-bold py-2 px-4 rounded-full">Edit</a>
            </div>
        @endif
    </div>
</x-app-layout>
