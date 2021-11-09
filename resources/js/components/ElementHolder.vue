<template>
    <div class="element_holder"  >
        <div class="elements"><img class="desk" src="../assets/desk_with_manual.png"  style="width: 100%; height: 100%; border-radius:5px "/></div>
        <div class="actions">
            <input :class="[isCorrect ? 'correct' : '' , 'answer']" type="text" placeholder="Type Here" style="z-index: 1" @input="onInput" maxlength="8"/>
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
            timer: null,
            isCorrect: false,
            correctAnswer: 'jetpogi'
        }
    },
    methods: {
            onInput(e){
                    keystrokeSound.play();
                    console.log(e.target.value);
                    if(e.target.value == this.correctAnswer){
                        this.isCorrect = true;
                           this.$swal({
                                title:'Great! That is the correct answer!',
                                icon:'success'    
                                        });
                    }
                    else{
                        this.isCorrect = false;
                    }
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
        max-width: 98%;
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
        background-repeat: no-repeat;
        background-position: center;
        background-size: 100%;
        border:none;
        outline: none;
        color: greenyellow;
        text-transform:uppercase;
        font-weight: bold;
        padding-left: 33%;
        padding-top: 0.5%;
        background-image: url('../assets/circuit_board_red.png');
    }

    .answer.correct{
        background-image: url('../assets/circuit_board_green.png');
    }


</style>