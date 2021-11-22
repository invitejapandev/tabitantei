<template>
    <div class="teamSelect">
        
         <span class="choose_header">CHOOSE&nbsp;&nbsp;YOUR&nbsp;&nbsp;TEAM</span>
        <div class="teamHolder">
            <div :class="[ teamSelected==n ? 'selected' : '', 'teamButton']" :key="n" v-for="n in teamCount" @click="selectTeam(n)">
                <Team :teamName="n" :selectedId=1 />
            </div>
        </div>
        
        <form hidden>
             <input v-model="nickName" autocomplete="off" id="1" type="text" placeholder="Nick Name" size="13" required hidden/>
             <a class="goButton" @click="submitTeam" hidden>GO! </a>
        </form>
        
         <img class="login-logo" src="../assets/green_logo.png" />

    </div>
    
</template>

<script>
    import Team from './Elements/Team.vue'
    import axios from 'axios'


  export default{
        name: 'TeamSelect',
        data(){
            return {
                teamCount: 10,
                teamSelected: 0,
                nickName: ''
            }
        },
        beforeCreate(){
            let codeResponse = JSON.parse(localStorage.getItem('codeResponse'));
           
            if(codeResponse){
                
                let teamSetup = JSON.parse(localStorage.getItem('teamSetup'));
                
                if(teamSetup){
                    if(teamSetup.game_event_id == codeResponse.id && teamSetup.playerTeam){
                        let gameProgress = JSON.parse(localStorage.getItem('gameProgress'));
                        if(gameProgress && gameProgress.game_event_id == codeResponse.id){

                            switch(gameProgress.puzzleProgress){
                                case 1:
                                    this.$router.push({ name: 'main.index1' });
                                    break;
                                case 2: 
                                    this.$router.push({ name: 'main.computer' });
                                    break;
                            }
                        }
                        else{
                            this.$router.push({ name: 'introduction.index' });
                        }
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
                        title:'Are you sure want to select Team '+n+'?',
                        text: "You might not be able to change team after this.",
                        // icon:'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: "Yes, let's Go!"
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

                                        this.$router.push({ name: 'introduction.index' })
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




    .teamSelect{
        position: relative;
        display:flex;
        flex-wrap: wrap;
        flex-direction: row;
        align-content: center;
        justify-content: center;
        width: 100%;
        height: 100%;
    }

    .login-logo{
        position: absolute;
        top: 20%;
        width: 100%;
        max-width: 708px;
        z-index: 1;
    }

    .choose_header{
        position: absolute;
        font-size: 7vw;
        top:  3%;
        color: white;
        font-weight: regular;
        font-family: CA-Geheimagent;
        letter-spacing: 7px;
    }



    .teamHolder{
        z-index: 2;
        display:flex;
        flex-wrap: wrap;
        align-content: center;
        justify-content: center;
        row-gap: 5rem;
        column-gap: 4rem;
    }
    
.teamButton{
    margin-left: 20px;
    padding: 1.5rem;
    padding-right: 3rem;
    padding-left: 3rem;
    font-size: 2rem;
    margin: 10px;
    letter-spacing: 9px;
    background-color: rgba(255,255,255,0.65);
    font-family: CA-Geheimagent;
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



@media only screen and (max-width: 1200px) {
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
        margin-top: 0%
    }
}


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
        margin-top: -40%
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
        margin-top: -70%
    }
}
</style>