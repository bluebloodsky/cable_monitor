<template>
  <ul>
    <li v-for="node in data">
      <a @click="onNodeClick(node)" :class="{selected:node==currentNode}">
        <button type='text' @click.stop="onExpandChage(node)">
          <i class="iconfont" :class="node.children?node.expand?'icon-nodeexpand':'icon-nodecollapse':'icon-document'"></i>
        </button>
        <span>{{node.label}}</span>
      </a>
      <ZlTreeNode :data="node.children" :currentNode="currentNode" @node-click="onNodeClick" v-if="node.children&&node.expand"></ZlTreeNode>
    </li>
  </ul>
</template>
<script>
export default {
  name: 'ZlTreeNode',
  props: {
    data: {
      type: Array,
      default: []
    },
    currentNode: Object
  },
  methods: {
    onNodeClick(node) {
      if (node.children && !node.clickable) {
        node.expand = node.expand ? false : true
      } else {
        this.$emit('node-click', node)
      }
    },
    onExpandChage(node) {
      if (node.children) {
        node.expand = node.expand ? false : true
      }
    }
  }
}

</script>
<style scoped>
i,
span {
  font-size: 16px;
  color: #fff;
}

li ul {
  padding: 0 0 0 15px;
}

a {
  display: block;
  padding: 5px;
}

a:hover,
a.selected {
  background-color: #306C95;
}

</style>
