<template>
<div class="mapContainer"> 
    <div class="mayumiHolder">
        <span class="mayumiText">Mayumi: </span>

    </div>
    <div class="textHolder" @click="proceed">
        
         
             <span class="text_handler">{{ outputText }}</span>
        <!-- <a class="btnReady" @click="proceed">Proceed</a> -->

    </div>
</div>
  
</template>

<script>
export default {
        name: 'MapText',
        data(){
            return {
                text1 : `Oh good you've contacted me! Don't worry, this message is encrypted. 
I don't have much time though…. 
A famous painting was stolen from the Louvre! So I am currently in Paris working on the case.
I did manage to find the painting...
However, it's been locked by a very complex device. It's almost entirely impossible to open it with the tools we have right now.
I need your help to find the legendary locksmith, Mr Sato who made the device. He may have the key to opening the lock. 
My sources have indicated that he is likely at the Palais Garnier.`,
                outputText : '',
                inc:0
            }
        },
        mounted(){
            this.outText()
        },
        methods:{
            proceed(){
                if (this.inc > this.text1.length) {
                     //Text is still printing
                 }
                 else{
                    this.$router.push({ name: 'MapTextPartTwo.index' })
                 }
            },
            outText() {

                if (this.inc < this.text1.length) {
                    this.outputText += this.text1.charAt(this.inc);
                    this.inc ++;
                    setTimeout(this.outText, 50)

                }
            }
        }
}
</script>

<style scoped>
    .mapContainer{
        display: flex;
        justify-content: center;
        align-content: center;
        flex-direction: column;
        padding-top: 4vh;
        height: 90vh;
        width: 100vw;
        overflow: hidden;
        gap: 5px;
    }

    .textHolder{
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        background-color: black;
        overflow: hidden;
        height: 55rem;
        width: 90%;
        margin-left: 5%;
        cursor: pointer;
    }
    
    .mayumiText{
        background-color: white;
        color: black;
        font-family: 'VT323', monospace;
        margin-left: 5%;
        width: 500px;
        font-size: 3vw;
        padding-left: 40px;
        padding-right: 40px;
        border-radius: 5%;
    }


    .text_handler{
        font-size: 2vw;
        padding: 2%;
        color: white;
        color: greenyellow;
        /* font-weight: regular;
        font-family: CA-Geheimagent; */
        font-family: 'VT323', monospace;
        letter-spacing: 7px;
    }

    .btnReady{
        position: fixed;
        top: 80%;
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