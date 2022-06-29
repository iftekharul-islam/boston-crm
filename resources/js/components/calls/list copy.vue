<template>
    <div id="boston-cal-lists">
        <div class="calls bg-platinum dashboard-space">
            <div class="bg-white pd-32">
                <div class="calls__menu d-flex flex-wrap">
                    <div class="left chart-box-header-btn d-flex flex-wrap me-3">
                        <button class="calls-btn h-40 d-flex align-items-center mb-2 active">All <span class="ms-2"> (88)</span></button>
                        <button class="calls-btn h-40 d-flex align-items-center mb-2">To be Schedule <span class="ms-2"> (88)</span></button>
                        <button class="calls-btn h-40 d-flex align-items-center mb-2">Schedule <span class="ms-2"> (88)</span></button>
                        <button class="calls-btn h-40 d-flex align-items-center mb-2">Todays Call <span class="ms-2"> (88)</span></button>
                        <button class="calls-btn h-40 d-flex align-items-center mb-2">Completed <span class="ms-2"> (88)</span></button>
                        <button @click="$bvModal.show('dateRange')" class="calls-btn h-40 d-flex align-items-center mb-2">Date Rage</button>
                    </div>
                    <div class="right d-flex">
                        <a @click="goToMap()" href="javascript:;"
                            class="primary-bg h-40 d-flex align-items-center mb-2 px-2 br-4 text-white me-3">Map
                            selected orders <span class="ms-2">({{ selectedItems.length }})</span></a>
                        <div class=" d-flex calls-search">
                            <input type="text" v-model="pages.searchModel" @input="searchData($event)" class="mb-3 px-3 bdr-1 br-4 gray-border calls-search-input h-40" placeholder="Search...">
                            <button class="bg-gray inline-flex-center mb-2 calls-search-btn d-none">
                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M7.33333 13.6667C10.8311 13.6667 13.6667 10.8311 13.6667 7.33333C13.6667 3.83553 10.8311 1 7.33333 1C3.83553 1 1 3.83553 1 7.33333C1 10.8311 3.83553 13.6667 7.33333 13.6667Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M17 17L13 13" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="call-list">
                    <template v-if="orderData.length">
                        <Table :items="orderData" :sl-start="pages.pageData.from" :header="table.header" @headClick="headerClick($event)">
                            <template v-slot:sl="{item}">
                                <span class="call-list-item">
                                    <input :id="`list-item-${item.id}`" type="checkbox" v-model="item.selected" @change="checkSelectedList($event, item)">
                                    <label :for="`list-item-${item.id}`">
                                        <svg width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M3.85561 9.43102C3.52966 9.43102 3.20372 9.31094 2.94639 9.05361L0.373124 6.48034C-0.124375 5.98284 -0.124375 5.1594 0.373124 4.6619C0.870622 4.1644 1.69407 4.1644 2.19157 4.6619L3.85561 6.32595L9.80843 0.373124C10.3059 -0.124375 11.1294 -0.124375 11.6269 0.373124C12.1244 0.870622 12.1244 1.69407 11.6269 2.19156L4.76483 9.05361C4.52466 9.31094 4.18156 9.43102 3.85561 9.43102Z" fill="white"/>
                                        </svg>
                                    </label>
                                </span>
                            </template>
                            <template v-slot:order_no="{item}">
                                {{ item.client_order_no }}
                            </template>
                             <template v-slot:client_name="{item}">
                                {{ item.amc ? item.amc.name : '-' }}
                            </template>
                            <template v-slot:inspector="{item}">
                                {{ item.inspection ? item.inspection.user.name : '-' }}
                            </template>
                            <template v-slot:inspection_date_time="{item}">
                                {{ item.inspection ? item.inspection.inspection_date_time : '-' }}
                            </template>
                            <template v-slot:appraiser="{item}">
                                <template v-if="item.appraisal_detail">
                                    {{ item.appraisal_detail.appraiser ? item.appraisal_detail.appraiser.name : '-' }}
                                </template>
                                <template v-else>
                                    -
                                </template>
<<<<<<< HEAD
                            </span>
                            <span class="call-list-item">12.03.2022</span>
                            <span class="call-list-item">
                                {{ item.inspection ? item.inspection.inspection_date_time : '-' }}
                            </span>
                            <span class="call-list-item">
                                <p class="mb-0 scheduled">{{ item.order_status }}</p>
                            </span>
                            <span class="call-list-item">
                                <a href="#" class="icon-list" data-bs-placement="bottom" title="Details"><span
                                        class="icon-eye text-blue-eye fs-20"><span class="path1"></span><span
                                            class="path2"></span></span></a>
                                <a href="#" ata-bs-toggle="tooltip" data-bs-placement="bottom" title="Quick view"
                                    class="icon-list quick-view-icon" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal"><span class="icon-note text-purple fs-20"><span
                                            class="path1"></span><span class="path2"></span><span
                                            class="path3"></span><span class="path4"></span></span></a>
                                <a href="#" class="icon-list" data-bs-placement="bottom" title="Call log"><span
                                        class="icon-messages2 primary-text fs-20"><span class="path1"></span><span
                                            class="path2"></span><span class="path3"></span><span
                                            class="path4"></span><span class="path5"></span></span></a>
                                <a @click="getScheduleData(callIndex)" href="#" class="icon-list" data-bs-placement="bottom" title="Schedule"><span
                                        class="icon-calendar text-brown fs-20"><span class="path1"></span><span
                                            class="path2"></span><span class="path3"></span><span
                                            class="path4"></span><span class="path5"></span><span
                                            class="path6"></span><span class="path7"></span><span
                                            class="path8"></span></span></a>

                                <a href="#" class="icon-list" data-bs-placement="bottom" title="Email & SMS"> <span
                                        class="icon-messages text-yellow-msg  fs-20"><span class="path1"></span><span
                                            class="path2"></span><span class="path3"></span></span></a>
                                <a href="#" class="icon-list"><span class="icon-call text-light-red fs-20"><span
                                            class="path1"></span><span class="path2"></span></span></a>
                                <button class="button button-transparent p-0" data-bs-toggle="collapse"
                                    data-bs-target="#collapseExample" aria-expanded="false"
                                    aria-controls="collapseExample"><span class="icon-arrow-bottom"></span></button>
                            </span>
                        </div>
                        <div class="call-collapse collapse" id="collapseExample">
                            <div class="item pending">
                                <span class="call-badge">Pending</span>
                                <p class="text-gray text-end fs-12">Today 12:10am</p>
                                <p class="fs-14 mgt-12 mgb-12">He made payment but didnt get confirmation yet</p>
                                <div class="d-flex justify-content-between">
                                    <p class="mb-0 fs-14"><span class="text-gray">Assigned to :</span> <b>Technical
                                            team</b></p>
                                    <a href="#">
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M13.491 1.66667H6.50768C3.47435 1.66667 1.66602 3.475 1.66602 6.50834V13.4833C1.66602 16.525 3.47435 18.3333 6.50768 18.3333H13.4827C16.516 18.3333 18.3243 16.525 18.3243 13.4917V6.50834C18.3327 3.475 16.5243 1.66667 13.491 1.66667Z"
                                                fill="white" />
                                            <path
                                                d="M13.9569 5.83333H9.9319C9.59023 5.83333 9.3069 6.11666 9.3069 6.45833C9.3069 6.8 9.59023 7.08333 9.9319 7.08333H12.4486L6.01523 13.5167C5.77357 13.7583 5.77357 14.1583 6.01523 14.4C6.14023 14.525 6.29857 14.5833 6.4569 14.5833C6.61523 14.5833 6.77357 14.525 6.89857 14.4L13.3319 7.96666V10.4833C13.3319 10.825 13.6152 11.1083 13.9569 11.1083C14.2986 11.1083 14.5819 10.825 14.5819 10.4833V6.45833C14.5819 6.11666 14.2986 5.83333 13.9569 5.83333Z"
                                                fill="#F97373" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                            <div class="item pending">
                                <span class="call-badge">Pending</span>
                                <p class="text-gray text-end fs-12">Today 12:10am</p>
                                <p class="fs-14 mgt-12 mgb-12">He made payment but didnt get confirmation yet</p>
                                <div class="d-flex justify-content-between">
                                    <p class="mb-0 fs-14"><span class="text-gray">Assigned to :</span> <b>Technical
                                            team</b></p>
                                    <a href="#">
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M13.491 1.66667H6.50768C3.47435 1.66667 1.66602 3.475 1.66602 6.50834V13.4833C1.66602 16.525 3.47435 18.3333 6.50768 18.3333H13.4827C16.516 18.3333 18.3243 16.525 18.3243 13.4917V6.50834C18.3327 3.475 16.5243 1.66667 13.491 1.66667Z"
                                                fill="white" />
                                            <path
                                                d="M13.9569 5.83333H9.9319C9.59023 5.83333 9.3069 6.11666 9.3069 6.45833C9.3069 6.8 9.59023 7.08333 9.9319 7.08333H12.4486L6.01523 13.5167C5.77357 13.7583 5.77357 14.1583 6.01523 14.4C6.14023 14.525 6.29857 14.5833 6.4569 14.5833C6.61523 14.5833 6.77357 14.525 6.89857 14.4L13.3319 7.96666V10.4833C13.3319 10.825 13.6152 11.1083 13.9569 11.1083C14.2986 11.1083 14.5819 10.825 14.5819 10.4833V6.45833C14.5819 6.11666 14.2986 5.83333 13.9569 5.83333Z"
                                                fill="#F97373" />
                                        </svg>
                                    </a>
=======
                            </template>
                            <template v-slot:property_address="{item}">
                                {{ item.property_info.search_address }}
                            </template>
                            <template v-slot:status="{item}">
                                <p class="mb-0 scheduled-point">{{ item.order_status }}</p>
                            </template>
                            <template v-slot:action="{item}">
                                <a href="javascript:;" class="icon-list" data-bs-placement="bottom" title="Quick view" @click="openQuickViewFeature(item)"><span class="icon-eye text-blue-eye fs-20"><span class="path1"></span><span class="path2"></span></span></a>
                                <a href="javascript:;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Quick view" class="icon-list quick-view-icon"><span class="icon-note text-purple fs-20"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></span></a>
                                <a href="javascript:;" class="icon-list" data-bs-placement="bottom" title="Call log"><span class="icon-messages2 primary-text fs-20"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></span></a>
                                <a href="javascript:;" class="icon-list" data-bs-placement="bottom" title="Schedule"><span class="icon-calendar text-brown fs-20"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span><span class="path8"></span></span></a>
                                <a href="javascript:;" class="icon-list"  data-bs-placement="bottom" title="Email & SMS"> <span class="icon-messages text-yellow-msg  fs-20"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span></a>
                                <a href="javascript:;" class="icon-list"><span class="icon-call text-light-red fs-20"><span class="path1"></span><span class="path2"></span></span></a>
                                <button class="button button-transparent p-0" @click="openIssues(item)"><span class="icon-arrow-bottom"></span></button>
                            </template>
                            <template v-slot:head_action="{item}">
                                <div class="text-right">
                                    <img src="/icons/column.svg" :tag="item.item" class="cursor-pointer open-head-column">
>>>>>>> c6f0dfe2f2c8eae39009574e1f57e40718fa9001
                                </div>
                            </template>
                            <template v-slot:popup>
                                <transition name="fade" appear v-if="visibleColumnDropDown">
                                    <div class="column-list">
                                        <div class="col-item" @click="addToTable(item)" :class="{ 'active' : checkColumnActive(item) }" v-for="item, ci in table.disableHeader" :key="ci">{{ item.title }}</div>
                                    </div>
                                </transition>
                            </template>
                        </Table>
                        <div class="text-center d-flex justify-content-center">
                            <select @change="loadPage(pages.activePage)" name="paginate" class="form-control per-page" v-model="pages.paginate">
                                <option value="">Per page</option>
                                <option :value="item" :key="ik" v-for="item, ik in pages.perPages">{{ item }} Per page</option>
                            </select>
                        </div>
                        <paginate align="center" :total-page="pages.pageData.last_page" @loadPage="loadPage($event)"></paginate>
                    </template>
                    <template v-else>
                        <div class="text-center my-3">
                            <strong class="text-danger">No orders has been found.</strong>
                        </div>
                    </template>
                </div>
                <!-- <paginate align="center" :total-page="pages.pageData.last_page" @loadPage="loadPage($event)"></paginate> -->
            </div>
        </div>
<<<<<<< HEAD
        <Map v-if="openMap" :latLng="latLng" />
        <call-schedule :orderId="orderId" :appraisers="appraisers"></call-schedule>
        <call-re-schedule :scheduleData="scheduleData" :appraisers="appraisers"></call-re-schedule>
    </div>
</template>

<script>
    import Map from "./map.vue"
    export default {
        name: "call-lists",
        props: ['order', 'appraisers'],
        components: {
            Map
        },
        data: () => ({
            openMap: false,
            orderData: [],
            pageData: [],
            selectedItems: [],
            latLng: [],
            isScheduled: 0,
            scheduleData: [],
            orderId: 0
        }),
        created() {
            this.initOrder(this.order);
        },
        watch: {
            orderId(newValue) {
                this.orderId = newValue;
            }
        },
        methods: {
            getScheduleData(index) {
                this.orderId = this.orderData[index].id
                this.isScheduled = (JSON.parse(this.orderData[index].workflow_status)).scheduling
                this.isScheduled == 0 ? this.$bvModal.show('schedule') : this.$bvModal.show('re-schedule')
                this.scheduleData = this.orderData[index].inspection
            },
            initOrder(order) {
                this.pageData = order;
                this.orderData = order.data;
                //this.isScheduled = (JSON.parse(this.orderData.workflow_status)).scheduling
                //console.log(this.pageData);
                //console.log(this.orderData)
            },
            checkSelectedList(event, item) {
                let value = item.selected;
                let findIndex = this.selectedItems.findIndex(ele => ele.id == item.id);
                if (findIndex !== -1) {
                    if (value == false) {
                        this.selectedItems.splice(findIndex, 1);
                    }
                } else {
                    if (value == true) {
                        this.selectedItems.push(item);
                    }
=======

        <b-modal id="dateRange" size="md" title="Search by date range">
            <div class="modal-body">
                <div class="alert alert-danger text-center" v-if="dateRange.error">
                    {{ dateRange.message }}
                </div>
                <div class="date-range-items">
                    <label for="">From Date</label>
                    <v-date-picker mode="date" v-model="dateRange.start">
                        <template class="position-relative" v-slot="{ inputValue, inputEvents }">
                            <input class="dashboard-input w-100" :value="inputValue" v-on="inputEvents" @change="dateRange.error = false" />
                        </template>
                    </v-date-picker>
                    <br><br>
                    <label for="">To Date</label>
                    <v-date-picker mode="date" v-model="dateRange.end">
                        <template class="position-relative" v-slot="{ inputValue, inputEvents }">
                            <input class="dashboard-input w-100" :value="inputValue" v-on="inputEvents" @change="dateRange.error = false" />
                        </template>
                    </v-date-picker>
                </div>
            </div>
            <div slot="modal-footer">
                <b-button variant="secondary" @click="$bvModal.hide('dateRange')">Close</b-button>
                <b-button variant="primary" @click="searchDateRange">Save</b-button>
            </div>
        </b-modal>
        <Map v-if="openMap" :latLng="latLng" @closeMap="closeCurrentMap($event)"/>
        <m-modal v-model="openIssue" title="Pending Issues/Tickets Lists">
            <div class="issue-list">
                <div class="call-list-modal" v-if="activeIssue.length">
                    <div class="item pending" v-for="item, lindex in activeIssue" :key="'pending-issue-'+lindex">
                        <span class="call-badge">Pending</span>
                        <p class="text-gray text-end fs-12">{{ item.created_at | dateTime }}</p>
                        <p class="fs-14 mgt-12 mgb-12">{{ item.issue }}</p>
                        <div class="d-flex justify-content-between" v-if="item.assigned_to">
                            <p class="mb-0 fs-14"><span class="text-gray">Assigned to :</span> <b>Technical team</b></p>
                        </div>
                    </div>
                </div>
                <div class="text-center my-3" v-else>
                    <div class="alert alert-danger">
                        There are no issues/tickets found.
                    </div>
                </div>
            </div>
        </m-modal>
        <Quickview v-if="openQuickView" :order="quickOrder" @closeQuickView="closeQuickViewModal($event)"/>
   </div>
</template>

<script>

import Calendar from 'v-calendar/lib/components/calendar.umd'
import DatePicker from 'v-calendar/lib/components/date-picker.umd'
Vue.component('VCalendar', Calendar)
Vue.component('VDatePicker', DatePicker)

import Table from "../../src/Table.vue"
import Map from "./map.vue"
import Quickview from "./QuickView.vue";

export default {
    name: "call-lists",
    props: ['order'],
    components: {
        Map,
        Quickview,
        Table
    },
    data: () => ({
        pages: {
            pageData: [],
            acitvePage: 1,
            searchModel: null,
            paginate: 10,
            perPages: [10,15,20,25,30,40,50,60,100]
        },
        visibleColumnDropDown: false,
        openMap: false,
        orderData: [],
        selectedItems: [],
        latLng: [],
        dateRange: {
            start: null,
            end: null,
            search: false,
            error: false,
            message: null
        },
        table : {
            disableHeader: [],
            header : [
                "SL@sl@left@left",
                "Order no@order_no@left@left",
                "Client name@client_name@left@left",
                "Property address@property_address@left@left",
                "Inspector@inspector@left@left",
                "Appraiser@appraiser@left@left",
                "Last call@last_call@left@left",
                "Insp. date & time@inspection_date_time@left@left",
                "Status@status@left@left",
                "Action@action@right@right"
            ]
        },
        activeIssue: [],
        openIssue: false,
        openQuickView: false,
        quickOrder: [],
    }),
    created() {
        this.initOrder(this.order);
    },
    mounted() {
        $(document).on("click", function(e) {
            let target = $(".open-head-column");
            let eventTarget = $(e.target);
            let secondTarget = $(".column-list");
            if (!eventTarget.is(target) && target.has(eventTarget).length == 0 && !eventTarget.is(secondTarget) && secondTarget.has(eventTarget).length == 0) {
                this.visibleColumnDropDown = false;
            }
        }.bind(this));
    },
    methods: {
        initOrder(order) {
            this.pages.pageData = order;
            this.orderData = order.data;
            console.log(this.orderData);
            this.initTable();
        },
        initTable() {
            this.table.header.map( (ele) => {
                let item = ele.split("@");
                let checkDisable = this.table.disableHeader.find((ele) => ele.key == item[1]);
                if (!checkDisable) {
                    this.table.disableHeader.push({
                        title: item[0],
                        key:  item[1]
                    });
>>>>>>> c6f0dfe2f2c8eae39009574e1f57e40718fa9001
                }
            });
        },
        checkSelectedList(event, item) {
            let value = item.selected;
            let findIndex = this.selectedItems.findIndex(ele => ele.id == item.id);
            if (findIndex !== -1) {
                if (value == false) {
                    this.selectedItems.splice(findIndex, 1);
                }
            } else {
                if (value == true) {
                    this.selectedItems.push(item);
                }
            }
        },
        goToMap() {
            let getLatLng = [];
            if (this.selectedItems.length <= 0) {
                return false;
            }
            this.selectedItems.map((ele) => {
                let latLng = {
                    lat: parseFloat(ele.property_info.latitude),
                    lng: parseFloat(ele.property_info.longitude),
                    details: {
                        orderNo: ele.client_order_no,
                        property: ele.property_info
                    }
                }
                getLatLng.push(latLng);
            });
            this.latLng = getLatLng;
            this.openMap = true;
        },
        closeCurrentMap(event) {
            this.openMap = false;
        },
        searchData: _.debounce( function (event) {
            this.loadPage(this.pages.acitvePage, event.target.value);
        }, 300),
        
        loadPage(acitvePage = null){
            this.pages.acitvePage = acitvePage;
            this.$boston.post('search/call/order?page='+this.pages.acitvePage, { data: this.pages.searchModel, paginate: this.pages.paginate, dateRange: this.dateRange }).then( (res) => {
                this.selectedItems = [];
                this.dateRange.search = false;
                this.pages.pageData = res;
                this.orderData = res.data;
            }).catch( (err) => {
                console.log(err);
            });
        },
        searchDateRange() {
            this.dateRange.error = false;
            if (this.dateRange.start > this.dateRange.end || this.dateRange.start == null || this.dateRange.end == null) {
                this.dateRange.error = true;
                this.dateRange.message = "Please input valid dates";
                return;
            }
            this.dateRange.search = true;
            this.loadPage(this.acitvePage);
            this.$bvModal.hide('dateRange')
        },
        checkColumnActive(val) {
            let getHeader = (this.table.header);
            let findActive = false;
            for (let index in getHeader){
                let ele = getHeader[index];
                let key = ele.split("@");
                if (key[1] && val.key == key[1]) {
                    findActive = val.key == key[1] ? true : false;
                    break;
                }
            }
            return findActive;
        },
        addToTable(val) {
            if (val.key == 'action') {
                return false;
            }
            let getHeader = (this.table.header);
            let getIndex = getHeader.find( (ele) => {
                let key = ele.split("@");
                if(val.key == key[1]) {
                    return true;
                }
            });
            if (!getIndex) {
                let slicePoint = 9;
                if (val.key == 'sl') {
                   slicePoint = 0;
                } else if (val.key == 'action') {
                    slicePoint = this.table.header.length;
                } 
                this.table.header.splice( slicePoint, 0,
                    val.title + '@' + val.key + '@left@left'
                );
            } else  {
                let getIndexNo = this.table.header.findIndex(ele => {
                    return ele == getIndex;
                });
                this.table.header.splice(getIndexNo, 1);
            }
            this.checkColumnActive(val)
        },
        headerClick(event) {
            if (event.item == "action") {
                this.visibleColumnDropDown = !this.visibleColumnDropDown;
            }
        },
        openIssues(item) {
            this.activeIssue = item.pending_tickets;
            this.openIssue = true;
        },
        openQuickViewFeature(item) {
            this.quickOrder = item;
            this.openQuickView = true;
        },
        closeQuickViewModal(val) {
            this.openQuickView = false;
            console.log(val);
        }
    }
}
</script>

<style scoped>

.cursor-hover {
    cursor: pointer;
}


.column-list {
    position: absolute;
    background: #fff;
    min-width: 220px;
    height: auto;
    right: 0;
    top: 40px;
    border: 1px solid rgba(25, 183, 162, 0.5);
    box-shadow: 0px 4px 12px 4px rgba(0, 0, 0, 0.08);
    border-radius: 8px;
    overflow: hidden;
    bottom: auto;
    padding: 20px;
    z-index: 999;
}
.column-list .col-item {
    padding: 0px 0px 0px 40px;
    cursor: pointer;
    position: relative;
    margin-bottom: 12px;
}

.column-list .col-item::after {
    content: "";
    position: absolute;
    height: 24px;
    width: 24px;
    background: transparent;
    border: 1px solid #19B7A2;
    left: 5px;
    top: 50%;
    border-radius: 4px;
    transform: translate(0, -50%);
}
.column-list .col-item.active::after {
    background: #19b7a2;
}
.column-list .col-item.active::before {
    content: '';
    display: inline-block;
    transform: rotate(45deg);
    height: 15px;
    width: 8px;
    border-bottom: 3px solid #ffffff;
    border-right: 3px solid #ffffff;
    position: absolute;
    left: 13px;
    z-index: 9;
    top: 4px;
}


</style>
