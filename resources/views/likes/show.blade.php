<x-app-layout>
    <div class="text-blue-950 bg-white w-1/4 mx-auto p-2">
        <div class="text-xl pb-2 ">Users who like this location</div>
        @foreach($users as $user)
            <div class="text-md">{{ $user->name }}</div>
        @endforeach
    </div>
</x-app-layout>
