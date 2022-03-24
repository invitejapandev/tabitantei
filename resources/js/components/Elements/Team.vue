<template>
    <a style="
    color:black !important; text-decoration: none" @click="onSelect(teamName)" href="#">TEAM {{ teamName }}</a>
</template>

<script>
export default {
    name:'Team',
    props:{
        teamName: Number,
        selectedTeam: Number
    },
    methods:{
        onSelect(teamName){
            this.$emit('selectTask', teamName)
        }
    }
}
</script>
