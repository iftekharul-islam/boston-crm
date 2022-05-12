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
Vue.component('client-info', require('./components/orders/details/clientInfo').default)
Vue.component('call-log', require('./components/orders/details/callLog').default)
Vue.component('borrower', require('./components/orders/details/borrower').default)
Vue.component('contact', require('./components/orders/details/contact').default)
Vue.component('inspection', require('./components/orders/details/inspection').default)
Vue.component('issues', require('./components/orders/details/issues').default)
Vue.component('history', require('./components/orders/details/history').default)
Vue.component('map-view', require('./components/orders/details/mapView').default)
Vue.component('files', require('./components/orders/details/files').default)
Vue.component('invoice', require('./components/orders/details/invoice').default)
Vue.component('notes', require('./components/orders/details/notes').default)
Vue.component('activity-log', require('./components/orders/details/activityLog').default)

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
