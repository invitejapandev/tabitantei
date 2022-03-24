<template>
    <div class="container">
        <div class="stats v-step-6" >
            <Player  class="player" playerName="Knight07" teamName="7" />
            <Timer :puzzleNumber="puzzleNumber"   :timeIsPaused="timePaused" class="timer " time="01:06:30" />
        </div>
        <Inventory class="inventory_holder v-step-9" />
    </div>
</template>

<script>
    import Player from './Player.vue';
    import Timer from './Timer.vue';
    import Inventory from './Inventory.vue';

    export default{
        name:'Header',
        components:{
            Player,
            Timer,
            Inventory
        },
        props:['timePaused' , 'puzzleNumber']
    }
</script>

<style scoped>
   .container{
       display: flex;
       flex-direction: row;
       align-content: center;
       flex-wrap: wrap;
   }
   
   .stats{
       display:flex;
       flex-wrap: wrap;
       justify-content: center;
       /* align-content: center; */
       /* padding-right: 30px; */
       flex-grow: 1;
       gap: 30px;
   }

    
   .inventory_holder{
       border-radius: 5px;
       flex-grow: 10;
       width: 700px;
       height: 69.31px;
   }

/* 
   .player{
       padding-right: 30px;
   } */


.v-tour__target--highlighted {
  box-shadow: 0 0 0 99999px rgba(0,0,0,.4);
}


</style>