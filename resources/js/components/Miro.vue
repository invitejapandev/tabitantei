<template>
    <div class="miro_board">
        <div class="iframeHolder">

        </div>
        
        <div class="newcard" style=" " >
            <transition name="fade">
                        <img  class="cover" src="../assets/computer.png" @click="hideImage" v-if="show" />
            </transition>
        </div>
    </div>
</template>

<script>

    export default{
        name: 'Miro',
        data(){
            return{
                show: true
            }
        },
        methods:{
            hideImage(e){
                this.show = false;
            }
        }
    }
</script>

<style>
   .miro_board{
        border-radius: 10px;
        background-color: white;
        width: 600px;
        z-index:100;
        padding:0; 
        margin: 0;
    }

    .iframeHolder{
        position: absolute;
        z-index:100;
        padding:0; 
        margin: 0;
    }

    .newcard{
        padding:0 !important;
        z-index:200;
        height: 100%;
        padding:0;
        margin:0;
    }

    .fade-enter-active, .fade-leave-active {
  transition: opacity 5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}

    .cover{
        border-radius: 10px;
        height: 100%; width: 100%; 
        object-fit: cover;
        padding:0;
        margin:0;
    }

</style>