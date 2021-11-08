<template>
    <div class="container">
            <span class="timeContent">{{ time }}</span>
    </div>
</template>

<script>

    export default{
        name: 'Timer',
        props:{
            time: String
        }
    }

</script>

<style scoped>

    .container{
        align-content: center;
        justify-content: start;
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
    }


    /* .container:hover {
        box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
    } */
</style>