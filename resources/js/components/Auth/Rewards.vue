<template>
    <div class="container py-4">
      <div class="card shadow-lg border-0 rounded-3">
        <div class="card-header bg-primary text-white text-center py-3">
          <h5 class="mb-0">🎁 Rewards</h5>
        </div>

        <div class="card-body">
          <!-- Bootstrap Carousel -->
          <div id="rewardCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
              <div
                v-for="(rewardGroup, index) in chunkedRewards"
                :key="index"
                class="carousel-item"
                :class="{ active: index === 0 }"
              >
                <div class="row g-4">
                  <div v-for="reward in rewardGroup" :key="reward.id" class="col-md-4">
                    <div class="card reward-card shadow-sm" @click="openModal(reward)">
                      <div class="position-relative">
                        <img
                          :src="reward.image || defaultImage"
                          class="img-fluid rounded-top"
                          alt="Reward Image"
                        />
                      </div>
                      <div class="card-body text-center">
                        <h5 class="fw-bold">{{ reward.title }}</h5>
                        <p class="text-muted">{{ reward.description }}</p>
                        <p class="fw-bold text-dark">Points: {{ reward.points_required }}</p>
                        <p class="text-muted small">Expires: {{ reward.valid_until }}</p>

                        <button
                          class="btn"
                          :class="{
                            'btn-secondary': reward.isRedeemed,
                            'btn-outline-primary': !reward.isRedeemed,
                          }"
                          :disabled="reward.isExpired || reward.isRedeemed"
                        >
                          {{ reward.isRedeemed ? "Already Redeemed" : "Redeem" }}
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Reward Details Modal -->
      <RewardModal :reward="selectedReward" :show="showModal" @close="showModal = false" @redeem="redeemReward" />
    </div>
</template>

  <script>
  import axios from "axios";
  import Swal from "sweetalert2";
  import RewardModal from "./RewardModal.vue";

  export default {
    components: {
      RewardModal,
    },
    data() {
      return {
        rewards: [],
        selectedReward: null,
        showModal: false,
        userId: localStorage.getItem("user_id"),
        defaultImage: "https://via.placeholder.com/150", // Fallback Image
      };
    },
    computed: {
      // Split rewards into groups of 3 for the carousel
      chunkedRewards() {
        return this.rewards.reduce((result, item, index) => {
          const chunkIndex = Math.floor(index / 3);
          if (!result[chunkIndex]) {
            result[chunkIndex] = [];
          }
          result[chunkIndex].push(item);
          return result;
        }, []);
      },
    },
    methods: {
      async fetchRewards() {
        try {
          const response = await axios.get("/api/rewards");

          if (!response.data || !Array.isArray(response.data)) {
            console.error("Invalid API Response:", response);
            return;
          }

          console.log("Fetched Rewards:", response.data);

          this.rewards = response.data.map((reward) => {
            const currentDate = new Date().toISOString().split("T")[0];
            return {
              ...reward,
              isExpired: reward.valid_until < currentDate,
              image: reward.image || this.defaultImage,
            };
          });
        } catch (error) {
          console.error("Error fetching rewards:", error);
        }
      },
      openModal(reward) {
        this.selectedReward = reward;
        this.showModal = true;
      },
      async redeemReward(rewardId, pointsRequired) {
        Swal.fire({
          title: "Confirm Redemption",
          text: `Are you sure you want to redeem this reward for ${pointsRequired} points?`,
          icon: "warning",
          showCancelButton: true,
          confirmButtonText: "Yes, Redeem",
          cancelButtonText: "Cancel",
        }).then(async (result) => {
          if (result.isConfirmed) {
            try {
              if (!this.userId) {
                Swal.fire("Error", "User not found. Please login again.", "error");
                return;
              }

              const response = await axios.post("/api/redeem-reward", {
                user_id: this.userId,
                reward_id: rewardId,
                points_required: pointsRequired,
              });

              if (response.data.success) {
                Swal.fire("Success", "Reward redeemed successfully!", "success");
                this.fetchRewards();
              } else {
                Swal.fire("Error", response.data.message, "error");
              }
            } catch (error) {
              Swal.fire("Error", "An error occurred. Please try again.", "error");
            }
          }
        });
      },
    },
    mounted() {
      this.fetchRewards();
    },
  };
  </script>

  <style scoped>
  /* Card Styling */
  .reward-card {
    transition: all 0.3s ease-in-out;
    border-radius: 10px;
    cursor: pointer;
  }
  .reward-card:hover {
    transform: scale(1.05);
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
  }
  </style>
