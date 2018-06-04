<template>
  <section>
    <ZlTreeNode :data="nodeData" :currentNode="currentNode" @node-click="onNodeClick"></ZlTreeNode>
  </section>
</template>
<script>
import ZlTreeNode from './ZlTreeNode'
export default {
  name: 'ZlTree',
  components: { ZlTreeNode },
  data() {
    return {     
      nodeData: []
    }
  },
  props: {
    data: Array,
    currentNode: Object,
    defaultExpandAll: Boolean,
    parentClickable: Boolean
  },
  mounted() {
    this.nodeData = this.data.map(child => this.calData(child, 0))
  },
  methods: {
    calData(node, level) {
      let result = {
        level: level
      }
      for (let key in node) {
        if (key != 'children') {
          result[key] = node[key]
        }
      }
      if (node.children) {
        result['expand'] = this.parentClickable || level == 0 || this.defaultExpandAll ? true : false
        result['children'] = node.children.map(child => this.calData(child, level + 1))
        result['clickable'] = this.parentClickable ? true : false
      } else {
        result['isLeaf'] = true
      }
      if (node.defaultSelected) {
        this.$emit("node-click" , result)
      }
      return result
    },
    onNodeClick(item) {
      this.$emit('node-click', item)
    }
  },
  watch: {
    data(newVal) {
      this.nodeData = newVal.map(child => this.calData(child, 0))
    }
  }
}

</script>
<style scoped>


</style>
