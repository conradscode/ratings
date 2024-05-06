<?php

namespace App\Http\Controllers;

use App\Models\Like;

class LikeController extends Controller
{
    const LIKE_ACTIVE = 1;

    public function index(int $locationId): int
    {
        return Like::query()
            ->where(
                [
                    '_fk_location' => $locationId,
                    'like_active' => self::LIKE_ACTIVE
                ]
            )
            ->count();
    }

    public function show(int $locationId): int
    {
        return Like::query()
            ->where(
                [
                    '_fk_location' => $locationId,
                    '_fk_user' => auth()->id(),
                    'like_active' => self::LIKE_ACTIVE
                ]
            )
            ->count();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(int $locationId)
    {
        Like::query()
            ->where('_fk_location', $locationId)
            ->updateOrInsert([
                '_fk_location' => $locationId,
                '_fk_user' => auth()->id(),
            ]);

        return to_route('location.index');
    }
}
