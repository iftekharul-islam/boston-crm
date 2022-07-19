import Vue from "vue";

const ClientList = () =>
    import ( /*webpackChunkName: "client_list"*/ '../components/clients/list');
const TicketList = () =>
    import ( /*webpackChunkName: "client_list"*/ '../components/ticket/list');
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
const workflowFiles = () =>
    import ( /*webpackChunkName: "workflowFiles"*/ '../components/orders/details/workflowFiles')
const invoice = () =>
    import ( /*webpackChunkName: "invoice"*/ '../components/orders/details/invoice')
const notes = () =>
    import ( /*webpackChunkName: "notes"*/ '../components/orders/details/notes')
const activityLog = () =>
    import ( /*webpackChunkName: "activityLog"*/ '../components/orders/details/activityLog')
const orderList = () =>
    import ( /*webpackChunkName: "orderList"*/ '../components/orders/list')
const orderEdit = () =>
    import ( /*webpackChunkName: "orderEdit"*/ '../components/orders/edit.vue')
const orderPagination = () =>
    import ( /*webpackChunkName: "orderPagination"*/ './Pagination')
const addCallLog = () =>
    import ( /*webpackChunkName: "AddCallLog"*/ '../components/orders/AddCallLog')
const callList = () =>
    import ( /*webpackChunkName: "callList"*/ '../components/calls/list')
const callSchedule = () =>
    import ( /*webpackChunkName: "callSchedule"*/ '../components/calls/callSchedule')
const callReSchedule = () =>
    import ( /*webpackChunkName: "callReSchedule"*/ '../components/calls/callReSchedule')
const addIssue = () =>
    import ( /*webpackChunkName: "addIssue"*/ '../components/orders/AddIssue')
const mModal = () =>
    import ( /*webpackChunkName: "m-modal"*/ './modal')
const sendMessage = () =>
    import ( /*webpackChunkName: "sendMessage"*/ '../components/calls/sendMessage')
const quickView = () =>
    import ( /*webpackChunkName: "quickView"*/ '../components/calls/quickView')
const marketingList = () =>
    import ( /*webpackChunkName: "marketingList"*/ '../components/marketing/list')
const addClient = () =>
    import ( /*webpackChunkName: "addClient"*/ '../components/marketing/addClient')

Vue.component('clients-list', ClientList);
Vue.component('ticket-list', TicketList);
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
Vue.component('workflow-files', workflowFiles);
Vue.component('invoice', invoice);
Vue.component('notes', notes);
Vue.component('activity-log', activityLog);
Vue.component('order-list', orderList);
Vue.component('order-edit-vue', orderEdit);
Vue.component('paginate', orderPagination);
Vue.component('add-issue', addIssue);
Vue.component('add-call-log', addCallLog);
Vue.component('call-list', callList);
Vue.component('call-schedule', callSchedule);
Vue.component('call-re-schedule', callReSchedule);
Vue.component('m-modal', mModal);
Vue.component('send-message', sendMessage);
Vue.component('quick-view', quickView);
Vue.component('marketing-list', marketingList);
Vue.component('add-client', addClient);
