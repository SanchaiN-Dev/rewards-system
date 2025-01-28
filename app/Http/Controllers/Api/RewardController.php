<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reward;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;


class RewardController extends Controller
{
    public function index(): JsonResponse
    {
        // Retrieve all rewards from the database
        $rewards = Reward::all();

        // Return as JSON response
        return response()->json($rewards);
    }

    public function redeem(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'points_required' => 'required|integer|min:1'
        ]);

        $user = User::find($request->user_id);

        // Check if the user has enough points
        if ($user->reward_point < $request->points_required) {
            return response()->json([
                'success' => false,
                'message' => 'Not enough points to redeem this reward.'
            ]);
        }

        // Deduct points and save
        $user->reward_point -= $request->points_required;
        $user->save();

        // Optionally, you can log the transaction here
        // Transaction::create([
        //     'user_id' => $user->id,
        //     'reward_title' => $request->reward_title,
        //     'points_used' => $request->points_required,
        //     'status' => 'completed'
        // ]);

        return response()->json([
            'success' => true,
            'message' => 'Reward redeemed successfully!',
        ]);
    }
}
