<template>
  <div class="textHolder">
        
         <span class="text_handler"> {{outputText}} </span>
         
        <a v-if="buttonVisible" class="btnReady" @click="gameStart">{{ buttonText }}</a>
    </div>
</template>

<script>

export default {
    
        name: 'Mission',
        data(){
            return{
                text1 : this.headerText,
                outputText : '',
                inc:0
            }
        },
        mounted(){
             this.outText()
        },
        methods:{
            gameStart(){
                if(this.newLink == true){
                    this.$router.push({name: 'main.computer' })
                }
                else{
                    this.$router.push({ name: 'main.index'+1 })
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
            headerText: String,
            buttonText: String,
            buttonVisible: Boolean,
            newLink: Boolean,
            linkData: String
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