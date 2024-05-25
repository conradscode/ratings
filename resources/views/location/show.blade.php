<x-app-layout>
    <div class="text-blue-950 bg-white w-1/4 mx-auto p-2">
        <a href="/" class="bg-sky-500 text-white font-bold p-1.5 rounded-full float-right">Return Home</a>
        <div class="text-2xl pb-3">{{ $location->name }}</div>
        <div>{{ $location->description }}</div>
        <div class="flex flex-row-reverse">
            @if($location->_fk_user == request()->user()->id)
                <form action="{{ route('location.destroy', $location) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="bg-red-500 text-white font-bold py-2 px-4 rounded-full"
                    >Delete
                    </button>
                </form>
                <a href="{{ route('location.edit', $location) }}"
                   class="bg-sky-500 text-white font-bold py-2 px-4 rounded-full">Edit</a>
            @endif
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
</x-app-layout>
