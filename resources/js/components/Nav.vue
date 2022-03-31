<template>
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container-fluid">
        <a class="navbar-brand" style="padding-left: 5px" href="#">
          <img src="/images/tabt_logo.png" height="70" alt=""
        /></a>
        <div class="navbar-nav ms-auto mb-2 mb-lg-0" id="navbarNavAltMarkup">
          <div class="navbar-nav">
            <a @click.prevent="navClicked(1)" class="nav-link" aria-current="page" href="#">Dashboard</a>
            <a @click.prevent="navClicked(2)" class="nav-link" aria-current="page" href="#">Events</a>
            <!-- <a @click.prevent="navClicked(3)" class="nav-link" aria-current="page" href="#">Settings</a> -->
            <a @click.prevent="navClicked(4)" class="nav-link" aria-current="page" href="#">Logout</a>
          </div>
        </div>
      </div>
    </nav>
</template>

<script>
export default {
    methods:{
        navClicked(val){
            if(val == 1){
                this.$router.push({ name: "dashboard.index" });
            }
            else if(val == 2){
                this.$router.push({ name: "events.index" });
            }
            else if(val == 3){
                this.$router.push({ name: "setting.index" });
            }
            else{
                this.$router.push({ name: "admin.index" });
                }
        }
    }
}
</script>

<style>

</style>