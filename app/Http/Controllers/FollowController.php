<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    public function toggle(User $user)
    {
        $authUser = Auth::user();

        $toggled = $authUser->following()->toggle($user->id);

        $status = count($toggled['attached']) > 0 ? 'followed' : 'unfollowed';

        $followersCount = $user->followers()->count();

        return response()->json([
            'status' => $status,
            'followers_count' => $followersCount,
        ]);
    }
}
