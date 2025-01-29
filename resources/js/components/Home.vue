<template>
    <div class="main-content position-relative bg-light py-4">
        <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header bg-primary text-white text-center py-3">
                <h5 class="mb-0">User Details</h5>
                </div>
                <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="profile-icon bg-secondary text-white d-flex align-items-center justify-content-center">
                    <i class="fas fa-user fa-2x"></i>
                    </div>
                    <h5 class="card-title ms-3">Hello, {{ user.name }}</h5>
                </div>

                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                    <i class="fas fa-envelope text-primary me-2"></i>
                    <strong>Email:</strong> {{ user.email }}
                    </li>
                    <li class="list-group-item">
                    <i class="fas fa-phone text-success me-2"></i>
                    <strong>Phone:</strong> {{ user.phone ?? 'Not Provided' }}
                    </li>
                    <li class="list-group-item">
                    <i class="fas fa-map-marker-alt text-danger me-2"></i>
                    <strong>Location:</strong> {{ user.location ?? 'Not Provided' }}
                    </li>
                    <li class="list-group-item">
                    <i class="fas fa-info-circle text-warning me-2"></i>
                    <strong>About Me:</strong> {{ user.about_me ?? 'Not Provided' }}
                    </li>
                    <li class="list-group-item">
                    <i class="fas fa-star text-warning me-2"></i>
                    <strong>Reward Points:</strong> {{ user.reward_point ?? '0' }}
                    </li>
                </ul>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      user: {}, // Default empty object instead of null
    };
  },
  async created() {
    await this.fetchUser();
  },
  methods: {
    async fetchUser() {
      try {
        const response = await axios.get("/api/user");
        this.user = response.data || {}; // Ensure it's an object
      } catch (error) {
        console.error("Error fetching user:", error);
        this.user = {}; // Set default empty object if error occurs
      }
    },
  },
};
</script>

  <style scoped>
  /* Profile Icon */
  .profile-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
  }

  /* Card Spacing */
  .card {
    max-width: 600px;
    margin: auto;
  }
  </style>
