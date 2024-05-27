<x-app-layout>
    <div class="text-blue-950 bg-white w-1/4 mx-auto p-2">
        <a href="/" class="bg-sky-500 text-white font-bold p-1.5 rounded-full float-right">Return Home</a>
        <div class="text-xl pb-2 ">Users who like this location</div>
        @foreach($users as $user)
            <div class="underline text-sky-500">
                <a href="{{ route('profile.show', $user->id) }}">{{ $user->name }}</a>
            </div>
        @endforeach
    </div>
</x-app-layout>
