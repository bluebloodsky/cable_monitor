<template>
    <section>
        <input type="text" v-model="name">
        <div>{{name|capitalize}}</div>
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
div{
    width: 300px;
    height: 300px;
    background: linear-gradient(lightblue , darkblue);
}
</style>
