<x-layout>
    <div class="location-container single-location">
        <h1>Create new location</h1>
        <form action="{{ route('location.store') }}" method="POST" class="location">
            @csrf
            <input name="name" type="text" placeholder="Enter the location name"><br>
            <textarea
                name="description"
                rows="10"
                class="location-body"
                placeholder="Enter your description here"></textarea>
            <h3>Rate this location between 1 and 5</h3>
            <select name="rating">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
            <div class="location-buttons">
                <a href="{{ route('location.index') }}" class="location-cancel-button">Cancel</a>
                <button class="location-submit-button">Submit</button>
            </div>
        </form>
    </div>
</x-layout>
