<template>
    <div class="combo-tree" @click.stop>
        <input placeholder="请选择" :value="currentNode.label" @focus="focus" ref="input"  readonly>
        <button type="text" @click="chooseData"><i class="iconfont icon-unfold"></i></button>
        <ZlTree class="tree" :class="{'show-tree':showTree}" :data="treeData" @node-click="onNodeClick" :currentNode="currentNode">
        </ZlTree>
    </div>
</template>

<script>
import ZlTree from "./ZlTree";
export default {
  components: {
    ZlTree
  },
  props: {
    treeData: Array,
    value: Object
  },
  data() {
    return {
      currentNode: {},
      showTree: false
    };
  },
  mounted() {
    this.currentNode = this.value ? this.value : {};
    window.addEventListener("click", () => (this.showTree = false));
  },
  methods: {
    onNodeClick(node) {
      this.showTree = false;
      this.currentNode = node;
      this.$emit("input", node);
    },
    chooseData() {
      this.showTree = !this.showTree;
      this.$nextTick(() => this.$refs.input.focus());
    },
    focus() {
      this.showTree = true;
    }
  }
};
</script>

<style scoped>
.combo-tree {
  position: relative;
  margin: 0;
  padding: 0;
  height: 22px;
  width: 180px;
  line-height: 18px;
  display: inline-block;
  white-space: normal;
}

.combo-tree input {
  width: 100%;
  height: 100%;
  margin: 0;
  padding: 0 20px 0 0;
  box-sizing: border-box;
  text-align: center;
  border: none;
  border: 1px solid #8ba0bc;
}

.combo-tree button {
  position: absolute;
  right: 1px;
  top: 1px;
  width: 20px;
  height: 20px;
  border: none;
  border-left: 1px solid #8ba0bc;
  border-radius: 0;
}

.tree {
  position: absolute;
  top: 21px;
  width: 100%;
  left: -9999px;
}

.show-tree {
  left: 0;
  z-index: 9999;
  background-color: #0b3567;
}
</style>
