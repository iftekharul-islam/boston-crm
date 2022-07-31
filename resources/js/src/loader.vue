<template>
   <div class="load" v-if="openLoader">
    <img src="/icons/loader.gif" alt="" :style="height ? 'height:'+ height + 'px' : ''">
   </div>
</template>
<script>
export default {
    model: {
        modelData: "vueLoader",
        event: "change",
    },
    props: ['height'],
    data: () => ({
        openLoader: true
    }),
    created() {
        // this.openLoader = this.$attrs.vueLoader;
    },
    watch: {
        $attrs: {
            handler(val) {
                // this.openLoader = val.vueLoader;
            },
            deep: true
        }
    }
}
</script>

<style scoped>
.load {
    text-align: center;
    width: 100%;
}
.load img {
    height: 100px;
    margin: auto;
}
</style>