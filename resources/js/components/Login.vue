<template>
        <div class="login_container">
            <form class="login_form" autocomplete="off">
                <input autocomplete="off" id="1" type="text" placeholder="ENTER GAME CODE"  maxlength="5" v-model="item.name" @input="onInput"/>
            </form>
             <img class="login-logo" src="../assets/green_logo.png" />
            <!-- <a class="go_button" @click="validateGame" :class="[item.name]">Go!</a> -->
         <span class="welcome_header">WELCOME&nbsp;&nbsp;AGENTS</span>
        </div>
        
         <!-- <iframe src="/mp3/spy_music.mp3" allow="autoplay" id="audio"></iframe> -->
         <!-- <audio id="player" autoplay controls><source src="/mp3/spy_music.mp3" type="audio/mp3"></audio> -->
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
        mounted(){
            
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
            playMusic(){
                
            var spy_music = new Audio('/mp3/spy_music.mp3');
            spy_music.play();
            },
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
                // spy_music.play();
                console.log(e.target.value);
                if(e.target.value.length==5){
                   axios.post('api/game/validate_key',{
                    code: this.item.name
                    }).then(response => {
                        
                        console.log(response['data'][0].game_code)
                        if(response['data'][0].id >= 1){
                            this.$swal({
                                title:'Game Code is Valid. You will now be redirected to team selection.',
                                icon:'success'    
                                        }).then((result) =>{
                                            this.$router.push({ name: 'team.index' })
                                            localStorage.setItem('codeResponse', JSON.stringify(response['data'][0]));
                                        });
                           
                        }
                        else{
                            this.$swal({
                                title:'Game Code is Valid.  Please try again.',
                                icon:'warning'    
                                        });
                        }
                    }).catch( error => {
                           this.$swal({
                                title:'Game Code is Invalid. Please try again.',
                                icon:'warning'    
                                        });
                    })
                }
            }
        }
    }
</script>

<style scoped>

.login_container{
    position: relative;
    display: flex;
    flex-wrap: wrap;
    align-content: center;
    justify-content: center;
    /* background-color: white; */ 
    background-size: cover;
    width: 100%;
    height: 100%;
}

.login-logo{
    position: absolute;
    top: 20%;
    width: 100%;
    max-width: 708px;
    z-index: 1;
}

.welcome_header{
    position: absolute;
    font-size: 7vw;
    top:  7%;
    color: white;
    font-weight: regular;
    font-family: CA-Geheimagent;
    letter-spacing: 10px;
}



.login_form{
    position: absolute;
    display: flex;
    justify-content: center;
    flex: 1 1 auto;
    flex-grow: 1;
    top: 43%;
    flex-shrink: 1;
    width: 100%;
    z-index: 2;
}

input{
    top: 45%;
    font-size: 3rem;
    text-align: center;
    padding: 2rem;
    text-transform: uppercase;
    font-family: CA-Geheimagent;
    background-color: rgba(255,255,255,0.75);
    border: none;
    color:black;
    letter-spacing: 9px;
    width: 40%;
    max-width: 100%;
}

input::placeholder{
    color:black;
}

.go_button{
    margin-left: 20px;
    padding: 1rem;
    font-size: 5rem;
    font-weight: bold;
}

</style>

<style>

.swal2-title{
    color: black;
}

@media only screen and (max-width: 890px) {
    input::placeholder{
        
    font-size: 20px;
    }
}

</style>