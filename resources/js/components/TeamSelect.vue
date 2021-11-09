<template>
    <div class="teamSelect">
        <div class="teamHolder">
            <div :class="[ teamSelected==n ? 'selected' : '', 'teamButton']" :key="n" v-for="n in teamCount" @click="selectTeam(n)">
                <Team :teamName="n" :selectedId=1 />
            </div>
        </div>
        
        <form>
             <input v-model="nickName" autocomplete="off" id="1" type="text" placeholder="Nick Name" size="13" required/>
             <a class="goButton" @click="submitTeam">GO! </a>
        </form>
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
            console.log(JSON.parse(localStorage.getItem('codeResponse')));
        },
        components:{
            Team
        },
        methods:{
            selectTeam(n){
                this.teamSelected = n;
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


                axios.post('api/game/store_player',{
                    game_event_id: 1,
                    teamNumber: this.teamSelected,
                    nickName: this.nickName
                }).then(response => {
                    console.log(response);
                    
                      localStorage.setItem('playerName', this.nickName);
                      localStorage.setItem('playerTeam', this.teamSelected)
                                this.$router.push({ name: 'main.index' })
                });

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

<style>

    .teamSelect{
        display:flex;
        flex-wrap: wrap;
        flex-direction: column;
        width: 100vw;
        height: 100vh;
        align-content: center;
        justify-content: center;
    }

    .teamHolder{
        display:flex;
        flex-wrap: wrap;
        align-content: center;
        justify-content: center;
    }
    
.teamButton{
    margin-left: 20px;
    padding: 1rem;
    font-size: 2rem;
    margin: 10px;
    background-color: blue;
     font-family: "Lucida Console", "Courier New", monospace;
     cursor: pointer;
}

.teamButton.selected{
    background-color: green;
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

</style>