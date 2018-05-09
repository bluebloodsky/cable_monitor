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
      currentNode: null
    }
  },
  props: {
    data: Array,
    defaultExpandAll: Boolean,
    parentClickable: Boolean
  },
  mounted() {

  },
  computed: {
    nodeData() {
      return this.data.map(child => this.calData(child, 0))
    }
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
        result['clickable'] = true
      } else {
        result['isLeaf'] = true
      }
      if (node.defaultSelected) {
        this.currentNode = result
      }
      return result
    },
    onNodeClick(item) {
      this.currentNode = item
      this.$emit('node-click', item)
    }
  }
}

</script>
<style scoped>


</style>
