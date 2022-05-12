/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default
import Pagination from 'vue-pagination-2'
import VueSweetalert2 from 'vue-sweetalert2'
import 'sweetalert2/dist/sweetalert2.min.css';

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
Vue.use(VueSweetalert2);
Vue.component('pagination', Pagination);
Vue.component('clients-list', require('./components/clients/list').default);
Vue.component('order-create', require('./components/orders/OrderCreate').default)
Vue.component('basic-info', require('./components/orders/details/basicInfo').default)
Vue.component('appraisal-details', require('./components/orders/details/appraisalDetails').default)
Vue.component('workflow', require('./components/orders/details/workflow').default)

axios.defaults.baseURL = window.origin;
Vue.config.productionTip = false
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
