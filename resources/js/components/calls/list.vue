<template>
    <div id="boston-cal-lists">
        <div class="calls bg-platinum dashboard-space">
            <div class="bg-white pd-32">
                <div class="calls__menu d-flex flex-wrap">
                    <div class="left chart-box-header-btn d-flex flex-wrap me-3">
                        <button @click="filterByTab('all')"
                            :class="{'active' : pages.filterType == 'all' || pages.filterType == null}"
                            class="calls-btn h-40 d-flex align-items-center mb-2 d-none">All <span class="ms-2">
                                ({{ filterValue.all }})</span></button>
                        <button @click="filterByTab('to_schedule')"
                            :class="{'active' : pages.filterType == 'to_schedule'}"
                            class="calls-btn h-40 d-flex align-items-center mb-2">To be Schedule <span class="ms-2">
                                ({{ filterValue.to_schedule }})</span></button>
                        <button @click="filterByTab('schedule')" :class="{'active' : pages.filterType == 'schedule'}"
                            class="calls-btn h-40 d-flex align-items-center mb-2">Schedule <span class="ms-2">
                                ({{ filterValue.schedule }})</span></button>
                        <button @click="filterByTab('today_call')"
                            :class="{'active' : pages.filterType == 'today_call'}"
                            class="calls-btn h-40 d-flex align-items-center mb-2">Todays Call <span class="ms-2">
                                ({{ filterValue.today_call }})</span></button>
                        <button @click="filterByTab('completed')" :class="{'active' : pages.filterType == 'completed'}"
                            class="calls-btn h-40 d-flex align-items-center mb-2">Completed <span class="ms-2">
                                ({{ filterValue.completed }})</span></button>
                        <button @click="$bvModal.show('dateRange'); filterByTab('daterange')" :class="{'active' : pages.filterType == 'daterange'}"
                            class="calls-btn h-40 d-flex align-items-center mb-2">Date Rage</button>
                    </div>
                    <div class="right d-flex">
                        <a @click="goToMap()" href="javascript:;"
                            class="primary-bg h-40 d-flex align-items-center mb-2 px-2 br-4 text-white me-3">Map
                            selected orders <span class="ms-2">({{ selectedItems.length }})</span></a>
                        <div class=" d-flex calls-search">
                            <input type="text" v-model="pages.searchModel" @input="searchData($event)"
                                class="mb-3 px-3 bdr-1 br-4 gray-border calls-search-input h-40" :placeholder="searchColumnType">
                            <button class="bg-gray inline-flex-center mb-2 calls-search-btn d-none">
                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M7.33333 13.6667C10.8311 13.6667 13.6667 10.8311 13.6667 7.33333C13.6667 3.83553 10.8311 1 7.33333 1C3.83553 1 1 3.83553 1 7.33333C1 10.8311 3.83553 13.6667 7.33333 13.6667Z"
                                        stroke="white" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M17 17L13 13" stroke="white" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <Table v-if="!gLoad" :items="orderData" :sl-start="pages.pageData.from" :header="table.header"
                    @headClick="headerClick($event)">
                    <template v-slot:status="{item}">
                        <p class="mb-0 status-scheduled td-text-overflow" :title="item.order_status">{{
                            item.order_status }}</p>
                    </template>
                    <template v-slot:sl="{item}">
                        <div class="call-list">
                            <span class="call-list-item">
                                <input :id="`list-item-${item.id}`" type="checkbox" v-model="item.selected"
                                    @change="checkSelectedList($event, item)">
                                <label :for="`list-item-${item.id}`">
                                    <svg width="12" height="10" viewBox="0 0 12 10" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M3.85561 9.43102C3.52966 9.43102 3.20372 9.31094 2.94639 9.05361L0.373124 6.48034C-0.124375 5.98284 -0.124375 5.1594 0.373124 4.6619C0.870622 4.1644 1.69407 4.1644 2.19157 4.6619L3.85561 6.32595L9.80843 0.373124C10.3059 -0.124375 11.1294 -0.124375 11.6269 0.373124C12.1244 0.870622 12.1244 1.69407 11.6269 2.19156L4.76483 9.05361C4.52466 9.31094 4.18156 9.43102 3.85561 9.43102Z"
                                            fill="white" />
                                    </svg>
                                </label>
                            </span>
                        </div>
                    </template>
                    <template v-slot:amc_name="{item}">
                        <strong>Amc:</strong> {{ item.extra_data.amc_name }} <br>
                        <strong>Lender:</strong> {{ item.extra_data.lender }}
                    </template>
                    <template v-slot:last_call="{item}">
                        {{ item.last_call ? item.last_call : '-' }}
                    </template>
                    <template v-slot:inspector="{item}">
                        {{ item.inspection ? item.inspection.user.name : '-' }}
                    </template>
                    <template v-slot:due_date="{item}">
                        {{ item.due_date | onlyDate }}
                    </template>
                    <template v-slot:order_no="{item}">
                        {{ item.client_order_no }}
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
                    </template>
                    <template v-slot:property_address="{item}">
                        <div class="full_addr">
                            {{ item.extra_data.full_address }}
                        </div>
                    </template>
                    <template v-slot:action="{item}">
                        <span class="call-list-item">
                            <a :href="`/orders/${item.id}`" class="icon-list">
                                <span class="icon-eye text-blue-eye fs-20"><span class="path1"></span><span
                                        class="path2"></span></span>
                                <span class="call-tooltip">Details</span>
                            </a>
                            <a href="javascript:;" @click.prevent="getQuickView(item)"
                                class="icon-list quick-view-icon"><span class="icon-note text-purple fs-20"><span
                                        class="path1"></span><span class="path2"></span><span class="path3"></span><span
                                        class="path4"></span></span>
                                <span class="call-tooltip">Quick view</span>
                            </a>
                            <a @click.prevent="getCallSummary(item.call_log, item.id, item.client_order_no, item.property_info.full_addr)" href="javascript:;"
                                class="icon-list" data-bs-toggle="modal" data-bs-target="#callLogModal"><span
                                    class="icon-messages2 primary-text fs-20"><span class="path1"></span><span
                                        class="path2"></span><span class="path3"></span><span class="path4"></span><span
                                        class="path5"></span></span>
                                <span class="call-tooltip">Call log</span>
                            </a>
                            <a @click="getScheduleData(item)" href="javascript:;" class="icon-list">
                                <span class="icon-calendar text-brown fs-20"><span class="path1"></span><span
                                        class="path2"></span><span class="path3"></span><span class="path4"></span><span
                                        class="path5"></span><span class="path6"></span><span class="path7"></span><span
                                        class="path8"></span></span>
                                <span class="call-tooltip" v-if="item.status == 0">Schedule</span>
                                <span class="call-tooltip" v-else>Re-schedule</span>
                            </a>
                            <a href="javascript:;" @click="getSendMessage(item)" class="icon-list">
                                <img src="/img/sms.svg" alt="Email and sms" class="img-fluid">
                                <span class="call-tooltip">Email & SMS</span>
                            </a>
                            <a @click="callNumberInit(item)" href="javascript:;" class="icon-list"><span class="icon-call text-light-red fs-20"><span
                                        class="path1"></span><span class="path2"></span></span>
                                <span class="call-tooltip">Call</span>
                            </a>
                            <button @click="openIssues(item)" class="button button-transparent p-0"><span
                                    class="icon-arrow-bottom"></span></button>
                        </span>
                    </template>
                    <template v-slot:head_action="{item}">
                        <img src="/icons/column.svg" :tag="item.item" class="cursor-pointer open-head-column">
                    </template>
                    <template v-slot:popup>
                        <transition name="fade" appear v-if="visibleColumnDropDown">
                            <div class="column-list">
                                <div class="col-item" @click="addToTable(item)"
                                    :class="{ 'active' : checkColumnActive(item) }"
                                    v-for="item, ci in table.disableHeader" :key="ci">{{ item.title }}</div>
                            </div>
                        </transition>
                    </template>
                </Table>
                <m-load v-else></m-load>
                <div class="d-flex align-items-center justify-content-center">
                    <div class="text-center d-flex justify-content-center mgr-20">
                        <select @change="loadPage(pages.activePage)" name="paginate" class="form-control per-page"
                            v-model="pages.paginate">
                            <option value="">Per page</option>
                            <option :value="item" :key="ik" v-for="item, ik in pages.perPages">{{ item }} Per page
                            </option>
                        </select>
                    </div>
                    <paginate align="center" :total-page="pages.pageData.last_page" @loadPage="loadPage($event)">
                    </paginate>
                </div>
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
                            <input class="dashboard-input w-100" :value="inputValue" v-on="inputEvents"
                                @change="dateRange.error = false" />
                        </template>
                    </v-date-picker>
                    <br><br>
                    <label for="">To Date</label>
                    <v-date-picker mode="date" v-model="dateRange.end">
                        <template class="position-relative" v-slot="{ inputValue, inputEvents }">
                            <input class="dashboard-input w-100" :value="inputValue" v-on="inputEvents"
                                @change="dateRange.error = false" />
                        </template>
                    </v-date-picker>
                </div>
            </div>
            <div slot="modal-footer">
                <b-button variant="secondary" @click="$bvModal.hide('dateRange')">Close</b-button>
                <b-button variant="primary" @click="searchDateRange">Save</b-button>
            </div>
        </b-modal>

        <m-modal v-model="openIssue" title="Pending Issues/Tickets Lists">
            <div class="issue-list">
                <div class="row" v-if="activeIssue && activeIssue.length">
                    <div class="call-list-modal col-md-6" v-for="item, lindex in activeIssue" :key="'pending-issue-'+lindex">
                        <div class="item pending">
                            <span class="call-badge">Pending</span>
                            <p class="text-gray text-end fs-12">{{ item.created_at | dateTime }}</p>
                            <p class="fs-14 mgt-12 mgb-12">{{ item.issue }}</p>
                            <div class="d-flex justify-content-between" v-if="item.assigned_to">
                                <p class="mb-0 fs-14"><span class="text-gray">Assigned to :</span> <b>Technical team</b></p>
                            </div>
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

        <m-modal v-model="openCallNumber" title="Call to client">
            <div class="box-body">
                <div class="list__group">
                    <p class="mb-0 left-side">Borrower name</p>
                    <span>:</span>
                    <p class="right-side mb-0">{{ contact_number_e }}</p>
                </div>
                <div class="list__group">
                    <p class="mb-0 left-side">Borrower Phone Numbers</p>
                    <span>:</span>
                    <p class="right-side list-items mb-0 phone-number">
                    <input @click="selectText(item)" readonly class="d-inline-block mb-2" v-for="item, ik in contact_number_s" :key="ik" :value="item"/>
                    </p>
                </div>
                <hr>
                <div class="list__group">
                    <p class="mb-0 left-side">Contact</p>
                    <span>:</span>
                    <p class="right-side mb-0">{{ contact_ex_number_e }}</p>
                </div>
                <div class="list__group">
                    <p class="mb-0 left-side">Contact Phone Numbers</p>
                    <span>:</span>
                    <p class="right-side list-items mb-0 phone-number">
                    <input @click="selectText(item)" readonly class="d-inline-block mb-2" v-for="item, ik in contact_ex_number_s" :key="ik" :value="item"/>
                    </p>
                </div>
            </div>
        </m-modal>

        <quick-view ref="quickViewComponent"></quick-view>
        <call-schedule ref="callScheduleComponent" :appraisers="appraisers"></call-schedule>
        <call-re-schedule ref="callReScheduleComponent" :appraisers="appraisers"></call-re-schedule>
        <send-message ref="sendMessageComponent"></send-message>
        <!-- <Map v-if="openMap" :latLng="latLng" @closeMap="closeCurrentMap($event)" /> -->

        <div class="modal fade schedule-modal call-log-modal" id="callLogModal" tabindex="-1"
            aria-labelledby="callLogModalLabel" aria-hidden="true">
            <div class="modal-dialog h-100">
                <div class="modal-content ">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="modal-body h-100 overflow-auto">
                        <h3>Call summary <span class="fs-15 badges solved-badges" v-if="!callLog.notCompleted">Completed</span></h3>
                        <p class="text-gray fs-12 mb-0">{{ callLog.order_no }}</p>
                        <p class="mb-3 text-gray fs-12 mb-0">{{ callLog.address }}</p>
                        <div class="call-summary-item" v-for="(log, logIndex) in callLog.items" :key="logIndex">
                            <div class="top d-flex align-items-center">
                                <div v-if="log.caller.media.length">
                                    <img :src="log.caller.media[0].original_url" alt=" profile photo boston"
                                        class="img-fluid">
                                </div>
                                <div v-else>
                                    <img src="/img/user.png" alt=" profile photo boston" class="img-fluid">
                                </div>
                                <div class="ms-3">
                                    <p class="fw-bold mb-1">{{ log.caller.name }}</p>
                                    <p class="text-gray fs-12 mb-0">{{ log.created_at }}</p>
                                </div>
                            </div>
                            <p class="message">{{ log.message }}</p>
                        </div>
                    </div>
                    <!-- message box -->
                    <div class="update-log">
                        <div class="group" :class="{ 'invalid-form' : callLog.error == true }">
                            <label for="" class="d-block mb-2 dashboard-label">Message</label>
                            <textarea @keyup="dataExist()" v-model.trim="callLog.message" class="dashboard-input w-100"
                                style="min-height: 100px"></textarea>
                            <span v-if="callLog.error" class="error-message">The Message field is required</span>
                        </div>
                        <div class="checkbox-group mt-2"  v-if="callLog.notCompleted">
                            <input type="checkbox" class="checkbox-input" v-model="callLog.status">
                            <label for="" class="checkbox-label">Call completed</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="button button-primary px-5" @click="addCallLog()">Post</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Table from "../../src/Table.vue"
    // import Map from "./map.vue"
    import Quickview from "./quickView.vue";

    import Calendar from 'v-calendar/lib/components/calendar.umd'
    import DatePicker from 'v-calendar/lib/components/date-picker.umd'

    Vue.component('VCalendar', Calendar)
    Vue.component('VDatePicker', DatePicker)

    export default {
        name: "call-lists",
        props: ['order', 'appraisers', 'filter-value'],
        components: {
            // Map,
            'quick-view': Quickview,
            Table,
        },
        data: () => ({
            filterValues: [],
            openCallNumber: false,
            contact_number_s: [],
            contact_number_e: null,
            contact_ex_number_s: [],
            contact_ex_number_e: null,
            contact_is_borrower: 0,
            callLog: {
                error: false,
                notCompleted: true,
                items: [],
                message: '',
                status: '',
                orderId: '',
                order_no: '',
                address: '',
            },
            pages: {
                pageData: [],
                acitvePage: 1,
                searchModel: null,
                filterType: "to_schedule",
                paginate: 10,
                perPages: [10, 15, 20, 25, 30, 40, 50, 60, 100]
            },
            visibleColumnDropDown: false,
            openMap: false,
            orderData: [],
            selectedItems: [],
            latLng: [],
            searchColumnType: "Search by order no, client order no etc.",
            dateRange: {
                start: null,
                end: null,
                search: false,
                error: false,
                message: null
            },
            table: {
                disableHeader: [
                    {
                        title: "Serial No",
                        key: "system_order_no"
                    },
                    {
                        title: "Due Date",
                        key: "due_date"
                    },
                    {
                        title: "Loan No",
                        key: "loan_no|extra_data",
                    },
                    {
                        title: "Receive date",
                        key: "receive_date|extra_data",
                    },
                    {
                        title: "Loan Type",
                        key: "loan_type|extra_data",
                    },
                    {
                        title: "FHA case no",
                        key: "fha_case_no|extra_data",
                    },
                    {
                        title: "Property Type",
                        key: "property_type|extra_data"
                    },
                    {
                        title: "Technology Fee",
                        key: "technology_fee|extra_data"
                    },
                    {
                        title: "State Name",
                        key: "state_name|extra_data"
                    },
                    {
                        title: "Lender",
                        key: "lender|extra_data"
                    },
                    {
                        title: "Area/City",
                        key: "area|extra_data"
                    },
                    {
                        title: "Unit no",
                        key: "unit_no|extra_data"
                    },
                    {
                        title: "Street Name",
                        key: "street_name|extra_data"
                    },
                    {
                        title: "Zip code",
                        key: "zip_code|extra_data"
                    },
                    {
                        title: "Latitude",
                        key: "latitude|extra_data"
                    },
                    {
                        title: "Longitude",
                        key: "longitude|extra_data"
                    },
                    {
                        title: "County",
                        key: "county|extra_data"
                    },
                    {
                        title: "Provided note",
                        key: "provided_note|extra_data"
                    },
                    {
                        title: "Borrower name",
                        key: "borrower_name|extra_data"
                    },
                    {
                        title: "Co borrower name",
                        key: "co_borrower_name|extra_data"
                    },
                    {
                        title: "Contact name",
                        key: "contact_name|extra_data"
                    },
                ],
                header: [
                    "SL@sl@left@left",
                    "Order no@order_no@left@left",
                    "Client name@amc_name@left@left",
                    "Property address@property_address@left@left",
                    "Inspector@inspector@left@left",
                    'Due date@due_date@left@left',
                    "Appraiser@appraiser@left@left",
                    "Last call@last_call@left@left",
                    "Insp. date & time@inspection_date_time@left@left",
                    "Status@status@left@left",
                    "Action@action@right@right"
                ]
            },
            activeIssue: [],
            openIssue: false,
        }),
        created() {
            this.initOrder(this.order);
            this.$root.$on('wk_flow_toast', (res) => {
                if (res.error == false) {
                    this.$store.commit('app/storeOrder', res.data)
                    this.loadPage(this.activePage)
                }
                this.$toast.open({
                    message: res.message,
                    type: res.error == true ? 'error' : 'success',
                });
            });
        },
        mounted() {
            $(document).on("click", function (e) {
                let target = $(".open-head-column");
                let eventTarget = $(e.target);
                let secondTarget = $(".column-list");
                if (!eventTarget.is(target) && target.has(eventTarget).length == 0 && !eventTarget.is(secondTarget) && secondTarget.has(eventTarget).length == 0) {
                    this.visibleColumnDropDown = false;
                }
            }.bind(this));
        },
        methods: {
            dataExist() {
                if (this.callLog.message !== "") {
                    this.callLog.error = false
                } else {
                    this.callLog.error = true
                }
            },
            addCallLog() {
                this.callLog.error = false
                if (this.callLog.message == '') {
                    this.callLog.error = true
                    return
                }
                let data = {
                    message: this.callLog.message,
                    status: this.callLog.status
                }
                axios.post('call-log-update/' + this.callLog.orderId, data)
                    .then(res => {
                        this.callLog.error = false
                        this.callLog.message = ''
                        this.callLog.status = ''
                        this.toastMessage(res.data.message, res.data.error)
                        if(res.data.data){
                            this.getCallSummary(res.data.data, this.callLog.orderId)
                        }
                    }).catch(err => {
                        console.log(err)
                    })
            },
            toastMessage(msg, status){
                this.$toast.open({
                    message: msg,
                    type: status == true ? 'error' : 'success',
                });
            },
            getCallSummary(value, id, order_no, address) {
                this.callLog.notCompleted = true
                this.callLog.items = []
                this.callLog.orderId = id
                this.callLog.order_no = order_no
                this.callLog.address = address
                if (value.length) {
                    this.callLog.items = value
                    this.callLog.items.forEach((log, index) => {
                        if (log.status) {
                            this.callLog.notCompleted = false
                        }
                    })
                }
            },
            callNumberInit(item) {
                let contactInfo = JSON.parse(item.borrower_info.contact_email);
                this.contact_number_s = contactInfo['phone'];
                this.contact_number_e = item.borrower_info.borrower_name;

                let contactInfoEx = JSON.parse(item.contact_info.contact_email);
                this.contact_ex_number_s = contactInfoEx['phone'];
                this.contact_ex_number_e = item.contact_info.contact;
                this.contact_is_borrower = item.contact_info.is_borrower;

                this.openCallNumber = true;
            },
            initOrder(order) {
                this.pages.pageData = order;
                this.orderData = order.data;
                this.initTable();
            },
            initTable() {
                this.table.header.map((ele) => {
                    let item = ele.split("@");
                    let checkDisable = this.table.disableHeader.find((ele) => ele.key == item[1]);
                    if (!checkDisable) {
                        this.table.disableHeader.push({
                            title: item[0],
                            key: item[1]
                        });
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
                let addrUrl = "";
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
                    addrUrl += ele.property_info.formatedAddress + "/";
                });
                this.latLng = getLatLng;
                let url = "https://www.google.co.in/maps/dir/"+addrUrl+"?hl=en";
                // this.openMap = true;
                window.open(url);
            },
            closeCurrentMap(event) {
                this.openMap = false;
            },
            searchData: _.debounce(function (event) {
                this.pages.filterType = null;
                this.loadPage(this.pages.acitvePage, event.target.value);
            }, 300),

            loadPage(acitvePage = null) {
                this.pages.acitvePage = acitvePage;
                this.gLoad = true;
                this.$boston.post('search/call/order?page=' + this.pages.acitvePage, { 'filterType': this.pages.filterType, data: this.pages.searchModel, paginate: this.pages.paginate, dateRange: this.dateRange }).then((res) => {
                    this.selectedItems = [];
                    this.gLoad = false;
                    if (this.pages.filterType != 'daterange') {
                        this.dateRange.search = false;
                        this.dateRange.start = null;
                        this.dateRange.end = null;
                    }
                    this.pages.pageData = res;
                    this.orderData = res.data;
                }).catch((err) => {
                    this.gLoad = false;
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
                this.loadPage(this.pages.acitvePage);
                this.$bvModal.hide('dateRange')
            },
            checkColumnActive(val) {
                let getHeader = (this.table.header);
                let findActive = false;
                for (let index in getHeader) {
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
                let getIndex = getHeader.find((ele) => {
                    let key = ele.split("@");
                    if (val.key == key[1]) {
                        return true;
                    }
                });
                if (!getIndex) {
                    let slicePoint = this.table.header.length - 1;
                    if (val.key == 'sl') {
                        slicePoint = 0;
                    } else if (val.key == 'action') {
                        slicePoint = this.table.header.length;
                    }
                    this.table.header.splice(slicePoint, 0,
                        val.title + '@' + val.key + '@left@left'
                    );
                } else {
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
            getQuickView(item) {
                this.$bvModal.show('quick-view')
                this.$refs.quickViewComponent.setQuickViewData(item)
            },
            getScheduleData(item) {
                this.$refs.callScheduleComponent.setOrderId(item.id)
                if (item.inspection) {
                    this.$refs.callReScheduleComponent.setScheduleData(item.inspection)
                    this.$refs.callReScheduleComponent.setOrderStatus(item.status)
                }
                item.status == 0 ? this.$bvModal.show('schedule') : this.$bvModal.show('re-schedule')
            },
            getSendMessage(item) {
                this.$bvModal.show('send-message')
                this.$refs.sendMessageComponent.setContactData(item.contact_info,item.property_info,item.lender)
            },
            filterByTab(item) {
                this.pages.filterType = item;
                if (item != 'daterange') {
                    this.dateRange.search = false;
                    this.dateRange.start = null;
                    this.dateRange.end = null;
                    this.loadPage();
                }
            },
        },
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
        max-height: 500px;
        right: 0;
        top: 40px;
        border: 1px solid rgba(25, 183, 162, 0.5);
        box-shadow: 0px 4px 12px 4px rgba(0, 0, 0, 0.08);
        border-radius: 8px;
        overflow: hidden;
        bottom: auto;
        padding: 20px;
        z-index: 999;
        overflow-y: auto;
    }

    .column-list .col-item {
        padding: 0px 0px 0px 40px;
        cursor: pointer;
        position: relative;
        margin-bottom: 10px;
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
        cursor: hover;
    }
.full_addr {
    height: 44px;
    overflow: hidden;
    text-overflow: ellipsis;
    cursor: pointer;
    transition: all 200ms ease-in-out;
}
.full_addr:hover {
    display: table;
    height: auto;
    overflow: auto;
    transition: all 200ms ease-in-out;
}
</style>
