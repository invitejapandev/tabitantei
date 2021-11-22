<template>
    <div @click="start" class="container">
            <span  class="timeContent">{{ displayedTime }}</span>
    </div>
</template>

<script>
    
    let currentGameTime = 0;
    let gameProgress;

    export default{
        name: 'Timer',
        data(){
            return {
                isRunning: true,
                currentTime: currentGameTime,
                currentTimer:null,
                minutes:0,
		        secondes:0,
                displayedTime: '0:00:00'
            }
        },
        beforeCreate(){
            let codeResponse = JSON.parse(localStorage.getItem('codeResponse'));
            if(codeResponse){
                
                gameProgress = JSON.parse(localStorage.getItem('gameProgress'));

                 if(gameProgress.GameTime != null){
                     currentGameTime = gameProgress.GameTime;
                 }
            }
        },
        mounted(){
            this.start();
        },
        props:{
            time: String,
            timeIsPaused: Boolean,
        },
        watch: {
            timeIsPaused: function(val){
                console.log('test'+this.currentTime)
                if(val === true){
                    this.isRunning = false;
                    gameProgress.GameTime = this.currentTime;
                    localStorage.setItem('gameProgress', JSON.stringify(gameProgress));
                }
            }
        },
        methods:{
            start () {
                console.log('test');
			 if (!this.currentTimer) {
				  this.currentTimer = setInterval( () => {
						if (this.isRunning == true) {
							 this.currentTime++
                            let newTime = this.currentTime / 60
                            let newMinute = parseInt(newTime);
                            if(newMinute<10){
                                newMinute = "0"+newMinute;
                            }
                            let newSecond = Math.round((newTime - newMinute) * 60)
                            if(newSecond<10){
                                newSecond = "0"+newSecond;
                            }
                            this.displayedTime = String("0:"+newMinute+":"+newSecond)
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
        justify-content: end;
        align-content: center;
        /* justify-content: center; */
    }

    .timeContent{
        background-color: white;
        color: black;
        font-weight: bold !important;
        font-size: 60px;
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