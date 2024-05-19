<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LocationController extends Controller
{
    protected LikeController $likeController;

    public function __construct(LikeController $likeController)
    {
        $this->likeController = $likeController;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $locations = Location::query()
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        foreach ($locations as $location) {
            $location->likes = $this->likeController->getLikesCount($location->id);
            $location->like_active = $this->likeController->getLikeActive($location->id);
        }

        return view('location.index', compact('locations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('location.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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

    /**
     * Display the specified resource.
     */
    public function show(Location $location)
    {
        return view('location.show', compact('location'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Location $location)
    {
        if (!$this->isUserAuthenticated($location->getAttribute('_fk_user'))) {
            abort(403);
        }
        return view('location.edit', compact('location'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Location $location): RedirectResponse
    {
        if (!$this->isUserAuthenticated($location->getAttribute('_fk_user'))) {
            abort(403);
        }

        $request = $request->validate([
            'name' => ['required', 'string', 'max:25'],
            'description' => ['required', 'string', 'max:144'],
            'rating' => ['required', 'numeric', 'digits_between:1,5'],
        ]);

        $location->update($request);
        return to_route('location.show', $location)
            ->with('message', 'Location updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Location $location): RedirectResponse
    {
        if (!$this->isUserAuthenticated($location->getAttribute('_fk_user'))) {
            abort(403);
        }
        $location->delete();
        return to_route('location.index')
            ->with('message', 'Location deleted successfully.');
    }

    public function isUserAuthenticated(int $fkUser): bool
    {
        return $fkUser == Auth::id();
    }
}
