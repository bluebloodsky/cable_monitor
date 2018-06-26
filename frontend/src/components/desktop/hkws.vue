<template>
  <section>
      <video :id="src" playsInline webkit-playsinline autoplay v-for="src in videoSrcs" @dblclick="fullScreen">
          <source :src="'http://hls.open.ys7.com/openlive/'+ src +'.hd.m3u8'"  type="application/x-mpegURL" />
          <source :src="'rtmp://rtmp.open.ys7.com/openlive/' + src + '.hd'" type="">
      </video>
  </section>
</template>
<script>
export default {
  data() {
    return {
      videoSrcs: [
      '11b9cf280b054e3f86ac88a556969ebf',
      '67902b82419a4b91a5e73aa868613f42',
      'ac07b68b3f064d2da62c1f51ad2c5ee2',
      ]
    }
  },
  mounted() {
      this.videoSrcs.map(src=> new EZUIPlayer(src))
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

video {
  height: calc(33% - 5px);
  width: calc(100% - 5px);
}

video:hover {
  cursor: pointer;
}

video:-webkit-full-screen {
  width: auto;
  height: 100%;
  max-width: 100%;
}

</style>
