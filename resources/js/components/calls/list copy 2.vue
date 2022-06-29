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
                <!-- <transition name="fade" appear v-if="visibleColumnDropDown">
                    <div class="column-list">
                        <div class="col-item" @click="addToTable(item)" :class="{ 'active' : checkColumnActive(item) }" v-for="item, ci in order.disableHeader" :key="ci">{{ item.title }}</div>
                    </div>
                </transition> -->
                <div class="call-list">
                    <div class="call-list-header">
                        <span class="call-list-item" v-for="item, sl in table.backupHeader" :key="sl + '-' + item.key">
                            <template v-if="item.disable == false">
                                {{ item.title }}
                            </template>
                        </span>
                        <span class="call-list-item cursor-hover">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.25"
                                    d="M17.028 0H6.972C2.604 0 0 2.604 0 6.972V17.028C0 21.396 2.604 24 6.972 24H17.028C21.396 24 24 21.396 24 17.028V6.972C24 2.604 21.396 0 17.028 0Z"
                                    fill="#2F415E" />
                                <path
                                    d="M19.5727 8.244C19.5727 8.736 19.1767 9.144 18.6727 9.144H12.3727C11.8807 9.144 11.4727 8.736 11.4727 8.244C11.4727 7.752 11.8807 7.344 12.3727 7.344H18.6727C19.1767 7.344 19.5727 7.752 19.5727 8.244Z"
                                    fill="#2F415E" />
                                <path
                                    d="M9.56388 7.08L6.86387 9.78C6.68387 9.96 6.45588 10.044 6.22788 10.044C5.99988 10.044 5.75988 9.96 5.59188 9.78L4.69188 8.88C4.33187 8.532 4.33187 7.956 4.69188 7.608C5.03988 7.26 5.60388 7.26 5.96388 7.608L6.22788 7.872L8.29188 5.808C8.63987 5.46 9.20388 5.46 9.56388 5.808C9.91188 6.156 9.91188 6.732 9.56388 7.08Z"
                                    fill="#2F415E" />
                                <path
                                    d="M19.5727 16.644C19.5727 17.136 19.1767 17.544 18.6727 17.544H12.3727C11.8807 17.544 11.4727 17.136 11.4727 16.644C11.4727 16.152 11.8807 15.744 12.3727 15.744H18.6727C19.1767 15.744 19.5727 16.152 19.5727 16.644Z"
                                    fill="#2F415E" />
                                <path
                                    d="M9.56388 15.48L6.86387 18.18C6.68387 18.36 6.45588 18.444 6.22788 18.444C5.99988 18.444 5.75988 18.36 5.59188 18.18L4.69188 17.28C4.33187 16.932 4.33187 16.356 4.69188 16.008C5.03988 15.66 5.60388 15.66 5.96388 16.008L6.22788 16.272L8.29188 14.208C8.63987 13.86 9.20388 13.86 9.56388 14.208C9.91188 14.556 9.91188 15.132 9.56388 15.48Z"
                                    fill="#2F415E" />
                            </svg>
                            <div id="menu-bar-list">
                                <div class="list-item" @click="addToColumn(item)" :class="{ 'active' : checkActiveColumn(item) }" v-for="item, sl in table.header" :key="sl + '-toggle-' + item.key">
                                    <div class="list-item-checkbox"></div>
                                    <div class="list-item-title">{{ item.title }}</div>
                                </div>
                            </div>
                        </span>
                    </div>
                    <template v-if="orderData.length">
                        <div class="call-item" v-for="item, callIndex in orderData" :key="callIndex">
                            <div class="call-list-body">
                                <span class="call-list-item">
                                    <input :id="`list-item-${item.id}`" type="checkbox" v-model="item.selected" @change="checkSelectedList($event, item)">
                                    <label :for="`list-item-${item.id}`">
                                        <svg width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M3.85561 9.43102C3.52966 9.43102 3.20372 9.31094 2.94639 9.05361L0.373124 6.48034C-0.124375 5.98284 -0.124375 5.1594 0.373124 4.6619C0.870622 4.1644 1.69407 4.1644 2.19157 4.6619L3.85561 6.32595L9.80843 0.373124C10.3059 -0.124375 11.1294 -0.124375 11.6269 0.373124C12.1244 0.870622 12.1244 1.69407 11.6269 2.19156L4.76483 9.05361C4.52466 9.31094 4.18156 9.43102 3.85561 9.43102Z" fill="white"/>
                                        </svg>
                                    </label>
                                </span>
                                <span class="call-list-item">{{ item.client_order_no }}</span>
                                <span class="call-list-item"><p class="mb-0 fw-bold text-ellips">{{ item.amc ? item.amc.name : '-' }}</p></span>
                                <span class="call-list-item"><p class="mb-0 text-ellips">{{ item.property_info.search_address }}</p></span>
                                <span class="call-list-item">{{ item.inspection ? item.inspection.user.name : '-' }}</span>
                                <span class="call-list-item">
                                    <template v-if="item.appraisal_detail">
                                        {{ item.appraisal_detail.appraiser ? item.appraisal_detail.appraiser.name : '-' }}
                                    </template>
                                    <template v-else>
                                        -
                                    </template>
                                </span>
                                <span class="call-list-item">12.03.2022</span>
                                <span class="call-list-item">
                                    {{ item.inspection ? item.inspection.inspection_date_time : '-' }}
                                </span>
                                <span class="call-list-item"><p class="mb-0 scheduled">{{ item.order_status }}</p></span>
                                <span class="call-list-item">
                                    <a href="javascript:;" class="icon-list" data-bs-placement="bottom" title="Details"><span class="icon-eye text-blue-eye fs-20"><span class="path1"></span><span class="path2"></span></span></a>
                                    <a href="javascript:;" ata-bs-toggle="tooltip" data-bs-placement="bottom" title="Quick view" class="icon-list quick-view-icon" data-bs-toggle="modal" data-bs-target="#exampleModal"><span class="icon-note text-purple fs-20"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></span></a>
                                    <a href="javascript:;" class="icon-list" data-bs-placement="bottom" title="Call log"><span class="icon-messages2 primary-text fs-20"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></span></a>
                                    <a href="javascript:;" class="icon-list" data-bs-placement="bottom" title="Schedule"><span class="icon-calendar text-brown fs-20"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span><span class="path8"></span></span></a>
                                    <a href="javascript:;" class="icon-list"  data-bs-placement="bottom" title="Email & SMS"> <span class="icon-messages text-yellow-msg  fs-20"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span></a>
                                    <a href="javascript:;" class="icon-list"><span class="icon-call text-light-red fs-20"><span class="path1"></span><span class="path2"></span></span></a>
                                    <button class="button button-transparent p-0" data-bs-toggle="collapse" :data-bs-target="`#collapseExample-${item.id}`" aria-expanded="false" :aria-controls="`#collapseExample-${item.id}`"><span class="icon-arrow-bottom"></span></button>
                                </span>
                            </div>
                            <div class="call-collapse collapse" :id="`collapseExample-${item.id}`">
                                <div class="item pending">
                                    <span class="call-badge">Pending</span>
                                    <p class="text-gray text-end fs-12">Today 12:10am</p>
                                    <p class="fs-14 mgt-12 mgb-12">He made payment but didnt get confirmation yet</p>
                                    <div class="d-flex justify-content-between">
                                        <p class="mb-0 fs-14"><span class="text-gray">Assigned to :</span> <b>Technical team</b></p>
                                    </div>
                                </div>
                                <a href="javascript:;" class="item more-item">
                                    <p class="text-center mb-1 text-white">10</p>
                                    <p class="text-center text-white mb-0">More</p>
                                </a>
                            </div>
                        </div>
                    </template>
                    <template v-else>
                        <div class="text-center my-3">
                            <strong class="text-danger">No orders has been found.</strong>
                        </div>
                    </template>
                </div>
                <paginate align="center" :total-page="pages.pageData.last_page" @loadPage="loadPage($event)"></paginate>
            </div>
        </div>

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
   </div>
</template>

<script>

import Calendar from 'v-calendar/lib/components/calendar.umd'
import DatePicker from 'v-calendar/lib/components/date-picker.umd'
Vue.component('VCalendar', Calendar)
Vue.component('VDatePicker', DatePicker)

import Map from "./map.vue"
export default {
    name: "call-lists",
    props: ['order'],
    components: {
        Map,
    },
    data: () => ({
        pages: {
            pageData: [],
            acitvePage: 1,
            searchModel: null,
            paginate: 10
        },
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
            backupHeader: [],
            header : [
                { 
                    title: "SL",
                    key: "sl",
                    disable: false
                },
                { 
                    title: "Order no",
                    key: "order_no",
                    disable: false
                },
                { 
                    title: "Client name",
                    key: "client_name",
                    disable: false
                },
                { 
                    title: "Property address",
                    key: "property_address",
                    disable: false
                },
                { 
                    title: "Inspector",
                    key: "inpector",
                    disable: false
                },
                { 
                    title: "Appraiser",
                    key: "appraiser",
                    disable: false
                },
                { 
                    title: "Last call",
                    key: "last_call",
                    disable: false
                },
                { 
                    title: "Insp. date & time",
                    key: "inspection_date_time",
                    disable: false
                },
                { 
                    title: "Status",
                    key: "status",
                    disable: false
                },
            ]
        }
    }),
    created() {
        this.table.header.map(ele => {
            this.table.backupHeader.push(ele);
        });
        this.initOrder(this.order);
    },
    methods: {
        initOrder(order) {
            this.pages.pageData = order;
            this.orderData = order.data;
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
        checkActiveColumn (val) {
            let getHeader = (this.table.backupHeader);
            let findActive = false;
            getHeader.map((ele) => {
                let key = ele.key;
                if (key && val.key == key) {
                    findActive = val.key == key ? true : false;
                }
            });
            return findActive;
        },
        addToColumn(item) {
            let getHeader = (this.table.backupHeader);
            let findIndex= getHeader.findIndex(ele => ele.key == item.key);
            item.disable = !item.disable;
            return;
            if (findIndex != -1) {
                this.table.backupHeader.splice(findIndex, 1);
            } else {
                this.table.backupHeader.push(item);
            }
        }
    }
}
</script>

<style scoped>

.cursor-hover {
    cursor: pointer;
}

#menu-bar-list{
    position: absolute;
    z-index: 10;
    background: #fff;
    border-radius: 0.25rem;
    overflow: hidden;
    box-shadow: 0 4px 8px 0px rgba(0,0,0,0.25);
}

#menu-bar-list .list-item {
    padding: 5px 8px;
    min-width: 220px;
    cursor: pointer;
    transition: all 0.2s linear;
    display: flex;
    align-items: center;
    font-weight: normal;
}

#menu-bar-list .list-item:hover {
    transition: all 0.2s linear;
    background: rgba(0,0,0,0.1);
}

#menu-bar-list .list-item .list-item-checkbox{
    height: 20px;
    width: 20px;
    border: thin solid #555;
    border-radius: 0.25rem;
    margin-right: 10px;
}

#menu-bar-list .list-item.active .list-item-checkbox{
    background: #19b7a2;
    border-color: transparent;
}


</style>