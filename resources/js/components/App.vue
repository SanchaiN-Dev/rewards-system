<template>
    <div>
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-sm">
            <div class="container">
                <!-- Logo -->
                <router-link to="/" class="navbar-brand fw-bold">Rewards App</router-link>

                <!-- Mobile Menu Button -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Navbar Items -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <router-link to="/" class="nav-link">Home</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/rewards" class="nav-link">Rewards</router-link>
                        </li>
                    </ul>

                    <!-- Right Side (Authentication Controls) -->
                    <div class="d-flex align-items-center">

                        <div v-if="isAuthenticated" class="dropdown">
                            <button class="btn btn-outline-light dropdown-toggle" type="button"
                                data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle"></i> Account
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <router-link to="/profile" class="dropdown-item">
                                        Profile
                                    </router-link>
                                </li>
                                <li>
                                    <button @click="logout" class="dropdown-item text-danger">
                                        Logout
                                    </button>
                                </li>
                            </ul>
                        </div>

                        <router-link v-if="!isAuthenticated" to="/login" class="btn btn-outline-primary me-2">
                            Login
                        </router-link>
                        <router-link v-if="!isAuthenticated" to="/register" class="btn btn-primary">
                            Register
                        </router-link>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="content-wrapper">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>

import { mapGetters } from 'vuex';

export default {

    mounted() {
        this.$store.dispatch('checkUserAuthenticationStatus');
        //console.log(this.authToken);
    },

    computed: {

        // Mapping the 'isAuthenticatedCheck' getter from the Vuex store to a computed property
        // ...mapGetters({
        //         isAuthenticated: 'isAuthenticatedCheck' // 1 Method to check user logged in status using getters
        //     }),

        isAuthenticated() {
            return this.$store.state.isAuthenticated //2 Method check user logged in status using state
            //return this.$store.getters.isAuthenticatedCheck // 3 Methodcheck user logged in status using getters
        },

        authToken() {
            return this.$store.state.token
        },
    },

    methods: {
        logout() {
            axios.post('api/logout')
                .then(response => {
                    //console.log(response.data)

                    //dispatch logout from Store/index.js
                    this.$store.dispatch('logout');
                    this.$router.push({ name: 'login' });
                })
                .catch(error => {
                    console.error('Error logging out:', error);
                    alert('Failed to log out. Please try again.');
                })
        }
    },
}
</script>

<style scoped>
/* Content wrapper for better spacing */
.content-wrapper {
  min-height: 90vh;
  padding-top: 20px;
  background-color: #f8f9fa;
}

/* Navbar Customizations */
.navbar {
  padding: 15px;
}

/* Add subtle hover effect for links */
.navbar-nav .nav-link:hover {
  color: #f8d210 !important;
  transition: 0.3s;
}

/* Dropdown Menu Styling */
.dropdown-menu {
  border-radius: 10px;
  overflow: hidden;
}

.dropdown-item:hover {
  background-color: #f8f9fa;
  color: #007bff;
}
</style>
