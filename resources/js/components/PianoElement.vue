<template>
<!-- <div></div> -->
    <div class="right_panel"  >
        <div class="element_holder">
            <div class="manual_div" @click="showMultiple()">
                <!-- <img class="desk" src="../assets/bulletin_board.png"  /> -->
                <img class="desk" v-bind:src="img"  />
            </div>
           
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
const piano = '/images/pianos.png';

var typingTimer;
var doneTypingInterval = 1000;
var presscount = 0;
let teamSetup;
export default{
    name:'PianoElement',
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
            img: this.elementImage
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
                                                        this.$router.push({ name: 'Piano.index' })
                                                    }
                                                    else if(this.puzzleNumber == 3){
                                                        this.$router.push({ name: 'mayu_palais.index'})
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
                                title:`That is not the correct answer. Please try again.`,
                                icon:'error'    
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
        
        this.imgs = piano;

        this.index = 0 // index of imgList
        this.show()
      },
      showMultiple2() {
        this.showLanguageButton= false;
        this.imgs = piano;

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

    .right_panel{
        position: relative;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        width: 30vw;
        height: 75vh;
    }

    .element_holder{
        position: relative;
        display: flex;
        flex-direction: column;
        flex-wrap: wrap;
        height: 40vh;
        width: 100%;
    }

    
    .manual_div{
        display: flex;
        position: relative;
        cursor: pointer;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 40vh;
        flex-grow: 1;
        /* border-style: solid; */
    }
    
    .desk{
        border-radius: 10px;
        width: 95%;
        height: 40vh;
        object-fit: cover;
    }


    .actions2{
        position: relative;
        display: flex;
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


    .appear{
        visibility: visible;
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