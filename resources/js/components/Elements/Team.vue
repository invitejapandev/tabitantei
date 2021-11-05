<template>
    <a style="color:white; text-decoration: none" href="#">Team {{ teamName }}</a>
</template>

<script>
export default {
    name:'Team',
    props:{
        teamName: Number
    }
}
</script>

<style>
</style>