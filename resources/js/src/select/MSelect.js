import Select from "./Select.vue";

const MSelect = {
    install(Vue, options = {}) {
        Vue.component('m-select', Select);
    }
}

export default MSelect;