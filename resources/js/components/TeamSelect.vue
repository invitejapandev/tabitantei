<template>
    <div class="teamHolder">
        <div class="teamButton" :key="n" v-for="n in teamCount" >
            <Team :teamName="n"/>
        </div>
    </div>
</template>

<script>
    import Team from './Elements/Team.vue'


  export default{
        name: 'TeamSelect',
        data(){
            return {
                teamCount: 5
            }
        },
        beforeCreate(){
            console.log(JSON.parse(localStorage.getItem('codeResponse')));
        },
        components:{
            Team
        }
    }
</script>

<style>
    .teamHolder{
        display:flex;
        width: 100vw;
        height: 100vh;
        flex-wrap: wrap;
        align-content: center;
        justify-content: center;
    }
    
.teamButton{
    margin-left: 20px;
    padding: 1rem;
    font-size: 2rem;
    border-style: solid;
    margin: 10px;
    background-color: blue;
     font-family: "Lucida Console", "Courier New", monospace;
}
</style>