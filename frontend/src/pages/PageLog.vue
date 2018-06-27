<template>
    <article class="wrapper-box">
        <header>
            <div>
                <span>开始时间:</span>
                <ZlDatePicker v-model="startDate"></ZlDatePicker>
            </div>
            <div>
                <span>结束时间:</span>
                <ZlDatePicker v-model="endDate"></ZlDatePicker>
            </div>
            <button type="text"><i class="iconfont icon-search"></i></button>
            <button type="text"><i class="iconfont icon-send"></i></button>
        </header>
        <section>
            <div>
                <table>
                    <thead>
                        <tr>
                            <th v-for="field in fields">{{field.caption}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(row,row_id) in data">
                            <td v-for="field in fields">
                                <span>{{row[field.name]}}</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <footer>
                <div>
                    <button type="text">
                                    <i class="iconfont icon-angle-double-left"></i>
                                  </button>
                    <button type="text">
                                    <i class="iconfont icon-return"></i>
                                  </button>
                    <input value="1">
                    <button type="text">
                                    <i class="iconfont icon-enter"></i>
                                  </button>
                    <button type="text">
                                    <i class="iconfont icon-angle-double-right"></i>
                                  </button>
                    <span> 共1页 0条</span>
                </div>
            </footer>
        </section>
    </article>
</template>

<script>
    import ZlDatePicker from "../components/ZlDatePicker";
    import {
        LOG_RECORDS
    } from "../json/json_event";
    export default {
        components: {
            ZlDatePicker,
        },
        data() {
            return {
                startDate: (new Date).addMonths(-1),
                endDate: new Date(),
                fields: [{
                    name: "time",
                    caption: "时间"
                }, {
                    name: "type",
                    caption: "类型"
                }, {
                    name: "content",
                    caption: "日志内容"
                }],
                data: LOG_RECORDS
            };
        },
    };
</script>

<style scoped>
    header {
        height: 40px;
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 10px;
        background-color: #132d48;
    }
    
    header>div {
        margin-right: 20px;
    }
    
    header select {
        width: 200px;
    }
    
    section {
        position: relative;
        height: calc(100% - 60px);
        background-color: #ccc;
        background-color: #132d48;
        border: solid 1px #406985;
        overflow: hidden;
    }
    
    footer {
        position: absolute;
        bottom: 0;
        left: 0;
        top: auto;
        right: 0;
        height: 30px;
        line-height: 30px;
        background-color: #133551;
        padding-left: 10px;
    }
    
    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }
    
    td,
    th,
    table {
        border: 1px solid #2b4f69;
        font-weight: normal;
    }
    
    thead {
        background-color: #06192a;
        line-height: 40px;
    }
    
    tbody {
        line-height: 40px;
        text-align: center;
    }
    
    td:last-child {
        text-align: left;
        padding-left: 20px;
    }
    
    footer div {
        margin-right: 50px;
        float: left;
    }
    
    footer input {
        width: 16px;
        text-align: center;
    }
    
    .iconfont {
        color: #fff;
        font-size: 20px;
    }
    
    .wave {
        position: absolute;
        top: 50px;
        left: 50px;
        height: 300px;
        width: 400px;
        background-color: #fff;
    }
</style>
