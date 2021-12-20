<template>
  <canvas
    class="memo_pad"
    ref="canvas"
    @mousemove="draw"
    @mousedown="setPosition"
    @mouseenter="setPosition"
    @resize="resize"
    id="canvas"
  ></canvas>
</template>
<script>
export default {
  name: "App",
  data() {
    return {
      pos: {x: 159, y: 136, length: 3},
    };
  },
  mounted(){

      const { canvas } = this.$refs;
      const ctx = canvas.getContext("2d");
      ctx.canvas.width = window.innerWidth;
      ctx.canvas.height = window.innerHeight;
      ctx.beginPath();
      ctx.lineWidth = 2;
      ctx.lineCap = "round";
      ctx.strokeStyle = "green";
      ctx.moveTo(291, 109);
      ctx.lineTo(50, 47);
      ctx.stroke();
  },
  methods: {
    setPosition(e) {
      this.pos.x = e.clientX;
      this.pos.y = e.clientY;
    },
    resize() {
      const { canvas } = this.$refs;
      const ctx = canvas.getContext("2d");
      ctx.canvas.width = window.innerWidth;
      ctx.canvas.height = window.innerHeight;
    },
    draw(e) {
      if (e.buttons !== 1) {
        return;
      }
      const { canvas } = this.$refs;
      const ctx = canvas.getContext("2d");
      const { pos } = this;
      ctx.beginPath();
      ctx.lineWidth = 3;
      ctx.lineCap = "round";
      ctx.strokeStyle = "black";
      ctx.moveTo(pos.x, pos.y);
      this.setPosition(e);
      ctx.lineTo(pos.x, pos.y);
      ctx.stroke();
    },
  },
};
</script>

<style scoped>
#canvas {
    overflow: hidden;
    display: block;
  border: 1px solid black;
}

body{
    margin: 0;
}
</style>