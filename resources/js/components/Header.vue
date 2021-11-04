<template>
    <div class="container">
        <div class="stats">
            <Player class="player" playerName="ron" teamName="Gryffindor" />
            <Timer class="timer" time="01:06:30" />
        </div>
        <Inventory class="inventory" />
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
        }
    }
</script>

<style>
   .container{
       display: flex;
       flex-wrap: wrap;
       align-content: end;
   }
   
   .stats{
       display:flex;
       flex-grow: 1;
       flex-direction: row;
       flex-wrap: wrap;
       justify-content: end;
   }

   .player{
       padding-right: 30px;
   }

   .timer{
       flex-basis: 100px;
       flex-grow: 4;
   }


   .inventory{
       flex-grow: 1;
       flex-basis: 500px;
   }

</style>