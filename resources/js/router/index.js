import { createRouter, createWebHistory } from "vue-router";

import About from '../components/About.vue';
import Home from '../components/Home.vue';
import Register from '../components/Auth/Register.vue';
import Login from '../components/Auth/Login.vue';
import Dashboard from '../components/Auth/Dashboard.vue';
import Rewards from '../components/Auth/Rewards.vue';
import Profile from '../components/Auth/Profile.vue';
import NotFound from '../components/Errors/404.vue';
import store from '../store/index';

const routes = [

    {
        path: '/',
        name: 'home',
        component: Home
    },

    {
        path: '/about',
        name: 'about',
        component: About
    },

    {
        path: '/register',
        name: 'register',
        component: Register
    },

    {
        path: '/login',
        name: 'login',
        component: Login
    },

    {
        path: '/dashboard',
        name: 'dashboard',
        component: Dashboard,
        meta: { requiresAuth: true }
    },

    {
        path: '/rewards',
        name: 'rewards',
        component: Rewards,
        meta: { requiresAuth: true }
    },

    {
        path: '/profile',
        name: 'profile',
        component: Profile,
        meta: { requiresAuth: true }
    },

    {
        path: '/logout',
        name: 'logout',
        meta: { requiresAuth: true }
    },

    {
        path: '/:any',
        name: 'notfound',
        component: NotFound
    },

];

const router = createRouter({
    history: createWebHistory(),
    routes,
    linkActiveClass: 'active'
});

router.beforeEach((to, from, next) => {

    const isAuthenticated = store.getters.isAuthenticatedCheck;
    if (to.meta.requiresAuth && !isAuthenticated) {
        next('/login');
    } else if ((to.name === 'login' || to.name === 'register') && isAuthenticated ) {
        next('/home');
    } else {
        next();
    }
});

export default router;
