<template>

    <div class="main">
        <Header  :puzzleNumber="puzzleNumber" class="header2" :timePaused="timeisPaused" />
        <div class="main_body">
            <PianoBody @pauseTime="pause-time"  :miroURL="miroURLData" :isShowned="isShowned" :imgCover="imgCover"/>
        </div>
        <a @click="helpTriggered()" href="#" class="float">
            <img src="../assets/chloe_version.png" style="width: 120px; height: 120px;"/>
        </a>

    </div>
</template>

<script>
    import axios from 'axios';
    import Header from './Header.vue';
    import PianoElement from './PianoElement.vue'
    import PianoBody from './PianoBody.vue';

    let computerMIRO = "https://miro.com/app/live-embed/o9J_ltgInS4=/?embedAutoplay=true&moveToViewport=-2638,-351,2934,3605";
    let  floorMIRO = "https://miro.com/app/live-embed/o9J_ltgIkjg=/?embedAutoplay=true&moveToViewport=2560,-648,1472,1160";
    let mapMIRO = 'https://miro.com/app/live-embed/o9J_ljJrZyw=/?embedAutoplay=true&moveToViewport=-1717,-895,2432,1658';

    let selectedMIRO = "";
    let gameProgress;
    let codeResponse, teamSetup;
    var getStatusInterval;

    export default{
        name: 'Main',
        components: {
            Header,
            PianoElement,
            PianoBody
        },
        props:{
            miroCovered: Boolean,
            elementImage: String,
            answer: String,
            puzzleNumber: Number
        }
    }
</script>

<style scoped>

    .main{
        display: flex;
        position: relative;
        flex-direction: column;
        height: 100%;
        color: white;
    }

    .header2{
        display: flex;
        justify-content: center;
        width: 100vw;
    }




    .main_body{
        display: flex;
        position: relative;
        flex-direction: row;
        justify-content: center;
        flex-wrap: wrap;
        width: 100%;
    }





    
.float{
	position:fixed;
	width:120px;
	height:120px;
	border-radius:50px;
	text-align:center;
    z-index: 99999999;
	bottom:15px;
	right:15px;
}

.my-float{
	margin-top:22px;
}

@media only screen and (max-width: 1500px) {

    .miro_holder{
        height: 95%;
    }

}


</style>