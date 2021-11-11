<template>

    <div class="main">
        <Header class="header2" :timePaused="timeisPaused"/>
        <div class="main_body">
            <Miro class="miro_holder"/>
            <ElementHolder @pause-time="pauseTime" class="main_element_holder" />

        </div>
        <a href="#" class="float">
            <img src="../assets/chloe_version.png" style="width: 120px; height: 120px;"/>
        </a>

    </div>
</template>

<script>
    import Header from './Header.vue';
    import ElementHolder from './ElementHolder.vue'
    import Miro from './Miro.vue';

    export default{
        name: 'Main',
        data(){
            return{
                timeisPaused:false
            }
        },
        components: {
            Header,
            ElementHolder,
            Miro
        },
        methods:{
            pauseTime(){
                this.timeisPaused = true;
            }
        }
    }
</script>

<style>

    .main{
        display: flex;
        position: relative;
        flex-direction: column;
        height: 100%;
        color: white;
    }


    .main_body{
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        padding:10px;
        height: 85vh;
    }


    .header2{
        padding-left:20px;
        min-height: 5vh;
    }

    .main_element_holder{
        flex-grow: 1;
       flex-basis: 700px;
    }

    .miro_holder{
        flex-grow: 1;
       flex-basis: 400px;
       min-width: 600px;
       height: 105%;
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

</style>