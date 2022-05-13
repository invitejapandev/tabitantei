<template>
    <div class="textHolder">
         <div class="bubbleBox">
            <div class="cover_image_holder">
                <video  :class="[show == false? 'appear':'','treasure_video']" @global-auto-play="autoPlay" @ended="onEnd()"  ref="videoRef" src="" ></video>
                <img  v-if="show" class="cover_image" :src='welcome_image' @click="hideImage" />   
                <button v-if="beginShow" class="begin_btn" @click="playVid()">Begin 次へ</button>
            </div>
         </div>
         <div v-if="btnHolderShow" class="btnHolder">
              <a v-if="prevShowned" class="btnReady" @click="prevImage()" >Prev</a>
              <a v-if="nextShowned" @click="nextImage()" class="btnReady">Next</a>
              <a v-if="enterShowned" class="btnReady" @click="playVid()">Proceed</a>
         </div>
    </div>
</template>

<script>

import axios from 'axios'

let codeResponse, teamSetup;
let getStatusInterval;
let completedPuzzle = 0;

export default {
    
        name: 'Welcome',
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
                buttonShown: false,
                beginShow: false,
                clicker: 0,
                btnHolderShow: true,
                welcome_image: '/images/Welcome_1.png'
            }
        },
        beforeCreate(){
            codeResponse = JSON.parse(localStorage.getItem('codeResponse'));
           
            if(codeResponse){
                
                 teamSetup = JSON.parse(localStorage.getItem('teamSetup'));
                
                if(teamSetup){
                    if(teamSetup.game_event_id == codeResponse.id && teamSetup.playerTeam){

                        axios.post('api/game/get_status_last_specific',{
                        game_event_id: codeResponse.id,
                        playerTeam: teamSetup.playerTeam
                        }).then(response => {
                                if(response.data <3){
                                                        this.$router.push({ name: 'welcome.index' });
                                 }
                                else if(response.data <=12){
                                     this.$router.push({ name: 'mission.index' });
                                 }
                        });
                    }
                }

            }
            else{
                 this.$router.push({ name: 'login.index' });
            }
        },
        beforeMount(){
           
        },
        mounted(){

            this.$refs.videoRef.src  = "./images/Yokomusic.mp4"; 
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

                this.welcome_image = this.elementImage[val];
            }
        },
        methods:{
            onEnd(){
                // alert('the video has ended')
                this.buttonShown = true;
                this.beginShow = true;
            },
            hideImage(){
                // if(this.show ==true){
                //     this.show = false;
                //     this.playVid();
                // }
                if(this.clicker == 0){
                    this.welcome_image = '/images/welcome_2.png';
                }
            },
            playVid(){
                this.btnHolderShow = false;
                if(this.show == true){
                    this.show=false;
                    this.beginShow=false;
                    this.$refs.videoRef.play();
                }
                else{
                    this.$router.push({name: 'mission.index' })
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
        flex-direction: column;
        justify-content: space-evenly;
        align-items: center;
        align-content: center;
        width: 100%;
        height: 100%;
        background-image: url('../assets/main_bg.jpg') !important;
        background-size: cover;
        background-repeat: no-repeat;
    }

    .bubbleBox{
        position: relative;
        display: flex;
        justify-content: center;
        align-content: center;
    }

     .btnHolder{
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        gap: 20px;
        z-index: 100;
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
        height: 540px;
        width: 960px;
        object-fit: cover;
    }

    .begin_btn{
       height: 55px;
        font-family: 'Covered By Your Grace', cursive;
        color: white;
        background-color: #12cdd4;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-weight: bold;
        font-size: 2em;
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
    
   

    .btnReady{
       height: 55px;
        font-family: 'Covered By Your Grace', cursive;
        color: white;
        background-color: #12cdd4;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-weight: bold;
        font-size: 2em;
        padding-left: 5px !important;
        padding-right: 5px;
        padding-top: 5px;
        padding-bottom: 5px;
    }

    @media (max-width: 700px) {
        .cover_image{
            height: 420px;
        }
    }
</style>