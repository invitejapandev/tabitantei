<template>
  <transition name="modal-fade">
    <div class="modal-backdrop">
      <div class="modal"
        role="dialog"
        aria-labelledby="modalTitle"
        aria-describedby="modalDescription"
      >
        <header
          class="modal-header"
          id="modalTitle"
        >
          <slot name="header">
            This is the default tile!
            <button  @click="displayTestArray()">Pen</button>
          </slot>
          <button
            type="button"
            class="btn-close"
            @click="close"
            aria-label="Close modal"
          >
            x
          </button>
        </header>

        <section
          class="modal-body"
          id="modalDescription"
        >
          <slot name="body">
            <div ref="bodyref" style="height: 500px; width: 500px;">
              <canvas ref="can" width="1000" height="1000"></canvas>
               <img :src="imgUrl" ref="canv_img" />
            </div>
          </slot>
        </section>

        <footer class="modal-footer">
          <slot name="footer">
            This is the default footer!
          </slot>
          <button
            type="button"
            class="btn-green"
            @click="close"
            aria-label="Close modal"
          >
            Close me!
          </button>
        </footer>
      </div>
    </div>
  </transition>
</template>

<script>
// let test_array;
let  canvas=null;
  export default {
    name: 'Modal',
  data() {
    return {
      pos: {x: 159, y: 136, length: 3},
      test_array: [],
      drawingMode: false,
      imgUrl: './images/color_semaphore.png'
    };
  },
  mounted(){
    const ref = this.$refs.can;
    canvas = new fabric.Canvas(ref);
    const rect = new fabric.Rect({
      fill: 'red',
      width: 20,
      height: 20
    });

    var circle = new fabric.Circle({
  radius: 20, fill: 'green', left: 100, top: 100
});
    canvas.add(rect);
    canvas.add(circle);
    var vm = this;
    // canvas.isDrawingMode = true;
    var imgElement = this.$refs.canv_img;
    var imgInstance = new fabric.Image.fromURL(this.imgUrl, function(oImg){
        canvas.add(oImg)
        // opacity: 0.85
      });

    // canvas.add(imgInstance);

  },
    methods: {
    
      close() {
        this.$emit('close');
      },
      displayTestArray(){
        this.drawingMode = !this.drawingMode;
        canvas.isDrawingMode = this.drawingMode;
      },
    },
  };
</script>


<style scoped>

  .modal-backdrop {
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background-color: rgba(0, 0, 0, 0.3);
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .modal {
    background: #FFFFFF;
      height: 80%;
      width: 80%;
    box-shadow: 2px 2px 20px 1px;
    overflow-x: auto;
    display: flex;
    flex-direction: column;
  }

  .modal-header,
  .modal-footer {
    padding: 15px;
    display: flex;
  }

  .modal-header {
    position: relative;
    border-bottom: 1px solid #eeeeee;
    color: #4AAE9B;
    justify-content: space-between;
  }

  .modal-footer {
    border-top: 1px solid #eeeeee;
    flex-direction: column;
  }

  .modal-body {
    position: relative;
    padding: 20px 10px;
  }

  .btn-close {
    position: absolute;
    top: 0;
    right: 0;
    border: none;
    font-size: 20px;
    padding: 10px;
    cursor: pointer;
    font-weight: bold;
    color: #4AAE9B;
    background: transparent;
  }

  .btn-green {
    color: white;
    background: #4AAE9B;
    border: 1px solid #4AAE9B;
    border-radius: 2px;
  }

  .modal-fade-enter,
  .modal-fade-leave-to {
    opacity: 0;
  }

  .modal-fade-enter-active,
  .modal-fade-leave-active {
    transition: opacity .5s ease;
  }
</style>