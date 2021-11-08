<template>
    
    <div class="inventoryContainer">
        <Item />
    </div>
</template>

<script>

import Item from './InventoryComponents/Item.vue';

export default{
    name:'Inventory',
    components:{
        Item
    }
}

</script>

<style scoped>
    .inventoryContainer{
        background-color: white;
        margin: 25px;
    }
</style>