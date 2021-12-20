<template>
<div class="facilitatorContainer">
    <div class="helpContainer">
        <div v-for="(item, index) in helpList" :key="index">
            <div class="helpBubble"  v-if="item.isDone == 0" >
                <div   class="helpDetails">{{item.player_name}} of Team {{item.team_number}} is asking for help. They are on puzzle: 
                    <span v-if="item.puzzle_number == 1">Floor</span>
                    <span v-if="item.puzzle_number == 2">Computer</span>
                    <span v-if="item.puzzle_number == 3">Piano</span>
                    <span v-if="item.puzzle_number == 4">Opera</span>
                    <span v-if="item.puzzle_number == 5">Tour</span>
                    <span v-if="item.puzzle_number == 6">Semaphore</span>
                    <span v-if="item.puzzle_number == 7">Security</span>
                    <span v-if="item.puzzle_number == 8">Cafe</span>
                    <span v-if="item.puzzle_number == 9">Graffiti</span>
                </div>
                <div class="helpAction"><input @click="HelpStatusTriggered(item.id)" style="z-index:99" type="checkbox"/></div>
            </div>
        </div>
        
        
    </div>
   
</div>
  
</template>

<script>

    import axios from 'axios';
    let temphelpList;
    let getStatusInterval;
export default {
        name: 'Factilitator',
        data(){
            return {
                outputText : '',
                inc:0,
                helpList: null
            }
        },
        beforeCreate(){
          getStatusInterval = setInterval(() => this.getStatus(), 5000);
        },
        mounted(){
        },
        created(){
        },
        methods:{
            HelpStatusTriggered(val){
                // alert(val);
                let objIndex = this.helpList.findIndex((obj => obj.id == val));
                this.helpList[objIndex].isDone = 1;

                axios.post('api/game/update_help',{
                                    id: val
                                }).then(response => {
                                    if(response){
                                          this.$swal({
                                            title:'Tagged as done.',
                                            icon:'success'}).then(response => {
                                                
                                            });
                                    }
                                });
            },
            getStatus(){
                 axios.post('api/game/game_help_list',{
                                }).then(response => {
                                    if(response){
                                        this.helpList = response.data;
                                    }
                                });
            }
        }
}
</script>

<style scoped>
    .facilitatorContainer{
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-content: center;
        flex-direction: column;
        padding-top: 4vh;
        width: 100vw;
        overflow: hidden;
        gap: 5px;
    }

    .helpContainer{
        display: flex;
        flex-wrap: wrap;
        align-content: center;
        width: 90vw;
        flex-direction: column;
        border-radius: 1%;
        background-color: #ffffff20;
    }

    .helpBubble{
        display: flex;
        flex-wrap: wrap;
        flex-direction: row;
        justify-content: space-between;
        background-color: white;
        width: 80vw;
        height: 70px;
        margin: 20px;
        font-size: 2.5vw;
        font-weight: bold;
        color: black;
        font-family: CA-Geheimagent;
        text-align: center;
        line-height: 70px;
        border-radius: 10px;
        padding: 15px;
    }

    input[type='checkbox'] {
    width:30px;
    height:30px;
    margin-top: 17px;
}


</style>