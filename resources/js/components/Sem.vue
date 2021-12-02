<template>

    <div class="main"  >
        <Header  :puzzleNumber="puzzleNumber" class="header2" :timePaused="timeisPaused" />
        <div class="main_body">
            <SemBody @showSemTest="showSemTest" @pauseTime="pause-time" class="miro_holder" :miroURL="miroURLData" :isShowned="isShowned" :imgCover="imgCover"/>
            <SemElement @pauseTime="pause-time" :elementImage="elementImage" class="main_element_holder" :answer="answer" :puzzleNumber="puzzleNumber" />
            <semtest :imgName="semImage" @hideSemtest="hideSemtest" class=""  :shouldShow="shouldShow"/>
        </div>
        <a href="#" class="float">
            <img src="../assets/chloe_version.png" style="width: 120px; height: 120px;"/>
        </a>

    </div>
</template>

<script>
    import axios from 'axios';
    import Header from './Header.vue';
    import SemElement from './SemElement.vue';
    import SemBody from './SemBody.vue';
    import semtest from './semtest.vue';

    let computerMIRO = "https://miro.com/app/live-embed/o9J_ltgInS4=/?embedAutoplay=true&moveToViewport=-2638,-351,2934,3605";
    let  floorMIRO = "https://miro.com/app/live-embed/o9J_ltgIkjg=/?embedAutoplay=true&moveToViewport=2560,-648,1472,1160";
    let mapMIRO = 'https://miro.com/app/live-embed/o9J_ljJrZyw=/?embedAutoplay=true&moveToViewport=-1717,-895,2432,1658';

    let selectedMIRO = "";
    let gameProgress;
    let codeResponse, teamSetup;
    var getStatusInterval;

    export default{
        name: 'Sem',
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
                else if(this.puzzleNumber == 3){
                    selectedMIRO = mapMIRO;
                }
                else{
                    selectedMIRO = computerMIRO;
                }
            }

          
        },
        data(){
            return{
                timeisPaused: false,
                miroURLData: selectedMIRO,
                imgCover: '/images/computer.png',
                isShowned: this.miroCovered,
                updatedTime: 0,
                showModal: false,
                shouldShow: null,
                semImage: '2f_north'
            }
        },
        components: {
            Header,
            SemElement,
            SemBody,
            semtest
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
                                if(response['data'][0].player_number != teamSetup.playerName){
                                    this.$swal({
                                            title:'Great! Your team got the correct answer.',
                                            icon:'success'}).then(response => {
                                                    if(this.puzzleNumber == 2){
                                                        this.$router.push({ name: 'main.piano' })
                                                    }
                                                    else if(this.puzzleNumber == 3){
                                                        this.$router.push({ name: 'MapText.index'})
                                                    }
                                                    else if(this.puzzleNumber == 6){
                                                        this.$router.push({name: 'paris.index'})
                                                    }
                                                    else{
                                                        this.$router.push({ name: 'archive.index' })
                                                    } 
                                                    });
                                    }
                                }
                        }).catch(error => {
                           console.log(error);
                        });

                 
            },
            hideSemtest(){
                this.shouldShow = false;
            },
            showSemTest(imageName){
                this.semImage = imageName;
                // alert(imageName);
               this.shouldShow = true;
                // alert(this.shouldShow);
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
        /* background-color: white; */
    }


    .main_element_holder{
        position: relative;
        flex-basis: 120px;
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