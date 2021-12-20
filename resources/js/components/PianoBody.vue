<template>
    <div class="miro_board">
        
            <div class="pianoHeader">
                <input  style="z-index:99" type="checkbox" v-model="userConfirmedData"/> I am not a robot.
                <br/>Select Correct Picture: 
                <br/><br/>
            </div>
        <div class="main_bod">
        <div class="piano_body">
            <div class="pianoPicHolder">
                <div class="pianoPicture" @click="selectColor('green')" > <img :class="[greenSelected ? 'btnSelected': '', 'piano_final']" src="../assets/green_piano.png" /></div>
                <div class="pianoPicture" @click="selectColor('orange')" > <img :class="[orangeSelected ? 'btnSelected': '', 'piano_final']" src="../assets/orange_piano.png" /></div>
            </div>
            <div class="pianoPicHolder">
                <div class="pianoPicture" @click="selectColor('red')" > <img :class="[redSelected ? 'btnSelected': '', 'piano_final']"  src="../assets/red_piano.png" /> </div>
                <div class="pianoPicture" @click="selectColor('blue')" > <img :class="[blueSelected ? 'btnSelected': '', 'piano_final']" src="../assets/blue_piano.png" /></div>
            </div>
       </div>
       
             <div class="manual_div" >
                <!-- <img class="desk" src="../assets/bulletin_board.png"  /> -->
                <img class="desk" src="/images/pianos.png"  />
            </div>
            </div>
       <!-- <div :class="[selectedColorShown ? 'showing' :'', 'selectedHeader']">Selected Color: <div class="selectedColor" ></div></div> -->
    </div>
</template>

<script>

import axios from 'axios'
   var getStatusInterval;
   let teamSetup, codeResponse ;
   let playerselectedColor;

    let getStatusAttempt = 0;

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
                      getStatusInterval = setInterval(() => this.getStatus(), 2000);
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
                greenSelected: false,
                orangeSelected: false,
                redSelected: false,
                blueSelected: false
            }
        },
        methods:{
            hideImage(){
                this.show = false;
            },
            getStatus(){

                    getStatusAttempt = getStatusAttempt+1;

                   
                    
                    if(this.userConfirmedData && playerselectedColor.length > 0)
                    {

                         if(getStatusAttempt == 10){
                          this.$swal({
                                                                                            title:'Someone is inactive or selected a different color. Coordination is the key.',
                                                                                            icon:'info'    
                                                                                                    }).then(response => {
                                                                                });
                        }

                    axios.post('api/game/get_status_piano',{
                        game_event_id: codeResponse.id,
                        playerTeam: teamSetup.playerTeam,
                        player_name: teamSetup.playerName,
                        player_selected_color: playerselectedColor
                        }).then(response => {
                            
                            if(response['data'].answered_player){
                                let answered_player = response['data'].answered_player;
                                let player_count = response['data'].player_count;
                                let selected_color = response['data'].selected_color;

                                       if(getStatusAttempt == 30 && this.userConfirmedData && playerselectedColor.length > 0){
                                           
                                    // alert('everyone did answer');
                                              clearInterval(getStatusInterval);
                                              let timerInterval;
                                           this.$swal({
                                                    title: 'Validating the answers.',
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
                                                    imageUrl: '/images/correct.png',
                                                    width: 524,
                                                    height: 277,
                                                    imageHeight: 267,
                                                    background: '#ffffff20'
                                                            }).then(response => {
                                                                                             this.$router.push({ name: 'mayu_palais.index'})
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
                                                    imageUrl: '/images/try_again.png',
                                                    width: 524,
                                                    height: 277,
                                                    imageHeight: 267,
                                                    background: '#ffffff20'
                                                            });

                                                                            getStatusAttempt = 0;
                                                                  getStatusInterval = setInterval(() => this.getStatus(), 2000);
                                                                this.validatedAnswer = true;

                                                                            



                                                            }
                                                    });

                    }


                                if(answered_player >= player_count && this.validatedAnswer == false )  {
                                    // alert('everyone did answer');
                                              clearInterval(getStatusInterval);
                                              let timerInterval;
                                           this.$swal({
                                                    title: 'Validating the answers.',
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
                                                    imageUrl: '/images/correct.png',
                                                    width: 524,
                                                    height: 277,
                                                    imageHeight: 267,
                                                    background: '#ffffff20'
                                                            }).then(response => {
                                                                                             this.$router.push({ name: 'mayu_palais.index'})
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
                                                    imageUrl: '/images/try_again.png',
                                                    width: 524,
                                                    height: 277,
                                                    imageHeight: 267,
                                                    background: '#ffffff20'
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

            }

                 
            },
            selectColor(color){
                getStatusAttempt = 0;

                    if(this.userConfirmedData){
                        playerselectedColor = color;
                        if(playerselectedColor =='green'){
                            this.greenSelected = true;
                            this.orangeSelected = false;
                            this.redSelected = false;
                            this.blueSelected = false;
                        }
                        else if(playerselectedColor =='orange'){
                            this.greenSelected = false;
                            this.orangeSelected = true;
                            this.redSelected = false;
                            this.blueSelected = false;
                        }
                        else if(playerselectedColor == 'red'){
                            this.greenSelected = false;
                            this.orangeSelected = false;
                            this.redSelected = true;
                            this.blueSelected = false;
                        }
                        else{
                            this.greenSelected = false;
                            this.orangeSelected = false;
                            this.redSelected = false;
                            this.blueSelected = true;
                        }


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

                        
                            // document.querySelector(".selectedColor").style.backgroundColor =color;
                            // this.selectedColorShown= true;
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

.main_bod{
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-content: center;
}



   .miro_board{
        display: flex;
        position: relative;
        justify-content: center;
        align-content: center;
        flex-wrap: wrap;
        flex-direction: column;
        width: 100%;
    }

    .piano_body{
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-content: center;
        gap: 20px;
        flex-direction: row;
        position: relative;
        width: 40vw;
        flex-grow: 1;
    }

    .pianoHeader{
        display: flex;
        position: relative;
        text-align: center;
        align-content: center;
        justify-content: center;
        font-size: 3rem;
        font-weight: bold;
        font-family: CA-Geheimagent;
        vertical-align: middle;
        width: 100%;
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
        height: 60px;
        width: 60px;
        z-index: 99;
    }

    .showing{
        display: flex;
        z-index: 99;
    }

    .pianoPicHolder{
        display: flex;
        flex-wrap: wrap;
        flex-direction: column;
        justify-content: center;
        align-content: center;
        width: 100%;
        gap: 20px;
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


    .pianopicture{
        display: flex;
        flex-wrap: wrap;
        align-content: center;
        justify-content: center;
    }

    .btnSelected{
        border-radius: 50%; border-style: solid; border-color: lightgreen;
    }


.manual_div{
        display: flex;
        position: relative;
        justify-content: center;
        align-items: center;
        width: 60vw;
        height: 50vh;
        flex-grow: 1;
        /* border-style: solid; */
    }
    
    .desk{
        border-radius: 10px;
        width: 95%;
        height: 40vh;
        object-fit: cover;
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

/* Small */
@media (min-width: 600px) {
      .pianopicture{
        width: 165px;
        height: 165px;
    }

    .piano_final{
        width: 160px;
        height: 160px;
    }

      .pianoPicHolder{
        height: 160px;
    }
  }
  
/* Medium */
@media (min-width: 1252px) { 

    .pianopicture{
        width: 180px;
        height: 180px;
    }

    .piano_final{
        width: 180px;
        height: 180px;
    } 


      .pianoPicHolder{
        height: 180px;
    }
 }
  
/* Large */
@media (min-width: 1500px) { 
    .pianopicture{
        width: 225px;
        height: 225px;
    }

    .piano_final{
        width: 220px;
        height: 220px;
    } 

    .pianoPicHolder{
        height: 220px;
    }
    }
  
/* X-Large */
@media (min-width: 1700px) { 
    .pianopicture{
        width: 285px;
        height: 285px;
    }


    .piano_final{
        width: 280px;
        height: 280px;
    } 

    .pianoPicHolder{
        height: 280px;
    }
    }



 
</style>