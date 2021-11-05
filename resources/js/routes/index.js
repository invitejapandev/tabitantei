import { createRouter, createWebHistory } from 'vue-router'

import MainIndex from '../components/Main'
import LoginIndex from '../components/Login'
import TeamSelect from '../components/TeamSelect'


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
    },
    {
        path: '/team',
        name:'team.index',
        component: TeamSelect
    }
];

export default createRouter({
    history: createWebHistory(),
    routes
})