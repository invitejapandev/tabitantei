<template>
    <div class="playerTeamName">
        <h1 class="header_div">TEAM {{ playerTeam }} - {{playerNameStored}}</h1>
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
        flex-wrap: wrap;
        justify-content: center;
        align-content: center;
        margin-left: 20px;
    }

    h1{
        font-size: 2.5vw;    
       font-weight: bolder;
       align-content: center;
    }
</style>