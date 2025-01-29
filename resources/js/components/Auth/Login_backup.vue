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
                                <input type="email" v-model="email" class="form-control" id="Email" aria-describedby="emailHelp" placeholder="Enter Your Email">
                            </div>
                            <div class="mb-3">
                                <label for="Password" class="form-label">Password</label>
                                <input type="password" v-model="password" class="form-control" id="Password" placeholder="Enter Your Password">
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
    export default {
        data() {
            return {
                email: '',
                password: '',
                errors: [],
            }
        },

        methods: {
            async login() {
                // Ensure CSRF cookie is set
                axios.get('/sanctum/csrf-cookie').then(response => {

                    // Post login data with CSRF token included in headers
                    axios.post('api/login', {
                        email: this.email,
                        password: this.password,
                    }, {
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    }).then(response => {
                        this.errors = [];  // Clear any previous errors

                        // Dispatch authentication status and token
                        const status = true;
                        const token = response.data.token;

                        this.$store.dispatch('setAuthToken', token);
                        this.$store.dispatch('setAuthStatus', status);

                        // Redirect to dashboard
                        this.$router.push({ name: 'home' });

                    }).catch(error => {
                        this.successMsg = ''; // Clear any previous success messages
                        if (error.response && error.response.data.errors) {
                            this.errors = Object.values(error.response.data.errors).flat();
                        } else {
                            this.errors = ["An unexpected error occurred. Please try again."];
                        }
                    });
                });
            }
        },
    }
</script>
