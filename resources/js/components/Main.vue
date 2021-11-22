<template>

    <div class="main">
        <Header class="header2" :timePaused="timeisPaused"/>
        <div class="main_body">
            <Miro class="miro_holder" :miroURL="miroURLData" :isShowned="isShowned" :imgCover="imgCover"/>
            <ElementHolder @pause-time="pauseTime" :elementImage="elementImage" class="main_element_holder" :answer="answer" :puzzleNumber="puzzleNumber" />
        </div>
        <a href="#" class="float">
            <img src="../assets/chloe_version.png" style="width: 120px; height: 120px;"/>
        </a>

    </div>
</template>

<script>
    import axios from 'axios';
    import Header from './Header.vue';
    import ElementHolder from './ElementHolder.vue'
    import Miro from './Miro.vue';

    let computerMIRO = "https://miro.com/app/live-embed/o9J_ltgInS4=/?embedAutoplay=true&moveToViewport=-2638,-351,2934,3605"
    let  floorMIRO = "https://miro.com/app/live-embed/o9J_ltgIkjg=/?embedAutoplay=true&moveToViewport=2560,-648,1472,1160";

    let selectedMIRO = "";
    let gameProgress;
    let codeResponse, teamSetup;
    var getStatusInterval;

    export default{
        name: 'Main',
        beforeCreate(){
            codeResponse = JSON.parse(localStorage.getItem('codeResponse'));
            teamSetup = JSON.parse(localStorage.getItem('teamSetup'));
            gameProgress = JSON.parse(localStorage.getItem('gameProgress'));

            if(codeResponse && teamSetup && teamSetup.game_event_id == codeResponse.id){
                
                if(gameProgress){
                    gameProgress.puzzleProgress = this.puzzleNumber;
                    localStorage.setItem('gameProgress', JSON.stringify(gameProgress));
                }
                else{
                    gameProgress = {
                        game_event_id: codeResponse.id,
                        puzzleProgress: this.puzzleNumber
                    }
                    localStorage.setItem('gameProgress', JSON.stringify(gameProgress));
                }

                if(this.puzzleNumber == 1){
                    selectedMIRO = floorMIRO;
                }
                else{
                    selectedMIRO = computerMIRO;
                }
            }

             getStatusInterval = setInterval(() => this.getStatus(), 2000);
        },
        data(){
            return{
                timeisPaused: false,
                miroURLData: selectedMIRO,
                imgCover: '/images/computer.png',
                isShowned: this.miroCovered
            }
        },
        components: {
            Header,
            ElementHolder,
            Miro
        },
        methods:{
            pauseTime(){
                this.timeisPaused = true;
            },
            getStatus(){
                    axios.post('api/game/get_status',{
                        game_event_id: codeResponse.id,
                        playerTeam: teamSetup.playerTeam,
                        puzzleNumber: this.puzzleNumber
                        }).then(response => {
                            console.log(response['data'][0].answered_current);
                               if(response['data'][0].answered_current == 1){
                                this.timeisPaused = true;
                                clearInterval(getStatusInterval);
                                this.$swal({
                                        title:'Great! Your team got the correct answer.',
                                        icon:'success'    
                                                });
                                }
                        }).catch(error => {
                           console.log(error);
                        });

                 
            }
        },
        props:{
            miroCovered: Boolean,
            elementImage: String,
            answer: String,
            puzzleNumber: Number
        }
    }
</script>

<style>

    .main{
        display: flex;
        position: relative;
        flex-direction: column;
        height: 100%;
        color: white;
    }

    .header2{
        display: flex;
        justify-content: center;
        width: 100vw;
    }




    .main_body{
        display: flex;
        position: relative;
        flex-direction: row;
        justify-content: center;
        flex-wrap: wrap;
        height: 85%;
        min-height: 800px;
        width: 100%;
    }

    .miro_holder{
        position: relative;
        flex-grow: 1;
        /* background-color: white; */
    }


    .main_element_holder{
        position: relative;
        flex-grow: 1;
    }


    
.float{
	position:fixed;
	width:120px;
	height:120px;
	border-radius:50px;
	text-align:center;
    z-index: 99999999;
	bottom:15px;
	right:15px;
}

.my-float{
	margin-top:22px;
}

@media only screen and (max-width: 1500px) {

    .miro_holder{
        height: 95%;
    }

}


</style>