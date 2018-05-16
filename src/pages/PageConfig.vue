<template>
  <div class="wrapper-box">
    <section class="box left-box">
      <header>导航</header>
      <ZlTree :data="nav" @node-click="onNodeClick"></ZlTree>
    </section>
    <section class="box main-box">
      <header>
        <span>列表</span>
        <div class="right-btn">
          <button type="text" @click="add"><i class="iconfont icon-add"></i></button>
          <button type="text" @click="submit"><i class="iconfont icon-right"></i></button>
        </div>
      </header>
      <div>
        <ZlTable>
          <ZlTableColumn v-for="field in fields" :label="field.caption"></ZlTableColumn>
          <ZlTableColumn labe="操作">
            <template scope="scope">
              <button @click="editRow(scope.row)" type="text"><i class="iconfont icon-edit"></i>
              </button>
              <button @click="delRow(scope.row)" type="text"><i class="iconfont icon-trash"></i>
              </button>
            </template>
          </ZlTableColumn>
        </ZlTable>
      </div>
    </section>
  </div>
</template>
<script>
import ZlTree from '../components/ZlTree'
import ZlTable from '../components/ZlTable'
import ZlTableColumn from '../components/ZlTableColumn'
import { NAV_CONFIG_TREE, MONITOR_TYPES_FIELDS } from '@/shared/constant'
export default {
  components: {
    ZlTree,
    ZlTable,
    ZlTableColumn
  },
  data() {
    return {
      nav: NAV_CONFIG_TREE,
      testItems: [],
      flg_showRightBox: false,
      fields: MONITOR_TYPES_FIELDS
    }
  },
  methods: {
    onNodeClick(node) {

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
  right: 0
}

.main-box>div {
  background-color: #D0DEE9;
  position: absolute;
  top: 38px;
  bottom: 2px;
  left: 2px;
  right: 2px;
  border-radius: 2px;
  padding: 20px;
}

.main-box>header,
.left-box>header {
  padding-left: 5px;
  border-bottom: 1px solid #3F6AA1;
}

</style>
