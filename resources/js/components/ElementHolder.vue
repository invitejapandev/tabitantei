<template>
<!-- <div></div> -->
    <div class="right_panel"  >
        <div class="element_holder">
            <div class="manual_div" @click="showMultiple()">
                <!-- <img class="desk" src="../assets/bulletin_board.png"  /> -->
                <img class="desk" v-bind:src="img"  />
            </div>
            <div class="actions2">
                <input :class="[isCorrect ? 'correct' : '' , 'answer']" type="text" placeholder="TYPE HERE" style="z-index: 1" v-on:keyup.enter="onEnter" @input="onInput" maxlength="8"/>
        
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

const floor1_image = '/images/floor1.png';
const floor2_image = '/images/floor2.png';
const floor3_image = '/images/floor3.png';
const floor4_image = '/images/floor4.png';

const en_floor_image = [floor1_image, floor2_image, floor3_image, floor4_image];

var typingTimer;
var doneTypingInterval = 1000;
var presscount = 0;

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
            img: this.elementImage
        }
    },
    props:{
        elementImage: String,
        answer: String,
        puzzleNumber: Number
    },
    methods: {
            onInput(e){
                    keystrokeSound.play();
                    console.log(e.target.value);
                    if(e.target.value.includes(this.correctAnswer)){
                        this.isCorrect = true;
                        correctSound.play();
                        this.$emit('pause-time');
                           this.$swal({
                                title:'Great! That is the correct answer!',
                                icon:'success'    
                                        }).then(response => {
                        // console.log(response);
                                if(this.puzzleNumber == 2){
                                    this.$router.push({ name: 'demo.index' })
                                }
                                else{
                                     this.$router.push({ name: 'archive.index' })
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
                    if(e.target.value.includes(this.correctAnswer)){
                        this.isCorrect = true;
                        correctSound.play();
                        this.$emit('pause-time');
                           this.$swal({
                                title:'Great! That is the correct answer!',
                                icon:'success'    
                                        }).then(response => {
                        // console.log(response);
                                if(this.puzzleNumber == 2){
                                    this.$router.push({ name: 'demo.index' })
                                }
                                else{
                                     this.$router.push({ name: 'archive.index' })
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
        this.showLanguageButton= true;
        if(this.puzzleNumber == 1){
            this.imgs = en_floor_image;
        }
        else{
            this.imgs =jp_manual
        }

        this.index = 0 // index of imgList
        this.show()
      },
      showMultiple2() {
        this.showLanguageButton= true;
        if(this.puzzleNumber == 1){
            this.imgs = en_floor_image
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


<style>

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
        height: 100%;
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