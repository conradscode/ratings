<?php

namespace App\Http\Controllers;

use App\Models\Follower;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    public function store(int $userId): RedirectResponse
    {
        if (!$this->followExists($userId)) {
            Follower::query()
                ->insert([
                    '_fk_user' => Auth::id(),
                    '_fk_user_followed' => $userId,
                ]);
        }

        return back();
    }

    public function destroy(int $userId): RedirectResponse
    {
        if ($this->followExists($userId)) {
            Follower::query()
                ->where([
                    '_fk_user' => Auth::id(),
                    '_fk_user_followed' => $userId,
                ])
                ->delete();
        }

        return back();
    }

    public function followExists(int $userId): bool
    {
        return Follower::query()
            ->where([
                '_fk_user' => Auth::id(),
                '_fk_user_followed' => $userId,
            ])
            ->exists();
    }
}
