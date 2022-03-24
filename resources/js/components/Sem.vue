<template>

    <div class="main"  >
        <Header  :puzzleNumber="puzzleNumber" class="header2" :timePaused="timeisPaused" />
        <div class="main_body">
            <SemBody @showSemTest="showSemTest" @pauseTime="pause-time" class="miro_holder" :miroURL="miroURLData" :isShowned="isShowned" :imgCover="imgCover"/>
            <SemElement :miroURL="miroURLData" @pauseTime="pause-time" :elementImage="elementImage" class="main_element_holder" :answer="answer" :puzzleNumber="puzzleNumber" />
            
        </div>
        <a @click="helpShowed = !helpShowed" href="#" class="float">
            <img src="../assets/chloe_version.png" style="width: 80px; height: 80px;"/>
        </a>

        <transition name="slide-fade">
            <HelpModal   v-if="helpShowed" :puzzleNumber="puzzleNumber" class="help_modal_new" @closeModal="closeModal" @helpTriggered="helpTriggered"/>
        </transition>
<semtest :imgName="semImage" @hideSemtest="hideSemtest" class="semtest"  :shouldShow="shouldShow"/>
    </div>
</template>

<script>
    import axios from 'axios';
    import Header from './Header.vue';
    import SemElement from './SemElement.vue';
    import SemBody from './SemBody.vue';
    import semtest from './semtest.vue';
    import HelpModal from './HelpModal.vue';

    let computerMIRO = "https://miro.com/app/live-embed/o9J_ltgInS4=/?embedAutoplay=true&moveToViewport=-2638,-351,2934,3605";
    let  floorMIRO = "https://miro.com/app/live-embed/o9J_ltgIkjg=/?embedAutoplay=true&moveToViewport=2560,-648,1472,1160";
    let mapMIRO = 'https://miro.com/app/live-embed/o9J_ljJrZyw=/?embedAutoplay=true&moveToViewport=-1717,-895,2432,1658';
    let semMiro = 'https://miro.com/app/live-embed/uXjVOdxVdVo=/?embedAutoplay=true&moveToViewport=-4821,5663,4776,2905';
    // <iframe width="768" height="432" src="https://miro.com/app/live-embed/uXjVOdxVdVo=/?moveToViewport=-4821,5663,4776,2905" frameBorder="0" scrolling="no" allowFullScreen></iframe>
var correctSound = new Audio('https://www.freesoundslibrary.com/wp-content/uploads/2018/03/right-answer-ding-ding-sound-effect.mp3');
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

                // selectedMIRO = semMiro;
                
                axios.post('api/game/get_miro_link',{
                        game_event_id: codeResponse.id,
                        team_number: teamSetup.playerTeam,
                        puzzle_number: this.puzzleNumber
                        }).then(response => {
                           if(response){
                               this.miroURLData = response.data;
                               console.log(response.data)
                           }
                           else{
                              
                               this.miroURLData = semMiro;
                           }
                        });
            }

             getStatusInterval = setInterval(() => this.getStatus(), 3000);
          
        },
        data(){
            return{
                timeisPaused: false,
                miroURLData: '',
                imgCover: '/images/computer.png',
                isShowned: this.miroCovered,
                updatedTime: 0,
                showModal: false,
                shouldShow: null,
                semImage: '2f_north',
                helpShowed: false
            }
        },
        components: {
            Header,
            SemElement,
            SemBody,
            semtest,
            HelpModal
        },
        methods:{
             closeModal(){
                 this.helpShowed= false;
             },
             helpTriggered(){
              this.$swal({
                        title:'ゲームマスターを呼びますか？<br/>Are you sure you want to call a gamemaster?',
                        // icon:'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: "Yes",
                        icon:'question'
                    }).then((result) =>{
                       if (result.isConfirmed) {
                            axios.post('api/game/store_game_help',{
                                    game_event_id: codeResponse.id,
                                    playerTeam: teamSetup.playerTeam,
                                    player_name: teamSetup.playerName,
                                    puzzle_number: this.puzzleNumber
                                }).then(response => {
                                    this.$swal({
                                            title:'ゲームマスターが参ります。<br/>A gamemaster will come for help.',
                                            icon:'success'}).then(response => {
                                                
                                            });
                                });
                       }

                    });
            },
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
                                    correctSound.play();
                                    this.$swal({
                                                    imageUrl: '/images/correct.png',
                                                    width: 524,
                                                    height: 277,
                                                    imageHeight: 267,
                                                    background: '#ffffff20'
                                                            }).then(response => {
                                                        this.$router.push({name: 'semaphore_completed.index'})
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

<style scoped>

    .main{
        display: flex;
        position: relative;
        flex-direction: column;
        color: white;
        height: 100%;
    }

    .header2{
        display: flex;
        justify-content: center;
        width: 100vw;
    }
    
    .semtest{
        position: absolute;
        height: 100%;
        width: 100%;
        z-index: 300;
    }



    .main_body{
        display: flex;
        position: relative;
        flex-direction: row;
        justify-content: center;
        flex-wrap: wrap;
        height: 85%;
        width: 100%;
        min-height: 560px;
    }

    .miro_holder{
        position: relative;
        flex-grow: 1;
        /* background-color: white; */
    }


    .main_element_holder{
        position: relative;
        flex-grow: 1;
        /* flex-basis: 120px; */
    }


    
.float{
	
	position:fixed;
	width:80px;
	height:80px;
	border-radius:50px;
	text-align:center;
    z-index: 99;
	bottom:10px;
	right:10px;
}


.help_modal_new{
    position: fixed;
    height: 450px;
    width: 310px;
    background: #F6D74D;
    border-radius: 20px;
    bottom: 120px;
    right: 90px;
    z-index: 100;
}


.slide-fade-enter-active {
 animation: bounce-in .3s reverse;
}
.slide-fade-leave-active {
   animation: bounce-in .5s;
}

@keyframes bounce-in {
    0%{ 
        transform: translateY(-10px);
    }
    100%{
        transform: translateY(10px);
    }
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