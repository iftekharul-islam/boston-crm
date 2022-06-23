import Vue from "vue";

const ClientList = () =>
    import ( /*webpackChunkName: "client_list"*/ '../components/clients/list');

const orderCreate = () =>
    import ( /*webpackChunkName: "orderCreate"*/ '../components/orders/OrderCreate')
const basicInfo = () =>
    import ( /*webpackChunkName: "basicInfo"*/ '../components/orders/details/basicInfo')
const propertyInfo = () =>
    import ( /*webpackChunkName: "propertyInfo"*/ '../components/orders/details/propertyInfo')
const appraisalDetails = () =>
    import ( /*webpackChunkName: "appraisalDetails"*/ '../components/orders/details/appraisalDetails')
const providedServices = () =>
    import ( /*webpackChunkName: "providedServices"*/ '../components/orders/details/providedServices')
const workflow = () =>
    import ( /*webpackChunkName: "workflow"*/ '../components/orders/details/workflow')
const clientInfo = () =>
    import ( /*webpackChunkName: "clientInfo"*/ '../components/orders/details/clientInfo')
const header = () =>
    import ( /*webpackChunkName: "header"*/ '../components/orders/details/header')
const callLog = () =>
    import ( /*webpackChunkName: "callLog"*/ '../components/orders/details/callLog')
const borrower = () =>
    import ( /*webpackChunkName: "borrower"*/ '../components/orders/details/borrower')
const contact = () =>
    import ( /*webpackChunkName: "contact"*/ '../components/orders/details/contact')
const inspection = () =>
    import ( /*webpackChunkName: "inspection"*/ '../components/orders/details/inspection')
const issues = () =>
    import ( /*webpackChunkName: "issues"*/ '../components/orders/details/issues')
const history = () =>
    import ( /*webpackChunkName: "history"*/ '../components/orders/details/history')
const mapView = () =>
    import ( /*webpackChunkName: "mapView"*/ '../components/orders/details/mapView')
const files = () =>
    import ( /*webpackChunkName: "files"*/ '../components/orders/details/files')
const invoice = () =>
    import ( /*webpackChunkName: "invoice"*/ '../components/orders/details/invoice')
const notes = () =>
    import ( /*webpackChunkName: "notes"*/ '../components/orders/details/notes')
const activityLog = () =>
    import ( /*webpackChunkName: "activityLog"*/ '../components/orders/details/activityLog')
const orderList = () =>
    import ( /*webpackChunkName: "orderList"*/ '../components/orders/list')
const orderEdit = () =>
    import ( /*webpackChunkName: "orderEdit"*/ '../components/orders/edit')
const orderPagination = () =>
    import ( /*webpackChunkName: "orderPagination"*/ './Pagination')
const ShowOrderDetails = () =>
    import ( /*webpackChunkName: "Show_order_details"*/ '../components/orders/show');

Vue.component('clients-list', ClientList);
Vue.component('order-create', orderCreate);
Vue.component('basic-info', basicInfo);
Vue.component('property-info', propertyInfo);
Vue.component('appraisal-details', appraisalDetails);
Vue.component('provided-services', providedServices);
Vue.component('workflow', workflow);
Vue.component('client-info', clientInfo);
Vue.component('order-header', header);
Vue.component('call-log', callLog);
Vue.component('borrower', borrower);
Vue.component('contact', contact);
Vue.component('inspection', inspection);
Vue.component('issues', issues);
Vue.component('history', history);
Vue.component('map-view', mapView);
Vue.component('files', files);
Vue.component('invoice', invoice);
Vue.component('notes', notes);
Vue.component('activity-log', activityLog);
Vue.component('order-list', orderList);
Vue.component('order-edit', orderEdit);
Vue.component('paginate', orderPagination);
Vue.component('show-order', ShowOrderDetails);
