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
        <el-table border :data="testItems">
          <el-table-column align="center" :prop="item.name" :label="item.caption" v-for="item in fields" :formatter="cellFormatter">
          </el-table-column>
          <el-table-column label="操作" align="center">
            <template scope="scope">
              <button @click="editRow(scope.row)" type="text"><i class="iconfont icon-edit"></i>
              </button>
              <button @click="delRow(scope.row)" type="text"><i class="iconfont icon-trash"></i>
              </button>
            </template>
          </el-table-column>
        </el-table>
      </div>
    </section>
  </div>
</template>
<script>
import ZlTree from '../components/ZlTree'
export default {
  components: {
    ZlTree
  },
  data() {
    return {
      nav: [{
        label: '基本信息配置',
        children: [{
          label: '监测类型配置'
        }, {
          label: '监测参数配置'
        }]
      }, {
        label: '设备信息配置',
        children: [{
          label: '电缆通道信息配置'
        }, {
          label: '电缆线路信息配置'
        }, {
          label: '监测设备配置'
        }]
      }],
      testItems: [],
      flg_showRightBox: false,
      fields: []
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
    add(){

    },
    submit(){
      
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
}

.main-box>header,
.left-box>header {
  padding-left: 5px;
  border-bottom: 1px solid #3F6AA1;
}

</style>
