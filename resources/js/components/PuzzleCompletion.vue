<template>
  <div :class="[show? 'confetti': 'default', 'textHolder']">
        
         <!-- <span class="text_handler"> {{outputText}} </span> -->
         <div class="bubbleBox">
                
        
                <!-- <transition name="fade"> -->
                    <div class="cover_image_holder">
                        <video  :class="[show == false? 'appear':'','treasure_video']" @global-auto-play="autoPlay" @ended="onEnd()"  ref="videoRef" src="" ></video>
                        <img  v-if="show" class="cover_image" :src='elementImage' @click="hideImage" />   
                        <button v-if="showBtn" class="begin_btn" @click="playVid()">{{btnText}}</button>
                    </div>
                <!-- </transition> -->
         </div>
         <!-- <div class="btnHolder">
              <a v-if="prevShowned" class="btnReady" @click="prevImage()" >Prev</a>
              <a v-if="nextShowned" @click="nextImage()" class="btnReady">Next</a>
              <a v-if="buttonShown" class="btnReady" @click="gameStart(this.puzzleNumber)">Proceed</a>
         </div> -->
         
        <!-- <a v-if="buttonVisible" class="btnReady" @click="gameStart">{{ buttonText }}</a> -->
    </div>
</template>

<script>

import axios from 'axios'

let codeResponse, teamSetup;
let getStatusInterval;
let completedPuzzle = 0;

export default {
    
        name: 'PuzzleCompletion',
        data(){
            return{
                show: true,
                text1 : this.headerText,
                outputText : '',
                inc:0,
                img: this.elementImage,
                imgIndex:0,
                nextShowned: false,
                prevShowned: false,
                enterShowned: false,
                currentPuzzle: 1,
                showBtn: true,
                buttonShown: false,
                btnText: 'Click here to continue 次の問題に進む'
            }
        },
        beforeCreate(){
            codeResponse = JSON.parse(localStorage.getItem('codeResponse'));
            teamSetup = JSON.parse(localStorage.getItem('teamSetup'));
            this.currentPuzzle = this.puzzleNumber;

            //  axios.post('api/game/get_status_last_specific',{
            //             game_event_id: codeResponse.id,
            //             playerTeam: teamSetup.playerTeam
            //             }).then(response => {
            //                     //
            //                     if(response.data == 0 && this.puzzleNumber != 1){
            //                         this.$router.push({ name: 'style_secrets.index' });
            //                     }
            //                     //Create Statements to handle redirect to other puzzles.
            //             });
        },
        beforeMount(){
           
        },
        mounted(){

            this.$refs.videoRef.src  = this.elementVideo; 
            if(this.imgIndex == 0 && this.imgIndex+1<this.elementImage.length){
                this.nextShowned = true;
            }
            else{
                this.enterShowned = true;
            }
        },
        watch: {
            imgIndex: function(val){
                if(this.imgIndex == 0 || this.imgIndex+1<this.elementImage.length){
                    this.nextShowned = true;
                }
                else{
                    this.nextShowned = false;
                }

                if(this.imgIndex+1 == this.elementImage.length){
                    this.enterShowned = true;
                }
                else{
                    this.enterShowned = false;
                }
                
                if(this.imgIndex >0 ){
                    this.prevShowned = true;
                }
                else{
                    this.prevShowned = false;
                }
            }
        },
        methods:{
            onEnd(){
                // alert('the video has ended')
                this.buttonShown = true;
                   if(this.beginURL == ''){
                        this.showBtn = false;
                    }
                    else{
                        this.showBtn =true;
                    }
            },
            hideImage(){
                if(this.show ==true){
                    this.show = false;
                    this.playVid();
                }
            },
            playVid(){
                this.btnText = 'Begin 次へ';
                if(this.beginURL == ''){
                        this.showBtn = false;
                    }
                if(this.show == true){
                    this.show=false;
                    this.$refs.videoRef.play();
                    this.showBtn=false;
                }
                else{
                    
                        this.$router.push({name: this.beginURL })
                    
                    
                }
            },
            prevImage(){
                if(this.imgIndex>0){
                    this.imgIndex = this.imgIndex-1;
                }
            },
            nextImage(){
                if(this.imgIndex+1<this.elementImage.length){
                    this.imgIndex = this.imgIndex+1;
                    // alert(this.imgIndex)
                }
            },
            gameStart(val){
                if(val == 1){
                    this.$router.push({name: 'introduction.index' })
                }
                else if(val == 2){
                    this.$router.push({name: 'main.piano' })
                }
                else if(val === 3){
                    this.$router.push({name: 'sato.index' })
                }

                
            },
            outText() {

                if (this.inc < this.text1.length) {
                    this.outputText += this.text1.charAt(this.inc);
                    this.inc ++;
                    setTimeout(this.outText, 50)

                }
            }
        },
        props:{
        elementImage: String,
            headerText: String,
            buttonText: String,
            buttonVisible: Boolean,
            newLink: Boolean,
            linkData: String,
            puzzleNumber: Number,
            elementVideo: String,
            beginURL: String
        },
        components:{

        }
}
</script>

<style scoped>



 
    .fade-enter-active, .fade-leave-active {
        transition: opacity 1s;
    }

    .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
        opacity: 0;
    }


    .textHolder{
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        width: 100%;
        height: 100%;
    }
    
    .textHolder.default{

        background-image: url('../assets/main_bg.jpg') !important;
        background-size: cover;
        background-repeat: no-repeat;
    }

    .textHolder.confetti{
         background-image: url('../assets/confetti.gif') !important;
        background-size: cover;
        background-repeat: no-repeat;
    }

    .bubbleBox{
        position: relative;
        display: flex;
        width: 100vw;
        height: 100vh;
        justify-content: center;
    }

    .cover_image_holder{
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-top: 20px;
        gap: 15px;
        z-index: 10;
    }

    .cover_image{
        height: 85vh;
    }

    .begin_btn{
        height: 39px;
        font-family: 'Covered By Your Grace', cursive;
        color: white;
        background-color: #12cdd4;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-weight: bold;
        font-size: 1.2em;
        padding-left: 5px !important;
        padding-right: 5px;
        padding-top: 5px;
        padding-bottom: 5px;
    }
    
    button:active{

        background-color:#08575a;
    }

    .treasure_video{
        order: -1;
        height: 540px;
        width: 960px;
        border-radius: 12px;
        display: none;
    }

    .appear{
        display: block;
    }


    .text_handler{
        font-size: 3vw;
        padding: 4%;
        color: white;
        font-weight: regular;
        font-family: CA-Geheimagent;
        letter-spacing: 7px;
    }
    
    .btnHolder{
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        gap: 20px;
        position: fixed;
        bottom: 5%;
    }

    .btnReady{
        color:white;
        font-size: 3vw;
        border-style: solid;
        border-radius: 10px;
        padding: 10px;
        cursor: pointer;
        font-weight: regular;
        font-family: CA-Geheimagent;
    }

    @media (max-width: 700px) {
        .cover_image{
            height: 420px;
        }
    }
</style>