<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Reward;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class RewardsController extends Controller
{
    public function index(): JsonResponse
    {
        $userId = Auth::id(); // Safely get logged-in user ID
        // Retrieve all rewards from the database
        $rewards = Reward::all()->map(function ($reward) use ($userId) {
            $reward->isRedeemed = $reward->transactions()->where('user_id', $userId)->exists();
            return $reward;
        });

        return response()->json($rewards);
        // Return as JSON response
        return response()->json($rewards);
    }

    public function redeem(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'reward_id' => 'required|exists:rewards,id', // Ensure reward_id is included
            'points_required' => 'required|integer|min:1'
        ]);

        $user = User::find($request->user_id);
        $reward = Reward::find($request->reward_id);

        // Check if the user has enough points
        if ($user->reward_point < $request->points_required) {
            return response()->json([
                'success' => false,
                'message' => 'Not enough points to redeem this reward.'
            ]);
        }

        // Check if the user has already redeemed this reward
        $alreadyRedeemed = Transaction::where('user_id', $request->user_id)
            ->where('reward_id', $request->reward_id)
            ->exists();

        if ($alreadyRedeemed) {
            return response()->json([
                'success' => false,
                'message' => 'You have already redeemed this reward.'
            ]);
        }

        // Deduct points and save
        $user->reward_point -= $request->points_required;
        $user->save();

        // Create a transaction record
        Transaction::create([
            'user_id' => $request->user_id,
            'reward_id' => $request->reward_id,
            'points_used' => $request->points_required,
            'status' => 'completed', // You can use 'pending' if you have an approval system
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Reward redeemed successfully!',
        ]);
    }

}
