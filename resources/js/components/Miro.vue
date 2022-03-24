<template>
    <div class="miro_board">
        <div class="iframeHolder">
            <iframe class="responsive" style="z-index: -1 !important" :src="iframe.src" frameBorder="0" scrolling="no" allowFullScreen></iframe>
        </div>
        
        <transition name="fade">
            <div class="newcard"  v-if="show">
                            <img class="cover_image"  v-bind:src="this.imgCover" @click="hideImage" v-if="show" />
            </div>
         </transition>
    </div>
</template>

<script>
// <iframe width="768" height="432" src="https://miro.com/app/live-embed/o9J_ltgIkjg=/?moveToViewport=2560,-648,1472,1160" frameBorder="0" scrolling="no" allowFullScreen></iframe>
    const realsrc = 'https://miro.com/app/live-embed/o9J_llppKnc=/?embedAutoplay=true&moveToViewport=-1877,-2465,3763,1996';
    const src2 = 'https://miro.com/app/live-embed/o9J_ltgInS4=/?embedAutoplay=true&moveToViewport=-2638,-351,2934,3605';
    const src3 = 'https://miro.com/app/live-embed/o9J_ltgIkjg=/?embedAutoplay=true&moveToViewport=2560,-648,1472,1160';

    
    // <iframe width="768" height="432" src="https://miro.com/app/live-embed/o9J_ljJrZyw=/?moveToViewport=-1717,-895,2432,1658" frameBorder="0" scrolling="no" allowFullScreen></iframe>
    const mapsrc = 'https://miro.com/app/live-embed/o9J_ljJrZyw=/?embedAutoplay=true&moveToViewport=-1717,-895,2432,1658';
    // <iframe width="768" height="432" src="https://miro.com/app/live-embed/o9J_ltgInS4=/?moveToViewport=-2638,-351,2934,3605" frameBorder="0" scrolling="no" allowFullScreen></iframe>
    // <iframe width="768" height="432" src="https://miro.com/app/live-embed/o9J_ltgInS4=/?moveToViewport=-2607,-300,2918,3605" frameBorder="0" scrolling="no" allowFullScreen></iframe>
    // <iframe width="768" height="432" src="https://miro.com/app/live-embed/o9J_ltgInS4=/?moveToViewport=-3318,-689,4377,4668" frameBorder="0" scrolling="no" allowFullScreen></iframe>
    export default{
        name: 'Miro',
        props:{
            miroURL: String,
            isShowned: Boolean,
            imgCover: String,
            miroLoaded: Boolean
        },
        data(){
            return{
                show: this.isShowned,
                iframe:{
                    src: this.miroURL,
                    style: null,
                    wrapperStyle: null
                }
            }
        },
        watch: {
            miroURL: function(val){
                this.iframe.src = val;
            }
        },
        methods:{
            hideImage(){
                this.show = false;
            }
        }
    }
</script>

<style scoped>
   .miro_board{
        display: flex;
        flex-wrap: wrap;
        position: relative;
        border-radius: 11px;
        justify-content: end;
    }

    .iframeHolder{
        position: absolute;
        padding:0; 
        margin: 0;
        z-index: 98;
        cursor: pointer;
        /* background-color: pink; */
        width: 98.5%;
        height: 97%;

    }

    .responsive{
        border-radius: 10px;
        width: 100%;
        height: 100%;
    }
    
     .cover_image{
        position: absolute;
        width: 100%;
        height: 100%;
        z-index:100;
        padding:0; 
        margin: 0;
        border-radius: 10px;
        object-fit: cover;
    }



    .newcard{
        /* position: relative; */
        /* background-color: pink; */
        display: flex;
        position: relative;
        width: 98%;
        height: 100%;
        z-index: 99;
        justify-content: center;
        cursor: pointer;
    }

   
    .fade-enter-active, .fade-leave-active {
        transition: opacity 5s;
    }

    .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
        opacity: 0;
    }



/* 
   @media only screen and (max-width: 1024px) {

        .cover_image{
            height: 80vh;
        }
        
        .iframeHolder{
            height: 80vh;
        }
    }

     @media only screen and (max-width: 800px) {

        .miro_board{
            justify-content: center;
        }

        .cover_image{
            height: 40vh;
            width: 50vh;
        }
        
        .iframeHolder{
            height: 40vh;
            width: 50vh;
        }

    } */



 
</style>