<template>
<div class="mapContainer"> 
    <div class="mayumiHolder">
        <span class="mayumiText">{{speaker}} </span>

    </div>
    <div class="textHolder">
        
         
             <span class="text_handler">{{ outputText }}</span>
        <a class="btnReady" @click="proceed">Proceed</a>

    </div>
</div>
  
</template>

<script>
export default {
        name: 'MapTextPartTwo',
        data(){
            return {
                text1 : this.mapMessage,
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
                     if(this.mapPart == 1){
                        this.$router.push({ name: 'main.map1' })
                      }
                      else{
                          this.$router.push({ name: 'main.map2' })
                      }
                 }
            },
            outText() {

                if (this.inc < this.text1.length) {
                    this.outputText += this.text1.charAt(this.inc);
                    this.inc ++;
                    setTimeout(this.outText, 50)
                }
                else{

                }
            }
        },
        props:{
            mapPart: Number,
            mapMessage: String,
            speaker: String
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
        margin-left: 5%
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
        font-family: 'VT323', monospace;
        /* font-weight: regular;
        font-family: CA-Geheimagent; */
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