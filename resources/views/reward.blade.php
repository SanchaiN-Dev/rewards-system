@extends('layouts.user_type.auth')

@section('content')
<div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
    <div class="col-12 mt-4">
        <div class="card mb-4">
            <div class="card-header pb-0 p-3">
                <h6 class="mb-1">Rewards</h6>
            </div>
            <div class="card-body p-3">
                <!-- Carousel Wrapper -->
                <div id="rewardCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div id="carousel-inner" class="carousel-inner">
                        @foreach ($rewards->chunk(3) as $rewardGroup)
                            <div class="carousel-item @if ($loop->first) active @endif">
                                <div class="row">
                                    @foreach ($rewardGroup as $reward)
                                        @php
                                            $isRedeemed = $transactions->contains(function ($transaction) use ($reward) {
                                                return $transaction->reward_id == $reward->id;
                                            });
                                            $currentDate = date('Y-m-d');
                                            $isExpired = $reward->valid_until < $currentDate;
                                        @endphp
                                        @if (!$isExpired)
                                        <div class="col-md-4">
                                            <div class="card card-blog card-plain">
                                                <div class="position-relative">
                                                    <a href="javascript:;"
                                                       class="d-block shadow-xl border-radius-xl"
                                                       data-bs-toggle="modal"
                                                       data-bs-target="#rewardModal"
                                                       onclick="showRewardDetails('{{ $reward->id }}', '{{ $reward->title }}', '{{ $reward->description }}', '{{ $reward->points_required }}', '{{ $reward->valid_until }}', '{{ $reward->image }}', {{ $isRedeemed ? 'true' : 'false' }})">
                                                        <img src="{{ $reward->image }}" alt="reward image" class="img-fluid shadow border-radius-xl w-100 h-40 object-cover">
                                                    </a>
                                                </div>
                                                <div class="card-body px-1 pb-0">
                                                    <h5>{{ $reward->title }}</h5>
                                                    <p class="mb-4 text-sm">{{ $reward->description }}</p>
                                                    <p class="text-gradient text-dark mb-2 text-lg">Points: {{ $reward->points_required }}</p>
                                                    <p class="text-gradient text-dark mb-2 text-sm">Expires: {{ $reward->valid_until }}</p>

                                                    @if ($isRedeemed)
                                                        <button type="button" class="btn btn-secondary btn-sm mb-0" disabled>Already Redeemed</button>
                                                    @else
                                                        <button type="button"
                                                                class="btn btn-outline-primary btn-sm mb-0 redeem-btn"
                                                                data-id="{{ $reward->id }}"
                                                                data-points="{{ $reward->points_required }}"
                                                                onclick="redeem('{{ $reward->id }}', '{{ $reward->points_required }}')">
                                                            Redeem
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!-- Carousel Controls -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#rewardCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#rewardCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- JavaScript for Fetching Data -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    const userId = @json(auth()->user()->id);

    // Function to show reward details in modal
    function showRewardDetails(id, title, description, points, expire, image, isRedeemed) {
        $('#modalTitle').text(title);
        $('#modalDescription').text(description);
        $('#modalPoints').text(points);
        $('#modalExpire').text(expire);
        $('#modalImage').attr('src', image);
        $('#modalRewardId').val(id); // Set reward ID
        $('#modalRewardPoints').val(points); // Set reward points

        if (isRedeemed) {
            $('#redeemStatusButton').show();
            $('#redeemActionButton').hide();
        } else {
            $('#redeemStatusButton').hide();
            $('#redeemActionButton').show();
        }
    }

    // Function to redeem a reward
    function redeem(rewardId, pointsRequired) {
        Swal.fire({
            title: 'Confirm Redemption',
            text: `Are you sure you want to redeem this reward for ${pointsRequired} points?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Redeem',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/redeem-reward',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        user_id: userId,
                        reward_id: rewardId,
                        points_required: pointsRequired
                    },
                    success: function (response) {
                        if (response.success) {
                            Swal.fire('Success', 'Reward redeemed successfully!', 'success').then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error', response.message || 'Failed to redeem reward.', 'error');
                        }
                    },
                    error: function (error) {
                        console.error('Error redeeming reward:', error);
                        Swal.fire('Error', 'An error occurred. Please try again.', 'error');
                    }
                });
            }
        });
    }
</script>
@endsection
