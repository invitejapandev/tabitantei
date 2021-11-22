import { createRouter, createWebHistory } from 'vue-router'

import MainIndex from '../components/Main'
import LoginIndex from '../components/Login'
import TeamSelect from '../components/TeamSelect'
import TextHolder from '../components/TextHolder'
import Mission from '../components/Mission'


const routes = [
    {
        path: '/main',
        name: 'main.index',
        component: MainIndex
    },
    {
        path: '/floor',
        name: 'main.index1',
        component: MainIndex,
        props: {
            miroCovered: false,
            elementImage: '/images/bulletin_board.png',
            answer: 'archive',
            puzzleNumber: 1
        }
    },
    {
        path: '/computer',
        name: 'main.computer',
        component: MainIndex,
        props: {
            miroCovered: true,
            elementImage: '/images/desk_new.png',
            answer: 'premier',
            puzzleNumber: 2
        }
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
    ,
    {
        path: '/introduction',
        name:'introduction.index',
        component: TextHolder
    }
    ,
    {
        path: '/mission',
        name:'mission.index',
        component: Mission,
        props:{
            headerText: `Hello trainees. You will have to put your spy skills to work 
            faster than we expected. We have an emergency. 
            We have lost all contact with one of our agents, 
            alias Mayumi, who was working on retrieving a famous 
            painting for one of our clients.We have no idea where 
            she went or why we lost contact with her, but her mission 
            is vitally important. All our other agents are in the field, 
            so it is up to you to meet this challenge. 
            It appears that she was working somewhere in the 
            Invite Japan Agency building before she left. Perhaps 
            that is a good place to start…`,
            buttonText:"Enter the Game",
            buttonVisible: true
        }
    },
    {
        path: '/demoend',
        name:'demo.index',
        component: Mission,
        props:{
            headerText: `End of Game Preview`,
            buttonVisible: false
        }
    },
    {
        path: '/archive',
        name:'archive.index',
        component: Mission,
        props:{
            headerText: `Good work agents! You've found the computer Mayumi was 
            working on. Access the computer and maybe you will find 
            her whereabouts.`,
            buttonText:"Check the Computer",
            buttonVisible: true,
            newLink: true,
            linkData: 'main.index2'
        }
    }
];

export default createRouter({
    history: createWebHistory(),
    routes
})