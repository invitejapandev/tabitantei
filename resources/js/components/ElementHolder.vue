<template>
    <div class="element_holder"  >
        <div class="elements"><img class="desk" src="../assets/desk_with_manual.png"  style="width: 100%; height: 100%; border-radius:5px "/></div>
        <div class="actions">
            <input class="answer" type="text" placeholder="Type Here" style="z-index: 1" @input="onInput"/>
            <!-- <img src="../assets/circuit_board.png" style="width: 50%; heigth: 50%; position: absolute;"/> -->
        </div>
    </div>
</template>

<script>
var keystrokeSound = new Audio('https://dl.dropboxusercontent.com/s/hjx4xlxyx39uzv7/18660_1464810669.mp3');
            var interval,  newInterval;

var typingTimer;
var doneTypingInterval = 1000;
var presscount = 0;

export default{
    name:'ElementHolder',
    data(){
        return{
            message: '',
            typing: false,
            timer: null
        }
    },
    methods: {
            onInput(e){
                    keystrokeSound.play();
                }
        }
}





</script>


<style>

    .element_holder{
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .elements{
        max-width: 100%;
        width: auto;
        max-height: 70%;
        height: auto;
    }

    .actions{
        display: flex;
        width: 100%;
        height: 30%;
        margin-bottom: 20px;
        margin-top: 10px;
        align-items: center;
        justify-content: center;
    }

    .answer{
        width: 100%;
        height: 100%;
        font-size: 2vw;
        background: transparent;
        background-image: url('../assets/circuit_board.png');
        background-repeat: no-repeat;
        background-position: center;
        background-size: 100%;
        border:none;
        outline: none;
        color: greenyellow;
        text-transform:uppercase;
        font-weight: bold;
        padding-left: 30%;
        padding-top: 2%;
    }


</style>