<template>
    <h1>TEAM {{ playerTeam }} - {{playerNameStored}}</h1>
</template>

<script>
    export default {
        name: 'Player',
        mounted(){
            this.playerNameStored = localStorage.getItem('playerName');
            this.playerTeam = localStorage.getItem('playerTeam');
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
    h1{
        font-size: 3rem;    
       font-weight: bolder;
    }
</style>