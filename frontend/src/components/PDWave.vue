<template>
  <section>
    <div ref="container" class="container">
    </div>
    <div class="control">
      <button type="text" @click="play"><i class="iconfont" :class="playFlg? 'icon-suspend' : 'icon-play' "></i></button>
      <input type="range" v-model="period" min="0" :max="pointsLength">
    </div>
  </section>
</template>
<script>
import DrawPRPS from "@/shared/util/draw/drawPRPS";
import DrawPRPD from "@/shared/util/draw/drawPRPD";
export default {
  props: {
    points: Array,
    type: {
      default: "PRPD"
    },
    title: {
      default: "局放图谱"
    }
  },
  data() {
    return {
      chart: null,
      period: 0,
      playFlg: true
    };
  },
  computed:{
    pointsLength(){
      return this.points ? this.points.length :0
    }
  },
  mounted() {
    if (this.type == "PRPS") {
      this.chart = new DrawPRPS(this.$refs["container"]);
    } else {
      this.chart = new DrawPRPD(this.$refs["container"]);
    }
    this.chart.setOption({
      points: this.points,
      title: this.title,
    });
    this.period = 0;
    window.setInterval(() => {
      if (this.playFlg) {
        this.period++;
      }
    }, 200);
    window.addEventListener("resize", () => {
      this.chart.resize();
    });
  },
  methods: {
    play() {
      this.playFlg = !this.playFlg;
      if (this.period >= this.pointsLength) {
        this.period = 0;
      }
    }
  },
  watch: {
    period(newVal) {
      if (this.period == this.pointsLength) {
        this.playFlg = false;
      }
      this.chart.draw(this.period);
    }
  }
};

</script>
<style scoped>
.container {
  height: calc(100% - 30px);
  background-color: whitesmoke;
}

.control {
  height: 30px;
  display: flex;
  align-items: center;
}

.control i {
  font-size: 20px;
  width: 30px;
}

.control input {
  width: calc(100% - 40px);
}

</style>
