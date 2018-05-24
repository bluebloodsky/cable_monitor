<template>
  <section>
    <header>
      <span>缺陷与隐患</span>
    </header>
    <div>
      <ul>
        <li>
          <span>发现缺陷</span>
          <span>严重</span>
          <span>危急</span>
        </li>
        <li>
          <span><strong>8</strong>条</span>
          <span><strong>1</strong>条</span>
          <span><strong>2</strong>条</span>
        </li>
      </ul>
    </div>
  </section>
</template>
<script>
export default {
  data() {
    return {
     
    }
  }
}

</script>
<style scoped>
header {
  height: 36px;
  font-size: 16px;
  line-height: 36px;
  padding-left: 15px;
  /*background-color: #1E364E;*/
  /*border: 1px solid #406985;*/
  margin-bottom: 10px;
}


header:before {
  content: '';
  position: absolute;
  top: -1px;
  left: -1px;
  bottom: auto;
  border-top: 18px solid #406985;
  border-right: 18px solid transparent;
}

header:after {
  content: '';
  position: absolute;
  top: -1px;
  left: -1px;
  bottom: auto;
  border-top: 16px solid #132D48;
  border-right: 16px solid transparent;
}

section>div {
  height: calc(100% - 60px);
  overflow-y: auto;
}

ul{
  margin-left: 50px;
  width: calc(100% - 100px);
  border-left: 1px solid #729FB6;
  border-right: 1px solid #729FB6;
}
li{
  height: 30px;
  display: flex;
  justify-content: space-around;
  align-items: center;
}

li span{
  width: 25%;
}
li:not(:first-child) span{
  color: #4C89A8;
}
strong{
  color: #C8E3EE;
  font-size: 18px;
  margin-right: 3px;
  font-weight: normal;
}
</style>
