<template>
  <div class="main">
    <transition name="fade">
      <div class="main_content" v-if="reactivated">
        <div
          :class="[
            tutorialStarted ? 'tutorial' : 'normal',
            'puzzle_title v-step-7',
          ]"
        >
          <div class="puzzle_name">{{ puzzleName }}</div>
          <div class="team_name">Team {{ teamNumber }}</div>
        </div>
        <div class="miro_answer">
          <div class="miro_holder v-step-0 v-step-1">
            <iframe
              class="responsive"
              style="z-index: -1 !important"
              :src="src"
              frameBorder="0"
              scrolling="no"
              allowFullScreen
            ></iframe>
          </div>
          <div :class="inputClass() + ' v-step-9'" v-if="show_inputs">
            <input
              v-model="userAnswer"
              v-on:keyup.enter="validateAnswer"
              class="answer"
              @click="inputClicked"
              placeholder="Please enter your answer here 答えを入力してください"
              type="text"
            />
            <button @click="validateAnswer" class="submit">Submit</button>
          </div>
          <div class="answer_result_holder" v-if="show_result_holder">
            <div
              v-if="answer_correct == false"
              @click="show_result_holder = false"
              class="wrong_answer"
            >
              Wrong answer. Please try again! 残念、不正解!
              もう一度挑戦しましょう!
            </div>
            <div
              v-if="answer_correct"
              @click="reactivate"
              class="correct_answer animate__animated animate__rubberBand"
            >
              {{ correctMessage }}
            </div>
          </div>
        </div>
      </div>
    </transition>
    <div
      :class="[
        albumShow == true ? 'show' : '',
        getPhotoAlbum() + ' photo_album v-step-8',
      ]"
      @click.self="openAlbum()"
      v-click-outside="closeAlbum"
    >
      <button
        v-if="showControl"
        class="arrow_left"
        @click="prevPage()"
      ></button>
      <div class="album_panel" @click.self="openAlbum()">
        <div class="album_section" @click.self="openAlbum()">
          <div
            @click="openImage(0 + pager)"
            :class="photodeg[degreeIndex()].first"
            v-if="album_image[currentIndex + 0 + pager]"
          >
            <img
              class="album_img"
              :src="album_image[currentIndex + 0 + pager]"
            />
          </div>
          <div
            @click="openImage(1 + pager)"
            :class="photodeg[degreeIndex()].second"
            v-if="album_image[currentIndex + 1 + pager]"
          >
            <img
              class="album_img"
              :src="album_image[currentIndex + 1 + pager]"
            />
          </div>
        </div>
        <div class="album_section" @click.self="openAlbum()">
          <div
            @click="openImage(2 + pager)"
            :class="photodeg[degreeIndex()].third"
            v-if="album_image[currentIndex + 2 + pager]"
          >
            <img
              class="album_img"
              :src="album_image[currentIndex + 2 + pager]"
            />
          </div>
          <div
            @click="openImage(3 + pager)"
            :class="photodeg[degreeIndex()].fourth"
            v-if="album_image[currentIndex + 3 + pager]"
          >
            <img
              class="album_img"
              :src="album_image[currentIndex + 3 + pager]"
            />
          </div>
        </div>
      </div>
      <button class="hide_btn" @click="closeAlbum()">Hide<br />かくれる</button>
      <div class="album_panel" @click.self="openAlbum()">
        <div class="album_section" @click.self="openAlbum()">
          <div
            @click="openImage(4 + pager)"
            :class="photodeg[degreeIndex()].fifth"
            v-if="album_image[currentIndex + 4 + pager]"
          >
            <img
              class="album_img"
              :src="album_image[currentIndex + 4 + pager]"
            />
          </div>
          <div
            @click="openImage(5 + pager)"
            :class="photodeg[degreeIndex()].sixth"
            v-if="album_image[currentIndex + 5 + pager]"
          >
            <img
              class="album_img"
              :src="album_image[currentIndex + 5 + pager]"
            />
          </div>
        </div>
        <div class="album_section" @click.self="openAlbum()">
          <div
            @click="openImage(6 + pager)"
            :class="photodeg[degreeIndex()].seventh"
            v-if="album_image[currentIndex + 6 + pager]"
          >
            <img
              class="album_img"
              :src="album_image[currentIndex + 6 + pager]"
            />
          </div>
          <div
            @click="openImage(7 + pager)"
            :class="photodeg[degreeIndex()].eight"
            v-if="album_image[currentIndex + 7 + pager]"
          >
            <img
              class="album_img"
              :src="album_image[currentIndex + 7 + pager]"
            />
          </div>
        </div>
      </div>

      <button
        v-if="showControl"
        class="arrow_right"
        @click="nextPage()"
      ></button>

      <vue-easy-lightbox
        scrollDisabled
        :visible="visible"
        :imgs="imgs"
        :index="index"
        @hide="handleHide"
        @on-next="onNext"
        @on-prev="onPrev"
      >
        <template v-slot:close-btn="{ close }">
          <button @click="close" class="lightbox_close">Close</button>
        </template>
      </vue-easy-lightbox>
    </div>
    <div class="help_container v-step-2">
      <div class="help_btn" @click="helpShowed = !helpShowed">
        <img class="help_img" :src="helpImage" />
      </div>
    </div>

    <transition name="slide-fade">
      <HelpModal
        v-if="helpShowed"
        :puzzleNumber="puzzleNumber"
        class="help_modal_new"
        @closeModal="closeModal"
        @helpTriggered="helpTriggered"
      />
    </transition>
    <v-tour
      class="v_tour"
      name="myTour"
      :steps="steps"
      :callbacks="myCallbacks"
      :options="{ highlight: true }"
    >
    </v-tour>
  </div>
</template>

<script>
import HelpModal from "./HelpModal.vue";
import axios from "axios";
let secondMiro =
  "https://miro.com/app/live-embed/o9J_kgVl-yc=/?embedAutoplay=true&moveToViewport=-664,-510,1328,1018";
let codeResponse;
let teamSetup;
let tempPuzzleName;
let getStatusInterval;
// let puzzTemp;

export default {
  name: "Mission",
  mounted() {
    // this.time_limit = codeResponse.time_limit;

    // this.$router.push({ name: "login.index" });
    if (codeResponse) {
      axios
        .post("api/game/get_game_time", {
          puzzle_number: 1,
          team_number: teamSetup.playerTeam,
          game_event_id: codeResponse.id,
        })
        .then((response) => {
          let game_time = response["data"].game_time;
          this.game_started = game_time["created_at"];
        });
    }
    // console.log('game started:'+this.game_started)
  },
  created() {
    // console.log("puzzle number: " + this.puzzleName);
    if (this.puzzleNumber == 1) {
      this.$swal({
        title: `Welcome, Explorers! Before I let you start your exploration, I have to show you around your interface. Here are the most important elements that will help you succeed.<br/>探検家の皆さん、ようこそ！旅に出発する前に、インターフェースについてご案内します。あなたの旅に役立つ機能を確認しましょう。`,
      }).then((result) => {
        this.$tours["myTour"].start();
      });
    }
  },
  beforeCreate() {
    codeResponse = JSON.parse(localStorage.getItem("codeResponse"));
    teamSetup = JSON.parse(localStorage.getItem("teamSetup"));
    // console.log('code response'+ codeResponse)
    if (codeResponse == null || teamSetup == null) {
      this.$router.push({ name: "login.index" });
    } else {
      // let instance = this/

      axios
        .post("api/game/get_status_last_specific", {
          game_event_id: codeResponse.id,
          playerTeam: teamSetup.playerTeam,
        })
        .then((response) => {
          this.teamNumber = teamSetup.playerTeam;
          if (response.data == 0) {
            // this.$router.push({ name: "yokohama.index" });
            this.puzzleName = "Style Secrets";
            this.correctAnswer = "talc";
            this.puzzleNumber = 1;
            this.helpImage = "/images/yokohama_help.png";
          } else if (response.data == 1) {
            // this.$router.push({ name: "yokohama.index" });
            this.puzzleName = "Scout Salute";
            this.correctAnswer = "jade";
            this.puzzleNumber = 2;
            this.helpImage = "/images/yokohama_help.png";
          } else if (response.data == 2) {
            // this.$router.push({ name: "yokohama.index" });
            this.puzzleName = "Yokohama Goal";
            this.correctAnswer = "ltejc";
            this.puzzleNumber = 3;
            this.helpImage = "/images/yokohama_help.png";
          } else if (response.data == 3) {
            // this.$router.push({ name: "karuizawa.index" });
            // this.puzzleName = "Forest Pool";
            // this.correctAnswer = "amenouzume";
            // this.puzzleNumber = 4;
            // this.helpImage = "/images/karuizawa_help.png";
            
              clearInterval(getStatusInterval);
              this.$router.push({ name: "forestpool.index" });
          } else if (response.data == 4) {
            // this.$router.push({ name: "karuizawa.index" });
            this.puzzleName = "Wardrobe Wisdom";
            this.correctAnswer = "susanoo";
            this.puzzleNumber = 5;
            this.helpImage = "/images/karuizawa_help.png";
          } else if (response.data == 5) {
            // this.$router.push({ name: "karuizawa.index" });
            this.puzzleName = "Karuizawa Goal";
            this.correctAnswer = "nzasm";
            this.puzzleNumber = 6;
            this.helpImage = "/images/karuizawa_help.png";
          } else if (response.data == 6) {
            // this.$router.push({ name: "sendai.index" });
            this.puzzleName = "Glass Fragments";
            this.correctAnswer = "benevolence";
            this.puzzleNumber = 7;
            this.helpImage = "/images/sendai_help.png";
          } else if (response.data == 7) {
            // this.$router.push({ name: "sendai.index" });
            this.puzzleName = "Historic Horsemen";
            this.correctAnswer = "wisdom";
            this.puzzleNumber = 8;
            this.helpImage = "/images/sendai_help.png";
          } else if (response.data == 8) {
            // this.$router.push({ name: "sendai.index" });
            this.puzzleName = "Sendai Goal";
            this.correctAnswer = "nlwsdv";
            this.puzzleNumber = 9;
            this.helpImage = "/images/sendai_help.png";
          } else if (response.data == 9) {
            // this.$router.push({ name: "asakusa.index" });
            this.puzzleName = "Dark Tower";
            this.correctAnswer = "yamato";
            this.puzzleNumber = 10;
            this.helpImage = "/images/asakusa_help.png";
          } else if (response.data == 10) {
            // this.$router.push({ name: "asakusa.index" });
            this.puzzleName = "Scared Signs";
            this.correctAnswer = "sadoiyo";
            this.puzzleNumber = 11;
            this.helpImage = "/images/asakusa_help.png";
          } else if (response.data == 11) {
            // this.$router.push({ name: "asakusa.index" });
            this.puzzleName = "Asakusa Goal";
            this.correctAnswer = "moai";
            this.puzzleNumber = 12;
            this.helpImage = "/images/asakusa_help.png";
          } else if (response.data >= 12) {
            clearInterval(getStatusInterval);
            this.$router.push({ name: "asakusa_completed.index" });
          }


          if(this.puzzleNumber){
              getStatusInterval = setInterval(() => this.getStatus(), 2500);
          }

          if (this.puzzleNumber === 1) {
            this.tutorialStarted = true;
          }

          if (this.puzzleNumber <= 2) {
            this.album_image = [
              "/images/YokoGallery-1.jpg",
              "/images/YokoGallery-2.jpg",
              "/images/YokoGallery-3.jpg",
              "/images/YokoGallery-4.jpg",
              "/images/YokoGallery-5.jpg",
              "/images/YokoGallery-6.jpg",
              "/images/YokoGallery-7.jpg",
              "/images/YokoGallery-8.jpg",
              "/images/YokoGallery-9.jpg",
              "/images/YokoGallery-10.jpg",
              "/images/YokoGallery-11.jpg",
              "/images/YokoGallery-12.jpg",
              "/images/YokoGallery-13.jpg",
              "/images/YokoGallery-14.jpg",
              "/images/YokoGallery-15.jpg",
              "/images/YokoGallery-16.jpg",
              "/images/YokoGallery-17.jpg",
              "/images/YokoGallery-18.jpg",
              "/images/YokoGallery-19.jpg",
              "/images/YokoGallery-20.jpg",
            ];
          } else if (this.puzzleNumber <= 5) {
            // alert('test');
            this.album_image = [
              "/images/Karuizawa-Gallery-1.jpg",
              "/images/Karuizawa-Gallery-2.jpg",
              "/images/Karuizawa-Gallery-3.jpg",
              "/images/Karuizawa-Gallery-4.jpg",
              "/images/Karuizawa-Gallery-5.jpg",
              "/images/Karuizawa-Gallery-7.jpg",
              "/images/Karuizawa-Gallery-8.jpg",
              "/images/Karuizawa-Gallery-10.jpg",
              "/images/Karuizawa-Gallery-11.jpg",
              "/images/Karuizawa-Gallery-12.jpg",
              "/images/Karuizawa-Gallery-13.jpg",
              "/images/Karuizawa-Gallery-14.jpg",
              "/images/Karuizawa-Gallery-15.jpg",
              "/images/Karuizawa-Gallery-17.jpg",
              "/images/Karuizawa-Gallery-19.jpg",
              "/images/Karuizawa-Gallery-23.jpg",
              "/images/Karuizawa-Gallery-24.jpg",
              "/images/Karuizawa-Gallery-25.jpg",
              "/images/Karuizawa-Gallery-26.jpg",
            ];
          } else if (this.puzzleNumber <= 8) {
            this.album_image = [
              "/images/Sendai Gallery 1.jpeg",
              "/images/Sendai Gallery 2.jpeg",
              "/images/Sendai Gallery 3.jpeg",
              "/images/Sendai Gallery 4.jpeg",
              "/images/Sendai Gallery 5.jpeg",
              "/images/Sendai Gallery 6.jpeg",
              "/images/Sendai Gallery 7.jpeg",
              "/images/Sendai Gallery 8.jpeg",
              "/images/Sendai Gallery 9.jpeg",
              "/images/Sendai Gallery 10.jpeg",
              "/images/Sendai Gallery 11.jpeg",
              "/images/Sendai Gallery 12.jpeg",
              "/images/Sendai Gallery 13.jpeg",
              "/images/Sendai Gallery 14.jpeg",
              "/images/Sendai Gallery 15.jpeg",
              "/images/Sendai Gallery 16.jpeg",
              "/images/Sendai Gallery 17.jpeg",
              "/images/Sendai Gallery 18.jpeg",
              "/images/Sendai Gallery 19.jpeg",
              "/images/Sendai Gallery 20.jpeg",
              "/images/Sendai Gallery 21.jpeg",
              "/images/Sendai Gallery 22.jpeg",
              "/images/Sendai Gallery 23.jpeg",
              "/images/Sendai Gallery 24.jpeg",
              "/images/Sendai Gallery 25.jpeg",
              "/images/Sendai Gallery 26.jpeg",
              "/images/Sendai Gallery 27.jpeg",
              "/images/Sendai Gallery 28.jpeg",
              "/images/Sendai Gallery 29.jpeg",
              "/images/Sendai Gallery 30.jpeg",
            ];
          } else if (this.puzzleNumber <= 12) {
            this.album_image = [
              "/images/Asakusa-Gallery-1.jpg",
              "/images/Asakusa-Gallery-2.jpg",
              "/images/Asakusa-Gallery-3.jpg",
              "/images/Asakusa-Gallery-4.jpg",
              "/images/Asakusa-Gallery-5.jpg",
              "/images/Asakusa-Gallery-6.jpg",
              "/images/Asakusa-Gallery-7.jpg",
              "/images/Asakusa-Gallery-8.jpg",
              "/images/Asakusa-Gallery-11.jpg",
              "/images/Asakusa-Gallery-12.jpg",
              "/images/Asakusa-Gallery-13.jpg",
              "/images/Asakusa-Gallery-14.jpg",
            ];
          }

          axios
            .post("api/game/get_miro_link", {
              game_event_id: codeResponse.id,
              team_number: teamSetup.playerTeam,
              puzzle_number: this.puzzleNumber,
            })
            .then((response) => {
              if (response) {
                this.miroURL = response.data;
                //    console.log(response.data)
              }
            });
        });
    }
  },
  data() {
    return {
      time_limit: null,
      game_started: null,
      correctMessage: "Correct! Click here to continue 正解! 次の問題に進む",
      tutorialStarted: false,
      puzzleNumber: null,
      userAnswer: "",
      albumShow: false,
      helpShowed: false,
      reactivated: true,
      show_result_holder: false,
      show_inputs: true,
      answer_correct: false,
      puzzleName: "",
      correctAnswer: "",
      teamNumber: 0,
      show: false,
      floorShow: false,
      imgs: "", // Img Url , string or Array of string
      visible: false,
      index: 0, // default: 0,
      showLanguageButton: false,
      img: this.elementImage,
      selectedImage: "",
      activeIndex: 0,
      activeLanguage: 1,
      nextDisabled: true,
      prevDisabled: true,
      showControl: false,
      missionCompleted: false,
      helpImage: null,
      src: "",
      miroURL: "",
      photodeg: [
        {
          first: "photo three_deg",
          second: "photo neg_four_deg",
          third: "photo four_deg",
          fourth: "photo neg_five_deg",
          fifth: "photo neg_three_deg",
          sixth: "photo five_deg",
          seventh: "photo six_deg",
          eight: "photo four_deg",
        },
        {
          first: "photo neg_three_deg",
          second: "photo six_deg",
          third: "photo neg_four_deg",
          fourth: "photo five_deg",
          fifth: "photo three_deg",
          sixth: "photo four_deg",
          seventh: "photo six_deg",
          eight: "photo three_deg",
        },
        {
          first: "photo three_deg",
          second: "photo neg_four_deg",
          third: "photo four_deg",
          fourth: "photo neg_five_deg",
          fifth: "photo neg_three_deg",
          sixth: "photo five_deg",
          seventh: "photo six_deg",
          eight: "photo four_deg",
        },
        {
          first: "photo neg_three_deg",
          second: "photo six_deg",
          third: "photo neg_four_deg",
          fourth: "photo five_deg",
          fifth: "photo three_deg",
          sixth: "photo four_deg",
          seventh: "photo six_deg",
          eight: "photo three_deg",
        },
        {
          first: "photo three_deg",
          second: "photo neg_four_deg",
          third: "photo four_deg",
          fourth: "photo neg_five_deg",
          fifth: "photo neg_three_deg",
          sixth: "photo five_deg",
          seventh: "photo six_deg",
          eight: "photo four_deg",
        },
      ],
      album_image: [],
      currentIndex: 0,
      pager: 0,
      steps: [
        {
          target: ".v-step-0", // We're using document.querySelector() under the hood
          content: `Here is your Miro board.<br/>This is where you can move<br/>things around and take notes!<br/>これはMiroボードと呼ばれるものです。<br/>このボード上では、アイテムを動かしたり、メモを取ったりすることができます。`,
          params: {
            placement: "left",
            modifiers: {
              arrow: {
                element: ".v-step__arrow",
              },
            },
          },
        },
        {
          target: ".v-step-1", // We're using document.querySelector() under the hood
          content: `The toolbar on the left provides you with tools to interact with the Miro board.<br/>You will mostly use the Pen tool to take notes and highlight items for your team. <br/>左端にあるツールバーには、Miroボードを操作するためのツールが用意されています。<br/>主に使用するのはペンツールです。これを使ってメモを取ったり、アイテムに印を付けることができます。`,
          params: {
            placement: "left",
            modifiers: {
              arrow: {
                element: ".v-step__arrow",
              },
            },
          },
        },
        {
          target: ".v-step-2",
          content: `If you need a hint, check previous answers, want to know how to use MIRO, or would like to call gamemasters, click on this button.<br/>ヒントが必要な時やMiroの使い方を知りたい時、またゲームマスターを呼びたい場合は、このボタンをクリックしてください。`,
          params: {
            placement: "top",
            modifiers: {
              arrow: {
                element: ".v-step__arrow",
              },
            },
          },
        },
        {
          target: ".v-step-3", // We're using document.querySelector() under the hood
          content: `To get some hints, press this button.<br/>ヒントを見るには、こちらのヒントボタンを押してください。`,
          params: {
            placement: "left",
            modifiers: {
              arrow: {
                element: ".v-step__arrow",
              },
            },
          },
        },
        {
          target: ".v-step-4", // We're using document.querySelector() under the hood
          content: `To check previous answers, press this.<br/>前のパズルの解答を確認するには、ここをクリックしてください。`,
          params: {
            placement: "left",
            modifiers: {
              arrow: {
                element: ".v-step__arrow",
              },
            },
          },
        },
        {
          target: ".v-step-5", // We're using document.querySelector() under the hood
          content: `If you need more help on using Miro,<br/>press this button here.<br/>Miroの操作についてのサポートが必要な場合は、こちらのボタンを押してください。`,
          params: {
            placement: "top",
            modifiers: {
              arrow: {
                element: ".v-step__arrow",
              },
            },
          },
        },
        {
          target: ".v-step-6", // We're using document.querySelector() under the hood
          content: `To call a GameMaster for help at ANYTIME, press this help button.<br/>ゲームマスターのヘルプが必要な場合は、こちらのヘルプボタンを押してください。To call a GameMaster for help at ANYTIME, press this help button.`,
          params: {
            placement: "top",
            modifiers: {
              arrow: {
                element: ".v-step__arrow",
              },
            },
          },
        },
        {
          target: ".v-step-7", // We're using document.querySelector() under the hood
          content: `Here you can see your team number and the puzzle title.<br/>ここでチーム番号とパズルのタイトルが確認できます。`,
          params: {
            placement: "left",
            modifiers: {
              arrow: {
                element: ".v-step__arrow",
              },
            },
          },
        },
        {
          target: ".v-step-8", // We're using document.querySelector() under the hood
          content: `In this zone you will find the photo album needed to solve the puzzle.<br/>Photos from it are clickable, so you can see them more closely.<br/>ここにパズルを解くために必要なフォトアルバムがあります。`,
          params: {
            placement: "left",
            modifiers: {
              arrow: {
                element: ".v-step__arrow",
              },
            },
          },
        },
        {
          target: ".v-step-9", // We're using document.querySelector() under the hood
          content: `When you think you have the answer,<br/>find the answer box below the Miro board here and type it in.<br/>答えを突き止めたら、Miroボードの下にあるアンサーボックスにその答えを入力してください。`,
          params: {
            placement: "top",
            modifiers: {
              arrow: {
                element: ".v-step__arrow",
              },
            },
          },
        },
      ],
      myCallbacks: {
        onPreviousStep: this.myCustomPreviousStepCallback,
        onNextStep: this.myCustomNextStepCallback,
        onSkip: this.tutorialSkipped,
      },
    };
  },
  watch: {
    miroURL: function (val) {
      this.src = val;
    },
    userAnswer: function (newVal, oldVal) {
      this.show_result_holder = false;
      this.answer_correct = false;
    },
    puzzleNumber: function (val) {
      // alert(val);
      if (val == 1) {
        this.$swal({
          title: `Welcome, Explorers! Before I let you start your exploration, I have to show you around your interface. Here are the most important elements that will help you succeed.<br/>探検家の皆さん、ようこそ！旅に出発する前に、インターフェースについてご案内します。あなたの旅に役立つ機能を確認しましょう。`,
        }).then((result) => {
          this.$tours["myTour"].start();
        });
      }
    },
  },
  methods: {
    getStatus() {
      axios
        .post("api/game/get_status", {
          game_event_id: codeResponse.id,
          playerTeam: teamSetup.playerTeam,
          puzzleNumber: this.puzzleNumber,
        })
        .then((response) => {
          let event_data = null;
          let game_status = null;
          if (response["data"].event_data)
            event_data = response["data"].event_data;
          if (response["data"].game_status)
            game_status = response["data"].game_status;
          // console.log(game_status);

          if (this.game_started) {
            // console.log('game_started'+ this.game_started);
            this.time_limit = event_data["time_limit"];
            let created_at = new Date(this.game_started);

            const today = new Date();

            let diff = Math.round((today - created_at) / 1000 / 60);

            if (diff > this.time_limit) {
              // alert('time is up');
              clearInterval(getStatusInterval);
              this.$swal({
                imageUrl: "/images/game_over.png",
                width: 1048,
                height: 544,
                imageHeight: 524,
                background: "#ffffff20",
                timer: 180000,
                timerProgressBar: true,
                allowOutsideClick: false,
                didOpen: () => {
                  this.$swal.showLoading();
                  const b = this.$swal.getHtmlContainer().querySelector("b");
                  timerInterval = setInterval(() => {
                    b.textContent = this.$swal.getTimerLeft();
                  }, 60000);
                },
                willClose: () => {
                  // clearInterval(timerInterval)
                },
              }).then((result) => {
                /* Read more about handling dismissals below */

                localStorage.removeItem("codeResponse");
                localStorage.removeItem("gameProgress");
                localStorage.removeItem("teamSetup");

                this.$router.push({ name: "login.index" });

                if (result.dismiss === this.$swal.DismissReason.timer) {
                }
              });
            } 
            else{
              if (game_status["answered_current"] == 1) {
                // this.timeisPaused = true;
                // clearInterval(getStatusInterval);
                if (game_status["player_number"] != teamSetup.playerName) {
                  if (
                    this.puzzleNumber == 3 ||
                    this.puzzleNumber == 6 ||
                    this.puzzleNumber == 9 ||
                    this.puzzleNumber == 12
                  ) {
                    this.missionCompleted = true;
                  } else {
                    this.missionCompleted = false;
                  }
                  this.correctMessage =
                    "Team got the correct answer! Click here to continue. 正解! 次の問題に進む";
                
                  this.show_inputs = false;
                  this.show_result_holder = true;
                  this.answer_correct = true;
                  // this.puzzleNumber += 1;
                }
              }
            }
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    getPhotoAlbum() {
      // alert(this.puzzleNumber);
      if (this.puzzleNumber <= 3) {
        return "yokohama";
      } else if (this.puzzleNumber <= 6) {
        if (this.missionCompleted == true) return "yokohama";
        else return "karuizawa";
      } else if (this.puzzleNumber <= 9) {
        if (this.missionCompleted == true) return "karuizawa";
        else return "sendai";
      } else if (this.puzzleNumber <= 13) {
        console.log("asakusa photo album");
        if (this.missionCompleted == true) {
          return "sendai";
        } else {
          return "asakusa";
        }
      }
    },
    tutorialSkipped() {
      this.tutorialStarted = false;
    },
    myCustomPreviousStepCallback(currentStep) {
      if (
        currentStep === 7 ||
        currentStep === 6 ||
        currentStep === 5 ||
        currentStep === 4
      ) {
        this.helpShowed = true;
      } else {
        this.helpShowed = false;
      }

      if (currentStep == 8) {
        this.tutorialStarted = false;
      } else {
        this.tutorialStarted = true;
      }
    },
    myCustomNextStepCallback(currentStep) {
      // if(currentStep == currentStep){
      //     this.tutorialStarted = false;
      // }

      if (
        currentStep === 2 ||
        currentStep === 3 ||
        currentStep === 4 ||
        currentStep === 5
      ) {
        this.helpShowed = true;
      } else {
        this.helpShowed = false;
      }

      if (currentStep == 8) {
        this.tutorialStarted = false;
      } else {
        this.tutorialStarted = true;
      }
    },
    inputClicked() {
      this.helpShowed = false;
    },
    inputClass() {
      if (this.show_result_holder == true && this.answer_correct == false) {
        return "action_holder animate__animated animate__headShake";
      } else {
        return "action_holder";
      }
    },
    reactivate() {
      if (this.missionCompleted) {
        
        if (this.puzzleNumber+1 == 4) {
          clearInterval(getStatusInterval);
          this.$router.push({ name: "yokohama_completed.index" });
        } else if (this.puzzleNumber+1 == 7) {
          clearInterval(getStatusInterval);
          this.$router.push({ name: "karuizawa_completed.index" });
        } else if (this.puzzleNumber+1 == 10) {
          clearInterval(getStatusInterval);
          this.$router.push({ name: "sendai_completed.index" });
        } else if (this.puzzleNumber+1 == 13) {
          clearInterval(getStatusInterval);
          this.$router.push({ name: "asakusa_completed.index" });
        }
      } else {
          let img_explanation = "";
          if (this.puzzleNumber == 1) {
            img_explanation = "/images/1_explanation_talc.png";
          } 
          else if (this.puzzleNumber == 2) {
            img_explanation = "/images/1_explanation_jade.png";
          } 
          else if (this.puzzleNumber == 4) {
            img_explanation = "/images/2_explanation_amenouzume.png";
          } 
          else if (this.puzzleNumber == 5) {
            img_explanation = "/images/2_explanation_susanoo.png";
          }
          else if (this.puzzleNumber == 7) {
            img_explanation = "/images/3_explanation_benevolence.png"
          } 
          else if (this.puzzleNumber == 8) {
            img_explanation = "/images/3_explanation_wisdom.png";
          } 
          else if (this.puzzleNumber == 10) {
            img_explanation = "/images/4_explanation_yamato.png";
          } else if (this.puzzleNumber == 11) {
            img_explanation = "/images/4_explanation_sodaiyo.png";
          }

          this.$swal({
            imageUrl: img_explanation,
            width: 960,
            height: 540,
            imageHeight: 480,
            background: "#ffffff20",
            confirmButtonText: "I understand now. わかりました。",
            allowOutsideClick: false,
          }).then((response) => {
            this.puzzleNumber += 1;
            this.reactivated = false;
            this.src = "";
            this.answer_correct = false;
            this.show_result_holder = false;
            this.userAnswer = "";
            if (this.puzzleNumber == 2) {
              this.puzzleName = "Scout Salute";
              this.correctAnswer = "jade";
            } else if (this.puzzleNumber == 3) {
              this.puzzleName = "Yokohama Goal";
              this.correctAnswer = "ltejc";
            } else if (this.puzzleNumber == 4) {
              // this.puzzleName = "Forest Pool";
              // this.correctAnswer = "amenouzume";
              clearInterval(getStatusInterval);
              this.$router.push({ name: "forestpool.index" });
            } else if (this.puzzleNumber == 5) {
              this.puzzleName = "Wardrobe Wisdom";
              this.correctAnswer = "susanoo";
            } else if (this.puzzleNumber == 6) {
              this.puzzleName = "Karuizawa Goal";
              this.correctAnswer = "nzasm";
            } else if (this.puzzleNumber == 7) {
              this.puzzleName = "Glass Fragments";
              this.correctAnswer = "benevolence";
            } else if (this.puzzleNumber == 8) {
              this.puzzleName = "Historic Horsemen";
              this.correctAnswer = "wisdom";
            } else if (this.puzzleNumber == 9) {
              this.puzzleName = "Sendai Goal";
              this.correctAnswer = "nlwsdv";
            } else if (this.puzzleNumber == 10) {
              this.puzzleName = "Dark Tower";
              this.correctAnswer = "yamato";
            } else if (this.puzzleNumber == 11) {
              this.puzzleName = "Sacred Signs";
              this.correctAnswer = "sadoiyo";
            } else if (this.puzzleNumber == 12) {
              this.puzzleName = "Asakusa Goal";
              this.correctAnswer = "moai";
            }

            // setTimeout(this.reactivated=true, 50000);
            let parenthandler = this;

            setTimeout(function () {
              // alert('test');
              parenthandler.show_inputs = true;
              parenthandler.reactivated = true;
            }, 1500);

            axios
              .post("api/game/get_miro_link", {
                game_event_id: codeResponse.id,
                team_number: teamSetup.playerTeam,
                puzzle_number: this.puzzleNumber,
              })
              .then((response) => {
                if (response) {
                  this.miroURL = response.data;
                  //    console.log(response.data)
                }
              });
          });
      }
    },
    validateAnswer() {
      this.helpShowed = false;
      //Create checking if which puzzle user is
      // alert(this.userAnswer.toLowerCase().split(" ").join(""))
      if (
        this.userAnswer
          .toLowerCase()
          .split(" ")
          .join("")
          .indexOf(this.correctAnswer) >= 0
      ) {
        // alert('answer is correct');
        // this.reactivate();

        axios
          .post("api/game/store_status", {
            game_event_id: teamSetup.game_event_id,
            teamNumber: teamSetup.playerTeam,
            puzzle_progress: this.puzzleNumber,
            player_number: teamSetup.playerName,
          })
          .then((response) => {
            //do nothing.
          });
        this.show_inputs = false;
        this.show_result_holder = true;
        this.answer_correct = true;
        if (
          this.puzzleNumber == 3 ||
          this.puzzleNumber == 6 ||
          this.puzzleNumber == 9 ||
          this.puzzleNumber == 12
        ) {
          this.missionCompleted = true;
        } else {
          this.missionCompleted = false;
        }

        // this.puzzleNumber += 1;
      } else {
        this.show_result_holder = true;
      }
    },
    randomClass() {
      return "photo three_deg";
    },
    openAlbum() {
      this.albumShow = true;
      this.showControl = true;
    },
    closeAlbum() {
      if (this.visible == false) {
        this.albumShow = false;
        this.showControl = false;
      }
    },
    testMethod() {
      // alert('test');
      this.imgs = "/images/YokoGallery-1.jpg";
      this.index = this.activeIndex;
      this.visible = true;
    },
    degreeIndex() {
      if (this.currentIndex % 2 == 0) {
        return 1;
      } else {
        return 0;
      }
    },
    nextPage() {
      if (this.album_image.length / 8 > this.currentIndex + 1) {
        this.currentIndex += 1;
        this.pager += 7;
      }
    },
    prevPage() {
      if (this.currentIndex != 0) {
        this.currentIndex -= 1;
        this.pager -= 7;
      }
    },
    openImage(addtl) {
      if (this.albumShow == false) {
        this.albumShow = true;
      } else {
        // alert('test');
        this.imgs = this.album_image[this.currentIndex + addtl];

        this.index = this.activeIndex;
        this.visible = true;
        this.showControl = false;
      }
      //   alert('test');
    },
    handleHide() {
      this.showLanguageButton = false;
      this.visible = false;
      this.showControl = true;
    },
    onNext(oldIndex, newIndex) {
      this.activeIndex = newIndex;
      this.prevDisabled = false;
      if (newIndex == this.imgs.length - 1) {
        this.nextDisabled = true;
      }
    },
    onPrev(oldIndex, newIndex) {
      this.activeIndex = newIndex;
      if (newIndex == 0) {
        this.prevDisabled = true;
        if (this.imgs.length > 1) {
          this.nextDisabled = false;
        }
      } else {
        if (newIndex != this.imgs.length - 1) {
          this.nextDisabled = false;
        }
      }
    },
    closeModal() {
      this.helpShowed = false;
    },
    helpTriggered() {
      this.$swal({
        title:
          "Are you sure you want to call a gamemaster?<br/>ゲームマスターを呼びますか？",
        // icon:'warning',
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes",
        icon: "question",
      }).then((result) => {
        if (result.isConfirmed) {
          axios
            .post("api/game/store_game_help", {
              game_event_id: codeResponse.id,
              playerTeam: teamSetup.playerTeam,
              player_name: teamSetup.playerName,
              puzzle_number: this.puzzleNumber,
            })
            .then((response) => {
              this.$swal({
                title:
                  "ゲームマスターが参ります。<br/>A gamemaster will come for help.",
                icon: "success",
              }).then((response) => {});
            });
        }
      });
    },
  },
  components: {
    HelpModal,
  },
};
</script>

<style scoped>
.main {
  display: flex;
  align-content: center;
  justify-content: center;
  width: 100%;
  height: 100%;
  background-image: url("../assets/puzzle_bg.jpeg") !important;
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center;
}

.main_content {
  display: flex;
  width: 100%;
  height: 100%;
}

.puzzle_title {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: flex-start;
  height: 20%;
  color: white;
  gap: 2px;
  z-index: 10;
}

.puzzle_title.tutorial {
  width: 25%;
}

.puzzle_title.normal {
  width: 20%;
}

.puzzle_name {
  margin-top: 40px;
  margin-left: 10px;
  color: white;
  font-size: 2.8em;
  font-family: "Covered By Your Grace", cursive;
  background: rgba(48, 27, 1, 0.6);
  padding-left: 10px;
  padding-right: 10px;
  border-radius: 5px;
  text-align: center;
}

.team_name {
  font-size: 2.2em;
  color: white;
  background: rgba(48, 27, 1, 0.6);
  padding-left: 10px;
  padding-right: 10px;
  border-radius: 5px;
  font-weight: bold;
  font-family: "Covered By Your Grace", cursive;
}

.miro_answer {
  display: flex;
  flex-grow: 1;
  flex-direction: column;
  height: 100%;
  justify-content: space-evenly;
  align-content: center;
  align-items: center;
  gap: 15px;
}

.miro_holder {
  position: relative;
  border-radius: 10px;
  margin-top: 40px;
  width: 95%;
  height: 80%;
  border-radius: 10px;
  background-color: lightgray;
}

.responsive {
  height: 100%;
  width: 100%;
  border-radius: 10px;
}

.action_holder {
  height: 10%;
  /* background-color: white; */
  width: 90%;
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 10px;
  margin-bottom: 10px;
}

.answer_result_holder {
  margin-bottom: 15px;
  width: 70%;
}

.answer {
  position: relative;
  width: 60%;
  height: 45px;
  border: none;
  border-radius: 5px;
  padding: 10px;
  padding-left: 20px;
  font-size: 1.25em;
}

.wrong_answer {
  color: #721c24;
  height: 45px;
  width: 100%;
  /* padding: 5px; */
  padding-left: 10px;
  padding-right: 10px;
  background-color: #f5c6cb;
  text-align: center;
  line-height: 45px;
  border-radius: 5px;
  cursor: pointer;
  font-weight: 400;
  font-size: 1.75vw;
  font-family: "Covered By Your Grace", cursive;
}

.correct_answer {
  color: #fff;
  height: 45px;
  /* padding: 5px; */
  padding-left: 10px;
  padding-right: 10px;
  background-color: #12cdd4;
  text-align: center;
  line-height: 45px;
  border-radius: 5px;
  cursor: pointer;
  font-weight: 400;
  font-size: 1.5em;
  font-family: "Covered By Your Grace", cursive;
}

.answer:focus {
  outline: none !important;
  border-color: #719ece;
  box-shadow: 0 0 10px #719ece;
}

.submit {
  background-color: rgb(46, 29, 4);
  height: 50px;
  border: none;
  color: white;
  font-weight: bold;
  border-radius: 5px;
  border: solid 2px silver;
  font-size: 1em;
  padding-left: 7px;
  padding-right: 7px;
}

.submit:active {
  background-color: rgba(17, 11, 2);
  color: rgb(129, 129, 129);
  border: solid 2px rgb(88, 88, 88);
}

.photo_album {
  position: fixed;
  display: flex;
  align-content: center;
  justify-content: center;
  align-items: center;
  left: -70%;
  width: 90%;
  min-height: 500px;
  top: 20vh;
  /* background-image: url('../assets/photo_album.png') !important; */
  background-size: contain;
  background-repeat: no-repeat;
  background-position: center;
  transition: all 1s;
  cursor: pointer;
  z-index: 12;
}

.photo_album.yokohama {
  background-image: url("../assets/photo_album_yokohama.png") !important;
}

.photo_album.karuizawa {
  background-image: url("../assets/photo_album_karuizawa.png") !important;
}

.photo_album.sendai {
  background-image: url("../assets/photo_album_sendai.png") !important;
}

.photo_album.asakusa {
  background-image: url("../assets/photo_album_asakusa.png") !important;
}

.photo_album.show {
  left: 0;
  right: 0;
  margin-left: auto;
  margin-right: auto;
  cursor: unset;
  z-index: 12;
}

.album_panel {
  position: relative;
  width: 40%;
  height: 25vw;
  /* background-color: black; */
  display: flex;
  flex-direction: column;
  align-content: center;
  justify-content: center;
  gap: 10px;
}

.album_section {
  position: relative;
  height: 45%;
  width: 100%;
  display: flex;
  align-content: center;
  justify-content: space-evenly;
}

.photo {
  position: relative;
  background-color: white;
  width: 20%;
  height: 85%;
  box-shadow: 0 3px 6px rgb(0 0 0 / 25%);
  padding: 10px;
  cursor: pointer;
  z-index: 12;
}

.photo.three_deg {
  transform: rotate(3deg);
}

.photo.neg_three_deg {
  transform: rotate(-3deg);
}

.photo.neg_six_deg {
  transform: rotate(-6deg);
}

.photo.six_deg {
  transform: rotate(6deg);
}

.photo.five_deg {
  transform: rotate(5deg);
}

.photo.four_deg {
  transform: rotate(4deg);
}

.photo.neg_five_deg {
  transform: rotate(-5deg);
}

.photo.neg_four_deg {
  transform: rotate(-4deg);
}

.album_img {
  position: relative;
  width: 100%;
  height: 90%;
  object-fit: cover;
  z-index: 10;
  cursor: pointer;
}

.arrow_left {
  position: relative;
  left: 40px;
  z-index: 1;
  background: rgba(146, 87, 12, 0.8);
  background-image: url("../assets/prev_page_new.png") !important;
  background-size: 100% auto;
  background-repeat: no-repeat;
  background-position: center;
  height: 50px;
  width: 50px;
  border: none;
  display: flex;
  justify-content: center;
  align-content: center;
  border-radius: 50%;
  cursor: pointer;
}

.arrow_right {
  position: relative;
  right: 50px;
  z-index: 1;
  background: rgba(146, 87, 12, 0.8);
  background-image: url("../assets/next_page_new.png") !important;
  background-size: 100% auto;
  background-repeat: no-repeat;
  background-position: center;
  height: 50px;
  width: 50px;
  border: none;
  display: flex;
  justify-content: center;
  align-content: center;
  border-radius: 50%;
  cursor: pointer;
}

.hide_btn {
  position: absolute;
  z-index: 10;
  background: rgba(146, 87, 12, 0.8);
  border: none;
  cursor: pointer;
  color: white;
  font-weight: regular;
  border-radius: 5px;
  font-size: 1.25vw;
  font-weight: bolder;
}

.help_container {
  z-index: 15;
  position: fixed;
  left: 10px;
  bottom: 10px;
  height: 150px;
  width: 150px;
  display: flex;
  justify-content: center;
  align-content: center;
  align-items: center;
}

.help_btn {
  display: flex;
  align-content: center;
  justify-content: center;
  height: 150px;
  width: 150px;
  cursor: pointer;
  padding: 5px;
}

.help_img {
  box-shadow: 0px 7px 7px 0 #222;
  border-radius: 50%;
}

.help_img:active {
  box-shadow: 0 3px 3px 0 #222;
  border-radius: 50%;
}

.help_modal_new {
  height: 450px;
  width: 310px;
  border-radius: 20px;
  bottom: 125px;
  left: 150px;
  z-index: 100;
}

.fade-enter-active {
  animation: fadeIn 2s;
}

.fade-leave-active {
  animation: fadeOut 2s;
}

.slide-fade-enter-active {
  animation: bounce-in 0.3s reverse;
}
.slide-fade-leave-active {
  animation: bounce-in 0.5s;
}

.lightbox_close {
  position: absolute;
  right: 30px;
  top: 15px;
  font-size: 1.5vw;
  font-weight: bold;
  border-style: solid;
  border-radius: 5px;
  /* border-color: black; */
  justify-content: center;
  align-content: center;
}

@keyframes bounce-in {
  0% {
    transform: translateY(-10px);
  }
  100% {
    transform: translateY(10px);
  }
}

@media only screen and (max-width: 1500px) {
  .miro_holder {
    height: 95%;
  }
}

.v-tour__target--highlighted {
  box-shadow: 0 0 0 99999px rgba(0, 0, 0, 0.4);
}

.v-step[data-popper-placement="right"] > .v-step__arrow {
  background-image: url("/images/main_bg.jpg") !important;
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center;
  padding-left: 100px !important;
}

.v_tour {
  position: absolute;
  z-index: 99999;
}
</style>