<template>
    <section class="wrapper" ref="wrapper">
        <img :src="node.img_url">
        <div :style="{ left:device.positionX + '%' , top:device.positionY  + '%'}" v-for="device in showDevices">
            <button type="text"> 
                  <i class="iconfont good icon-circle"></i>
                </button>
            <ul>
                <li v-for="param in device.params">
                    <span>{{param.name_cn}}：</span>
                    <span><strong>{{param.val}}</strong>{{param.unit}}</span>
                </li>
            </ul>
        </div>
    </section>
</template>

<script>
    export default {
        props: {
            node: Object
        },
        data() {
            return {
                currentData: [],
                monitor_devices: [],
                monitor_params: []
            };
        },
        mounted() {
            this.axios.get('monitor-devices').then(response => {
                this.monitor_devices = response.data
                return this.axios.get('monitor-params')
            }).then(response => {
                this.monitor_params = response.data
                this.queryData()
            })
        },
        methods: {
            queryData() {
                this.axios.get('/test/real-data').then(response => {
                    this.currentData = []
                    response.data.map(adata => {
                        let old_data = this.currentData.find(item => item.device_name == adata.device_name)
                        if (old_data) {
                            old_data[adata['param_name']] = adata['val']
                        } else {
                            this.currentData.push({
                                device_name: adata['device_name'],
                                data_time: adata['data_time'],
                                [adata['param_name']]: adata['val']
                            })
                        }
                    })
                })
            }
        },
        computed: {
            showDevices() {
                let l_devices = [];
                /*过滤所有该监测类型参数*/
                let l_params = this.monitor_params.filter(
                    param => param.monitor_type == this.node.monitor_type_name
                );
                /*获取每个该线路该监测类型设备实时数据*/
                this.monitor_devices.map(device => {
                    if (
                        this.node.name == (device.wire ? device.wire : device.section) &&
                        device.monitor_type == this.node.monitor_type_name
                    ) {
                        l_devices.push(device);
                        let device_data = this.currentData.find(
                            adata => adata.device_name == device.name
                        );
                        device.params = [];
                        l_params.map(param => {
                            let l_param = {
                                name: param.name,
                                name_cn: param.name_cn,
                                unit: param.unit,
                                show_type: param.show_type,
                                val: "/ "
                            };
                            if (device_data && device_data[param.name]) {
                                if (param['data_type'] == 'BOOL') {
                                    l_param.val = device_data[param.name] == 1 ? '开' : '关'
                                } else {
                                    l_param.val = device_data[param.name]
                                }
                            }
                            device.params.push(l_param);
                        });
                    }
                });
                return l_devices
            }
        }
    };
</script>

<style scoped>
    .wrapper {
        position: absolute;
        left: 10px;
        right: 10px;
        top: 10px;
        bottom: 10px;
    }
    
    img {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
    }
    
    .wrapper img {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
    }
    
    .iconfont {
        font-size: 20px;
    }
    
    .wrapper>div {
        position: absolute;
        line-height: 20px;
    }
    
    .wrapper ul {
        position: absolute;
        top: 0;
        left: 30px;
        width: 300px;
    }
    
    .wrapper>div:hover ul {
        left: 30px;
    }
</style>