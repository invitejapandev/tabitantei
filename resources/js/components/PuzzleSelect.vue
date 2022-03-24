<template>
    <div class="teamSelect">
        
        <span class="choose_header">CHOOSE YOUR MISSION</span>
        <div class="teamHolder">
            <!-- <div :class="[ teamSelected==n ? 'selected' : '', 'teamButton']" :key="n" v-for="n in teamCount" @click="selectTeam(n)">
                <Team :teamName="n" :selectedId=1 />
            </div> -->
            <div @click="selectGame('Tower View')" class="missionHolder">
                <span style="text-align: center;">Tower View</span>
                <div style="flex-" :class="[semaphore_solved ? 'unlocked':'', 'missionBox']"> <img class="final_icon" :src="semaphore_img"/></div>
            </div>

            <div @click="selectGame('Café la Parisienne')" class="missionHolder">
                <span style="text-align: center;">Café la Parisienne</span>
                 <div :class="[cafe_solved ? 'unlocked':'', 'missionBox']">  <img  class="final_icon" :src="cafe_img" /></div>
            </div>

            <div @click="selectGame('Maison de Verre')" class="missionHolder">
                <span style="text-align: center;">Maison de Verre</span>
                <div :class="[security_solved ? 'unlocked':'', 'missionBox']"> <img class="final_icon" :src="security_img" /></div>
            </div>

            <div @click="selectGame('Graffiti Mural')" class="missionHolder">
                <span style="text-align: center;">Graffiti Mural</span>
                <div :class="[graffiti_solved ? 'unlocked':'', 'missionBox']"> <img class="final_icon" :src="graffiti_img" /></div>
            </div>

            <!-- <div class="missionBox"> <img src="../assets/bw_semaphore.png" style="width: 320px;; height: 320px;; "/></div> -->
           
            
            
        </div>
        

    </div>
    
</template>

<script>
    import Team from './Elements/Team.vue'
    import axios from 'axios'
let SelectedpuzzleNumber = 0;
    let codeResponse, teamSetup;
let getStatusInterval;
let completedPuzzle = 0;

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
                                    completedPuzzle = completedPuzzle+ 1;
                                }
                                if(response.data[i]['puzzle_progress'] == 7){
                                    this.security_img= './images/color_security.png';
                                    this.security_solved = true;
                                    completedPuzzle = completedPuzzle+ 1;
                                }
                                if(response.data[i]['puzzle_progress'] == 8){
                                    this.cafe_img= './images/color_cafe.png';
                                    this.cafe_solved = true;
                                    completedPuzzle = completedPuzzle+ 1;
                                }
                                if(response.data[i]['puzzle_progress'] == 9){
                                    this.graffiti_img= './images/color_graffiti.png';
                                    this.graffiti_solved = true;
                                    completedPuzzle = completedPuzzle+ 1;
                                }
                            }
                            
                if(completedPuzzle == 4){
                    this.$router.push({name: 'finale.index' })
                }
                        });
        },
        beforeCreate(){
             codeResponse = JSON.parse(localStorage.getItem('codeResponse'));
             getStatusInterval = setInterval(() => this.getSelectedMission(), 2000);

            // if(codeResponse){
                
            //      teamSetup = JSON.parse(localStorage.getItem('teamSetup'));
                
            //     if(teamSetup){
            //         if(teamSetup.game_event_id == codeResponse.id && teamSetup.playerTeam){
            //             let gameProgress = JSON.parse(localStorage.getItem('gameProgress'));
            //             if(gameProgress && gameProgress.game_event_id == codeResponse.id){

            //                 switch(gameProgress.puzzleProgress){
            //                     case 1:
            //                         this.$router.push({ name: 'main.index1' });
            //                         break;
            //                     case 2: 
            //                         this.$router.push({ name: 'main.computer' });
            //                         break;
            //                 }
            //             }
            //             else{
            //                 this.$router.push({ name: 'introduction.index' });
            //             }
            //         }
            //     }

            // }
            // else{
            //      this.$router.push({ name: 'login.index' });
            // }
        },
        components:{
            Team
        },
        methods:{
            getSelectedMission(){
                 axios.post('api/game/get_selected_mission',{
                            game_event_id: codeResponse.id,
                            playerTeam: teamSetup.playerTeam,
                            player_number: teamSetup.playerName,
                            puzzle_number: SelectedpuzzleNumber
                        }).then(response => {
                            if(response){
                                if(response.data['puzzle_selected'] >0){
                                    let puz_num = response.data['puzzle_selected'];
                                    clearInterval(getStatusInterval);
                                    this.$swal({
                                            title:'チームがミッションを選択しました。<br/>これから次のミッションエリアに転送されます。<br/>Your team has chosen a mission. You will now be redirected.',
                                            icon:'info'    
                                        }).then((result) =>{
                                            
                                                // axios.post('api/game/update_team_mission',{
                                                //     game_event_id: codeResponse.id,
                                                //     playerTeam: teamSetup.playerTeam,
                                                //     player_name: teamSetup.playerName,
                                                //     puzzle_number: puz_num
                                                // }).then(response => {
                                                // });


                                            if(puz_num == 6)
                                                this.$router.push({ name: 'tower_intro.index' });
                                            if(puz_num == 7)
                                                this.$router.push({ name: 'mdv_intro.index' });
                                            if(puz_num == 8)
                                                this.$router.push({ name: 'cafe_intro.index' });
                                            if(puz_num == 9)
                                                this.$router.push({ name: 'graffiti_intro.index' });


                                            // localStorage.setItem('codeResponse', JSON.stringify(response['data'][0]));
                                        });
                                }
                            }
                        });
            },
            selectGame(gameName){
                //  this.$router.push({ name: 'main.index' })
                if(gameName == 'Tower View' && this.semaphore_solved == true){
                     this.$swal({
                                                    title:'['+gameName+'] のミッションをクリアしました。次のミッションを選択してください。<br/>Your team cleared the '+gameName+' mission. Please select another mission.',
                                                    icon:'info'    
                                                            });
                }
                else if(gameName == 'Café la Parisienne' && this.cafe_solved == true){
                     this.$swal({
                                                    title:'['+gameName+'] のミッションをクリアしました。次のミッションを選択してください。<br/>Your team cleared the '+gameName+' mission. Please select another mission.',
                                                    icon:'info'    
                                                            });
                }
                else if(gameName == 'Maison de Verre' && this.security_solved == true){
                     this.$swal({
                                                    title:'['+gameName+'] のミッションをクリアしました。次のミッションを選択してください。<br/>Your team cleared the '+gameName+' mission. Please select another mission.',
                                                    icon:'info'    
                                                            });
                }
                else if(gameName == 'Graffiti Mural' && this.graffiti_solved == true){
                     this.$swal({
                                                    title:'['+gameName+'] のミッションをクリアしました。次のミッションを選択してください。<br/>Your team cleared the '+gameName+' mission. Please select another mission.',
                                                    icon:'info'    
                                                            });
                }
                else{
                    this.$swal({
                        title:'['+gameName+']のミッションを選択しますか？<br/>Are you sure want to select the '+gameName+' mission?',
                        html: "確定後、全員が次のミッションエリアに転送されます。<br/>Everyone will be redirected after confirmation.",
                        // icon:'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: "Yes"
                    }).then((result) =>{
                       if (result.isConfirmed) {
                            codeResponse = JSON.parse(localStorage.getItem('codeResponse'));

                            
                            if(gameName == 'Tower View'){
                                SelectedpuzzleNumber = 6;
                            }
                            else if(gameName == 'Maison de Verre'){
                                SelectedpuzzleNumber = 7;
                            }
                            else if(gameName == 'Café la Parisienne'){
                                SelectedpuzzleNumber = 8;
                            }
                            else if(gameName == 'Graffiti Mural'){
                                SelectedpuzzleNumber = 9;
                            }
                           
                           if(codeResponse){
                                axios.post('api/game/store_team_mission',{
                                    game_event_id: codeResponse.id,
                                    playerTeam: teamSetup.playerTeam,
                                    player_name: teamSetup.playerName,
                                    puzzle_number: SelectedpuzzleNumber
                                }).then(response => {
                                    this.$swal({
                                            title:'ミッションを選択しました。（次へ進むには、2名以上が同じミッションを選択する必要があります。）<br/>You have voted for a mission. Minimum of two players should vote for the same mission.',
                                            icon:'info'    
                                        }).then((result) =>{});
                                    // console.log(response);
                                    // clearInterval(getStatusInterval);

                                    // if(response.data != 0){
                                    //      if(SelectedpuzzleNumber == 6)
                                    //             this.$router.push({ name: 'tower_intro.index' });
                                    //         if(SelectedpuzzleNumber == 7)
                                    //             this.$router.push({ name: 'mdv_intro.index' });
                                    //         if(SelectedpuzzleNumber == 8)
                                    //             this.$router.push({ name: 'cafe_intro.index' });
                                    //         if(SelectedpuzzleNumber == 9)
                                    //             this.$router.push({ name: 'graffiti_intro.index' });
                                    // }
                                    // else{
                                    //     this.$swal({
                                    //         title:'One player already selected a mission.',
                                    //         icon:'info'    
                                    //     }).then((result) =>{
                                    //     });
                                    // }

                                    
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


    .teamSelect{
        position: relative;
        display:flex;
        flex-wrap: wrap;
        flex-direction: column;
        align-content: center;
        justify-content: center;
        width: 100%;
        height: 100%;
        gap: 100px;
    }

    .missionHolder{
        display: flex;
        flex-wrap: wrap;
        flex-direction: column;
        gap: 20px;
        justify-content: center;
        align-content: center;
        color:white;
        font-size: 3rem;
        font-weight: bold;
        font-family: CA-Geheimagent;
    }


    .missionBox{
        display: flex;
        flex-wrap: wrap;
        align-content: center;
        justify-content: center;
        border-radius: 50%;
        padding: 0px;
        margin:0px;
        background-color: black;
        cursor: pointer;
    }

    .unlocked{
        background-color: transparent;
    }

    .choose_header{
        text-align: center;
        font-size: 7vw;
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

.final_icon{
    width: 320px;
    height: 320px;
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






/* @media only screen and (max-width: 500px) {
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
} */

/* Small */
@media (min-width: 600px) {
      .final_icon{
        width: 250px;
        height: 250px;
    }

    .missionBox{
        width: 250px;
        height: 250px;
    }
  }
  
/* Medium */
@media (min-width: 1252px) { 

    .final_icon{
        width: 250px;
        height: 250px;
    }

    .missionBox{
        width: 250px;
        height: 250px;
    } 
 }
  
/* Large */
@media (min-width: 1370px) { 
    .final_icon{
        width: 250px;
        height: 250px;
    }

    .missionBox{
        width: 250px;
        height: 250px;
    } 
    }
  
/* X-Large */
@media (min-width: 1500px) { 
    .final_icon{
        width: 320px;
        height: 320px;
    }


    .missionBox{
        width: 320px;
        height: 320px;
    } 
    }


</style>