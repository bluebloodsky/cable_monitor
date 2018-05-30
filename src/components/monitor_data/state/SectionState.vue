<template>
<section class="wrapper" ref="wrapper">
   <img :src="node.img_url" alt="无" ref="source">
  <canvas ref="canvas">
  </canvas>
</section>
</template>
<script>
export default {
  props: {
    node: Object
  },
  mounted() {
    let canvas = this.$refs["canvas"]
    let [width,height] = [this.$refs['wrapper'].clientWidth , this.$refs['wrapper'].clientHeight]
    canvas.width= width
    canvas.height= height
    let ctx = canvas.getContext("2d")
    ctx.fillRect(0,0,100,100)
    // let source = this.$refs["source"]
    // ctx.drawImage(source, 0, 0 ,width,height)

  }
};
</script>
<style scoped>
.wrapper {
  position: absolute;
  left: 10px;
  right: 10px;
  top: 10px;
  bottom: 10px;
}

img{
  position: absolute;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
}
</style>
