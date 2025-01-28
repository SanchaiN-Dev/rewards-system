@extends('layouts.user_type.auth')
@section('content')
<div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
    <div class="col-12 mt-4">
        <div class="card mb-4">
            <div class="card-header pb-0 p-3">
                <h6 class="mb-1">User Details</h6>
            </div>
            <div class="card-body p-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Hello, {{ $user->name }}</h5>
                        <p class="card-text"><strong>Email:</strong> {{ $user->email }}</p>
                        <p class="card-text"><strong>Phone:</strong> {{ $user->phone ?? 'Not Provided' }}</p>
                        <p class="card-text"><strong>Location:</strong> {{ $user->location ?? 'Not Provided' }}</p>
                        <p class="card-text"><strong>About Me:</strong> {{ $user->about_me ?? 'Not Provided' }}</p>
                        <p class="card-text"><strong>Reward Points:</strong> {{ $user->reward_point }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
