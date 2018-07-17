<template>
  <section>
    <div v-for="item in items" class="content-box" @click="chooseItem(item)">
      <div>
        <i class="iconfont" :class="item.icon"></i>
        <span>{{item.label}}</span>
      </div>
      <ul>
        <li><i class="iconfont icon-circle" :class="item['SupDevRun'] == 1 ? 'bad':'good'"></i>运行状态</li>
        <li><i class="iconfont icon-circle" :class="item['MoDevConf'] == 1 ? 'bad':'good'"></i>通讯状态</li>
      </ul>
    </div>
  </section>
</template>
<script>
import { STATE_DATA } from '@/json/json_monitor_status'
import { copyObject } from '@/shared/util'
export default {
  props: {
    node: Object
  },
  data() {
    return {
      state_data: STATE_DATA
    }
  },
  methods: {
    chooseItem(item) {
      this.$emit('choose-item', item)
    }
  },
  computed: {
    items() {
      let ret = []
      if (this.node && this.node.children) {
        this.node.children.map(child => {
          if (this.node.level == 0) {
            let state = this.state_data.find(astate => astate["name"].trim() == child["name"].trim())
            if (state) {
              child['MoDevConf'] = state['MoDevConf']
              child['SupDevRun'] = state['SupDevRun']
            }
          } else {
            let state = this.state_data.find(astate => astate["name"].trim() == child["name"].trim() && astate["monitor_type_name"] == child["monitor_type_name"])
            if (state) {
              child['MoDevConf'] = state['MoDevConf']
              child['SupDevRun'] = state['SupDevRun']
            }
          }
          ret.push(child)
        })
      }
      return ret
    }
  }
};

</script>
<style scoped>
section {
  padding-left: 20px;
  display: flex;
  justify-content: flex-start;
  flex-wrap: wrap;
  align-content: flex-start;
}

.content-box {
  position: relative;
  font-size: 16px;
  background-color: #38648D;
  margin-bottom: 5px;
  margin-right: 5px;
  width: 280px;
  height: 80px;
  border-radius: 5px;
  display: flex;
  justify-content: space-around;
  cursor: pointer;
}

.content-box>div {
  width: 160px;
  display: flex;
  align-items: center;
  justify-content: flex-start;
}

.content-box>div i {
  font-size: 60px;
}

.content-box>ul {
  width: 100px;
  padding: 10px 0;
}

.content-box li {
  height: 30px;
  line-height: 30px;
}

</style>
