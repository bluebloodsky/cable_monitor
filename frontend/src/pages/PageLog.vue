<template>
    <section>
        <div>{{name|capitalize}}</div>
        <img src="@/assets/fire.png" alt="">
    </section>
</template>

<script>
    export default {
        data() {
            return {
                name: ""
            };
        },
        filters: {
            capitalize(val) {
                if (!val) {
                    return "";
                }
                val = val.toString();
                return val.charAt(0).toUpperCase() + val.slice(1);
            }
        }
    };
</script>

<style scoped>
section{
    background-color: #ccc;
}
div{
    width: 30px;
    height: 262px;
    background: linear-gradient(to top ,#000000 ,#ff7f00,#ffff7f,#fffff2);
    float: left;
    margin: 0 20px;
}
</style>
