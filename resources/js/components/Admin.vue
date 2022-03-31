<template>
  <div
    class="
      admin_login
      contianer-fluid
      h-100
      d-flex
      flex-column
      justify-content-start
      align-items-center
    "
  >
    <div class="row p-3 pt-5">
      <div class="d-flex justify-content-center">
        <img
          src="/images/tabt_logo.png"
          height="150"
          width="236"
          alt="tabitantei_logo"
        />
      </div>
    </div>
    <div class="row w-25">
     
      <div class="card shadow p-3 mb-5 bg-white rounded">
        <div class="card-body">
           <div v-if="passwordError" class="alert alert-danger" role="alert">
  Username/password is invalid. </div>
  <div v-if="passwordSuccess" class="alert alert-success" role="alert">
  Username and Password is valid. You will now be redirected. </div>
            <form @submit.prevent="validateLogin">
              <div class="form-group">
                <label for="exampleInputEmail1">Username</label>
                <input
                  v-model="usernameInput"
                  type="text"
                  class="form-control"
                  id="exampleInputEmail1"
                  aria-describedby="emailHelp"
                  placeholder="Enter Username Here"
                  required
                />
              </div>
              <div class="form-group pb-2">
                <label for="exampleInputPassword1">Password</label>
                <input
                  v-model="passwordInput"
                  type="password"
                  class="form-control"
                  id="exampleInputPassword1"
                  placeholder="Enter Passowrd Here"
                  required
                />
              </div>
            
              <button type="submit" class="btn btn-primary">Login</button>
            </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      username: 'admin',
      // password: 'T@b!t@nt3!',
      password: '1',
      usernameInput: null,
      passwordInput: null,
      passwordError: false,
      passwordSuccess: false
    };
  },
  methods:{
    validateLogin(){
      if(this.usernameInput == this.username && this.passwordInput == this.password){
        this.passwordSuccess = true;
        this.passwordError = false;
        // this.$router.push({ name: 'dashboard.index' });
        this.$swal({
                title:
                  "Username and Password is valid. You will now be redirected.",
                icon: "success",
              }).then((response) => {
                this.$router.push({ name: 'dashboard.index' });
              });
      }
      else{
        this.passwordError = true;
        this.passwordSuccess = false;
      }
    }
  }
};
</script>

<style scoped>
</style>