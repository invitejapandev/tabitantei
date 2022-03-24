<template>
  <div class="textHolder">
        
         <!-- <span class="text_handler"> {{outputText}} </span> -->
         <div class="bubbleBox">
                <img class="desk" v-bind:src="img[imgIndex]"  />
         </div>
         <div class="btnHolder">
              <a v-if="prevShowned" class="btnReady" @click="prevImage()" >Prev</a>
              <a v-if="nextShowned" @click="nextImage()" class="btnReady">Next</a>
              <a v-if="enterShowned" class="btnReady" @click="gameStart(this.puzzleNumber)">Back to Home</a>
         </div>
         
        <!-- <a v-if="buttonVisible" class="btnReady" @click="gameStart">{{ buttonText }}</a> -->
    </div>
</template>

<script>

export default {
    
        name: 'GameOver',
        data(){
            return{
                text1 : this.headerText,
                outputText : '',
                inc:0,
                img: this.elementImage,
                imgIndex:0,
                nextShowned: false,
                prevShowned: false,
                enterShowned: false,
                currentPuzzle: 1
            }
        },
        beforeCreate(){
            
            this.currentPuzzle = this.puzzleNumber;
        },
        mounted(){
            //  this.outText()
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

             
                
                if(this.imgIndex >0 ){
                    this.prevShowned = true;
                }
                else{
                    this.prevShowned = false;
                }

                if(this.imgIndex+1 == this.elementImage.length){
                   this.prevShowned = false;
                }
                else{
                    this.enterShowned = false;
                }
            }
        },
        methods:{
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

                    this.$router.push({name: 'login.index' })
                
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
    .textHolder{
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        height: 100vh;
        align-content: center;
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

    .bubbleBox{
        display: flex;
        flex-wrap: wrap;
        align-content: center;
        justify-content: center;
        justify-items: center;
    }

     @media (min-width: 1252px) { 
        .desk{
            max-width: 900px;
        }
    }

    @media (min-width: 1370px) { 
        .desk{
            max-width: 1100px;
        }
    }


    @media (min-width: 1500px) { 
        .desk{
            max-width: 1400px;
        }
    }


</style>