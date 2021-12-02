<template>
    <div class="teamSelect">
        
        <span class="choose_header">CHOOSE YOUR MISSION</span>
        <div class="teamHolder">
            <!-- <div :class="[ teamSelected==n ? 'selected' : '', 'teamButton']" :key="n" v-for="n in teamCount" @click="selectTeam(n)">
                <Team :teamName="n" :selectedId=1 />
            </div> -->
            <div @click="selectGame('Semaphore')" class="missionHolder">
                <span style="text-align: center;">Semaphore</span>
                <div class="missionBox"> <img :src="semaphore_img" style="width: 21rem; height: 21rem; "/></div>
            </div>

            <div @click="selectGame('Cafe')" class="missionHolder">
                <span style="text-align: center;">Cafe</span>
                 <div class="missionBox">  <img :src="cafe_img" style="width: 21rem; height: 21rem; "/></div>
            </div>

            <div @click="selectGame('Security')" class="missionHolder">
                <span style="text-align: center;">Security</span>
                <div class="missionBox "> <img :src="security_img" style="width: 21rem; height: 21rem; "/></div>
            </div>

            <div @click="selectGame('Graffiti')" class="missionHolder">
                <span style="text-align: center;">Graffiti</span>
                <div class="missionBox"> <img :src="graffiti_img" style="width: 21rem; height: 21rem; "/></div>
            </div>

            <!-- <div class="missionBox"> <img src="../assets/bw_semaphore.png" style="width: 21rem; height: 21rem; "/></div> -->
           
            
            
        </div>
        

    </div>
    
</template>

<script>
    import Team from './Elements/Team.vue'
    import axios from 'axios'

    let codeResponse, teamSetup;
let getStatusInterval;

  export default{
        name: 'TeamSelect',
        data(){
            return {
                teamCount: 10,
                teamSelected: 0,
                nickName: '',
                semaphore_img: './images/bw_semaphore.png',
                semaphore_solved: false,
                cafe_img: './images/bw_cafe.png',
                cafe_solved: false,
                security_img: './images/bw_security.png',
                security_solved: false,
                graffiti_img: './images/bw_graffiti.png',
                graffiti_solved: false,
            }
        },
        beforeMount(){
            
            codeResponse = JSON.parse(localStorage.getItem('codeResponse'));
            teamSetup = JSON.parse(localStorage.getItem('teamSetup'));


             axios.post('api/game/get_status_last',{
                        game_event_id: codeResponse.id,
                        playerTeam: teamSetup.playerTeam
                        }).then(response => {
                            for(var i =0; i< response.data.length; i++){
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
        beforeCreate(){
             codeResponse = JSON.parse(localStorage.getItem('codeResponse'));
             getStatusInterval = setInterval(() => this.getSelectedMission(), 2000);

            if(codeResponse){
                
                 teamSetup = JSON.parse(localStorage.getItem('teamSetup'));
                
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
            getSelectedMission(){
                 axios.post('api/game/get_selected_mission',{
                            game_event_id: codeResponse.id,
                            playerTeam: teamSetup.playerTeam,
                            player_number: teamSetup.playerName
                        }).then(response => {
                            if(response){
                                if(response.data['puzzle_number'] > 0){
                                    let puz_num = response.data['puzzle_number'];
                                    clearInterval(getStatusInterval);
                                    this.$swal({
                                            title:'One of your teammates selected a mission. Everyone will be redirected.',
                                            icon:'info'    
                                        }).then((result) =>{
                                            
                                                axios.post('api/game/update_team_mission',{
                                                    game_event_id: codeResponse.id,
                                                    playerTeam: teamSetup.playerTeam,
                                                    player_name: teamSetup.playerName,
                                                    puzzle_number: puz_num
                                                }).then(response => {
                                                });


                                            if(puz_num == 6)
                                                this.$router.push({ name: 'main.semaphore' });
                                            if(puz_num == 7)
                                                this.$router.push({ name: 'security.index' });
                                            if(puz_num == 8)
                                                this.$router.push({ name: 'cafe.index' });
                                            if(puz_num == 9)
                                                this.$router.push({ name: 'graffiti.index' });


                                            // localStorage.setItem('codeResponse', JSON.stringify(response['data'][0]));
                                        });
                                }
                            }
                        });
            },
            selectGame(gameName){
                //  this.$router.push({ name: 'main.index' })
                if(gameName == 'Semaphore' && this.semaphore_solved == true){
                     this.$swal({
                                                    title:'Your team cleared the '+gameName+' mission. Please select another mission.',
                                                    icon:'info'    
                                                            });
                }
                else if(gameName == 'Cafe' && this.cafe_solved == true){
                     this.$swal({
                                                    title:'Your team cleared the '+gameName+' mission. Please select another mission.',
                                                    icon:'info'    
                                                            });
                }
                else if(gameName == 'Security' && this.security_solved == true){
                     this.$swal({
                                                    title:'Your team cleared the '+gameName+' mission. Please select another mission.',
                                                    icon:'info'    
                                                            });
                }
                else if(gameName == 'Graffiti' && this.graffiti_solved == true){
                     this.$swal({
                                                    title:'Your team cleared the '+gameName+' mission. Please select another mission.',
                                                    icon:'info'    
                                                            });
                }
                else{
                    this.$swal({
                        title:'Are you sure want to select the '+gameName+' mission?',
                        text: "Everyone will be redirected after confirmation.",
                        // icon:'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: "Yes"
                    }).then((result) =>{
                       if (result.isConfirmed) {
                            codeResponse = JSON.parse(localStorage.getItem('codeResponse'));

                            let SelectedpuzzleNumber = 0;
                            if(gameName == 'Semaphore'){
                                SelectedpuzzleNumber = 6;
                            }
                            else if(gameName == 'Security'){
                                SelectedpuzzleNumber = 7;
                            }
                            else if(gameName == 'Cafe'){
                                SelectedpuzzleNumber = 8;
                            }
                            else if(gameName == 'Graffiti'){
                                SelectedpuzzleNumber = 9;
                            }
                           
                           if(codeResponse){
                                axios.post('api/game/store_team_mission',{
                                    game_event_id: codeResponse.id,
                                    playerTeam: teamSetup.playerTeam,
                                    player_name: teamSetup.playerName,
                                    puzzle_number: SelectedpuzzleNumber
                                }).then(response => {
                                    // console.log(response);
                                    clearInterval(getStatusInterval);

                                    if(response){
                                         if(SelectedpuzzleNumber == 6)
                                                this.$router.push({ name: 'main.semaphore' });
                                            if(SelectedpuzzleNumber == 7)
                                                this.$router.push({ name: 'security.index' });
                                            if(SelectedpuzzleNumber == 8)
                                                this.$router.push({ name: 'cafe.index' });
                                            if(SelectedpuzzleNumber == 9)
                                                this.$router.push({ name: 'graffiti.index' });
                                    }
                                    else{
                                        alert('something went wrong');
                                    }
                                });
                            }
                       }
                    });
                }
            }
        }
    }
</script>

<style scoped>

    .missionBox{
        display: flex;
        flex-wrap: wrap;
        align-content: center;
        justify-content: center;
        height: 20rem;
        width: 20rem;
        border-radius: 50%;
        padding: 0px;
        margin:0px;
        background-color: black;
        cursor: pointer;
    }

    missionBox.unlocked{
        background-color: transparent;
    }

    .missionHolder{
        display: flex;
        flex-wrap: wrap;
        flex-direction: column;
        gap: 20px;
        align-content: center;
        justify-content: center;
        color:white;
        font-size: 3rem;
        font-weight: bold;
        font-family: CA-Geheimagent;
    }

    .teamSelect{
        position: relative;
        display:flex;
        flex-wrap: wrap;
        flex-direction: row;
        align-content: center;
        justify-content: center;
        width: 100%;
        height: 100%;
        min-height: 900px;
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
        top: 10%;
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