<template>
    <h1>{{playerName}} s- Team {{ teamName }}</h1>
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

<style>
</style>