<template>
<!-- <div></div> -->
    <div class="right_panel"  >
        <div class="element_holder">
            <div class="manual_div" @click="showMultiple()">
                <!-- <img class="desk" src="../assets/bulletin_board.png"  /> -->
                <img class="desk" v-bind:src="img"  />
            </div>
            <div :class="[puzzleNumber == 4 ? 'appear' : '' , 'actions2']" >
                <input :class="[isCorrect ? 'correct' : '' , 'answer']" type="text" placeholder="TYPE HERE" style="z-index: 1" v-on:keyup.enter="onEnter" @input="onInput" />
        
            </div>

            <div :class="[puzzleNumber == 5 ? 'appear' : '' , 'actions3']" >
                <div class="btnBoxes blue" @click="onButtonClicked('blue')">Wine Testing</div>
                <div class="btnBoxes green" @click="onButtonClicked('green')">Street Art Walking</div>
                <div class="btnBoxes yellow" @click="onButtonClicked('yellow')">Literary Walking</div>
                <div class="btnBoxes red" @click="onButtonClicked('red')">Photo Spot</div>

            </div>

            <div :class="[puzzleNumber == 9 ? 'appear' : '' , 'actions4']" >
                <div class="arrow_button" >
                    <div class="circle arrow"></div>
                        <div class="crossCenter">
                        <div class="crossTop" @click="updateLetter(1)"><i class="arrow up"></i></div>
                        <div class="crossBottom" @click="updateLetter(4)"><i class="arrow down"></i></div>
                        <div class="crossLeft" @click="updateLetter(2)"><i class="arrow left"></i></div>
                        <div class="crossRight" @click="updateLetter(3)"><i class="arrow right"></i></div>
                        <div class="crossCircle" @click="updateLetter(5)">C</div>
                    </div>
                </div>
                <div class="arrow_output">

                    <div v-for="n in lettersFinal" :key="n" class="text_output">{{n}}</div>
                </div>
            </div>
        </div>
       
       
       <div class="btnCard"></div>
     <vue-easy-lightbox
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

var keystrokeSound = new Audio('https://dl.dropboxusercontent.com/s/hjx4xlxyx39uzv7/18660_1464810669.mp3');
var correctSound = new Audio('https://www.freesoundslibrary.com/wp-content/uploads/2018/03/right-answer-ding-ding-sound-effect.mp3');
            var interval,  newInterval;
var clickSound = new Audio('/images/button_click.mp3');
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

const g_3 = '/images/g_1.png';
const g_2 = '/images/g_2.png';
const g_1 = '/images/g_3.png';
const g_4 = '/images/g_4.png';


let arrowIndex = 0;
let arrowUp = ['P', 'H', 'A', 'E', 'T', 'T'];
let arrowLeft = ['S', 'O', 'R', 'R', 'L', 'G'];
let arrowRight = ['T', 'E', 'I', 'I', 'N', 'S'];
let arrowDown = ['M', 'A', 'V', 'N', 'A', 'Y'];
const g_images = [g_1, g_2, g_3, g_4];
let answer = '';

const en_color_iamges = [blue_image, yellow_image, green_image, red_image];

var typingTimer;
var doneTypingInterval = 1000;
var presscount = 0;
let teamSetup;
export default{
    name:'GraffitiElement',
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
            lettersFinal:  [],
            firstLetter: '',
            secondLetter: '',
            thirdLetter: '',
            fourthLetter: '',
            fifthLetter: '',
            sixthLetter: '',
        }
    },
    props:{
        elementImage: String,
        answer: String,
        puzzleNumber: Number
    },
    beforeCreate(){
        teamSetup = JSON.parse(localStorage.getItem('teamSetup'));
    },
    methods: {
            updateLetter(arrowPressed){
                // let arraySet = [this.firstLetter, this.secondLetter];
                    // clickSound.play();
                if(arrowIndex<6){
                    if(arrowPressed == 1){
                        this.lettersFinal[arrowIndex] = arrowUp[arrowIndex];
                        answer = answer+''+arrowUp[arrowIndex];
                        arrowIndex +=1;
                    }
                    else if(arrowPressed == 2){
                        this.lettersFinal[arrowIndex] = arrowLeft[arrowIndex];
                        answer = answer+''+arrowLeft[arrowIndex];
                        arrowIndex +=1;
                    }
                    else if(arrowPressed == 3){
                        this.lettersFinal[arrowIndex] = arrowRight[arrowIndex];
                        answer = answer+''+arrowRight[arrowIndex];
                        arrowIndex +=1;
                    }
                    else if(arrowPressed == 4){
                        this.lettersFinal[arrowIndex] = arrowDown[arrowIndex];
                        answer = answer+''+arrowDown[arrowIndex];
                        arrowIndex +=1;
                    }
                    else if(arrowPressed == 5){
                        this.$swal({
                                title:'Are you sure you want to clear the answers?',
                                // icon:'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: "Yes"
                            }).then((result) =>{
                            if (result.isConfirmed) {
                                
                                arrowIndex=0;
                                this.lettersFinal =[];
                                answer = '';
                            }
                            });
                    }

                    // alert(answer);
                    
                    if(answer=='PEARLS'){
                        correctSound.play();
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
                                                    
                                                         this.$router.push({ name: 'graffiti_completed.index'})
                                        });
                                    }
                                    else{
                                        //show db error
                                        //alert('something went wrong');
                                    }
                                });
                    }
                    else if(arrowIndex == 6){
                       this.$swal({
                                                    imageUrl: '/images/try_again.png',
                                                    width: 524,
                                                    height: 277,
                                                    imageHeight: 267,
                                                    background: '#ffffff20'
                                                            });
                    }
                }
                else{
                    if(arrowPressed == 5){
                        this.$swal({
                                title:'Are you sure you want to clear the answers?',
                                // icon:'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: "Yes"
                            }).then((result) =>{
                            if (result.isConfirmed) {
                                
                                arrowIndex=0;
                                this.lettersFinal =[];
                                answer = '';
                            }
                            });
                    }
                    else if(answer=='PEARLS'){
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
                                                    
                                                         this.$router.push({ name: 'graffiti_completed.index'})
                                        });
                                    }
                                    else{
                                        //show db error
                                        //alert('something went wrong');
                                    }
                                });
                    }
                    else if(arrowIndex == 6){
                        this.$swal({
                                                    imageUrl: '/images/try_again.png',
                                                    width: 524,
                                                    height: 277,
                                                    imageHeight: 267,
                                                    background: '#ffffff20'
                                                            });
                    }
                    // validate_answer;
                }
            },
            onInput(e){
                    keystrokeSound.play();
                    console.log(e.target.value);
                    if(e.target.value.includes(this.correctAnswer)){
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
                                                        this.$router.push({ name: 'MapTextPartThree.index'})
                                                    }
                                                    else if(this.puzzleNumber == 5){
                                                         this.$router.push({ name: 'ParisText.index'})
                                                    }
                                                    else if(this.puzzleNumber == 9){
                                                         this.$router.push({ name: 'graffiti_completed.index'})
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
                        this.isCorrect = false;
                    }
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
                                                        this.$router.push({ name: 'MapTextPartThree.index'})
                                                    }
                                                    else if(this.puzzleNumber == 5){
                                                         this.$router.push({ name: 'ParisText.index'})
                                                    }
                                                    else if(this.puzzleNumber == 9){
                                                         this.$router.push({ name: 'graffiti_completed.index'})
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
            onEnter(e){
                 keystrokeSound.play();
                    console.log(e.target.value);
                    if(e.target.value.toLowerCase().indexOf(this.correctAnswer) > 0){
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
                                                        this.$router.push({ name: 'MapTextPartThree.index'})
                                                    }
                                                    else if(this.puzzleNumber == 5){
                                                         this.$router.push({ name: 'ParisText.index'})
                                                    }
                                                    else if(this.puzzleNumber == 9){
                                                         this.$router.push({ name: 'graffiti_completed.index'})
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
        this.imgs = g_images;

        this.index = 0 // index of imgList
        this.show()
      },
      showMultiple2() {
        this.showLanguageButton= false;
        this.imgs = g_images;

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

.arrow_output{
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-content: center;
    width: 80%;
    gap: 20px;
}

.text_output{
    color: black;
    background-color: white;
    font-size: 6vw;
    font-weight: bold;
    padding-left: 20px;
    padding-right: 20px;
    padding-top: 5px;
    padding-bottom: 5px;
    margin-top: 20px;
    margin-left: 30px;
    font-family: CA-Geheimagent;
}

.arrow {
  border: solid white;
  border-width: 0 3px 3px 0;
  display: inline-block;
  padding: 3px;
}

.right {
  transform: rotate(-45deg);
  -webkit-transform: rotate(-45deg);
}

.left {
  transform: rotate(135deg);
  -webkit-transform: rotate(135deg);
}

.up {
  transform: rotate(-135deg);
  -webkit-transform: rotate(-135deg);
}

.down {
  transform: rotate(45deg);
  -webkit-transform: rotate(45deg);
}

body{
  background-color: #FEFEFE;
}

.controller{
  margin-top: 100px;
  height: 200px;
  width: 400px;
  background-color: #E6E6E6;
  position: relative;
  box-shadow: 15px 15px 15px rgba(0,0,0,0.2);
}

.controllerLeft{
  height: 250px;
  width: 250px;
  background-color: #E6E6E6;
  position: absolute;
  border-radius: 100%;
  margin-left: -125px;
  box-shadow: -15px 8px 15px rgba(0,0,0,0.2);
}

.controllerRight{
  height: 250px;
  width: 250px;
  background-color: #B8B8B8;
  position: relative;
  border-radius: 100%;
  margin-right: -125px;
  border: solid 15px rgba(230, 230, 230,1);
  box-shadow: 15px 8px 15px rgba(0,0,0,0.2);
}

.circle{
  height: 120px;
  width: 120px;
  background-color: #E6E6E6;
  position: absolute;
  border-radius: 100%;
  border: solid 5px rgba(184, 184, 184, 1);
  margin-left: 42px;
  margin-top: 0px;
  display: flex;
  justify-content: center;
  align-content: center;
}

.crossCenter{
  background-color: #333333;
  width: 35px;
  height: 35px;
  margin-top: 50px;
  margin-left: 95px;
  position: relative;
  text-align: center;
  line-height: 35px;
  cursor: pointer;
pointer-events: auto;
}

.crossCircle{
  background-color: #292929;
  width: 25px;
  height: 25px;
  position: absolute;
  border-radius: 100%;
  margin-top: 5px;
  margin-left: 5px;
  text-align: center;
  font-weight: bold;
  line-height: 25px;
  cursor: pointer;
pointer-events: auto;
}

.crossTop{
  background-color: #333333;
  width: 35px;
  line-height: 35px;
  position: absolute;
  border-radius: 15%;
  margin-top: -30px;
}

.crossBottom{
  background-color: #333333;
  width: 35px;
  height: 35px;
  position: absolute;
  border-radius: 15%;
  margin-top: 30px;
  cursor: pointer;
pointer-events: auto;
  text-align: center;
  line-height: 35px;
}

.crossLeft{
  background-color: #333333;
  width: 35px;
  line-height: 35px;
  position: absolute;
  border-radius: 15%;
  margin-left: -30px;
  cursor: pointer;
pointer-events: auto;
  text-align: center;
  height: 35px;
}

.crossRight{
  background-color: #333333;
  width: 35px;
  line-height: 35px;
  position: absolute;
  border-radius: 15%;
  margin-left: 30px;
  text-align: center;
  height: 35px;
  cursor: pointer;
pointer-events: auto;
}

.centerBlue{
  position: absolute;
  width: 50px;
  height: 20px;
  margin-left: 175px;
  cursor: pointer;
pointer-events: auto;
  margin-top: 30px;
  background-color: #0099FF;
}

.centerLeft{
  position: absolute;
  width: 20px;
  height: 20px;
  margin-left: -10px;
  margin-top: 0px;
  background-color: #0099FF;
  border-radius: 100%;
}

.centerRight{
  position: absolute;
  width: 20px;
  height: 20px;
  margin-left: 40px;
  margin-top: 0px;
  background-color: #0099FF;
  border-radius: 100%;
}

.backButton1Center{
  position: absolute;
  width: 80px;
  height: 50px;
  background-color: #E6E6E6;
  -webkit-transform: rotate(-30deg);
  margin-top: 60px;
  margin-left: 45px;
}

.backButton2Center{
  position: absolute;
  width: 80px;
  height: 50px;
  background-color: #E6E6E6;
  -webkit-transform: rotate(-30deg);
  margin-top: 115px;
  margin-left: 90px;
}

.cornerLeft1{
  position: absolute;
  width: 50px;
  height: 50px;
  background-color: #00B800;
  border-radius: 100%;
  margin-left: -20px;
  border: solid 5px rgba(230, 230, 230, 1)
}

.cornerRight1{
  position: absolute;
  width: 50px;
  height: 50px;
  background-color: #6699FF;
  border-radius: 100%;
  margin-left: 60px;
  border: solid 5px rgba(230, 230, 230, 1)
}

.cornerLeft2{
  position: absolute;
  width: 50px;
  height: 50px;
  background-color: #CFCF00;
  border-radius: 100%;
  margin-left: -20px;
  border: solid 5px rgba(230, 230, 230, 1)
}

.cornerRight2{
  position: absolute;
  width: 50px;
  height: 50px;
  background-color: #7D230D;
  border-radius: 100%;
  margin-left: 60px;
  border: solid 5px rgba(230, 230, 230, 1)
}

.centerStart{
  background-color: #B8B8B8;
  position: absolute;
  height: 35px;
  width: 10px;
  margin-left: 180px;
  margin-top: 110px;
  -webkit-transform: rotate(20deg);
}

.centerSelect{
  background-color: #B8B8B8;
  position: absolute;
  height: 35px;
  width: 10px;
  margin-left: 205px;
  margin-top: 110px;
  -webkit-transform: rotate(20deg);
}

.SLeft{
  background-color: #B8B8B8;
  position: absolute;
  border-radius: 100%;
  height: 10px;
  width: 10px;
  margin-top: 30px;
}

.SRight{
  background-color: #B8B8B8;
  position: absolute;
  border-radius: 100%;
  height: 10px;
  width: 10px;
  margin-top: -5px;
}

.cable{
  background-color: black;
  width: 10px;
  height: 150px;
  position: absolute;
  margin-left: 49.7%;
  margin-top: -100px;
  box-shadow: 7px 8px 15px rgba(0,0,0,0.2);
}


    .right_panel{
        position: relative;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        width: 60vw;
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
        cursor: pointer;
pointer-events: auto;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 40vh;
        flex-grow: 2;
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

    .actions4{
        position: relative;
        display: flex;
        width: 87%;
        flex-grow: 1;
        flex-wrap: wrap;
        display: none;
        justify-content: start;
        align-items: center;
        gap: 30px;
    }

    .actions3{
        position: relative;
        display: flex;
        width: 87%;
        flex-grow: 1;
        flex-wrap: wrap;
        display: none;
        justify-content: center;
        align-items: center;
        gap: 30px;
    }

     .btnBoxes{
        display: flex;
        justify-content: center;
        align-items: center;
        width: 10rem;
        height: 10rem;
        border-radius: 10%;
        font-size: 1.5rem;
        font-weight: bold;
        font-family: CA-Geheimagent;
        cursor: pointer;
pointer-events: auto;
    }

    .btnBoxes.blue{
        background-color: blue;
    }

    .btnBoxes.red{
        background-color: red;
    }

    .btnBoxes.green{
        background-color: green;
    }

    .btnBoxes.yellow{
        background-color: yellow;
        color: black;
    }


    .appear{
        visibility: visible;
        display: flex;
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