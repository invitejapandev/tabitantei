<template>
<!-- <div></div> -->
    <div  :class="[puzzleNumber == 4 ? 'right_panel' : 'right_panel_wider']" >
        <div class="element_holder">
            <div class="manual_div">
                <!-- <img class="desk" src="../assets/bulletin_board.png"  /> -->
                <!-- <img class="desk" v-bind:src="img"  /> -->
                <div  :class="[puzzleNumber == 4 ? 'appear' : '' , 'form_container']">
                    <!-- <div class="form_input" hidden>
                        <div class="form_label" > <img class="map1_icon_x"  src="../assets/map_icon_circle.png" /> </div>
                        <div class="form_select" style="text-align: center; line-height: 60px; ">A</div>
                        <div class="form_select" style="text-align: center; line-height: 60px;">2</div>
                    </div> -->
                    <div class="form_input">
                        <!-- <div class="form_label"> <img class="map1_icon_x"  src="../assets/map_icon_x.png" /> </div> -->
                        <select v-model="xSelected" class="form_select" @change="validateAnswer()" required>
                            <option value=""></option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                            <option value="E">E</option>
                            <option value="F">F</option>
                            <option value="G">G</option>
                        </select>
                         <select  v-model="ySelected" class="form_select" @change="validateAnswer()" required>
                             <option value=""></option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                    <!-- <div class="form_input">
                        <div class="form_label">Y</div>
                        <select  v-model="ySelected" class="form_select">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div> -->
                    <!-- <div class="form_action">
                        <button  @click="validateAnswer()" class="form_submit">Submit</button>
                    </div> -->
                </div>

                
                <div :class="[puzzleNumber == 5 ? 'appear' : '' , 'actions3']" >
                    <div class="btnBoxes blue" @click="selectColor2('blue')"></div>
                    <div class="btnBoxes green" @click="selectColor2('green')"></div>
                    <div class="btnBoxes yellow" @click="selectColor2('brown')"></div>
                    <div class="btnBoxes red" @click="selectColor2('red')"></div>
                </div>
            </div>
            
                <div  :class="[puzzleNumber == 5 ? 'appear' : '' , 'player_selected_colors']">
                    <div v-for="(item, index) in answerList" :key="index" class="player_color">
                        {{item.nickName}}
                        <div :class="[item.selected_color != '' ? item.selected_color+'_bg': '', 'selected_color']" ></div>
                    </div>

               
                </div>
            <!-- <div :class="[puzzleNumber == 4 ? 'appear' : '' , 'actions2']" >
                <input :class="[isCorrect ? 'correct' : '' , 'answer']" type="text" placeholder="TYPE HERE" style="z-index: 1" v-on:keyup.enter="onEnter" @input="onInput" />
        
            </div> -->

        </div>
       
       
       <div class="btnCard"></div>
     <vue-easy-lightbox
      scrollDisabled
      moveDisabled
      :visible="visible"
      :imgs="imgs"
      :index="index"
      @hide="handleHide"
    ></vue-easy-lightbox>


    </div>

     <div class="language_buttons">
             <a href="#" :class="[showLanguageButton ? 'appear' : '', 'float3']" @click="showMultiple()">
            <img src="../assets/japan.png" style="width: 100%; height: 100%; 
            border-radius:70px;
                object-fit: cover;"/>
                </a>

                <a href="#" :class="[showLanguageButton ? 'appear' : '', 'float3']" @click="showMultiple2()">
                    <img src="../assets/english.png" style="width: 100%; height: 100%; 
            border-radius:70px;
                object-fit: cover;"/>
                </a>
        </div>
</template>

<script>

import VueEasyLightbox from 'vue-easy-lightbox'
import axios from 'axios'
   var getStatusInterval;

var keystrokeSound = new Audio('https://dl.dropboxusercontent.com/s/hjx4xlxyx39uzv7/18660_1464810669.mp3');
var correctSound = new Audio('https://www.freesoundslibrary.com/wp-content/uploads/2018/03/right-answer-ding-ding-sound-effect.mp3');
            var interval,  newInterval;
const compImage = '/images/computer.png';
const cover_jp = '/images/cover_jp.png';
const page_1_jp = '/images/page_1_jp.png';
const page_2_jp = '/images/page_2_jp.png';
const page_8_jp = '/images/page_8_jp.png';

const jp_manual = [cover_jp, page_1_jp, page_2_jp, page_8_jp];

const cover_en = '/images/cover_en.png';
const page_1_en = '/images/page_1_en.png';
const page_2_en = '/images/page_2_en.png';
const page_8_en = '/images/page_8_en.png';

const en_manual = [cover_en, page_1_en, page_2_en, page_8_en];

const floor1_image = '/images/floor3.png';
const floor2_image = '/images/floor1.png';
const floor3_image = '/images/floor2.png';
const floor4_image = '/images/floor4.png';

const en_floor_image = [floor1_image, floor2_image, floor3_image, floor4_image];

const map1_image = '/images/Map1.png';
const map2_image = '/images/Map2.png';
const map3_image = '/images/Map3.png';
const map4_image = '/images/Map4.png';
const map5_image = '/images/Map5.png';
const map6_image = '/images/Map6.png';
const map7_image = '/images/Map7.png';

const en_map_images = [map1_image, map2_image, map3_image, map4_image, map5_image, map6_image, map7_image];

const blue_image = '/images/Blue.png';
const yellow_image = '/images/Yellow.png';
const green_image = '/images/Green.png';
const red_image = '/images/Red.png';

const en_color_iamges = [blue_image, yellow_image, green_image, red_image];

var typingTimer;
var doneTypingInterval = 1000;
var presscount = 0;
let teamSetup;
let codeResponse;
let getStatusAttempt = 0;

let playerselectedColor;


export default{
    name:'MapElement',
    components:{
        VueEasyLightbox
    },
    data(){
        return{
            message: '',
            typing: false,
            timer: null,
            isCorrect: false,
            correctAnswer: this.answer,
            imgs: '', // Img Url , string or Array of string
            visible: false,
            index: 0, // default: 0,
            showLanguageButton: false,
            img: this.elementImage,
            xSelected: '',
            ySelected: '',
            validatedAnswer: false,
            answerList: {}
        }
    },
    props:{
        elementImage: String,
        answer: String,
        puzzleNumber: Number,
        SecondMapAnswer: Boolean
    },
    beforeCreate(){
            teamSetup = JSON.parse(localStorage.getItem('teamSetup'));
            codeResponse = JSON.parse(localStorage.getItem('codeResponse'));
            if(this.puzzleNumber ==5){
                getStatusInterval = setInterval(() => this.getStatus(), 3000);
            }
    },
    methods: {
            validateAnswer(){
                // alert(this.xSelected+' '+this.ySelected);
                if(this.xSelected!='' && this.ySelected!=''){
                let answer = this.xSelected+''+this.ySelected;
                if(answer.includes(this.correctAnswer)){
                    this.isCorrect = true;
                        correctSound.play();
                        this.$emit('pause-time');
                        
                        let gameProgress = JSON.parse(localStorage.getItem('gameProgress'));


                          axios.post('api/game/store_status',{
                                    game_event_id: teamSetup.game_event_id,
                                    teamNumber: teamSetup.playerTeam,
                                    puzzle_progress: this.puzzleNumber,
                                    player_number: teamSetup.playerName
                                }).then(response => {
                                    console.log(response);
                                    


                                    if(response){
                                        this.$swal({
                                                    imageUrl: '/images/correct.png',
                                                    width: 524,
                                                    height: 277,
                                                    imageHeight: 267,
                                                    background: '#ffffff20'
                                                            }).then(response => {
                                                    if(this.puzzleNumber == 2){
                                                        this.$router.push({ name: 'demo.index' })
                                                    }
                                                    else if(this.puzzleNumber == 4){
                                                        this.$router.push({ name: 'tour.index'})
                                                    }
                                                    else if(this.puzzleNumber == 5){
                                                         this.$router.push({ name: 'travel_paris.index'})
                                                    }
                                                    else{
                                                        this.$router.push({ name: 'archive.index' })
                                                    }
                                        });
                                    }
                                    else{
                                        //show db error
                                        //alert('something went wrong');
                                    }
                                });
                    }
                    else{
                        this.$swal({
                                                        imageUrl: '/images/try_again.png',
                                                        width: 524,
                                                        height: 277,
                                                        imageHeight: 267,
                                                        background: '#ffffff20'
                                                                });
                            this.isCorrect = false;
                    }
                }
            },
            getStatus(){

                axios.post('api/game/get_selected_map_answer',{
                        game_event_id: codeResponse.id,
                        player_team: teamSetup.playerTeam,
                        player_name: teamSetup.playerName,
                        // player_selected_color: playerselectedColor,
                        puzzle_number: this.puzzleNumber
                        }).then(response => {
                            
                            let data = response['data'];
                            this.answerList = data.playerAnswerList;
                            let voted_color = data.voted_color;
                            let gameProgressNew = data.gameProgress;
                            if(gameProgressNew == 1){
                                clearInterval(getStatusInterval);
                                this.$swal({
                                                                                        imageUrl: '/images/correct.png',
                                                                                        width: 524,
                                                                                        height: 277,
                                                                                        imageHeight: 267,
                                                                                        background: '#ffffff20'
                                                                                    }).then(response => {
                                                                                            
                                                                                              
                                                                                      if(this.puzzleNumber == 4){
                                                                                                    this.$router.push({ name: 'tour.index'})
                                                                                                }
                                                                                                else if(this.puzzleNumber == 5){
                                                                                                    this.$router.push({ name: 'travel_paris.index'})
                                                                                                }
                                                                                    });
                            }

                            if(voted_color != ""){
                                clearInterval(getStatusInterval);
                                let timerInterval;
                                                this.$swal({
                                                    title: '全員が選択を完了しました。解答を検証中です。<br/>Validating the answers.',
                                                    timer: 3000,
                                                    timerProgressBar: true,
                                                    allowOutsideClick:false,
                                                    didOpen: () => {
                                                        this.$swal.showLoading()
                                                        const b = this.$swal.getHtmlContainer().querySelector('b')
                                                        timerInterval = setInterval(() => {
                                                        b.textContent =  this.$swal.getTimerLeft()
                                                        }, 100)
                                                    },
                                                    willClose: () => {
                                                        clearInterval(timerInterval)
                                                    }
                                                    }).then((result) => {

                                                        axios.post('api/game/update_map_answer',{
                                                            game_event_id: codeResponse.id,
                                                            player_team: teamSetup.playerTeam,
                                                            player_name: teamSetup.playerName,
                                                            selected_color: voted_color,
                                                            puzzle_number: this.puzzleNumber
                                                            }).then(response => {
                                                            
                                                            });
                                                    
                                                        if(voted_color == 'red'){
                                                            this.validatedAnswer = true;
                                                                correctSound.play();
                                                                this.$emit('pause-time');
                                                                
                                                                let gameProgress = JSON.parse(localStorage.getItem('gameProgress'));

                                                                axios.post('api/game/store_status',{
                                                                            game_event_id: teamSetup.game_event_id,
                                                                            teamNumber: teamSetup.playerTeam,
                                                                            puzzle_progress: 5,
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
                                                                                            
                                                                                              
                                                                                      if(this.puzzleNumber == 4){
                                                                                                    this.$router.push({ name: 'tour.index'})
                                                                                                }
                                                                                                else if(this.puzzleNumber == 5){
                                                                                                    this.$router.push({ name: 'travel_paris.index'})
                                                                                                }
                                                                                    });
                                                                                }
                                                                                else{
                                                                                    //show db error
                                                                                    //alert('something went wrong');
                                                                                }
                                                                        });
                                                        }
                                                        else{
                                                             this.$swal({
                                                                    imageUrl: '/images/try_again.png',
                                                                    width: 524,
                                                                    height: 277,
                                                                    imageHeight: 267,
                                                                    background: '#ffffff20'
                                                            });

                                                            getStatusInterval = setInterval(() => this.getStatus(), 2000);
                                                            this.validatedAnswer = true;
                                                        }
                                                    
                                                    });

                            }
                        });


            //         getStatusAttempt = getStatusAttempt+1;

            //         if(getStatusAttempt == 30){
            //               this.$swal({
            //                         title:'メンバーの誰かが稼働していないか、別の色を選択しています。<br/>共同作業が鍵です。<br/>Someone is inactive or selected a different color. Coordination is the key.',
            //                         icon:'info'    
            //                         }).then(response => {
            //                 });
            //             }

                        
            //     if(playerselectedColor.length > 0){

            //             axios.post('api/game/get_status_map',{
            //                     game_event_id: codeResponse.id,
            //                     playerTeam: teamSetup.playerTeam,
            //                     player_name: teamSetup.playerName,
            //                     player_selected_color: playerselectedColor,
            //                     puzzle_number: this.puzzleNumber
            //                 }).then(response => {
            //                     if(response['data'].gameStatus){
            //                     let gameStatus = response['data'].gameStatus;
            //                     // alert(gameStatus);
            //                             if(gameStatus[0].answered_current == 1 && [0].player_number != teamSetup.playerName){
                                            
            //                                 clearInterval(getStatusInterval);
            //                                     axios.post('api/game/store_status',{
            //                                             game_event_id: teamSetup.game_event_id,
            //                                             teamNumber: teamSetup.playerTeam,
            //                                             puzzle_progress: 5,
            //                                             player_number: teamSetup.playerName
            //                                     }).then(response => {
            //                                         if(response){
            //                                             this.$swal({
            //                                                 imageUrl: '/images/correct.png',
            //                                                 width: 524,
            //                                                 height: 277,
            //                                                 imageHeight: 267,
            //                                                 background: '#ffffff20'
            //                                                         }).then(response => {
            //                                                                           if(this.puzzleNumber == 4){
            //                                                                                         this.$router.push({ name: 'tour.index'})
            //                                                                                     }
            //                                                                                     else if(this.puzzleNumber == 5){
            //                                                                                         this.$router.push({ name: 'travel_paris.index'})
            //                                                                                     }
            //                                                                 });
            //                                         }
            //                                     });
            //                             }
            //                         }
                                
            //                     if(response['data'].answered_player){
            //                         let answered_player = response['data'].answered_player;
            //                         let player_count = response['data'].player_count;
            //                         let selected_color = response['data'].selected_color;
                                    
            //                             this.answerList = response['data'].playerAnswerList;
            //                             // this.playerNoAnswer = response['data'].playerNoAnswer;


                                    

            //                             if(getStatusAttempt >= 60 && playerselectedColor.length > 0){
                                            
            //                             // alert('everyone did answer');
            //                                     getStatusAttempt = 0;
            //                                     clearInterval(getStatusInterval);
            //                                     let timerInterval;
            //                                 this.$swal({
            //                                             title: '全員が選択を完了しました。解答を検証中です。<br/>Validating the answers.',
            //                                             timer: 3000,
            //                                             timerProgressBar: true,
            //                                             allowOutsideClick:false,
            //                                             didOpen: () => {
            //                                                 this.$swal.showLoading()
            //                                                 const b = this.$swal.getHtmlContainer().querySelector('b')
            //                                                 timerInterval = setInterval(() => {
            //                                                 b.textContent =  this.$swal.getTimerLeft()
            //                                                 }, 100)
            //                                             },
            //                                             willClose: () => {
            //                                                 clearInterval(timerInterval)
            //                                             }
            //                                             }).then((result) => {
            //                                                 if(selected_color =='red' && this.validatedAnswer == false){
            //                                                         this.validatedAnswer = true;
            //                                                         correctSound.play();
            //                                                         this.$emit('pause-time');
                                                                    
            //                                                         let gameProgress = JSON.parse(localStorage.getItem('gameProgress'));


            //                                                         axios.post('api/game/store_status',{
            //                                                                     game_event_id: teamSetup.game_event_id,
            //                                                                     teamNumber: teamSetup.playerTeam,
            //                                                                     puzzle_progress: this.puzzleNumber,
            //                                                                     player_number: teamSetup.playerName
            //                                                                 }).then(response => {
                                                                                


            //                                                                     if(response){
            //                                                                         this.$swal({
            //                                             imageUrl: '/images/correct.png',
            //                                             width: 524,
            //                                             height: 277,
            //                                             imageHeight: 267,
            //                                             background: '#ffffff20'
            //                                                     }).then(response => {
            //                                                                                   if(this.puzzleNumber == 4){
            //                                                                                         this.$router.push({ name: 'tour.index'})
            //                                                                                     }
            //                                                                                     else if(this.puzzleNumber == 5){
            //                                                                                         this.$router.push({ name: 'travel_paris.index'})
            //                                                                                     }
            //                                                                         });
            //                                                                     }
            //                                                                     else{
            //                                                                         //show db error
            //                                                                         //alert('something went wrong');
            //                                                                     }
            //                                                                 });
                                                                    
            //                                                     }
            //                                                     else{
            //                                                         this.$swal({
            //                                                         imageUrl: '/images/try_again.png',
            //                                                         width: 524,
            //                                                         height: 277,
            //                                                         imageHeight: 267,
            //                                                         background: '#ffffff20'
            //                                                                 });

            //                                                         getStatusInterval = setInterval(() => this.getStatus(), 2000);
            //                                                         this.validatedAnswer = true;
            //                                                     }
            //                                             });

            //                     }
            //                     if(answered_player >= player_count && this.validatedAnswer == false )  {
            //                         // alert('everyone did answer');
            //                                   clearInterval(getStatusInterval);
            //                                   getStatusAttempt = 0;
            //                                   let timerInterval;
            //                                this.$swal({
            //                                         title: 'Validating the answers.',
            //                                         timer: 3000,
            //                                         timerProgressBar: true,
            //                                         allowOutsideClick:false,
            //                                         didOpen: () => {
            //                                             this.$swal.showLoading()
            //                                             const b = this.$swal.getHtmlContainer().querySelector('b')
            //                                             timerInterval = setInterval(() => {
            //                                             b.textContent =  this.$swal.getTimerLeft()
            //                                             }, 100)
            //                                         },
            //                                         willClose: () => {
            //                                             clearInterval(timerInterval)
            //                                         }
            //                                         }).then((result) => {
            //                                               if(selected_color =='red' && this.validatedAnswer == false){
            //                                                     this.validatedAnswer = true;
            //                                                     correctSound.play();
            //                                                     this.$emit('pause-time');
                                                                
            //                                                     let gameProgress = JSON.parse(localStorage.getItem('gameProgress'));


            //                                                     axios.post('api/game/store_status',{
            //                                                                 game_event_id: teamSetup.game_event_id,
            //                                                                 teamNumber: teamSetup.playerTeam,
            //                                                                 puzzle_progress: this.puzzleNumber,
            //                                                                 player_number: teamSetup.playerName
            //                                                             }).then(response => {
                                                                            


            //                                                                 if(response){
            //                                                                     this.$swal({
            //                                         imageUrl: '/images/correct.png',
            //                                         width: 524,
            //                                         height: 277,
            //                                         imageHeight: 267,
            //                                         background: '#ffffff20'
            //                                                 }).then(response => {
            //                                                                         if(this.puzzleNumber == 4){
            //                                                                             this.$router.push({ name: 'tour.index'})
            //                                                                         }
            //                                                                         else if(this.puzzleNumber == 5){
            //                                                                             this.$router.push({ name: 'travel_paris.index'})
            //                                                                         }
            //                                                                     });
            //                                                                 }
            //                                                                 else{
            //                                                                     //show db error
            //                                                                     //alert('something went wrong');
            //                                                                 }
            //                                                             });
                                                                
            //                                                 }
            //                                                 else if(this.validatedAnswer == false){
            //                                                      this.$swal({
            //                                         imageUrl: '/images/try_again.png',
            //                                         width: 524,
            //                                         height: 277,
            //                                         imageHeight: 267,
            //                                         background: '#ffffff20'
            //                                                 });

            //                                                                 // getStatusAttempt = 0;
            //                                                       getStatusInterval = setInterval(() => this.getStatus(), 2000);
            //                                                     this.validatedAnswer = true;

                                                                            



            //                                                 }
            //                                         });
                                  
            //                     }
            //                 }
            //             }).catch(error => {
            //                console.log(error);
            //             });
            //     }
                 
            },
            selectColor2(color){
                // console.log(color)
                getStatusAttempt = 0;
                let swal_title = '';
                // clearInterval(getStatusInterval);
                        playerselectedColor = color;
                        if(playerselectedColor =='green'){
                            this.greenSelected = true;
                            this.orangeSelected = false;
                            this.redSelected = false;
                            this.blueSelected = false;
                            swal_title = '[Street Art Walking Tour] を選択しました。<br/>You selected the Street Art Walking Tour.'
                            
                        }
                        else if(playerselectedColor =='brown'){
                            this.greenSelected = false;
                            this.orangeSelected = true;
                            this.redSelected = false;
                            this.blueSelected = false;
                            swal_title = '[Literary Walking Tour] を選択しました。<br/>You selected the Literary Walking Tour.'
                            
                        }
                        else if(playerselectedColor == 'red'){
                            this.greenSelected = false;
                            this.orangeSelected = false;
                            this.redSelected = true;
                            this.blueSelected = false;
                            swal_title = '[Photo Spot Tour] を選択しました。<br/>You selected the Photo Spot Tour.'
                        }
                        else{
                            this.greenSelected = false;
                            this.orangeSelected = false;
                            this.redSelected = false;
                            this.blueSelected = true;
                            swal_title = '[Wine Tasting Tour] を選択しました。<br/>You selected the Wine Tasting Tour.'
                        }


                            axios.post('api/game/submit_color_map',{
                                            game_event_id: teamSetup.game_event_id,
                                            team_number: teamSetup.playerTeam,
                                            selected_color: color,
                                            player_name: teamSetup.playerName
                                        }).then(response => {
                                            console.log(response);

                                            if(response){
                                                this.$swal({
                                                        title:swal_title,
                                                        html: "メンバー全員が同じボタンを選択すると、解答が検証されます。<br/>Once all members of your team enter the same button, your answer will be validated.",
                                                        
                                                        // icon:'warning',
                                                    }).then((result) =>{
                                                    
                                                    });
                                            }
                                            else{
                                                //show db error
                                                //alert('something went wrong');
                                            }
                                        });

                        
                            // document.querySelector(".selectedColor").style.backgroundColor =color;
                            // this.selectedColorShown= true;
                            this.validatedAnswer = false;
                            //  getStatusInterval = setInterval(() => this.getStatus(), 2000);
                    
            },
            onButtonClicked(e){
                if(e == this.correctAnswer){
                    this.isCorrect = true;
                        correctSound.play();
                        this.$emit('pause-time');

                        let gameProgress = JSON.parse(localStorage.getItem('gameProgress'));

                            axios.post('api/game/store_status',{
                                    game_event_id: teamSetup.game_event_id,
                                    teamNumber: teamSetup.playerTeam,
                                    puzzle_progress: this.puzzleNumber,
                                    player_number: teamSetup.playerName
                                }).then(response => {
                                    console.log(response);
                                    


                                    if(response){
                                        this.$swal({
                                                    imageUrl: '/images/correct.png',
                                                    width: 524,
                                                    height: 277,
                                                    imageHeight: 267,
                                                    background: '#ffffff20'
                                                            }).then(response => {
                                                    if(this.puzzleNumber == 2){
                                                        this.$router.push({ name: 'demo.index' })
                                                    }
                                                    else if(this.puzzleNumber == 4){
                                                        this.$router.push({ name: 'tour.index'})
                                                    }
                                                    else if(this.puzzleNumber == 5){
                                                         this.$router.push({ name: 'travel_paris.index'})
                                                    }
                                                    else{
                                                        this.$router.push({ name: 'archive.index' })
                                                    }
                                        });
                                    }
                                    else{
                                        //show db error
                                        //alert('something went wrong');
                                    }
                                });
                }
                else{
                       this.$swal({
                                                    imageUrl: '/images/try_again.png',
                                                    width: 524,
                                                    height: 277,
                                                    imageHeight: 267,
                                                    background: '#ffffff20'
                                                            });
                        this.isCorrect = false;
                }
            },
           showSingle() {
        this.imgs = 'http://via.placeholder.com/350x150'
        // or
        this.imgs = {
          title: 'this is a placeholder',
          src: 'http://via.placeholder.com/350x150'
        }
        this.show()
      },
      showMultiple() {
        this.showLanguageButton= false;
        if(this.puzzleNumber == 1){
            this.imgs = en_floor_image;
        }
        else if(this.puzzleNumber == 4){
            this.imgs = en_map_images;
        }
        else if(this.puzzleNumber == 5){
            this.imgs = en_color_iamges;
        }
        else{
            this.imgs =jp_manual
        }

        this.index = 0 // index of imgList
        this.show()
      },
      showMultiple2() {
        this.showLanguageButton= false;
        if(this.puzzleNumber == 1){
            this.imgs = en_floor_image
        }
        else if(this.puzzleNumber == 4){
            this.imgs = en_map_images;
        }
        else{
            this.imgs =en_manual
        }

        this.index = 0 // index of imgList
        this.show()
      },
      show() {
        this.visible = true
      },
      handleHide() {
          
        this.showLanguageButton= false;
        this.visible = false
      }
        }
}





</script>


<style scoped>

    option{
        background: black;
    }

    .map1_icon_x{
        height: 30px;
        width: 30px;
    }
    .form_container{
        border-radius: 5%;
        margin-left: 20px;
        width: 100%;
        display: none;
        flex-wrap: wrap;
        flex-direction: column;
        justify-content: start;
        align-content: center;
        font-size: 1.5rem;
        font-weight: bold;
        gap: 5px;
        font-family: CA-Geheimagent;

    }

    .form_input{
        display: flex;
        height: 90%;
        width: 100%;
        flex-direction: row;
        background-image: url('../assets/map1_answer_box.png');
        justify-content: center;
        align-content: center;
        flex-wrap: wrap;
        background-repeat: no-repeat;
        background-position: center;
        bottom: 10px;
        min-height: 480px;
    }

    .form_action{
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-content: center;
        margin-top: 10px;
    }

    .form_submit{
        font-size: 1.5rem;
        font-weight: bold;
        color: black;
        border-radius: 5px;
        font-family: CA-Geheimagent;

    }
    
    .form_select{
        bottom: 10px;
        background: rgba(255, 255, 255, 0);
        width: 35px;
        height: 45px;
        text-align: center;
        font-size: 1.5rem;
        font-weight: bold;
        font-family: CA-Geheimagent;
        text-indent: 1px;
        -webkit-appearance: none;
        color: white;
        margin-top: 390px;
        -moz-appearance: none;
        cursor: pointer;
        margin-left: 2px;
        border: none;
    }

    
    
    .form_label{
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-content: center;
    }

    .right_panel{
        position: relative;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        width: 10vw;
    }

    .right_panel_wider{
        position: relative;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        width: 20vw;
    }
    .element_holder{
        position: relative;
        display: flex;
        flex-direction: column;
        flex-wrap: wrap;
        height: 100%;
        width: 100%;
    }

    
    .manual_div{
        display: flex;
        position: relative;
        width: 100%;
        flex-grow: 1;
        /* border-style: solid; */
    }
    
    .desk{
        border-radius: 10px;
        width: 95%;
        height: 100%;
        object-fit: cover;
    }


    .actions2{
        position: relative;
        display: flex;
        width: 87%;
        flex-grow: 1;
        display: none;
    }


    .answer{
        font-size: 3vw;
        width: 100%;
        background: transparent;
        background-size: 100%;
        background-repeat: no-repeat;
        background-position: center;
        border:none;
        outline: none;
        color: greenyellow;
        text-transform:uppercase;
        font-weight: bold;
        padding-left: 26.5%;
        padding-right: 42%;
        background-image: url('../assets/circuit_board_red.png');
        font-family: 'VT323', monospace;
    }

    .answer.correct{
        background-image: url('../assets/circuit_board_green.png');
    }



    .language_buttons{
        display: flex;
        position: fixed;
        overflow: hidden;
        left: 50%;
        transform: translate(-50%);
        bottom: 46px;
        flex-wrap: wrap;
        z-index: 99999999;
        padding: 0;
        gap: 10px;
    }



    
      .float3{
        max-height: 40px;
        max-width: 40px;
        width:auto;
        height:auto;
        object-fit: cover;
        border-radius:50px;
        text-align:center;
        visibility: hidden;
        margin-right: 2px;
    }


    .actions3{
        position: relative;
        display: flex;
        width: 87%;
        flex-grow: 1;
        flex-wrap: wrap;
        justify-content: center;
        display: none;
        gap: 30px;
        height: 20vh;
    }

     .btnBoxes{
        display: flex;
        text-align: center;
        justify-content: center;
        align-items: center;
        width: 7rem;
        height: 7rem;
        border-radius: 10%;
        font-size: 1.5rem;
        font-weight: bold;
        font-family: CA-Geheimagent;
        cursor: pointer;
    }

    .btnBoxes.blue{
        background: url('../assets/icon_blue.png');
        background-size: cover;
    }

    .btnBoxes.blue:hover {     
        background-color: #0D47A1;
    }

    .btnBoxes.red{
        background: url('../assets/icon_red.png');
        background-size: cover;
    }

    .btnBoxes.red:hover{
        background-color: #B71C1C;
    }

    .btnBoxes.green{
        background: url('../assets/icon_green.png');
        background-size: cover;
    }

    .btnBoxes.green:hover{
        background-color: #1B5E20;
    }

    .btnBoxes.yellow{
        background: url('../assets/icon_brown.png');
        background-size: cover;
    }

    .btnBoxes.yellow:hover{
        background-color: #3E2723;
    }

    .selected_color{
        height: 20px; width: 20px; border-radius: 5px; background: lightgray;
    }

    .red_bg{
        background:#990000;
    }

    .blue_bg{
        background:#29aae1;
    }
    .green_bg{
        background:#39b44a;
    }
    .brown_bg{
        background:#8b6239;
    }

    .player_selected_colors{
        flex-grow: 1;
        /* margin-left: 20px; */
        margin-top: 30px;
        display: flex;
        flex-wrap: wrap;
        flex-direction: column;
        gap: 5px;
        justify-content: start;
        align-content: center;
        font-family: 'VT323', monospace;
        font-weight: bold;
        display: none;
        font-size: 1vw;
    }

    .appear{
        visibility: visible;
        display: flex;
    }

   

    .player_color{
        display: flex;
        align-content: center;
        gap: 20px;
    }
   


  
     @media only screen and (max-width: 1024px) {
         .actions2{
                width: 50vw;
         }

         .right_panel{
             width: 50vw;
         }
    }



/* 
     @media only screen and (max-width: 1921px) {
         .manual_div{
             height: 70%;
         }
    }





    @media only screen and (max-width: 1600px) {
         .manual_div{
             height: 80%;
         }
    }

     @media only screen and (max-width: 1400px) {
         .manual_div{
             height: 70%;
         }
    } */

</style>