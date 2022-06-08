require('./bootstrap');
window.Vue = require('vue').default
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';
<<<<<<< HEAD
=======
import 'vue-select/dist/vue-select.css';
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
>>>>>>> production

import { ValidationProvider } from "vee-validate/dist/vee-validate.full.esm";
import { ValidationObserver } from 'vee-validate';
Vue.component('ValidationProvider', ValidationProvider);
Vue.component('ValidationObserver', ValidationObserver);

import storage from "./store/index";
import * as boston from "./helper/boston";
import "./helper/config";

Vue.use(BootstrapVue)
Vue.use(IconsPlugin)
<<<<<<< HEAD

// import vSelect from 'vue-select';
// Vue.component('v-select', vSelect)
=======
Vue.component('v-select', vSelect)
Vue.use(VueSweetalert2);
>>>>>>> production

import "./src/vue_component";

axios.defaults.baseURL = window.origin;
Vue.config.productionTip = false
Vue.prototype.$boston = boston;

import "./helper/BostonMixin";

const app = new Vue({
    el: '#app',
    store: storage
});