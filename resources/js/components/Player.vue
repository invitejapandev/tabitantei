<template>
    <div class="playerTeamName">
        <h1>TEAM {{ playerTeam }} - {{playerNameStored}}</h1>
    </div>
</template>

<script>
    export default {
        name: 'Player',
        mounted(){

            let teamSetup = JSON.parse(localStorage.getItem('teamSetup'));
            if(teamSetup){
                this.playerNameStored = teamSetup.playerName;
                this.playerTeam = teamSetup.playerTeam;
            }
            else{
                this.$router.push({ name: 'login.index' });
            }
        },
        data(){
            return{
                playerTeam: 0,
                playerNameStored: 'Jet'
            }
        },
        props: {
            playerName: String,
            teamName: String
        }
    }
</script>

<style scoped>
    .playerTeamName{
        display: flex;
        justify-content: center;
        align-content: center;
    }

    h1{
        font-size: 3rem;    
       font-weight: bolder;
    }
</style>