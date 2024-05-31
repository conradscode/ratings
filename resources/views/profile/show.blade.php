<x-app-layout>
    <div class="text-blue-950 bg-white w-1/4 mx-auto p-2">
        <a href="/" class="bg-sky-500 text-white font-bold p-1.5 rounded-full float-right">Return Home</a>
        <div class="text-2xl pb-3">{{ $user->name }}</div>
        <div>{{ $user->id }}</div>
        <div class="flex flex-row-reverse">
            @if($user->id == request()->user()->id)
                <form action="{{ route('profile.edit') }}" method="GET">
                    @csrf
                    <button class="bg-sky-500 text-white font-bold py-2 px-4 rounded-full"
                    >Edit Profile
                    </button>
                </form>
            @else
                @if($user->follow_exists)
                    <form action="{{ route('follow.destroy', $user->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="bg-sky-500 text-white font-bold py-2 px-4 rounded-full"
                                href="{{ route('follow.destroy', $user->id) }}">
                            Unfollow
                        </button>
                    </form>
                @else
                    <form action="{{ route('follow.store', $user->id) }}" method="POST">
                        @csrf
                        @method('POST')
                        <button class="bg-sky-500 text-white font-bold py-2 px-4 rounded-full"
                                href="{{ route('follow.store', $user->id) }}">
                            Follow
                        </button>
                    </form>
                @endif
            @endif
        </div>
    </div>
</x-app-layout>
