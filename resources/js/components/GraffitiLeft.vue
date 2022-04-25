<template>
    <div class="miro_board">
        <!-- <div class="iframeHolder">
            <iframe class="responsive" style="z-index: -1 !important" :src="iframe.src" frameBorder="0" scrolling="no" allowFullScreen></iframe>
        </div> -->
        

         <div class="newcard"  v-if="puzzleNumber == 8">
                            <!-- <img class="cover_image"  v-bind:src="this.imgCover"  v-if="show" /> -->
                            <svg  class="cover_image"   version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 772 843" preserveAspectRatio="xMinYMin meet" >
                    <image style="border-radius: 200px;"  :xlink:href="imgCover" >
                    </image>
                    
                    <a class="clickable_image floor" @click="boardClicked('phone', activeLanguage)">
                        <polygon fill="#fff" opacity="0" points="460,308,487,292,675,365,680,392,517,816,498,827,318,761,305,746,309,721"   />
                    </a>
                    
                </svg>
            
            </div>

            <div class="newcard"  v-if="puzzleNumber == 9">
                            <!-- <img class="cover_image"  v-bind:src="this.imgCover"  v-if="show" /> -->
                            <svg  class="cover_image"   version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 772 843" preserveAspectRatio="xMinYMin meet" >
                    <image style="border-radius: 200px;"  :xlink:href="imgCover" >
                    </image>
                    
                    <a class="clickable_image floor" @click="boardClicked('graffiti', activeLanguage)">
                        <polygon fill="#fff" opacity="0" points="1,1,771,1,770,841,1,843"   />
                    </a>
                    
                </svg>
            
            </div>

        <div class="newcard"  v-if="puzzleNumber == 2">
                            <!-- <img class="cover_image"  v-bind:src="this.imgCover"  v-if="show" /> -->
                            <svg  class="cover_image"   version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 772 843" preserveAspectRatio="xMinYMin meet" >
                    <image style="border-radius: 200px;"  :xlink:href="imgCover" >
                    </image>
                    
                    <a class="clickable_image floor" @click="boardClicked('manual', activeLanguage)">
                        <polygon fill="#fff" opacity="0" points="454,336,18,428,98,842,147,840,679,718"   />
                    </a>
                    
                </svg>
            
            </div>


        <!-- <transition name="fade"> -->
            <div class="newcard"  v-if="puzzleNumber == 1">
                            <!-- <img class="cover_image"  v-bind:src="this.imgCover"  v-if="show" /> -->
                            <svg  class="cover_image"   version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 772 843" preserveAspectRatio="xMinYMin meet" >
                    <image style="border-radius: 200px;"  :xlink:href="imgCover" >
                    </image>

                    <a class="clickable_image floor" @click="boardClicked('floor', activeLanguage)">
                        <polygon fill="#fff" opacity="0" points="71,92,530,94,534,363,68,365"   />
                    </a>
                    
                    <a class="clickable_image burito" @click="boardClicked('burito', activeLanguage)">
                        <polygon fill="#fff" opacity="0" points="69,423,220,368,221,555,63,557"   />
                    </a>

                    <a class="clickable_image smiley" @click="boardClicked('smiley', activeLanguage)">
                        <polygon fill="#fff" opacity="0" points="127,558,117,741,264,741,264,545,223,547,221,557"   />
                    </a>

                    <a class="clickable_image stapler" @click="boardClicked('stapler', activeLanguage)">
                        <polygon fill="#fff"  opacity="0" points="290,392,442,368,483,566,387,580,317,580"   />
                    </a>

                    <a class="clickable_image music" @click="boardClicked('music', activeLanguage)">
                        <polygon fill="#fff"  opacity="0" points="302,580,506,578,508,740,289,738"   />
                    </a>
                    
                </svg>
            
            </div>
         <!-- </transition> -->
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
    <button :disabled="prevDisabled"  @click="prev" class="lightbox_prev"><img  class="close_btn_img" src="../assets/prev_page.png"/>Prev</button>
  </template>

  <template v-slot:next-btn="{ next }">
    <button :disabled="nextDisabled" class="lightbox_next" @click="next">Next<img  class="close_btn_img" src="../assets/next_page.png"/></button>
  </template>

  <template v-slot:close-btn="{ close }">
    <button @click="close" class="lightbox_close">Close</button>
  </template>
    
    </vue-easy-lightbox>
    
    <div class="language_buttons">
         
        </div>
    </div>
</template>

<script>

import VueEasyLightbox from 'vue-easy-lightbox';
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

const g_images = [g_1, g_2, g_3, g_4];


    export default{
        name: 'Miro',
        components:{
            VueEasyLightbox
        },
        props:{
            imgCover: String,
            puzzleNumber: Number
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
                activeIndex: 0,
                activeLanguage: 1,
                prevDisabled: true,
                nextDisabled: true
            }
        },
        methods:{
            boardClicked(val, languageval){
                this.activeLanguage = languageval
                if(this.activeLanguage != 1){
                    if(val == 'floor'){
                        this.imgs = floor1_image;
                        this.selectedImage = val;
                    }
                    else if(val == 'burito'){
                        this.imgs = floor2_image;
                        this.selectedImage = val;
                    }
                    else if(val == 'smiley'){
                        this.imgs = floor3_image;
                        this.selectedImage = val;
                    }
                    else if(val == 'stapler'){
                        this.imgs = floor4_image;
                        this.selectedImage = val;
                    }
                    else if(val == 'music'){
                        this.imgs = floor5_image;
                        this.selectedImage = val;
                    }
                    else if(val == 'manual'){
                        this.imgs = en_manual;
                        this.selectedImage = val;
                    }
                    else if(val == 'phone'){
                        this.imgs = cafe_img;
                        this.selectedImage = val;
                    }
                    else if(val == 'graffiti'){
                        this.imgs = g_images;
                        this.selectedImage = val;
                    }

                }
                else{
                    if(val == 'floor'){
                    this.imgs = floor1_image_jp;
                    this.selectedImage = val;
                    }
                    else if(val == 'burito'){
                        this.imgs = floor2_image_jp;
                        this.selectedImage = val;
                    }
                    else if(val == 'smiley'){
                        this.imgs = floor3_image_jp;
                        this.selectedImage = val;
                    }
                    else if(val == 'stapler'){
                        this.imgs = floor4_image_jp;
                        this.selectedImage = val;
                    }
                    else if(val == 'music'){
                        this.imgs = floor5_image_jp;
                        this.selectedImage = val;
                    }
                    else if(val =='manual'){
                        this.imgs = jp_manual;
                        this.selectedImage = val;
                    }
                    else if(val =='phone'){
                        this.imgs = cafe_img_j;
                        this.selectedImage = val;
                    } 
                    else if(val == 'graffiti'){
                        this.imgs = g_images;
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
                            if(this.activeIndex != 0){
                                this.prevDisabled = false;
                            }
                        }
                    }
                    else{
                         this.nextDisabled = true;
                            this.prevDisabled = true;
                    }
                    
                    if(this.activeIndex == (this.imgs.length - 1)){
                        this.nextDisabled = true;
                    }

                    
                    this.index = this.activeIndex;
                    this.visible = true;
                    this.showLanguageButton = true;


            },
            handleHide() {
                this.showLanguageButton= false;
                this.visible = false
            },
            onNext(oldIndex, newIndex){
                this.activeIndex = newIndex
                this.prevDisabled = false;
                if(newIndex == (this.imgs.length-1)){
                    this.nextDisabled = true;
                }
            },
            onPrev(oldIndex, newIndex){
                this.activeIndex = newIndex
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
            }
        }
    }
</script>

<style scoped>

    .clickable_image{
        cursor: pointer;
    }

   .miro_board{
        display: flex;
        flex-wrap: wrap;
        position: relative;
        border-radius: 11px;
        justify-content: flex-end;
    }

    .iframeHolder{
        position: absolute;
        padding:0; 
        margin: 0;
        z-index: 98;
        cursor: pointer;
        /* background-color: pink; */
        width: 100%;
        height: 100%;

    }

    .responsive{
        border-radius: 10px;
        width: 100%;
        height: 100%;
    }
    
     .cover_image{
        position: absolute;
        border-radius: 10px;
        object-fit: cover;
    }



    .newcard{
        /* position: relative; */
        /* background-color: pink; */
        display: flex;
        position: relative;
        width: 96%;
        height: 100%;
        justify-content: center;
    }

   
    .fade-enter-active, .fade-leave-active {
        transition: opacity 5s;
    }

    .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
        opacity: 0;
    }

    .language_buttons{
        cursor: pointer;
        display: flex;
        position: fixed;
        overflow: hidden;
        left: 50%;
        transform: translate(-50%);
        bottom: 46px;
        flex-wrap: wrap;
        z-index: 99999999;
        padding: 0;
        gap: 10px;
    }



    
      .float3{
        max-height: 40px;
        max-width: 40px;
        width:auto;
        height:auto;
        object-fit: cover;
        border-radius:50px;
        text-align:center;
        visibility: hidden;
        margin-right: 2px;
    }


    .appear{
        visibility: visible;
    }




/* 
   @media only screen and (max-width: 1024px) {

        .cover_image{
            height: 80vh;
        }
        
        .iframeHolder{
            height: 80vh;
        }
    }

     @media only screen and (max-width: 800px) {

        .miro_board{
            justify-content: center;
        }

        .cover_image{
            height: 40vh;
            width: 50vh;
        }
        
        .iframeHolder{
            height: 40vh;
            width: 50vh;
        }

    } */




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
 
</style>