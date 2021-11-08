<template>
    <h1>TEAM {{ teamName }} - {{playerName}}</h1>
</template>

<script>
    export default {
        name: 'Player',
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