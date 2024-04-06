<x-layout>
    <div class="location-container">
        <a href="{{ route('location.create') }}" class="new-location-btn">
            New location
        </a>
        <div class="locations">
            @foreach ($locations as $location)
                <div class="location">
                    <div class="location-body">
                        {{ $location->name }}
                    </div>
                    <div class="location-buttons">
                        <a href="{{ route('location.show', $location) }}"
                            class="location-button">View</a>
                        <a href="{{ route('location.edit', $location) }}"
                           class="location-button">Edit</a>
                        <form action="{{ route('location.destroy', $location) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="location-delete-button">Delete</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        {{ $locations->links() }}
    </div>
</x-layout>
