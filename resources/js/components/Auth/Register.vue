<template>
    <div class="container">
        <div class="row">
            <div class="col-6 mt-5 offset-3">
                <div class="card">
                    <div class="card-header">
                        Register Page
                    </div>
                    <div class="card-body">

                         <!-- Display success message if it exists -->
                         <div v-if="successMsg" class="alert alert-success">
                            {{ successMsg }}
                        </div>

                        <!-- Display errors if there are any -->
                        <ul v-if="errors.length">
                            <li v-for="error in errors" :key="error" class="text-danger">{{ error }}</li>
                        </ul>
                        <form @submit.prevent="register">
                            <div class="mb-3">
                                <label for="Name" class="form-label">Name</label>
                                <input type="text" v-model="name" class="form-control" id="Name" placeholder="Enter Your Name">
                            </div>
                            <div class="mb-3">
                                <label for="Email" class="form-label">Email Address</label>
                                <input type="email" v-model="email" class="form-control" id="Email" aria-describedby="emailHelp" placeholder="Enter Your Email" autocomplete="off">
                                <div id="emailHelp" class="form-text">We'll not share your email withanyone</div>
                            </div>
                            <div class="mb-3">
                                <label for="Password" class="form-label">Password</label>
                                <input type="password" v-model="password" class="form-control" id="Password" placeholder="Enter Your Password" autocomplete="off">
                            </div>
                            <div class="mb-3">
                                <label for="ConfirmPassword" class="form-label">Confirm Password</label>
                                <input type="password" v-model="password_confirmation" class="form-control" id="password_confirmation" placeholder="Enter Your Confirm Password">
                            </div>
                            <button type="submit" class="btn btn-primary">Register</button>
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
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
                errors: [],
                successMsg: ''
            }
        },
        methods: {
            async register() {
                try {
                    const response = await axios.post('api/register', {
                        name: this.name,
                        email: this.email,
                        password: this.password,
                        password_confirmation: this.password_confirmation,
                    });
                    console.log(response.data);
                    this.successMsg = response.data.message;
                    this.errors = [];  // Clear any previous errors
                } catch (error) {
                    this.successMsg = '';
                    if (error.response && error.response.data.errors) {
                        this.errors = Object.values(error.response.data.errors).flat();
                    } else {
                        this.errors = ["An unexpected error occurred. Please try again."];
                    }
                }
            }
        },
    }
</script>
