<template>
    <div @click="start" class="container">
            <span  class="timeContent">{{ displayedTime }}</span>
    </div>
</template>

<script>
    import axios from 'axios'


    let currentGameTime = 0;
    let gameProgress, teamSetup, codeResponse;

    export default{
        name: 'Timer',
        data(){
            return {
                isRunning: true,
                currentTime: currentGameTime,
                currentTimer:null,
                minutes:0,
		        secondes:0,
                displayedTime: '0:00:00',
                timeLimit: 60
            }
        },
        beforeCreate(){
            codeResponse = JSON.parse(localStorage.getItem('codeResponse'));
            if(codeResponse){
                teamSetup = JSON.parse(localStorage.getItem('teamSetup'));

                          axios.post('api/game/get_game_time',{
                                    game_event_id: codeResponse.id,
                                    team_number: teamSetup.playerTeam,
                                    puzzle_number: this.puzzleNumber,
                                }).then(response => {
                                    // console.log(response);
                                    let gameTime = response['data'].game_time;
                                    // console.log('game_time'+gameTime['id'])
                                    this.timeLimit = response['data'].time_limit;
                                    console.log('new time limit'+ this.timeLimit);
                                    if(gameTime){
                                        // alert(response['data'].created_at);
                                        let created_at = new Date(gameTime['created_at']);
                                            
                                        const today = new Date();

                                        let diff = Math.round((today-created_at)/(1000));
                                        
                                        console.log(diff);
                                        this.currentTime = diff;

                                        
                                    }
                                    else{
                                        axios.post('api/game/store_game_time',{
                                            game_event_id: codeResponse.id,
                                            team_number: teamSetup.playerTeam,
                                            puzzle_number: this.puzzleNumber,
                                            game_time: this.currentTime
                                        }).then(response => {
                                            if(response){
                                                // alert('saved!')
                                            }
                                            else{
                                                // alert('error!');
                                            }
                                        });
                                    }
                                });
                                
            }
        },
        mounted(){
            this.start();
            // if(this.currentTime >=60){
            //                         console.log('time is up');
            //                     }
        },
        props:{
            time: String,
            timeIsPaused: Boolean,
            puzzleNumber: Number
        },
        watch: {
            timeIsPaused: function(val){
                // console.log('test'+this.currentTime)
                if(val === true){
                    this.isRunning = false;
                     axios.post('api/game/get_game_time',{
                                    game_event_id: codeResponse.id,
                                    team_number: teamSetup.playerTeam,
                                    puzzle_number: this.puzzleNumber,
                                }).then(response => {
                                    // console.log(response);
                                    let game_time = response['data'].game_time;
                                    this.timeLimit = response['data'].time_limit;
                                        // console.log('current game_time:'+ game_time['id']);
                                    if(game_time){
                                        let created_at = new Date(game_time['created_at']);
                                            
                                        const today = new Date();

                                        let diff = Math.round((today-created_at)/(1000));
                                        
                                        this.currentTime = diff;

                                        
                                    }
                                    else{
                                        axios.post('api/game/store_game_time',{
                                            game_event_id: codeResponse.id,
                                            team_number: teamSetup.playerTeam,
                                            puzzle_number: this.puzzleNumber,
                                            game_time: this.currentTime
                                        }).then(response => {
                                            if(response){
                                                // alert('saved!')
                                            }
                                            else{
                                                // alert('error!');
                                            }
                                        });
                                    }
                                });
                }
            }
        },
        methods:{
            start () {
			 if (!this.currentTimer) {
				  this.currentTimer = setInterval( () => {
						if (this.isRunning == true) {
							 this.currentTime++
                             
                            let newTime = this.currentTime / 60
                            let newMinute = 0;
                            let newHour = 0;

                            
                            // console.log('current /time:'+newTime);
                            let timerInterval;
                            if(newTime>=this.timeLimit){
                              this.$swal({
                                        title: 'Time is up!',
                                        html: 'In 3 minutes, you will be redirect out of the game. Thank you for playing!',
                                        timer: 180000,
                                        timerProgressBar: true,
                                        allowOutsideClick: false,
                                        didOpen: () => {
                                            this.$swal.showLoading()
                                            const b = this.$swal.getHtmlContainer().querySelector('b')
                                            timerInterval = setInterval(() => {
                                            b.textContent = this.$swal.getTimerLeft()
                                            }, 60000)
                                        },
                                        willClose: () => {
                                            clearInterval(timerInterval)
                                        }
                                        }).then((result) => {
                                        /* Read more about handling dismissals below */
                                        
                                        localStorage.removeItem('codeResponse');
                                        localStorage.removeItem('gameProgress');
                                        localStorage.removeItem('teamSetup');

                                                                                this.$router.push({ name: 'gameover.index' });

                                        if (result.dismiss === this.$swal.DismissReason.timer) {
                                            

                                        }
                                    })


                                	 clearInterval(this.currentTimer)
                            }
                           if(parseInt(newTime)/60 >= 1){
                                newHour = Math.round(parseInt(newTime)/60);
                                newMinute = Math.round(parseInt(newTime)%60);
                            }
                            else{
                                newMinute = parseInt(newTime);
                            }

                            if(newMinute<10){
                                newMinute = "0"+newMinute;
                            }
                            let newSecond = Math.round((newTime - parseInt(newTime)) * 60)
                            if(newSecond<10){
                                newSecond = "0"+newSecond;
                            }
                            this.displayedTime = String(newHour+":"+newMinute+":"+newSecond)
						} else {
							 clearInterval(this.currentTimer)
							 this.reset()
						}
				  }, 1000 )
			 }
		 },
		 stop () {
			 this.isRunning = false
			 clearInterval(this.currentTimer)
			 this.currentTimer = null
		 },
		 reset () {
			  this.stop()
			//   this.currentTime = 0
			//   this.secondes = 0
			//   this.minutes = 0
		 },
		 setTime (payload) {
			 this.currentTime = (payload.minutes * 60 + payload.secondes)
		 }
        }
    }

</script>

<style scoped>

    .container{
        display: flex;
        justify-content: flex-end;
        align-content: center;
        /* justify-content: center; */
    }

    .timeContent{
        background-color: white;
        color: black;
        font-weight: bold !important;
        font-size: 3vw;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        background-color: white;
        color: black;
        margin:0;
        padding-left: 30px;
        padding-right: 30px;
        padding-top: -5px;
       border-radius: 5px;
    }


    /* .container:hover {
        box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
    } */
</style>