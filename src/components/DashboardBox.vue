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
  props: { title: String }
};
</script>
<style scoped>
article {
  position: relative;
  border-style: solid;
  border-width: 32px 37px;
  border-image-source: url(../assets/border.png);
  border-image-slice: 32 37 fill;
  margin-top:30px;
}
header {
  position: absolute;
  font-size: 24px;
  left: 0;
  width: 100%;
  top: -48px;
  text-align: center;
  color: rgb(255, 238, 138);
}

section{
    width: 100%;
    height: 100%;
}
</style>
