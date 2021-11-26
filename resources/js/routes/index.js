import { createRouter, createWebHistory } from 'vue-router'

import MainIndex from '../components/Main'
import LoginIndex from '../components/Login'
import TeamSelect from '../components/TeamSelect'
import TextHolder from '../components/TextHolder'
import Mission from '../components/Mission'
import MapText from '../components/MapText'
import MapTextPartTwo from '../components/MapTextPartTwo'
import MainMap from '../components/Map'
import ParisText from '../components/ParisText'
import ParisSelect from '../components/PuzzleSelect'


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
        path: '/map1',
        name: 'main.map1',
        component: MainMap,
        props: {
            miroCovered: false,
            elementImage: '/images/desk_new.png',
            answer: 'f2',
            puzzleNumber: 3
        }
    },
    {
        path: '/map2',
        name: 'main.map2',
        component: MainMap,
        props: {
            miroCovered: false,
            elementImage: '/images/desk_new.png',
            answer: 'green',
            puzzleNumber: 4
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
        path: '/MapText',
        name:'MapText.index',
        component: MapText
    },
    {
        path: '/MapText2',
        name:'MapTextPartTwo.index',
        component: MapTextPartTwo,
        props:{
            mapPart: 1,
            speaker:'Mayumi:',
            mapMessage:`In my training to be an agent, I learned that in order to travel the city of Paris undetected, I should always start at the Arc De Triomphe, and use the oldest paths to go from point A to point B.If you look in my scrapbook, you will find a very old map of Paris.
            I marked it with some possible locations of the Palais Garnier, but you may be able to accurately identify the right spot...`
        }
    }
    ,
    {
        path: '/MapText3',
        name:'MapTextPartThree.index',
        component: MapTextPartTwo,
        props:{
            mapPart: 2,
            speaker:'Mayumi:',
            mapMessage:`Great! I think that's the right place! Now in order to take the oldest path and avoid detection, I need you to tell me which path from the old map still exists today. 
            Which path should I choose?`
        }
    },
    {
        path: '/MapText4',
        name:'MapTextPartFour.index',
        component: MapTextPartTwo,
        props:{
            mapPart: 2,
            speaker:'Mayumi:',
            mapMessage:`Agents! I located the locksmith thanks to your help.
            From what I can tell though, there may be more to this case than I thought.
            I am need some backup here in Paris. Come here immeditaely and meet me at the 
            Locksmith's location. Hurry, we don't have much time left!`
        }
    },
    {
        path: '/ParisText',
        name:'ParisText.index',
        component: ParisText,
        props:{
            parisPart: 1,
            speaker:'Locksmith: ',
            mapMessage:`Who are you?! Oh, you're from the Invite Japan Agency, aren't you? So you found me, then.
            Shhh! Be quiet, they probably have the place bugged.
            I am the locksmith. But my beautiful masterpiece has been corrupted and used to hide stolen artwork...such a shame!
            I can tell you how to break, but it's up to you to actually do it.The lock uses keywords that are scattered across four locations in Paris. You'll have to go to each one and find the keyword. The order of the locations doesn't matter, just as long as you go to every location. Do you understand? That's the only way you will be able to retrieve the painting. 
            Here, I'll give you a guide to help you find them. 
            \n\n
            I'll text you when I can to help you out, but you have to leave now. There are agents all around from your agency collecting pieces of information that you need. You'll have to figure out a way to piece them together on your own. `
        }
    },
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
    },
    {
        path: '/parispuzzle',
        name:'paris.index',
        component: ParisSelect
    }
];

export default createRouter({
    history: createWebHistory(),
    routes
})