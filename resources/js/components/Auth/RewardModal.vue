<template>
    <div v-if="show" class="modal fade show d-block" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">{{ reward?.title }}</h5>
            <button type="button" class="btn-close" @click="$emit('close')"></button>
          </div>
          <div class="modal-body text-center">
            <img :src="reward?.image" class="img-fluid rounded mb-3" />
            <p>{{ reward?.description }}</p>
            <p><strong>Points:</strong> {{ reward?.points_required }}</p>
            <p><strong>Expires:</strong> {{ reward?.valid_until }}</p>
          </div>
          <div class="modal-footer">
            <button
              v-if="!reward?.isExpired"
              class="btn btn-primary"
              @click="$emit('redeem', reward.id, reward.points_required)"
            >
              Redeem
            </button>
            <button class="btn btn-secondary" @click="$emit('close')">
              Close
            </button>
          </div>
        </div>
      </div>
    </div>
  </template>

  <script>
  export default {
    props: {
      reward: Object,
      show: Boolean,
    },
  };
  </script>

  <style scoped>
  /* Modal Styling */
  .modal {
    background: rgba(0, 0, 0, 0.5);
  }
  </style>
