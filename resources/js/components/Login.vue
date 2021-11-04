<template>
        <div class="login_container" >
            <input type="text" placeholder="Game Code" size="8" maxlength="5" v-model="item.name"/>
            <a class="go_button" @click="validateGame" :class="[item.name]">Go!</a>
        </div>
</template>


<script>
    import axios from 'axios'

    export default{
        data: function(){
            return {
                item:{
                    name:""
                }
            }
        },
        methods: {
            validateGame(){
                if(this.item.name == ''){
                    return;
                }

                axios.post('api/game/validate_key',{
                    code: this.item.name
                }).then(response => {
                    if(response.status == 200 || response.status == 200){
                        console.log(response);
                    }
                }).catch( error => {
                    console.log(error);
                })
            }
        }
    }
</script>

<style scoped>
.login_container{
    display: flex;
    align-content: center;
    justify-content: center;
    padding-top: 500px;
}

input{
    font-size: 5rem;
    text-align: center;
    padding: 1rem;
    text-transform: uppercase;
    font-weight: bold;
}

.go_button{
    margin-left: 20px;
    padding: 1rem;
    font-size: 5rem;
    font-weight: bold;
}
</style>