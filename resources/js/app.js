/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default
    // import Pagination from 'vue-pagination-2'
    // import VueSweetalert2 from 'vue-sweetalert2'
import vSelect from 'vue-select';
// import 'sweetalert2/dist/sweetalert2.min.css';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
// import Calendar from 'v-calendar/lib/components/calendar.umd'
// import DatePicker from 'v-calendar/lib/components/date-picker.umd'

import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';
import 'vue-select/dist/vue-select.css';

import { ValidationProvider } from "vee-validate/dist/vee-validate.full.esm";
import { ValidationObserver } from 'vee-validate';
Vue.component('ValidationProvider', ValidationProvider);
Vue.component('ValidationObserver', ValidationObserver);

import storage from "./store/index";
import * as boston from "./helper/boston";
import "./helper/config";

// Vue.use(VueSweetalert2);
Vue.use(BootstrapVue)
Vue.use(IconsPlugin)


Vue.component('v-select', vSelect)

// Vue.component('VCalendar', Calendar)
// Vue.component('VDatePicker', DatePicker)
// Vue.component('pagination', Pagination);


import "./src/vue_component";

axios.defaults.baseURL = window.origin;
Vue.config.productionTip = false
Vue.prototype.$boston = boston;
import "./helper/BostonMixin";
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    store: storage
});