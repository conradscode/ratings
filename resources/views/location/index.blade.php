<x-layout>
    <div class="location-container">
        <a href="#" class="new-location-btn">
            New location
        </a>
        <div class="locations">
            @foreach ($locations as $location)
                <div class="location">
                    <div class="location-body">
                        {{ $location->name }}
                    </div>
                    <div class="location-buttons">
                        <a href="#" class="location-button">View</a>
                        <a href="#" class="location-button">Edit</a>
                        <button class="location-delete-button">Delete</button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-layout>
