<template>
  <div class="textHolder">
        
         <!-- <span class="text_handler"> {{outputText}} </span> -->
         <div class="bubbleBox" @click="playVid()">
                <video class="treasure_video" @click="playVid()" @global-auto-play="autoPlay" @ended="onEnd()"  ref="videoRef" src="" ></video>
        
        <!-- <transition name="fade">
         <img class="cover_image" src='/images/cover_image.png' @click="hideImage"  v-if="show" />   
        
         </transition> -->
         </div>
         <div class="btnHolder">
              <a v-if="prevShowned" class="btnReady" @click="prevImage()" >Prev</a>
              <a v-if="nextShowned" @click="nextImage()" class="btnReady">Next</a>
              <a v-if="buttonShown" class="btnReady" @click="gameStart(this.puzzleNumber)">Proceed</a>
         </div>
         
        <!-- <a v-if="buttonVisible" class="btnReady" @click="gameStart">{{ buttonText }}</a> -->
    </div>
</template>

<script>

import axios from 'axios'

    let codeResponse, teamSetup;
let getStatusInterval;
let completedPuzzle = 0;

export default {
    
        name: 'VideoFiller',
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
                buttonShown: false
            }
        },
        beforeCreate(){
             codeResponse = JSON.parse(localStorage.getItem('codeResponse'));
            teamSetup = JSON.parse(localStorage.getItem('teamSetup'));
              axios.post('api/game/get_status_last',{
                        game_event_id: codeResponse.id,
                        playerTeam: teamSetup.playerTeam
                        }).then(response => {
                            for(var i =0; i< response.data.length; i++){
                                if(response.data[i]['puzzle_progress'] == 6){
                                    this.semaphore_img= './images/color_semaphore.png';
                                    this.semaphore_solved = true;
                                    completedPuzzle = completedPuzzle+ 1;
                                }
                                if(response.data[i]['puzzle_progress'] == 7){
                                    this.security_img= './images/color_security.png';
                                    this.security_solved = true;
                                    completedPuzzle = completedPuzzle+ 1;
                                }
                                if(response.data[i]['puzzle_progress'] == 8){
                                    this.cafe_img= './images/color_cafe.png';
                                    this.cafe_solved = true;
                                    completedPuzzle = completedPuzzle+ 1;
                                }
                                if(response.data[i]['puzzle_progress'] == 9){
                                    this.graffiti_img= './images/color_graffiti.png';
                                    this.graffiti_solved = true;
                                    completedPuzzle = completedPuzzle+ 1;
                                }
                            }
                            this.$refs.videoRef.src  =this.elementImage; 
                            
                            console.log(completedPuzzle);
                        });
            this.currentPuzzle = this.puzzleNumber;
            
        },
        beforeMount(){
           
        },
        mounted(){
            //  this.outText()
            
            //  this.$refs.videoRef.src = "./images/finale_video.mp4"; 
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
            },
            hideImage(){
                this.show = false;
                this.playVid();
            },
            playVid(){
                
        this.$refs.videoRef.play();
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
            puzzleNumber: Number
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
        width: 100vw;
        height: 100vh;
    }

    .bubbleBox{
        position: relative;
        display: flex;
        width: 100vw;
        height: 100vh;
        justify-content: center;
        cursor: pointer;
    }

    .cover_image{
        height: 720px;
        width: 1280px;
        position: absolute;
        top: 10%;
    }

    .treasure_video{
        position: absolute;
        top: 10%;
        height: 60vh;
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


</style>