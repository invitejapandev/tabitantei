<template>
    <div class="teamSelect">
        
         <span class="choose_header">Select team&nbsp;チームを選択してください</span>
        <div class="teamHolder">
            <div  :class="[ teamSelected==n ? 'selected' : '', 'teamButton']" :key="n" v-for="n in teamCount" @click="selectTeam(n)">
                <Team style="color:white" :teamName="n" :selectedId=1 />
            </div>
        </div>
        
        <form hidden>
             <input v-model="nickName" autocomplete="off" id="1" type="text" placeholder="Nick Name" size="13" required hidden/>
             <a class="goButton" @click="submitTeam" hidden>GO! </a>
        </form>

    </div>
    
</template>

<script>
    import Team from './Elements/Team.vue'
    import axios from 'axios'

    let codeResponse,teamSetup;


  export default{
        name: 'TeamSelect',
        data(){
            return {
                teamCount: 5,
                teamSelected: 0,
                nickName: ''
            }
        },
        beforeCreate(){
             codeResponse = JSON.parse(localStorage.getItem('codeResponse'));
           
            if(codeResponse){
                
                 teamSetup = JSON.parse(localStorage.getItem('teamSetup'));
                
                if(teamSetup){
                    if(teamSetup.game_event_id == codeResponse.id && teamSetup.playerTeam){
                        // let gameProgress = JSON.parse(localStorage.getItem('gameProgress'));
                        // if(gameProgress && gameProgress.game_event_id == codeResponse.id){

                        //     switch(gameProgress.puzzleProgress){
                        //         case 1:
                        //             this.$router.push({ name: 'main.index1' });
                        //             break;
                        //         case 2: 
                        //             this.$router.push({ name: 'main.computer' });
                        //             break;
                        //         case 3: 
                        //             this.$router.push({ name: 'main.piano' });
                        //             break;
                        //         case 4: 
                        //             this.$router.push({ name: 'main.map1' });
                        //             break;
                        //         case 5: 
                        //             this.$router.push({ name: 'main.map2' });
                        //             break;
                        //         case 6: 
                        //             this.$router.push({ name: 'main.semaphore' });
                        //             break;
                        //         case 7: 
                        //             this.$router.push({ name: 'security.index' });
                        //             break;
                        //         case 8: 
                        //             this.$router.push({ name: 'cafe.index' });
                        //             break;
                        //         case 9: 
                        //             this.$router.push({ name: 'graffiti.index' });
                        //             break;
                        //     }
                        // }
                        // else{
                        //     this.$router.push({ name: 'introduction.index' });
                        // }

                        axios.post('api/game/get_status_last_specific',{
                        game_event_id: codeResponse.id,
                        playerTeam: teamSetup.playerTeam
                        }).then(response => {
                            // alert(response.data);
                                 if(response.data <3){
                                                        this.$router.push({ name: 'welcome.index' });
                                                    }
                                 else if(response.data <6){
                                     this.$router.push({ name: 'karuizawa.index' });
                                 }
                                    else if(response.data <9){
                                     this.$router.push({ name: 'sendai.index' });
                                 }
                                    else if(response.data <=12){
                                     this.$router.push({ name: 'asakusa.index' });
                                 }
                            //Create handling to redirect to specific puzzle.
                        });
                    }
                }

            }
            else{
                 this.$router.push({ name: 'login.index' });
            }
        },
        components:{
            Team
        },
        methods:{
            selectTeam(n){
                this.teamSelected = n;
                
                this.$swal({
                        html:`<strong><h3>Select team チームを選択してください</h3></strong>
                        <p>As you move through the game, it will be necessary to communicate with your teammates. Start now by confirming your team number with everyone.<br/>
                        ゲームを進めるにあたって、チームメイトとのコミュニケーションが必要になってきます。まずは、ご自身のチーム名とプレイヤー番号をチームの皆さんと一緒に確認するところから始めましょう。</p>`,
                        showCancelButton: true,
                        showClass: {
                            popup: 'animate__animated animate__fadeInDown'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOutUp'
                        },
                        background: 'url(/images/book_bg.png)',
                        width: 497,
                        customClass: { popup:'swal-height',
                        actions: 'action-class'},
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: "Ok",
                        cancelButtonText: "Cancel 取り消す",
                    }).then((result) =>{
                       if (result.isConfirmed) {
                           let codeResponse = JSON.parse(localStorage.getItem('codeResponse'));
                           
                           if(codeResponse){
                                axios.post('api/game/store_player',{
                                    game_event_id: codeResponse.id,
                                    teamNumber: this.teamSelected
                                }).then(response => {
                                    console.log(response);
                                    
                                    if(response){
                                        let teamSetup = {
                                            playerName : 'Player '+response['data'],
                                            playerTeam : this.teamSelected,
                                            game_event_id : codeResponse.id
                                        }

                                        localStorage.setItem('teamSetup', JSON.stringify(teamSetup));

                                          axios.post('api/game/get_status_last_specific',{
                                            game_event_id: codeResponse.id,
                                            playerTeam: this.teamSelected
                                            }).then(response => {
                                                // alert(response.data);
                                                   if(response.data <3){
                                                        this.$router.push({ name: 'welcome.index' });
                                                    }
                                                    else if(response.data <6){
                                                        this.$router.push({ name: 'karuizawa.index' });
                                                    }
                                                    else if(response.data <9){
                                                        this.$router.push({ name: 'sendai.index' });
                                                    }
                                                    else if(response.data <=12){
                                                        this.$router.push({ name: 'asakusa.index' });
                                                    }
                                                    else{
                                                        this.$router.push({ name: 'welcome.index' });
                                                    }

                                                //Create handling to be redirected to other puzzles.
                                            });
                                    }
                                    else{
                                        alert('something went wrong');
                                    }
                                });
                            }
                       }
                    });

            },
            submitTeam(){

                
                if(this.teamSelected == 0){
                     this.$swal({
                                title:'Please select team first.',
                                icon:'warning'    
                                        });
                    return;
                }


                 if(this.nickName == ''){

                    this.$swal({
                                title:'Please provide nick name.',
                                icon:'warning'    
                                        });
                    return;
                }

                let codeResponse = JSON.parse(localStorage.getItem('codeResponse'));

                if(codeResponse){
                    axios.post('api/game/store_player',{
                        game_event_id: codeResponse.id,
                        teamNumber: this.teamSelected,
                        nickName: this.nickName
                    }).then(response => {
                        console.log(response);
                        
                        localStorage.setItem('playerName', this.nickName);
                        localStorage.setItem('playerTeam', this.teamSelected)
                                    this.$router.push({ name: 'main.index' })
                    });
                }

                // axios.post('api/game/validate_key',{
                //     code: this.item.name
                // }).then(response => {
                //     if(response.status == 200 || response.status == 200){
                //         console.log(response);
                //     }
                // }).catch( error => {
                //     console.log(error);
                // })
                console.log(this.nickName);
            }
        }
    }
</script>
<style scoped>

.title-class{
    font-size: 1999px;
}

.testingclass{
    font-weight: bolder;
    font-size: 1em;
}

.swal-height {
  height: 399px;
}

.action-class{
    position: fixed;
    bottom: 8px;
    right: 15px;
}

</style>

<style scoped>



    .teamSelect{
        position: relative;
        display:flex;
        flex-wrap: wrap;
        flex-direction: column;
        align-content: center;
        justify-content: start;
        align-items: center;
        gap: 20px;
    width: 100%;
    height: 100%;
        background-image: url('../assets/main_bg.jpg') !important;
        background-size: cover;
        background-repeat: no-repeat;
    }


     .choose_header{
         margin-top: 50px;
        font-size: 3vw;
        text-align: center;
        top:  3%;
        color: black;
        font-weight: regular;
    font-family: 'Covered By Your Grace', cursive;
        /* letter-spacing: 7px; */
        z-index: 2;
    }



    .teamHolder{
        width: 80%;
        z-index: 2;
        display:flex;
        flex-wrap: wrap;
        margin-top: 20px;
        align-content: start;
        justify-content: center;
        /* row-gap: 1rem;
        column-gap: 1rem; */
        flex-grow: 1;
    }
    

    button{
        color: white !important;
    }

.teamButton{
    text-align: center;
    width: 35%;
    margin-left: 20px;
    padding: 1rem;
    padding-right: 3rem;
    padding-left: 3rem;
    font-size: 1.5vw;
    margin: 10px;
    letter-spacing: 9px;
    font-weight: bold ;
    color: white !important;
    background-color:#12cdd4;
     cursor: pointer;
}

.teamButton.selected{
    background-color: rgba(180, 10, 10, 0.65);
}

</style>

<style scoped>
input{
    font-size: 3rem;
    text-align: center;
    padding: 1rem;
    text-transform: uppercase;
    font-weight: bold;
}

form{   
        margin-top: 20px;
        display:flex;
        align-content: center;
        justify-content: center;
}

.goButton{
    margin-left: 20px;
    padding: 1rem;
    font-size: 3rem;
    margin: 10px;
    color:white;
    background-color: rgb(32, 32, 46);
     cursor: pointer;
}



/* 

@media only screen and (max-width: 600px) {
    .teamButton{
        font-size: 1rem;
    }

    
    .teamHolder{
        z-index: 2;
        display:flex;
        flex-wrap: wrap;
        align-content: center;
        justify-content: center;
        row-gap: 1rem;
        column-gap: 4rem;
        margin-top: 300px;
    }
}



@media only screen and (max-width: 500px) {
    .teamButton{
        margin-left: 10px;
        padding: 1rem;
        padding-right: 1rem;
        padding-left: 1rem;
        font-size: 1rem;
        margin: 5px;
        letter-spacing: 4px;
    }

    .teamHolder{
        z-index: 2;
        display:flex;
        flex-wrap: wrap;
        align-content: center;
        justify-content: center;
        row-gap: 1rem;
        column-gap: 4rem;
        margin-top: 300px;
    }
} */
</style>