<template>
  <div class="contianer-fluid pt3 mb-3">
    <Navigation />
    <div class="container-fluid px-5 pt-3" style="padding-bottom: 20px;">
      <div class="row justify-content-between align-items-center mb-3">
        <div class="col-12">
          <h2>Events</h2>
          <div class="text-muted">Event overview &amp; summary</div>
        </div>
      </div>
      <div class="card card-raised">
        <div class="card-header bg-dark text-white px-4">
          <div class="d-flex justify-content-between align-items-center">
            <div class="p-1">
              <h4 class="card-title text-white">Clients and Game Schedule</h4>
              <div class="card-subtitle">Management</div>
            </div>
            <div class="p-2 bd-highlight">
              <a  v-if="hideTable==false" href="#" @click="openFormTrigger" class="btn btn-primary">Add Event</a>
              <!-- <a  v-if="openForm==true" href="#" @click="openFormTrigger" class="btn btn-primary">Back</a> -->
            </div>
          </div>
        </div>
        <div class="card-body">

    <transition name="fade">
          <!-- Simple DataTables example-->
          <div v-if="hideTable==false">
            <table class="table table-striped table-responsive">
              <thead>
                <tr>
                  <th style="width: 20%">Client</th>
                  <th style="width: 10%">Game Code</th>
                  <th style="width: 15%" scope="col">Date of Event</th>
                  <th style="width: 5%">Number of Teams</th>
                  <th style="width: 10%">Status</th>
                  <th style="width: 20%">Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="item in events" :key="item.id">
                  <td>{{ item.company_name }}</td>
                  <td>{{ item.game_code.toUpperCase() }}</td>
                  <td>{{ formatDate(item.event_date) }}</td>
                  <td>{{ item.team_count }}</td>
                  <td>{{ identifyStatus(item.event_date, item.Status) }}</td>
                  <td>
                    <a v-if="item.Status != 2" href="#" @click.prevent="editEvent(item.id)"><span class="badge bg-primary">Edit</span></a>&nbsp;
                    <a v-if="item.Status != 2" href="#" @click.prevent="toggleEvent(item.id, 2)"><span class="badge bg-danger">Cancel</span></a>&nbsp;
                    <a href="#" @click.prevent="toggleEvent(item.id, 1)"><span class="badge bg-success" v-if="item.Status == 0 && item.Status!= 2">Start</span></a>
                    <a href="#" @click.prevent="toggleEvent(item.id, 0)"><span class="badge bg-secondary" v-if="item.Status == 1 && item.Status!= 2">Close</span></a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

    </transition>
    <transition name="fade">

          <div class="row" v-if="openForm">
            <form @submit.prevent="submitForm">
              <div class="form-group mb-2">
                <label for="exampleInputEmail1"><strong>Client</strong></label>
                <input v-model="company_name" type="text" class="form-control" id="company_name" name="company_name" placeholder="Enter Client Company Name" required>
                <!-- <small id="emailHelp" class="form-text text-muted">For Invite Japan use only.</small> -->
              </div>
              <div class="form-group mb-2">
                <label for="exampleInputPassword1"><strong>Number of Teams</strong></label>
                <input v-model="team_count" type="number" class="form-control" id="exampleInputPassword1" min="1" max="12" placeholder="Enter the number of teams (Maximum of 12)" required>
              </div>
              <div class="form-group mb-2">
                <label for="exampleInputPassword1"><strong>Game Code</strong> 
                  &nbsp;<a href="#" @click="refresh"><span class="badge bg-success mb-2">Refresh</span></a>
                  &nbsp;<a href="#" @click="gameCodeDisabled=!gameCodeDisabled"><span class="badge bg-primary mb-2" >Edit</span></a>
                </label>
                <input style="text-transform:uppercase"  v-model="game_code"  type="text" class="form-control" id="exampleInputPassword1" minlength="5" maxlength="5" placeholder="Enter alphanumeric code" :disabled="gameCodeDisabled">
              </div>
              <div class="form-group mb-2">
                <label for="exampleInputPassword1"><strong>Expected Players</strong></label>
                <input v-model="player_count" type="number" class="form-control" id="exampleInputPassword1" min="1" placeholder="Enter the number of expected players" required>
              </div>
              <div class="form-group mb-2">
                <label for="exampleInputPassword1"><strong>Date of Event</strong></label>
                <input v-model="event_date" type="datetime-local" class="form-control" id="exampleInputPassword1" placeholder="Enter the number of expected players" required>
              </div>
              <div class="form-group mb-3">
                <label for="exampleInputPassword1"><strong>Additional Details</strong></label>
                <textarea v-model="additional_details" name="additional_details" id="additional_details" class="form-control" placeholder="Enter additional details if needed"></textarea>
              </div>
              <button type="submit" class="btn btn-primary">Submit</button>&nbsp;
              <a @click="cancelForm" class="btn btn-danger">Cancel</a>
            </form>
          </div>
    </transition>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import JsonCSV from 'vue-json-csv';
import Navigation from './Nav.vue';

let getStatusInterval;

export default {
  mounted(){
    // this.game_code='test22';
    this.game_code = Math.random().toString(36).slice(2).substring(0,5);
     axios.get('api/games').then(response => {
       this.events = response.data
     });
  },
  data(){
    return{
      openForm: false,
      hideTable: false,
      gameCodeDisabled: true,
      company_name: null,
      team_count: null,
      event_date: null,
      additional_details: null,
      game_code:null,
      player_count: null,
      events: null
    }
  },
  methods:{
    toggleEvent(ev_id, event_status){
                  axios.post('api/game/toggle_event',{
                                    event_id: ev_id,
                                    Status: event_status
                                }).then(response =>{
                                  if(response.data==1){
                                    //success
                                  }
                                  else{
                                    //error
                                  }
                                });
    },
    formatDate(event_date){
      let dt = new Date(event_date);
      return dt.toLocaleString("en-US")
    },
    identifyStatus(event_date, event_status){
      // return event_date.getTime();
      let d1 = new Date();
      let d2 = new Date(event_date);
      d2 = d2.setHours(0, 0, 0, 0);
      d1 = d1.setHours(0, 0, 0, 0);

      // return d1;
      
      if(d1>d2){
        return 'Closed';
      }
      else if(d1<d2 && (event_status == 0 || event_status == 1)){
        return "Upcoming";
      }
      else if(d1==d2 && event_status == 0){
        return "Today's Event";
      }
      else if(d1==d2 && event_status == 1){
        return "Ongoing";
      }
      else{
        return 'Cancelled';
      }
      // if(event_status == 0){
      //   return 'Active';
      // }
      // else if(event_status == 1){
      //   return 'Ongoing'
      // }
      // else{
      //   return '--N/A--';
      // }
    },
    refresh(){
      this.game_code = Math.random().toString(36).slice(2).substring(0,5);
    },
    openFormTrigger(){
      this.hideTable = true;
      setTimeout(() => {
        this.openForm = true;
      }, 1000);
    },
    submitForm(){
      this.$swal.fire({
          title: 'Are you sure you want to submit this form?',
          icon: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes'
        }).then((result) => {
          if (result.isConfirmed) {
               axios.post('api/game/store_event',{
                                    company_name: this.company_name,
                                    team_count: this.team_count,
                                    event_date: this.event_date,
                                    additional_details: this.additional_details,
                                    game_code: this.game_code,
                                    player_count: this.player_count
                                }).then(response => {
                                  if(response){
                                    console.log(response.data)
                                    if(response.data == 1){
                                      this.$swal.fire({
                                          icon: 'success',
                                          title: 'Success',
                                          text: 'Event successfully added.'
                                        }).then((result)=>{
                                            this.openForm = false;
                                            setTimeout(() => {
                                              this.hideTable = false;
                                            }, 1000);
                                        });
                                    }
                                    else if(response.data == 2){
                                        this.$swal.fire({
                                          icon: 'error',
                                          title: 'Ooops!',
                                          text: 'Game code already exist on our database. Please try another.'
                                        });
                                    }
                                    else{
                                        this.$swal.fire({
                                          icon: 'error',
                                          title: 'Ooops!',
                                          text: 'Something went wrong. Please try again or contact your admin.'
                                        });
                                    }
                                  }
                                });
          }
        })
                
    },
    cancelForm(){
      this.$swal.fire({
          title: 'Are you sure you want to cancel?',
          text: "The form will reset.",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes'
        }).then((result) => {
          if (result.isConfirmed) {
             this.openForm = false;
              setTimeout(() => {
                this.hideTable = false;
              }, 1000);
          }
        })
    },
  },
  components:{
    Navigation
  }
};
</script>

<style scoped>
.fade-enter-active {
  animation: fadeIn .5s;
}

.fade-leave-active {
  animation: fadeOut .5s;
}
</style>