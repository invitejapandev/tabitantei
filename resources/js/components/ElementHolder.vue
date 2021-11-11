<template>
    <div class="element_holder"  >
        <div class="elements" @click="showMultiple()"><img class="desk" src="../assets/desk.png"  style="width: 100%; height: 100%; border-radius:5px "/></div>
        <div class="actions">
            <input :class="[isCorrect ? 'correct' : '' , 'answer']" type="text" placeholder="TYPE HERE" style="z-index: 1" @input="onInput" maxlength="8"/>
            <!-- <img src="../assets/circuit_board.png" style="width: 50%; heigth: 50%; position: absolute;"/> -->
        </div>
        <div class="language_buttons">
             <a href="#" :class="[showLanguageButton ? 'appear' : '', 'float2']" @click="showMultiple()">
            <img src="../assets/japan.png" style="width: 60px; height: 60px; 
            border-radius:70px;
                object-fit: cover;"/>
                </a>

                <a href="#" :class="[showLanguageButton ? 'appear' : '', 'float3']" @click="showMultiple2()">
                    <img src="../assets/english.png" style="width: 100%; height: 100%; 
            border-radius:70px;
                object-fit: cover;"/>
                </a>
        </div>
       
     <vue-easy-lightbox
      scrollDisabled
      escDisabled
      moveDisabled
      :visible="visible"
      :imgs="imgs"
      :index="index"
      @hide="handleHide"
    ></vue-easy-lightbox>
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
            correctAnswer: 'premier',
            imgs: '', // Img Url , string or Array of string
            visible: false,
            index: 0, // default: 0,
            showLanguageButton: false
        }
    },
    methods: {
            onInput(e){
                    keystrokeSound.play();
                    console.log(e.target.value);
                    if(e.target.value == this.correctAnswer){
                        this.isCorrect = true;
                        correctSound.play();
                        this.$emit('pause-time');
                           this.$swal({
                                title:'Great! That is the correct answer!',
                                icon:'success'    
                                        });
                    }
                    else{
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
        this.imgs =jp_manual

        this.index = 0 // index of imgList
        this.show()
      },
      showMultiple2() {
        this.showLanguageButton= true;
        this.imgs = en_manual

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
@import url('https://fonts.googleapis.com/css2?family=VT323&display=swap');

    .language_buttons{
        display: flex;
        position: absolute;
        overflow: hidden;
        left:46%;
        bottom:50px;
    flex-wrap: wrap;
    align-content: center;
    justify-content: center;
        z-index: 99999999;
        padding: 0;
        gap: 10px;
    }


    .float2{
        width:60px;
        height:60px;
        border-radius:50px;
        text-align:center;
        visibility: hidden;
        margin-right: 2px;
    }


    
      .float3{
        width:60px;
        height:60px;
        border-radius:50px;
        text-align:center;
        visibility: hidden;
    }


    .appear{
        visibility: visible;
    }




    .element_holder{
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .elements{
        width: 97%;
        height: 840px;
        height: auto;
     cursor: pointer;
    }

    .actions{
        display: flex;
        width: 100%;
        height: 30%;
        margin-bottom: 20px;
        margin-top: 10px;
        align-items: center;
        justify-content: center;
    }

    .answer{
        width: 100%;
        height: 100%;
        font-size: 5vw;
        background: transparent;
        background-repeat: no-repeat;
        background-position: center;
        background-size: 100%;
        border:none;
        outline: none;
        color: greenyellow;
        text-transform:uppercase;
        font-weight: bold;
        padding-left: 27%;
        padding-top: 0.4%;
        background-image: url('../assets/circuit_board_red.png');
        font-family: 'VT323', monospace;
    }

    .answer.correct{
        background-image: url('../assets/circuit_board_green.png');
    }


</style>