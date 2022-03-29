<template>
  <div class="contianer-fluid pt3 mb-3">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container-fluid">
        <a class="navbar-brand" style="padding-left: 5px" href="#">
          <img src="/images/tabt_logo.png" height="70" alt=""
        /></a>
        <div class="navbar-nav ms-auto mb-2 mb-lg-0" id="navbarNavAltMarkup">
          <div class="navbar-nav">
            <a class="nav-link" aria-current="page" href="#">Events</a>
            <a class="nav-link" aria-current="page" href="#">Clients</a>
            <a class="nav-link" aria-current="page" href="#">Settings</a>
            <a class="nav-link" aria-current="page" href="#">Logout</a>
          </div>
        </div>
      </div>
    </nav>
    <div class="container-fluid px-5 pt-3" style="padding-bottom: 20px;">
      <div class="row justify-content-between align-items-center mb-3">
        <div class="col-12">
          <h2>Dashboard</h2>
          <div class="text-muted">Game overview &amp; summary</div>
        </div>
      </div>
      <div class="row">
        <div class="col-xxl-3 col-md-6 mb-5">
          <div class="card card-raised bg-dark text-white">
            <div class="card-body px-4">
              <div
                class="d-flex justify-content-between align-items-center mb-2"
              >
                <div class="me-2">
                  <div class="display-5 text-white" v-if="events">{{ events.length }}</div>
                  <div class="card-text">Tabitantei Events</div>
                </div>
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="50"
                  height="50"
                  fill="currentColor"
                  class="bi bi-calendar-event-fill"
                  viewBox="0 0 16 16"
                >
                  <path
                    d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v1h16V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4V.5zM16 14V5H0v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2zm-3.5-7h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5z"
                  />
                </svg>
              </div>
              <div class="card-text">
                <div class="d-inline-flex align-items-center">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="16"
                    height="16"
                    fill="currentColor"
                    class="bi bi-arrow-up"
                    viewBox="0 0 16 16"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5z"
                    />
                  </svg>
                  <div class="caption fw-500 me-2" v-if="events">{{ (((events.length) - 1 )/1)*100  }}%</div>
                  <div class="caption">from last year</div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xxl-3 col-md-6 mb-5">
          <div class="card card-raised bg-dark text-white">
            <div class="card-body px-4">
              <div
                class="d-flex justify-content-between align-items-center mb-2"
              >
                <div class="me-2">
                  <div class="display-5 text-white" v-if="allPlayers">{{ allPlayers.length }}</div>
                  <div class="card-text">Total Players Played</div>
                </div>
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="50"
                  height="50"
                  fill="currentColor"
                  class="bi bi-person-lines-fill"
                  viewBox="0 0 16 16"
                >
                  <path
                    d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5zm.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1h-4zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1h-2z"
                  />
                </svg>
              </div>
              <div class="card-text">
                <div class="d-inline-flex align-items-center">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="16"
                    height="16"
                    fill="currentColor"
                    class="bi bi-arrow-up"
                    viewBox="0 0 16 16"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5z"
                    />
                  </svg>
                  <div class="caption fw-500 me-2" v-if="allPlayers">{{ ((allPlayers.length - 2)/2)*100 }}%</div>
                  <div class="caption">from last year</div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xxl-3 col-md-6 mb-5">
          <div class="card card-raised bg-dark text-white">
            <div class="card-body px-4">
              <div
                class="d-flex justify-content-between align-items-center mb-2"
              >
                <div class="me-2">
                  <div class="display-5 text-white" v-if="currentPlayers">{{currentPlayers.length}}</div>
                  <div class="card-text">Current Event Players</div>
                </div>
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="50"
                  height="50"
                  fill="white"
                  class="bi bi-activity"
                  viewBox="0 0 16 16"
                >
                  <path
                    fill-rule="evenodd"
                    d="M6 2a.5.5 0 0 1 .47.33L10 12.036l1.53-4.208A.5.5 0 0 1 12 7.5h3.5a.5.5 0 0 1 0 1h-3.15l-1.88 5.17a.5.5 0 0 1-.94 0L6 3.964 4.47 8.171A.5.5 0 0 1 4 8.5H.5a.5.5 0 0 1 0-1h3.15l1.88-5.17A.5.5 0 0 1 6 2Z"
                  />
                </svg>
              </div>
              <div class="card-text">
                <div class="d-inline-flex align-items-center">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="16"
                    height="16"
                    fill="currentColor"
                    class="bi bi-arrow-up"
                    viewBox="0 0 16 16"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5z"
                    />
                  </svg>
                  <div class="caption fw-500 me-2">7%</div>
                  <div class="caption">from last event</div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xxl-3 col-md-6 mb-5">
          <div class="card card-raised bg-dark text-white">
            <div class="card-body px-4">
              <div
                class="d-flex justify-content-between align-items-center mb-2"
              >
                <div class="me-2">
                  <div class="display-5 text-white">No Data</div>
                  <div class="card-text">Fastest Game Completion</div>
                </div>
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="50"
                  height="50"
                  fill="currentColor"
                  class="bi bi-puzzle-fill"
                  viewBox="0 0 16 16"
                >
                  <path
                    d="M3.112 3.645A1.5 1.5 0 0 1 4.605 2H7a.5.5 0 0 1 .5.5v.382c0 .696-.497 1.182-.872 1.469a.459.459 0 0 0-.115.118.113.113 0 0 0-.012.025L6.5 4.5v.003l.003.01c.004.01.014.028.036.053a.86.86 0 0 0 .27.194C7.09 4.9 7.51 5 8 5c.492 0 .912-.1 1.19-.24a.86.86 0 0 0 .271-.194.213.213 0 0 0 .036-.054l.003-.01v-.008a.112.112 0 0 0-.012-.025.459.459 0 0 0-.115-.118c-.375-.287-.872-.773-.872-1.469V2.5A.5.5 0 0 1 9 2h2.395a1.5 1.5 0 0 1 1.493 1.645L12.645 6.5h.237c.195 0 .42-.147.675-.48.21-.274.528-.52.943-.52.568 0 .947.447 1.154.862C15.877 6.807 16 7.387 16 8s-.123 1.193-.346 1.638c-.207.415-.586.862-1.154.862-.415 0-.733-.246-.943-.52-.255-.333-.48-.48-.675-.48h-.237l.243 2.855A1.5 1.5 0 0 1 11.395 14H9a.5.5 0 0 1-.5-.5v-.382c0-.696.497-1.182.872-1.469a.459.459 0 0 0 .115-.118.113.113 0 0 0 .012-.025L9.5 11.5v-.003l-.003-.01a.214.214 0 0 0-.036-.053.859.859 0 0 0-.27-.194C8.91 11.1 8.49 11 8 11c-.491 0-.912.1-1.19.24a.859.859 0 0 0-.271.194.214.214 0 0 0-.036.054l-.003.01v.002l.001.006a.113.113 0 0 0 .012.025c.016.027.05.068.115.118.375.287.872.773.872 1.469v.382a.5.5 0 0 1-.5.5H4.605a1.5 1.5 0 0 1-1.493-1.645L3.356 9.5h-.238c-.195 0-.42.147-.675.48-.21.274-.528.52-.943.52-.568 0-.947-.447-1.154-.862C.123 9.193 0 8.613 0 8s.123-1.193.346-1.638C.553 5.947.932 5.5 1.5 5.5c.415 0 .733.246.943.52.255.333.48.48.675.48h.238l-.244-2.855z"
                  />
                </svg>
              </div>
              <div class="card-text">
                <div class="d-inline-flex align-items-center">
                  <!-- <i class="material-icons icon-xs">arrow_upward</i> -->
                  <div class="caption fw-500 me-2">-- N/A --</div>
                  <div class="caption"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="card card-raised">
        <div class="card-header bg-dark text-white px-4">
          <div class="d-flex justify-content-between align-items-center">
            <div class="p-1">
              <h4 class="card-title text-white" v-if="info">{{ info.company_name }}</h4>
              <div class="card-subtitle" v-if="resultGenerated == false">Game Progress</div>
              <div class="card-subtitle" v-if="resultGenerated">Game Result</div>
            </div>
            <div class="p-2 bd-highlight">
              <a class="btn btn-primary" @click="downloadCSVData" v-if="resultGenerated">Export Overall Result</a>&nbsp;
              <a @click="closeResult" class="btn btn-primary" v-if="resultGenerated">Back</a>
              <a class="btn btn-success" @click="triggerWinnerResult" href="#" role="button" v-if="resultGenerated==false">Generate
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="16"
                  height="16"
                  fill="currentColor"
                  class="bi bi-trophy-fill"
                  viewBox="0 0 16 16"
                >
                  <path
                    d="M2.5.5A.5.5 0 0 1 3 0h10a.5.5 0 0 1 .5.5c0 .538-.012 1.05-.034 1.536a3 3 0 1 1-1.133 5.89c-.79 1.865-1.878 2.777-2.833 3.011v2.173l1.425.356c.194.048.377.135.537.255L13.3 15.1a.5.5 0 0 1-.3.9H3a.5.5 0 0 1-.3-.9l1.838-1.379c.16-.12.343-.207.537-.255L6.5 13.11v-2.173c-.955-.234-2.043-1.146-2.833-3.012a3 3 0 1 1-1.132-5.89A33.076 33.076 0 0 1 2.5.5zm.099 2.54a2 2 0 0 0 .72 3.935c-.333-1.05-.588-2.346-.72-3.935zm10.083 3.935a2 2 0 0 0 .72-3.935c-.133 1.59-.388 2.885-.72 3.935z"
                  /></svg
              ></a>

              
            </div>
          </div>
        </div>
        <div class="card-body">
          <!-- Simple DataTables example-->
          <div>
            <table class="table table-striped table-responsive" v-if="resultGenerated">
              <thead>
                <tr>
                  <th style="width: 15%">Place</th>
                  <th style="width: 10%" scope="col">Team</th>
                  <th style="width: 20%">Time</th>
                  <th style="width: 25%">Puzzle Solved</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(item, index) in winnerList" :key="item.team_number">
                  <td scope="row">
                    <svg v-if="index+1 == 1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="gold" class="bi bi-trophy-fill" viewBox="0 0 16 16">
                      <path d="M2.5.5A.5.5 0 0 1 3 0h10a.5.5 0 0 1 .5.5c0 .538-.012 1.05-.034 1.536a3 3 0 1 1-1.133 5.89c-.79 1.865-1.878 2.777-2.833 3.011v2.173l1.425.356c.194.048.377.135.537.255L13.3 15.1a.5.5 0 0 1-.3.9H3a.5.5 0 0 1-.3-.9l1.838-1.379c.16-.12.343-.207.537-.255L6.5 13.11v-2.173c-.955-.234-2.043-1.146-2.833-3.012a3 3 0 1 1-1.132-5.89A33.076 33.076 0 0 1 2.5.5zm.099 2.54a2 2 0 0 0 .72 3.935c-.333-1.05-.588-2.346-.72-3.935zm10.083 3.935a2 2 0 0 0 .72-3.935c-.133 1.59-.388 2.885-.72 3.935z"/>
                    </svg>
                    <svg v-if="index+1 == 2" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="silver" class="bi bi-trophy-fill" viewBox="0 0 16 16">
                      <path d="M2.5.5A.5.5 0 0 1 3 0h10a.5.5 0 0 1 .5.5c0 .538-.012 1.05-.034 1.536a3 3 0 1 1-1.133 5.89c-.79 1.865-1.878 2.777-2.833 3.011v2.173l1.425.356c.194.048.377.135.537.255L13.3 15.1a.5.5 0 0 1-.3.9H3a.5.5 0 0 1-.3-.9l1.838-1.379c.16-.12.343-.207.537-.255L6.5 13.11v-2.173c-.955-.234-2.043-1.146-2.833-3.012a3 3 0 1 1-1.132-5.89A33.076 33.076 0 0 1 2.5.5zm.099 2.54a2 2 0 0 0 .72 3.935c-.333-1.05-.588-2.346-.72-3.935zm10.083 3.935a2 2 0 0 0 .72-3.935c-.133 1.59-.388 2.885-.72 3.935z"/>
                    </svg>
                    <svg v-if="index+1 == 3" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="brown" class="bi bi-trophy-fill" viewBox="0 0 16 16">
                      <path d="M2.5.5A.5.5 0 0 1 3 0h10a.5.5 0 0 1 .5.5c0 .538-.012 1.05-.034 1.536a3 3 0 1 1-1.133 5.89c-.79 1.865-1.878 2.777-2.833 3.011v2.173l1.425.356c.194.048.377.135.537.255L13.3 15.1a.5.5 0 0 1-.3.9H3a.5.5 0 0 1-.3-.9l1.838-1.379c.16-.12.343-.207.537-.255L6.5 13.11v-2.173c-.955-.234-2.043-1.146-2.833-3.012a3 3 0 1 1-1.132-5.89A33.076 33.076 0 0 1 2.5.5zm.099 2.54a2 2 0 0 0 .72 3.935c-.333-1.05-.588-2.346-.72-3.935zm10.083 3.935a2 2 0 0 0 .72-3.935c-.133 1.59-.388 2.885-.72 3.935z"/>
                    </svg>
                    <svg v-if="index+1 > 3" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="brown" class="bi bi-award-fill" viewBox="0 0 16 16">
                      <path d="m8 0 1.669.864 1.858.282.842 1.68 1.337 1.32L13.4 6l.306 1.854-1.337 1.32-.842 1.68-1.858.282L8 12l-1.669-.864-1.858-.282-.842-1.68-1.337-1.32L2.6 6l-.306-1.854 1.337-1.32.842-1.68L6.331.864 8 0z"/>
                      <path d="M4 11.794V16l4-1 4 1v-4.206l-2.018.306L8 13.126 6.018 12.1 4 11.794z"/>
                    </svg>
                    <span v-if="index+1 == 1"> 1st</span>
                    <span v-if="index+1 == 2"> 2nd</span>
                    <span v-if="index+1 == 3"> 3rd</span>
                    <span v-if="index+1 == 4"> 4th</span>
                    <span v-if="index+1 == 5"> 5th</span>
                    
                    
                  </td>
                  <td>Team {{item.team_number}}</td>
                  <td>{{getResultTime(item.TotalSecond)}}</td>
                  <td v-if="item.GameProgress>0">{{item.GameProgress}}</td>
                  <td v-else>0</td>
                </tr>

              </tbody>
            </table>
            <table class="table table-striped table-responsive" v-if="resultGenerated == false">
              <thead>
                <tr>
                  <th style="width: 15%">Team</th>
                  <th style="width: 10%" scope="col">Players' Count</th>
                  <th style="width: 20%">Puzzle</th>
                  <th style="width: 25%">Progress</th>
                  <th style="width: 15%">Status</th>
                  <th style="width: 15%">Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="item in teamList" :key="item.team_number">
                  <th scope="row">
                    Team {{item.team_number}}
                   </th>
                  <td>{{item.player_count}}</td>
                  <td>
                    <span v-if="item.puzzle_progress==null">Style Secrets</span>
                    <span v-if="item.puzzle_progress==1">Scout Salute</span>
                    <span v-if="item.puzzle_progress==2">Yokohama Goal</span>
                    <span v-if="item.puzzle_progress==3">Forest Pool</span>
                    <span v-if="item.puzzle_progress==4">Wardrobe Wisdom</span>
                    <span v-if="item.puzzle_progress==5">Karuizawa Goal</span>
                    <span v-if="item.puzzle_progress==6">Glass Fragments</span>
                    <span v-if="item.puzzle_progress==7">Historic Horsement</span>
                    <span v-if="item.puzzle_progress==8">Sendai Goal</span>
                    <span v-if="item.puzzle_progress==9">Dark Tower</span>
                    <span v-if="item.puzzle_progress==10">Sacred Signs</span>
                    <span v-if="item.puzzle_progress==11">Asakusa Goal</span>
                  </td>
                  <td>
                    <progress id="file" v-if="item.GameProgress" :value="item.GameProgress" max="12"></progress>
                  </td>
                  <td>
                    <span v-if="item.HelpCount>0" class="badge bg-warning">Asking for help</span>
                    <span v-if="item.HelpCount==0" class="badge bg-primary">Ongoing</span>
                    <span v-if="item.puzzle_progress==12" class="badge bg-success">Finished!</span>
                  </td>
                  <td>
                    <a v-if="item.HelpCount==0"  href="#" disabled><span class="badge bg-secondary">No Action</span></a>
                    <a v-if="item.HelpCount>0" @click="helpStatusTriggered(item.team_number)" href="#"><span class="badge bg-success">Help</span></a>
                  </td>
                </tr>
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

let getStatusInterval;

export default {
  data() {
    return {
      items: [
        { age: 40, first_name: "Dickerson", last_name: "Macdonald" },
        { age: 21, first_name: "Larsen", last_name: "Shaw" },
        { age: 89, first_name: "Geneva", last_name: "Wilson" },
        { age: 38, first_name: "Jami", last_name: "Carney" },
      ],
      info: null,
      events: null,
      allPlayers: null,
      currentPlayers: null,
      teamList: null,
      resultGenerated: false,
      winnerList: null
    };
  },
  methods:{
            getStatus(){
                axios.get('api/game/get_current_status',{
                                }).then(response => {
                                    if(response){
                                        this.teamList = response.data;
                                    }
                                });
            },
            downloadCSVData(){
    
},
            closeResult(){
                this.resultGenerated = false;
            },
            getResultTime(val){
                let diff = val;
                                            let newTime = diff / 60
                                            let newMinute = 0;
                                            let newHour = 0;
                                            if(parseInt(newTime)/60 >= 1){
                                                newHour = Math.round(parseInt(newTime)/60);
                                                newMinute = Math.round(parseInt(newTime)%60);
                                            }
                                            else{
                                                newMinute = parseInt(newTime);
                                            }

                                            if(newMinute<10){
                                                newMinute = "0"+newMinute;
                                            }
                                            let newSecond = Math.round((newTime - parseInt(newTime)) * 60)
                                            if(newSecond<10){
                                                newSecond = "0"+newSecond;
                                            }
                                            return  String(newHour+":"+newMinute+":"+newSecond)
            },
            triggerWinnerResult(){
                // this.generateWinner = true;
                axios.post('api/game/get_status_piano',{
                                }).then(response => {
                                    if(response){
                                        this.winnerList = response.data;
                                    }
                                });

                                let newResultTime;
                
                           let timerInterval;
                           this.$swal({
                                                    html: 'Calculating Results',
                                                    timer: 5000,
                                                    timerProgressBar: true,
                                                    allowOutsideClick: false,
                                                    didOpen: () => {
                                                        this.$swal.showLoading()
                                                        const b = this.$swal.getHtmlContainer().querySelector('b')
                                                        timerInterval = setInterval(() => {
                                                        b.textContent = this.$swal.getTimerLeft()
                                                        }, 5000)
                                                    },
                                                    willClose: () => {
                                                        clearInterval(timerInterval)
                                                    }
                                                    }).then((result) => {
                                                        // correctSound.play();
                                                       this.resultGenerated = true;
                                                        // console.log('player_list: '+this.playerList.nickName)
                                                    /* Read more about handling dismissals below */

                                                    if (result.dismiss === this.$swal.DismissReason.timer) {
                                                        

                                                    }
                                                })
            },
            helpStatusTriggered(val){
                this.$swal({
                        title: `Do you want to tag this as done?`,
                        // icon:'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: "Yes"
                    }).then((result) =>{
                       if (result.isConfirmed) {
                           let timerInterval;

                            axios.post('api/game/update_help',{
                                    id: val
                                }).then(response => {
                                    if(response){
                                         this.$swal({
                                                    html: 'Updating status...',
                                                    timer: 2000,
                                                    timerProgressBar: true,
                                                    allowOutsideClick: false,
                                                    didOpen: () => {
                                                        this.$swal.showLoading()
                                                        const b = this.$swal.getHtmlContainer().querySelector('b')
                                                        timerInterval = setInterval(() => {
                                                        b.textContent = this.$swal.getTimerLeft()
                                                        }, 5000)
                                                    },
                                                    willClose: () => {
                                                        clearInterval(timerInterval)
                                                    }
                                                    }).then((result) => {

                                                        this.$swal({
                                                            title:'Tagged as done.',
                                                            icon:'success'}).then(response => {
                                                                
                                                            });
                                                        // console.log('player_list: '+this.playerList.nickName)
                                                    /* Read more about handling dismissals below */

                                                    if (result.dismiss === this.$swal.DismissReason.timer) {
                                                        

                                                    }
                                                })
                                                    }
                                                });
                                    }
                                });

                                
                           
                // alert(val);
                // let objIndex = this.helpList.findIndex((obj => obj.id == val));
                // this.helpList[objIndex].isDone = 1;

               
            }
  },
  mounted(){
    axios
      .get("api/get_game_event_details")
      .then(response => (this.info = response.data))
      .catch(error => console.log(error));

       axios
      .get("api/game/get_game_events")
      .then(response => (this.events = response.data))
      .catch(error => console.log(error));

      axios
      .get("api/game/get_game_players")
      .then(response => (this.allPlayers = response.data))
      .catch(error => console.log(error));

      axios
      .get("api/game/get_current_game_players")
      .then(response => (this.currentPlayers = response.data))
      .catch(error => console.log(error));
      
      getStatusInterval = setInterval(() => this.getStatus(), 1000);
      // console.log('info data: '+this.info)
  }
};
</script>