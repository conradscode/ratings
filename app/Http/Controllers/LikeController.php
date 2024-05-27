<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function show(int $locationId)
    {
        $usersIds = Like::query()
            ->where('_fk_location', $locationId)
            ->pluck('_fk_user');

        $users = User::query()
            ->select(['id', 'name'])
            ->whereIn('id', $usersIds)
            ->get();

        return view('likes.show', compact('users'));
    }

    public function store(int $locationId): RedirectResponse
    {
        if ($this->likeExists($locationId)) {
            return to_route('location.index');
        }

        Like::query()
            ->where('_fk_location', $locationId)
            ->insert([
                '_fk_location' => $locationId,
                '_fk_user' => Auth::id(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

        return back();
    }

    public function destroy(int $locationId): RedirectResponse
    {
        if (! $this->likeExists($locationId)) {
            return to_route('location.index');
        }

        Like::query()
            ->where([
                '_fk_location' => $locationId,
                '_fk_user' => Auth::id(),
            ])
            ->delete();

        return back();
    }

    public function likeExists(int $locationId): bool
    {
        return Like::query()
            ->where([
                '_fk_location' => $locationId,
                '_fk_user' => Auth::id(),
            ])
            ->exists();
    }

    public function getLikesCount(int $locationId): int
    {
        return Like::query()
            ->where('_fk_location', $locationId)
            ->count();
    }

    public function deleteAllLikes(int $locationId): void
    {
        Like::query()
            ->where('_fk_location', $locationId)
            ->delete();
    }
}
