<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Reward;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RewardController extends Controller
{
    /**
     * Display a listing of rewards.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        // Fetch all rewards from the database
        $rewards = Reward::all();

        // Format the response
        return response()->json($rewards);
    }
}
