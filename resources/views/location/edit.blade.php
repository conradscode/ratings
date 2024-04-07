<x-app-layout>
    <div class="location-container single-location">
        <h1 class="text-3xl py-4">Edit your location</h1>
        <form action="{{ route('location.update', $location) }}" method="POST" class="location">
            @csrf
            @method('PUT')
            <input name="name" type="text" value="{{ $location->name }}"><br>
            <textarea
                name="description"
                rows="10"
                class="location-body"
                placeholder="Enter your description here">{{ $location->description }}</textarea>
            <h3>Rate this location between 1 and 5</h3>
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
            <div class="location-buttons">
                <a href="{{ route('location.index') }}" class="location-cancel-button">Cancel</a>
                <button class="location-submit-button">Submit</button>
            </div>
        </form>
    </div>
</x-app-layout>
