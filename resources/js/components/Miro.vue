<template>
    <div class="miro_board">
        <div class="iframeHolder">
            <iframe class="responsive" style="z-index: -1 !important" :src="iframe.src" frameBorder="0" scrolling="no" allowFullScreen></iframe>
        </div>
        
        <transition name="fade">
        <div class="newcard" style=" " v-if="show">
                        <img  class="cover" src="../assets/computer.png" @click="hideImage" v-if="show" />
           
        </div>
         </transition>
    </div>
</template>

<script>
    const realsrc = 'https://miro.com/app/live-embed/o9J_llppKnc=/?embedAutoplay=true&moveToViewport=-1877,-2465,3763,1996';
    const src2 = 'https://miro.com/app/live-embed/o9J_ltgInS4=/?embedAutoplay=true&moveToViewport=-2638,-351,2934,3605';
    // <iframe width="768" height="432" src="https://miro.com/app/live-embed/o9J_ltgInS4=/?moveToViewport=-2638,-351,2934,3605" frameBorder="0" scrolling="no" allowFullScreen></iframe>
    // <iframe width="768" height="432" src="https://miro.com/app/live-embed/o9J_ltgInS4=/?moveToViewport=-2607,-300,2918,3605" frameBorder="0" scrolling="no" allowFullScreen></iframe>
    // <iframe width="768" height="432" src="https://miro.com/app/live-embed/o9J_ltgInS4=/?moveToViewport=-3318,-689,4377,4668" frameBorder="0" scrolling="no" allowFullScreen></iframe>
    export default{
        name: 'Miro',
        data(){
            return{
                show: true,
                iframe:{
                    src: src2,
                    style: null,
                    wrapperStyle: null
                }
            }
        },
        methods:{
            hideImage(){
                this.show = false;
            }
        }
    }
</script>

<style>
   .miro_board{
        display: flex;
        position: relative;
        border-radius: 10px;
        background-color: black;
        width: 600px;
        padding:0; 
        margin: 0;
    }

    .iframeHolder{
        position: absolute;
        padding:0; 
        width: 100%;
        height: 100%;
        margin: 0;
        z-index: 98;
     cursor: pointer;
    }

    .responsive{
        border-radius: 10px;
        width: 100%;
        height: 100%;
    }
    
    .newcard{
        position: relative;
        padding:0 !important;
        padding:0;
        margin:0;
        z-index: 99;
     cursor: pointer;
    }

    .fade-enter-active, .fade-leave-active {
  transition: opacity 5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}

    .cover{
        border-radius: 10px;
        width: 100%; 
        object-fit: cover;
        padding:0;
        margin:0;
        z-index:100;
    }

</style>