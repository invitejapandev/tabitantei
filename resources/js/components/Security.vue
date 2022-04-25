<template>
    <div class="main">
         <Header  :puzzleNumber="puzzleNumber" class="header2" :timePaused="timeisPaused" />
         <div class="mainContent">
             <div class="videoHolder" >
                 <!-- <div class="video classified">Classified</div> -->
                 <div class="video classified" v-for="(item, index) in vids" :key="index">
                      <vue3-video-player v-if="item.isShowned==true" v-bind:src="'./images/'+item.vidName" class="vue3video"></vue3-video-player>
                      <div v-else>Classified</div>
                </div>
                 <!-- <div class="video"></div>
                 <div class="video"></div>
                 <div class="video"></div>
                 <div class="video"></div>
                 <div class="video"></div>
                 <div class="video"></div>
                 <div class="video"></div>
                 <div class="video"></div> -->
             </div>
             <div class="answerHolder">
                 <div class="security_answer" v-for="(item, index) in orderedQuestions" :key="index">
                    <div :class="[item.isShowned ? '': 'classified', 'question']">
                        <div v-if="item.isShowned==true"> <pre>{{ item.japaneseDetails }}<br/>{{ item.questionDetails }}</pre></div>
                        <div v-else> Classified</div>
                    </div>
                            <form id="answerForm" class="dropAnswer" @submit.prevent="formSubmit">
                                 <!-- @change="selectedAnswer(index, $event)" -->
                                <select  class="answerSelect" v-bind:ref="item.inputName" required>
                                    <option value="">Select</option>
                                    <option  v-for="(item, index2) in item.dummies"  :key="index2" v-bind:value="item.isCorrect">{{item.text}}</option>
                                </select>
                            </form>
                 </div>
                 <div class="submitHolder">
                     <button type="submit" class="btnSubmit" form="answerForm">Submit</button>
                 </div>
             </div>
         </div>
         <a @click="helpShowed = !helpShowed" href="#" class="float">
            <img src="../assets/chloe_version.png" style="width: 80px; height: 80px;"/>
        </a>
        <transition name="slide-fade">
            <HelpModal   v-if="helpShowed" :puzzleNumber="puzzleNumber" class="help_modal_new" @closeModal="closeModal" @helpTriggered="helpTriggered"/>
        </transition>
    </div>
</template>

<script>
name: 'Security'
import axios from 'axios'
import Header from './Header.vue';
import HelpModal from './HelpModal.vue';

let teamSetup, codeResponse, playerIndex, player_count, player_matrix, newQuestionShowned_temp, getStatusInterval;
var correctSound = new Audio('https://www.freesoundslibrary.com/wp-content/uploads/2018/03/right-answer-ding-ding-sound-effect.mp3');
   

export default {
    beforeCreate(){
        
            teamSetup = JSON.parse(localStorage.getItem('teamSetup'));
             codeResponse = JSON.parse(localStorage.getItem('codeResponse'));
    },
    beforeMount(){
        // let test = 'true, false, true, false, false, false, false, true';
        
        // let newQuestionShowned = [true, false, true, false, false, false, false, true];
        
        // let newQuestionShowned_temp = player_matrix.split(',');

               axios.post('api/game/get_player_count',{
                        game_event_id: codeResponse.id,
                        playerTeam: teamSetup.playerTeam,
                        player_name: teamSetup.playerName
                        }).then(response => {
                            player_count = response.data.length;
                            for(var i = 0; i < player_count; i++){
                                // alert(response.data[i]['nickName']);
                                if(teamSetup.playerName == response.data[i]['nickName']){
                                    playerIndex = i+1;
                                    
                                    // alert(playerIndex);
                                }
                            }
                                    // console.log(response.data['player_matrix'])
                                    if(playerIndex%2 == 1){
                                        player_matrix = 'false,true,false,true,true,true,false,false,false,false';
                                    }
                                    else{
                                        player_matrix = 'true,false,true,false,false,false,true,true,false,false';
                                    }


                                    // player_matrix = response.data['player_matrix'];
                                    newQuestionShowned_temp = player_matrix.split(',');
                                                         
                                        let newQuestionShowned = newQuestionShowned_temp.map(function (x){
                                            if(x.trim() == 'true'){
                                                return true;
                                            }
                                            else{
                                                return false;
                                            }
                                        });
                                        
                                        console.log(newQuestionShowned);
                                        
                                        let video_matrix = '';
                                        if(playerIndex%2 == 1){
                                            video_matrix = 'false,true,false,true,true,false,false,true,false,true';
                                        }
                                        else{
                                            video_matrix = 'true,false,true,false,false,true,true,false,true,false';
                                        }

                                        let newVideoShowned_temp = video_matrix.split(',');

                                        let newVideoShowned = newVideoShowned_temp.map(function (x){
                                            if(x.trim() == 'true'){
                                                return true;
                                            }
                                            else{
                                                return false;
                                            }
                                        });

                                        // let newVideoShowned = [true, false, false, false, false, true, true, true, true, false];

                                        let newQuestions = this.questions.map((item,index) => {
                                            const questiondata = {};
                                            questiondata['questionDetails'] = item.questionDetails;
                                            questiondata['japaneseDetails'] = item.japaneseDetails;
                                            questiondata['answer'] = item.answer;
                                            questiondata['dummies'] = item.dummies;
                                            questiondata['isShowned'] = newQuestionShowned[index];
                                            return questiondata;
                                        });

                                        let newVids = this.vids.map((item, index)=>{
                                            const vidData ={};
                                            vidData['vidName'] = item.vidName;
                                            vidData['isShowned'] = newVideoShowned[index];
                                            return vidData;

                                        });


                                        this.questions = newQuestions;
                                        this.vids =newVids; 
                                        
             getStatusInterval = setInterval(() => this.getStatus(), 3000);
                                

                        });

   
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
        formSubmit(submitEvent){
            console.log(this.$refs.input1.value);
            if(this.$refs.input1.value == 'true' && this.$refs.input2.value == 'true'  && this.$refs.input3.value == 'true' && this.$refs.input4.value == 'true' && this.$refs.input5.value == 'true' && this.$refs.input6.value == 'true' && this.$refs.input7.value == 'true' && this.$refs.input8.value == 'true'){
                 
                        correctSound.play();
                 axios.post('api/game/store_status',{
                                    game_event_id: teamSetup.game_event_id,
                                    teamNumber: teamSetup.playerTeam,
                                    puzzle_progress: this.puzzleNumber,
                                    player_number: teamSetup.playerName
                                }).then(response => {
                                    


                                    if(response){
                                       this.$swal({
                                                    imageUrl: '/images/correct.png',
                                                    width: 524,
                                                    height: 277,
                                                    imageHeight: 267,
                                                    background: '#ffffff20'
                                                            }).then(response => {
                                                          this.$router.push({ name: 'security_completed.index'})
                                        });
                                    }
                                    else{
                                        //show db error
                                        //alert('something went wrong');
                                    }
                                });
                this.timeisPaused = true;
            }
            else{
                 this.$swal({
                                                    imageUrl: '/images/try_again.png',
                                                    width: 524,
                                                    height: 277,
                                                    imageHeight: 267,
                                                    background: '#ffffff20'
                                                            });
            }
            // alert(submitEvent.target.elements.0.value);
            //  let name_test = submitEvent.target.elements.name.value;
            //  console.log(name_test);
        },
            
            getStatus(){
                    axios.post('api/game/get_status',{
                        game_event_id: codeResponse.id,
                        playerTeam: teamSetup.playerTeam,
                        puzzleNumber: this.puzzleNumber
                        }).then(response => {
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
                                                          this.$router.push({ name: 'security_completed.index'})
                                                    });
                                    }
                                }
                        }).catch(error => {
                           console.log(error);
                        });

                 
            }
    },
    props:{
        puzzleNumber: Number
    },
    computed:{
        orderedQuestions: function(){
            return this.questions.sort((a, b) => parseInt(a['id']) - parseInt(b['id']));
        }
    },
    data(){
        return{
            timeisPaused: false,
            helpShowed: false,
            vids: [
                {vidName: 'MV_1.mp4', isShowned: false },
                {vidName: 'MV_2.mp4', isShowned: false },
                {vidName: 'MV_3.mp4', isShowned: false },
                {vidName: 'MV_4.mp4', isShowned: false },
                {vidName: 'MV_5.mp4', isShowned: false },
                {vidName: 'MV_6.mp4', isShowned: false },
                {vidName: 'MV_7.mp4', isShowned: false },
                {vidName: 'MV_8.mp4', isShowned: false },
                {vidName: 'MV_9.mp4', isShowned: false },
                {vidName: 'MV_10.mp4', isShowned: false }
            ],
            questions:[
                {
                    questionDetails: `Find a person who knocks 4 times. What are they holding?`,
                    japaneseDetails: `4回ノックしている人物を探せ。\nその人物が持っているのは？`
                    , inputName: 'input5'
                    ,isShowned: false
                    , answer:'DUCK'
                    , id: 4
                    , dummies:[
                        {
                        text: 'ELEPHANT',
                        isCorrect: false
                        },
                        {
                        text: 'FISH',
                        isCorrect: false
                        },
                        {
                        text: 'CROW',
                        isCorrect: false
                        },
                        {
                        text: 'DUCK',
                        isCorrect: true
                        },
                        {
                        text: 'LION',
                        isCorrect: false
                        },
                    ]
                },
                
                {
                    questionDetails: 'Find a nanny. How many dots are on the suitcase?',
                    japaneseDetails: `エプロンを着けた人物を探せ。\nスーツケースにはいくつの点がある？`
                    , inputName: 'input8'
                    ,isShowned: false
                    , answer:'NINE'
                    , id: 8
                    , dummies:[
                        {
                        text: 'TWO',
                        isCorrect: false
                        },
                        {
                        text: 'FOUR',
                        isCorrect: false
                        },
                        {
                        text: 'SIX',
                        isCorrect: false
                        },
                        {
                        text: 'EIGHT',
                        isCorrect: false
                        },
                        {
                        text: 'NINE',
                        isCorrect: true
                        },
                    ]
                },
                {
                    questionDetails: 'Find a boxer. What hand gesture are they making?',
                    japaneseDetails: `ボクサーを探せ。\nその人物は何のハンドサインをしている？`
                    , inputName: 'input6'
                    ,isShowned: false
                    , answer:'OKAY'
                    , id: 6
                    , dummies:[
                        {
                        text: 'PEACE',
                        isCorrect: false
                        },
                        {
                        text: 'OKAY',
                        isCorrect: true
                        },
                        {
                        text: 'HELLO',
                        isCorrect: false
                        },
                        {
                        text: 'LOSER',
                        isCorrect: false
                        },
                        {
                        text: 'LOVE',
                        isCorrect: false
                        },
                    ]
                },
                {
                    questionDetails: `Find a person holding a dictionary. What do they put on their face?`,
                    japaneseDetails: `辞書を持っている人物を探せ。\nその人物の顔にあるものは？`
                    , inputName: 'input2'
                    ,isShowned: false
                    , answer:'GLASSES'
                    , id: 1
                    , dummies:[
                        {
                        text: 'LIPSTICK',
                        isCorrect: false
                        },
                        {
                        text: 'GLASSES',
                        isCorrect: true
                        },
                        {
                        text: 'MAKE UP',
                        isCorrect: false
                        },
                        {
                        text: 'MASK',
                        isCorrect: false
                        },
                        {
                        text: 'SUNGLASSES',
                        isCorrect: false
                        },
                    ]
                },
                {
                    questionDetails: 'Find a delivery guy. What is the name of the pizza shop?',
                    japaneseDetails: `配達人を探せ。\nその人物が働くピザ屋の名前は？`
                    , inputName: 'input4'
                    ,isShowned: false
                    , answer:'OLIVER'
                    , id: 2
                    , dummies:[
                        {
                        text: 'ANGELO',
                        isCorrect: false
                        },
                        {
                        text: 'EMILIO',
                        isCorrect: false
                        },
                        {
                        text: 'HERVE',
                        isCorrect: true
                        },
                        {
                        text: 'ISABEL',
                        isCorrect: false
                        },
                        {
                        text: 'OLIVER',
                        isCorrect: true
                        },
                    ]
                },
                {
                    questionDetails: 'Find a Ninja. What object is he holding?',
                    japaneseDetails: `忍者を探せ。\nその人物が手に持っているものは？`
                    , inputName: 'input3'
                    ,isShowned: false
                    , answer:'CAMERA'
                    , id: 5
                    , dummies:[
                        {
                        text: 'ARROWS',
                        isCorrect: false
                        },
                        {
                        text: 'STAR',
                        isCorrect: false
                        },
                        {
                        text: 'ROPE',
                        isCorrect: false
                        },
                        {
                        text: 'BOTTLE',
                        isCorrect: false
                        },
                        {
                        text: 'CAMERA',
                        isCorrect: true
                        },
                    ]
                },
                {
                    questionDetails: 'Find a cleaner. What are they eating?',
                    japaneseDetails: `清掃員を探せ。\nその人物が食べているものは？`
                    , inputName: 'input1'
                    , isShowned: false
                    , answer:'ICE CREAM'
                    , id: 7
                    , dummies:[
                        {
                        text: 'ONIGIRI',
                        isCorrect: false
                        }, 
                        {
                        text: 'CAKE',
                        isCorrect: false
                        },
                        {
                        text: 'ICE CREAM',
                        isCorrect: true
                        },
                        {
                        text: 'BANANA',
                        isCorrect: false
                        },
                        {
                        text: 'SANDWICH',
                        isCorrect: false
                        },
                    ]
                },
                {
                    questionDetails: 'Find a person with a picnic basket. What fruit do they have?',
                    japaneseDetails: `ピクニックバスケットを持っている人物を探せ。\nその人物が持っているフルーツは？`
                    , inputName: 'input7'
                    ,isShowned: false
                    , answer:'LEMON'
                    , id: 3
                    , dummies:[
                        {
                        text: 'LEMON',
                        isCorrect: true
                        },
                        {
                        text: 'APPLE',
                        isCorrect: false
                        },
                        {
                        text: 'GRAPES',
                        isCorrect: false
                        },
                        {
                        text: 'PEAR',
                        isCorrect: false
                        },
                        {
                        text: 'STRAWBERRIES',
                        isCorrect: false
                        },
                    ]
                }
            ]
        }
    },
    components: {
                Header,
                HelpModal
    }
}
</script>

<style scoped>

    .vue3video{
        border-radius: 10px !important;
    }

    .videohidden{
        display: none !important;
    }

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
    }

.visitorlogHolder{
    text-align: center;
}

.visitorLog{
    background-color: white;
    font-size: 3rem;
    font-weight: bold;
    font-family: CA-Geheimagent;
    padding: 5px;
    border-radius: 5%;
    color: black;
}

.mainContent{
    display: flex;
    flex-wrap: wrap;
    flex-direction: row;
        width: 100%;
}

.videoHolder{
    position: relative;
    display: flex;
    flex-wrap: wrap;
    align-content: center;
    justify-content: center;
    gap: 10px;
    margin-bottom: 10px;
    flex-grow: 1;
    width: 45vw;
}

.video{
    height: 180px;
    line-height: 180px;
    width: 300px;
    background-color: white;
    font-family: CA-Geheimagent;
    font-size: 1.5vw;
    text-align: center;
    cursor: pointer;
}

.answerHolder{
    position: relative;
    flex-wrap: wrap;
    display: flex;
    flex-grow: 1;
    justify-content: flex-start;
    align-content: center;
    flex-direction: column;
    gap: 10px;
    width: 55vw;
    flex-grow: 1;
}

.security_answer{
    display: flex;
    position: relative;
    width: 95%;
    height: auto;
    gap: 10px;
}

.question{
    border-radius: 5px;
    position: relative;
    width: 80%;
    height: auto;
    line-height: auto;
    background-color: black;
    font-family: CA-Geheimagent;
    font-size: 1vw;
    text-align: center;
    padding-left: 5px;
    padding-right: 5px;
    font-weight: bold;
}

.dropAnswer{
    display: flex;
    justify-content: flex-end;
    align-content: center;
    position: relative;
    width: 20%;
    height: 50px;
    line-height: 50px;
    border-radius: 2%;
}

.answerSelect{
    height: 30px;
    width: 150px;
    margin-top: 10px;
    font-family: CA-Geheimagent;
    font-size: 1.5rem;
}

.classified{
    background-color: red;
    font-family: CA-Geheimagent;
    cursor:unset;
    font-size: 2vw;
}

.submitHolder{
    display: flex;
    justify-content: center;
}

.btnSubmit{
    height: 60px;
    width: 75px;
    line-height: 30px;
    text-align: center;
    font-family: CA-Geheimagent;
    font-size: 1.5rem;
    border-radius: 10px;
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



</style>