<template>
    <div class="element_holder"  >
        <div class="elements"><img class="desk" src="../assets/desk_with_manual.png"  style="width: 100%; height: 100%; border-radius:5px "/></div>
        <div class="actions">
            <input class="answer" type="text" placeholder="Type Here" style="z-index: 1" @input="onInput"/>
            <img src="../assets/circuit_board.png" style="width: 50%; heigth: 50%; position: absolute;"/>
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
        padding-left: 10px;
    }

    .actions{
        display: flex;
        width: 100%;
        height: 20%;
        width: 95%;
        margin-bottom: 20px;
        margin-top: 10px;
        align-items: start;
        justify-content: start;
    }

    .answer{
        width: 20%;
        margin-top: 90px;
        margin-left: 290px;
        font-size: 2.2rem;
        background: transparent;
        border:none;
        outline: none;
        color: greenyellow;
        padding: 10px;
        text-transform:uppercase;
        font-weight: bold;
    }


</style>