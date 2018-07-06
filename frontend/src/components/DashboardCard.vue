<template>
  <article>
    <header>
      {{title}}
    </header>
    <section>
      <slot></slot>
    </section>
  </article>
</template>
<script>
export default {
  props: {
    title: String
  }
};

</script>
<style scoped>
article {
  position: relative;
}

article>header {
  font-size: 18px;
  background: url(../assets/title.png) center center / 100% 100% no-repeat;
  width: 322px;
  height: 86px;
  /* color: rgb(255, 238, 138); */
  line-height: 86px;
  text-align: center;
}

article>section {
  /* border-image-source: url(../assets/section.png); */
  background: url(../assets/section.png) center center / 100% 100% no-repeat;
  /* border-image-slice: 32 37 fill; */
  /* border-width: 32px 37px; */
  padding: 1px;
  height: calc(100% - 80px);
  overflow-y: auto;
}

</style>
