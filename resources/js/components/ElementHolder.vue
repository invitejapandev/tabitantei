<template>
    <div class="element_holder">
        <div class="elements"></div>
        <div class="actions">
            <input class="answer" type="text" placeholder="Enter Answer Here" />
        </div>
    </div>
</template>

<script>

export default{
    name:'ElementHolder'
}

</script>


<style>

    .element_holder{
        border-style: solid;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .elements{
        border-style: solid;
        width: 95%;
        height: 120%;
        margin-top: 20px;
    }

    .actions{
        display: flex;
        border-style: solid;
        width: 100%;
        height: 20%;
        width: 95%;
        margin-bottom: 20px;
        margin-top: 10px;
        align-items: start;
        justify-content: center;
    }

    .answer{
        width: 90%;
        margin-top: 20px;
        font-size: 2.2rem;
        padding: 15px;
    }


</style>