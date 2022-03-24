<template>
<!-- <div></div> -->
    <div class="right_panel"  >
        <div class="element_holder">
            <div class="manual_div" >
                <!-- <img class="desk" src="../assets/bulletin_board.png"  /> -->
                <div class="desk v-step-0 v-step-1">
                    <iframe class="responsive" style="z-index: -1 !important" :src="iframe.src" frameBorder="0" scrolling="no" allowFullScreen></iframe>
                </div>
                 <transition name="fade">
                    <div class="newcard"  v-if="coverShowned" @click="hideImage">
                                    <img class="cover_image"  v-bind:src="this.imgCover" @click="hideImage" v-if="coverShowned" />
                    </div>
                </transition>
            </div>
            <div class="actions2 v-step-8" >
                <input v-if="puzzleNumber == 2" :class="[isCorrect ? 'correct' : '' , 'answer']" type="text" placeholder="TYPE HERE" style="z-index: 1" v-on:keyup.enter="onEnter" />
                <input v-if="puzzleNumber == 8" class="answer cafe_answer" type="text" placeholder="TYPE HERE" style="z-index: 1" v-on:keyup.enter="onEnter" @input="onInput" />
                <input v-if="puzzleNumber == 1" :class="[isCorrect ? 'norman_answer_correct' : 'norman_answer' , 'answer']" type="text" placeholder="TYPE HERE" style="z-index: 1" v-on:keyup.enter="onEnter" @input="onInput" />
            </div>
        </div>
       
       
       <div class="btnCard"></div>


    </div>

     <div class="language_buttons2">
           
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

const cafe_img = '/images/cafe_english.png';
const cafe_imgs = [cafe_img];

const cafe_img_j ='/images/cafe_japanese.png';
const cafe_imgs_j = [cafe_img_j];

var typingTimer;
var doneTypingInterval = 1000;
var presscount = 0;
let teamSetup;
export default{
    name:'ElementHolder',
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
            coverShowned: this.isShowned,
            asd: false,
                iframe:{
                    src: this.miroURL,
                    style: null,
                    wrapperStyle: null
                },
            imgCover: '/images/comp_817.png'
        }
    },
    props:{
        elementImage: String,
        answer: String,
        puzzleNumber: Number,
        miroURL: String,
        isShowned: Boolean
    },
        watch: {
            miroURL: function(val){
                this.iframe.src = val;
            }
        },
    beforeCreate(){
        teamSetup = JSON.parse(localStorage.getItem('teamSetup'));
    },
    methods: {
            onInput(e){
                    keystrokeSound.play();
                    console.log(e.target.value);
                    if(e.target.value.toLowerCase().indexOf(this.correctAnswer) >= 0){
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
                                    


                                    if(response){
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
                                                    else if(this.puzzleNumber == 6){
                                                        this.$router.push({name: 'semaphore_completed.index'})
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
            onEnter(e){
                 keystrokeSound.play();
                    console.log(e.target.value);
                    if(e.target.value.toLowerCase().indexOf(this.correctAnswer) >= 0){
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
                                                        this.$router.push({ name: 'computer_on.index' })
                                                    }
                                                    else if(this.puzzleNumber == 3){
                                                        this.$router.push({ name: 'MapText.index'})
                                                    }
                                                    else if(this.puzzleNumber === 8){
                                                        this.$router.push({name: 'cafe_completed.index'})
                                                    }
                                                    else if(this.puzzleNumber == 6){
                                                        this.$router.push({name: 'semaphore_completed.index'})
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
        this.showLanguageButton= true;
        if(this.puzzleNumber == 1){
            this.imgs = en_floor_image;
        }
        else if(this.puzzleNumber === 8){
            this.imgs = cafe_imgs;
        }
        else{
            this.imgs =en_manual
        }

        this.index = 0 // index of imgList
        this.show()
      },
      showMultiple2() {
        this.showLanguageButton= true;
        if(this.puzzleNumber == 1){
            this.imgs = en_floor_image
        }
        else if(this.puzzleNumber === 8){
            this.imgs = cafe_imgs_j;
        }
        else{
            this.imgs =jp_manual
        }

        this.index = 0 // index of imgList
        this.show()
      },
            hideImage(){
            //    alert('test');
            this.coverShowned = false;
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
        justify-content: center;
        align-content: center;
        flex-wrap: wrap;
        height: 100%;
        width: 100%;
    }

    
    .manual_div{
        display: flex;
        position: relative;
        cursor: pointer;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 50vh;
        flex-grow: 1;
        /* border-style: solid; */
    }
    
    .desk{
        border-radius: 10px;
        width: 95%;
        height: 100%;
        object-fit: cover;
    }

    .responsive{
        border-radius: 10px;
        width: 100%;
        height: 100%;
    }
    


    .actions2{
        position: relative;
        display: flex;
        justify-content: center;
        width: 87%;
        flex-grow: 1;
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
        padding-left: 20%;
        padding-right: 42%;
        background-image: url('../assets/circuit_board_red.png');
        font-family: 'VT323', monospace;
    }

    .answer.correct{
        background-image: url('../assets/circuit_board_green.png');
    }

    .cafe_answer{
        background-image: url('../assets/cafe_answerbox_645.png');
        padding-top: 7%;
        padding-left: 57%;
        padding-right: 0%;
        color: black;
        font-size: 2.5vw;
        font-weight: normal;

    }

    .norman_answer{
        font-size: 2vw;
        background-image: url('../assets/norman_chat_2.png');
        padding-left: 48%;
        padding-right: 0%;
        color: black;

    }

    .norman_answer_correct{
        font-size: 2vw;
        background-image: url('../assets/norman_chat_2.png');
        padding-left: 48%;
        padding-right: 0%;
        color: black;

    }



    .language_buttons2{
        display: flex;
        position: fixed;
        overflow: hidden;
        left: 50%;
        transform: translate(-50%);
        bottom: 46px;
        flex-wrap: wrap;
        z-index: 0;
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


    .appear{
        visibility: visible;
    }


    .cover_image{
        position: absolute;
        width: 97%;
        height: 100%;
        z-index:100;
        padding:0; 
        margin: 0;
        border-radius: 10px;
        object-fit: cover;
    }



    .newcard{
        /* position: relative; */
        /* background-color: pink; */
        position: absolute;
        display: flex;
        width: 98%;
        height: 100%;
        z-index: 99;
        justify-content: center;
        cursor: pointer;
    }

   
    .fade-enter-active, .fade-leave-active {
        transition: opacity 5s;
    }

    .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
        opacity: 0;
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

.v-tour__target--highlighted {
  box-shadow: 0 0 0 99999px rgba(0,0,0,.4);
}


</style>