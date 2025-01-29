import './bootstrap';

import { createApp } from 'vue';
import App from './components/App.vue';
import router from './router/index';
import store from './store/index';
import axios from 'axios';

//Setting Token
axios.interceptors.request.use(config => {
    const token = store.state.token;
    if (token) {
        config.headers['Authorization'] = `Bearer ${token}`;
    }
    return config;
}, error => {
    return Promise.reject(error);
}
);

const app = createApp(App)
app.use(router);
app.use(store)
app.mount('#app')







