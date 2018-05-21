<template>
  <div class="wrapper-box">
    <section class="box left-box">
      <header>导航</header>
      <ZlTree :data="nav" @node-click="onNodeClick"></ZlTree>
    </section>
    <section class="box main-box">
      <header>
        <span>{{currentNode.label}}</span>
        <div class="right-btn">
          <button type="text" @click="add"><i class="iconfont icon-add"></i></button>
          <button type="text" @click="submit"><i class="iconfont icon-right"></i></button>
        </div>
      </header>
      <div>
        <WireDevicePosition v-if="currentNode.name=='WIRE_MONITOR_POSITION'"></WireDevicePosition>
        <CameraPosition v-else-if="currentNode.name=='CAMERA_LOCATION'"></CameraPosition>
        <ZlTable :fields="fields" :data="data"  @edit-row="editRow" @del-row="delRow" v-else>
        </ZlTable>
      </div>
        <section class="right-pad-box" :class="{'right-pad-box-show': flg_showRightBox}">
          <header>
            <span>编辑</span>
          </header>          
        </section>
    </section>
  </div>
</template>
<script>
import ZlTree from '../components/ZlTree'
import ZlTable from '../components/ZlTable'
import WireDevicePosition from '../components/config/WireDevicePosition'
import CameraPosition from '../components/config/CameraPosition'
import { NAV_CONFIG_TREE, FIELDS } from '@/shared/constant'
import { MONITOR_TYPES, MONITOR_PARAMS } from '../json/json_base_info'
import { TUNNELS, WIRES, SECTIONS, MONITOR_DEVICES, MONITOR_CAMERAS } from '../json/json_device_info'

export default {
  components: {
    ZlTree,
    ZlTable,
    WireDevicePosition,
    CameraPosition
  },
  data() {
    return {
      nav: NAV_CONFIG_TREE,
      testItems: [],
      flg_showRightBox: false,
      MONITOR_TYPES: MONITOR_TYPES,
      MONITOR_PARAMS: MONITOR_PARAMS,
      TUNNELS: TUNNELS,
      WIRES: WIRES,
      SECTIONS: SECTIONS,
      MONITOR_DEVICES: MONITOR_DEVICES,
      MONITOR_CAMERAS: MONITOR_CAMERAS,
      FIELDS: FIELDS,
      currentNode: {},
      currentRow: null
    }
  },
  mounted() {
    this.currentNode = NAV_CONFIG_TREE[0].children[0]
  },
  computed: {
    fields() {
      return this.currentNode.name ? this['FIELDS'][this.currentNode.name + "_FIELDS"] : []
    },
    data() {
      return this.currentNode.name ? this[this.currentNode.name] : []
    }
  },
  methods: {
    onNodeClick(node) {
      this.currentNode = node
    },
    cellFormatter(row, column, cellValue) {
      if (Array.isArray(cellValue)) {
        return cellValue.map(item => item.name_cn).join('/')
      } else {
        return cellValue
      }
    },
    editRow(row) {
      this.flg_showRightBox = true
      this.currentRow = row
    },
    delRow(row) {
      remove(this.testItems, row)
    },
    add() {

    },
    submit() {

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
}

.main-box {
  position: absolute;
  left: 252px;
  right: 0;
  overflow: hidden
}

.main-box>div {
  background-color: #D0DEE9;
  position: absolute;
  top: 38px;
  bottom: 2px;
  left: 2px;
  right: 2px;
  border-radius: 2px;
  /*padding: 20px;*/
}

.main-box>header,
.left-box>header {
  padding-left: 5px;
  border-bottom: 1px solid #3F6AA1;
}

</style>
