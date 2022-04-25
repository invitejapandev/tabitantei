<template>
    <div class="miro_board">
        
            
        <div class="main_bod">
            <div class="player_selected_holder">
                <div  v-for="(item, index) in answerList" :key="index" class="player_selected">{{ item.nickName }} <img :src="renderSected(item.selected_color)" height="30"  width="30" /></div>
                <!-- <div  v-for="(item2, index2) in playerNoAnswer" :key="index2" class="player_selected">{{ item2.nickName }} <img src="/images/choice_indicator_blank.png" height="30"  width="30" /></div> -->
                <!-- <div class="player_selected">Player 1 selected <img src="/images/choice_indicator_blank.png" height="30"  width="30" /></div>
                <div class="player_selected">Player 2 selected <img src="/images/choice_indicator_blue.png" height="30"  width="30" /></div>
                <div class="player_selected">Player 3 selected <img src="/images/choice_indicator_red.png" height="30"  width="30" /></div>
                <div class="player_selected">Player 4 selected <img src="/images/choice_indicator_yellow.png" height="30"  width="30" /></div>
                <div class="player_selected">Player 5 selected <img src="/images/choice_indicator_yellow.png" height="30"  width="30" /></div> -->
            </div>
            
        <div class="pianoFooter">
                <input  style="z-index:99; align-items: center;" type="checkbox" v-model="userConfirmedData"/>私はロボットではありません<br/>I am not a robot
        </div>
             <div class="manual_div" >
                <!-- <img class="desk" src="/images/piano_captcha_full.png"  />
                 -->
                 <svg  class="desk"   version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 2372 1334" preserveAspectRatio="xMinYMin meet" >
                    <image xlink:href="../assets/piano_captcha_full.png" >
                    </image>
                    <a class="clickable_image red" @click="selectColor('red')">
                        <circle cx="710" cy="243" r="218" fill="#fff" opacity="0" />
                    </a>
                    <a class="clickable_image red" @click="selectColor('green')">
                        <circle cx="298" cy="436" r="215" fill="#fff" opacity="0" />
                    </a>
                    <a class="clickable_image red" @click="selectColor('orange')">
                        <circle cx="297" cy="873" r="216" fill="#fff" opacity="0" />
                    </a>
                    <a class="clickable_image red" @click="selectColor('blue')">
                        <circle cx="711" cy="1072" r="217" fill="#fff" opacity="0" />
                    </a>
                    
                </svg>
            </div>
            

        </div>
       
    </div>
</template>

<script>

import axios from 'axios'
   var getStatusInterval, getStatusInterval_latest;
   let teamSetup, codeResponse ;
   let playerselectedColor;
   
var correctSound = new Audio('https://www.freesoundslibrary.com/wp-content/uploads/2018/03/right-answer-ding-ding-sound-effect.mp3');

    let getStatusAttempt = 0;

    export default{
        name: 'Miro',
        props:{
            miroURL: String,
            isShowned: Boolean,
            imgCover: String,
            puzzleNumber: Number
        },
        beforeCreate(){
            teamSetup = JSON.parse(localStorage.getItem('teamSetup'));
            codeResponse = JSON.parse(localStorage.getItem('codeResponse'));
            getStatusInterval = setInterval(() => this.getStatus(), 3000);
                    //    getStatusInterval_latest = setInterval(() => this.getStatus_latest(), 2000);
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
                blueSelected: false,
                answerList: null,
                playerNoAnswer: {}
            }
        },
        methods:{
            renderSected(val){
                if(val == 'red'){
                    return '../images/choice_indicator_red.png';
                }
                else if(val == 'blue'){
                    return '../images/choice_indicator_blue.png';
                }
                else if(val == 'green'){
                    return '../images/choice_indicator_green.png';
                }
                else if(val == 'orange')
                {
                    return '../images/choice_indicator_yellow.png';
                }
                else{
                     return '../images/choice_indicator_blank.png';
                }
            },
            hideImage(){
                this.show = false;
            },
            getStatus_latest(){
                    axios.post('api/game/get_status',{
                        game_event_id: codeResponse.id,
                        playerTeam: teamSetup.playerTeam,
                        puzzleNumber: this.puzzleNumber
                        }).then(response => {
                            console.log(response['data'][0].answered_current);
                               if(response['data'][0].answered_current == 1){
                                this.timeisPaused = true;
                                                                //  clearInterval(getStatusInterval_latest);
                                                                                            clearInterval(getStatusInterval);
                                                                                            getStatusAttempt =0;
                                if(response['data'][0].player_number != teamSetup.playerName){
                                    this.$swal({
                                                    imageUrl: '/images/correct.png',
                                                    width: 524,
                                                    height: 277,
                                                    imageHeight: 267,
                                                    background: '#ffffff20'
                                                            }).then(response => { 
                                                                this.$router.push({ name: 'mayu_palais.index'});
                                                    });
                                    }
                                }
                        }).catch(error => {
                           console.log(error);
                        });

                 
            
        },
            getStatus(){

                 axios.post('api/game/get_selected_piano_answer',{
                        game_event_id: codeResponse.id,
                        player_team: teamSetup.playerTeam,
                        player_name: teamSetup.playerName,
                        // player_selected_color: playerselectedColor,
                        puzzle_number: this.puzzleNumber
                        }).then(response => {
                            let data = response['data'];
                            this.answerList = data.playerAnswerList;

                            let voted_color = data.voted_color;
                            let gamePrgoressNew = data.gameProgress;
                            if(gamePrgoressNew == 1){
                                
                                clearInterval(getStatusInterval);
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

                            if(voted_color != ""){
                                clearInterval(getStatusInterval);
                                let timerInterval;
                                                this.$swal({
                                                    title: '全員が選択を完了しました。解答を検証中です。<br/>Validating the answers.',
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

                                                        axios.post('api/game/update_piano_answer',{
                                                            game_event_id: codeResponse.id,
                                                            player_team: teamSetup.playerTeam,
                                                            player_name: teamSetup.playerName,
                                                            selected_color: voted_color,
                                                            puzzle_number: this.puzzleNumber
                                                            }).then(response => {
                                                            
                                                            });
                                                    
                                                        if(voted_color == 'blue'){
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
                                                        else{
                                                             this.$swal({
                                                                    imageUrl: '/images/try_again.png',
                                                                    width: 524,
                                                                    height: 277,
                                                                    imageHeight: 267,
                                                                    background: '#ffffff20'
                                                            });

                                                            getStatusInterval = setInterval(() => this.getStatus(), 3000);
                                                            this.validatedAnswer = true;
                                                        }
                                                    
                                                    });

                            }
                        });
                

            //         getStatusAttempt = getStatusAttempt+1;
            //              if(getStatusAttempt == 30){
            //               this.$swal({
            //                   title:'メンバーの誰かが稼働していないか、別の色を選択しています。<br/>共同作業が鍵です。<br/><br/>Someone is inactive or selected a different color. Coordination is the key.',
            //                   }).then(response => {

            //                    });
            //             }

            //             axios.post('api/game/get_status_piano',{
            //             game_event_id: codeResponse.id,
            //             playerTeam: teamSetup.playerTeam,
            //             player_name: teamSetup.playerName,
            //             player_selected_color: playerselectedColor,
            //             puzzle_number: this.puzzleNumber
            //             }).then(response => {
            //                 if(response['data'].gameStatus){
            //                     let gameStatus = response['data'].gameStatus;
            //                     // alert(gameStatus);
            //                      if(gameStatus[0].answered_current == 1 && [0].player_number != teamSetup.playerName){
                                     
            //                         clearInterval(getStatusInterval);
            //                             axios.post('api/game/store_status',{
            //                                     game_event_id: teamSetup.game_event_id,
            //                                     teamNumber: teamSetup.playerTeam,
            //                                     puzzle_progress: 3,
            //                                     player_number: teamSetup.playerName
            //                             }).then(response => {
            //                                 if(response){
            //                                     this.$swal({
            //                                         imageUrl: '/images/correct.png',
            //                                         width: 524,
            //                                         height: 277,
            //                                         imageHeight: 267,
            //                                         background: '#ffffff20'
            //                                                 }).then(response => {
            //                                                         this.$router.push({ name: 'mayu_palais.index'})
            //                                                         });
            //                                 }
            //                             });
            //                      }
            //                 }
            //                 if(response['data'].answered_player){
            //                     let answered_player = response['data'].answered_player;
            //                     let player_count = response['data'].player_count;
            //                     let selected_color = response['data'].selected_color;
                                
            //                         this.answerList = response['data'].playerAnswerList;
            //                         // let answerPiano =  this.answerList.find(({seleted_color}) => selected_color === 'green');

            //                             console.log('answerPiano:'+this.answerList.length);
            //                         // this.playerNoAnswer = response['data'].playerNoAnswer;

            //        if(getStatusAttempt >= 60 && this.userConfirmedData && playerselectedColor.length > 0){
                                           
            //                         // alert('everyone did answer');
            //                                 clearInterval(getStatusInterval);
            //                                 getStatusAttempt = 0;
            //                                 let timerInterval;
            //                                 this.$swal({
            //                                         title: '全員が選択を完了しました。解答を検証中です。<br/>Validating the answers.',
            //                                         timer: 3000,
            //                                         timerProgressBar: true,
            //                                         allowOutsideClick:false,
            //                                         didOpen: () => {
            //                                             this.$swal.showLoading()
            //                                             const b = this.$swal.getHtmlContainer().querySelector('b')
            //                                             timerInterval = setInterval(() => {
            //                                             b.textContent =  this.$swal.getTimerLeft()
            //                                             }, 100)
            //                                         },
            //                                         willClose: () => {
            //                                             clearInterval(timerInterval)
            //                                         }
            //                                         }).then((result) => {
            //                                                 if(selected_color =='blue' && this.validatedAnswer == false){
            //                                                     this.validatedAnswer = true;
            //                                                     correctSound.play();
            //                                                     this.$emit('pause-time');
                                                                
            //                                                     let gameProgress = JSON.parse(localStorage.getItem('gameProgress'));

            //                                                     axios.post('api/game/store_status',{
            //                                                                 game_event_id: teamSetup.game_event_id,
            //                                                                 teamNumber: teamSetup.playerTeam,
            //                                                                 puzzle_progress: 3,
            //                                                                 player_number: teamSetup.playerName
            //                                                             }).then(response => {
            //                                                                     if(response){
            //                                                                         this.$swal({
            //                                                                             imageUrl: '/images/correct.png',
            //                                                                             width: 524,
            //                                                                             height: 277,
            //                                                                             imageHeight: 267,
            //                                                                             background: '#ffffff20'
            //                                                                         }).then(response => {
                                                                                            
            //                                                                                     this.$router.push({ name: 'mayu_palais.index'})
            //                                                                         });
            //                                                                     }
            //                                                                     else{
            //                                                                         //show db error
            //                                                                         //alert('something went wrong');
            //                                                                     }
            //                                                             });
                                                                
            //                                                 }
            //                                                 else{
            //                                                     this.$swal({
            //                                                         imageUrl: '/images/try_again.png',
            //                                                         width: 524,
            //                                                         height: 277,
            //                                                         imageHeight: 267,
            //                                                         background: '#ffffff20'
            //                                                                 });

            //                                                                 getStatusInterval = setInterval(() => this.getStatus(), 2000);
            //                                                                 this.validatedAnswer = true;
            //                                                 }
            //                                         });
            //         }
                    
            //         if(answered_player >= player_count && this.validatedAnswer == false )  {
            //                         // alert('everyone did answer');
            //                                 clearInterval(getStatusInterval);
            //                                 getStatusAttempt = 0;

            //                                 let timerInterval;
            //                                 this.$swal({
            //                                         title: 'Validating the answers.',
            //                                         timer: 3000,
            //                                         timerProgressBar: true,
            //                                         allowOutsideClick:false,
            //                                         didOpen: () => {
            //                                             this.$swal.showLoading()
            //                                             const b = this.$swal.getHtmlContainer().querySelector('b')
            //                                             timerInterval = setInterval(() => {
            //                                             b.textContent =  this.$swal.getTimerLeft()
            //                                             }, 100)
            //                                         },
            //                                         willClose: () => {
            //                                             clearInterval(timerInterval)
            //                                         }
            //                                         }).then((result) => {
            //                                               if(selected_color =='blue' && this.validatedAnswer == false){
            //                                                     this.validatedAnswer = true;
            //                                                     correctSound.play();
            //                                                     this.$emit('pause-time');
                                                                
            //                                                     let gameProgress = JSON.parse(localStorage.getItem('gameProgress'));


            //                                                     axios.post('api/game/store_status',{
            //                                                                 game_event_id: teamSetup.game_event_id,
            //                                                                 teamNumber: teamSetup.playerTeam,
            //                                                                 puzzle_progress: 3,
            //                                                                 player_number: teamSetup.playerName
            //                                                             }).then(response => {
                                                                            
            //                                                                 //   clearInterval(getStatusInterval_latest);
            //                                                                                 // clearInterval(getStatusInterval);

            //                                                                 if(response){
            //                                                                     this.$swal({
            //                                         imageUrl: '/images/correct.png',
            //                                         width: 524,
            //                                         height: 277,
            //                                         imageHeight: 267,
            //                                         background: '#ffffff20'
            //                                                 }).then(response => {
            //                                                                                  this.$router.push({ name: 'mayu_palais.index'})
            //                                                                     });
            //                                                                 }
            //                                                                 else{
            //                                                                     //show db error
            //                                                                     //alert('something went wrong');
            //                                                                 }
            //                                                             });
                                                                
            //                                                 }
            //                                                 else if(this.validatedAnswer == false){
            //                                                      this.$swal({
            //                                         imageUrl: '/images/try_again.png',
            //                                         width: 524,
            //                                         height: 277,
            //                                         imageHeight: 267,
            //                                         background: '#ffffff20'
            //                                                 });

                                                                            
            //                                                     getStatusInterval = setInterval(() => this.getStatus(), 2000);
            //                                                     this.validatedAnswer = true;
            //                                                 }
            //                                         });
                                  
            //                     }
            //                 }
            //             }).catch(error => {
            //                console.log(error);
            //             });


                 
            },
            selectColor(color){
                getStatusAttempt = 0;
                let swal_title = '';

                    if(this.userConfirmedData){
                        playerselectedColor = color;
                        if(playerselectedColor =='green'){
                            this.greenSelected = true;
                            this.orangeSelected = false;
                            this.redSelected = false;
                            this.blueSelected = false;
                            swal_title = '緑を選択しました。<br/>You selected color green.';
                        }
                        else if(playerselectedColor =='orange'){
                            this.greenSelected = false;
                            this.orangeSelected = true;
                            this.redSelected = false;
                            this.blueSelected = false;
                            swal_title = '黄色を選択しました。<br/>You selected color yellow.';
                        }
                        else if(playerselectedColor == 'red'){
                            this.greenSelected = false;
                            this.orangeSelected = false;
                            this.redSelected = true;
                            this.blueSelected = false;
                            swal_title = '赤を選択しました。<br/>You selected color red.';
                        }
                        else{
                            this.greenSelected = false;
                            this.orangeSelected = false;
                            this.redSelected = false;
                            this.blueSelected = true;
                            swal_title = '青を選択しました。<br/>You selected color blue.';
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
                                                        title:swal_title,
                                                        html: "チーム内の2名が同じボタンを選択すると、解答のセキュリティ分析が開始します。<br/>Once all members of your team enter the same button, your answer will be sent for security analysis",
                                                        
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
                                                        title:'あなたがロボットではないことを確認してください.<br/>Please confirm that you are not a robot.'
                                                       
                                                        
                                                        // icon:'warning',
                                                    }).then((result) =>{
                                                    
                                                    });
                     }
            }
        }
    }
</script>

<style scoped>

    .clickable_image{
        cursor: pointer;
    }


    input[type='checkbox'] {
        width:30px;
        height:30px;
    }

    
    .main_bod{
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-start;
        align-content: flex-start;
        flex-direction: column;
        width: 100%;
        gap: 20px;
    }

    .player_selected_holder{
        display: flex;
        flex-wrap: wrap;
        font-size: 2.5vw;
        font-weight: bold;
        font-family: CA-Geheimagent;
        justify-content: space-around;
        gap: 30px;
    }


    .player_selected{
        display: flex;
        align-items: center;
        gap: 5px;
    }

   .miro_board{
        display: flex;
        position: relative;
        justify-content: flex-start;
        align-content: center;
        flex-wrap: wrap;
        flex-direction: column;
        width: 100vw;
    }



    image{
        object-fit: contain;
    }

    .manual_div{
        display: flex;
        flex-wrap: wrap;
        position: relative;
        justify-content: center;
        align-content: center;
        height: 65vh;
        /* border-style: solid; */
    }
    
    .desk{
        position: absolute;
        border-radius: 10px;
        width: 70%;
        object-fit: contain;
        padding: 0;
    }

    
    .pianoFooter{
        display: flex;
        position: relative;
        align-items: center;
        justify-content: center;
        font-size: 1.5vw;
        font-weight: bold;
        font-family: CA-Geheimagent;
        vertical-align: middle;
        width: 100%;
        text-align: center;
        gap: 5px;
        margin-bottom: 60px;
        z-index: 99;
    }
 
</style>