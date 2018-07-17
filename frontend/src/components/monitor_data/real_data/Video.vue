<template>
  <section>
    <img :src="imgSrc" v-for="imgSrc in imgSrcs">
  </section>
</template>
<script>
export default {
  data() {
    return {
      imgSrcs: ['http://61.83.161.2:10000/mjpeg.cgi?channel3&user=guest&password=guest&time=1524039431169']
    }
  },
  mounted() {
  },
  methods: {
    fullScreen(e) {
      e.target.webkitRequestFullscreen()
    }
  }
};

</script>
<style scoped>
section {
  width: 100%;
  height: 100%;
}

img {
  height: calc(100% - 1px);
  width: calc(100% - 5px);
}

</style>
