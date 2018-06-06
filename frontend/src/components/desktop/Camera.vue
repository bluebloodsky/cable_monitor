<template>
  <section>
    <img :src="imgSrc" @dblclick="fullScreen" v-for="imgSrc in imgSrcs">
  </section>
</template>
<script>
export default {
  data() {
    return {
      imgSrcs: []
    }
  },
  mounted() {
    for (let i = 1; i < 5; i++) {
      this.imgSrcs.push('http://61.83.161.2:10000/mjpeg.cgi?channel=' + i + '&user=guest&password=guest&time=1524039431169')
    }
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
  display: flex;
  justify-content: space-around;
  align-items: center;
  flex-wrap: wrap;
  height: 100%;
}

img {
  height: calc(50% - 5px);
  width: calc(50% - 5px);
}

img:hover {
  cursor: pointer;
}

img:-webkit-full-screen {
  width: auto;
  height: 100%;
  max-width: 100%;
}

</style>
