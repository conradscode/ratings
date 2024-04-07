<x-app-layout>
    <div class="location-container single-location pl-5">
        <div class="text-3xl py-4 text-white">Edit your location</div>
        <form action="{{ route('location.update', $location) }}" method="POST" class="location">
            @csrf
            @method('PUT')
            <input name="name" type="text" value="{{ $location->name }}"><br>
            <textarea
                name="description"
                rows="10"
                class="location-body"
                placeholder="Enter your description here">{{ $location->description }}</textarea>
            <div class="flex">
                <div class="text-3xl py-4 text-white pr-5">Rate this location between 1 and 5</div>
                <select name="rating">
                    @for($i = 1; $i < 6; $i++)
                        <option value="{{$i}}"
                                @if($i == $location->rating)
                                    selected
                            @endif
                        >
                            {{$i}}
                        </option>
                    @endfor
                </select>
            </div>
            <button class="bg-sky-500 text-white font-bold py-2 px-4 rounded-full">Submit</button>
            <a href="{{ route('location.index') }}"
               class="bg-red-500 text-white font-bold py-2 px-4 rounded-full">Cancel</a>
        </form>
    </div>
</x-app-layout>
