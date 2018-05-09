<template>
  <div class="wrapper-box">
    <section class="box left-box">
      <header>导航</header>
      <ZlTree :data="nav" @node-click="onNodeClick" parent-clickable></ZlTree>
    </section>
    <section class="box tab-box">
      <header>
        <ul>
          <li v-for="(tab,index) in showTabs">
            <a :class="{selected : index == currentPage}" @click="currentPage=index"><span>{{tab}}</span></a>
          </li>
        </ul>
      </header>
      <section>
        <TunnelState :data="tunnelState" v-if="level == 0">
        </TunnelState>
      </section>
    </section>
  </div>
</template>
<script>
import ZlTree from '../components/ZlTree'
import TunnelState from '../components/monitordata/TunnelState'
import { DATA_THREE } from '../json/json_monitor_data'
export default {
  components: { ZlTree, TunnelState },
  data() {
    return {
      tabs: ['状态总览', '实时数据', '历史数据'],
      currentPage: 0,
      nav: [],
      level: 0,
      showTabs: ['状态总览'],
      tunnelState:[]
    }
  },
  computed: {},
  mounted() {
    this.nav = DATA_THREE
  },
  methods: {
    onNodeClick(item) {
      console.log(item)
      this.level = item.level
      if (item.isLeaf) {
        this.showTabs = this.tabs.filter((tab, index) => index > 0)
      } else {
        this.showTabs = [this.tabs[0]]
      }
      if(this.level == 0){
        this.tunnelState = item.children
      }
    }
  }

}

</script>
<style scoped>
.box {
  height: 100%;
  background-color: #0B3567;
  border: 1px solid #3F6AA1;
  border-radius: 5px;
}

.box>header {
  height: 36px;
  font-size: 16px;
  line-height: 36px;
  overflow: hidden;
  position: relative;
}

.left-box {
  position: absolute;
  left: 0;
  width: 250px;
  margin-right: 2px;
}

.left-box>header {
  padding-left: 5px;
  border-bottom: 1px solid #3F6AA1;
}

.tab-box {
  position: absolute;
  left: auto;
  right: 2px;
  width: calc(100% - 254px);
}

.tab-box>header {
  margin-left: 5px
}

.tab-box>header li {
  float: left;
}

.tab-box>header a {
  position: relative;
  height: 0;
  display: inline-block;
  padding: 0 30px;
  border-bottom: 36px solid #75A7C4;
  border-left: 18px solid transparent;
  border-right: 18px solid transparent;
  margin-left: -18px;
}

.tab-box>header a:hover,
.tab-box>header a.selected {
  border-bottom: 36px solid #CFDEE9;
  color: #3C3C3C;
  z-index: 999;
}


.left-box>section,
.tab-box>section {
  position: absolute;
  top: 36px;
  bottom: 0;
  left: 5px;
  right: 0;
  overflow-y: auto;
}

.tab-box>section {
  background-color: #CEDDE8;
  padding-top: 20px;
}

</style>
