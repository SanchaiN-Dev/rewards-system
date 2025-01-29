<template>
    <div class="container">
        <div class="row">
            <div class="col-6 mt-5 offset-3">
                <div class="card">
                    <div class="card-header">
                        Login Page
                    </div>
                    <div class="card-body">

                        <!-- Display errors if there are any -->
                        <ul v-if="errors.length">
                            <li v-for="error in errors" :key="error" class="text-danger">{{ error }}</li>
                        </ul>

                        <form @submit.prevent="login">
                            <div class="mb-3">
                                <label for="Email" class="form-label">Email Address</label>
                                <input type="email" v-model="email" class="form-control" id="Email" placeholder="Enter Your Email" required>
                            </div>
                            <div class="mb-3">
                                <label for="Password" class="form-label">Password</label>
                                <input type="password" v-model="password" class="form-control" id="Password" placeholder="Enter Your Password" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { mapActions } from 'vuex';

export default {
    data() {
        return {
            email: 'admin@gmail.com',
            password: '123456',
            errors: [],
        };
    },
    methods: {
        // Map Vuex actions to this component's methods
        ...mapActions(['setAuthToken', 'setAuthStatus']),

        async login() {
            try {
                // Step 1: Ensure CSRF cookie is set
                await axios.get('/sanctum/csrf-cookie');

                // Step 2: Post login data (email and password) with CSRF token included
                const response = await axios.post('api/login', {
                    email: this.email,
                    password: this.password,
                });

                // Step 3: If login is successful, clear previous errors
                this.errors = [];

                // Step 4: Dispatch Vuex actions to store the token and set authentication status
                const token = response.data.token;
                this.setAuthToken(token);  // Save token to Vuex
                this.setAuthStatus(true);   // Set user as authenticated
                console.log(response.data);
                localStorage.setItem("user_id", response.data.userId);
                // Step 5: Redirect to dashboard or any other protected route
                this.$router.push({ name: 'home' });

            } catch (error) {
                // Handle errors: Display error messages
                if (error.response && error.response.data.errors) {
                    this.errors = Object.values(error.response.data.errors).flat();
                } else {
                    this.errors = ["An unexpected error occurred. Please try again."];
                }
            }
        },
    },
};
</script>

<style scoped>
.text-danger {
    color: red;
}
</style>
