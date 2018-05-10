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
        <TunnelState :data="currentNode.children" v-if="!currentNode.isLeaf">
        </TunnelState>
        <template v-else>
          <WireState v-show="currentPage == 0"></WireState>
        </template>
      </section>
    </section>
  </div>
</template>
<script>
import ZlTree from '../components/ZlTree'
import TunnelState from '../components/monitordata/TunnelState'
import WireState from '../components/monitordata/WireState'
import { MONITOR_TYPES, MONITOR_PARAMS } from '../json/json_base_info'
import { TUNNELS, WIRES, SECTIONS, MONITOR_DEVICE } from '../json/json_device_info'
import { DATA_THREE } from '../json/json_monitor_data'
export default {
  components: { ZlTree, TunnelState, WireState },
  data() {
    return {
      tabs: ['状态总览', '实时数据', '历史数据'],
      currentPage: 0,
      nav: [],
      level: 0,
      showTabs: [],
      currentNode: []
    }
  },
  computed: {},
  mounted() {
    /*计算左侧树形结构*/
    TUNNELS.map(tunnel => {
      let node = {
        name: tunnel.name,
        type: 'tunnel',
        label: tunnel.name_cn,
        children: []
      }
      this.nav.push(node)
      MONITOR_TYPES.map(monitor_type => {
        let subnode = {
          icon: monitor_type.icon,
          name: monitor_type.name,
          label: monitor_type.name_cn,
          type: 'monitorType',
          children: []
        }
        node.children.push(subnode)
        if (monitor_type.type == 'WIRE_MONITOR') {
          WIRES.map(wire => {
            subnode.children.push({
              name: wire.name,
              label: wire.name_cn,
              type: 'wire'
            })
          })
        } else {
          SECTIONS.map(section => {
            subnode.children.push({
              name: section.name,
              label: section.name_cn,
              type: 'section'
            })
          })
        }
      })
    })
    this.showTabs = [this.tabs[0]]
    this.currentNode = this.nav[0]
  },
  methods: {
    onNodeClick(item) {
      this.currentPage = 0
      this.currentNode = item
      if (item.isLeaf) {
        this.showTabs = this.tabs
      } else {
        this.showTabs = [this.tabs[0]]
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
