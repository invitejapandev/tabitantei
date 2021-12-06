<template>
  <div class="textHolder"  @click="proceed">
        
         <span class="text_handler">{{ outputText }}</span>
        <a class="btnReady" @click="proceed">Proceed</a>
    </div>
</template>

<script>
export default {
        name: 'TextHolder',
        data(){
            return {
                text1 : `"Welcome Trainees": Congratulations! 
Your team has been admitted to the top-secret 
spy training program at the Invite Japan 
agency. Your team has shown remarkable 
skills and talents so far, but there is much more to learn. 
Before you can be accepted as full-fledged spies at our 
agency, you must prove yourself in the field, and 
demonstrate your puzzle-solving and team working skills...`,
                outputText : '',
                inc:0
            }
        },
        mounted(){
            // this.outText()
        },
        methods:{
            proceed(){
                this.$router.push({ name: 'bubble.index' })
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
    .textHolder{
        height: 100%;
        width: 100%;
        background-size: contain;
        background-color: black;
        background-repeat: no-repeat;
        background-position: center center;
        background-attachment: scroll;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        background-image: url('../assets/welcome_page_1.png');
        padding:0;
        margin: 0;
        /* min-width: 1440px; */
        /* min-height: 810px; */
        cursor: pointer;
    }

    .text_handler{
        font-size: 3vw;
        padding: 7%;
        color: white;
        font-weight: regular;
        font-family: CA-Geheimagent;
        letter-spacing: 7px;
    }

    .btnReady{
        position: fixed;
        bottom: 3%;
        color:white;
        font-size: 2vw;
        border-style: solid;
        border-radius: 10px;
        padding: 3px;
        cursor: pointer;
        font-weight: regular;
        font-family: CA-Geheimagent;
    }


</style>