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
              <a href="#" class="btn btn-primary">Add Event</a>
            </div>
          </div>
        </div>
        <div class="card-body">
          <!-- Simple DataTables example-->
          <div>
            <table class="table table-striped table-responsive">
              <thead>
                <tr>
                  <th style="width: 20%">Client</th>
                  <th style="width: 10%" scope="col">Schedule</th>
                  <th style="width: 15%">Number of Teams</th>
                  <th style="width: 25%">Status</th>
                  <th style="width: 10%">Action</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
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
  components:{
    Navigation
  }
};
</script>