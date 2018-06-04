<template>
  <div class="zl-date-picker" @click.stop>
    <input placeholder="请选择日期" :value="showValue" @change="changeValue" @focus="focus" ref="input">
    <button type="text" @click="chooseDate"><i class="iconfont icon-unfold"></i></button>
    <ZlCalendar class="calendar" :class="{'show-calendar':showCalendar}" :value="currentDate" @input="receiveDate"></ZlCalendar>
  </div>
</template>
<script>
import ZlCalendar from './ZlCalendar'
export default {
  name: 'ZlDatePicker',
  components: { ZlCalendar },
  props: {
    value: {
      type: String
    },
  },
  data() {
    return {
      currentDate: null,
      showCalendar: false
    }
  },
  mounted() {
    this.currentDate = this.value ? new Date(this.value) : new Date()
    window.addEventListener("click", () => this.showCalendar = false)
  },
  computed: {
    showValue() {
      return this.currentDate ? this.currentDate.format("yyyy-MM-dd") : ''
    }
  },
  methods: {
    chooseDate() {
      this.showCalendar = !this.showCalendar;
      this.$nextTick(() => this.$refs.input.focus())
    },
    receiveDate(val) {
      this.showCalendar = false;
      this.$nextTick(() => this.$refs.input.focus())
      this.currentDate = new Date(val)
      this.$emit('input', val)
    },
    changeValue(e) {
      let newValue = e.target.value
      if (new Date(newValue).getDate() == newValue.substring(newValue.length - 2)) {
        this.currentDate = new Date(newValue)
        this.$emit('input', newValue)
      }
      e.target.value = this.currentDate.format("yyyy-MM-dd")
    },
    focus() {
      this.$refs.input.select()
    }
  }
}

</script>
<style scoped>
.zl-date-picker {
  position: relative;
  margin: 0;
  padding: 0;
  height: 22px;
  width: 130px;
  line-height: 18px;
  display: inline-block;
  white-space: normal;
}

.zl-date-picker input {
  width: 100%;
  height: 100%;
  margin: 0;
  padding: 0 20px 0 0;
  box-sizing: border-box;
  text-align: center;
  border: none;
  border: 1px solid #8BA0BC;
}

.zl-date-picker button {
  position: absolute;
  right: 1px;
  top: 1px;
  width: 20px;
  height: 20px;
  border: none;
  border-left: 1px solid #8BA0BC;
  border-radius: 0;
}

.calendar {
  position: absolute;
  top: 21px;
  left: -9999px;
}

.show-calendar {
  left: 0;
  z-index: 9999;
}

</style>
