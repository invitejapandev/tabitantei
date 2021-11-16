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
        height: 85%;
        width: 100%;
    }

    .miro_holder{
        position: relative;
        flex-grow: 1;
        /* background-color: white; */
    }


    .main_element_holder{
        position: relative;
        flex-grow: 1;
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