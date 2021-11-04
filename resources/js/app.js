import { createApp } from 'vue';
import Vue from 'vue';
import App from './components/App.vue'
import router from './routes'
import MainIndex from './components/Main.vue'
import LoginIndex from './components/Login.vue'


createApp({
    components: {
        MainIndex,
        LoginIndex
    }
}).use(router).mount('#app')