import { createApp } from 'vue';
import Vue from 'vue';
import App from './components/App.vue'
import router from './routes'
import LoginIndex from './components/Login.vue'
import VueEasyLightbox from 'vue-easy-lightbox'
import Vue3VideoPlayer from '@cloudgeek/vue3-video-player'
import '@cloudgeek/vue3-video-player/dist/vue3-video-player.css'
import fabric from 'fabric'
import BootstrapVue3 from 'bootstrap-vue-3'

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue-3/dist/bootstrap-vue-3.css'

import VueTour from 'v3-tour'

import 'animate.css';
const clickOutside = {
    beforeMount: (el, binding) => {
      el.clickOutsideEvent = event => {
        // here I check that click was outside the el and his children
        if (!(el == event.target || el.contains(event.target))) {
          // and if it did, call method provided in attribute value
          binding.value();
        }
      };
      document.addEventListener("click", el.clickOutsideEvent);
    },
    unmounted: el => {
      document.removeEventListener("click", el.clickOutsideEvent);
    },
  };

import 'sweetalert2/dist/sweetalert2.min.css';
import './components/css/overrides/vuetour.css';
import VueSweetalert2 from 'vue-sweetalert2';

require('v3-tour/dist/vue-tour.css')


createApp({
    components: {
        LoginIndex
    }
}).use(BootstrapVue3).use(router).use(VueSweetalert2).use(fabric).use(Vue3VideoPlayer, {
    lang: 'jp'
  }).use(VueEasyLightbox).use(VueTour).directive("click-outside", clickOutside).mount('#app')