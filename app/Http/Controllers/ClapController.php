<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class ClapController extends Controller
{
    public function toggle(Post $post)
    {
        $user = auth()->user();

        $existing = $post->claps()->where('user_id', $user->id)->first();

        if ($existing) {
            $existing->delete();
            $status = 'unclapped';
        } else {
            $post->claps()->create([
                'user_id' => $user->id,
                'created_at' => now(),
            ]);
            $status = 'clapped';
        }

        return response()->json([
            'status' => $status,
            'count' => $post->claps()->count(),
        ]);
    }
}
