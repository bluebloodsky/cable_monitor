<template>
  <ul>
    <li v-for="item in data" :key="item.id">
      <a @click="onNodeClick(item)" :class="{selected:item==currentNode}">
        <button type='text' @click.stop="onExpandChage(item)">
          <i class="iconfont" :class="item.children?item.expand?'icon-nodeexpand':'icon-nodecollapse':'icon-document'"></i>
        </button>
        <span>{{item.label}}</span>
      </a>
      <ZlTreeNode :data="item.children" :currentNode="currentNode" @node-click="onNodeClick" v-if="item.children&&item.expand"></ZlTreeNode>
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
    onNodeClick(item) {
      if (item.children && !item.clickable) {
        item.expand = item.expand ? false : true
      } else {
        this.$emit('node-click', item)
      }
    },
    onExpandChage(item){
      if (item.children){
        item.expand = item.expand ? false : true
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
