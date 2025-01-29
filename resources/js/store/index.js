import axios from 'axios';
import { createStore } from 'vuex';

export default createStore({
    state: {
        token: localStorage.getItem('token') || '', // Get the token from local storage, default is empty string
        isAuthenticated: !!localStorage.getItem('token'), // Check if token exists, if so set authentication status to true
    },

    mutations: {

        //check Authentication State
        UpdateAuthenticationStatus (state, status) {
            state.isAuthenticated = status;
        },

        // Update authentication status
        UpdateAuthStatus(state, status) {
            state.isAuthenticated = status;
            console.log('Authentication status is:', status);
        },

        // Update the token and save it to localStorage
        UpdateToken(state, token) {
            state.token = token;
            localStorage.setItem('token', token); // Save the token to localStorage
        },

        // Clear authentication status and token (for logout)
        ClearAuthData(state) {
            state.token = '';
            state.isAuthenticated = false;
            localStorage.removeItem('token'); // Remove token from localStorage
            delete axios.defaults.headers.common['Authorization']
        },
    },

    actions: {
        // Set authentication status
        setAuthStatus({ commit }, status) {
            commit('UpdateAuthStatus', status);
        },

        // Set token and update authentication status
        setAuthToken({ commit }, token) {
            commit('UpdateToken', token);
            commit('UpdateAuthStatus', true); // Mark as authenticated
            console.log('Token updated and authentication status is set to true');
        },

        // Log out by clearing token and authentication status
        logout({ commit }) {
            commit('ClearAuthData');
            console.log('Logged out, token and authentication status cleared');
        },

        //check Authentication state
        checkUserAuthenticationStatus( {commit} ) {
            axios.get('api/authenticated')
                .then( response => {
                    commit('UpdateAuthenticationStatus', response.data.status)
                })
                .catch( error => {
                    console.log(error);
                })
        }
    },

    getters: {
        // Check if the user is authenticated
        isAuthenticatedCheck(state) {
            return state.isAuthenticated;
        },

        // Get the stored token
        getToken(state) {
            return state.token;
        },
    },
});
