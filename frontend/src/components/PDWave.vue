<template>
    <section>
        <div ref="container" class="container">
        </div>
        <div class="control">
            <button type="text" @click="play"><i class="iconfont" :class="playFlg? 'icon-suspend' : 'icon-play' "></i></button>
            <input type="range" v-model="period" min="0" :max="points.length">
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
    }
  },
  data() {
    return {
      chart: null,
      period: 0,
      playFlg: true
    };
  },
  mounted() {
    if (this.type == "PRPS") {
      this.chart = new DrawPRPS(this.$refs["container"]);
    } else {
      this.chart = new DrawPRPD(this.$refs["container"]);
    }
    this.chart.setOption({
      points: this.points
    });
    this.period = 0;
    window.setInterval(() => {
      if (this.playFlg) {
        this.period++;
      }
    }, 200);
  },
  methods: {
    play() {
      this.playFlg = !this.playFlg;
      if (this.period >= this.points.length) {
        this.period = 0;
      }
    }
  },
  watch: {
    period(newVal) {
      if (this.period == this.points.length) {
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


