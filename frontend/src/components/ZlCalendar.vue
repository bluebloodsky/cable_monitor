<template>
  <div class="zl-calendar">
    <div class="zl-calendar-header">
      <div>
        <button type="text" @click="goPrevYear">
          <i class="iconfont icon-angle-double-left"></i>
        </button>
        <button type="text" @click="goPrevMonth">
          <i class="iconfont icon-return"></i>
        </button>
      </div>
      <span>{{title}}</span>
      <div>
        <button type="text" @click="goNextMonth">
          <i class="iconfont icon-enter"></i>
        </button>
        <button type="text" @click="goNextYear">
          <i class="iconfont icon-angle-double-right"></i>
        </button>
      </div>
    </div>
    <div class="zl-calendar-body">
      <div class="weeks">
        <span class="week" v-for="week in weekNames">{{week}}</span>
      </div>
      <div class="dates">
        <div class="week-row" v-for="week in currentDates">
          <a class="week-num">{{week.num}}</a>
          <a class="day-cell" v-for="day in week.days" :class="{ 'today':day.isToday , 
          'choose-day':day.isChooseDay,'weekend': day.weekDay == 0 || day.weekDay == 6, 'not-cur-month': day.isLastMonth || day.isNextMonth}" @click="selectDate(day)">{{day.num}}</a>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
const DateUtil = {
  getMonthStartDate(date) {
    return new Date(date.getFullYear(), date.getMonth(), 1)
  },
  getMonthEndDate(date) {
    let dt = new Date(date.getFullYear(), date.getMonth() + 1, 1)
    dt.setDate(dt.getDate() - 1)
    return dt
  },
  getLastMonthEndDate(date) {
    let dt = new Date(date.getFullYear(), date.getMonth(), 1)
    dt.setDate(dt.getDate() - 1)
    return dt
  },
  getNextMonthStartDate(date) {
    let dt = new Date(date.getFullYear(), date.getMonth() + 1, 1)
    dt.setDate(dt.getDate())
    return dt
  },
  getYearStartDate(date) {
    return new Date(date.getFullYear(), 0, 1)
  }
}

export default {
  props: {
    value: {
      type: Date
    },
    weekNames: {
      type: Array,
      default: function() {
        return ['周日', '周一', '周二', '周三', '周四', '周五', '周六']
      }
    },
    titleFormat: {
      type: String,
      default: 'yyyy年MM月'
    },
    valueFormat: {
      type: String,
      default: 'yyyy-MM-dd'
    }
  },
  data() {
    return {
      currentDate: null
    }
  },
  computed: {
    title() {
      return this.currentDate.format(this.titleFormat)
    },
    currentDates() {
      let today = new Date()
      let [ty, tm, td] = [today.getFullYear(), today.getMonth(), today.getDate()]
      let chooseDay = new Date(this.value)
      let [cy, cm, cd] = [chooseDay.getFullYear(), chooseDay.getMonth(), chooseDay.getDate()]

      let dates = []
      let yearStartDate = DateUtil.getYearStartDate(this.currentDate)
      let startDate = DateUtil.getMonthStartDate(this.currentDate)
      let endDate = DateUtil.getMonthEndDate(this.currentDate)
      let yearStartWeek = yearStartDate.getDay() //当年第一天星期几
      let weekDay = startDate.getDay() //本月第一天星期几
      let weekNum = Math.floor(((startDate.getTime() - yearStartDate.getTime()) / 86400000 + yearStartWeek) / 7) + 1
      let [y, m, start, end] = [startDate.getFullYear(), startDate.getMonth(), 1, endDate.getDate()]

      //补充上一个月日期
      if (weekDay != 0) {
        dates.push({
          num: weekNum++,
          days: []
        })
        let lastMonthEndDate = DateUtil.getLastMonthEndDate(this.currentDate)
        let [ly, lm, ld] = [lastMonthEndDate.getFullYear(), lastMonthEndDate.getMonth(), lastMonthEndDate.getDate()]
        for (let i = 0; i < weekDay; i++) {
          dates[0].days.unshift({
            num: ld,
            isLastMonth: true,
            weekDay: (weekDay + 6 - i) % 7,
            isToday: ld == td && lm == tm && ly == ty,
            isChooseDay: ld == cd && lm == cm && ly == cy,
          })
          ld--
        }
      }

      //填充当前月日期
      while (start < end + 1) {
        if (weekDay == 0) {
          dates.push({
            num: weekNum++,
            days: []
          })
        }
        dates[dates.length - 1].days.push({
          num: start,
          weekDay: weekDay,
          isToday: start == td && m == tm && y == ty,
          isChooseDay: start == cd && m == cm && y == cy,
        })
        start++
        weekDay = (weekDay + 1) % 7
      }

      // 补充下一个月的日期
      let NextMonthStartDate = DateUtil.getNextMonthStartDate(this.currentDate)
      let [ny, nm, nd] = [NextMonthStartDate.getFullYear(), NextMonthStartDate.getMonth(), 1]

      let nextDiff = (7 - weekDay) % 7
      if (dates.length != 6) {
        nextDiff += 7
      }
      for (let i = 0; i < nextDiff; i++) {
        if (weekDay == 0) {
          dates.push({
            num: weekNum++,
            days: []
          })
        }
        dates[dates.length - 1].days.push({
          num: nd,
          isNextMonth: true,
          weekDay: weekDay,
          isToday: nd == td && nm == tm && ny == ty,
          isChooseDay: nd == cd && nm == cm && ny == cy,
        })
        nd++
        weekDay = (weekDay + 1) % 7
      }
      return dates
    }
  },
  created() {
    this.currentDate = this.value ? new Date(this.value) : new Date()
  },
  watch: {
    value: function(newVal) {
      this.currentDate = new Date(newVal)
    }
  },
  methods: {
    goPrevYear() {
      let newDate = new Date(this.currentDate.getFullYear() - 1, this.currentDate.getMonth(), 1)
      this.$set(this, "currentDate", newDate)
    },
    goPrevMonth() {
      let newDate = new Date(this.currentDate.getFullYear(), this.currentDate.getMonth() - 1, 1)
      this.$set(this, "currentDate", newDate)
    },
    goNextYear() {
      let newDate = new Date(this.currentDate.getFullYear() + 1, this.currentDate.getMonth(), 1)
      this.$set(this, "currentDate", newDate)
    },
    goNextMonth() {
      let newDate = new Date(this.currentDate.getFullYear(), this.currentDate.getMonth() + 1, 1)
      this.$set(this, "currentDate", newDate)
    },
    selectDate(day) {
      let monthDiff = day.isLastMonth ? -1 : day.isNextMonth ? 1 : 0
      let newDate = new Date(this.currentDate.getFullYear(), this.currentDate.getMonth() + monthDiff, day.num)
      this.$emit("input", newDate.format(this.valueFormat))
    }
  }
}

</script>
<style scoped>
.zl-calendar {
  width: 238px;
  border: 1px solid #8BA0BC;
  background-color: #CFDDEE;
  font-size: 14px;
  height: auto;
  padding-bottom: 10px;
  color: #000;
}

.zl-calendar-header {
  height: 34px;
  display: flex;
  justify-content: space-around;
  align-items: center;
}

.zl-calendar-header button {
  height: 16px;
  width: 16px;
  background-color: transparent;
  border: none;
  outline: none;
  color: #8BA0BC;
  font-size: 10px;
}

.zl-calendar-body {}

.weeks {
  height: 40px;
  border-bottom: 1px solid #B7C8DD;
  margin: 0 20px 0 36px;
  display: flex;
  justify-content: space-between;
  line-height: 18px;
  text-align: center;
}

.week-row {
  height: 20px;
  margin-right: 20px;
  display: flex;
  justify-content: space-between;
  text-align: center;
  font-size: 12px;
}

.day-cell {
  width: 20px;
  height: 20px;
  line-height: 20px;
}

.week-num {
  width: 20px;
  height: 20px;
  line-height: 20px;
  margin: 0 6px;
  color: gray;
  pointer-events: none;
  cursor: default;
}

.weekend {
  color: #C2004A;
}

.week-num,
.not-cur-month {
  color: #999;
}

.today {
  border: 1px solid #C95C05;
}

.choose-day {
  background-color: #A9C1DE;
  color: #000;
}

</style>
