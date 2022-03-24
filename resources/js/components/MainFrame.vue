<template>

    <div class="main" >
        
        <div class="left_cover"></div>
        <Header   :puzzleNumber="puzzleNumber" class="header2" :timePaused="timeisPaused" />
        <div class="main_body">
            <LeftPanel  class="miro_holder"  :isShowned="isShowned" :puzzleNumber="puzzleNumber" :imgCover="imgCover" />
            <RightPanel  @pauseTime="pause-time" :isShowned="isShowned" :imgCover="imgCover" :miroURL="miroURLData" :elementImage="elementImage" class="main_element_holder" :answer="answer" :puzzleNumber="puzzleNumber" />
        </div>
        <a href="#" @click="helpShowed = !helpShowed" class="float v-step-2" >
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
        
    <v-tour name="myTour" :steps="steps"  :callbacks="myCallbacks" :options="{ highlight: true }"></v-tour>
    </div>
</template>

<script>
    import axios from 'axios';
    import Header from './Header.vue';
    // import ElementHolder from './ElementHolder.vue'
    // import Miro from './Miro.vue';
    import LeftPanel from './LeftPanel.vue';
    import RightPanel from './RightPanel.vue';
    import HelpModal from './HelpModal.vue';

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
                                else if(response.data >= 5 && (this.puzzleNumber != 6 || this.puzzleNumber != 7 || this.puzzleNumber != 9) && this.puzzleNumber != 8){
                                    this.$router.push({ name: 'travel_paris.index' });
                                }
                                else{
                                    getStatusInterval = setInterval(() => this.getStatus(), 2500);
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
        mounted:function(){
            if(this.puzzleNumber ==1){
                this.$swal({
                                            title:`エージェントの皆さん、ファーストミッションへようこそ！ まず任務に取り掛かる前に、これから使うインターフェースについてご案内しなければなりません。ミッションを成功させるのに役立つ重要な要素となりますので、ぜひ覚えておいてください！<br>Agents, welcome to your first mission. Before I let you get out in the field, I have to show you around your interface. Here are the most important elements that will help you succeed in your mission!`,
                                        }).then((result) =>{
                                            this.$tours['myTour'].start()
                                        });
            }
        },
        data(){
            return{
                timeisPaused: false,
                miroURLData: '',
                // imgCover: '/images/billboard_772_jp.png',
                imgCover: this.elementImage,
                isShowned: this.miroCovered,
                updatedTime: 0,
                helpShowed: false,
                steps: [
                            {
                                target: '.v-step-0',  // We're using document.querySelector() under the hood
                                content: `これはMiroボードと呼ばれるものです。<br/>このボード上では、アイテムを動かしたり、メモを取ったりすることができます。<br/>Here is your Miro board.<br/>This is where you can move<br/>things around and take notes!`,
                                params: {
                                    placement: 'left',
                                    modifiers:{
                                    arrow: {
                                        element: '.v-step__arrow'
                                    }
                                    }
                                }            
                            },
                            {
                                target: '.v-step-1',  // We're using document.querySelector() under the hood
                                content: `左端にあるツールバーには、Miroボードを操作するためのツールが用意されています。<br/>主に使用するのはペンツールです。これを使ってメモを取ったり、アイテムに印を付けることができます。<br/>The toolbar on the left provides you with tools to interact with the Miro board.<br/>You will mostly use the Pen tool to take notes and highlight items for your team`,
                                params: {
                                    placement: 'left',
                                    modifiers:{
                                    arrow: {
                                        element: '.v-step__arrow'
                                    }
                                    }
                                }            
                            },
                            {
                                target: '.v-step-2',
                                content: `ヒントが必要な時やMiroの使い方を知りたい時、またゲームマスターを呼びたい場合は、このボタンをクリックしてください。<br/>If you need a hint, want to know how to use MIRO, or would like to call gamemasters, click on this button.`
                            },
                            {
                                target: '.v-step-3',  // We're using document.querySelector() under the hood
                                content: `ヒントを見るには、こちらのヒントボタンを押してください。<br/>To get some hints, press this button.`,
                                params: {
                                    placement: 'left',
                                    modifiers:{
                                        arrow: {
                                            element: '.v-step__arrow'
                                        }
                                    }
                                }      
                            },
                            {
                                target: '.v-step-4',  // We're using document.querySelector() under the hood
                                content: `Miroの操作についてのサポートが必要な場合は、こちらのボタンを押してください。<br/>If you need more help on using Miro,<br/>press this button here.`,
                                params: {
                                    placement: 'left',
                                    modifiers:{
                                        arrow: {
                                            element: '.v-step__arrow'
                                        }
                                    }
                                }      
                            },
                            {
                                target: '.v-step-5',  // We're using document.querySelector() under the hood
                                content: `ゲームマスターのヘルプが必要な場合は、こちらのヘルプボタンを押してください。<br/>To call a GameMaster for help at ANYTIME, press this help button.`,
                                params: {
                                    placement: 'left',
                                    modifiers:{
                                        arrow: {
                                            element: '.v-step__arrow'
                                        }
                                    }
                                }      
                            },
                            {
                                target: '.v-step-6',  // We're using document.querySelector() under the hood
                                content: `チーム番号・ご自身のプレイヤー番号・タイマーは、ここで確認することができます。<br/>Here you can see your Team and Player number as well as the timer!`,
                                params: {
                                    modifiers:{
                                        arrow: {
                                            element: '.v-step__arrow'
                                        }
                                    }
                                }      
                            },
                            {
                                target: '.v-step-7',  // We're using document.querySelector() under the hood
                                content: `このゾーンには、パズルを解くために必要なアイテムが隠されています。<br/>一部のアイテムは、クリックすると拡大表示され、詳しく調べることができます。<br/>In this zone you will find the elements needed to solve the puzzle.<br/>Certain elements in this zone may be clickable, so you can seem them more closely.`,
                                params: {
                                    placement: 'right',
                                    modifiers:{
                                        arrow: {
                                            element: '.v-step__arrow'
                                        }
                                    }
                                }      
                            },
                            {
                                target: '.v-step-8',  // We're using document.querySelector() under the hood
                                content: `答えを突き止めたら、Miroボードの下にあるアンサーボックスにその答えを入力してください。<br/>When you think you have the answer,<br/>find the answer box below the Miro board here and type it in!`,
                                params: {
                                    placement: 'left',
                                    modifiers:{
                                        arrow: {
                                            element: '.v-step__arrow'
                                        }
                                    }
                                }      
                            },
                            {
                                target: '.v-step-9',  // We're using document.querySelector() under the hood
                                content: `ここでゲームの進行状況を確認しましょう！<br/>Keep an eye on your progress here!`,
                                params: {
                                    modifiers:{
                                        arrow: {
                                            element: '.v-step__arrow'
                                        }
                                    }
                                }      
                            }
                        ],
                 myCallbacks: {
                    onPreviousStep: this.myCustomPreviousStepCallback,
                    onNextStep: this.myCustomNextStepCallback
                }
            }
        },
        components: {
            Header,
            LeftPanel,
            RightPanel,
            HelpModal
        },
        methods:{
            myCustomPreviousStepCallback (currentStep) {
                console.log('[Vue Tour] A custom previousStep callback has been called on step ' + (currentStep + 1))
                    if (currentStep === 6 || currentStep === 5 || currentStep === 4) {
                    console.log('[Vue Tour] A custom nextStep callback has been called from step 2 to step 3')
                    this.helpShowed = true;
                    }
                    else{
                        this.helpShowed = false;
                    }
            },
            myCustomNextStepCallback (currentStep) {
                console.log('[Vue Tour] A custom nextStep callback has been called on step ' + (currentStep + 1))
                

                if (currentStep === 2 || currentStep === 3 || currentStep === 4) {
                console.log('[Vue Tour] A custom nextStep callback has been called from step 2 to step 3')
                this.helpShowed = true;
                }
                else{
                    this.helpShowed = false;
                }
            },
            hideImage(){
                this.helpShowed = !this.helpShowed;
            },
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
                            // console.log(response['data'][0].answered_current);
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
        min-height: 560px;
        width: 100%;
    }

    .miro_holder{
        position: relative;
        flex-grow: 1;
        max-width: 50vw;
        /* background-color: white; */
    }


    .main_element_holder{
        position: relative;
        flex-grow: 1;
        max-width: 50vw;
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

@media only screen and (max-width: 1500px) {

    .miro_holder{
        height: 95%;
    }

}

.v-tour__target--highlighted {
  box-shadow: 0 0 0 99999px rgba(0,0,0,.4);
}


</style>