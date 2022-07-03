<template>
    <div id="boston-cal-lists">
        <div class="calls bg-platinum dashboard-space">
            <div class="bg-white pd-32">
                <div class="calls__menu d-flex flex-wrap">
                    <div class="left chart-box-header-btn d-flex flex-wrap me-3">
                        <button class="calls-btn h-40 d-flex align-items-center mb-2 active">All <span class="ms-2">
                                (88)</span></button>
                        <button class="calls-btn h-40 d-flex align-items-center mb-2">To be Schedule <span class="ms-2">
                                (88)</span></button>
                        <button class="calls-btn h-40 d-flex align-items-center mb-2">Schedule <span class="ms-2">
                                (88)</span></button>
                        <button class="calls-btn h-40 d-flex align-items-center mb-2">Todays Call <span class="ms-2">
                                (88)</span></button>
                        <button class="calls-btn h-40 d-flex align-items-center mb-2">Completed <span class="ms-2">
                                (88)</span></button>
                        <button @click="$bvModal.show('dateRange')"
                            class="calls-btn h-40 d-flex align-items-center mb-2">Date Rage</button>
                    </div>
                    <div class="right d-flex">
                        <a @click="goToMap()" href="javascript:;"
                            class="primary-bg h-40 d-flex align-items-center mb-2 px-2 br-4 text-white me-3">Map
                            selected orders <span class="ms-2">({{ selectedItems.length }})</span></a>
                        <div class=" d-flex calls-search">
                            <input type="text" v-model="pages.searchModel" @input="searchData($event)"
                                class="mb-3 px-3 bdr-1 br-4 gray-border calls-search-input h-40"
                                placeholder="Search...">
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
                <div class="call-list">
                    <div class="call-list-header">
                        <span class="call-list-item ">SL</span>
                        <span class="call-list-item ">Order no</span>
                        <span class="call-list-item ">Client name</span>
                        <span class="call-list-item ">Property address</span>
                        <span class="call-list-item ">Inspector</span>
                        <span class="call-list-item ">Appraiser</span>
                        <span class="call-list-item ">Last call</span>
                        <span class="call-list-item ">Insp. date & time</span>
                        <span class="call-list-item ">Status</span>
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
                        </span>
                    </div>
                    <div class="call-item" v-for="item, callIndex in orderData" :key="callIndex">
                        <div class="call-list-body">
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
                            <span class="call-list-item">{{ item.client_order_no }}</span>
                            <span class="call-list-item">
                                <p class="mb-0 fw-bold text-ellips">{{ item.amc ? item.amc.name : '-' }}</p>
                            </span>
                            <span class="call-list-item">
                                <p class="mb-0 text-ellips">{{ item.property_info.search_address }}</p>
                            </span>
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
                            <span class="call-list-item">
                                <p class="mb-0 scheduled">{{ item.order_status }}</p>
                            </span>
                            <span class="call-list-item">
                                <a href="javascript:;" class="icon-list" data-bs-placement="bottom" title="Details"><span
                                        class="icon-eye text-blue-eye fs-20"><span class="path1"></span><span
                                            class="path2"></span></span></a>
                                <a href="javascript:;" @click.prevent="getQuickView(callIndex)" title="Quick view"
                                    class="icon-list quick-view-icon"><span class="icon-note text-purple fs-20"><span
                                            class="path1"></span><span class="path2"></span><span
                                            class="path3"></span><span class="path4"></span></span></a>
                                <a @click.prevent="getCallSummary(item.call_log, item.id)" href="javascript:;" class="icon-list" data-bs-placement="bottom" title="Call log" data-bs-toggle="modal"
                                   data-bs-target="#callLogModal"><span
                                        class="icon-messages2 primary-text fs-20"><span class="path1"></span><span
                                            class="path2"></span><span class="path3"></span><span
                                            class="path4"></span><span class="path5"></span></span></a>
                                <a @click.prevent="getScheduleData(callIndex)" href="javascript:;" class="icon-list" data-bs-placement="bottom" title="Schedule"><span
                                        class="icon-calendar text-brown fs-20"><span class="path1"></span><span
                                            class="path2"></span><span class="path3"></span><span
                                            class="path4"></span><span class="path5"></span><span
                                            class="path6"></span><span class="path7"></span><span
                                            class="path8"></span></span></a>
                                <a href="javascript:;" @click="getSendMessage(callIndex)" class="icon-list" data-bs-placement="bottom" title="Email & SMS"> <span
                                        class="icon-messages text-yellow-msg  fs-20"><span class="path1"></span><span
                                            class="path2"></span><span class="path3"></span></span></a>
                                <a href="javascript:;" class="icon-list"><span class="icon-call text-light-red fs-20"><span
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
                                    <a href="javascript:;">
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
                                    <a href="javascript:;">
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
                            <div class="item solved">
                                <span class="call-badge">Solved</span>
                                <p class="text-gray text-end fs-12">Today 12:10am</p>
                                <p class="fs-14 mgt-12 mgb-12">He made payment but didnt get confirmation yet</p>
                                <div class="d-flex justify-content-between">
                                    <p class="mb-0 fs-14"><span class="text-gray">Assigned to :</span> <b>Technical
                                            team</b></p>
                                    <a href="javascript:;">
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
                            <a href="javascript:;" class="item more-item">
                                <p class="text-center mb-1 text-white">10</p>
                                <p class="text-center text-white mb-0">More</p>
                            </a>
                        </div>
                    </div>
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
        <Map v-if="openMap" :latLng="latLng" @closeMap="closeCurrentMap($event)" />
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


        <quick-view ref="quickViewComponent"></quick-view>
        <Map v-if="openMap" :latLng="latLng" />
        <call-schedule ref="callScheduleComponent" :appraisers="appraisers"></call-schedule>
        <call-re-schedule ref="callReScheduleComponent" :appraisers="appraisers"></call-re-schedule>
        <send-message ref="sendMessageComponent"></send-message>

        <div class="modal fade schedule-modal call-log-modal" id="callLogModal" tabindex="-1" aria-labelledby="callLogModalLabel" aria-hidden="true">
            <div class="modal-dialog h-100">
                <div class="modal-content ">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="modal-body h-100 overflow-auto">
                        <p class="mgb-22 fs-20 text-600">Call summary</p>
                        <div class="call-summary-item" v-for="(log, logIndex) in callLog.items" :key="logIndex">
                            <div class="top d-flex align-items-center">
                                <div v-if="log.caller.media.length">
                                    <img :src="log.caller.media[0].original_url" alt=" profile photo boston" class="img-fluid">
                                </div>
                                <div v-else>
                                    <img src="/img/user.png" alt=" profile photo boston" class="img-fluid">
                                </div>
                                <div class="ms-3">
                                    <p class="fw-bold mb-1">{{ log.caller.name }}</p>
                                    <p class="text-gray fs-12 mb-0">{{ log.created_at | momentTime}}</p>
                                </div>
                            </div>
                            <p class="message">{{ log.message }}</p>
                        </div>
                        <div class="update-log" v-if="callLog.notCompleted">
                                <div class="group" :class="{ 'invalid-form' : callLog.error == true }">
                                    <label for="" class="d-block mb-2 dashboard-label">Message</label>
                                    <textarea @keyup="callLog.error = false" v-model="callLog.message" class="dashboard-input w-100" style="min-height: 100px"></textarea>
                                    <span v-if="callLog.error" class="error-message">The Message field is required</span>
                                </div>
                            <div class="checkbox-group mt-2">
                                <input type="checkbox" class="checkbox-input" v-model="callLog.status">
                                <label for="" class="checkbox-label">Call completed</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" v-if="callLog.notCompleted">
                        <button type="button" class="button button-primary px-5" @click="addCallLog()">Post</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Table from "../../src/Table.vue"
    import Map from "./map.vue"

    export default {
        name: "call-lists",
        props: ['order','appraisers'],
        components: {
            Map,
            Table
        },
        data: () => ({
            callLog: {
                error: false,
                notCompleted: true,
                items: [],
                message: '',
                status: '',
                orderId: '',
            },
            pages: {
                pageData: [],
                acitvePage: 1,
                searchModel: null,
                paginate: 10,
                perPages: [10, 15, 20, 25, 30, 40, 50, 60, 100]
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
            table: {
                disableHeader: [],
                header: [
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
        }),
        created() {
            this.initOrder(this.order);
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
            addCallLog() {
                this.callLog.error = false
                if(this.callLog.message == ''){
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
                        if (res.data.error) {
                            console.log(res.data.message)
                        } else {
                            this.callLog.message = ''
                            this.callLog.status = ''
                            this.getCallSummary(res.data.data, this.callLog.orderId)

                        }
                    }).catch(err => {
                    console.log(err)
                })
            },
            getCallSummary(value, id) {
                console.log(value)
                this.callLog.notCompleted = true
                this.callLog.items = []
                this.callLog.orderId = id
                if(value.length){
                    this.callLog.items = value
                    this.callLog.items.forEach((log, index) => {
                        if(log.status){
                            this.callLog.notCompleted = false
                        }
                    })
                }
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
            searchData: _.debounce(function (event) {
                this.loadPage(this.pages.acitvePage, event.target.value);
            }, 300),

            loadPage(acitvePage = null) {
                this.pages.acitvePage = acitvePage;
                this.$boston.post('search/call/order?page=' + this.pages.acitvePage, { data: this.pages.searchModel, paginate: this.pages.paginate, dateRange: this.dateRange }).then((res) => {
                    this.selectedItems = [];
                    this.dateRange.search = false;
                    this.pages.pageData = res;
                    this.orderData = res.data;
                }).catch((err) => {
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
                    let slicePoint = 9;
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
            getQuickView(index) {
                this.$bvModal.show('quick-view')
                this.$refs.quickViewComponent.setQuickViewData(this.orderData[index])
            },
            getScheduleData(index) {
                this.$refs.callScheduleComponent.setOrderId(this.orderData[index].id)
                this.$refs.callReScheduleComponent.setOrderId(this.orderData[index].id)
                this.$refs.callReScheduleComponent.setScheduleData(this.orderData[index].inspection)
                this.$refs.callReScheduleComponent.setOrderStatus(this.orderData[index].status)
                this.orderData[index].status == 0 ? this.$bvModal.show('schedule') : this.$bvModal.show('re-schedule')
            },
            getSendMessage(index){
                this.$bvModal.show('send-message')
            }
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
        cursor: hover;
    }
</style>
