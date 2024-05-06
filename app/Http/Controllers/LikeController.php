<?php

namespace App\Http\Controllers;

use App\Models\Like;

class LikeController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(int $locationId): int
    {
        return Like::query()
            ->where(
                [
                    '_fk_location' => $locationId,
                    'like_active' => 1
                ]
            )
            ->count();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(int $locationId, int $likeActive)
    {
        Like::query()
            ->where('_fk_location', $locationId)
            ->updateOrInsert([
                '_fk_location' => $locationId,
                'like_active' => $likeActive
            ]);

        return to_route('location.index');
    }
}
