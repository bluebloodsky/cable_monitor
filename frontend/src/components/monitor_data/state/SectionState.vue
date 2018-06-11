<template>
<section class="wrapper" ref="wrapper">
   <img :src="node.img_url">
   <Fan class="fan"></Fan>
</section>
</template>
<script>
import Fan from '@/components/fan/Fan'
export default {
  components:{Fan},
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
.fan{
  position: absolute;
  left: 3%;
  top: 27%;
  z-index: 99;
}
</style>
