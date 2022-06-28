<template>
    <div id="boston-cal-lists">
        <div class="calls bg-platinum dashboard-space">
            <div class="bg-white pd-32">
                <div class="calls__menu d-flex flex-wrap">
                    <div class="left chart-box-header-btn d-flex flex-wrap me-3">
                        <button class="calls-btn h-40 d-flex align-items-center mb-2 active">Appraiser <span
                                class="ms-2"> (88)</span></button>
                        <button class="calls-btn h-40 d-flex align-items-center mb-2">Appraiser <span class="ms-2">
                                (88)</span></button>
                        <button class="calls-btn h-40 d-flex align-items-center mb-2">Appraiser <span class="ms-2">
                                (88)</span></button>
                        <button class="calls-btn h-40 d-flex align-items-center mb-2">Appraiser <span class="ms-2">
                                (88)</span></button>
                        <button class="calls-btn h-40 d-flex align-items-center mb-2">Appraiser <span class="ms-2">
                                (88)</span></button>
                    </div>
                    <div class="right d-flex">
                        <a @click="goToMap()" href="javascript:;"
                            class="primary-bg h-40 d-flex align-items-center mb-2 px-2 br-4 text-white me-3">Map
                            selected orders <span class="ms-2">({{ selectedItems.length }})</span></a>
                        <div class=" d-flex calls-search">
                            <input type="text" class="mb-3 px-3 bdr-1 br-4 gray-border calls-search-input h-40"
                                placeholder="Search...">
                            <button class="bg-gray inline-flex-center mb-2 calls-search-btn">
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
                                <a href="#" class="icon-list" data-bs-placement="bottom" title="Schedule"><span
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
                                </div>
                            </div>
                            <div class="item solved">
                                <span class="call-badge">Solved</span>
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
                            <a href="#" class="item more-item">
                                <p class="text-center mb-1 text-white">10</p>
                                <p class="text-center text-white mb-0">More</p>
                            </a>
                        </div>
                        <div class="modal fade quick-view-modal" id="exampleModal" tabindex="-1"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog h-100">
                                <div class="modal-content h-100 p-0">
                                    <div
                                        class="bg-gray pdl-32 pdr-22 d-flex align-items-center justify-content-between h-60 min-h-60 header-modal">
                                        <h5 class="fs-20 fw-bold text-white mb-0" id="exampleModalLabel">Quickview</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body h-100 overflow-auto">
                                        <p class="mb-3 fw-bold">Client info</p>
                                        <div class="modal-item">
                                            <p class="mb-0">AMC name</p>
                                            <span>:</span>
                                            <p class="mb-0 text-600">EStreet Appraisal Management
                                                Company, LLC</p>
                                        </div>
                                        <a href="#" class="primary-text underline text-600 mgb-24 d-inline-block">AMC
                                            requirements</a>
                                        <div class="modal-item">
                                            <p class="mb-0">AMC name</p>
                                            <span>:</span>
                                            <p class="mb-0 text-600">EStreet Appraisal Management
                                                Company, LLC</p>
                                        </div>
                                        <div class="modal-item">
                                            <p class="mb-0">AMC name</p>
                                            <span>:</span>
                                            <p class="mb-0 text-600">EStreet Appraisal Management
                                                Company, LLC</p>
                                        </div>
                                        <a href="#" class="primary-text underline text-600 d-inline-block">Lender
                                            requirements</a>
                                        <div class="mgt-32">
                                            <p class="mb-3 text-600">Property info</p>
                                            <div class="modal-item">
                                                <p class="mb-0">Property address</p>
                                                <span>:</span>
                                                <p class="mb-0 text-600">EStreet Appraisal Management
                                                    Company, LLC</p>
                                            </div>
                                            <div class="modal-item">
                                                <p class="mb-0">Property address</p>
                                                <span>:</span>
                                                <p class="mb-0 text-700 fs-20 primary-text">EStreet Appraisal Management
                                                    Company, LLC</p>
                                            </div>
                                            <div class="modal-item">
                                                <p class="mb-0">Due date</p>
                                                <span>:</span>
                                                <p class="mb-0 text-600">33-33-33</p>
                                            </div>
                                            <div class="modal-item">
                                                <p class="mb-0">Order no</p>
                                                <span>:</span>
                                                <p class="mb-0 text-600">4654765765</p>
                                            </div>
                                            <div class="modal-item">
                                                <p class="mb-0">Order receive date</p>
                                                <span>:</span>
                                                <p class="mb-0 text-600">40-89-32</p>
                                            </div>
                                            <div class="mgt-32">
                                                <p class="mb-3 text-600 ">Contact info</p>
                                                <div class="modal-item">
                                                    <p class="mb-0">Contact name</p>
                                                    <span>:</span>
                                                    <p class="mb-0 text-600">Abid ali ahmede</p>
                                                </div>
                                                <div class="modal-item">
                                                    <p class="mb-0">Phone</p>
                                                    <span>:</span>
                                                    <p class="mb-0 text-600">35465765565</p>
                                                </div>
                                                <div class="modal-item">
                                                    <p class="mb-0">Email</p>
                                                    <span>:</span>
                                                    <p class="mb-0 text-600">exmplll@mail.com</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <p class="text-700 mb-3">Notes</p>
                                            <p class="note-text mb-3 text-700">Lorem ipsum, or lipsum as it is sometimes
                                                known, is dummy text used
                                                in laying out print, graphic or web designs. The passage is attributed
                                                to an unknown</p>
                                            <p class="note-text text-700">Lorem ipsum, or lipsum as it is sometimes
                                                known, is dummy text used
                                                in laying out print, graphic or web designs. The passage is attributed
                                                to an unknown</p>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary">Save changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <Map v-if="openMap" :latLng="latLng" />
    </div>
</template>

<script>
    import Map from "./map.vue"
    export default {
        name: "call-lists",
        props: ['order','appraisers'],
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
        }),
        created() {
            this.initOrder(this.order);
        },
        methods: {
            initOrder(order) {
                this.pageData = order;
                this.orderData = order.data;
                //this.isScheduled = (JSON.parse(this.orderData.workflow_status)).scheduling
                console.log(this.pageData);
                console.log(this.orderData)
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
            }
        },
        watch: {

        }
    }
</script>

<style scoped>
    .cursor-hover {
        cursor: hover;
    }
</style>
