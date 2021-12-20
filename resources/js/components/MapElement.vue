<template>
<!-- <div></div> -->
    <div class="right_panel"  >
        <div class="element_holder">
            <div class="manual_div">
                <!-- <img class="desk" src="../assets/bulletin_board.png"  /> -->
                <!-- <img class="desk" v-bind:src="img"  /> -->
                <div  :class="[puzzleNumber == 4 ? 'appear' : '' , 'form_container']">
                    <div class="form_input">
                        <div class="form_label" > <img class="map1_icon_x"  src="../assets/map_icon_circle.png" /> </div>
                        <div class="form_select" style="text-align: center; line-height: 60px; ">A</div>
                        <div class="form_select" style="text-align: center; line-height: 60px;">2</div>
                    </div>
                    <div class="form_input">
                        <div class="form_label"> <img class="map1_icon_x"  src="../assets/map_icon_x.png" /> </div>
                        <select v-model="xSelected" class="form_select" required>
                            <option value=""></option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                            <option value="E">E</option>
                            <option value="F">F</option>
                            <option value="G">G</option>
                        </select>
                         <select  v-model="ySelected" class="form_select" required>
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
                    <div class="form_action">
                        <button  @click="validateAnswer()" class="form_submit">Submit</button>
                    </div>
                </div>

                
                <div :class="[puzzleNumber == 5 ? 'appear' : '' , 'actions3']" >
                    <div class="btnBoxes blue" @click="onButtonClicked('blue')"></div>
                    <div class="btnBoxes green" @click="onButtonClicked('green')"></div>
                    <div class="btnBoxes yellow" @click="onButtonClicked('yellow')"></div>
                    <div class="btnBoxes red" @click="onButtonClicked('red')"></div>

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
            ySelected: ''
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
            validateAnswer(){
                // alert(this.xSelected+' '+this.ySelected);
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

    .map1_icon_x{
        height: 30px;
        width: 30px;
    }
    .form_container{
        height: 220px;
        width: 200px;
        background: #FFFFFFB3;
        border-radius: 5%;
        display: none;
        flex-wrap: wrap;
        flex-direction: column;
        justify-content: center;
        align-content: center;
        font-size: 1.5rem;
        font-weight: bold;
        color: black;
        gap: 5px;
        font-family: CA-Geheimagent;

    }

    .form_input{
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-content: center;
        gap: 5px;
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
        width: 40px;
        height: 60px;
        text-align: center;
        font-size: 1.5rem;
        font-weight: bold;
        font-family: CA-Geheimagent;
        text-indent: 1px;
        background: black;
        -webkit-appearance: none;
        color: white;
        -moz-appearance: none;
        cursor: pointer;
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
        width: 15vw;
        max-width: 15vw;
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
        height: 40vh;
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