<template>
    <div class="wrapper-box">
        <section class="box left-box">
            <header>导航</header>
            <ZlTree :data="nav" @node-click="onNodeClick"></ZlTree>
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
                    },{
                        label:'监测参数配置'
                    }]
                },{
                    label: '设备信息配置',
                    children: [{
                        label: '电缆通道信息配置'
                    },{
                        label:'电缆线路信息配置'
                    },{
                        label:'监测设备配置'
                    }]
                }]
            }
        }
    }
</script>

<style scoped>
    
</style>
