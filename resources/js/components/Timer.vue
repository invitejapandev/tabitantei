<template>
    <div class="container">
        <div class="timer_container">
            <h1>{{ time }}</h1>
        </div>
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
    .timer_container{
        padding: 2px 16px;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        justify-content: center;
        align-content: center;
    }


    /* .container:hover {
        box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
    } */
</style>