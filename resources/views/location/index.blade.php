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
                    @if ($location->liked_by_current_user)
                        <form action="{{ route('likes.destroy', ['locationId' => $location->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="bg-sky-500 text-white font-bold py-2 px-4 rounded-full">Unlike</button>
                        </form>
                    @else
                        <form action="{{ route('likes.store', ['locationId' => $location->id]) }}" method="POST">
                            @csrf
                            @method('POST')
                            <button class="bg-sky-500 text-white font-bold py-2 px-4 rounded-full">Like</button>
                        </form>
                    @endif
                    <a class="p-2" href="{{ route('likes.show', ['locationId' => $location->id]) }}">
                        {{$location->likes}} @if($location->likes > 1 || $location->likes < 1)
                            Likes
                        @else
                            Like
                        @endif
                    </a>
                </div>
            </div>
        @endforeach
        <div class="p-2"></div>
    </div>
    <div class="flex flex-row-reverse pb-6 p-4">
        <a href="{{ route('location.create') }}" class="bg-sky-500 text-white font-bold py-2 p-4 rounded-full">
            Create new location
        </a>
    </div>
    {{ $locations->links() }}
</x-app-layout>
