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
