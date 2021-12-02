<template>
<!-- <div></div> -->
    <div :class="[shouldShowData ? '' : 'showing' , 'right_panel']"  >
        <div class="element_holder">
            <div class="manual_div"  ref="draggableContainer" >
                <!-- <img class="desk" src="../assets/bulletin_board.png"  /> -->
                <div id="mask" @mousedown="dragMouseDown" >
                    <div id="unblurred" v-bind:style="{'background-image': 'url(' + (imgData) + ')'}"><!-- <img class="desk" src="../assets/bulletin_board.png"  /> --></div>
                     <!-- v-bind:style="{ backgroundImage: 'url(' + imgData + ')' }" -->
                </div>
            </div>
           
        </div>
       <div class="closebtn" @click="hideSelf()" >X</div>
       
       <div class="btnCard"></div>
     <vue-easy-lightbox
      scrollDisabled
      moveDisabled
      :visible="visible"
      :imgs="imgs"
      :index="index"
      @hide="handleHide"
    ></vue-easy-lightbox>

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
    name:'semtest',
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
            positions: {
                clientX: undefined,
                clientY: undefined,
                movementX: 0,
                movementY: 0
            },
            shouldShowData: this.shouldShow,
            imgData: `./images/`+this.imgName+'.png'
        }
    },
    props:{
        elementImage: String,
        answer: String,
        puzzleNumber: Number,
        shouldShow: Boolean,
        imgName: String
    },
    watch: {
            shouldShow: function(val){
                // alert(val)
                this.shouldShowData = val;
            },
            imgName: function(val){
                
                this.imgData = `../images/`+val+'.png'
                // alert(this.imgData)
            }
    },
    beforeCreate(){
        teamSetup = JSON.parse(localStorage.getItem('teamSetup'));
    },
    methods: {
        dragMouseDown: function (event) {
      event.preventDefault()
      // get the mouse cursor position at startup:
      this.positions.clientX = event.clientX
      this.positions.clientY = event.clientY
      document.onmousemove = this.elementDrag
      document.onmouseup = this.closeDragElement
    },
    elementDrag: function (event) {
      event.preventDefault()
      this.positions.movementX = this.positions.clientX - event.clientX
      this.positions.movementY = this.positions.clientY - event.clientY
      this.positions.clientX = event.clientX
      this.positions.clientY = event.clientY
      // set the element's new position:
      this.$refs.draggableContainer.style.top = (this.$refs.draggableContainer.offsetTop - this.positions.movementY) + 'px'
      this.$refs.draggableContainer.style.left = (this.$refs.draggableContainer.offsetLeft - this.positions.movementX) + 'px'
    },
    hideSelf(){
        this.shouldShowData = false;
        this.$emit('hideSemtest');
    },
    closeDragElement () {
      document.onmouseup = null
      document.onmousemove = null
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
                                                    title:'Great! That is the correct answer!',
                                                    icon:'success'    
                                                            }).then(response => {
                                                    if(this.puzzleNumber == 2){
                                                        this.$router.push({ name: 'Piano.index' })
                                                    }
                                                    else if(this.puzzleNumber == 3){
                                                        this.$router.push({ name: 'MapText.index'})
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
                                                    title:'Great! That is the correct answer!',
                                                    icon:'success'    
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


        body{
            margin:0;
            height: 100%;
            background-size: cover;
            background-color: black !important;
            font-family: CA-Geheimagent;
        }

#mask {
	position: relative;
	width: 400px;
	height: 400px;
	overflow: hidden;
	position: absolute;
	top: calc(50% - 100px);
	left: calc(50% - 100px);

}

.closebtn{
    cursor: pointer; height: 30px; line-height: 30px; width: 30px; background-color: white; position: absolute; right: 0px; color: black; text-align: center; border-radius:50%; font-weight: bolder;
}

#unblurred {
	position: absolute;
	top: 0;
	left: 0;
	z-index: 999;
	width: 100%;
	height: 100%;
	overflow: hidden;
	filter: blur(0px);
	-webkit-filter: blur(0px);
	background-attachment: fixed !Important;
	background-repeat:no-repeat;
    background-position: center;
    background-image:url('../assets/top_west.png');
	background-size:60%;
	border-radius: 50%;
	cursor: move;
}


    .right_panel{
        position: absolute;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
            background-color: black !important;
        width: 100%;
        height: 100%;
        overflow: hidden;
        z-index: 999;
    }

    .showing{
        display: none;
    }

    .element_holder{
        position: absolute;
        display: flex;
        flex-direction: column;
        flex-wrap: wrap;
        height: 100%;
            background-color: black !important;
        width: 100%;
    }

    
    .manual_div{
        display: flex;
        position: relative;
        cursor: pointer;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 100%;
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