<template>
    <div class="main-content position-relative bg-light py-4">
      <div class="container">
        <!-- Profile Header -->
        <div class="card shadow-lg border-0 rounded-3">
          <div class="card-body d-flex align-items-center p-4">
            <div>
              <h4 class="mb-1 text-dark fw-bold">Sanchai Noumnoy</h4>
              <p class="text-muted">Web Developer</p>
            </div>
          </div>
        </div>

        <!-- Profile Information -->
        <div class="card mt-4 shadow-sm border-0 rounded-3">
          <div class="card-header bg-primary text-white fw-bold">
            Profile Information
          </div>
          <div class="card-body">
            <ul class="list-group list-group-flush">
              <li class="list-group-item">
                <strong class="text-dark">Full Name:</strong> Sanchai Noumnoy
              </li>
              <li class="list-group-item">
                <strong class="text-dark">Email:</strong> sanchai.n.contact@gmail.com
              </li>
              <li class="list-group-item">
                <strong class="text-dark">Location:</strong> Bangkok
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </template>

  <style scoped>
  /* Profile Image Styling */
  .profile-image-container {
    width: 80px;
    height: 80px;
  }

  .profile-image-container img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
  }

  /* Card Styling */
  .card {
    border-radius: 12px;
  }

  .card-header {
    font-size: 1.1rem;
  }
  </style>
