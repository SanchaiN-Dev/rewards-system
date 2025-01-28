<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Reward;

class RewardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $transactions = Transaction::where('user_id', $user->id)->get();
        $rewards = Reward::all(); // Assuming you fetch all rewards

        return view('reward', compact('user', 'rewards', 'transactions'));
    }

    public function redeem(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'reward_id' => 'required|exists:rewards,id', // Ensure reward exists
            'points_required' => 'required|integer|min:1'
        ]);

        $user = User::find($request->user_id);

        // Check if the reward is already redeemed
        $existingTransaction = Transaction::where('user_id', $user->id)
            ->where('reward_id', $request->reward_id)
            ->first();

        if ($existingTransaction) {
            return response()->json([
                'success' => false,
                'message' => 'You have already redeemed this reward.'
            ]);
        }

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

        // Log the transaction
        Transaction::create([
            'user_id' => $user->id,
            'reward_id' => $request->reward_id,
            'points_used' => $request->points_required,
            'status' => 'completed',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Reward redeemed successfully!',
        ]);
    }
}

