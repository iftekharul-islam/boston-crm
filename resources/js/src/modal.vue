<template>
<transition v-if="openModal" name="fade" appear>
    <div class="open-model">
        <div class="model-box">
            <div class="model-title">
                {{ title }}
                <div class="modal-close" @click="closeModal">
                    &times;
                </div>
            </div>
            <div class="model-body">
                <slot></slot>
            </div>
        </div>
    </div>
</transition>
</template>

<script>
export default {
    props: ['title'],
    data: () => ({
        openModal: false
    }),
    model: {
        prop: 'modalData',
        event: 'change'
    },
    created() {
        this.initModal(this.$attrs.modalData);
    },
    methods: {
        initModal(val) {
            this.openModal = val;
        },
        closeModal() {
            this.openModal = false;
            this.$emit('change', false);
        }
    },
    watch: {
        $attrs: {
            handler(val) {
                this.initModal(val.modalData);
            }, 
            deep: true
        }
    }
}
</script>

<style scoped>
/* modal */
.open-model {
    position: fixed;
    left: 0;
    top: 0;
    z-index: 990;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.2);
    backdrop-filter: blur(6px);
}
.open-model .model-box {
    background: #fff;
    max-width: 700px;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    position: absolute;
    min-width: 700px;
    border-radius: 0.25rem;
    box-shadow: 0 5px 20px rgb(0 0 0 / 5%);
    padding: 20px;
}
.open-model .model-title {
    position: relative;
    font-weight: bold;
    font-size: 16px;
    padding-bottom: 10px;
}
.open-model .modal-close {
    position: absolute;
    right: 0px;
    top: -15px;
    font-size: 30px;
    cursor: pointer;
}
.open-model .model-body{
    max-height: 600px;
    overflow: auto;
    overflow-x: hidden;
    scrollbar-width: thin;
    scrollbar-color: #bbb;
}
.open-model .model-body::-webkit-scrollbar {
    width: 5px;
}
.open-model .model-body::-webkit-scrollbar-thumb {
    background: #bbb;
}
</style>