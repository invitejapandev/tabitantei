<template>

    <div class="main">
        <Header class="header2"/>
        <div class="main_body">
            <Miro class="miro_holder"/>
            <ElementHolder class="main_element_holder" />
        </div>
        <a href="#" class="float">
            <img src="../assets/chloe_version.png" style="width: 120px; height: 120px"/>
        </a>
    </div>
</template>

<script>

    import Header from './Header.vue';
    import ElementHolder from './ElementHolder.vue'
    import Miro from './Miro.vue';

    export default{
        name: 'Main',
        components: {
            Header,
            ElementHolder,
            Miro
        }
    }
</script>

<style>

    .main{
        display: flex;
        flex-direction: column;
        height: 100%;
        background-color: #004D40;
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
    }

    
.float{
	position:fixed;
	width:120px;
	height:120px;
	bottom:40px;
	right:40px;
	border-radius:50px;
	text-align:center;
}

.my-float{
	margin-top:22px;
}

</style>