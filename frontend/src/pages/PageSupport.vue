<template>
  <div class="wrapper-box">
    <aside>
      <header>导航</header>
      <ZlTree :data="nav" @node-click="onNodeClick" :currentNode="currentNode"></ZlTree>
    </aside>
    <section class="box tab-box">
      <header>
        <ul>
          <li>
            <a class="selected">
               <span>状态评估</span>
      		</a>
          </li>
        </ul>
      </header>
      <section>
      	
      </section>
    </section>
  </div>
</template>
<script>
import ZlTree from "../components/ZlTree";
export default {
  components: {
    ZlTree
  },
  data() {
    return {
      nav: [],
      currentNode: {}
    }
  },
  mounted() {
    /*计算左侧树形结构*/
    this.axios.get("device-tree").then(response => {
      let tunnels = response.data['tunnels']
      let wires = response.data['wires']
      let monitor_types = response.data['monitor_types']
      let sections = response.data['sections']
      tunnels.map(tunnel => {
        let node = {
          name: tunnel.name,
          type: "tunnel",
          label: tunnel.name_cn,
          children: []
        };

        this.nav.push(node);

        wires.map((wire, index) => {
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
    })
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
