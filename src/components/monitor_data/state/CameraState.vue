<template>
  <section>
    <img :src="child.location" @dblclick="fullScreen" v-for="child in data.children">
  </section>
</template>
<script>
export default {
  props: {
    node: Object
  },
  mounted() {

  },
  methods: {
    fullScreen(e) {
      e.target.webkitRequestFullscreen()
    }
  }
}

</script>
<style scoped>
section {
  display: flex;
  justify-content: space-around;
  align-items: center;
  flex-wrap: wrap;
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
