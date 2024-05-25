<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
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
                'updated_at' => now()
            ]);

        return to_route('location.index');
    }

    public function destroy(int $locationId): RedirectResponse
    {
        if (!$this->likeExists($locationId)) {
            return to_route('location.index');
        }

        Like::query()
            ->where([
                '_fk_location' => $locationId,
                '_fk_user' => Auth::id(),
            ])
            ->delete();

        return to_route('location.index');
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
}
