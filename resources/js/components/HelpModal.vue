<template>
                 <div :class="helpModal()">
                     
                    <div :class="helpModalMantle()">
                        <div :class="helpModalCore()">
                            <div class="help_modal_title">
                                <div class="help_jap">どのようなことでお困りですか？</div><div class="help_english">WHAT DO YOU NEED HELP FOR?</div>
                            </div>
                            <div class="help_modal_option">
                                <button  :class="helpButton()+' v-step-3'" @click="boardClicked(puzzleNumber, 1)"><div class="help_jap">ヒントが必要</div>
                                <div class="help_english">NEED A HINT</div></button>
                                <button :class="helpButton()+' v-step-4'" @click="boardClicked(80+puzzleNumber, 1)"><div class="help_jap">ヒントが必要</div>
                                <div class="help_english">PREVIOUS ANSWER</div></button>
                                <button :class="helpButton()+' v-step-5'" @click="boardClicked(99, activeLanguage)"><div class="help_jap">MIROボードの使い方</div>
                                <div class="help_english">MIRO BOARD QUICK TIPS</div></button>
                                <button :class="helpButton()+' v-step-6'" @click="helpTriggered()"><div class="help_jap">ゲームマスターを呼ぶ</div>
                                <div class="help_english">CALL A GAMEMASTER</div></button>
                            </div>
                        </div>
                    </div>
                    <div class="close_btn" v-on:click="closeModal()"><img  class="close_btn_img" src="../assets/close_btn.png"/></div>
                      <vue-easy-lightbox
      scrollDisabled
      :visible="visible"
      :imgs="imgs"
      :index="index"
      @hide="handleHide"
      @on-next="onNext"
      @on-prev="onPrev"
    >
    <template v-slot:prev-btn="{ prev }">
    <button :disabled="prevDisabled" @click="prev" class="lightbox_prev"><img  class="close_btn_img" src="../assets/prev_page.png"/>Prev</button>
    
  </template>

  <template v-slot:next-btn="{ next }">
    <button :disabled="nextDisabled" class="lightbox_next" @click="next">Next<img  class="close_btn_img" src="../assets/next_page.png"/></button>
  </template>

  <template v-slot:close-btn="{ close }">
    <button  @click="close" class="lightbox_close">Close</button>
     <div v-if="isOpen == false" class="unlocker">
        <a @click="openClicked" class="unlock_btn">Open</a>
    </div>
     <div v-if="isRevealed" class="unlocker">
        <a @click="revealClicked" class="unlock_btn">Reveal</a>
    </div>
  </template>

  
  </vue-easy-lightbox>

    <div class="language_buttons_help">
             <a href="#" :class="[showLanguageButton ? 'appear' : '', 'float3_help']" @click="boardClicked(selectedImage, 1)">
            <img src="../assets/japan.png" style="width: 100%; height: 100%; 
            border-radius:70px;
                object-fit: cover;"/>
                </a>

                <a href="#" :class="[showLanguageButton ? 'appear' : '', 'float3_help']" @click="boardClicked(selectedImage, 0)">
                    <img src="../assets/english.png" style="width: 100%; height: 100%; 
            border-radius:70px;
                object-fit: cover;"/>
                </a>
        </div>

   
    </div>
</template>

<script>
import axios from 'axios';

import VueEasyLightbox from 'vue-easy-lightbox';

// const style_secrets_hints = ['images/']
const style_secrets_hints = ['/images/_Style Secrets Hint A.png', '/images/_Style Secrets Hint B.png', '/images/_Style Secrets Hint C.png'];
const style_secrets_hints_open = ['/images/_Style Secrets Hint A.png', '/images/_Style Secrets Hint B.png', '/images/_Style Secrets Hint C.png'];

const scout_salute_hints = ['/images/_Scout Salute Hint A.png', '/images/_Scout Salute Hint B.png'];
const scout_salute_hints_open = ['/images/_Scout Salute Hint A.png', '/images/_Scout Salute Hint B.png'];

const forest_pool_hints = ['/images/_Forest Pool Hint A.png', '/images/_Forest Pool Hint B.png', '/images/_Forest Pool Hint C.png', '/images/_Forest Pool Hint D.png', '/images/_Forest Pool Hint E.png', '/images/_Forest Pool Hint F.png', '/images/_Forest Pool Hint G.png'];
const forest_pool_hints_open = ['/images/_Forest Pool Hint A.png', '/images/_Forest Pool Hint B.png', '/images/_Forest Pool Hint C.png', '/images/_Forest Pool Hint D.png', '/images/_Forest Pool Hint E.png', '/images/_Forest Pool Hint F.png', '/images/_Forest Pool Hint G.png'];

const wardrobe_wisdome_hints = ['/images/_Wardrobe Wisdom Hint A.png', '/images/_Wardrobe Wisdom Hint B.png'];
const wardrobe_wisdome_hints_open = ['/images/_Wardrobe Wisdom Hint A.png', '/images/_Wardrobe Wisdom Hint B.png'];

const glass_fragment_hints = ['/images/_Glass Fragment Hint A.png', '/images/_Glass Fragment Hint B.png'];
const glass_fragment_hints_open = ['/images/_Glass Fragment Hint A.png', '/images/_Glass Fragment Hint B.png'];

const history_horsement_hints = ['/images/_Historic Horsemen Hint A.png', '/images/_Historic Horsemen Hint B.png', '/images/_Historic Horsemen Hint C.png', '/images/_Historic Horsemen Hint D.png'];
const history_horsement_hints_open = ['/images/_Historic Horsemen Hint A.png', '/images/_Historic Horsemen Hint B.png', '/images/_Historic Horsemen Hint C.png', '/images/_Historic Horsemen Hint D.png'];

const dark_tower_hints = ['/images/_Dark Tower Hint A.png', '/images/_Dark Tower Hint B.png', '/images/_Dark Tower Hint C.png'];
const dark_tower_hints_open = ['/images/_Dark Tower Hint A.png', '/images/_Dark Tower Hint B.png', '/images/_Dark Tower Hint C.png'];

const sacred_signs_hints = ['/images/_Sacred Signs Hint A.png', '/images/_Sacred Signs Hint B.png'];
const sacred_signs_hints_open = ['/images/_Sacred Signs Hint A.png', '/images/_Sacred Signs Hint B.png'];

const floor_hints_open = ['/images/floor_directory_hint_a.png', '/images/floor_directory_hint_b_op.png'];
const computer_hints = ['/images/comp_hint_a.png', '/images/comp_hint_b.png', '/images/comp_hint_c.png', '/images/comp_hint_d.png'];
const computer_hints_open = ['/images/comp_hint_a.png','/images/hint_b_op.png','/images/hint_c_op.png','/images/hint_d_op.png'];
// const computer_hints_blurred = ['/images/comp_hint_a.jpg', '/images/comp_hint_b.jpg', '/images/comp_hint_c.jpg', '/images/comp_hint_d.jpg'];
const piano_hints = ['/images/piano_security_hint_a.png', '/images/piano_security_hint_b.png'];
const piano_hints_open = ['/images/piano_security_hint_a.png', '/images/piano_security_hint_b_op.png'];
const opera_house_hints = ['/images/opera_house_hint_a.png', '/images/opera_house_hint_b.png'];
const opera_house_hints_open = ['/images/opera_house_hint_a.png', '/images/opera_house_hint_b_op.png'];
const walking_tour_hints = ['/images/walking_tour_hint_a.png', '/images/walking_tour_hint_b.png','/images/walking_tour_hint_c.png'];
const walking_tour_hints_open = ['/images/walking_tour_hint_a.png', '/images/walking_tour_hint_b_op.png','/images/walking_tour_hint_c_op.png'];
const tower_hints = ['/images/tower_view_hint_a.png', '/images/tower_view_hint_b.png'];
const tower_hints_open = ['/images/tower_view_hint_a.png', '/images/tower_view_hint_b_op.png'];
const security_hints = ['/images/maison_de_verre_hint_a.png', '/images/maison_de_verre_hint_b.png'];
const security_hints_open = ['/images/maison_de_verre_hint_a.png', '/images/maison_de_verre_hint_b_op.png'];
const graffiti_hints = ['/images/grafitti_mural_hint_a.png', '/images/grafitti_mural_hint_b.png'];
const graffiti_hints_open = ['/images/grafitti_mural_hint_a.png', '/images/grafitti_mural_hint_b_op.png'];
const cafe_hints = ['/images/cafe_menu_hint_a.png', '/images/cafe_menu_hint_b.png'];
const cafe_hints_open = ['/images/cafe_menu_hint_a.png', '/images/cafe_menu_hint_b_op.png'];


const miro_help = '/images/mirohelp_eng.png';
const miro_help_jp = '/images/mirohelp_jp.png';

const floor1_image = '/images/emergencyplan_eng.png';
const floor2_image = '/images/burrito_eng.png';
const floor3_image = '/images/inter_eng.png';
const floor4_image = '/images/sell_eng.png';
const floor5_image = '/images/salsa_eng.png';

const floor1_image_jp = '/images/emergencyplan_jp.png';
const floor2_image_jp = '/images/burrito_jp.png';
const floor3_image_jp = '/images/inter_jp.png';
const floor4_image_jp = '/images/sell_jp.png';
const floor5_image_jp = '/images/salsa_eng.png';

const cover_jp = '/images/cover_jp.png';
const page_1_jp = '/images/page_1_jp.png';
const page_2_jp = '/images/page_2_jp.png';
const page_8_jp = '/images/page_8_jp.png';

const jp_manual = [cover_jp, page_1_jp, page_2_jp, page_8_jp];

const cover_en = '/images/cover_en.png';
const page_1_en = '/images/page_1_en.png';
const page_2_en = '/images/page_2_en.png';
const page_8_en = '/images/page_8_en.png';

const en_manual = [cover_en, page_1_en, page_2_en, page_8_en];

const cafe_img = '/images/cafe_english.png';
const cafe_img_j ='/images/cafe_japanese.png';


const en_floor_image = [floor1_image, floor2_image, floor3_image, floor4_image];



const g_3 = '/images/g_1_new.png';
const g_2 = '/images/g_2_new.png';
const g_1 = '/images/g_3_new.png';
const g_4 = '/images/g_4_new.png';
let codeResponse, teamSetup;

const g_images = [g_1, g_2, g_3, g_4];


export default {
    name: "HelpModal",
        beforeCreate(){
            
        codeResponse = JSON.parse(localStorage.getItem('codeResponse'));
        teamSetup = JSON.parse(localStorage.getItem('teamSetup'));

           axios.post('api/game/get_hint_log',{
                        game_event_id: codeResponse.id,
                        team_number: teamSetup.playerTeam,
                        puzzle_number: this.puzzleNumber
                        }).then(response => {
                            console.log(response);
                            if(response.data === 1){
                                this.isOpen = true;
                                this.isOpenTemp = true;
                              this.closed_hints = this.openIdentifier();

                                axios.post('api/game/get_reveal_log',{
                                        game_event_id: codeResponse.id,
                                        team_number: teamSetup.playerTeam,
                                        puzzle_number: this.puzzleNumber,
                                        player_number: teamSetup.playerName
                                    }).then(response => {
                                          if(response.data['unlocked_hints']){
                                            //   console.log('unlocked_hints_list:'+ response.data['unlocked_hints']);
                                            let unlocked_hints = response.data['unlocked_hints'];
                                            let unlocked_array = unlocked_hints.split(",").map(Number);
                                              this.unlockedHints = unlocked_array;
                                            //   console.log('unlocked_hints_list:'+ unlocked_array);
                                          }
                                    }).catch(error => {
                                            // alert('something went wrong');
                                    });
                            }
                            else{
                            }
                        }).catch(error => {
                            // alert('something went wrong');
                        });
        },
        beforeUnmount(){
            axios.post('api/game/store_reveal_log',{
                                        game_event_id: codeResponse.id,
                                        team_number: teamSetup.playerTeam,
                                        puzzle_number: this.puzzleNumber,
                                        player_number: teamSetup.playerName,
                                        unlocked_hints: this.unlockedHints
                                    }).then(response => {
                                          if(response.data){
                                            //   console.log('unlocked_hints_list:'+ response.data['unlocked_hints']);
                                            //   this.unlockedHints = response.data['unlocked_hints'];
                                          }
                                    }).catch(error => {
                                            // alert('something went wrong');
                                    });
        },
        data(){
            return{
                show: false,
                floorShow: false,
                imgs: '', // Img Url , string or Array of string
                visible: false,
                index: 0, // default: 0,
                showLanguageButton: false,
                img: this.elementImage,
                selectedImage: '',
                activeIndex2: 0,
                activeLanguage: 1,
                nextDisabled: true,
                prevDisabled: true,
                showUnlockBtn: false,
                isOpen: false,
                isOpenTemp: false,
                isRevealed: false,
                unlockedHints: [],
                computer_hints_blurred: ['/images/comp_hint_a.jpg', '/images/comp_hint_b.jpg', '/images/comp_hint_c.jpg', '/images/comp_hint_d.jpg'],
                closed_hints: ['/images/hint.png'],
                open_hints: ['/images/hint_a_op.png','/images/hint_b_op.png','/images/hint_c_op.png','/images/hint_d_op.png']
            }
        },
        props:{
            puzzleNumber: Number
        },
        watch:{
            puzzleNumber: function(val){
                this.unlockedHints =[];
            }
        },
        methods:{
        helpModal(){
            if(this.puzzleNumber <=3){
                return 'help_modal yokohama';
            }
            else if(this.puzzleNumber <=6){
                return 'help_modal karuizawa';
            }
            else if(this.puzzleNumber <=9){
                return 'help_modal sendai';
            }
            else if(this.puzzleNumber <=12){
                return 'help_modal asakusa';
            }
        },
        helpModalMantle(){
         if(this.puzzleNumber <=3){
                return 'help_modal_mantle yokohama';
            }
            else if(this.puzzleNumber <=6){
                return 'help_modal_mantle karuizawa';
            }
            else if(this.puzzleNumber <=9){
                return 'help_modal_mantle sendai';
            }
            else if(this.puzzleNumber <=12){
                return 'help_modal_mantle asakusa';
            }
        },
        helpModalCore(){
            if(this.puzzleNumber <=3){
                return 'help_modal_core yokohama';
            }
            else if(this.puzzleNumber <=6){
                return 'help_modal_core karuizawa';
            }
            else if(this.puzzleNumber <=9){
                return 'help_modal_core sendai';
            }
            else if(this.puzzleNumber <=12){
                return 'help_modal_core asakusa';
            }
        },
        helpButton(){
            if(this.puzzleNumber <=3){
                return 'help_button yokohama';
            }
            else if(this.puzzleNumber <=6){
                return 'help_button karuizawa';
            }
            else if(this.puzzleNumber <=9){
                return 'help_button sendai';
            }
            else if(this.puzzleNumber <=12){
                return 'help_button asakusa';
            }
        },
        openIdentifier(){
                    if(this.puzzleNumber == 1){
                       return style_secrets_hints_open;
                    }
                    else if(this.puzzleNumber == 2){
                        return scout_salute_hints_open;
                    }
                    else if(this.puzzleNumber == 4){
                        return forest_pool_hints_open;
                    }
                    else if(this.puzzleNumber == 5){
                        return wardrobe_wisdome_hints_open;
                    }
                    else if(this.puzzleNumber == 7){
                        return glass_fragment_hints_open;
                    }
                    else if(this.puzzleNumber == 8){
                        return history_horsement_hints_open;
                    }
                    else if(this.puzzleNumber == 10){
                        return dark_tower_hints_open;
                    }
                    else if(this.puzzleNumber == 11){
                        return sacred_signs_hints_open;
                    }
        },
        hintIdentifier(){
                    if(this.puzzleNumber == 1){
                       return style_secrets_hints[this.activeIndex2];
                    }
                    else if(this.puzzleNumber == 2){
                        return scout_salute_hints[this.activeIndex2];
                    }
                    else if(this.puzzleNumber == 4){
                        return forest_pool_hints[this.activeIndex2];
                    }
                    else if(this.puzzleNumber == 5){
                        return wardrobe_wisdome_hints[this.activeIndex2];
                    }
                    else if(this.puzzleNumber == 7){
                        return glass_fragment_hints[this.activeIndex2];
                    }
                    else if(this.puzzleNumber == 8){
                        return history_horsement_hints[this.activeIndex2];
                    }
                    else if(this.puzzleNumber == 10){
                        return dark_tower_hints[this.activeIndex2];
                    }
                    else if(this.puzzleNumber == 11){
                        return sacred_signs_hints[this.activeIndex2];
                    }
        },
        closeModal(){
            // console.log('test');
            this.$emit('closeModal');
        },
        helpTriggered(){
            this.$emit('helpTriggered');
        },
        hintClicked(){
            this.$swal({
                        title:'ゲームマスターを呼びますか？<br/>Are you sure you want to call a gamemaster?',
                        // icon:'warning',
                        html:'<button type="button" role="button" class="swalBtn">Test</button>',
                        icon:'question',
                        onBeforeOpen: () => {
                            const swalBtn = document.querySelector('swalBtn');

                            swalBtn.addEventListener('click', () => {
                                alert('test');
                            });
                        }
                    }).then((result) =>{
                       if (result.isConfirmed) {
                      
                       }

                    });
        },
        revealClicked(){
            
            console.log('revealed hints:'+ this.unlockedHints);
            this.unlockedHints.push(this.activeIndex2);
            this.closed_hints[this.activeIndex2] = this.hintIdentifier();
            this.isRevealed = false;
            axios.post('api/game/store_reveal_log',{
                                        game_event_id: codeResponse.id,
                                        team_number: teamSetup.playerTeam,
                                        puzzle_number: this.puzzleNumber,
                                        player_number: teamSetup.playerName,
                                        unlocked_hints: this.unlockedHints
                                    }).then(response => {
                                          if(response.data){
                                            //   console.log('unlocked_hints_list:'+ response.data['unlocked_hints']);
                                            //   this.unlockedHints = response.data['unlocked_hints'];
                                          }
                                    }).catch(error => {
                                            // alert('something went wrong');
                                    });
        },
        openClicked(){
            // this.showUnlockBtn = false;
            // this.isRevealed = true;
            // let temp_open = this.open_hints;
            // this.closed_hints = temp_open;

            this.$swal({
                        title:`Are you sure you want to open hints? It will add 3 minutes on your final time tally.`,
                        // icon:'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: "Yes"
                    }).then((result) =>{
                       if (result.isConfirmed) {

                           
                              this.visible = false;
                                               this.isOpen = true;
                                               this.isOpenTemp = true;
                              this.closed_hints = this.openIdentifier();
                              this.imgs = this.closed_hints;
                              this.index = this.activeIndex2;
                            //   console.log(this.closed_hints+'hays');

                                if(Array.isArray(this.imgs)){
                        
                                    if(this.imgs.length==1){
                                        this.nextDisabled = true;
                                        this.prevDisabled = true;
                                    }
                                    if(this.imgs.length>1){
                                        this.nextDisabled = false;
                                        if(this.activeIndex2 != 0){
                                            this.prevDisabled = false;
                                        }
                                    }
                                }
                                else{
                                    this.nextDisabled = true;
                                        this.prevDisabled = true;
                                }
                                
                                if(this.activeIndex2 == (this.imgs.length - 1)){
                                    this.nextDisabled = true;
                                }

                                
                              this.visible = true;

                        axios.post('api/game/store_hint_log',{
                                        game_event_id: codeResponse.id,
                                        team_number: teamSetup.playerTeam,
                                        puzzle_number: this.puzzleNumber
                                    }).then(response => {
                                          if(response.data){
                                            //   console.log('unlocked_hints_list:'+ response.data['unlocked_hints']);
                                            //   this.unlockedHints = response.data['unlocked_hints'];
                                          }
                                    }).catch(error => {
                                            // alert('something went wrong');
                                    });
                      
                        // this.closed_hints.push(this.open_hints);
                        // this.unlockedHints.push(this.activeIndex2);
                      
                       }

                    });

            



            // alert(this.activeIndex2);
            // console.log(this.computer_hints);
            // console.log('unlocked puzzles'+ this.unlockedHints);
            // this.imgs = computer_hints_blurred;
            //         this.index = this.activeIndex2;
            //         this.visible = true;

            // console.log('computer hint blur new value'+ computer_hints_blurred[this.activeIndex2])
        },
        previousAnswerClicked(){
                this.$swal({
                                                            title:`Feature and assets under development.`,
                                                        }).then((result) =>{      
                                                        });
        }
        ,boardClicked(val, languageval){
            if(val == 3 || val == 6 || val == 9 || val == 12){
                  this.$swal({
                                                            title:`No hints available at the moment.`,
                                                        }).then((result) =>{      
                                                        });
                // break;
            }else{
            if(val != 99){

                if(this.unlockedHints.indexOf(this.activeIndex2) === -1 && this.activeIndex2!=0 ){
                    this.isRevealed = true;
                }
                else{
                    this.isRevealed = false;
                }
            }
            else if(val >=81){
                    this.isRevealed = false;
            }
            // let val = this.puzzleNumber;
                this.activeLanguage = languageval
                    // console.log(val);
                if(this.activeLanguage != 1){
                    if(val == 99){
                        this.isOpen = true;
                        this.imgs = miro_help;
                        this.selectedImage = val;
                        this.showLanguageButton = true;
                    }
                    else{
                        if(this.isOpenTemp == true && this.isOpen == true){
                            this.isOpen = true;
                        }
                        else{
                            this.isOpen = false;
                        }
                        this.imgs = this.closed_hints;
                        this.selectedImage = val;
                    }

                }
                else{
                    if(val == 99){
                        this.isOpen = true;
                        this.imgs = miro_help_jp;
                        this.selectedImage = val;
                        this.showLanguageButton = true;
                    }
                    else if(val == 81){
                          this.$swal({
                                     title:`No available previous answers.`,
                                                        }).then((result) =>{      
                                                        });
                    }
                    else if(val ==82){
                        this.isOpen = true;
                        this.isRevealed = false;
                        this.imgs = ['/images/1_explanation_talc.png'];
                        this.selectedImage = val;
                    }
                    else if(val ==83){
                        this.isOpen = true;
                        this.isRevealed = false;
                        this.imgs = ['/images/1_explanation_talc.png','/images/1_explanation_jade.png'];
                        this.selectedImage = val;
                    }
                    else if(val ==84){
                            this.$swal({
                                     title:`No available previous answers.`,
                                                        }).then((result) =>{      
                                                        });
                    }
                    else if(val ==85){
                        this.isOpen = true;
                        this.isRevealed = false;
                        this.imgs = ['/images/2_explanation_amenouzume.png'];
                        this.selectedImage = val;
                    }
                    else if(val ==86){
                        this.isOpen = true;
                        this.isRevealed = false;
                        this.imgs = ['/images/2_explanation_amenouzume.png', '/images/2_explanation_susanoo.png'];
                        this.selectedImage = val;
                    }
                    else if(val ==87){
                            this.$swal({
                                     title:`No available previous answers.`,
                                                        }).then((result) =>{      
                                                        });
                    }
                    else if(val ==88){
                        this.isOpen = true;
                        this.isRevealed = false;
                        this.imgs = ['/images/3_explanation_benevolence.png'];
                        this.selectedImage = val;
                    }
                    else if(val ==89){
                        this.isOpen = true;
                        this.isRevealed = false;
                        this.imgs = ['/images/3_explanation_benevolence.png', '/images/3_explanation_wisdom.png'];
                        this.selectedImage = val;
                    }
                    else if(val ==90){
                        this.$swal({
                                     title:`No available previous answers.`,
                                                        }).then((result) =>{      
                                                        });
                    }
                    else if(val ==91){
                        this.isOpen = true;
                        this.isRevealed = false;
                        this.imgs = ['/images/4_explanation_yamato.png'];
                        this.selectedImage = val;
                    }
                    else if(val ==92){
                        this.isOpen = true;
                        this.isRevealed = false;
                        this.imgs = ['/images/4_explanation_yamato.png', '/images/4_explanation_sodaiyo.png'];
                        this.selectedImage = val;
                    }
                    else{
                        if(this.isOpenTemp == true && this.isOpen == true){
                            this.isOpen = true;
                        }
                        else{
                            this.isOpen = false;
                        }
                        this.imgs = this.closed_hints;
                        this.selectedImage = val;
                    }


                }
                

                    if(Array.isArray(this.imgs)){
                        
                        if(this.imgs.length==1){
                            this.nextDisabled = true;
                            this.prevDisabled = true;
                        }
                        if(this.imgs.length>1){
                            this.nextDisabled = false;
                            if(this.activeIndex2 != 0){
                                this.prevDisabled = false;
                            }
                        }
                    }
                    else{
                         this.nextDisabled = true;
                            this.prevDisabled = true;
                    }
                    
                    if(this.activeIndex2 == (this.imgs.length - 1)){
                        this.nextDisabled = true;
                    }
                    
                    this.index = this.activeIndex2;
                        if(val!= 81 && val != 84 && val != 87 && val != 90){
                            this.visible = true;
                        }
                    }
            },
            handleHide() {
                this.showLanguageButton= false;
                this.visible = false
            },
            onNext(oldIndex, newIndex){
                this.activeIndex2 = newIndex
                this.prevDisabled = false;
                if(newIndex == (this.imgs.length-1)){
                    this.nextDisabled = true;
                }

                if(this.unlockedHints.indexOf(newIndex) === -1 && this.selectedImage <= 81){
                    this.isRevealed = true;
                }
                else{
                    this.isRevealed = false;
                    
                    this.closed_hints[newIndex] = this.hintIdentifier();
            // this.isRevealed = false;
                }
            },
            onPrev(oldIndex, newIndex){
                this.activeIndex2 = newIndex
                if(newIndex == 0){
                    this.prevDisabled = true;
                    if(this.imgs.length>1){
                        this.nextDisabled = false;
                    }
                }
                else{
                    if(newIndex != (this.imgs.length-1)){
                        this.nextDisabled = false;
                    }
                }

                if((this.unlockedHints.indexOf(newIndex) === -1 && newIndex!=0 ) && this.selectedImage <= 81){
                    this.isRevealed = true;
                }
                else{
                    this.isRevealed = false;
                    this.closed_hints[newIndex] = this.hintIdentifier();
                }
            }
    }

}
</script>

<style scoped>
.help_modal{
    color: white;
    position: fixed;
    height: 450px;
    width: 310px;
    border-radius: 20px;
    z-index: 100;
    box-shadow: 0 10px 10px 0 #222;
}

.help_modal.yokohama{
    background: #a7c8c8;
}

.help_modal.karuizawa{
    background: #c797bb;
}

.help_modal.sendai{
    background: #b39594;
}

.help_modal.asakusa{
    background: #af9e82;
}

.help_modal.shadow{
    
  -webkit-filter: drop-shadow(5px 5px 5px #222);
  filter: drop-shadow(5px 5px 5px #222);
}

.help_modal_mantle{
    position: absolute;
    height: 430px;
    width: 290px;
    border-radius: 20px;
    left: 10px;
    top: 10px;
    z-index: 101;
}

.help_modal_mantle.yokohama{
    background: #7aa0a4;
}

.help_modal_mantle.karuizawa{
    background: #8b4879;
}


.help_modal_mantle.sendai{
    background: #7e5c60;
}


.help_modal_mantle.asakusa{
    background: #8c7d6c;
}


.help_modal_core{
    position: absolute;
    display: flex;
    flex-direction: column;
    flex-wrap: wrap;
    height: 410px;
    width: 270px;
    border-radius: 20px;
    left: 10px;
    top: 10px;
    z-index: 102;
}

.help_modal_core.yokohama{
        background-image: url('../assets/bg_yokohama.png') !important;
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
}

.help_modal_core.karuizawa{
        background-image: url('../assets/bg_karuizawa.png') !important;
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
}

.help_modal_core.sendai{
        background-image: url('../assets/bg_sendai.png') !important;
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
}

.help_modal_core.asakusa{
        background-image: url('../assets/bg_asakusa.png') !important;
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
}



/* .help_connector{
    position: absolute;
    left: 268px;
    top: 385px;
    z-index: 99;
    border-left: 30px solid transparent;
    border-right: 27px solid transparent;
    border-top: 100px solid #F6D74D;
    transform: skewX(30deg);
} */

.help_modal_title{
    display: flex;
    flex-direction: column;
    align-content: center;
    justify-content: center;
    text-align: center;
    font-size: 1.2em;
    font-family: 'Covered By Your Grace', cursive;
    font-weight: 700;
    letter-spacing: 2px;
    margin-top: 13px;
    padding-left: 5px;
    padding-right: 5px;
    flex-grow: 1;
    z-index: 103;
}

.help_modal_option{
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    gap: 8px;
    z-index: 104;
    flex-grow: 1;
}

.help_button{
    cursor: pointer;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-content: center;
    width: 240px;
    color: white;
    height: 60px;
    border-radius: 20px;
    text-align: center;
    font-size: 1.2em;
    letter-spacing: 2px;
    z-index: 105;
    align-items: center;
    border-style: none;
}

.help_button.yokohama{
    background: #7aa0a4;
}

.help_button.karuizawa{
    background: #8b4879;
}


.help_button.sendai{
    background: #7e5c60;
}


.help_button.asakusa{
    background: #8c7d6c;
}

.help_english{
    
    font-family: kon-tiki-aloha-jf, sans-serif;
    font-weight: 400;
    font-style: normal;
}

.help_jap{
font-family: ab-kotatsu,sans-serif;
font-weight: 400;
font-style: normal;
}

.close_btn{
    cursor:pointer;
    position: absolute;
    display: flex;
    justify-content: center;
    align-content: center;
    align-items: center;
    height: 30px;
    width: 30px;
    left: 275px;
    top: 5px;
    border-radius: 50%;
    background-color: #3f3e3d;
    z-index: 106;
}

.close_btn_img{
    height: 18px;
    width: 18px;
    z-index: 107;
}

  .language_buttons_help{
        cursor: pointer;
        display: flex;
        position: fixed;
        overflow: hidden;
        left: 50%;
        transform: translate(-50%);
        bottom: 46px;
        flex-wrap: wrap;
        z-index: 9999999999;
        padding: 0;
        gap: 10px;
    }

      .float3_help{
        max-height: 40px;
        max-width: 40px;
        width:auto;
        height:auto;
        object-fit: cover;
        border-radius:50px;
        text-align:center;
        display: none;
        margin-right: 2px;
    }

    .appear{
        display: block;
    }

    
.v-tour__target--highlighted {
  box-shadow: 0 0 0 99999px rgba(0,0,0,.4);
}


    .lightbox_next{
        position:absolute;
        right: 100px;
        top: 50%;
        font-size: 2vw;
        font-weight: bold;
        border-style: solid;
        border-radius: 5px;
        /* border-color: black; */
        justify-content: center;
        align-content: center;
    }

    .lightbox_close{
        position:absolute;
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

    .lightbox_next > img{
        vertical-align: middle;
    }

    .lightbox_prev{
        
        position:absolute;
        left: 100px;
        top: 50%;
        font-size: 2vw;
        font-weight: bold;
        border-style: solid;
        border-radius: 5px;
        /* border-color: black; */
        justify-content: center;
        align-content: center;

    }

    .lightbox_prev > img{
        vertical-align: middle;
    }

    .lightbox_prev:active{
        background: grey;
    }

    .lightbox_next:active{
        background: grey;
    }

    .lightbox_close:active{
        background: grey;
    }

    .unlocker{
        position: fixed;
        top: 61%;
        left: 50%;
        transform: translate(-50%, 0);
        z-index: 99999;
        display: flex;
        align-items: center;
        align-content: center;
        justify-content: center;
    }

    .unlock_btn{
        cursor: pointer;
        background-color:rgba(0, 0, 0, 0.473);opacity:0.8;
        color: white;
        font-size: 3vw;
        padding-left: 10px;
        padding-right: 10px;
        border-radius: 5px;
        font-weight: bold;
    }

    .vel-img{

  filter: blur(8px) !important;
  -webkit-filter: blur(8px) !important;
    }


.v-tour__target--highlighted {
  box-shadow: 0 0 0 99999px rgba(0,0,0,.4);
}

</style>