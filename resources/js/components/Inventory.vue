<template>
    
    <div class="inventoryContainer">
        <!-- <Item /> -->
        <div class="progressIconContainer">
            <div  :class="[floor_solved ? 'solved':'', 'progressIcon']"><img :src="floor_img" class="imageIcon"/></div>
            <div :class="[computer_solved ? 'solved':'', 'progressIcon']"><img :src="computer_img" class="imageIcon"/></div>
            <div :class="[piano_solved ? 'solved':'', 'progressIcon']"><img :src="piano_img" class="imageIcon"/></div>
            <div :class="[map_solved ? 'solved':'', 'progressIcon']"><img :src="map_img" class="imageIcon"/></div>
            <div :class="[semaphore_solved ? 'solved':'', 'progressIcon']"><img :src="semaphore_img" class="imageIcon"/></div>
            <div :class="[cafe_solved ? 'solved':'', 'progressIcon']"><img :src="cafe_img" class="imageIcon"/></div>
            <div :class="[security_solved ? 'solved':'', 'progressIcon']"><img :src="security_img" class="imageIcon"/></div>
            <div :class="[graffiti_solved ? 'solved':'', 'progressIcon']"><img :src="graffiti_img" class="imageIcon"/></div>
        </div>
    </div>
</template>

<script>

import Item from './InventoryComponents/Item.vue';
import axios from 'axios';

let codeResponse, teamSetup;

export default{
    name:'Inventory',
    components:{
        Item
    },
    beforeDestroy(){
        codeResponse = JSON.parse(localStorage.getItem('codeResponse'));
        getStatusInterval = setInterval(() => this.getSelectedMission(), 2000);


    },
     beforeMount(){
            
            codeResponse = JSON.parse(localStorage.getItem('codeResponse'));
            teamSetup = JSON.parse(localStorage.getItem('teamSetup'));


             axios.post('api/game/get_status_last',{
                        game_event_id: codeResponse.id,
                        playerTeam: teamSetup.playerTeam
                        }).then(response => {
                            for(var i =0; i< response.data.length; i++){
                                if(response.data[i]['puzzle_progress'] == 1){
                                    this.floor_img= './images/color_directional.png';
                                    this.floor_solved = true;
                                }
                                if(response.data[i]['puzzle_progress'] == 2){
                                    this.computer_img= './images/color_computer.png';
                                    this.computer_solved = true;
                                }
                                if(response.data[i]['puzzle_progress'] == 3){
                                    this.piano_img= './images/color_piano.png';
                                    this.piano_img_solved = true;
                                }
                                
                                if(response.data[i]['puzzle_progress'] == 5){
                                    this.map_img = './images/color_map.png';
                                    this.map_img_solved = true;
                                }
                                if(response.data[i]['puzzle_progress'] == 6){
                                    this.semaphore_img= './images/color_semaphore.png';
                                    this.semaphore_solved = true;
                                }
                                if(response.data[i]['puzzle_progress'] == 7){
                                    this.security_img= './images/color_security.png';
                                    this.security_solved = true;
                                }
                                if(response.data[i]['puzzle_progress'] == 8){
                                    this.cafe_img= './images/color_cafe.png';
                                    this.cafe_solved = true;
                                }
                                if(response.data[i]['puzzle_progress'] == 9){
                                    this.graffiti_img= './images/color_graffiti.png';
                                    this.graffiti_solved = true;
                                }
                            }
                        });
        },
    data(){
        return{
            floor_img: './images/bw_directional.png',
            floor_img_solved: './images/color_directional.png',
            floor_solved: false,
            computer_img: './images/bw_computer.png',
            computer_img_solved: './images/color_computer.png',
            computer_solved: false,
            piano_img: './images/bw_piano.png',
            piano_img_solved: './images/color_piano.png',
            piano_solved: false,
            map_img: './images/bw_map.png',
            map_img_solved: './images/color_map.png',
            map_solved: false,
            semaphore_img: './images/bw_semaphore.png',
            semaphore_img_solved: './images/color_semaphore.png',
            semaphore_solved: false,
            cafe_img: './images/bw_cafe.png',
            cafe_img_solved: './images/color_cafe.png',
            cafe_solved: false,
            security_img: './images/bw_security.png',
            security_img_solved: './images/color_security.png',
            security_solved: false,
            graffiti_img: './images/bw_graffiti.png',
            graffiti_img_solved: './images/color_graffiti.png',
            graffiti_solved: false,
        }
    }
}

</script>

<style scoped>
    .inventoryContainer{
        /* background-color: white; */
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-content: center;
        margin: 25px;
        gap: 20px;
    }

    .progressIconContainer{
        display: flex;
        gap: 5px;
        flex-wrap: wrap;
        justify-content: center;
    }


    .progressIcon{
        width: 55px;
        height: 55px;
        border-radius: 50%;
        background-color: black;
    }

    .imageIcon{
        width: 55px; height: 55px; 
    }

    .solved{
        background-color: transparent;
    }

    @media (min-width: 1500px) { 
       .progressIcon{
           width: 70px;
           height: 70px;
       }

       .imageIcon{
           width: 70px;
           height: 70px;
       }
    }


</style>