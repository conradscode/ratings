<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LocationController extends Controller
{
    protected LikeController $likeController;

    protected ProfileController $profileController;

    public function __construct(
        LikeController $likeController,
        ProfileController $profileController
    ) {
        $this->likeController = $likeController;
        $this->profileController = $profileController;
    }

    public function index(): View
    {
        $locations = Location::query()
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        foreach ($locations as $location) {
            $this->getAdditionalLocationProperties($location);
        }

        return view('location.index', compact('locations'));
    }

    public function create(): View
    {
        return view('location.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $location = $request->validate([
            'name' => ['required', 'string', 'max:25'],
            'description' => ['required', 'string', 'max:144'],
            'rating' => ['required', 'numeric', 'digits_between:1,5'],
        ]);

        $location['_fk_user'] = Auth::id();
        $location = Location::query()->create($location);

        return to_route('location.show', $location)
            ->with('message', 'Location created successfully.');
    }

    public function show(Location $location): View
    {
        $this->getAdditionalLocationProperties($location);

        return view('location.show', compact('location'));
    }

    public function edit(Location $location): View
    {
        if (! $this->isUserAuthenticated($location->getAttribute('_fk_user'))) {
            abort(403);
        }

        return view('location.edit', compact('location'));
    }

    public function update(Request $request, Location $location): RedirectResponse
    {
        if (! $this->isUserAuthenticated($location->getAttribute('_fk_user'))) {
            abort(403);
        }

        $request = $request->validate([
            'name' => ['required', 'string', 'max:25'],
            'description' => ['required', 'string', 'max:144'],
            'rating' => ['required', 'numeric', 'digits_between:1,5'],
        ]);

        $location->update($request);

        return to_route('location.show', $location);
    }

    public function destroy(Location $location): RedirectResponse
    {
        if (! $this->isUserAuthenticated($location->getAttribute('_fk_user'))) {
            abort(403);
        }

        $this->likeController->deleteAllLikes($location->id);
        $location->delete();

        return to_route('location.index')
            ->with('message', 'Location deleted successfully.');
    }

    public function isUserAuthenticated(int $fkUser): bool
    {
        return $fkUser == Auth::id();
    }

    public function getAdditionalLocationProperties(Location $location): Location
    {
        $location->likes = $this->likeController->getLikesCount($location->id);
        $location->liked_by_current_user = $this->likeController->likeExists($location->id);
        $location->posted_user = $this->profileController->getUserDetailsById($location->_fk_user);

        return $location;
    }
}
