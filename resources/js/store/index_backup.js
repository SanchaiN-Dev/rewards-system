import { createStore } from 'vuex';

export default createStore({

    state: {
        token: localStorage.getItem('token') || '' ,
        isAuthenticated: false
    },

    mutations: {

        // UpdateAuthenticationStatus (state, status) {
        //     state.isAuthenticated = status;
        // },

        UpdateAuthStatus( state, status) {
            state.isAuthenticated = status;
            console.log('status is ' + status);
        },

        UpdateToken (state, token) {
            state.token = token
            localStorage.setItem('token', token)
        }

    },

    actions: {
        setAuthStatus( {commit}, status ) {
            commit('UpdateAuthStatus', status);
        },


        setAuthToken( {commit}, token ) {
            commit('UpdateToken', token);
            console.log('updating token here');
        }
    },

    getters: {

    },

});
