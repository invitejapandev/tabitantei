<template>
        <div class="login_container" >
            <input id="1" type="text" placeholder="Game Code" size="8" maxlength="5" v-model="item.name" @input="onInput"/>
            <!-- <a class="go_button" @click="validateGame" :class="[item.name]">Go!</a> -->
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
        beforeCreate(){
            let codeResponse = JSON.parse(localStorage.getItem('codeResponse'));
            if(codeResponse){
            let eventDate = codeResponse.event_date;
            eventDate = new Date(eventDate);
            let nowDate = new Date();
            const diffTime = Math.abs(nowDate - eventDate);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            if(diffDays>1){
            alert(diffDays);
                console.log(codeResponse);
                axios.post('api/game/validate_key',{
                        code: codeResponse.game_code
                        }).then(response => {
                            console.log(response);
                            if(response['data'][0].id >= 1){
                                if(response['data'][0].Status == 1){
                                    localStorage.setItem('codeResponse', JSON.stringify(response['data'][0]));
                                    this.$router.push({ name: 'team.index' });
                                }
                            }
                        }).catch(error => {
                            alert('something went wrong');
                        });
                }
                else{
                      this.$router.push({ name: 'team.index' });
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
            },
            onInput(e){
                console.log(e.target.value);
                if(e.target.value.length==5){
                   axios.post('api/game/validate_key',{
                    code: this.item.name
                    }).then(response => {
                        
                        console.log(response['data'][0].game_code)
                        if(response['data'][0].id >= 1){
                            alert('Success! Valid Code. You will now proceed to the game.');
                            this.$router.push({ name: 'team.index' })
                            localStorage.setItem('codeResponse', JSON.stringify(response['data'][0]));
                        }
                        else{
                            alert('invalid code');
                        }
                    }).catch( error => {
                            alert('test');
                    })
                }
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