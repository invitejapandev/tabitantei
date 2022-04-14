<template>
  <div v-if="teams">
    <!-- <table>
      <thead>
        <tr>
          <th>Team</th>
          <th>Puzzle</th>
          <th>Stage</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in team_puzzles" :key="item.team_id">
          <td>{{ item.team_id }}</td>
          <td>{{ item.puzzle }}</td>
          <td>{{ item.stage }}</td>
        </tr>
      </tbody>
    </table> -->
    <div class="form p-3">
      <div class="row">
        <div class="col-3">
          <div class="form-group mb-2">
                <label for="exampleInputEmail1"><strong>Team Count</strong></label>
                <input v-model="teams_count" type="number" class="form-control" min="1" id="team_count" name="team_count" placeholder="Enter Client Company Name" required>
                <!-- <small id="emailHelp" class="form-text text-muted">For Invite Japan use only.</small> -->
          </div>
           <div class="form-group mb-2">
                <label for="exampleInputEmail1"><strong>Stage Count</strong></label>
                <input v-model="stage_number" type="number" class="form-control" min="1"  id="stage_number" name="stage_number" placeholder="Enter Client Company Name" required>
                <!-- <small id="emailHelp" class="form-text text-muted">For Invite Japan use only.</small> -->
          </div>
          <div class="form-group mb-2">
            <label for="exampleInputEmail1"><strong>Origin Location</strong></label>
               <input v-model="origin_location.location_name" type="text" class="form-control" id="location_name" name="location_name" placeholder="Enter Client Company Name" required>
               <input v-model="origin_location.long" type="number" class="form-control" id="long" name="long" placeholder="Enter Client Company Name" required>
               <input v-model="origin_location.lat" type="number" class="form-control" id="lat" name="lat" placeholder="Enter Client Company Name" required>
          </div>
          <div class="form-group mb-2">
            <label for="exampleInputEmail1"><strong>Final Location</strong></label>
               <input v-model="end_location.location_name" type="text" class="form-control" id="location_name" name="location_name" placeholder="Enter Client Company Name" required>
               <input v-model="end_location.long" type="number" class="form-control" id="long" name="long" placeholder="Enter Client Company Name" required>
               <input v-model="end_location.lat" type="number" class="form-control" id="lat" name="lat" placeholder="Enter Client Company Name" required>
          </div>
        </div>
      </div>
       
    </div>
    <br />
    <br />
    <div class="p-3">
      <table v-if="teams" >
          <thead>
            <tr>
              <th class="p-3">TEAM</th>
              <th class="p-3" v-for="item in stage_number" :key="item"> STAGE {{ item }}</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="item in teams" :key="item.team_name">
              <td class="p-3">
               <strong>{{ item.team_name.toUpperCase() }}</strong>
              </td>
              <td class="p-3" v-for="puzzle in item.puzzle_ids" :key="puzzle">
                  {{ puzzle }}
              </td>
            </tr>
          </tbody>
        </table>
    </div>
    
    <br />
    <!-- <li v-for="item in team_puzzles" :key="item.team_id">
                {{ item.team_id }} - <strong> Puzzle: </strong>{{item.puzzle}} - {{item.stage}}
            </li> -->
  </div>
</template>

<script>
export default {
  data() {
    return {
      puzzle: {
        number: null,
        title: null,
        zone: null,
        maximum_concurrent: null,
      },
      teams: [],
      teams_count: 12,
      team_puzzles: [],
      final_puzzles: [],
      stage_number: 12,
      origin_location: {
        location_name: "Asakusa Station",
        long: 139.79759,
        lat: 35.7108,
      },
      end_location: {
        location_name: "Asakusa Station",
        long: 139.79759,
        lat: 35.7108,
      },
      puzzle_loc: [
        {
          puzzle_name: "_101dark_wall",
          long: 139.8001046,
          lat: 35.7096209,
          distance: 0,
        },
        {
          puzzle_name: "_102water_beasts",
          long: 139.8004161,
          lat: 35.7101174,
          distance: 0,
        },
        {
          puzzle_name: "_104plaza_arrows",
          long: 139.8006633,
          lat: 35.7099557,
          distance: 0,
        },
        {
          puzzle_name: "_106animal_nest",
          long: 139.8008939,
          lat: 35.7101996,
          distance: 0,
        },
        {
          puzzle_name: "_150heian_wind",
          long: 139.8011783,
          lat: 35.7108443,
          distance: 0,
        },
        {
          puzzle_name: "_201katoki_bridge",
          long: 139.803218,
          lat: 35.7143094,
          distance: 0,
        },
        {
          puzzle_name: "_202panaromic_view_sixteen",
          long: 139.8025998,
          lat: 35.7122425,
          distance: 0,
        },
        {
          puzzle_name: "_204meiji_passage",
          long: 139.7993061,
          lat: 35.7098512,
          distance: 0,
        },
        {
          puzzle_name: "_301number_bench",
          long: 139.8002756,
          lat: 35.7125803,
          distance: 0,
        },
        {
          puzzle_name: "_302utagawa_ukiyo_e",
          long: 139.8004982,
          lat: 35.7127501,
          distance: 0,
        },
        {
          puzzle_name: "_304_creator_tiles",
          long: 139.7982681,
          lat: 35.7106439,
          distance: 0,
        },
        {
          puzzle_name: "_305park_ways",
          long: 139.8010765,
          lat: 35.7132343,
          distance: 0,
        },
        {
          puzzle_name: "_306animal_spirits",
          long: 139.8019026,
          lat: 35.7138789,
          distance: 0,
        },
        {
          puzzle_name: "_307megurin_map",
          long: 139.7983056,
          lat: 35.7108291,
          distance: 0,
        },
        {
          puzzle_name: "_308the_painter",
          long: 139.7978496,
          lat: 35.7105546,
          distance: 0,
        },
        {
          puzzle_name: "_401ekimise",
          long: 139.7982242,
          lat: 35.7114694,
          distance: 0,
        },
        {
          puzzle_name: "_402vegi_stand",
          long: 139.8015003,
          lat: 35.7150549,
          distance: 0,
        },
        {
          puzzle_name: "_404old_asakusa",
          long: 139.7987398,
          lat: 35.7125939,
          distance: 0,
        },
        {
          puzzle_name: "_501thieves_of_old_edo",
          long: 139.7972646,
          lat: 35.7126854,
          distance: 0,
        },
        {
          puzzle_name: "_601banner_street",
          long: 139.793668,
          lat: 35.7154004,
          distance: 0,
        },
        {
          puzzle_name: "_603owarai_street",
          long: 139.7937844,
          lat: 35.7132965,
          distance: 0,
        },
        {
          puzzle_name: "_604shibaraku_status",
          long: 139.7963686,
          lat: 35.7151494,
          distance: 0,
        },
        {
          puzzle_name: "_605eight_paintings",
          long: 139.7956976,
          lat: 35.7145477,
          distance: 0,
        },
        {
          puzzle_name: "_606the_entertainers",
          long: 139.7933864,
          lat: 35.7138668,
          distance: 0,
        },
        {
          puzzle_name: "_607postmaster_panda",
          long: 139.7957705,
          lat: 35.7150122,
          distance: 0,
        },
        {
          puzzle_name: "_701peaceful_tow",
          long: 139.7970526,
          lat: 35.7136352,
          distance: 0,
        },
        {
          puzzle_name: "_702sacred_spaces",
          long: 139.7962985,
          lat: 35.714134,
          distance: 0,
        },
        {
          puzzle_name: "_703pigeon_chorus",
          long: 139.7963896,
          lat: 35.7142559,
        },
        {
          puzzle_name: "_704elevent_stone_monuments",
          long: 139.7960784,
          lat: 35.7142603,
          distance: 0,
        },
        {
          puzzle_name: "_705monument_puzzle",
          long: 139.7958585,
          lat: 35.7142733,
          distance: 0,
        },
        {
          puzzle_name: "_706maigo_ishi",
          long: 139.7965693,
          lat: 35.7142101,
          distance: 0,
        },
        {
          puzzle_name: "_707kanji_stone",
          long: 139.7959551,
          lat: 35.7143605,
          distance: 0,
        },
        {
          puzzle_name: "_801coffee_codes",
          long: 139.7972814,
          lat: 35.7112298,
          distance: 0,
        },
        {
          puzzle_name: "_803ancient_shops",
          long: 139.7957129,
          lat: 35.7128849,
          distance: 0,
        },
        {
          puzzle_name: "_901orante_town",
          long: 139.7950584,
          lat: 35.7127673,
          distance: 0,
        },
        {
          puzzle_name: "_904tanuki_town",
          long: 139.794581,
          lat: 35.7118439,
          distance: 0,
        },
        {
          puzzle_name: "_902star_hands",
          long: 139.7951014,
          lat: 35.712702,
          distance: 0,
        },
        {
          puzzle_name: "_903colorful_cows",
          long: 139.7929556,
          lat: 35.7111296,
          distance: 0,
        },
        {
          puzzle_name: "_991main_office",
          long: 139.7922207,
          lat: 35.7117437,
          distance: 0,
        },
        {
          puzzle_name: "_303sora_chan",
          long: 139.7981125,
          lat: 35.710657,
          distance: 0,
        },
      ],
    };
  },
  methods: {
    shuffle(array) {
      let currentIndex = array.length,
        randomIndex;

      // While there remain elements to shuffle.
      while (currentIndex != 0) {
        // Pick a remaining element.
        randomIndex = Math.floor(Math.random() * currentIndex);
        currentIndex--;

        // And swap it with the current element.
        [array[currentIndex], array[randomIndex]] = [
          array[randomIndex],
          array[currentIndex],
        ];
      }

      return array;
    },
    getDistanceFromLatLonInKm(lat1, lon1, lat2, lon2) {
    //   console.log(
    //     "lat1:" + lat1 + "lon1:" + lon1 + "lat2:" + lat2 + "lon2:" + lon2
    //   );
      var R = 6371; // Radius of the earth in km
      var dLat = this.deg2rad(lat2 - lat1); // deg2rad below
      var dLon = this.deg2rad(lon2 - lon1);
      var a =
        Math.sin(dLat / 2) * Math.sin(dLat / 2) +
        Math.cos(this.deg2rad(lat1)) *
          Math.cos(this.deg2rad(lat2)) *
          Math.sin(dLon / 2) *
          Math.sin(dLon / 2);
      var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
      var d = R * c; // Distance in km
    //   console.log(d);
      return d;
    },
    deg2rad(deg) {
      return deg * (Math.PI / 180);
    },
    generateNextLocation(currentIndex, oldIds){
        // return "currentIndex:"+currentIndex+" oldIds:"+oldIds[0];
        let puzzle_data = this.puzzle_loc.find(x => x.puzzle_name === oldIds[currentIndex-1]);
        // return puzzle_data.lat;
        let puzzle_local_temp = this.puzzle_loc;
        puzzle_local_temp.forEach((e) => {
            e.distance = this.getDistanceFromLatLonInKm(
                puzzle_data.lat,
                puzzle_data.long,
                e.lat,
                e.long
            );
        });

        puzzle_local_temp.sort((a, b) => {
            return a.distance - b.distance;
        });

        let i;
        var y=Math.random();
        //Distance meter (increase the value of i's to create great distance.)
        if(y < 0.5){
            i = 10;
        }
        else{
            i = 12;
        }


        while(oldIds.find(x => x ===puzzle_local_temp[i].puzzle_name)){
            i+=1;
        }
        return puzzle_local_temp[i].puzzle_name;
    },
    getRandomInt(min, max) {
        min = Math.ceil(min);
        max = Math.floor(max);
        return Math.floor(Math.random() * (max - min + 1)) + min;
    },
    countInArray(array, what) {
        var count = 0;
        for (var i = 0; i < array.length; i++) {
            if (array[i] === what) {
                count++;
            }
        }
        return count;
    },
    randomizer(){
      for (var i = 0; i < this.teams_count; i++) {
      if (i < 25) {
        this.teams.push({
          team_name: String.fromCharCode(96 + i + 1),
          puzzle_ids: [],
        });
      } else if (i >= 25) {
        this.teams.push({
          team_name:
            String.fromCharCode(96 + (i - 24)) + "" + (i - 24),
          puzzle_ids: [],
        });
      }
    }

    //This part of algorithm is sorting the list of coordinates based on what puzzle is the nearest on the start zone.
    this.puzzle_loc.forEach((e) => {
      e.distance = this.getDistanceFromLatLonInKm(
        this.origin_location.lat,
        this.origin_location.long,
        e.lat,
        e.long
      );
    });

    this.puzzle_loc.sort((a, b) => {
      return a.distance - b.distance;
    });
        for (var stage_i = 0; stage_i < this.stage_number; stage_i++) {

              this.shuffle(this.teams);
              let puzzle_index_temp = 0;
              this.teams.forEach((e) => {
                if (stage_i == 0) {
                  //this part identifies the initial puzzles for the teams
                  e.puzzle_ids.push(this.puzzle_loc[puzzle_index_temp].puzzle_name);
                } else if (stage_i + 1 == this.stage_number) {
                  //this part identifies the final puzzles for the teams
                  this.puzzle_loc.forEach((e) => {
                        e.distance = this.getDistanceFromLatLonInKm(
                            this.end_location.lat,
                            this.end_location.long,
                            e.lat,
                            e.long
                        );
                    });

                    this.puzzle_loc.sort((a, b) => {
                        return a.distance - b.distance;
                    });
                
                  let end_iteration = this.getRandomInt(0, Math.floor((this.teams_count-1)/2));
                  while(e.puzzle_ids.find(x=>x === this.puzzle_loc[end_iteration].puzzle_name) || this.countInArray(this.final_puzzles, this.puzzle_loc[end_iteration].puzzle_name) >= 2){
                      end_iteration +=1;
                  }
                  
                  this.final_puzzles.push(this.puzzle_loc[end_iteration].puzzle_name);
                //   console.log("count:" + this.countInArray(this.final_puzzles, this.puzzle_loc[end_iteration].puzzle_name) + ", puzzle:" + this.puzzle_loc[end_iteration].puzzle_name);
                  e.puzzle_ids.push(this.puzzle_loc[end_iteration].puzzle_name);
                } else {
                  //this part identifies the puzzles in between of beginning and ending stages
                  e.puzzle_ids.push(this.generateNextLocation(stage_i, e.puzzle_ids));
                }

                puzzle_index_temp += 1;
              });
            }

            this.teams.sort((a, b) =>{
                let fa = a.team_name.toLowerCase();
                let fb = b.team_name.toLowerCase();

                if(fa < fb){
                    return -1;
                }
                if(fa > fb){
                    return 1;
                }

                return 0;
            });
    }
  },
  mounted() {
    //This part will assign the team names based on the number of teams the system is handling.
    for (var i = 0; i < this.teams_count; i++) {
      if (i < 25) {
        this.teams.push({
          team_name: String.fromCharCode(96 + i + 1),
          puzzle_ids: [],
        });
      } else if (i >= 25) {
        this.teams.push({
          team_name:
            String.fromCharCode(96 + (i - 24)) + "" + (i - 24),
          puzzle_ids: [],
        });
      }
    }

    //This part of algorithm is sorting the list of coordinates based on what puzzle is the nearest on the start zone.
    this.puzzle_loc.forEach((e) => {
      e.distance = this.getDistanceFromLatLonInKm(
        this.origin_location.lat,
        this.origin_location.long,
        e.lat,
        e.long
      );
    });

    this.puzzle_loc.sort((a, b) => {
      return a.distance - b.distance;
    });

    //This part will assign the puzzles for specific team based on how many pages were specified.
    for (var stage_i = 0; stage_i < this.stage_number; stage_i++) {

      this.shuffle(this.teams);
      let puzzle_index_temp = 0;
      this.teams.forEach((e) => {
        if (stage_i == 0) {
          //this part identifies the initial puzzles for the teams
          e.puzzle_ids.push(this.puzzle_loc[puzzle_index_temp].puzzle_name);
        } else if (stage_i + 1 == this.stage_number) {
          //this part identifies the final puzzles for the teams
          this.puzzle_loc.forEach((e) => {
                e.distance = this.getDistanceFromLatLonInKm(
                    this.end_location.lat,
                    this.end_location.long,
                    e.lat,
                    e.long
                );
            });

            this.puzzle_loc.sort((a, b) => {
                return a.distance - b.distance;
            });
        
          let end_iteration = this.getRandomInt(0, Math.floor((this.teams_count-1)/2));
          while(e.puzzle_ids.find(x=>x === this.puzzle_loc[end_iteration].puzzle_name) || this.countInArray(this.final_puzzles, this.puzzle_loc[end_iteration].puzzle_name) >= 2){
              end_iteration +=1;
          }
          
          this.final_puzzles.push(this.puzzle_loc[end_iteration].puzzle_name);
        //   console.log("count:" + this.countInArray(this.final_puzzles, this.puzzle_loc[end_iteration].puzzle_name) + ", puzzle:" + this.puzzle_loc[end_iteration].puzzle_name);
          e.puzzle_ids.push(this.puzzle_loc[end_iteration].puzzle_name);
        } else {
          //this part identifies the puzzles in between of beginning and ending stages
          e.puzzle_ids.push(this.generateNextLocation(stage_i, e.puzzle_ids));
        }

        puzzle_index_temp += 1;
      });
    }

    this.teams.sort((a, b) =>{
        let fa = a.team_name.toLowerCase();
        let fb = b.team_name.toLowerCase();

        if(fa < fb){
            return -1;
        }
        if(fa > fb){
            return 1;
        }

        return 0;
    });

    // for (var j = 0; j < this.stage_number; j++) {
    //   this.shuffle(this.teams);
    //   for (var i = 0; i < this.teams_count; i++) {
    //     if(j == 0){
    //         this.team_puzzles.push({
    //         team_id: this.teams[i].team_name,
    //         puzzle: this.puzzle_loc[i].puzzle_name,
    //         stage: j + 1,
    //         });
    //     }
    //     else{
    //         this.team_puzzles.push({
    //         team_id: this.teams[i].team_name,
    //         puzzle: "TBA",
    //         stage: j + 1,
    //         });
    //     }
    //   }
    // }

    // this.team_puzzles.sort((a, b) => {
    //   let fa = a.team_id.toLowerCase(),
    //     fb = b.team_id.toLowerCase();

    //   if (fa < fb) {
    //     return -1;
    //   }
    //   if (fa > fb) {
    //     return 1;
    //   }

    //   return 0;
    // });

    // this.team_puzzles.forEach((e) => {
    //   console.log(e.team_id);
    // });
  },
  watch: {
    teams_count:function(val){
      this.teams = [];
      this.final_puzzles  = [];
        this.randomizer()
    },
    stage_number:function(val){
      this.teams = [];
      this.final_puzzles  = [];
        this.randomizer()
    },
    'origin_location.long':function(val){
      this.teams = [];
      this.final_puzzles  = [];
        this.randomizer()
    },
    'origin_location.lat':function(val){
      this.teams = [];
      this.final_puzzles  = [];
        this.randomizer()
    },
    'end_location.long':function(val){
      this.teams = [];
      this.final_puzzles  = [];
        this.randomizer()
    },
    'end_location.lat':function(val){
      this.teams = [];
      this.final_puzzles  = [];
        this.randomizer()
    },
  },
};
</script>

<style scoped>
table,
th,
td {
  border: 1px solid black;
}
</style>