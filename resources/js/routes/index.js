import { createRouter, createWebHistory } from 'vue-router'

import MainIndex from '../components/Main.vue'
import LoginIndex from '../components/Login.vue'


const routes = [
    {
        path: '/main',
        name: 'main.index',
        component: MainIndex
    },
    {
        path: '/',
        name: 'login.index',
        component: LoginIndex
    }

];

export default createRouter({
    history: createWebHistory(),
    routes
})