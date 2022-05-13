import { createRouter, createWebHistory } from 'vue-router'

import LoginIndex from '../components/Login'
import TeamSelect from '../components/TeamSelect'
import Mission from '../components/Mission'
import HelpModal from '../components/HelpModal'
import Welcome from '../components/Welcome'
import PuzzleCompletion from '../components/PuzzleCompletion'
import Admin from '../components/Admin'
import Dashboard from '../components/Dashboard'
import Event from '../components/Event'
import Logistics from '../components/Logistics'
import ForestPool from '../components/ForestPool'

const routes = [
   
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
    ,
    {
        path: '/helpmodal',
        name:'helpmodal.index',
        component: HelpModal
    },
    ,{
        path: '/welcome',
        name:'welcome.index',
        component: Welcome,
        props:{
            buttonText:"Enter the Game",
            buttonVisible: true,
            puzzleNumber: 6,
            newLink: true,
            elementImage: ['/images/Welcome_1.png','/images/Welcome_2.png','/images/Welcome_3.png','/images/Welcome_4.png']
        }
    },
    {
        path:'/yokohama_completed',
        name:'yokohama_completed.index',
        component:PuzzleCompletion,
        props:{
            buttonText:"Enter the Game",
            buttonVisible: true,
            puzzleNumber: 4,
            newLink: true,
            elementImage: ['/images/yokohama_congrats.png'],
            elementVideo:['/images/karuizawa_intro.mp4'],
            beginURL: 'karuizawa.index'
        }
    },
    {
        path:'/karuizawa_completed',
        name:'karuizawa_completed.index',
        component:PuzzleCompletion,
        props:{
            buttonText:"Enter the Game",
            buttonVisible: true,
            puzzleNumber: 4,
            newLink: true,
            elementImage: ['/images/karuizawa_congrats.png'],
            elementVideo:['/images/sendai_intro.mp4'],
            beginURL: 'sendai.index'
        }
    },
    {
        path:'/sendai_completed',
        name:'sendai_completed.index',
        component:PuzzleCompletion,
        props:{
            buttonText:"Enter the Game",
            buttonVisible: true,
            puzzleNumber: 4,
            newLink: true,
            elementImage: ['/images/sendai_congrats.png'],
            elementVideo:['/images/asakusa_intro.mp4'],
            beginURL: 'asakusa.index'
        }
    },
    {
        path:'/asakusa_completed',
        name:'asakusa_completed.index',
        component:PuzzleCompletion,
        props:{
            buttonText:"Enter the Game",
            buttonVisible: true,
            puzzleNumber: 4,
            newLink: true,
            elementImage: ['/images/asakusa_congrats.png'],
            elementVideo:['/images/congrats_video.mp4'],
            beginURL: ''
        }
    },
    {
        path:'/dashboard',
        name:'dashboard.index',
        component:Dashboard
    },
    {
        path:'/admin',
        name:'admin.index',
        component:Admin
    },
    {
        path:'/events',
        name:'events.index',
        component:Event
    },
    {
        path:'/logistics',
        name:'logistics.index',
        component: Logistics
    },
    {
        path: '/start_mission',
        name:'mission.index',
        component: Mission
    },
    {
        path: '/forestpool',
        name:'forestpool.index',
        component: ForestPool
    }

       
];

export default createRouter({
    history: createWebHistory(),
    routes
})