import { createRouter, createWebHistory } from 'vue-router'

import MainIndex from '../components/Main'
import LoginIndex from '../components/Login'
import TeamSelect from '../components/TeamSelect'
import TextHolder from '../components/TextHolder'
import Mission from '../components/Mission'
import Bubble from '../components/Bubble'
import Finale from '../components/Finale'
import Video from '../components/Video'
import VideoFiller from '../components/VideoFiller'
import MapText from '../components/MapText'
import MapTextPartTwo from '../components/MapTextPartTwo'
import MainMap from '../components/Map'
import ParisText from '../components/ParisText'
import ParisSelect from '../components/PuzzleSelect'
import PianoIndex from '../components/Piano'
import SemaphoreIndex from '../components/Sem'
import semtest from '../components/semtest'
import SecurityIndex from '../components/Security'
import GraffitiIndex from '../components/Graffiti'
import FacilitatorIndex from '../components/Facilitator'
import CanvassIndex from '../components/Canvass'
import ModalIndex from '../components/Modal'
import ModalViewIndex from '../components/ModalView'
import PianoNewIndex from '../components/PianoNew'
import MainFrame from '../components/MainFrame'
import HelpModal from '../components/HelpModal'
import GameOver from '../components/GameOver'
import Welcome from '../components/Welcome'
import PuzzleCompletion from '../components/PuzzleCompletion'
import PuzzleIndex from '../components/Puzzle'
import Admin from '../components/Admin'
import Dashboard from '../components/Dashboard'
import Event from '../components/Event'

const routes = [
    {
        path: '/main',
        name: 'main.index',
        component: MainIndex
    },
    // {
    //     path: '/floor',
    //     name: 'main.index1',
    //     component: MainIndex,
    //     props: {
    //         miroCovered: false,
    //         elementImage: '/images/bulletin_board.png',
    //         answer: 'archive',
    //         puzzleNumber: 1
    //     }
    // },
    {
        path: '/floor',
        name: 'main.index1',
        component: MainFrame,
        props: {
            miroCovered: false,
            elementImage: '/images/billboard_772_jp.png',
            answer: 'archive',
            puzzleNumber: 1
        }
    },
    {
        path: '/computer',
        name: 'main.computer',
        component: MainFrame,
        props: {
            miroCovered: true,
            elementImage: '/images/desk_772.png',
            answer: 'premier',
            puzzleNumber: 2
        }
    },
    {
        path: '/piano',
        name: 'main.piano',
        component: PianoIndex,
        props: {
            miroCovered: true,
            elementImage: '/images/pianos.png',
            answer: 'piano2',
            puzzleNumber: 3
        }
    },
    {
        path: '/map1',
        name: 'main.map1',
        component: MainMap,
        props: {
            miroCovered: false,
            elementImage: '/images/desk_new.png',
            answer: 'F2',
            puzzleNumber: 4
        }
    },
    {
        path: '/map2',
        name: 'main.map2',
        component: MainMap,
        props: {
            miroCovered: false,
            elementImage: '/images/desk_new.png',
            answer: 'red',
            puzzleNumber: 5
        }
    },
    {
        path: '/semaphore',
        name: 'main.semaphore',
        component: SemaphoreIndex,
        props: {
            miroCovered: true,
            elementImage: '/images/tower_plan.png',
            answer: 'cheater',
            puzzleNumber: 6
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
    },
    {
        path: '/semtest',
        name:'sem.index',
        component: semtest
    }
    ,
    {
        path: '/helpmodal',
        name:'helpmodal.index',
        component: HelpModal
    },
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
            mapPart: 3,
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
            buttonText:"Enter the Game",
            buttonVisible: true
        }
    },
    {
        path: '/norman',
        name:'bubble.index',
        component: Bubble,
        props:{
            buttonText:"Enter the Game",
            buttonVisible: true,
            elementImage: ['/images/msg_norm_1.gif','/images/msg_norm_2.png','/images/msg_norm_3.png','/images/msg_norm_4.png']
        }
    },
    {
        path: '/mayu_palais',
        name:'mayu_palais.index',
        component: Bubble,
        props:{
            buttonText:"Enter the Game",
            buttonVisible: true,
            puzzleNumber: 4,
            elementImage: ['/images/msg_mayu_1.gif','/images/msg_mayu_2.png','/images/msg_mayu_3.png','/images/msg_mayu_4.png','/images/msg_mayu_5.png','/images/msg_palais_1.gif','/images/msg_palais_2.png','/images/msg_palais_3.png','/images/msg_palais_4.png']
        }
    },
    {
        path: '/tour',
        name:'tour.index',
        component: Bubble,
        props:{
            buttonText:"Enter the Game",
            buttonVisible: true,
            puzzleNumber: 5,
            elementImage: ['/images/msg_tour_1.png','/images/msg_tour_2.png','/images/msg_tour_3.png']
        }
    },
    {
        path: '/travel_paris',
        name:'travel_paris.index',
        component: Bubble,
        props:{
            buttonText:"Enter the Game",
            buttonVisible: true,
            puzzleNumber: 98,
            elementImage: ['/images/msg_mission_1.png','/images/msg_mission_2.png']
        }
    },
    {
        path: '/sato',
        name:'sato.index',
        component: Bubble,
        props:{
            buttonText:"Enter the Game",
            buttonVisible: true,
            puzzleNumber: 99,
            elementImage: ['/images/msg_sato_1.gif','/images/msg_sato_2.png','/images/msg_sato_3.png','/images/msg_sato_4.png','/images/msg_sato_5.png','/images/msg_sato_6.png','/images/msg_sato_7.png','/images/msg_sato_8.png','/images/msg_sato_9.png']
        }
    },
    {
        path: '/tower_intro',
        name:'tower_intro.index',
        component: Bubble,
        props:{
            buttonText:"Enter the Game",
            buttonVisible: true,
            puzzleNumber: 91,
            elementImage: ['/images/msg_tower_1.png','/images/msg_tower_2.png','/images/msg_tower_3.png','/images/msg_tower_4.png','/images/msg_tower_5.png']
        }
    },
    {
        path: '/cafe_intro',
        name:'cafe_intro.index',
        component: Bubble,
        props:{
            buttonText:"Enter the Game",
            buttonVisible: true,
            puzzleNumber: 92,
            elementImage: ['/images/msg_cafe_1.png','/images/msg_cafe_2.png']
        }
    },
    {
        path: '/mdv_intro',
        name:'mdv_intro.index',
        component: Bubble,
        props:{
            buttonText:"Enter the Game",
            buttonVisible: true,
            puzzleNumber: 93,
            elementImage: ['/images/msg_mdv_1.png','/images/msg_mdv_2.png','/images/msg_mdv_3.png','/images/msg_mdv_4.png']
        }
    },
    {
        path: '/graffiti_intro',
        name:'graffiti_intro.index',
        component: Bubble,
        props:{
            buttonText:"Enter the Game",
            buttonVisible: true,
            puzzleNumber: 94,
            elementImage: ['/images/msg_graffiti_1.png','/images/msg_graffiti_2.png']
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
        component: Bubble,
        props:{
            buttonText:"Enter the Game",
            buttonVisible: true,
            newLink: true,
            elementImage: ['/images/msg_norm_5.png']
        }
    }
    ,{
        path: '/intro_video',
        name:'intro_video.index',
        component: VideoFiller,
        props:{
            buttonText:"Enter the Game",
            buttonVisible: true,
            puzzleNumber: 1,
            newLink: true,
            elementImage: ['/images/intro.mp4']
        }
    }
    ,{
        path: '/computer_on',
        name:'computer_on.index',
        component: VideoFiller,
        props:{
            buttonText:"Enter the Game",
            buttonVisible: true,
            puzzleNumber: 2,
            newLink: true,
            elementImage: ['/images/computer_on.mp4']
        }
    },
    {
        path: '/travel_video',
        name:'travel_video.index',
        component: VideoFiller,
        props:{
            buttonText:"Enter the Game",
            buttonVisible: true,
            puzzleNumber: 3,
            newLink: true,
            elementImage: ['/images/travel_to_paris.mp4']
        }
    },
    ,{
        path: '/semaphore_completed',
        name:'semaphore_completed.index',
        component: Video,
        props:{
            buttonText:"Enter the Game",
            buttonVisible: true,
            puzzleNumber: 6,
            newLink: true,
            elementImage: ['/images/msg_norm_5.png']
        }
    },
    ,{
        path: '/cafe_completed',
        name:'cafe_completed.index',
        component: Video,
        props:{
            buttonText:"Enter the Game",
            buttonVisible: true,
            puzzleNumber: 6,
            newLink: true,
            elementImage: ['/images/msg_norm_5.png']
        }
    },
    ,{
        path: '/security_completed',
        name:'security_completed.index',
        component: Video,
        props:{
            buttonText:"Enter the Game",
            buttonVisible: true,
            puzzleNumber: 6,
            newLink: true,
            elementImage: ['/images/msg_norm_5.png']
        }
    },
    ,{
        path: '/graffiti_completed',
        name:'graffiti_completed.index',
        component: Video,
        props:{
            buttonText:"Enter the Game",
            buttonVisible: true,
            puzzleNumber: 6,
            newLink: true,
            elementImage: ['/images/msg_norm_5.png']
        }
    },
    {
        path: '/parispuzzle',
        name:'paris.index',
        component: ParisSelect
    },
    {
        path: '/security',
        name:'security.index',
        component: SecurityIndex,
        props: {
            puzzleNumber: 7
        }
    },
    {
        path: '/cafe',
        name: 'cafe.index',
        component: MainFrame,
        props: {
            miroCovered: false,
            elementImage: '/images/cafe_playerside_772.png',
            answer: 'suspicious',
            puzzleNumber: 8
        }
    },
    {
        path: '/graffiti',
        name:'graffiti.index',
        component: GraffitiIndex,
        props: {
            miroCovered: false,
            elementImage: '/images/graffiti_cover_772.png',
            answer: 'pearls',
            puzzleNumber: 9
        }
    },
    {
        path: '/facilitator',
        name:'facilitator.index',
        component: FacilitatorIndex
    },
    {
        path: '/finale',
        name:'finale.index',
        component: Finale,
        props:{
            buttonText:"Enter the Game",
            buttonVisible: true,
            elementImage: ['/images/msg_finale_2.png','/images/msg_finale_3.png','/images/msg_finale_4.png','/images/finale_image.png'],
            puzzleNumber: 100
        }
    },
    {
        path: '/gameover',
        name:'gameover.index',
        component: GameOver,
        props:{
            buttonText:"Enter the Game",
            buttonVisible: true,
            elementImage: ['/images/finale_image.png'],
            puzzleNumber: 100
        }
    },
    {
        path: '/canvass',
        name:'canvass.index',
        component: CanvassIndex
    },
    {
        path: '/modal',
        name:'modal.index',
        component: ModalIndex
    },
    {
        path: '/modalview',
        name:'modalview.index',
        component: ModalViewIndex
    },
    {
        path: '/pianonew',
        name:'pianonew.index',
        component: PianoNewIndex
    },
    {
        path: '/style_secrets',
        name:'style_secrets.index',
        component: PuzzleIndex
    },
    {
        path: '/yokohama',
        name:'yokohama.index',
        component: PuzzleIndex,
        props:{
            maxPuzzle: 3,
            helpImage: '/images/yokohama_help.png'
        }
    }
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
        path: '/karuizawa',
        name:'karuizawa.index',
        component: PuzzleIndex,
        props:{
            maxPuzzle: 6,
            helpImage: '/images/karuizawa_help.png'
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
        path: '/sendai',
        name:'sendai.index',
        component: PuzzleIndex,
        props:{
            maxPuzzle: 9,
            helpImage: '/images/sendai_help.png'
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
        path: '/asakusa',
        name:'asakusa.index',
        component: PuzzleIndex,
        props:{
            maxPuzzle: 12,
            helpImage: '/images/asakusa_help.png'
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
    }
       
];

export default createRouter({
    history: createWebHistory(),
    routes
})