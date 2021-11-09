import { createApp } from 'vue';
import Vue from 'vue';
import App from './components/App.vue'
import router from './routes'
import MainIndex from './components/Main.vue'
import LoginIndex from './components/Login.vue'
import VueEasyLightbox from 'vue-easy-lightbox'

import 'sweetalert2/dist/sweetalert2.min.css';
import VueSweetalert2 from 'vue-sweetalert2';


createApp({
    components: {
        MainIndex,
        LoginIndex
    }
}).use(router).use(VueSweetalert2).use(VueEasyLightbox).mount('#app')