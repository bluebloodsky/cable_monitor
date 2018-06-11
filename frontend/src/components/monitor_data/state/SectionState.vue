<template>
<section class="wrapper" ref="wrapper">
   <img :src="node.img_url">
   <Fan class="fan" style="left:3%" :speed="2"></Fan>
   <Fan class="fan" style="left:6%" :speed="1"></Fan>
   <Fan class="fan" style="left:15%" :speed="5"></Fan>
   <Fan class="fan" style="left:18%" :speed="3"></Fan>
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
  top: calc(32% - 41px);
  z-index: 99;
}
</style>
