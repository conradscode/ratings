<x-app-layout>
    <div class="location-container single-location">
        <div class="location-header">
            <h1 class="text-3xl py-4">Location: {{ $location->created_at }}</h1>
            <div class="location-buttons">
                <a href="{{ route('location.edit', $location) }}" class="location-edit-button">Edit</a>
                <form action="{{ route('location.destroy', $location) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="location-delete-button">Delete</button>
                </form>
            </div>
        </div>
        <div class="location">
            <div class="location-body">
                {{ $location->name }}
            </div>
        </div>
    </div>
</x-app-layout>

