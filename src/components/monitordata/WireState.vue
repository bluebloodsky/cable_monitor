<template>
  <section>
    <div v-for="i in 3" class="state-box">
      <ul>
        <li v-for="i in 6">
          <span>{{i}}号防区</span>
          <a v-for="i in 4" href="#">
            <i class="iconfont icon-circle good"></i>
          </a>
        </li>
      </ul>
    </div>
  </section>
</template>
<script>
export default {
  props: {
    data: Array
  }
}

</script>
<style scoped>
section {
  padding-left: 20px;
  display: flex;
  justify-content: flex-start;
  flex-wrap: wrap;
  align-content: flex-start;
}

.state-box {
  width: 100%;
  height: 30px;
  margin: 10% 5px 0 5px;
  position: relative;
}

.state-box ul {
  width: calc(100% -70px);
  /*background-color: #DAEAF7;*/
  background-color: #3C3C3C;
  height: 3px;
  margin-left: 70px;
  border-radius: 3px;
  /*border: 1px solid #CED4DF;*/
  display: flex;
  justify-content: space-around;
}

.state-box:before {
  position: absolute;
  top: -50%;
  transform: translateY(50%);
  left: 30px;
  color: #3C3C3C;
}

.state-box:nth-child(3n + 1):before {
  content: 'A相';
}

.state-box:nth-child(3n + 2):before {
  content: 'B相';
}

.state-box:nth-child(3n):before {
  content: 'C相';
}

.state-box:nth-child(3n) {
  margin-bottom: 100px;
}





/*
.state-box:nth-child(3n) ul {
  background-color: #C55C60;
}


.state-box:nth-child(3n + 1) ul {
  background-color: #FEE179;
}

.state-box:nth-child(3n +2) ul {
  background-color: #4C9F95;
}
*/

.state-box li {
  float: left;
  position: relative;
  width: 20%;
  height: 100%;
  display: flex;
  justify-content: space-around;
  align-items: center;
}

.state-box li:after {
  content: '';
  border-left: dashed 3px #999;
  height: 100px;
  width: 0;
  position: absolute;
  right: 0;
  bottom: -8px;
  left: auto;
  top: auto;
}

.state-box li span {
  position: absolute;
  top: -50px;
  left: 50%;
  transform: translateX(-50%);
  color: #3C3C3C;
}

</style>
