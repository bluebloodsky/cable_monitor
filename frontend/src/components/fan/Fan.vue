<template>
  <section>
    <img src="./rotator.png" ref="rotator">
  </section>
</template>
<script>
export default {
  props: {
    speed: {
      default: 2
    }
  },
  mounted() {
    this.refs.rotator.style.animation = 'rotate ' + 1 / this.speed + 's linear infinite'
  },
  watch: {
    speed(newVal) {
      this.refs.rotator.style.animation = 'rotate ' + 1 / newVal + 's linear infinite'
    }
  }
};

</script>
<style scoped>
section {
  background: url(./shell.png);
  width: 40px;
  height: 40px;
  z-index: 9;
  position: relative;
}

img {
  position: absolute;
  left: 7px;
  top: 4px;
  animation: rotate 0.5s linear infinite;
}

@keyframes rotate {
  0% {
    transform: rotate(0deg) skew(0deg) scale(1);
    -ms-transform: rotate(0deg) skew(0deg) scale(1);
    /* IE 9 */
    -moz-transform: rotate(0deg) skew(0deg) scale(1);
    /* Firefox */
    -webkit-transform: rotate(0deg) skew(0deg) scale(1);
    /* Safari ºÍ Chrome */
    -o-transform: rotate(0deg) skew(0deg) scale(1);
  }
  100% {
    transform: rotate(-360deg) skew(0deg) scale(1);
    -ms-transform: rotate(-360deg) skew(0deg) scale(1);
    /* IE 9 */
    -moz-transform: rotate(-360deg) skew(0deg) scale(1);
    /* Firefox */
    -webkit-transform: rotate(-360deg) skew(0deg) scale(1);
    /* Safari ºÍ Chrome */
    -o-transform: rotate(-360deg) skew(0deg) scale(1);
  }
}

</style>
