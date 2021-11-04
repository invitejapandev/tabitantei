<template>

    <div class="main">
        <Header class="header2"/>
        <div class="main_body">
            <Miro class="miro_holder"/>
            <ElementHolder class="main_element_holder" />
        </div>
        <a href="#" class="float">
        <i class="fa fa-plus my-float"></i>
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
    }


    .main_body{
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        padding:10px;
        height: 85vh;
    }

    .header2{
        padding:10px;
        min-height: 10vh;
    }

    .main_element_holder{
        flex-grow: 1;
       flex-basis: 700px;
    }

    .miro_holder{
       flex-basis: 700px;
        flex-grow: 1;
    }

    
.float{
	position:fixed;
	width:70px;
	height:70px;
	bottom:40px;
	right:40px;
	background-color:rgb(204, 0, 0);
	color:#FFF;
	border-radius:50px;
	text-align:center;
	box-shadow: 2px 2px 3px rgb(112, 95, 95);
}

.my-float{
	margin-top:22px;
}

</style>