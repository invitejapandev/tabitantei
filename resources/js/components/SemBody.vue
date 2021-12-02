<template>
    <div class="miro_board">
    <div class="instruction_holder">Over the last 24 hours, we have detected an agent traveling all over the city who is trying to get a message to your team. But there is only one place in Paris where you can view so many places at different times of day. Using the hyper sensitive 24SC positioned on two decks of the Eiffel Tower, you may be able to decode the message he is trying to send.
<br/><br/>
You will need to divide into two teams, some of you going to the 2nd Floor Observation Deck and some to the Top Floor high above.
<br/><br/>
The code word is 07:45, 08:30, 16:00, 17:42, 00:46, 16:00, 10:50.</div>
       <div class="pianoHeader">Select which floor <div :class="[selectedColorShown ? 'showing' :'', 'selectedColor']" ></div> </div>
       <div class="towerFloorHolder">
           <div class="floor fred" @click="topFlorTriggered()"> TOP FLOOR </div>
           <div class="floor fgreen" @click="secondFloorTriggered()" > 2ND FLOOR </div>
       </div>

        <div class="pianoHeader">Where to point 24SC? <div :class="[selectedColorShown ? 'showing' :'', 'selectedColor']" ></div> </div>
       <div class="towerFloorHolder">
           <div  v-for="(item, index) in angles" :key="index" class="angle" @click="showSemTest(item.imageName)"> {{ item.angleName }} </div>
           <!-- <div class="angle" @click="selectColor('green')"> WEST </div>
           <div class="angle" @click="selectColor('orange')" > SOUTH-WEST </div>
           <div class="angle" @click="selectColor('orange')" > SOUTH-EAST </div>
           <div class="angle" @click="selectColor('orange')" > NORTH </div> -->
       </div>
       <!-- <div :class="[selectedColorShown ? 'showing' :'', 'selectedHeader']">Selected Color: <div class="selectedColor" ></div></div> -->
    </div>
</template>

<script>

import axios from 'axios'
   var getStatusInterval;
   let teamSetup, codeResponse ;
   let playerselectedColor;
    let angleData;
// <iframe width="768" height="432" src="https://miro.com/app/live-embed/o9J_ltgIkjg=/?moveToViewport=2560,-648,1472,1160" frameBorder="0" scrolling="no" allowFullScreen></iframe>
    const realsrc = 'https://miro.com/app/live-embed/o9J_llppKnc=/?embedAutoplay=true&moveToViewport=-1877,-2465,3763,1996';
    const src2 = 'https://miro.com/app/live-embed/o9J_ltgInS4=/?embedAutoplay=true&moveToViewport=-2638,-351,2934,3605';
    const src3 = 'https://miro.com/app/live-embed/o9J_ltgIkjg=/?embedAutoplay=true&moveToViewport=2560,-648,1472,1160';
var correctSound = new Audio('https://www.freesoundslibrary.com/wp-content/uploads/2018/03/right-answer-ding-ding-sound-effect.mp3');
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
            imgCover: String
        },
        beforeCreate(){
             teamSetup = JSON.parse(localStorage.getItem('teamSetup'));
             codeResponse = JSON.parse(localStorage.getItem('codeResponse'));
                    //   getStatusInterval = setInterval(() => this.getStatus(), 2000);
        },
        data(){
            return{
                show: this.isShowned,
                iframe:{
                    src: this.miroURL,
                    style: null,
                    wrapperStyle: null
                },
                selectedColorShown: false,
                validatedAnswer: false,
                userConfirmedData: false,
                angles: null
            }
        },
        methods:{
            hideImage(){
                this.show = false;
            },
            showSemTest(itemImageName){
                // alert(itemImageName);
                this.$emit('showSemTest', itemImageName);
            },
            secondFloorTriggered(){
                this.angles =  [
                    {angleName: 'North', imageName: '2f_north' },
                    {angleName: 'South East', imageName: '2f_south_east' },
                    {angleName: 'South West', imageName: '2f_south_west' },
                    {angleName: 'West', imageName: '2f_west' },
                ];
            },
            topFlorTriggered(){
                 this.angles =  [
                    {angleName: 'North East', imageName: 'top_north_east' },
                    {angleName: 'North West', imageName: 'top_north_west' },
                    {angleName: 'South', imageName: 'top_south' },
                    {angleName: 'West', imageName: 'top_west' },
                ];
            },
            getStatus(){


                    axios.post('api/game/get_status_piano',{
                        game_event_id: codeResponse.id,
                        playerTeam: teamSetup.playerTeam,
                        player_name: teamSetup.playerName
                        }).then(response => {
                            
                            if(response['data'].answered_player){
                                let answered_player = response['data'].answered_player;
                                let player_count = response['data'].player_count;
                                let selected_color = response['data'].selected_color;

                                if(answered_player == player_count && this.validatedAnswer == false){
                                    // alert('everyone did answer');
                                              clearInterval(getStatusInterval);
                                              let timerInterval;
                                           this.$swal({
                                                    title: 'Everyone did answer. Validating the answers.',
                                                    timer: 3000,
                                                    timerProgressBar: true,
                                                    allowOutsideClick:false,
                                                    didOpen: () => {
                                                        this.$swal.showLoading()
                                                        const b = this.$swal.getHtmlContainer().querySelector('b')
                                                        timerInterval = setInterval(() => {
                                                        b.textContent =  this.$swal.getTimerLeft()
                                                        }, 100)
                                                    },
                                                    willClose: () => {
                                                        clearInterval(timerInterval)
                                                    }
                                                    }).then((result) => {
                                                          if(selected_color =='blue' && this.validatedAnswer == false){
                                                                this.validatedAnswer = true;
                                                                correctSound.play();
                                                                this.$emit('pause-time');
                                                                
                                                                let gameProgress = JSON.parse(localStorage.getItem('gameProgress'));


                                                                axios.post('api/game/store_status',{
                                                                            game_event_id: teamSetup.game_event_id,
                                                                            teamNumber: teamSetup.playerTeam,
                                                                            puzzle_progress: 3,
                                                                            player_number: teamSetup.playerName
                                                                        }).then(response => {
                                                                            


                                                                            if(response){
                                                                                this.$swal({
                                                                                            title:'Great! That is the correct answer!',
                                                                                            icon:'success'    
                                                                                                    }).then(response => {
                                                                                             this.$router.push({ name: 'MapText.index'})
                                                                                });
                                                                            }
                                                                            else{
                                                                                //show db error
                                                                                //alert('something went wrong');
                                                                            }
                                                                        });
                                                                
                                                            }
                                                            else if(this.validatedAnswer == false){
                                                                this.$swal({
                                                                    title:`That is not the correct answer. Please try again.`,
                                                                    icon:'error'    
                                                                            });
                                                                  getStatusInterval = setInterval(() => this.getStatus(), 2000);
                                                                this.validatedAnswer = true;
                                                            }
                                                    });
                                  
                                }
                            }
                            // alert(response['data'].answered_player);

                            // let player_count = 
                            // alert(response['data'].answered_player)
                            
                            // console.log(response['data'][0].answered_current);
                            //    if(response['data'][0].answered_current == 1){
                            //     this.timeisPaused = true;
                            //     clearInterval(getStatusInterval);
                            //     if(response['data'][0].player_number != teamSetup.playerName){
                            //         this.$swal({
                            //                 title:'Great! Your team got the correct answer.',
                            //                 icon:'success'}).then(response => {
                            //                         if(this.puzzleNumber == 2){
                            //                             this.$router.push({ name: 'MapText.index' })
                            //                         }
                            //                         else if(this.puzzleNumber == 3){
                            //                             this.$router.push({ name: 'MapTextPartThree.index'})
                            //                         }
                            //                         else{
                            //                             this.$router.push({ name: 'archive.index' })
                            //                         } 
                            //                         });
                            //         }
                            //     }
                        }).catch(error => {
                           console.log(error);
                        });

                 
            },
            selectColor(color){
                
                    if(this.userConfirmedData){
                        playerselectedColor = color;
                            axios.post('api/game/submit_color',{
                                            game_event_id: teamSetup.game_event_id,
                                            team_number: teamSetup.playerTeam,
                                            selected_color: color,
                                            player_name: teamSetup.playerName
                                        }).then(response => {
                                            console.log(response);

                                            if(response){
                                                this.$swal({
                                                        title:'You selected color '+color+'.',
                                                        text: "Once all members of your team enter the same button, your answer will be sent for security analysis.",
                                                        
                                                        // icon:'warning',
                                                    }).then((result) =>{
                                                    
                                                    });
                                            }
                                            else{
                                                //show db error
                                                //alert('something went wrong');
                                            }
                                        });

                        
                            document.querySelector(".selectedColor").style.backgroundColor =color;
                            this.selectedColorShown= true;
                            this.validatedAnswer = false;
                     }
                     else{
                         this.$swal({
                                                        title:'Please confirm that you are not a robot.'
                                                       
                                                        
                                                        // icon:'warning',
                                                    }).then((result) =>{
                                                    
                                                    });
                     }
            }
        }
    }
</script>

<style scoped>
input[type='checkbox'] {
    width:30px;
    height:30px;
    margin-top: 16px;
}

.instruction_holder{
    display: flex;
    justify-content: center;
    margin: 5%;
        font-size: 1.5rem;
        font-weight: bold;
        font-family: CA-Geheimagent;
}



   .miro_board{
        display: flex;
        justify-content: start;
        align-content: center;
        flex-wrap: wrap;
        width: 50px;
        flex-direction: column;
        gap: 20px;
    }

    .pianoHeader{
        display: flex;
        text-align: center;
        align-content: center;
        justify-content: center;
        font-size: 3rem;
        gap: 10px;
        font-weight: bold;
        font-family: CA-Geheimagent;
        vertical-align: middle;
    }
    
    .selectedHeader{
        display: none;
        text-align: center;
        align-content: center;
        justify-content: center;
        font-size: 3rem;
        gap: 10px;
        font-weight: bold;
        font-family: CA-Geheimagent;
    }

    
    
    .selectedColor{
        display: none;
        border-radius: 10%;
        justify-content: end;
        align-content: end;
        height: 100%;
        width: 60px;
    }

    .showing{
        display: flex;
    }

    .towerFloorHolder{
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: center;
        align-content: center;
    }

    .floor{
        display: flex;
        justify-content: center;
        align-content: center;
        border-radius: 3%;
        height: 70px;
        padding-top: 2%;
        width: 200px;
        font-weight: bold;
        font-size: 3rem;
        font-family: CA-Geheimagent;
        cursor: pointer;
        background-color: white;
        color: black;
    }

    .fred{
        border-style: solid;
        border-color: #f8aa90;
    }

    .fgreen{
        border-style: solid;
        border-color: #aed79d;
    }

    
    .angle{
        display: flex;
        justify-content: center;
        align-content: center;
        border-radius: 3%;
        height: 70px;
        padding-top: 2%;
        width: 200px;
        font-weight: bold;
        font-size: 3rem;
        font-family: CA-Geheimagent;
        cursor: pointer;
        background-color: black;
        color: white;
    }
    

    .iframeHolder{
        position: absolute;
        padding:0; 
        margin: 0;
        z-index: 98;
        cursor: pointer;
        /* background-color: pink; */
        width: 98%;
        height: 100%;

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