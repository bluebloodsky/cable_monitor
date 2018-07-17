<template>
  <div class="wrapper-box">
    <aside>
      <header>导航</header>
      <zl-tree :data="nav" @node-click="onNodeClick" :currentNode="currentNode"></zl-tree>
    </aside>
    <section class="box tab-box">
      <header>
        <ul>
          <li v-for="(tab,index) in tabs" :key="index">
            <a :class="{selected : index == currentPage}" @click="currentPage=index"><span>{{tab}}</span></a>
          </li>
        </ul>
      </header>
      <section>
        <state-evaluation v-if="currentPage == 0"></state-evaluation>
        <state-data v-else></state-data>
      </section>
    </section>
  </div>
</template>
<script>
import ZlTree from "../components/ZlTree";
import StateEvaluation from "../components/support/StateEvaluation"
import StateData from "../components/support/StateData"

import { mapGetters } from 'vuex'
export default {
  components: {
    ZlTree,
    StateEvaluation,
    StateData
  },
  data() {
    return {
      tabs: ["状态评价", "状态数据"],
      currentPage: 0,
      currentNode: {}
    }
  },
  computed: {
    ...mapGetters({
      tunnels: 'tunnels',
      wires: 'wires',
      sections: "sections",
      monitor_types: "monitorTypes",
      monitor_params: "monitorParams",
    }),
    nav() {
      let ret = []
      this.tunnels.map(tunnel => {
        let node = {
          name: tunnel.name,
          type: "tunnel",
          label: tunnel.name_cn,
          children: []
        };

        ret.push(node);

        this.wires.map((wire, index) => {
          let subNode = {
            name: wire.name,
            label: wire.name_cn,
            type: wire.type
          }
          if (index == 0) {
            subNode.defaultSelected = true;
          }
          node.children.push(subNode);
        });
      })
      return ret
    }
  },
  mounted() {

  },
  methods: {
    onNodeClick(node) {
      this.currentNode = node;
    },
    onChooseItem(node) {
      this.currentNode = node;
    }
  }
}

</script>
<style scoped>
aside,
.box {
  height: 100%;
  background-color: #0b3567;
  border: 1px solid #3f6aa1;
  border-radius: 5px;
}

aside>header,
.box>header {
  height: 36px;
  font-size: 16px;
  line-height: 36px;
  overflow: hidden;
  position: relative;
}

aside {
  position: absolute;
  left: 0;
  bottom: 0;
  width: 250px;
  margin-right: 2px;
  overflow-y: auto;
}

aside>header {
  padding-left: 5px;
  border-bottom: 1px solid #3f6aa1;
}

.tab-box {
  position: absolute;
  left: auto;
  right: 2px;
  width: calc(100% - 254px);
}

.tab-box>header {
  margin-left: 5px;
}

.tab-box>header li {
  float: left;
}

.tab-box>header a {
  position: relative;
  height: 0;
  display: inline-block;
  padding: 0 30px;
  border-bottom: 36px solid #75a7c4;
  border-left: 18px solid transparent;
  border-right: 18px solid transparent;
  margin-left: -18px;
}

.tab-box>header a:before {
  position: absolute;
  content: "";
  right: -18px;
  top: 0;
  border-bottom: 36px solid #ccc;
  border-right: 18px solid transparent;
  z-index: 2;
}

.tab-box>header a:after {
  position: absolute;
  content: "";
  right: -17px;
  top: 1px;
  border-bottom: 35px solid #75a7c4;
  border-right: 17px solid transparent;
  z-index: 2;
}

.tab-box>header a:hover,
.tab-box>header a.selected {
  border-bottom: 36px solid #cfdee9;
  color: #3c3c3c;
  z-index: 3;
}

.tab-box>header a:hover::after,
.tab-box>header a.selected::after {
  position: absolute;
  content: " ";
  right: -17px;
  top: 1px;
  border-bottom: 35px solid #cfdee9;
  border-right: 17px solid transparent;
  z-index: 3;
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
  background-color: #cedde8;
  padding-top: 20px;
}

</style>
