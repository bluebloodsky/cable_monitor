<template>
  <div class="wrapper-box">
    <section class="box left-box">
      <header>导航</header>
      <ZlTree :data="nav" @node-click="onNodeClick" :currentNode="currentNode" parent-clickable></ZlTree>
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
        <CameraState :node="currentNode" v-if="currentNode.type == 'CAMR_MONITOR'">
        </CameraState>
        <TunnelState :node="currentNode" v-else-if="!currentNode.isLeaf" @choose-item="onChooseItem">
        </TunnelState>
        <template v-else-if="currentNode.type == 'GIL'">
          <GILState :node="currentNode" v-show="currentPage == 0"></GILState>
          <TxtRealData :node="currentNode" v-show="currentPage == 1"></TxtRealData>
        </template>
        <template v-else-if="currentNode.type == 'WIRE'">
          <WireState v-show="currentPage == 0"></WireState>
          <GaugeRealData :node="currentNode" v-show="currentPage == 1">
          </GaugeRealData>
        </template>
        <template v-else-if="currentNode.type == 'SECTION'">
          <SectionState :node="currentNode" v-show="currentPage == 0"></SectionState>
          <GaugeRealData :node="currentNode" v-show="currentPage == 1"></GaugeRealData>
        </template>
      </section>
    </section>
  </div>
</template>
<script>
import ZlTree from '../components/ZlTree'
import TunnelState from '../components/monitor_data/state/TunnelState'
import GILState from '../components/monitor_data/state/GILState'
import WireState from '../components/monitor_data/state/WireState'
import SectionState from '../components/monitor_data/state/SectionState'
import CameraState from '../components/monitor_data/state/CameraState'
import TxtRealData from '../components/monitor_data/real_data/TxtRealData'
import GaugeRealData from '../components/monitor_data/real_data/GaugeRealData'
import { MONITOR_TYPES, MONITOR_PARAMS } from '../json/json_base_info'
import { TUNNELS, WIRES, SECTIONS, MONITOR_DEVICES, MONITOR_CAMERAS } from '../json/json_device_info'

export default {
  components: { ZlTree, TunnelState, GILState, WireState, SectionState, CameraState, TxtRealData, GaugeRealData },
  data() {
    return {
      tabs: ['状态总览', '实时数据', '历史数据'],
      currentPage: 0,
      nav: [],
      currentNode: {}
    }
  },
  computed: {
    showTabs() {
      if (this.currentNode.isLeaf) {
        return this.tabs
      } else {
        return [this.tabs[0]]
      }
    }
  },
  mounted() {
    /*计算左侧树形结构*/
    TUNNELS.map((tunnel, index) => {
      let node = {
        name: tunnel.name,
        type: 'tunnel',
        label: tunnel.name_cn,
        children: []
      }
      if (index == 0) {
        node.defaultSelected = true
      }
      this.nav.push(node)
      MONITOR_TYPES.map(monitor_type => {
        let subnode = {
          icon: monitor_type.icon,
          name: monitor_type.name,
          label: monitor_type.name_cn,
          type: monitor_type.type,
          children: []
        }
        if (monitor_type.type == 'WIRE_MONITOR') {
          WIRES.map(wire => {
            if (wire.type == "WIRE") {
              subnode.children.push({
                name: wire.name,
                label: wire.name_cn,
                type: wire.type,
                monitor_type_name: monitor_type.name
              })
            }
          })
        } else if (monitor_type.type == 'GIL_MONITOR') {
          WIRES.map(wire => {
            if (wire.type == "GIL") {
              subnode.children.push({
                name: wire.name,
                label: wire.name_cn,
                type: wire.type,
                monitor_type_name: monitor_type.name
              })
            }
          })
        } else if (monitor_type.type == 'SECTION_MONITOR') {
          SECTIONS.map(section => {
            subnode.children.push({
              name: section.name,
              label: section.name_cn,
              type: 'SECTION',
              monitor_type_name: monitor_type.name,
              img_url: section.img_url
            })
          })
        } else if (monitor_type.type == 'CAMR_MONITOR') {
          MONITOR_CAMERAS.map(camera => {
            subnode.children.push({
              name: camera.name,
              label: camera.name_cn,
              type: 'CAMERA',
              location: camera.location
            })
          })
        }
        if (subnode.children && subnode.children.length > 0) {
          node.children.push(subnode)
        }
      })
    })
  },
  methods: {
    onNodeClick(node) {
      if (!node.isLeaf) {
        this.currentPage = 0
      }
      this.currentNode = node
    },
    onChooseItem(node) {
      this.currentNode = node
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

.tab-box>header a:before{
  position: absolute;
  content: '';
  right: -18px;
  top: 0;
  border-bottom: 36px solid #ccc;
  border-right: 18px solid transparent;
  z-index: 99;
}

.tab-box>header a:after{
  position: absolute;
  content: '';
  right: -17px;
  top: 1px;
  border-bottom: 35px solid #75A7C4;
  border-right: 17px solid transparent;
  z-index: 99;
}

.tab-box>header a:hover,
.tab-box>header a.selected {
  border-bottom: 36px solid #CFDEE9;
  color: #3C3C3C;
  z-index: 999;
}

.tab-box>header a:hover::after,
.tab-box>header a.selected::after{
  position: absolute;
  content: ' ';
  right: -17px;
  top: 1px;
  border-bottom: 35px solid #CFDEE9;
  border-right: 17px solid transparent;
  z-index: 99;
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
