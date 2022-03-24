<template>

    <div class="main">
        <Header  :puzzleNumber="puzzleNumber" class="header2" :timePaused="timeisPaused" />
        <div class="main_body">
            <PianoBody :puzzleNumber="puzzleNumber" @pauseTime="pause-time" class="miro_holder" :miroURL="miroURLData" :isShowned="isShowned" :imgCover="imgCover"/>
        </div>
        <a @click="helpShowed = !helpShowed"  href="#" class="float">
            <img src="../assets/chloe_version.png" style="width: 80px; height: 80px;"/>
        </a>

        <transition name="slide-fade">
            <HelpModal   v-if="helpShowed" :puzzleNumber="puzzleNumber" class="help_modal_new" @closeModal="closeModal" @helpTriggered="helpTriggered"/>
                  <!-- <div class="help_modal"  v-if="helpShowed" @click="hideImage">
                    <div class="help_modal_mantle">
                        <div class="help_modal_core">
                            <div class="help_modal_title">
                                たすけて<br/><br/>WHAT DO YOU NEED HELP FOR?
                            </div>
                            <div class="help_modal_option">
                                <div class="help_button">たすけて<br/>
                                NEED A HINT</div>
                                <div class="help_button">たすけて<br/>
                                MIRO BOARD QUICK TIPS</div>
                                <div class="help_button" @click="helpTriggered()">たすけて<br/>
                                CALL A GAMEMASTER</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="help_connector"></div>
                </div> -->
        </transition>

    </div>
</template>

<script>
    import axios from 'axios';
    import Header from './Header.vue';
    import PianoElement from './PianoElement.vue'
    import PianoBody from './PianoBody.vue';
    import HelpModal from './HelpModal.vue';

    let computerMIRO = "https://miro.com/app/live-embed/o9J_ltgInS4=/?embedAutoplay=true&moveToViewport=-2638,-351,2934,3605";
    let  floorMIRO = "https://miro.com/app/live-embed/o9J_ltgIkjg=/?embedAutoplay=true&moveToViewport=2560,-648,1472,1160";
    let mapMIRO = 'https://miro.com/app/live-embed/o9J_ljJrZyw=/?embedAutoplay=true&moveToViewport=-1717,-895,2432,1658';

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
                else if(this.puzzleNumber == 3){
                    selectedMIRO = mapMIRO;
                }
                else{
                    selectedMIRO = computerMIRO;
                }
            }

            axios.post('api/game/get_status_last_specific',{
                        game_event_id: codeResponse.id,
                        playerTeam: teamSetup.playerTeam
                        }).then(response => {
                            // alert(response.data);
                             if(response.data == 0 && this.puzzleNumber != 1){
                                    this.$router.push({ name: 'introduction.index' });
                                }
                                else if(response.data == 1  && this.puzzleNumber != 2){
                                    this.$router.push({ name: 'archive.index' });
                                }
                                else if(response.data == 2  && this.puzzleNumber != 3){
                                    this.$router.push({ name: 'main.piano' });
                                }
                                else if(response.data == 3 && this.puzzleNumber != 4 ){
                                    this.$router.push({ name: 'mayu_palais.index' });
                                }
                                else if(response.data== 4 && this.puzzleNumber != 5){
                                    this.$router.push({ name: 'tour.index' });
                                }
                                else if(response.data >= 5 && (this.puzzleNumber != 6 || this.puzzleNumber != 7 || this.puzzleNumber != 9)  && this.puzzleNumber != 8){
                                    this.$router.push({ name: 'travel_paris.index' });
                                }
                                else{
                                    
                                    // getStatusInterval = setInterval(() => this.getStatus(), 2000);
                                }
                        });
        },
        data(){
            return{
                timeisPaused: false,
                miroURLData: selectedMIRO,
                imgCover: '/images/computer.png',
                isShowned: this.miroCovered,
                updatedTime: 0,
                helpShowed: false
            }
        },
        components: {
            Header,
            PianoElement,
            PianoBody,
            HelpModal
        },
        methods:{
             closeModal(){
                 this.helpShowed = false;
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
                                    this.$swal({
                                                    imageUrl: '/images/correct.png',
                                                    width: 524,
                                                    height: 277,
                                                    imageHeight: 267,
                                                    background: '#ffffff20'
                                                            }).then(response => { 
                                                                this.$router.push({ name: 'mayu_palais.index'});
                                                    });
                                    }
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

<style scoped>

    .main{
        display: flex;
        flex-wrap: wrap;
        position: relative;
        flex-direction: row;
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
        min-height: 800px;
        width: 100%;
    }

    .miro_holder{
        position: relative;
        flex-grow: 1;
        /* background-color: white; */
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