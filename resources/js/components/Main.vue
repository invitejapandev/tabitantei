<template>

    <div class="main">
        <Header  :puzzleNumber="puzzleNumber" class="header2" :timePaused="timeisPaused" />
        <div class="main_body">
            <Miro class="miro_holder" :miroURL="miroURLData" :isShowned="isShowned" :imgCover="imgCover"/>
            <ElementHolder @pauseTime="pause-time" :elementImage="elementImage" class="main_element_holder" :answer="answer" :puzzleNumber="puzzleNumber" />
        </div>
        <a href="#" @click="helpTriggered()" class="float">
            <img src="../assets/chloe_version.png" style="width: 120px; height: 120px;"/>
        </a>

    </div>
</template>

<script>
    import axios from 'axios';
    import Header from './Header.vue';
    import ElementHolder from './ElementHolder.vue'
    import Miro from './Miro.vue';

    let computerMIRO = "https://miro.com/app/live-embed/o9J_ltgInS4=/?embedAutoplay=true&moveToViewport=-2638,-351,2934,3605";
    let  floorMIRO = "https://miro.com/app/live-embed/o9J_ltgIkjg=/?embedAutoplay=true&moveToViewport=2560,-648,1472,1160";
    let mapMIRO = 'https://miro.com/app/live-embed/o9J_ljJrZyw=/?embedAutoplay=true&moveToViewport=-1717,-895,2432,1658';
    let cafeMIRO = 'https://miro.com/app/live-embed/o9J_lkaWZtQ=/?embedAutoplay=true&moveToViewport=-808,-1845,2834,3668';
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

               
            }

            axios.post('api/game/get_status_last_specific',{
                        game_event_id: codeResponse.id,
                        playerTeam: teamSetup.playerTeam
                        }).then(response => {
                            // alert(response.data);
                                if(response.data == 0 && this.puzzleNumber != 1){
                                    this.$router.push({ name: 'intro_video.index' });
                                }
                                else if(response.data == 1  && this.puzzleNumber != 2){
                                    this.$router.push({ name: 'archive.index' });
                                }
                                else if(response.data == 2  && this.puzzleNumber != 3){
                                    this.$router.push({ name: 'computer_on.index' });
                                }
                                else if(response.data == 3 && this.puzzleNumber != 4 ){
                                    this.$router.push({ name: 'mayu_palais.index' });
                                }
                                else if(response.data== 4 && this.puzzleNumber != 5){
                                    this.$router.push({ name: 'tour.index' });
                                }
                                else{
                                    getStatusInterval = setInterval(() => this.getStatus(), 2000);
                                }
                        });

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
                                if(this.puzzleNumber == 1){
                                        this.miroURLData = floorMIRO;
                                    }
                                    else if(this.puzzleNumber == 3){
                                        this.miroURLData = mapMIRO;
                                    }
                                    else if(this.puzzleNumber == 8){
                                        this.miroURLData = cafeMIRO;
                                    }
                                    else{
                                        this.miroURLData = computerMIRO;
                                    }
                           }
                        });
        },
        data(){
            return{
                timeisPaused: false,
                miroURLData: '',
                imgCover: '/images/computer.png',
                isShowned: this.miroCovered,
                updatedTime: 0
            }
        },
        components: {
            Header,
            ElementHolder,
            Miro
        },
        methods:{
            helpTriggered(){
              this.$swal({
                        title:'Are you sure you want to call for help?',
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
                                            title:'A facilitator will come for help.',
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
                                                    if(this.puzzleNumber == 2){
                                                        this.$router.push({ name: 'computer_on.index' })
                                                    }
                                                    else if(this.puzzleNumber == 3){
                                                        this.$router.push({ name: 'MapText.index'})
                                                    }
                                                    else if(this.puzzleNumber === 8){
                                                        this.$router.push({name: 'cafe_completed.index'})
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