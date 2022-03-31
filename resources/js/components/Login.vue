<template>
        <div class="login_container">
            <form class="login_form" autocomplete="off" v-on:submit.prevent="onEnter">
                <input autocomplete="off" id="1" type="text" placeholder="ゲームコードを入力
                
                
                
                
                
                Enter Game Code"  maxlength="5" v-model="item.name" @input="onInput"/>
            </form>
             <!-- <img class="login-logo" src="../assets/green_logo.png" /> -->
            <!-- <a class="go_button" @click="validateGame" :class="[item.name]">Go!</a> -->         
            <!-- <span class="welcome_header_jap">エージェントのみなさん、ようこそ！</span> -->
            <span class="welcome_header">TABITANTEI</span>
        </div>
        
         <!-- <iframe src="/mp3/spy_music.mp3" allow="autoplay" id="audio"></iframe> -->
         <!-- <audio id="player" autoplay controls><source src="/mp3/spy_music.mp3" type="audio/mp3"></audio> -->
</template>


<script>
    import axios from 'axios'
     var codeSuccess = 'ゲームコードが認証されました。チーム選択画面に進みます。<br/>Game Code is Valid. You will now be redirected to team selection.';
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
                            // alert('something went wrong');
                        });
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
            onEnter(e){
                console.log(e.target.value);
                   axios.post('api/game/validate_key',{
                    code: this.item.name
                    }).then(response => {
                        
                        console.log(response['data'][0].game_code)
                        if(response['data'][0].id >= 1 && response['data'][0].Status == 1){
                           this.$swal({
                                html:`<strong><h3>`+codeSuccess+`</h3></strong><br/>`,
                                background: 'url(/images/book_bg_login.png)',
                                showClass: {
                                    popup: 'animate__animated animate__fadeInDown'
                                },
                                hideClass: {
                                    popup: 'animate__animated animate__fadeOutDown'
                                },
                                width: 497,
                                customClass: { actions: 'action-class' },
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: "Ok",
                            }).then((result) =>{
                                            this.$router.push({ name: 'team.index' })
                                            localStorage.setItem('codeResponse', JSON.stringify(response['data'][0]));
                                        });
                           
                        }
                        else{
                          this.$swal({
                                html:`<strong><h3>Game code is invalid. Please try again.</h3></strong><br/>`,
                                background: 'url(/images/book_bg_login.png)',
                                showClass: {
                                    popup: 'animate__animated animate__fadeInDown'
                                },
                                hideClass: {
                                    popup: 'animate__animated animate__fadeOutUp'
                                },
                                width: 497,
                                customClass: { actions: 'action-class' },
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: "Ok",
                            });
                        }
                    }).catch( error => {
                           this.$swal({
                                html:`<strong><h3>Game code is invalid. Please try again.</h3></strong><br/>`,
                                background: 'url(/images/book_bg_login.png)',
                                showClass: {
                                    popup: 'animate__animated animate__fadeInDown'
                                },
                                hideClass: {
                                    popup: 'animate__animated animate__fadeOutUp'
                                },
                                width: 497,
                                customClass: { actions: 'action-class' },
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: "Ok",
                            });
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
                        if(response['data'][0].id >= 1 && response['data'][0].Status == 1){
                            this.$swal({
                                html:`<strong><h3>`+codeSuccess+`</h3></strong><br/>`,
                                background: 'url(/images/book_bg_login.png)',
                                showClass: {
                                    popup: 'animate__animated animate__fadeInDown'
                                },
                                hideClass: {
                                    popup: 'animate__animated animate__fadeOutDown'
                                },
                                width: 497,
                                customClass: { actions: 'action-class' },
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: "Ok",
                            }).then((result) =>{
                                            this.$router.push({ name: 'team.index' })
                                            localStorage.setItem('codeResponse', JSON.stringify(response['data'][0]));
                                        });
                           
                        }
                        else{
                          this.$swal({
                                html:`<strong><h3>Game code is invalid. Please try again.</h3></strong><br/>`,
                                background: 'url(/images/book_bg_login.png)',
                                showClass: {
                                    popup: 'animate__animated animate__fadeInDown'
                                },
                                hideClass: {
                                    popup: 'animate__animated animate__fadeOutUp'
                                },
                                width: 497,
                                customClass: { actions: 'action-class' },
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: "Ok",
                            });
                        }
                    }).catch( error => {
                         this.$swal({
                                html:`<strong><h3>Game code is invalid. Please try again.</h3></strong><br/>`,
                                background: 'url(/images/book_bg_login.png)',
                                showClass: {
                                    popup: 'animate__animated animate__fadeInDown'
                                },
                                hideClass: {
                                    popup: 'animate__animated animate__fadeOutUp'
                                },
                                width: 497,
                                customClass: { actions: 'action-class' },
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: "Ok",
                            });
                    })
                }
            }
        }
    }
</script>

<style>

.title-class{
    font-size: 1999px;
}

.testingclass{
    font-weight: bolder;
    font-size: 1em;
}

.swal-height {
  height: 399px;
}

.action-class{
    position: fixed;
    right: 15px;
    bottom: 10px;
}

</style>


<style scoped>


.login_container{
    position: relative;
    display: flex;
    flex-wrap: wrap;
    align-content: center;
    justify-content: center;
    background-size: cover;
    width: 100%;
    height: 100%;
        background-image: url('../assets/main_bg.jpg') !important;
}

.login-logo{
    position: absolute;
    bottom: 7%;
    width: 100%;
    max-width: 600px;
    z-index: 1;
}

.welcome_header{
    position: absolute;
    font-size: 7vw;
    top:  12%;
    color:black;
    letter-spacing: 10px;
    font-family: 'Covered By Your Grace', cursive;
    z-index: 2;
}

.welcome_header_jap{
    position: absolute;
    font-size: 4vw;
    top:  3%;
    color: lightslategray;
    font-weight: regular;
    font-family: CA-Geheimagent;
    letter-spacing: 10px;
    z-index: 2;
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
    font-size: 3vw;
    text-align: center;
    padding: 2rem;
    text-transform: uppercase;
    font-family: 'Covered By Your Grace', cursive;
    background-color: rgba(255,255,255,0.75);
    border: none;
    color:black;
    letter-spacing: 9px;
    height: 160px;
    width: 40%;
    max-width: 100%;
}
::-webkit-input-placeholder { /* Chrome/Opera/Safari */
  white-space:pre-line;  
  position:relative;
  top:-35px;
  
}
::-moz-placeholder { /* Firefox 19+ */
     white-space:pre-line;  
  position:relative;
  top:-35px;
}
:-ms-input-placeholder { /* IE 10+ */
    white-space:pre-line;  
  position:relative;
  top:-35px;
}
:-moz-placeholder { /* Firefox 18- */
     white-space:pre-line;  
  position:relative;
  top:-35px;
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

@media only screen and (max-width: 650px) {

    .login_form{
        top: 33% !important;
    }
}

</style>